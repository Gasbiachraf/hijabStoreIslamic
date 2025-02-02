<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Update Product') }}
        </h2>
        <div x-data="">
            <button type="button" class="bg-red-600 text-white rounded-lg px-4 py-2"
                x-on:click.prevent="$dispatch('open-modal', 'delete_product')">Delete Product</button>
            <x-modal name="delete_product" :show="$errors->userDeletion->isNotEmpty()">
                <div class="flex flex-col items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>

                    <p> You want to delete {{ $product->name->en }} ?</p>
                    <form action="{{ route('product.delete', $product) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="flex gap-5 items-center">
                            <button type="button" x-on:click.prevent='$dispatch("close-modal", "delete_product")'
                                class="px-3 py-2 bg-gamma/50 rounded text-white w-fit">Cancel</button>
                            <button class="bg-red-500 px-4 py-2 text-white rounded">Delete</button>
                        </div>
                    </form>
                </div>
            </x-modal>
        </div>
    </x-slot>
    <form x-data="{
        checkInfo: { check_category: false, check_subCategory: false, check_title: [false, false, false], check_description: [false, false, false], check_type: [false, false, false] },
    }" action="{{ route('product.update', $product) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="infoContainer" x-data='{category:"", sub_category:"",}'
            class="p-[3vw] w-full gap-5 bg-teta rounded-lg">
            {{-- steps --}}
            <div x-data="{ steps: ['Info', 'Variants', 'Pricing'], currentStep: 0 }">
                <div class="flex justify-between py-5 gap-5 w-full">
                    <template x-for='(step, index) in steps' :key="index">
                        <div class="flex flex-col items-center gap-1 font-medium">
                            <div x-bind:class='steps[currentStep] === step ? "bg-alpha/50" : "bg-gray-50/80"'
                                class=" rounded-full w-10 h-10 flex justify-center items-center">
                                <span x-text="index + 1"></span>
                            </div>
                            <p x-text="step"></p>
                        </div>
                    </template>
                </div>
                <div>
                    {{-- info --}}
                    <div id="Info" x-show="steps[currentStep] === 'Info'">
                        {{-- category && sub category --}}
                        <div class="w-full bg--500 flex gap-5 items-center">
                            <div class="w-1/2 flex flex-col gap-3 py-4">
                                <div class="flex gap-2 items-center justify-between">
                                    <h1 class="font-medium">Category</h1>
                                    <button type="button" x-on:click.prevent="$dispatch('open-modal', 'add-category')"
                                        class="bg-alpha/50 px-4 rounded-lg py-2 cursor-pointer">+ Add New
                                        Category</button>
                                    <x-modal name="add-category" :show="$errors->userDeletion->isNotEmpty()">
                                        <div class="flex flex-col gap-4">
                                            <label for="">Category Name</label>
                                            <input placeholder="name" x-ref='category_name' type="text"
                                                name="category_name">
                                            <button type="button"
                                                x-on:click.prevent='category=$refs.category_name.value; $dispatch("close-modal", "add-category")'
                                                class="px-3 py-2 bg-gamma rounded text-white w-fit">Submit</button>
                                        </div>
                                    </x-modal>
                                </div>
                                <select x-on:input="checkInfo.check_category = true" name="category_id" id="">
                                    <option selected value="{{ $product->subcategory->category->id }}">
                                        {{ $product->subcategory->category->name }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    <template x-if=category>
                                        <option value="" x-text='category'></option>
                                    </template>
                                </select>
                            </div>
                            <div class="w-1/2 flex flex-col gap-3 py-4">
                                <div class="flex gap-2 items-center justify-between">
                                    <h1>Sub Category</h1>
                                    <button type="button"
                                        x-on:click.prevent="$dispatch('open-modal', 'add-subcategory')"
                                        class="bg-alpha/50 px-4 rounded-lg py-2 cursor-pointer">+ Add New Sub
                                        Category</button>
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
                                <select x-on:input="checkInfo.check_subCategory = true" name="sub_category_id"
                                    id="">
                                    <option selected value="{{ $product->subcategory->id }}">
                                        {{ $product->subcategory->name }}</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                    <template x-if=sub_category>
                                        <option value="" x-text='sub_category'></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        {{-- title and description --}}
                        <div x-data='{languages:["en","fr","ar"], currentPage:"en"}'>
                            <div class="flex items-center gap-3 rounded-md bg-beta px-3 py-2">
                                <template x-for='language in languages'>
                                    <span x-bind:class="currentPage == language ? 'bg-gray-50/80' : 'bg-transparent'"
                                        class=" w-[5vw] text-center rounded py-2 font-medium cursor-pointer"
                                        x-on:click='currentPage = language'
                                        x-text="language === 'en' ? 'English' : language === 'fr' ? 'Français' : 'العربية'"></span>
                                </template>
                            </div>
                            <div id="english" x-show='currentPage == languages[0]' class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Title</label>
                                    <input value="{{ old('product_name[en]', $product->name->en) }}"
                                        x-on:input="checkInfo.check_title[0] = true" type="text"
                                        name="product_name[en]" class="bg-gray-50/80" placeholder="Title">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Description</label>
                                    <textarea x-on:input="checkInfo.check_description[0] = true" name="product_description[en]" class="bg-gray-50/80"
                                        placeholder="Description" id="" cols="30" rows="5">{{ old('product_description[en]', $product->description->en) }}</textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Fabric</label>
                                    <input value="{{ old('inventory_type[en]', $product->inventories[0]->type->en) }}"
                                        x-on:input="checkInfo.check_type[0] = true" type="text"
                                        name="inventory_type[en]" placeholder="Fabric type">
                                </div>
                            </div>
                            <div id="french" x-show='currentPage == languages[1]'
                                class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">Titre de Prodruit</label>
                                    <input value="{{ old('product_name[fr]', $product->name->fr) }}"
                                        x-on:input="checkInfo.check_title[1] = true" type="text"
                                        name="product_name[fr]" class="bg-gray-50/80" placeholder="Titre">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Description</label>
                                    <textarea x-on:input="checkInfo.check_description[1] = true" name="product_description[fr]" class="bg-gray-50/80"
                                        placeholder="Description" id="" cols="30" rows="5">{{ old('product_description[fr]', $product->description->fr) }}</textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Tissu</label>
                                    <input value="{{ old('inventory_type[fr]', $product->inventories[0]->type->fr) }}"
                                        x-on:input="checkInfo.check_type[1] = true" type="text"
                                        name="inventory_type[fr]" placeholder="Type de tissu">
                                </div>
                            </div>
                            <div dir="rtl" id="arabic" x-show='currentPage == languages[2]'
                                class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">اسم المنتج</label>
                                    <input value="{{ old('product_name[ar]', $product->name->ar) }}"
                                        x-on:input="checkInfo.check_title[2] = true" type="text"
                                        name="product_name[ar]" class="bg-gray-50/80" placeholder="اسم ">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">وصف المنتج</label>
                                    <textarea x-on:input="checkInfo.check_description[2] = true" name="product_description[ar]" class="bg-gray-50/80"
                                        placeholder="وصف " id="" cols="30" rows="5">{{ old('product_description[ar]', $product->description->ar) }}</textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">القماش</label>
                                    <input value="{{ old('inventory_type[ar]', $product->inventories[0]->type->ar) }}"
                                        x-on:input="checkInfo.check_type[2] = true" type="text"
                                        name="inventory_type[ar]" placeholder="نوع القماش  ">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- variants --}}
                    <div id="Variants" x-show="steps[currentStep] === 'Variants'" x-data="{ colors: [] }"
                        class="py-4">
                        <div class="flex justify-between">
                            <h1 class="text-xl font-medium">Variants</h1>
                            <button type="button" x-on:click="colors.push({ id: Date.now(), hex:'', sizes: [] });"
                                class="bg-slate-100 py-2 px-4 rounded">+
                                Add Color</button>
                        </div>

                        <div class="flex flex-wrap gap-3 py-4">
                            @foreach ($product->inventories as $inventory)
                                @foreach ($inventory->variants as $variant)
                                    <div id="variant-{{ $variant->id }}"
                                        class="bg-alpha/10 border border-black/10 w-[30%] relative flex justify-between gap-3 rounded-sm p-3">
                                        <div class="flex flex-col gap-3">
                                            <div style="background-color: {{ $variant->color }};"
                                                class="w-[40px] h-[40px] rounded-full "></div>
                                            <div class="flex gap-4">
                                                @foreach ($variant->sizes as $size)
                                                    <div class="flex gap-1">
                                                        <p>{{ $size->size }}</p>
                                                        <p>({{ $size->quantity }})</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @php
                                            $firstImage = $variant->images->first();
                                        @endphp
                                        <div class="w-[70px] h-[70px]"><img class="w-full h-full object-contain"
                                                src="{{ asset('storage/images/' . $firstImage->path) }}"
                                                alt="">
                                        </div>
                                        <div
                                            class="hover:bg-red-500/50 absolute top-1 right-3 flex justify-center items-center rounded-md hover:text-white ">
                                            <button type="button" onclick="deleteVariant(this)"
                                                data-id="{{ $variant->id }}" class="bg-transparent">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5 cursor-pointer group-hover:text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <template x-for='(col, index) in colors' :key="col.id">
                            <div class="flex flex-col gap-3 bg-gray-50/80 rounded p-4 mt-3">
                                <div class="flex justify-between py-3 items-center">
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-ref="chooseColor"
                                            x-on:input='col.hex = $refs.chooseColor.value' name="color[]"
                                            value="" class="h-10">
                                        <span x-text="col.hex"></span>
                                    </div>
                                    <div class="hover:bg-slate-300/50 group flex justify-center items-center p-2 ">
                                        <button type="button" x-on:click="colors.splice(index, 1)"
                                            class="bg-transparent">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
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
                                        <button x-on:click="col.sizes.push({id: Date.now(), value: ''})"
                                            type="button" class="bg-beta px-4 py-2 rounded">+ Add
                                            Sizes</button>
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

                    {{-- pricing --}}
                    <div id="Pricing" x-show="steps[currentStep] === 'Pricing'" class="flex flex-col gap-3">
                        <h1 class="text-xl font-medium">
                            Pricing
                        </h1>
                        <div class="flex gap-5 justify-between items-center">
                            <div class="flex flex-col gap-3">
                                <label for="">Purchase price</label>
                                <input value="{{ old('prePrice', $product->inventories[0]->prePrice) }}" required
                                    class="input-number" class="bg-gray-50/80" type="number" name="prePrice"
                                    placeholder="Purchase">
                            </div>
                            <div class="flex flex-col gap-3">
                                <label for="">Sale Price</label>
                                <input value="{{ old('prePrice', $product->inventories[0]->postPrice) }}" required
                                    class="input-number" class="bg-gray-50/80" type="number" name="postPrice"
                                    placeholder="Sale">
                            </div>
                            <div class="flex flex-col gap-3">
                                <label for="">Old Price</label>
                                <input value="{{ old('prePrice', $product->inventories[0]->exPrice) }}" required
                                    class="input-number" class="bg-gray-50/80" type="number" name="ex_price"
                                    placeholder="Old">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-8 ">
                        <button type="button" x-on:click="currentStep > 0 ? currentStep -= 1 : '' "
                            class="bg-alpha/50 px-4 py-2 rounded font-medium">Previous</button>
                        <button type="" x-bind:type="currentStep === 3 ? 'submit' : 'button'"
                            x-on:click="currentStep <= 2 ? currentStep += 1 : null"
                            class="bg-alpha/50 px-4 py-2 rounded font-medium"
                            x-text="currentStep < 2 ? 'Next' : 'Update'">
                        </button>

                    </div>
                </div>
            </div>
    </form>

    <script>
        function deleteImage(button) {
            const id = button.getAttribute('data-id');
            const url = `/delete/image/${id}`;
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete the image.');
                    }
                    return response.json();
                })
                .then(data => {
                    const imageDiv = document.getElementById(`image-${id}`);
                    if (imageDiv) {
                        imageDiv.remove();
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        }
        // !!!!!!!!!!  !!!!!!!!!!  !!!!!!!!!!
        function deleteVariant(button) {
            const id = button.getAttribute('data-id');
            const url = `/delete/variant/${id}`;
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete the variant.');
                    }
                    return response.json();
                })
                .then(data => {
                    const cardDiv = document.getElementById(`variant-${id}`);
                    if (cardDiv) {
                        cardDiv.remove();
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        }

        function uploadImage(variantId) {
            // const variantId = document.getElementById('variantId').value; // Get variant_id from hidden input or any source
            const input = document.getElementById(`imageInput_${variantId}`);
            const file = input.files[0];
            if (!file) {
                alert('Please select an image.');
                return;
            }
            const formData = new FormData();
            formData.append('variant_id', variantId);
            formData.append('images', file);
            console.log(formData);

            fetch('/upload/image', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to upload image.');
                    }
                    return response.json();
                })
                .then(data => {

                    // Append the new image to the DOM
                    const imageContainer = document.getElementById('image-container');
                    const newImageDiv = document.createElement('div');
                    newImageDiv.id = `image-${data.id}`;
                    newImageDiv.className = 'relative w-32 h-32';
                    newImageDiv.innerHTML = `
                <img class="w-full h-full object-cover" src="/storage/images/${data.path}" alt="Uploaded Image">
            <div class="bg-white rounded group flex justify-center items-center p-1 absolute top-3 right-3">
                <button type="button" data-id="${data.id}" onclick="deleteImage(this)" class="bg-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 cursor-pointer group-hover:text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            `;
                    imageContainer.appendChild(newImageDiv);
                    input.value = "";
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
        }
    </script>

</x-app-layout>
