<form wire:submit.prevent="save">
    <div class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full ...">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="new_image" class="block text-sm font-medium text-gray-700">Mountain Image</label>
            <input type="file" wire:model="new_image" id="new_image" class="mt-1 block w-full ...">
            @if ($new_image)
                <p class="mt-2 text-sm text-gray-500">Image Preview:</p>
                <img src="{{ $new_image->temporaryUrl() }}" class="mt-2 h-32 w-auto">
            @elseif ($image_url)
                <p class="mt-2 text-sm text-gray-500">Current Image:</p>
                <img src="{{ asset('storage/' . $image_url) }}" class="mt-2 h-32 w-auto">
            @endif
            @error('new_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <hr>

        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Jalur Pendakian</h3>
            @foreach ($jalurs as $index => $jalur)
                <div class="flex items-center space-x-2 mb-2">
                    <input type="text" wire:model="jalurs.{{ $index }}" class="flex-grow mt-1 block w-full ..." placeholder="Nama Jalur #{{ $index + 1 }}">
                    <button type="button" wire:click="removeJalur({{ $index }})" class="bg-red-500 text-white py-2 px-3 rounded-md hover:bg-red-600">&times;</button>
                </div>
                @error('jalurs.'.$index) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            @endforeach
            <button type="button" wire:click="addJalur" class="mt-2 text-sm bg-gray-200 py-1 px-3 rounded hover:bg-gray-300">+ Tambah Jalur</button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Save Mountain
            </button>
        </div>
    </div>
</form>