<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Arrival_Products') }}
        </h2>
    </x-slot>

    <div class="flex flex-col justify-center items-center p-4 md:p-10">
        <div class="w-full overflow-x-auto bg-white rounded-lg shadow-md p-4">

            <!-- Search Inputs -->
            <div class="mb-4 flex gap-4">
                <!-- Search by Product Name -->
                <input type="text" id="productSearch" placeholder="Search by Product Name..."
                    class="border p-2 rounded w-1/2" oninput="filterArrivals()">

                <!-- Search by Arrival Date (Year/Month/Day) -->
                <input type="text" id="dateSearch" placeholder="Search by Date (YYYY, YYYY-MM, YYYY-MM-DD)"
                    class="border p-2 rounded w-1/2" oninput="filterArrivals()">
            </div>

            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Arrival Date</th>
                        <th class="px-6 py-3">Color</th>
                        <th class="px-6 py-3">Size</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="arrivalTableBody">
                    @foreach ($arrivals as $arrival)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $arrival->id }}</td>
                            <td class="px-6 py-3 product-name">
                                {{ $arrival->size->variant->inventory->product->name->en ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-3 arrival-date">
                                {{ $arrival->arrivalDate }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="w-4 h-4 rounded-full border border-gray-300"
                                    style="background-color: {{ $arrival->size->variant->color ?? '#ccc' }};">
                                </div>
                            </td>
                            <td class="px-6 py-3">{{ $arrival->size->size }}</td>
                            <td class="px-6 py-3">{{ $arrival->quantity }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('arrival.edit', $arrival->id) }}"
                                    class="bg-blue-500 px-4 py-2 text-white rounded-lg shadow hover:bg-blue-600">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterArrivals() {
            const searchName = document.getElementById('productSearch').value.toLowerCase();
            const searchDate = document.getElementById('dateSearch').value;  // YYYY, YYYY-MM, YYYY-MM-DD

            const rows = document.querySelectorAll('#arrivalTableBody tr');

            rows.forEach(row => {
                const productName = row.querySelector('.product-name').innerText.toLowerCase();
                const arrivalDate = row.querySelector('.arrival-date').innerText;  // Full date (YYYY-MM-DD)

                const matchesName = productName.includes(searchName);

                let matchesDate = true;  // Default to true if no date filter
                if (searchDate) {
                    // Compare parts (support year, year-month, full date)
                    matchesDate = arrivalDate.startsWith(searchDate);
                }

                if (matchesName && matchesDate) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
