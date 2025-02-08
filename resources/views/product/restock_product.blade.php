<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Restock Product') }}
        </h2>
    </x-slot>
    <form action="{{ route('variant.restock', $product) }}" method="post" >
        @csrf
        @method('PATCH')
        <div class="bg-teta p-10 flex flex-col gap-5 rounded">
            <div>
                <h1 class="text-2xl font-bold">{{ $product->name->en }}</h1>
            </div>
            @foreach ($product->inventories as $inventory)
                @foreach ($inventory->variants as $variant)
                    <div class="p-4 border bg-alpha/10 border-black rounded-md">
                        <div class="flex justify-between py-4">
                            <div style="background-color: {{ $variant->color }}" class="w-10 h-10 rounded-full">.</div>
                        </div>
                        <div class="flex flex-col gap-3">
                            @foreach ($variant->sizes as $size)
                                <div id="infoContainer" class="flex justify-between">
                                    <div class="flex flex-col gap-3">
                                        <p class="text-lg font-bold ">Size: {{ $size->size }}</p>
                                        <p>Current Stock: {{ $size->quantity }}</p>
                                    </div>
                                    
                                    <input value="0" type="number" placeholder="Add Quantity" class="input-number"
                                        name="{{ $variant->color }}[{{ $size->size }}]" id="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endforeach
            <div class="self-end">
                <button class="flex items-center gap-2 bg-gamma px-4 py-3 hover:bg-gamma/70 rounded text-white">
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
