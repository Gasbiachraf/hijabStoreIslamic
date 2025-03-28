<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div x-data='{showModal: false}' class="container mx-auto my-10 p-4">

        <h1 class="text-3xl font-bold mb-6">Cart</h1>

        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1 bg-white rounded-lg shadow-md p-4">
                <!-- Responsive Table Wrapper -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead>
                            <tr class="text-left border-b text-sm md:text-base">
                                <th class="pb-3">PRODUCTS</th>
                                <th class="pb-3">NAME</th>
                                <th class="pb-3">COLOR</th>
                                <th class="pb-3">SIZE</th>
                                <th class="pb-3">PRICE</th>
                                <th class="pb-3">QUANTITY</th>
                                <th class="pb-3">TOTAL</th>
                                <th class="pb-3">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedProducts as $product)
                                @foreach ($product->inventories as $inventory)
                                    @foreach ($inventory->variants as $variant)
                                        @foreach ($variant->sizes as $size)
                                            <tr class="border-b text-sm md:text-base">
                                                <td>
                                                    <img src="{{ asset('storage/images/' . $variant->images->filter(fn($element) => $element->path)->pluck('path')->first()) }}"
                                                        class="w-10 h-10 md:w-16 md:h-16 object-cover rounded"
                                                        alt="Product Image">
                                                </td>
                                                <td class="py-2">{{ $product->name->ar }}</td>
                                                <td class="py-2">
                                                    <div class="w-4 h-4 rounded-full border border-gray-300"
                                                        style="background-color: {{ $variant->color }};">
                                                    </div>
                                                </td>
                                                <td class="py-2">{{ $size->size }}</td>
                                                <td class="py-2">{{ $inventory->postPrice }}£</td>
                                                <td class="py-2 flex items-center space-x-2">
                                                    <button
                                                        class="px-2 py-1 border border-gray-400 rounded decrement-btn text-xs md:text-sm"
                                                        data-variant-id="{{ $variant->id }}"
                                                        data-size-id="{{ $size->id }}">-</button>
                                                    <span class="quantity text-xs md:text-sm"
                                                        id="quantity-{{ $variant->id }}-{{ $size->id }}">1</span>
                                                    <button
                                                        class="px-2 py-1 border border-gray-400 rounded increment-btn text-xs md:text-sm"
                                                        data-variant-id="{{ $variant->id }}"
                                                        data-size-id="{{ $size->id }}">+</button>
                                                </td>
                                                <td class="py-2"
                                                    id="subtotal-{{ $variant->id }}-{{ $size->id }}">
                                                    {{ $inventory->postPrice }}£
                                                </td>
                                                <td class="py-2 text-center">
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="color"
                                                            value="{{ $variant->color }}">
                                                        <input type="hidden" name="size"
                                                            value="{{ $size->size }}">
                                                        <button type="submit"
                                                            class="text-red-500 text-lg md:text-xl">🗑</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Subtotal -->
                <div class="text-right mt-4 text-sm md:text-base">
                    <span class="font-semibold">Items subtotal: </span>
                    <span id="items-subtotal">691</span>
                </div>

                <!-- Checkout Button -->
                <div class="mt-4 flex justify-center">
                    <button class="w-full md:w-1/3 bg-blue-600 text-white font-bold py-3 rounded-lg text-sm md:text-lg"
                        x-on:click.prevent="$dispatch('open-modal','command-modal')">Proceed to Checkout</button>
                </div>
            </div>
        </div>
        <div class="flex gap-2 items-center">

            {{-- <button class="p-4 bg-green-500 " >
                Open modal
            </button> --}}
            <x-modal name="command-modal" :show="$errors->userDeletion->isNotEmpty()">
                <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                    @csrf

                    <!-- Client Section -->
                    <div class="mb-6">
                        <label for="client" class="block text-lg font-semibold text-gray-800 mb-2">Client</label>
                        <div class="flex items-center space-x-4">
                            <select id="client" name="client_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                                <option value="">Select a client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            <button id="add-client-button" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md"
                                type="button">
                                Add New
                            </button>
                        </div>

                        <div id="new-client-form" class="mt-4 hidden space-y-4">
                            <div class="mb-2">
                                <label for="client-name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="client-name" name="new_client_name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                            </div>
                            <div class="mb-2">
                                <label for="client-phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" id="client-phone" name="new_client_phone"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                            </div>
                            <div class="mb-2">
                                <label for="client-address"
                                    class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="client-address" name="new_client_address"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div class="mb-6">
                        <label for="status" class="block text-lg font-semibold text-gray-800 mb-2">Status</label>
                        <select required id="status" name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                            <option value="sell">Sell</option>
                            <option value="rent">Rent</option>
                        </select>
                    </div>

                    <!-- Delivery Section -->
                    <div class="mb-6">
                        <label for="livraison" class="block text-lg font-semibold text-gray-800 mb-2">Delivery</label>
                        <select id="livraison" name="livraison"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                            <option value="livraison">livraison</option>
                            <option value="in_present">in present</option>
                        </select>
                    </div>

                    <!-- Products Section -->
                    <div id="products-section" class=" overflow-x-auto">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Products</h3>
                        <table class="w-full min-w-[600px] border bg-white rounded-lg shadow-md">
                            <thead>
                                <tr class="bg-gray-100 text-gray-800 text-sm font-semibold">
                                    <th class="py-2">Image</th>
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Color</th>
                                    <th class="py-2">Size</th>
                                    <th class="py-2">Price</th>
                                    <th class="py-2">Quantity</th>
                                    <th class="py-2">Subtotal</th>
                                    <th class="py-2">Sell price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedProducts as $product)
                                    @foreach ($product->inventories as $inventory)
                                        @foreach ($inventory->variants as $variant)
                                            @foreach ($variant->sizes as $size)
                                                <tr class="border-b text-sm">
                                                    <!-- Product Image -->
                                                    <td>
                                                        <img src="{{ asset('storage/images/' . $variant->images->filter(fn($image) => $image->path)->pluck('path')->first()) }}"
                                                            class="w-10 h-10 object-cover rounded" width="60px"
                                                            alt="Product Image">
                                                    </td>
                                                    <!-- Product Name -->
                                                    <td>{{ $product->name->ar }}</td>
                                                    <!-- Product Color -->
                                                    <td>
                                                        <div class="w-4 h-4 rounded-full border border-gray-300"
                                                            style="background-color: {{ $variant->color }};"></div>
                                                    </td>
                                                    <!-- Product Size -->
                                                    <td>{{ $size->size }}</td>
                                                    <!-- Product Price -->
                                                    <td>{{ $inventory->postPrice }}£</td>
                                                    <!-- Quantity Selector -->
                                                    <td data-variant-id="{{ $variant->id }}"
                                                        data-size-id="{{ $size->id }}">
                                                        <span class=" "
                                                            id="modal-quantity2-{{ $variant->id }}-{{ $size->id }}">1</span>
                                                    </td>

                                                    <!-- Subtotal -->
                                                    <td class="py-4"
                                                        id="subtotal2-{{ $variant->id }}-{{ $size->id }}">
                                                        {{ $inventory->postPrice }}£
                                                    </td>
                                                    <!-- Delete Button -->
                                                    <td class="py-4 text-center ">
                                                        <input required type="number" class="rounded-lg"
                                                            name="products[{{ $variant->id }}_{{ $size->id }}][sale_price]">
                                                    </td>
                                                    <!-- Hidden Inputs for Form Submission -->
                                                    <input type="hidden"
                                                        id="input-quantity2-{{ $variant->id }}-{{ $size->id }}"
                                                        name="products[{{ $variant->id }}_{{ $size->id }}][quantity]"
                                                        value="1">
                                                    <input type="hidden"
                                                        name="products[{{ $variant->id }}_{{ $size->id }}][variant_id]"
                                                        value="{{ $variant->id }}">
                                                    {{-- <input type="hidden" name="products[{{ $variant->id }}_{{ $size->id }}][sale_price]" value="{{ $inventory->postPrice }}"> --}}
                                                    <input id="" type="hidden"
                                                        name="products[{{ $variant->id }}_{{ $size->id }}][size]"
                                                        value="{{ $size->size }}">
                                                    <input type="hidden"
                                                        name="products[{{ $variant->id }}_{{ $size->id }}][color]"
                                                        value="{{ $variant->color }}">
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit"
                            class="bg-green-600 text-white px-8 py-3 rounded-lg shadow-lg font-bold text-lg hover:bg-green-700 transition duration-300">Submit</button>
                    </div>
                </form>
            </x-modal>



        </div>

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const decrementButtons = document.querySelectorAll('.decrement-btn');
            const incrementButtons = document.querySelectorAll('.increment-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const itemsSubtotalElement = document.getElementById('items-subtotal');
            // Function to update the total items subtotal
            const updateItemsSubtotal = () => {
                let total = 0;
                const subtotals = document.querySelectorAll('td[id^="subtotal-"]');
                subtotals.forEach(subtotal => {
                    total += parseFloat(subtotal.textContent.replace('£', ''));
                });
                itemsSubtotalElement.textContent = `${total.toFixed(2)}£`;
            };
            // Add event listeners to increment and decrement buttons
            decrementButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const variantId = button.dataset.variantId;
                    const sizeId = button.dataset.sizeId;
                    const quantityElement = document.getElementById(
                        `quantity-${variantId}-${sizeId}`);
                    const quantityElement2 = document.getElementById(
                        `modal-quantity2-${variantId}-${sizeId}`);
                    // console.log(quantityElement2);

                    const subtotalElement = document.getElementById(
                        `subtotal-${variantId}-${sizeId}`);
                    const subtotalElement2 = document.getElementById(
                        `subtotal2-${variantId}-${sizeId}`);
                    const price = parseFloat(button.closest('tr').querySelector('td:nth-child(5)')
                        .innerText.replace('£', ''));

                    let currentQuantity = parseInt(quantityElement.textContent);
                    if (currentQuantity > 1) {
                        currentQuantity--;
                        quantityElement.textContent = currentQuantity;
                        quantityElement2.textContent = currentQuantity;

                        subtotalElement.textContent = `${(currentQuantity * price).toFixed(2)}£`;
                        subtotalElement2.textContent = `${(currentQuantity * price).toFixed(2)}£`;

                        // Update the overall items subtotal
                        updateItemsSubtotal();
                    }
                });
            });

            incrementButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const variantId = button.dataset.variantId;
                    const sizeId = button.dataset.sizeId;
                    const quantityElement = document.getElementById(
                        `quantity-${variantId}-${sizeId}`);
                    const quantityElement2 = document.getElementById(
                        `modal-quantity2-${variantId}-${sizeId}`);
                    const subtotalElement = document.getElementById(
                        `subtotal-${variantId}-${sizeId}`);
                    const subtotalElement2 = document.getElementById(
                        `subtotal2-${variantId}-${sizeId}`);
                    const price = parseFloat(button.closest('tr').querySelector('td:nth-child(5)')
                        .innerText.replace('£', ''));

                    let currentQuantity = parseInt(quantityElement.textContent);
                    currentQuantity++;
                    quantityElement.textContent = currentQuantity;
                    quantityElement2.textContent = currentQuantity;

                    subtotalElement.textContent = `${(currentQuantity * price).toFixed(2)}£`;
                    subtotalElement2.textContent = `${(currentQuantity * price).toFixed(2)}£`;

                    // Update the overall items subtotal
                    updateItemsSubtotal();
                });
            });

            // Add event listeners to delete buttons
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const row = button.closest('tr'); // Get the row to delete
                    row.remove(); // Remove the row from the table

                    // Update the overall items subtotal
                    updateItemsSubtotal();
                });
            });

            // Initialize the subtotal calculation on page load
            updateItemsSubtotal();
        });

        // 
        document.addEventListener('DOMContentLoaded', () => {
            // Elements for summary and totals
            const elements = {
                itemsSubtotal: document.getElementById('items-subtotal'),
                itemsSubtotal2: document.getElementById('items-subtotal2'),
                negotiation: document.getElementById('negotiation'),
                shippingCost: document.getElementById('shipping-cost'),
                subtotal: document.getElementById('subtotal'),
                total: document.getElementById('total')
            };

            // Parse numeric values from strings
            const parseValue = (value) => parseFloat(value.replace(/[^\d.-]/g, '')) || 0;

            // Function to update the items subtotal
            const updateItemsSubtotal = () => {
                let newSubtotal = 0;
                const subtotals = document.querySelectorAll('td[id^="subtotal-"]');
                subtotals.forEach((subtotal) => {
                    newSubtotal += parseValue(subtotal.textContent);
                });

                elements.itemsSubtotal.textContent = `${newSubtotal.toFixed(2)}£`;
                elements.itemsSubtotal2.textContent = `${newSubtotal.toFixed(2)}£`;

                updateSummary(); // Recalculate the summary
            };

            // Function to update the summary values
            const updateSummary = () => {
                const itemsSubtotal = parseValue(elements.itemsSubtotal2.textContent);
                const negotiation = parseValue(elements.negotiation.value || '0');
                const shippingCost = parseValue(elements.shippingCost.textContent);

                const subtotal = itemsSubtotal - negotiation;
                const total = subtotal + shippingCost;

                elements.subtotal.textContent = `${subtotal.toFixed(2)}£`;
                elements.total.textContent = `${total.toFixed(2)}£`;
            };

            // Function to handle quantity changes
            const handleQuantityChange = (variantId, sizeId, isIncrement) => {
                const quantityElement = document.getElementById(`quantity-${variantId}-${sizeId}`);
                const subtotalElement = document.getElementById(`subtotal-${variantId}-${sizeId}`);
                const hiddenInput = document.getElementById(`quantity-input-${variantId}-${sizeId}`);
                const price = parseFloat(
                    document.querySelector(
                        `tr[data-variant-id="${variantId}"][data-size-id="${sizeId}"] td:nth-child(5)`)
                    .textContent.replace('£', '')
                );

                let currentQuantity = parseInt(quantityElement.textContent);

                if (isIncrement) {
                    currentQuantity++;
                } else if (currentQuantity > 1) {
                    currentQuantity--;
                }

                quantityElement.textContent = currentQuantity;
                hiddenInput.value = currentQuantity;
                subtotalElement.textContent = `${(currentQuantity * price).toFixed(2)}£`;

                updateItemsSubtotal(); // Update the overall items subtotal
            };

            // Attach event listeners for increment and decrement buttons
            document.querySelectorAll('.increment-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const variantId = button.dataset.variantId;
                    const sizeId = button.dataset.sizeId;
                    handleQuantityChange(variantId, sizeId, true);
                });
            });

            document.querySelectorAll('.decrement-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const variantId = button.dataset.variantId;
                    const sizeId = button.dataset.sizeId;
                    handleQuantityChange(variantId, sizeId, false);
                });
            });

            // Attach event listeners for delete buttons
            document.querySelectorAll('.delete-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const row = button.closest('tr'); // Get the row to delete
                    row.remove(); // Remove the row from the table
                    updateItemsSubtotal(); // Update the overall items subtotal
                });
            });

            // Listen for changes in negotiation input
            elements.negotiation.addEventListener('input', updateSummary);

            // Initialize the calculations on page load
            updateItemsSubtotal();

            // Toggle new client form visibility
            document.getElementById('add-client-button').addEventListener('click', () => {
                const newClientForm = document.getElementById('new-client-form');
                newClientForm.classList.toggle('hidden');
            });
        });

        // 
        document.getElementById('add-client-button').addEventListener('click', function() {
            const newClientForm = document.getElementById('new-client-form');
            newClientForm.classList.toggle('hidden');
        });


        // 
        document.addEventListener("DOMContentLoaded", function() {
            const clientSelect = document.getElementById("client");
            console.log(clientSelect);
            
            const addClientButton = document.getElementById("add-client-button");
            console.log(addClientButton);
            
            const newClientForm = document.getElementById("new-client-form");
            console.log(newClientForm);
            
            // Ensure one option is selected before submitting
            document.getElementById("checkout-form").addEventListener("submit", function(event) {
                const clientSelected = clientSelect.value !== "";
                console.log(clientSelected);
                
                const newClientFilled = document.getElementById("client-name").value.trim() !== "" &&
                console.log(newClientFilled);
                
                    document.getElementById("client-phone").value.trim() !== "" &&
                    document.getElementById("client-address").value.trim() !== "";

                if (!clientSelected && !newClientFilled) {
                    event.preventDefault(); // Stop form submission
                    alert("Please select an existing client or add a new one.");
                }
            });
        });
    </script>



</x-app-layout>
