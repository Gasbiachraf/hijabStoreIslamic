<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-lg font-bold">Our Blogs</h1>
                    <a href="{{ route('blog.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded">Create New Blog</a>
                </div>

                <!-- Blog List -->
                <div class="flex gap-4 flex-wrap">
                    @foreach ($blogs as $blog)
                        @include('Blogs.components.card')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
