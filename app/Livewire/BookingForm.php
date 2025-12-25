<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mountain;
use App\Models\Booking;
use App\Models\TrailRoute;
use App\Models\Quota; //
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Support\Str;

class BookingForm extends Component
{
    public $mountainId;
    public $mountain;
    public $bookingDate;
    public $totalMembers = 1;
    public $routeId;
    public $members = [];
    public $totalPrice = 0;
    public $discountAmount = 0;
    public $finalPrice = 0;
    public $voucherCode = '';
    public $appliedVoucher = null;
    public $availableRoutes;
    public $quotas;
    public $savedMembers = [];
    public $showMemberSelector = false;

    protected $rules = [
        'bookingDate' => 'required|date|after_or_equal:today',
        'routeId' => 'required|exists:trail_routes,id',
        'totalMembers' => 'required|integer|min:1|max:10',
        'members.*.name' => 'required|string|max:255',
        'members.*.id_number' => 'required|string|max:255',
        'members.*.phone' => 'nullable|string|max:255',
    ];

    protected $listeners = ['routeUpdated' => 'updateRoute'];

    public function mount($mountainId, $quotas)
    {
        $this->mountainId = $mountainId;
        $this->mountain = Mountain::find($mountainId);
        $this->quotas = $quotas;
        $this->availableRoutes = TrailRoute::where('mountain_id', $mountainId)
                                            ->where('status', 'open')
                                            ->pluck('name', 'id');

        $user = Auth::user();
        
        // Load saved members
        $this->savedMembers = $user->savedMembers()->latest()->get()->toArray();
        
        // ALWAYS auto-fill ketua rombongan (member pertama) dengan data user
        $this->members = [
            [
                'name' => $user->name,
                'id_number' => $user->identity_number ?? '',
                'phone' => $user->phone ?? '',
            ]
        ];
        
        if ($this->availableRoutes->isNotEmpty()) {
            $this->routeId = $this->availableRoutes->keys()->first();
        }

        $this->calculatePrice();
    }

    public function updatedTotalMembers()
    {
        // Validasi: pastikan totalMembers dalam range 1-10
        $this->totalMembers = max(1, min(10, (int) $this->totalMembers));
        
        $newCount = $this->totalMembers;
        $currentCount = count($this->members);

        if ($newCount > $currentCount) {
            // Jika user menambah anggota DAN ada saved members, tampilkan popup
            if (count($this->savedMembers) > 0) {
                $this->showMemberSelector = true;
            } else {
                // Jika tidak ada saved members, langsung tambah form kosong
                for ($i = $currentCount; $i < $newCount; $i++) {
                    $this->members[$i] = [
                        'name' => '',
                        'id_number' => '',
                        'phone' => '',
                    ];
                }
            }
        } elseif ($newCount < $currentCount) {
            $this->members = array_slice($this->members, 0, $newCount);
        }
        $this->calculatePrice();
    }

