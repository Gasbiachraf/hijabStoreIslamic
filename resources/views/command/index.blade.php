<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-10">
        <div class="flex-1 bg-white rounded-lg shadow-md p-4">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-6 py-3">id</th>
                        <th class="px-6 py-3">quantity</th>
                        <th class="px-6 py-3">sell price</th>
                        {{-- <th class="px-6 py-3">command_id</th> --}}
                        <th class="px-6 py-3">size</th>
                        <th class="px-6 py-3">Color</th>
                        <th class="px-6 py-3">created_at</th>
                        <th class="px-6 py-3">action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandVariants as $command)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $command->id }}</td>
                            <td class="px-6 py-3">{{ $command->quantity }}</td>
                            <td class="px-6 py-3">{{ $command->salePrice }}</td>
                            {{-- <td class="px-6 py-3">{{ $command->command_id }}</td> --}}
                            <td class="px-6 py-3">{{ $command->size }}</td>
                            <td class="px-6 py-3"><div class="w-4 h-4 rounded-full border border-gray-300"
                                style="background-color: {{ $command->variant->color ?? 'N/A' }};">
                            </div></td>
                            <td class="px-6 py-3">{{  $command->created_at}}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('commandVariants.edit', $command->id) }}"
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
