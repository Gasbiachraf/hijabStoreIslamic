<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center w-full">
        <div class="w-full bg-white shadow-md rounded-lg p-6">

            <!-- Add Client Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('clients.create') }}"
                    class="inline-flex items-center bg-blue-500 text-white px-5 py-3 rounded-lg shadow-md transition hover:bg-blue-600">
                    ➕ Add Client
                </a>
            </div>

            <!-- Search Inputs (JS filters) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <input type="text" id="search-name" placeholder="Search Name" 
                    class="p-2 border rounded-lg" oninput="filterTable()">
                <input type="text" id="search-gsm" placeholder="Search GSM" 
                    class="p-2 border rounded-lg" oninput="filterTable()">
                <input type="text" id="search-email" placeholder="Search Email" 
                    class="p-2 border rounded-lg" oninput="filterTable()">
                <input type="text" id="search-address" placeholder="Search Address" 
                    class="p-2 border rounded-lg" oninput="filterTable()">
            </div>

            <!-- Clients Table -->
            <div class="relative overflow-x-auto shadow-sm rounded-lg">
                <table class="w-full text-sm text-left text-gray-700 whitespace-nowrap" id="clients-table">
                    <thead class="text-xs uppercase bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">GSM</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Historique</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="border-b even:bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-4 py-3">{{ $client->id }}</td>
                                <td class="px-4 py-3 name">{{ $client->name }}</td>
                                <td class="px-4 py-3 gsm">{{ $client->GSM }}</td>
                                <td class="px-4 py-3 address">{{ $client->adress }}</td>
                                <td class="px-4 py-3 email">{{ $client->email }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('clients.historique', $client->id) }}" class="text-blue-500 hover:underline">
                                        📜 View Historique
                                    </a>
                                </td>
                                <td class="px-4 py-3 flex justify-center space-x-2">
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-600">
                                        ✏️ Edit
                                    </a>
                                    @if (auth()->user()->role === 'admin')
                                        <form action="{{ route('clients.delete', $client->id) }}" method="POST"
                                            >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded-lg shadow hover:bg-red-700">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function filterTable() {
            const nameFilter = document.getElementById('search-name').value.toLowerCase();
            const gsmFilter = document.getElementById('search-gsm').value.toLowerCase();
            const emailFilter = document.getElementById('search-email').value.toLowerCase();
            const addressFilter = document.getElementById('search-address').value.toLowerCase();

            const rows = document.querySelectorAll('#clients-table tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.name').textContent.toLowerCase();
                const gsm = row.querySelector('.gsm').textContent.toLowerCase();
                const email = row.querySelector('.email').textContent.toLowerCase();
                const address = row.querySelector('.address').textContent.toLowerCase();

                if (name.includes(nameFilter) &&
                    gsm.includes(gsmFilter) &&
                    email.includes(emailFilter) &&
                    address.includes(addressFilter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</x-app-layout>
