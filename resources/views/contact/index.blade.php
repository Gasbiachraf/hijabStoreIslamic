<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <div class="flex flex-col justify-center items-center p-4 md:p-10">
        <div class="w-full overflow-x-auto bg-white rounded-lg shadow-md p-4">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Message</th>
                        <th class="px-4 py-3">Received At</th>
                        <th class="px-4 py-3">Is red</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $message->id }}</td>
                            <td class="px-4 py-3">{{ $message->name }}</td>
                            <td class="px-4 py-3">{{ $message->email }}</td>
                            <td class="px-4 py-3 max-w-xs md:max-w-md lg:max-w-lg truncate">
                                <span title="{{ $message->message }}">
                                    {{ Str::limit($message->message, 50) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3">{{ $message->is_read }}</td>
                            <!-- Delete Button with Confirmation -->
                            <td>
                                <form action="{{ route('contacts.destroy', $message->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>


                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                No contact messages
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
