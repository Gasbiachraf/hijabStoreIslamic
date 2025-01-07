<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-10">

        <div class="w-[80%] h-[70%] p- relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="mb-6 flex self-end justify-end ">
                <a href="{{ route('clients.create') }}">
                    <button type="button" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600">
                        Add client
                    </button>
                </a>
            </div>
            <table class="w-full text-sm text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th colspan="1" class="px-6 py-3">id</th>
                        <th colspan="1" class="px-6 py-3">name</th>
                        <th colspan="1" class="px-6 py-3">GSM</th>
                        <th colspan="1" class="px-6 py-3">Adress</th>
                        <th colspan="1" class="px-6 py-3">Email</th>
                        <th colspan="1" class="px-6 py-3">Historique</th>
                        <th colspan="1" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td colspan="1" class="px-6 py-3">{{ $client->id }}</td>
                        <td colspan="1" class="px-6 py-3">{{ $client->name }}</td>
                        <td colspan="1" class="px-6 py-3">{{ $client->GSM }}</td>
                        <td colspan="1" class="px-6 py-3">{{ $client->adress }}</td>
                        <td colspan="1" class="px-6 py-3">{{ $client->email }}</td>
                        <td colspan="1" class="px-6 py-3">{{ $client->historique }}</td>
                        <td colspan="1" class="px-6 py-3 flex gap-4 items-center">
                            <a href="{{ route('clients.edit', $client->id) }}"
                                class="bg-blue-500 px-4 py-2 text-white  rounded-lg shadow hover:bg-blue-600">
                                Edit
                            </a>
                            <form action="{{ route('clients.delete', $client->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 p-2 rounded-lg text-white hover:underline"
                                    onclick="return confirm('Are you sure you wanna delete this client ?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
