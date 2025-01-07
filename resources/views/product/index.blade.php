<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <div class="flex flex-col justify-center items-center p-10">

        <div class="w-[80%] h-[70%] p- relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex justify-between items-center">
                <div class="flex items-center bg-white w-fit px-2 py-1 rounded-lg h-fit ">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="mr-2">
                        <path
                            d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input type="text" placeholder="Search for a product"
                        class="rounded-lg border-none outline-none focus:outline-none focus:border-none focus:ring-0 text-sm w-full">
                </div>
                <div class="mb-6 flex  self-end justify-end ">
                    <div class="flex gap-5">
                        <a href="">
                            <button type="button"
                                class="bg-blue-500 text-white px-3 py-3 rounded-lg shadow hover:bg-blue-600 flex gap-5 items-center">
                                Add Product
                                <svg fill="#ffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                    viewBox="0 0 45.402 45.402" xml:space="preserve">
                                    <g>
                                        <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141
                                    c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27
                                    c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435
                                    c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z" />
                                    </g>
                                </svg>
                            </button>
                        </a>
                        <a class="flex" href="{{ route('cart.index') }}">

                            <button type="button"
                                class="bg-blue-500 text-white px-3 py-3 rounded-lg shadow hover:bg-blue-600 flex gap-5">
                                <span>Go to cart</span>
                                <svg fill="#ffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                                    viewBox="0 0 902.86 902.86" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M671.504,577.829l110.485-432.609H902.86v-68H729.174L703.128,179.2L0,178.697l74.753,399.129h596.751V577.829z
                                M685.766,247.188l-67.077,262.64H131.199L81.928,246.756L685.766,247.188z" />
                                            <path d="M578.418,825.641c59.961,0,108.743-48.783,108.743-108.744s-48.782-108.742-108.743-108.742H168.717
                                c-59.961,0-108.744,48.781-108.744,108.742s48.782,108.744,108.744,108.744c59.962,0,108.743-48.783,108.743-108.744
                                c0-14.4-2.821-28.152-7.927-40.742h208.069c-5.107,12.59-7.928,26.342-7.928,40.742
                                C469.675,776.858,518.457,825.641,578.418,825.641z M209.46,716.897c0,22.467-18.277,40.744-40.743,40.744
                                c-22.466,0-40.744-18.277-40.744-40.744c0-22.465,18.277-40.742,40.744-40.742C191.183,676.155,209.46,694.432,209.46,716.897z
                                M619.162,716.897c0,22.467-18.277,40.744-40.743,40.744s-40.743-18.277-40.743-40.744c0-22.465,18.277-40.742,40.743-40.742
                                S619.162,694.432,619.162,716.897z" />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <table class="w-full text-sm text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th colspan="1" class="px-6 py-3"><input type="checkbox" name="" id=""></th>
                        <th colspan="1" class="px-6 py-3">Image</th>
                        <th colspan="1" class="px-6 py-3">name</th>
                        <th colspan="1" class="px-6 py-3">color</th>
                        <th colspan="1" class="px-6 py-3">Size</th>
                        <th colspan="1" class="px-6 py-3">Price</th>
                        <th colspan="1" class="px-6 py-3">Quantity</th>
                        <th colspan="1" class="px-6 py-3">action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($products as $product) --}}

                    <tr class="bg-white border-b hover:bg-gray-50 items-center">
                        <td colspan="1" class="px-6 py-3 text-center"><input type="checkbox"></td>
                        <td colspan="1" class="px-6 py-3 flex justify-center items-center text-center"><img
                                src="{{ asset('assets/1.jpg') }}" width="60px" alt=""></td>
                        <td colspan="1" class="px-6 py-3 text-center">smart watch</td>
                        <td colspan="1" class="px-6 py-3 text-center">black</td>
                        <td colspan="1" class="px-6 py-3 text-center">M</td>
                        <td colspan="1" class="px-6 py-3 text-center">35£</td>
                        <td colspan="1" class="px-6 py-3 text-center">35£</td>
                        <td colspan="1" class="px-6 py-3 text-center  ">
                            <div class="flex gap-4 justify-center items-center">
                                <a href=""
                                    class="bg-blue-500 px-4 py-2 text-white  rounded-lg shadow hover:bg-blue-600">
                                    Edit
                                </a>
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 p-2 rounded-lg text-white hover:underline"
                                        onclick="return confirm('Are you sure you wanna delete this product ?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
