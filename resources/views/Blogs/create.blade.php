<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Blog') }}
        </h2>
    </x-slot>

    <!-- Include Quill Library -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">
                <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Blog Title -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" required
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Blog Image -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Image</label>
                        <input type="file" name="image" accept="image/*" required
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Quill Editor -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Content</label>
                        <div id="editor" class="border border-gray-300 p-4"></div>
                        <input type="hidden" id="quill-content" name="description">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white p-2 text-sm rounded">Save Blog</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', { theme: 'snow' });

        // Update hidden input on editor change
        quill.on('text-change', function() {
            document.querySelector("#quill-content").value = quill.root.innerHTML;
        });
    </script>
</x-app-layout>
