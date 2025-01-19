<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-10">

        <div class="w-[80%] h-[70%] p- relative overflow-x-auto shadow-md sm:rounded-lg">
            <form id="product-form" method="POST" action="{{ route('cart.store') }}">
                @csrf
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center bg-white w-fit px-2 py-1 rounded-lg h-fit">
                        <input type="text" placeholder="Search for a product"
                               class="rounded-lg border-none outline-none focus:ring-0 text-sm w-full">
                    </div>
                    <div class="flex gap-5">
                        {{-- <a href="{{ route('products.create') }}"> --}}
                            <button type="button" class="bg-blue-500 text-white px-3 py-3 rounded-lg shadow hover:bg-blue-600">
                                Add Product
                            </button>
                        {{-- </a> --}}
                        <button type="submit" class="bg-blue-500 text-white px-3 py-3 rounded-lg shadow hover:bg-blue-600">
                            Go to Cart
                        </button>
                    </div>
                </div>
                <table class="w-full text-sm text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3"><input type="checkbox" id="select-all"></th>
                        <th class="px-6 py-3">Image</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Color</th>
                        <th class="px-6 py-3">Size</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($inventories as $inventory)
                        @foreach ($inventory->variants as $variant)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-3 text-center">
                                    <input type="checkbox" name="products[]" value="{{ json_encode([
                                        'id' => $inventory->product->id,
                                    ]) }}" class="row-checkbox">
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <img src="{{ asset('storage/' . $variant->image) }}" width="60px" alt="Product Image">
                                </td>
                                <td class="px-6 py-3 text-center">{{ $inventory->product->name }}</td>
                                <td class="px-6 py-3 text-center">{{ $variant->color }}</td>
                                <td class="px-6 py-3 text-center">{{ $variant->size }}</td>
                                <td class="px-6 py-3 text-center">{{ $variant->quantity }}</td>
                                <td class="px-6 py-3 text-center">{{ $inventory->postPrice }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
            
            selectAllCheckbox.addEventListener('change', function () {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
    
            
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    }
    
                    
                    if (Array.from(rowCheckboxes).every(cb => cb.checked)) {
                        selectAllCheckbox.checked = true;
                    }
                });
            });
        });
    </script>
    
</x-app-layout>
