# Contoh Implementasi Multi-Bahasa di View

## 1. Header Navigation (modern-header.blade.php)

### Update Navigation Links
```blade
{{-- Sebelum --}}
<a href="{{ route('home') }}">Home</a>
<a href="{{ route('mountains.list') }}">Explore Mountains</a>
<a href="{{ route('about') }}">About Us</a>
<a href="{{ route('dashboard') }}">Dashboard</a>

{{-- Sesudah --}}
<a href="{{ route('home') }}">{{ __('common.nav.home') }}</a>
<a href="{{ route('mountains.list') }}">{{ __('common.nav.explore_mountains') }}</a>
<a href="{{ route('about') }}">{{ __('common.nav.about_us') }}</a>
<a href="{{ route('dashboard') }}">{{ __('common.nav.dashboard') }}</a>
```

### Update User Menu
```blade
{{-- Sebelum --}}
<span>Profile Settings</span>
<span>My Bookings</span>
<span>Sign Out</span>

{{-- Sesudah --}}
<span>{{ __('common.nav.profile_settings') }}</span>
<span>{{ __('common.nav.my_bookings') }}</span>
<span>{{ __('common.nav.sign_out') }}</span>
```

### Update Guest Actions
```blade
{{-- Sebelum --}}
<a href="{{ route('login') }}">Sign In</a>
<a href="{{ route('register') }}">Get Started</a>

{{-- Sesudah --}}
<a href="{{ route('login') }}">{{ __('common.nav.sign_in') }}</a>
<a href="{{ route('register') }}">{{ __('common.nav.get_started') }}</a>
```

---

## 2. Login Page (auth/login.blade.php)

```blade
{{-- Title --}}
<h2>{{ __('auth.login.welcome_back') }}</h2>
<p>{{ __('auth.login.subtitle') }}</p>

{{-- Form Fields --}}
<label>{{ __('auth.login.email') }}</label>
<input type="email" placeholder="{{ __('auth.login.email') }}">

<label>{{ __('auth.login.password') }}</label>
<input type="password" placeholder="{{ __('auth.login.password') }}">

{{-- Remember Me --}}
<label>
    <input type="checkbox">
    {{ __('auth.login.remember_me') }}
</label>

{{-- Forgot Password Link --}}
<a href="{{ route('password.request') }}">
    {{ __('auth.login.forgot_password') }}
</a>

{{-- Submit Button --}}
<button type="submit">{{ __('auth.login.sign_in') }}</button>

{{-- Social Login --}}
<p>{{ __('auth.login.or_continue_with') }}</p>
<button>{{ __('auth.login.google') }}</button>

{{-- Register Link --}}
<p>
    {{ __('auth.login.no_account') }}
    <a href="{{ route('register') }}">{{ __('auth.login.register_here') }}</a>
</p>
```

---

## 3. Register Page (auth/register.blade.php)

```blade
<h2>{{ __('auth.register.create_account') }}</h2>
<p>{{ __('auth.register.subtitle') }}</p>

<label>{{ __('auth.register.name') }}</label>
<input type="text" placeholder="{{ __('auth.register.name') }}">

<label>{{ __('auth.register.email') }}</label>
<input type="email" placeholder="{{ __('auth.register.email') }}">

<label>{{ __('auth.register.phone') }}</label>
<input type="tel" placeholder="{{ __('auth.register.phone') }}">

<label>{{ __('auth.register.password') }}</label>
<input type="password" placeholder="{{ __('auth.register.password') }}">

<label>{{ __('auth.register.password_confirmation') }}</label>
<input type="password" placeholder="{{ __('auth.register.password_confirmation') }}">

<label>
    <input type="checkbox">
    {{ __('auth.register.agree_terms') }}
</label>

<button type="submit">{{ __('auth.register.create_account_btn') }}</button>

<p>
    {{ __('auth.register.have_account') }}
    <a href="{{ route('login') }}">{{ __('auth.register.login_here') }}</a>
</p>
```

