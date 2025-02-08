<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit Arrival Product') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10">
        <form action="{{ route('arrival.update', $arrival->id) }}" method="POST"
            class="bg-[#e9e8e4] shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PATCH')

            <!-- Arrival Date -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="arrivalDate">
                    Arrival Date
                </label>
                <input type="date" id="arrivalDate" name="arrivalDate"
                    value="{{ old('arrivalDate', $arrival->arrivalDate ? \Carbon\Carbon::parse($arrival->arrivalDate)->format('Y-m-d') : '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">

            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                    Quantity
                </label>
                <input type="number" id="quantity" name="quantity" value="{{ $arrival->quantity }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                @error('quantity')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Size Selection -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="size_id">
                    Size
                </label>
                <select id="size_id" name="size_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}" {{ $size->id == $arrival->size_id ? 'selected' : '' }}>
                            {{ $size->size }}
                        </option>
                    @endforeach
                </select>
                @error('size_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-[#cdc3b0] hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Update Arrival Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
