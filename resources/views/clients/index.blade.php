<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center p-10">
        <div class="w-full max-w-6xl bg-white shadow-md rounded-lg p-6 sm ">
            <!-- Add Client Button -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('clients.create') }}"
                    class="inline-flex items-center bg-blue-500 text-white px-5 py-3 rounded-lg shadow-md transition hover:bg-blue-600">
                    ➕ Add Client
                </a>
            </div>

            <!-- Clients Table -->
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-gray-700">
                    <thead class="text-xs uppercase bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">GSM</th>
                            <th class="px-6 py-4 text-left">Address</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Historique</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="border-b even:bg-gray-100 hover:bg-gray-200 transition">
                                <td class="px-6 py-4 text-nowrap">{{ $client->id }}</td>
                                <td class="px-6 py-4 text-nowrap">{{ $client->name }}</td>
                                <td class="px-6 py-4 text-nowrap ">{{ $client->GSM }}</td>
                                <td class="px-6 py-4 text-nowrap">{{ $client->adress }}</td>
                                <td class="px-6 py-4 text-nowrap">{{ $client->email }}</td>
                                <td class="px-6 py-4 text-nowrap">{{ $client->historique }}</td>
                                <td class="px-6 py-4 text-nowrap flex items-center justify-center gap-x-4">
                                    <!-- Edit Button -->
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                        class="bg-blue-500 px-4 py-2 text-white rounded-lg shadow-md transition hover:bg-blue-600">
                                        ✏️ Edit
                                    </a>
                                    <!-- Delete Button -->
                                    @if (auth()->user()->role === 'admin')
                                        <form action="{{ route('clients.delete', $client->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this client?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 px-4 py-2 text-white rounded-lg shadow-md transition hover:bg-red-700">
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

</x-app-layout>