---

## 4. Dashboard (dashboard.blade.php)

```blade
{{-- Welcome Message --}}
<h1>{{ __('dashboard.dashboard.welcome') }}, {{ $user->name }}</h1>

{{-- Active Booking Section --}}
<h2>{{ __('dashboard.dashboard.active_booking') }}</h2>
@if($activeBooking)
    <div>
        <p>{{ __('dashboard.dashboard.check_in_date') }}: {{ $activeBooking->check_in_date }}</p>
        <p>{{ __('dashboard.dashboard.hikers') }}: {{ $activeBooking->number_of_hikers }}</p>
        <a href="#">{{ __('dashboard.dashboard.download_ticket') }}</a>
    </div>
@else
    <p>{{ __('dashboard.dashboard.no_active_booking') }}</p>
@endif

{{-- Recent Bookings --}}
<h2>{{ __('dashboard.dashboard.recent_bookings') }}</h2>
@if($allBookings->count() > 0)
    @foreach($allBookings as $booking)
        <div>
            <p>{{ $booking->mountain->name }}</p>
            <span>{{ __('common.status.' . $booking->status) }}</span>
        </div>
    @endforeach
    <a href="{{ route('bookings.index') }}">{{ __('dashboard.dashboard.view_all') }}</a>
@else
    <p>{{ __('dashboard.dashboard.no_bookings') }}</p>
@endif

{{-- Notifications --}}
<h2>{{ __('dashboard.notifications.title') }}</h2>
@if($notifications->count() > 0)
    <button>{{ __('dashboard.notifications.delete_all') }}</button>
    @foreach($notifications as $notification)
        <div>
            <p>{{ $notification->message }}</p>
        </div>
    @endforeach>
@else
    <p>{{ __('dashboard.notifications.no_notifications') }}</p>
@endif
```

---

## 5. Booking Form (livewire/booking-form.blade.php)

```blade
<h2>{{ __('booking.form.title') }}</h2>

{{-- Mountain Selection --}}
<label>{{ __('booking.form.mountain') }}</label>
<select>
    <option>{{ __('booking.form.select_mountain') }}</option>
</select>

{{-- Trail Route --}}
<label>{{ __('booking.form.trail_route') }}</label>
<select>
    <option>{{ __('booking.form.select_route') }}</option>
</select>

{{-- Check-in Date --}}
<label>{{ __('booking.form.check_in_date') }}</label>
<input type="date">

{{-- Number of Hikers --}}
<label>{{ __('booking.form.number_of_hikers') }}</label>
<input type="number">

{{-- Hiker Details --}}
<h3>{{ __('booking.form.hiker_details') }}</h3>
<label>{{ __('booking.form.full_name') }}</label>
<input type="text">

<label>{{ __('booking.form.id_number') }}</label>
<input type="text">

<label>{{ __('booking.form.phone') }}</label>
<input type="tel">

{{-- Emergency Contact --}}
<h3>{{ __('booking.form.emergency_contact') }}</h3>
<label>{{ __('booking.form.emergency_name') }}</label>
<input type="text">

<label>{{ __('booking.form.emergency_phone') }}</label>
<input type="tel">

{{-- Voucher --}}
<label>{{ __('booking.form.voucher_code') }}</label>
<input type="text">
<button>{{ __('booking.form.apply_voucher') }}</button>

{{-- Price Summary --}}
<div>
    <p>{{ __('booking.form.price_per_person') }}: Rp {{ number_format($price) }}</p>
    <p>{{ __('booking.form.subtotal') }}: Rp {{ number_format($subtotal) }}</p>
    <p>{{ __('booking.form.discount') }}: Rp {{ number_format($discount) }}</p>
    <p><strong>{{ __('booking.form.total_payment') }}: Rp {{ number_format($total) }}</strong></p>
</div>

{{-- Terms --}}
<label>
    <input type="checkbox">
    {{ __('booking.form.agree_terms') }}
</label>

{{-- Submit --}}
<button type="submit">{{ __('booking.form.submit_booking') }}</button>
```

