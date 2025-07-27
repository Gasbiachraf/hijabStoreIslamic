<div class="bg-gray-100 p-4 rounded shadow-md w-80">
    <img src="{{ asset('storage/images/' . $blog->image) }}" alt="Blog Image"
        class="w-full h-40 object-cover rounded">
    {{-- @dump($blog->image). --}}
    <h2 class="text-lg font-semibold mt-2">{{ $blog->title }}</h2>
    <p class="text-sm text-gray-600 mt-1">{!! Str::limit($blog->description, 100) !!}</p>

    <div class="mt-4 flex justify-between items-center">
        <!-- Edit Button -->
        <a href="{{ route('blog.edit', $blog->id) }}" class="bg-yellow-500 text-white px-3 py-1 text-sm rounded">Edit</a>

        <!-- Delete Form -->
        @if (auth()->user()->role === 'admin')
            <form action="{{ route('blog.delete', $blog->id) }}" method="POST"
                onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-3 py-1 text-sm rounded">Delete</button>
            </form>
        @endif
    </div>
</div>
