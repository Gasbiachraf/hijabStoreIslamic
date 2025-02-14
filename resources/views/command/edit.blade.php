<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Edit Command') }}
        </h2>
    </x-slot>
{{-- <h1></h1> --}}
    <div class="max-w-4xl mx-auto mt-10">
        <form action="{{ route('commandVariants.update', $commandVariant->id) }}" method="POST"
            class="bg-[#e9e8e4] shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <style>
                /* Style for the select box */
                .color-option {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .color-box {
                    width: 14px;
                    height: 14px;
                    border-radius: 50%;
                    border: 1px solid #ccc;
                    display: inline-block;
                }
            </style>
            <!-- Product Variant Dropdown -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="variant_id">
                    Product Variant (Color)
                </label>
                <select id="variant_id" name="variant_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @foreach ($variants as $variant)
                        <option value="{{ $variant->id }}" data-color="{{ $variant->color }}"
                            {{ $variant->id == $commandVariant->variant_id ? 'selected' : '' }}>
                            <span>{{$variant->color}}</span> <!-- Show the name instead of color code -->
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="color-preview" id="colorPreview"
                style="width: 30px; height: 30px; border-radius: 50%; margin-top: 10px;"></div>

            <!-- Quantity Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                    Quantity
                </label>
                <input type="number" id="quantity" name="quantity" value="{{ $commandVariant->quantity }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <!-- Size Dropdown (Will be updated dynamically) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="size">
                    Size
                </label>
                <select id="size" name="size"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->size }}"
                            {{ $size->size == $commandVariant->size ? 'selected' : '' }}>
                            {{ $size->size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-[#cdc3b0] hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Update Command
                </button>
            </div>
        </form>
    </div>


    <script>
        document.getElementById('variant_id').addEventListener('change', function() {
            let variantId = this.value;
            let sizeDropdown = document.getElementById('size');

            // Clear the existing options
            sizeDropdown.innerHTML = '';

            // Fetch available sizes for selected variant
            fetch(`/get-sizes/${variantId}`)
                .then(response => response.json())
                .then(data => {
                    data.sizes.forEach(size => {
                        let option = document.createElement('option');
                        option.value = size.size;
                        option.textContent = size.size;
                        sizeDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching sizes:', error));
        });
        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById("variant_id");
            const colorPreview = document.getElementById("colorPreview");

            function updateColorPreview() {
                const selectedOption = select.options[select.selectedIndex];
                const color = selectedOption.dataset.color;
                colorPreview.style.backgroundColor = color;
            }

            select.addEventListener("change", updateColorPreview);
            updateColorPreview(); // Initialize on page load
        });
    </script>
</x-app-layout>
