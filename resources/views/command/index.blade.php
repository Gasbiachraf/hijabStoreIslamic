<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-4 md:p-10">
        <div class="w-full overflow-x-auto bg-white rounded-lg shadow-md p-4">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Quantity</th>
                        <th class="px-4 py-3">Sell Price</th>
                        <th class="px-4 py-3">Size</th>
                        <th class="px-4 py-3">Color</th>
                        <th class="px-4 py-3">Created At</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commandVariants as $command)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $command->id }}</td>

                            <!-- Product Name & Image -->
                            <td class="px-4 py-3 flex items-center gap-3">
                                {{-- <img src="{{ $command->variant->image->path  }}" 
                                     alt="Product Image" class="w-12 h-12 rounded-lg object-cover"> --}}
                                     <span>{{ $command->variant->inventory->product->name->en ?? 'N/A' }}</span>

                                    </td>

                            <td class="px-4 py-3">{{ $command->quantity }}</td>
                            <td class="px-4 py-3">{{ $command->salePrice }}</td>
                            <td class="px-4 py-3">{{ $command->size }}</td>

                            <!-- Color Indicator -->
                            <td class="px-4 py-3">
                                <div class="w-4 h-4 rounded-full border border-gray-300"
                                    style="background-color: {{ $command->variant->color ?? '#ccc' }};">
                                </div>
                            </td>

                            <td class="px-4 py-3">{{ $command->created_at }}</td>
                            <td class="px-4 py-3">
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
