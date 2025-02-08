<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Arrival_Products') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-10">
        <div class="flex-1 bg-white rounded-lg shadow-md p-4">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-6 py-3">id</th>
                        <th class="px-6 py-3">Arrival Date</th>
                        <th class="px-6 py-3">Color</th>
                        <th class="px-6 py-3"> Size</th>
                        <th class="px-6 py-3">quantity</th>
                       

                    </tr>
                </thead>
                <tbody>
                    @foreach ($arrivals as $arrival)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $arrival->id }}</td>
                            <td class="px-6 py-3">{{ $arrival->arrivalDate }}</td>
                            <td class="px-6 py-3">
                                
                                <div class="w-4 h-4 rounded-full border border-gray-300"
                                    style="background-color: {{ $arrival->size->variant->color }};">
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
</x-app-layout>