---

## 6. Booking List (bookings/index.blade.php)

```blade
<h1>{{ __('booking.list.title') }}</h1>

@if($bookings->count() > 0)
    <table>
        <thead>
            <tr>
                <th>{{ __('booking.list.booking_code') }}</th>
                <th>{{ __('booking.list.mountain') }}</th>
                <th>{{ __('booking.list.check_in_date') }}</th>
                <th>{{ __('booking.list.hikers') }}</th>
                <th>{{ __('booking.list.total') }}</th>
                <th>{{ __('booking.list.status') }}</th>
                <th>{{ __('booking.list.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->mountain->name }}</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>{{ $booking->number_of_hikers }}</td>
                    <td>Rp {{ number_format($booking->total_price) }}</td>
                    <td>{{ __('booking.status.' . $booking->status) }}</td>
                    <td>
                        @if($booking->status === 'pending')
                            <a href="{{ route('bookings.pay', $booking) }}">
                                {{ __('booking.list.pay') }}
                            </a>
                        @else
                            <a href="#">{{ __('booking.list.view') }}</a>
                            <a href="{{ route('bookings.ticket.download', $booking) }}">
                                {{ __('booking.list.download_ticket') }}
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div>
        <p>{{ __('booking.list.no_bookings') }}</p>
        <a href="{{ route('mountains.list') }}">{{ __('booking.list.start_booking') }}</a>
    </div>
@endif
```

---

## 7. Admin Mountains (admin/mountains/index.blade.php)

```blade
<h1>{{ __('admin.mountains.title') }}</h1>

<a href="{{ route('admin.mountains.create') }}">
    {{ __('admin.mountains.add_mountain') }}
</a>

<table>
    <thead>
        <tr>
            <th>{{ __('admin.mountains.mountain_name') }}</th>
            <th>{{ __('admin.mountains.location') }}</th>
            <th>{{ __('admin.mountains.height') }}</th>
            <th>{{ __('admin.mountains.difficulty') }}</th>
            <th>{{ __('admin.mountains.price') }}</th>
            <th>{{ __('admin.mountains.status') }}</th>
            <th>{{ __('admin.mountains.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mountains as $mountain)
            <tr>
                <td>{{ $mountain->name }}</td>
                <td>{{ $mountain->location }}</td>
                <td>{{ $mountain->height }} MDPL</td>
                <td>{{ $mountain->difficulty }}</td>
                <td>Rp {{ number_format($mountain->base_price) }}</td>
                <td>{{ __('common.status.' . $mountain->status) }}</td>
                <td>
                    <a href="{{ route('admin.mountains.edit', $mountain) }}">
                        {{ __('common.btn.edit') }}
                    </a>
                    <form method="POST" action="{{ route('admin.mountains.destroy', $mountain) }}">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('{{ __('admin.mountains.delete_confirm') }}')">
                            {{ __('common.btn.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

## Tips Implementasi

1. **Gunakan Helper `__()`** untuk semua teks yang ditampilkan ke user
2. **Jangan hardcode teks** dalam bahasa apapun
3. **Konsisten dengan key naming** - gunakan struktur yang jelas
4. **Test kedua bahasa** setelah implementasi
5. **Update terjemahan** jika ada perubahan teks

---

## Checklist Update View

- [ ] Header & Navigation
- [ ] Footer
- [ ] Login Page
- [ ] Register Page
- [ ] Forgot Password Page
- [ ] Dashboard
- [ ] Booking Form
- [ ] Booking List
- [ ] Payment Page
- [ ] Profile Page
- [ ] Mountains List
- [ ] Mountain Detail
- [ ] About Page
- [ ] Admin Panel
- [ ] Validator Panel
- [ ] Email Templates
- [ ] Error Pages (404, 500, dll)
