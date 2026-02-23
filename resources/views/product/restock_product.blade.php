<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Restock Product') }}
        </h2>
    </x-slot>
    <form action="{{ route('variant.restock', $product) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="bg-teta p-10 flex flex-col gap-5 rounded">
            <div>
                <h1 class="text-2xl font-bold">{{ $product->name->en }}</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Enter positive numbers to increase stock, negative numbers to decrease stock (e.g., -5 to reduce by 5)
                </p>
            </div>
            @foreach ($product->inventories as $inventory)
                @foreach ($inventory->variants as $variant)
                    <div class="p-4 border bg-alpha/10 border-black rounded-md">
                        <div class="flex justify-between py-4">
                            <div style="background-color: {{ $variant->color }}" class="w-10 h-10 rounded-full border-2 border-gray-300"></div>
                        </div>
                        <div class="flex flex-col gap-3">
                            @php
                                $allSizes = \App\Models\Size::getAllSizesForVariant($variant->id);
                            @endphp
                            @foreach ($allSizes as $sizeData)
                                <div id="infoContainer" class="flex justify-between items-center">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-lg font-bold">Size: {{ $sizeData['size'] }}</p>
                                        <p class="{{ $sizeData['exists'] ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                                            Current Stock: <span class="font-bold">{{ $sizeData['quantity'] }}</span>
                                            @if (!$sizeData['exists'])
                                                <span class="text-sm text-gray-400">(Not in stock)</span>
                                            @endif
                                        </p>
                                        @if ($sizeData['exists'] && $sizeData['quantity'] > 0)
                                            <p class="text-xs text-gray-500">
                                                Min: -{{ $sizeData['quantity'] }} (can reduce up to current stock)
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <input 
                                            value="0" 
                                            type="number" 
                                            placeholder="Add/Reduce Quantity" 
                                            class="input-number w-32 text-center"
                                            name="{{ $variant->color }}[{{ $sizeData['size'] }}]" 
                                            min="{{ $sizeData['exists'] ? -$sizeData['quantity'] : 0 }}"
                                            step="1"
                                            id="stock-input-{{ $variant->id }}-{{ $sizeData['size'] }}"
                                        >
                                        <p class="text-xs text-gray-400">
                                            Use - for reduction
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endforeach
            <div class="self-end">
                <button type="submit" class="flex items-center gap-2 bg-gamma px-4 py-3 hover:bg-gamma/70 rounded text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <p>Update Stock</p>
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
