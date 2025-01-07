<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    {{-- <x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
>{{ __('Delete Account') }}</x-danger-button> --}}

    <div class="p-[4vw] flex gap-5 bg-teta rounded-lg">
        <div>
            {{-- title and description --}}
            <div x-data='{languages:["en","fr","ar"], currentPage:"en"}'>
                <div class="flex items-center gap-5 rounded-md bg-beta p-3">
                    <template x-for='language in languages'>
                        <span class="bg-gray-50/80 w-1/3 text-center rounded py-2 font-bold cursor-pointer"
                            x-on:click='currentPage = language' x-text='language'></span>
                    </template>
                </div>
                <div id="english" x-show='currentPage == languages[0]' class="flex flex-col gap-3 mt-4">
                    <div class="flex flex-col gap-3">
                        <label for="">Product Title</label>
                        <input type="text" name="name[en]" class="bg-gray-50/80" placeholder="Title">
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="">Product Description</label>
                        <textarea name="description[en]" class="bg-gray-50/80" placeholder="Description" id="" cols="30"
                            rows="10"></textarea>
                    </div>
                </div>
                <div id="french" x-show='currentPage == languages[1]' class="flex flex-col gap-3 mt-4">
                    <div class="flex flex-col gap-3">
                        <label for="">Titre de Prodruit</label>
                        <input type="text" name="name[fr]" class="bg-gray-50/80" placeholder="Title">
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="">Product Description</label>
                        <textarea name="description[fr]" class="bg-gray-50/80" placeholder="Description" id="" cols="30"
                            rows="10"></textarea>
                    </div>
                </div>
                <div dir="rtl" id="arabic" x-show='currentPage == languages[2]'
                    class="flex flex-col gap-3 mt-4">
                    <div class="flex flex-col gap-3">
                        <label for="">اسم المنتج</label>
                        <input type="text" name="name[]" class="bg-gray-50/80" placeholder="اسم ">
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="">وصف المنتج</label>
                        <textarea name="description[]" class="bg-gray-50/80" placeholder="وصف " id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            {{-- image --}}
            <div class="flex flex-col gap-3 py-4">
                <h1 class="text-xl font-medium">Display Images</h1>
                <div class="w-full">
                    <div
                        class="relative h-48 rounded-lg border border-dashed bg-gray-50/50 flex justify-center items-center ">
                        <div class="absolute flex flex-col items-center">
                            <img alt="File Icon" class="mb-3" src="{{ asset('assets/icons8-upload-100.png') }}" />
                            <span class="block text-gray-500 font-semibold">Drag &amp; drop your files here</span>
                            <span class="block text-gray-400 font-normal mt-1">or click to upload</span>
                        </div>
                        <input name="" class="h-full w-full opacity-0 cursor-pointer" type="file" />
                    </div>
                </div>

            </div>
            <div class="flex flex-col gap-3">
                <h1 class="text-xl font-medium">
                    Pricing
                </h1>
                <div class="flex gap-5 justify-around">
                    <div class="flex gap-3 items-center">
                        <label for="">Purchase price</label>
                        <input class="input-number" class="bg-gray-50/80" type="number" name="prePrice"
                            placeholder="Purchase">
                    </div>
                    <div class="flex gap-3 items-center">
                        <label for="">Sale Price</label>
                        <input class="input-number" class="bg-gray-50/80" type="number" name="postPrice"
                            placeholder="Sale">
                    </div>
                    <div class="flex gap-3 items-center">
                        <label for="">Old Price</label>
                        <input class="input-number" class="bg-gray-50/80" type="number" name="ex_price"
                            placeholder="Old">
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="bg-gray-50/80 rounded-t-md p-4">
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
                <select name="" id="">
                    <option value="">select a category</option>
                </select>
            </div>
            <div class="bg-gray-50/80 rounded-b-md p-4">
                <div x-data='{showModal: false}' class="flex gap-2 items-center">
                    <h1>Category</h1>
                    <button x-on:click.prevent="$dispatch('open-modal', 'add-subcategory')"
                        class="underline text-blue-500 font-medium cursor-pointer">Add New Category</button>
                    <x-modal name="add-subcategory" :show="$errors->userDeletion->isNotEmpty()">
                        <form class="px-5 py-8 flex flex-col gap-3" action="">
                            @csrf
                            <label for="">Sub Category Name</label>
                            <input type="hidden" value="">
                            <input placeholder="name" type="text" name="name">
                            <button class="px-3 py-2 bg-gamma rounded text-white w-fit">Submit</button>
                        </form>
                    </x-modal>
                </div>
                <select name="" id="">
                    <option value="">select a Sub Category</option>
                </select>
            </div>
        </div>

    </div>
</x-app-layout>
