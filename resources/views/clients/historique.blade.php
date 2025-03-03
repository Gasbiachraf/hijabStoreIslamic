<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Historique - ' . $client->name) }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center w-full">
        <div class="w-full bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Commands for {{ $client->name }}</h3>

            @forelse($client->commands as $command)
                <div class="mb-6 border rounded-lg shadow-sm overflow-hidden">
                    <!-- Command Summary -->
                    <div class="bg-gray-100 px-4 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <div class="font-semibold">Command #{{ $command->id }}</div>
                            <div class="text-gray-600">Status: <span class="font-medium">{{ $command->status }}</span></div>
                            <div class="text-gray-600">Delivery: <span class="font-medium">{{ $command->livraison }}</span></div>
                            <div class="text-gray-600">Created At: {{ $command->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                        <button onclick="toggleDetails('command-{{ $command->id }}')" class="text-blue-500 hover:underline">
                            🔽 View Products
                        </button>
                    </div>

                    <!-- Products Table (inside each command) -->
                    <div id="command-{{ $command->id }}" class="hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-gray-700">
                                <thead class="text-xs uppercase bg-gray-50 border-t">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Product</th>
                                        <th class="px-4 py-2 text-left">Color</th>
                                        <th class="px-4 py-2 text-left">Size</th>
                                        <th class="px-4 py-2 text-left">Quantity</th>
                                        <th class="px-4 py-2 text-left">Sale Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $commandVariants = \App\Models\CommandVariant::where('command_id', $command->id)->get();
                                    @endphp

                                    @forelse($commandVariants as $cv)
                                        <tr class="border-t hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $cv->variant->inventory->product->name->en ?? 'N/A' }}</td>
                                            <td class="px-4 py-2">
                                                <div class="w-4 h-4 rounded-full border border-gray-300"
                                                     style="background-color: {{ $cv->variant->color ?? '#ccc' }};">
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">{{ $cv->size }}</td>
                                            <td class="px-4 py-2">{{ $cv->quantity }}</td>
                                            <td class="px-4 py-2">{{ $cv->salePrice }} DH</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-500">No products for this command.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No commands found for this client.</p>
            @endforelse

            <div class="mt-4">
                <a href="{{ route('clients.index') }}" class="text-blue-500 hover:underline">⬅️ Back to Clients</a>
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</x-app-layout>
