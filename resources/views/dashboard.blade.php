<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="flex gap-3 w-full rounded-lg">
            <div class="w-full flex flex-col gap-3">
                {{-- cards --}}
                <div class="flex lg:flex-row flex-col gap-3">
                    <div class="bg-white p-3 rounded-lg border lg:w-1/3 aspect-video">
                        <div class="flex justify-between">
                            <h3>Total Earning</h3>
                            <h3>last 7 days</h3>
                        </div>
                        <p class="text-3xl font-bold">{{ $total7daysEarnings }} Dhs</p>
                    </div>
                    <div class="bg-white p-3 rounded-lg border lg:w-1/3 aspect-video">
                        <div class="flex justify-between">
                            <h3>Top 5 Categories</h3>
                        </div>
                        <p id="pieChart" class=""></p>
                    </div>
                    <div class="bg-white p-3 rounded-lg border lg:w-1/3 aspect-video">
                        <div class="flex justify-between">
                            <h3>Last 30 Days Orders</h3>
                        </div>
                        <p class="text-5xl font-bold">{{ $last30Orders }}</p>
                    </div>
                    {{-- top selling products --}}

                    <div class="bg-white p-3 rounded-lg border lg:w-1/3 aspect-video">
                        <h2 class="pb-4">Top Selling Products</h2>
                        @foreach ($products->take(3) as $k => $prd)
                                @php
                                    $firstImage = $prd[0]->variant->images->first();
                                @endphp
                                <div class="flex gap-3 border-t-2 py-2 {{ $k == 0 ? 'border-t-0' : 'border-t-2' }}">
                                    <img class="w-10 h-10 object-cover object-center"
                                        src="{{ asset('storage/images/' . $firstImage->path) }}" alt="">
                                    <div class="flex justify-between w-full text-lg font-medium">
                                        {{-- <dd>{{ $prd[0]->variant->inventory->product->name->en }}</dd> --}}
                                        <p>{{ $prd[0]->variant->inventory->product->name->en }}</p>
                                        <p>{{ count($prd) }}</p>
                                    </div>
                                </div>
                        @endforeach
                    </div>

                </div>
                {{-- stats --}}
                <div class="bg-white p-3 rounded-lg">
                    <div class="px-3">
                        <p class="text-xl font-medium">
                            Last 30 days sales 
                        </p>
                        <p class="text-xl font-medium">{{ $totalEarningThisMonth }} Dhs</p>
                    </div>
                    <div id="chart" class="">
                    </div>
                </div>
            </div>




        </div>
        {{-- orders cards --}}
        <div class="flex lg:flex-row flex-col gap-3 py-3">
            <div class="flex items-center gap-3 bg-white lg:w-1/4 rounded-lg p-3">
                <div class="bg-green-400 lg:w-[3vw] w-[8vw] flex justify-center items-center aspect-square rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ count($commands) }}</p>
                    <p>Total orders</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white lg:w-1/4 rounded-lg p-3">
                <div class="bg-green-400 lg:w-[3vw]  w-[8vw] flex justify-center items-center aspect-square rounded-full">
                    <svg class="size-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ count($storeCommands) }}</p>
                    <p>Orders made at the store </p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white lg:w-1/4 rounded-lg p-3">
                <div class="bg-green-400 lg:w-[3vw] w-[8vw] flex justify-center items-center aspect-square rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ count($inPresentCommands) }}</p>
                    <p>Orders with delivery </p>
                </div>
            </div>
        </div>
        {{-- orders table --}}
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-lg">
                    <tr class="">
                        <th class="px-6 py-3 rounded-tl-lg">Customer</th>
                        <th class="px-6 py-3">Items</th>
                        {{-- <th class="px-6 py-3">Category</th> --}}
                        <th class="px-6 py-3">Payement Status</th>
                        <th class="px-6 py-3">Delivery Status</th>
                        <th class="px-6 py-3 rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody class="rounded-br-lg">
                    @foreach ($commands as $key => $command)
                        @if ($key < 9)
                            <tr class="bg-white hover:bg-gray-50 rounded-br-lg">
                                <td class="px-6 py-3 border-b text-center {{ $key == 8 ? 'rounded-bl-lg' : 'rounded-none' }}">
                                    {{ $command->client->name }}
                                </td>
                                <td class="px-6 py-3 border-b text-center"><a href="">{{ count($command->variants) }}</a>
                                </td>
                                {{-- <td class="px-6 py-3">{{ $inventory->product->category->name }}</td> --}}
                                <td class="px-6 py-3 border-b text-center"><span
                                        class="{{ $command->status === 'rent' ? 'bg-orange-300 text-orange-900' : 'bg-green-300 text-green-900' }}  p-2  rounded-lg">{{ $command->status === 'rent' ? 'Rent' : 'Buy' }}</span>
                                </td>
                                <td class="px-6 py-3 border-b text-center">
                                    <span class="bg-blue-300 p-2 text-blue-900 rounded-lg">
                                        {{ $command->livraison === 'livraison' ? 'Livraison' : 'On Site' }}
                                    </span>
                                </td>
                                <td 
                                    class="px-6 py-3 border-b flex justify-center {{ $key == 8 ? 'rounded-br-lg' : 'rounded-none' }}">
                                    <a class="" href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- total cards --}}
        <div class="py-3 grid lg:grid-cols-4 gap-3 flex-wrap">
            <div class=" bg-white rounded-lg p-3 flex gap-3 items-center">
                <div class="lg:w-[3vw] w-[8vw] aspect-square rounded-full bg-red-200 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ $totalEarnings }}</p>
                    <p>Total Earning</p>
                </div>
            </div>
            <div class=" bg-white rounded-lg p-3 flex gap-3 items-center">
                <div class="lg:w-[3vw] w-[8vw] aspect-square rounded-full bg-red-200 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ $totalTodayEarning }}</p>
                    <p>Today's Earning</p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-3 flex gap-3 items-center">
                <div class="lg:w-[3vw] w-[8vw] aspect-square rounded-full bg-red-200 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ $clients }}</p>
                    <p>Total Customers</p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-3 flex gap-3 items-center">
                <div class="lg:w-[3vw] w-[8vw] aspect-square rounded-full bg-red-200 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ count($variants) }}</p>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-3 flex gap-3 items-center">
                <div class="lg:w-[3vw] w-[8vw] aspect-square rounded-full bg-red-200 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ count($categories) }}</p>
                    <p>Total Categories</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        const topCategories = @json($topcategories);
        const totalCategories = @json($totalCategorie);
        const total30daysSells = @json($last30daysSells);
    </script>
</x-app-layout>
