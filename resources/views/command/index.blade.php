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
                        <th class="px-6 py-3">quantity</th>
                        <th class="px-6 py-3">sell price</th>
                        <th class="px-6 py-3">command_id</th>
                        <th class="px-6 py-3">variant_id</th>
                        <th class="px-6 py-3">created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandVariants as $command)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $command->quantity }}</td>
                            <td class="px-6 py-3">{{ $command->salePrice }}</td>
                            <td class="px-6 py-3">{{ $command->command_id }}</td>
                            <td class="px-6 py-3">{{  $command->variant_id }}</td>
                            <td class="px-6 py-3">{{  $command->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
