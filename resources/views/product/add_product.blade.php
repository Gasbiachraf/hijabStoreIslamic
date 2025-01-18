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
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div x-data='{category:"", sub_category:"",}' class="p-[4vw] flex gap-5 bg-teta rounded-lg">
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
                            <input required type="text" name="product_name[en]" class="bg-gray-50/80"
                                placeholder="Title">
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">Product Description</label>
                            <textarea name="product_description[en]" class="bg-gray-50/80" placeholder="Description" id="" cols="30"
                                rows="5"></textarea>
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">Fabric</label>
                            <input required type="text" name="inventory_type[en]" placeholder="Fabric type">
                        </div>
                    </div>
                    <div id="french" x-show='currentPage == languages[1]' class="flex flex-col gap-3 mt-4">
                        <div class="flex flex-col gap-3">
                            <label for="">Titre de Prodruit</label>
                            <input required type="text" name="product_name[fr]" class="bg-gray-50/80"
                                placeholder="Title">
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">Product Description</label>
                            <textarea required name="product_description[fr]" class="bg-gray-50/80" placeholder="Description" id=""
                                cols="30" rows="5"></textarea>
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">Tissu</label>
                            <input required type="text" name="inventory_type[fr]" placeholder="Type de tissu">
                        </div>
                    </div>
                    <div dir="rtl" id="arabic" x-show='currentPage == languages[2]'
                        class="flex flex-col gap-3 mt-4">
                        <div class="flex flex-col gap-3">
                            <label for="">اسم المنتج</label>
                            <input required type="text" name="product_name[ar]" class="bg-gray-50/80"
                                placeholder="اسم ">
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">وصف المنتج</label>
                            <textarea required name="product_description[ar]" class="bg-gray-50/80" placeholder="وصف " id="" cols="30"
                                rows="5"></textarea>
                        </div>
                        <div class="flex flex-col gap-3">
                            <label for="">القماش</label>
                            <input required type="text" name="inventory_type[ar]" placeholder="نوع القماش  ">
                        </div>
                    </div>
                </div>
                {{-- color variants --}}

                <div x-data='{colors:[]}' class="py-4">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium">Variants</h1>
                        <button type="button" x-on:click="colors.push({ id: Date.now(), hex:'', sizes: [] });"
                            class="bg-slate-100 py-2 px-4 rounded">+
                            Add Color</button>
                    </div>
                    <template x-for='(col, index) in colors' :key="col.id">
                        <div class="flex flex-col gap-3 bg-gray-50/80 rounded p-4 mt-3">
                            <div class="flex justify-between py-3 items-center">
                                <div class="flex items-center gap-3">
                                    <input type="color" x-ref="chooseColor"
                                        x-on:change='col.hex = $refs.chooseColor.value' name="color[]" value=""
                                        class="h-10">
                                    <span x-text="$refs.chooseColor.value"></span>
                                </div>
                                <div class="hover:bg-slate-300/50 group  flex justify-center items-center p-2 ">
                                    <button type="button" x-on:click="colors.splice(index, 1)"
                                        class="bg-transparent">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-5 cursor-pointer group-hover:text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div class="grid w-full max-w-xs items-center gap-1.5">
                                    <label
                                        class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Picture</label>
                                    <input id="picture" x-bind:name="`variant_images[${col.hex}][]`" multiple
                                        type="file"
                                        class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium">
                                </div>
                            </div>
                            <div class="">
                                <div class="flex justify-between">
                                    <p>Sizes</p>
                                    <button x-on:click="col.sizes.push({id: Date.now(), value: ''})" type="button"
                                        class="bg-beta px-4 py-2 rounded">+ Add Sizes</button>
                                </div>
                                <template class="flex flex-col gap-2" x-for="(size, i) in col.sizes"
                                    :key="size.id">
                                    <div class="flex justify-between mt-2 items-center">
                                        <div class="flex flex-col gap-2">
                                            <label
                                                class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Size</label>
                                            <input type="text" x-model="size.value"
                                                x-bind:name="`size[${col.hex}_${i + 1}]`"
                                                placeholder="XS-S-M-L-XL-XXl">
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label
                                                class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Quantity</label>
                                            <input type="number" x-bind:name="`quantity[${col.hex}_${i + 1}]`"
                                                class="input-number" placeholder="0">
                                        </div>
                                        <div
                                            class="hover:bg-slate-300/50 group  flex justify-center items-center p-2 ">
                                            <button class="bg-transparent" type="button"
                                                x-on:click="col.sizes.splice(i,1)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 cursor-pointer group-hover:text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                </div>
                {{-- image --}}
                {{-- <div class="flex flex-col gap-3 py-4">
                    <h1 class="text-xl font-medium">Display Images</h1>
                    <div class="w-full">
                        <div
                            class="relative h-48 rounded-lg border border-dashed bg-gray-50/50 flex justify-center items-center ">
                            <div class="absolute flex flex-col items-center">
                                <img alt="File Icon" class="mb-3"
                                    src="{{ asset('assets/icons8-upload-100.png') }}" />
                                <span class="block text-gray-500 font-semibold">Drag &amp; drop your files here</span>
                                <span class="block text-gray-400 font-normal mt-1">or click to upload</span>
                            </div>
                            <input required name="variant_images[]" accept="image/png, image/jpg, image/jpeg" multiple
                                class="h-full w-full opacity-0 cursor-pointer" type="file" />
                        </div>
                    </div>
                </div> --}}
                <div class="flex flex-col gap-3">
                    <h1 class="text-xl font-medium">
                        Pricing
                    </h1>
                    <div class="flex gap-5 justify-around">
                        <div class="flex gap-3 items-center">
                            <label for="">Purchase price</label>
                            <input required class="input-number" class="bg-gray-50/80" type="number"
                                name="prePrice" placeholder="Purchase">
                        </div>
                        <div class="flex gap-3 items-center">
                            <label for="">Sale Price</label>
                            <input required class="input-number" class="bg-gray-50/80" type="number"
                                name="postPrice" placeholder="Sale">
                        </div>
                        <div class="flex gap-3 items-center">
                            <label for="">Old Price</label>
                            <input required class="input-number" class="bg-gray-50/80" type="number"
                                name="ex_price" placeholder="Old">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="bg-gray-50/80 flex flex-col gap-3 rounded-t-md p-4">
                    <div class="flex gap-2 items-center">
                        <h1>Category</h1>
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
                    </div>
                    <select name="category_id" id="">
                        <option value="">select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                        <template x-if=category>
                            <option value="" x-text='category'></option>
                        </template>
                    </select>
                </div>
                <div class="bg-gray-50/80 flex flex-col gap-3 rounded-b-md p-4">
                    <div class="flex gap-2 items-center">
                        <h1>Sub Category</h1>
                        <button type="button" x-on:click.prevent="$dispatch('open-modal', 'add-subcategory')"
                            class="underline text-blue-500 font-medium cursor-pointer">Add New Sub Category</button>
                        <x-modal name="add-subcategory" :show="$errors->userDeletion->isNotEmpty()">
                            <div class="flex flex-col gap-4 p-5">
                                <label for="">Sub Category Name</label>
                                {{-- <input type="hidden" value=""> --}}
                                <input placeholder="name" x-ref='sub_category_name' type="text"
                                    name="sub_category">
                                <button type='button'
                                    x-on:click='sub_category = $refs.sub_category_name.value; $dispatch("close-modal", "add-subcategory") '
                                    class="px-3 py-2 bg-gamma rounded text-white w-fit">Submit</button>
                            </div>
                        </x-modal>
                    </div>
                    <select name="sub_category_id" id="">
                        <option value="">select a Sub Category</option>
                        @foreach ($subCategories as $subCategory)
                            <option value="{{ $subCategory->id }}" >{{ $subCategory->name }}</option>
                        @endforeach
                        <template x-if=sub_category>
                            <option value="" x-text='sub_category'></option>
                        </template>
                    </select>
                </div>
                {{-- <h1>Variants</h1>
                <div class="bg-gray-50/80 flex flex-col gap-3 rounded-b-md p-4">
                    <label>Size</label>
                    <input required type="text" placeholder="Option 1" name="size" id="">
                </div>
                <div class="bg-gray-50/80 flex flex-col gap-3 rounded-b-md p-4">
                    <label>Color</label>
                    <input required type="text" placeholder="Option 2" name="color" id="">
                </div> --}}
            </div>
        </div>
        <button>Create</button>
    </form>

</x-app-layout>
