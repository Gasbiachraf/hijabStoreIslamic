<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="flex flex-col justify-center items-center p-10">
        <div class="w-[90%] p-5 bg-white shadow-md rounded-lg">
            @if (count($inventories) < 1)
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-28">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <p>
                        There is No products
                    </p>
                </div>
            @else
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Products</h3>
                    <a href="{{ route('cart.index') }}"
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-600">
                        Go to Cart (<span id="selected-count">{{ count($selectedProductIds) }}</span>)
                    </a>


                </div>
                {{-- {{ dump($selectedProductIds) }} --}}
                <div class="overflow-x-auto">
                    <form id="product-form" method="POST" action="{{ route('cart.store') }}">
                        @csrf
                        <table class="w-full text-sm text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Image</th>
                                    <th class="px-6 py-3">Title</th>
                                    {{-- <th class="px-6 py-3">Category</th> --}}
                                    <th class="px-6 py-3">Price</th>
                                    <th class="px-6 py-3">Stock Info</th>
                                    <th class="px-6 py-3">Total Stock</th>
                                    <th class="px-6 py-3">Select Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-3">
                                            <img src="{{ asset('storage/images/' . $inventory->variants->first()->images->first()->path) }}"
                                                alt="Product Image" class="w-16 h-16 object-cover rounded-md">
                                        </td>
                                        <td class="px-6 py-3"><a
                                                href="product/{{ $inventory->product->id }}">{{ $inventory->product->name->en }}</a>
                                        </td>
                                        {{-- <td class="px-6 py-3">{{ $inventory->product->category->name }}</td> --}}
                                        <td class="px-6 py-3">${{ $inventory->postPrice }}</td>
                                        <td class="px-6 py-3">
                                            @php
                                                // dd();
                                                $sizesByColor = $inventory->variants->mapWithKeys(function ($variant) {
                                                    return [
                                                        $variant->color => $variant->sizes->mapWithKeys(
                                                            fn($size) => [$size->size => $size->quantity],
                                                        ),
                                                    ];
                                                });
                                            @endphp
                                            @foreach ($sizesByColor as $color => $sizes)
                                                <div class="flex  gap-1 mb-2 text-center">
                                                    <!-- Display Color -->
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-4 h-4 rounded-full border border-gray-300"
                                                            style="background-color: {{ $color }};">
                                                        </div>
                                                        {{-- <span class="font-semibold capitalize">{{ $color }}</span> --}}
                                                    </div>

                                                    <!-- Display Sizes and Quantities -->
                                                    <div class="ml-6">
                                                        @foreach ($sizes as $size => $quantity)
                                                            <span class="text-sm">
                                                                {{ $size }}
                                                                (<strong>{{ $quantity }}</strong>)
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>


                                        <td class="px-6 py-3 text-center">
                                            {{ $inventory->variants->reduce(function ($carry, $variant) {
                                                return $carry + $variant->sizes->sum('quantity');
                                            }, 0) }}
                                        <td class="px-6 py-3 text-center">
                                            <div class="relative flex flex-col gap-5">
                                                @foreach ($sizesByColor as $color => $sizes)
                                                    <!-- Dropdown Button -->
                                                    <button type="button" data-product-id="{{ $inventory->id }}"
                                                        data-color="{{ $color }}"
                                                        class="bg-purple-500 text-white px-3 py-2 rounded-lg shadow hover:bg-purple-600 flex items-center gap-2 w-full"
                                                        onclick="toggleDropdown(this)">
                                                        <div class="w-4 h-4 rounded-full border border-gray-300"
                                                            style="background-color: {{ $color }};"></div>
                                                        <span>Select Size</span>
                                                    </button>
                                                    <!-- Dropdown Content -->
                                                    <div
                                                        class="hidden absolute top-5 left-0 bg-white border rounded-lg shadow-md mt-2 z-10 dropdown-content w-full">
                                                        @foreach ($sizes as $size => $quantity)
                                                            <div class="p-2 hover:bg-gray-100 cursor-pointer"
                                                                data-product-id="{{ $inventory->product->id }}"
                                                                data-color="{{ $color }}"
                                                                data-size="{{ $size }}"
                                                                onclick="saveSelection(this.dataset.productId, this.dataset.color, this.dataset.size)">
                                                                <span class="text-sm">{{ $size }}
                                                                    (<strong>{{ $quantity }}</strong>)
                                                                </span>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            @endif

        </div>
    </div>


    <script>
        function saveSelection(productId, color, size) {
            fetch('/cart/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        color: color,
                        size: size,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count dynamically
                        const selectedCountElement = document.getElementById('selected-count');
                        const currentCount = parseInt(selectedCountElement.textContent);
                        selectedCountElement.textContent = currentCount + 1;

                        // Highlight selected size
                        const button = document.querySelector(
                            `button[data-product-id="${productId}"][data-color="${color}"]`);
                        const dropdown = button.nextElementSibling;
                        dropdown.querySelectorAll('.p-2').forEach(item => item.classList.remove('bg-green-500'));
                        dropdown.querySelector(`[data-size="${size}"]`).classList.add('bg-green-500');

                        // Close dropdown
                        dropdown.classList.add('hidden');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }




        function toggleDropdown(button) {

            const dropdown = button.nextElementSibling;

            // Close all other dropdowns
            const allDropdowns = document.querySelectorAll('.dropdown-content');
            allDropdowns.forEach(function(dropdownItem) {
                if (dropdownItem !== dropdown) {
                    dropdownItem.classList.add('hidden');
                }
            });

            // Toggle the visibility of the clicked dropdown
            dropdown.classList.toggle('hidden');

            // Close dropdown when clicking outside
            document.addEventListener('click', function handleClickOutside(event) {
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                    document.removeEventListener('click', handleClickOutside);
                }
            });
        }
    </script>
</x-app-layout>