    public function updatedBookingDate($value)
    {
        // Konversi format tanggal dari DD-MM-YYYY ke YYYY-MM-DD untuk database
        if (!empty($value)) {
            // Cek apakah format DD-MM-YYYY
            if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $value, $matches)) {
                // Konversi ke YYYY-MM-DD
                $this->bookingDate = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
            }
        }
    }

    public function selectSavedMember($memberId)
    {
        $member = collect($this->savedMembers)->firstWhere('id', $memberId);
        
        if ($member) {
            // Tambahkan member yang dipilih ke array members
            $this->members[] = [
                'name' => $member['name'],
                'id_number' => $member['id_number'],
                'phone' => $member['phone'],
            ];
            $this->showMemberSelector = false;
            $this->calculatePrice();
        }
    }

    public function skipMemberSelection()
    {
        // Tambah form kosong untuk diisi manual
        $this->members[] = [
            'name' => '',
            'id_number' => '',
            'phone' => '',
        ];
        $this->showMemberSelector = false;
        $this->calculatePrice();
    }

    public function closeMemberSelector()
    {
        $this->showMemberSelector = false;
        // Reset totalMembers ke jumlah members saat ini
        $this->totalMembers = count($this->members);
    }

    public function calculatePrice()
    {
        if (!$this->mountain) {
            return;
        }

        $this->totalPrice = $this->mountain->ticket_price * $this->totalMembers;
        
        $this->discountAmount = 0;
        $this->finalPrice = $this->totalPrice;

        if ($this->appliedVoucher) {
            $this->reapplyVoucherLogic();
        }
    }

    protected function reapplyVoucherLogic()
    {
        if (!$this->appliedVoucher) return;

        $this->discountAmount = $this->appliedVoucher->calculateDiscount($this->totalPrice);
        $this->discountAmount = min($this->discountAmount, $this->totalPrice);
        $this->finalPrice = max(0, $this->totalPrice - $this->discountAmount);
    }

    public function applyVoucher()
    {
        $this->resetErrorBag('voucherCode');
        $this->appliedVoucher = null;
        $this->discountAmount = 0;
        $this->finalPrice = $this->totalPrice;

        if (empty($this->voucherCode)) {
            session()->flash('voucher_info', 'Masukkan kode voucher.');
            return;
        }

        $voucher = Voucher::where('code', $this->voucherCode)->first();

        if (!$voucher) {
            session()->flash('voucher_error', 'Kode voucher tidak valid.');
            return;
        }

        if (!$voucher->isActive()) {
            session()->flash('voucher_error', 'Voucher sudah tidak aktif atau kadaluarsa.');
            return;
        }

        if ($voucher->usage_limit > 0 && $voucher->used_count >= $voucher->usage_limit) { 
            session()->flash('voucher_error', 'Kuota voucher ini sudah habis.');
            return;
        }

        $userUsages = VoucherUsage::where('user_id', Auth::id())
                                    ->where('voucher_id', $voucher->id)
                                    ->count();
                                    
        if ($voucher->user_usage_limit > 0 && $userUsages >= $voucher->user_usage_limit) {
            session()->flash('voucher_error', 'Anda sudah mencapai batas penggunaan voucher ini.');
            return;
        }

        $this->appliedVoucher = $voucher;
        $this->reapplyVoucherLogic();

        session()->flash('voucher_success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        $this->appliedVoucher = null;
        $this->voucherCode = '';
        $this->calculatePrice();
        session()->flash('voucher_info', 'Voucher dihapus.');
    }

    public function updateRoute($routeId)
    {
        $this->routeId = $routeId;
    }

    public function submitBooking()
    {
        if (empty($this->bookingDate)) {
            $this->addError('bookingDate', 'Silakan pilih tanggal pendakian terlebih dahulu.');
            return;
        }

        if ($this->mountain->status === 'closed') {
            session()->flash('error', 'Gunung sedang ditutup sementara.');
            return;
        }

        $selectedRoute = TrailRoute::find($this->routeId);
        if (!$selectedRoute || $selectedRoute->status === 'closed') {
            session()->flash('error', 'Jalur pendakian yang dipilih sedang ditutup.');
            return;
        }

        $this->validate();

        try {
            DB::beginTransaction();

            // --- FIX: LOGIKA PENGURANGAN KUOTA ---
            
            // 1. Ambil data kuota dengan Lock agar tidak bentrok antar user
            $quota = Quota::where('mountain_id', $this->mountainId)
                          ->where('date', $this->bookingDate)
                          ->lockForUpdate()
                          ->first();

            // 2. Validasi Kuota Tersedia
            if (!$quota) {
                throw new \Exception('Kuota untuk tanggal ini belum dibuka.');
            }

            if ($quota->remaining_quota < $this->totalMembers) {
                throw new \Exception('Kuota tidak mencukupi. Sisa kuota: ' . $quota->remaining_quota);
            }

            // 3. Kurangi Kuota
            $quota->remaining_quota -= $this->totalMembers;
            $quota->save();
            
            // --- END FIX ---

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'mountain_id' => $this->mountainId,
                'trail_route_id' => $this->routeId,
                'check_in_date' => $this->bookingDate,
                'check_out_date' => $this->bookingDate,
                'member_count' => $this->totalMembers,
                'total_price' => $this->finalPrice,
                'status' => 'pending', 
                'booking_code' => 'BKN-' . strtoupper(Str::random(8)),
            ]);

            foreach ($this->members as $memberData) {
                $booking->members()->create([
                    'full_name' => $memberData['name'],
                    'identity_number' => $memberData['id_number'],
                ]);
            }

            if ($this->appliedVoucher) {
                VoucherUsage::create([
                    'user_id' => Auth::id(),
                    'voucher_id' => $this->appliedVoucher->id,
                    'booking_id' => $booking->id,
                    'discount_amount' => $this->discountAmount,
                ]);
                $this->appliedVoucher->increment('used_count');
            }

            DB::commit();

            return redirect()->route('bookings.pay', $booking);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal memproses booking: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}