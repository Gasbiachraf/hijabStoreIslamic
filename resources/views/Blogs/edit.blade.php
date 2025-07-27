<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Blog') }}
        </h2>
    </x-slot>

    <!-- Include Quill Library -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">
                <section>
                    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Blog Title -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title', $blog->title) }}" required
                                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Blog Image -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Image</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500">

                            <!-- Preview Current Image -->
                            <div class="mt-2">
                                <img id="imagePreview" src="{{ asset('storage/images/' . $blog->image) }}"
                                    alt="Blog Image" class="w-40 h-40 object-cover rounded-md">
                                {{-- {{ dd($blog->image) }} --}}
                            </div>
                        </div>

                        <!-- Quill Editor -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Content</label>
                            <div id="editor" class="border border-gray-300 p-4"></div>
                            <input type="hidden" id="quill-content" name="description">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-blue-500 text-white p-2 text-sm rounded">Update Blog</button>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Set existing content after Quill initializes
        // let existingContent = {!! json_encode($blog->content) !!};
        let existingContent = {!! json_encode($blog->description) !!};

        // quill.root.innerHTML = existingContent;
        quill.root.innerHTML = existingContent || "";

        // Ensure hidden input is updated on text change
        document.querySelector("#quill-content").value = existingContent;
        quill.on('text-change', function() {
            document.querySelector("#quill-content").value = quill.root.innerHTML;
        });

        // Image Preview
        document.getElementById("image").addEventListener("change", function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById("imagePreview").src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

</x-app-layout>
