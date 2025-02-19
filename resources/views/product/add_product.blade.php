<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <form x-data="{
        checkInfo: { check_category: false, check_subCategory: false, check_title: [false, false, false], check_description: [false, false, false], check_type: [false, false, false] },
        checkVariant: { check_color: false, check_image: false, check_size: [false, false] },
        isCompleteInfo() {
            // Check the boolean fields directly
            if (!this.checkInfo.check_category || !this.checkInfo.check_subCategory) {
                return false;
            }
            // Check if all array fields are true
            return this.checkInfo.check_title.every(Boolean) &&
                this.checkInfo.check_description.every(Boolean) &&
                this.checkInfo.check_type.every(Boolean);
        },
        isCompleteVariant() {
            // Check the boolean fields directly
            if (!this.checkVariant.check_color || !this.checkVariant.check_image) {
                return false;
            }
    
            // Check if all array fields are true
            return this.checkVariant.check_size.every(Boolean);
        },
        isStepComplete(step) {
            if (step === 0) {
                return this.isCompleteInfo();
            } else if (step === 1) {
                return this.isCompleteVariant();
            }
            return true; // Assuming step 2 doesn't need validation
        }
    
    }" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="infoContainer" x-data='{category:"", sub_category:"",}' class="p-[3vw] w-full gap-5 bg-teta rounded-lg">
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
                        <div x-data="{ cat: '', subCategorys: {{ json_encode($subCategories) }} }"
                            class="w-full bg--500 flex lg:flex-row flex-col gap-5 items-center">
                            <div class="lg:w-1/2 w-full flex flex-col gap-3 py-4">
                                <div class="flex w-full gap-2 items-center justify-between">
                                    <h1 class="font-medium">Category</h1>
                                    <button type="button" x-on:click.prevent="$dispatch('open-modal', 'add-category')"
                                        class="bg-alpha/50 px-4 rounded-lg py-2 cursor-pointer">+ Add New
                                        Category</button>
                                    <x-modal name="add-category" :show="$errors->userDeletion->isNotEmpty()">
                                        <div class="flex flex-col  gap-4">
                                            <label for="">Category Name</label>
                                            <input placeholder="name" x-ref='category_name' type="text"
                                                name="category_name">
                                            <button type="button"
                                                x-on:click.prevent='category=$refs.category_name.value; $dispatch("close-modal", "add-category")'
                                                class="px-3 py-2  bg-gamma rounded text-white w-fit">Submit</button>
                                        </div>
                                    </x-modal>
                                </div>

                                <select x-on:input="checkInfo.check_category = true" x-model="cat" name="category_id">
                                    <option value="" disabled selected>select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                    <template x-if=category>
                                        <option value="" x-text='category'></option>
                                    </template>
                                </select>
                            </div>
                            <div class="lg:w-1/2 w-full flex flex-col gap-3 py-4">
                                <div class="flex w-full gap-2 items-center justify-between">
                                    <h1>Sub Category</h1>
                                    <button type="button"
                                        x-on:click.prevent="$dispatch('open-modal', 'add-subcategory')"
                                        class="bg-alpha/50 px-4 rounded-lg py-2 cursor-pointer">+ Add New Sub
                                        Category</button>
                                    <x-modal name="add-subcategory" :show="$errors->userDeletion->isNotEmpty()">
                                        <div class="flex  flex-col gap-4 ">
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

                                {{-- @php
                                    $subCategory = Category::where('id','cat')->get();
                                @endphp --}}
                                <select x-on:input="checkInfo.check_subCategory = true" name="sub_category_id"
                                    id="">
                                    <option value="" selected disabled>select a Sub Category</option>
                                    <template x-for="subCategory in subCategorys" :key="subCategory.id">
                                        <template x-if="subCategory.category_id == cat">
                                            <option :value="subCategory.id" x-text="subCategory.name"></option>
                                        </template>
                                    </template>
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
                                        class="px-2 text-center rounded py-2 font-medium cursor-pointer"
                                        x-on:click='currentPage = language'
                                        x-text="language === 'en' ? 'English' : language === 'fr' ? 'Français' : 'العربية'"></span>
                                </template>
                            </div>
                            <div id="english" x-show='currentPage == languages[0]' class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Title</label>
                                    <input x-on:input="checkInfo.check_title[0] = true" type="text"
                                        name="product_name[en]" class="bg-gray-50/80" placeholder="Title">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Description</label>
                                    <textarea x-on:input="checkInfo.check_description[0] = true" name="product_description[en]" class="bg-gray-50/80"
                                        placeholder="Description" id="" cols="30" rows="5"></textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Fabric</label>
                                    <input x-on:input="checkInfo.check_type[0] = true" type="text"
                                        name="inventory_type[en]" placeholder="Fabric type">
                                </div>
                            </div>
                            <div id="french" x-show='currentPage == languages[1]' class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">Titre de Prodruit</label>
                                    <input x-on:input="checkInfo.check_title[1] = true" type="text"
                                        name="product_name[fr]" class="bg-gray-50/80" placeholder="Titre">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Product Description</label>
                                    <textarea x-on:input="checkInfo.check_description[1] = true" name="product_description[fr]" class="bg-gray-50/80"
                                        placeholder="Description" id="" cols="30" rows="5"></textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">Tissu</label>
                                    <input x-on:input="checkInfo.check_type[1] = true" type="text"
                                        name="inventory_type[fr]" placeholder="Type de tissu">
                                </div>
                            </div>
                            <div dir="rtl" id="arabic" x-show='currentPage == languages[2]'
                                class="flex flex-col gap-3 mt-4">
                                <div class="flex flex-col gap-3">
                                    <label for="">اسم المنتج</label>
                                    <input x-on:input="checkInfo.check_title[2] = true" type="text"
                                        name="product_name[ar]" class="bg-gray-50/80" placeholder="اسم ">
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">وصف المنتج</label>
                                    <textarea x-on:input="checkInfo.check_description[2] = true" name="product_description[ar]" class="bg-gray-50/80"
                                        placeholder="وصف " id="" cols="30" rows="5"></textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <label for="">القماش</label>
                                    <input x-on:input="checkInfo.check_type[2] = true" type="text"
                                        name="inventory_type[ar]" placeholder="نوع القماش  ">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- variants --}}
                    <div id="Variants" x-show="steps[currentStep] === 'Variants'" x-data="{ colors: [{ id: Date.now(), hex: '', sizes: [] }] }"
                        class="py-4">
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
                                            x-on:input='col.hex = $refs.chooseColor.value; checkVariant.check_color = true'
                                            name="color[]" value="" class="h-10">
                                        <span x-text="col.hex"></span>
                                    </div>
                                    <div class="hover:bg-slate-300/50 group  flex justify-center items-center p-2 ">
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
                                        <input id="picture" x-on:input="checkVariant.check_image = true"
                                            x-bind:name="`variant_images[${col.hex}][]`" multiple type="file"
                                            class="flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="flex justify-between">
                                        <p>Sizes</p>
                                        <button x-on:click="col.sizes.push({id: Date.now(), value: ''}); check"
                                            type="button" class="bg-beta px-4 py-2 rounded">+ Add
                                            Sizes</button>
                                    </div>
                                    <template class="flex flex-col gap-2" x-for="(size, i) in col.sizes"
                                        :key="size.id">
                                        <div class="flex justify-between mt-2 items-center">
                                            <div class="flex flex-col gap-2">
                                                <label
                                                    class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Size</label>
                                                <input type="text" x-on:input="checkVariant.check_size[0] = true"
                                                    x-model="size.value" x-bind:name="`size[${col.hex}_${i + 1}]`"
                                                    placeholder="XS-S-M-L-XL-XXl">
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label
                                                    class="text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Quantity</label>
                                                <input type="number" x-bind:name="`quantity[${col.hex}_${i + 1}]`"
                                                    class="input-number" placeholder="0"
                                                    x-on:input="checkVariant.check_size[1] = true">
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
                        <div class="flex lg:flex-row flex-col w-full gap-5 justify-between items-center">
                            <div class="flex flex-col w-full gap-3">
                                <label for="">Purchase price</label>
                                <input required class="input-number" class="bg-gray-50/80" type="number"
                                    name="prePrice" placeholder="Purchase">
                            </div>
                            <div class="flex flex-col w-full gap-3">
                                <label for="">Sale Price</label>
                                <input required class="input-number" class="bg-gray-50/80" type="number"
                                    name="postPrice" placeholder="Sale">
                            </div>
                            <div class="flex flex-col w-full gap-3">
                                <label for="">Old Price</label>
                                <input required class="input-number" class="bg-gray-50/80" type="number"
                                    name="ex_price" placeholder="Old">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-8 ">
                        <button type="button" x-on:click="currentStep > 0 ? currentStep -= 1 : '' "
                            class="bg-alpha/50 px-4 py-2 rounded font-medium">Previous</button>
                        <button x-bind:disabled="!isStepComplete(currentStep)" type=""
                            x-bind:type="currentStep === 2 ? 'submit' : 'button'"
                            x-on:click="currentStep < 2 ? currentStep +=  1 : '' "
                            class="bg-alpha/50 px-4 py-2 rounded font-medium"
                            x-text="currentStep < 2 ? 'Next' : 'Create' "></button>
                    </div>
                </div>
            </div>
    </form>

</x-app-layout>
