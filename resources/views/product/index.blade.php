<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Products') }}
        </h2>
        <div>
            <a href="/addproduct">
                <button class="bg-gamma text-white rounded  px-4 py-2">Add Product</button>
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col justify-center items-center p-1">
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
                <div class="flex justify-between items-center mb-4 gap-2">
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
                                    <th class="px-6 py-3">Actions</th>
                                    <th class="px-6 py-3">Restock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-3">
                                            <img src="{{ asset('storage/images/' . $inventory->variants->first()->images->first()->path) }}"
                                                alt="Product Image" class="w-16 h-16 object-cover rounded-md">
                                        </td>
                                        <td class="px-6 py-3">{{ $inventory->product->name->en }}
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
                                        </td>
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
                                        <td class="flex justify-center items-center py-[5vh]">
                                            <a class="" href="product/{{ $inventory->product->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-[6vw]">
                                            <a href="/restock/variant/{{ $inventory->product->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                                                </svg>
                                            </a>
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
