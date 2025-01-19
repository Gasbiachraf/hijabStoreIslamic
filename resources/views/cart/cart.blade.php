<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div x-data='{showModal: false}' class="container mx-auto my-10 p-4">

        <h1 class="text-3xl font-bold mb-6">Cart</h1>

        <div class="flex flex-col lg:flex-row gap-6">

            <div class="flex-1 bg-white rounded-lg shadow-md p-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3">PRODUCTS</th>
                            <th class="pb-3">COLOR</th>
                            <th class="pb-3">SIZE</th>
                            <th class="pb-3">PRICE</th>
                            <th class="pb-3">QUANTITY</th>
                            <th class="pb-3">TOTAL</th>
                            <th class="pb-3"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="border-b">
                            <td class="py-4">Smartwatch</td>
                            <td class="py-4">red</td>
                            <td class="py-4">M</td>
                            <td class="py-4">39£</td>
                            <td class="py-4 flex items-center">
                                <button class="px-2 py-1 border border-gray-400 rounded">-</button>
                                <span class="mx-2">2</span>
                                <button class="px-2 py-1 border border-gray-400 rounded">+</button>
                            </td>
                            <td class="py-4">398£</td>
                            <td class="py-4">

                                <button class="text-red-500">🗑</button>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="text-right mt-4">
                    <span class="font-semibold">Items subtotal: </span>
                    <span>691</span>
                </div>
            </div>


            <div class="w-full lg:w-1/3 bg-white rounded-lg shadow-md p-4">
                <h2 class="text-lg font-bold mb-4">Summary</h2>
                <div class="flex justify-between mb-2">
                    <span>Items subtotal:</span>
                    <span>691</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Discount:</span>
                    <span class="text-red-500">-59</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Nego ciation:</span>
                    <span>126.2</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span>665</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Shipping Cost:</span>
                    <span>30</span>
                </div>
                <div class="border-t my-2"></div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span>695.20</span>
                </div>
                <div class="mt-4">
                    <label for="payment-method" class="block mb-2">Payment Method:</label>
                    <select id="payment-method" class="w-full border border-gray-300 rounded p-2">
                        <option>Cash on Delivery</option>
                        <option>in present</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-blue-600 text-white font-bold py-3 rounded">Proceed to checkout</button>
                </div>
            </div>
        </div>
        <div  class="flex gap-2 items-center">

            <button class="p-4 bg-green-500 " x-on:click.prevent="$dispatch('open-modal','command-modal')">
                Open modal
            </button>
            <x-modal name="command-modal" :show="$errors->userDeletion->isNotEmpty()">
                <h1 class="text-3xl text-center">
                    zakaria dahar
                </h1>
                <button class="p-4 bg-red-500" x-on:click="$dispatch('close-modal','command-modal')">Close</button>
            </x-modal>
        </div>


        <button type="button" x-on:click.prevent="$dispatch('open-modal', 'add-category')"
            class="underline text-blue-500 font-medium cursor-pointer">Add New Category</button>
        <x-modal name="add-category" :show="$errors->userDeletion->isNotEmpty()">
            <div class="flex flex-col gap-4 p-5">
                <label for="">Category Name</label>
                <input placeholder="name" x-ref='category_name' type="text" name="category_name">
                <button type="button"
                    x-on:click.prevent='category=$refs.category_name.value; $dispatch("close-modal", "add-category")'
                    class="px-3 py-2 bg-gamma rounded text-white w-fit">Submit</button>
            </div>
        </x-modal>
        <div x-data='{showModal: false}' class="flex gap-2 items-center">
            <h1>Category</h1>
            <button x-on:click.prevent="$dispatch('open-modal', 'add-category')"
                class="underline text-blue-500 font-medium cursor-pointer">Add New Category</button>
            <x-modal name="add-category" :show="$errors->userDeletion->isNotEmpty()">
                <form class="px-5 py-8 flex flex-col gap-3" action="">
                    @csrf
                    <label for="">Category Name</label>
                    <input placeholder="name" type="text" name="name">
                    <button class="px-3 py-2 bg-gamma rounded text-white w-fit">Submit</button>
                </form>
            </x-modal>
        </div>

    </div>
</x-app-layout>
