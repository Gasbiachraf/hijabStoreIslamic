<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center min-h-screen bg-[#e9e8e4] p-6">
        <div class="w-full max-w-lg bg-white shadow-md rounded-lg p-8">
            <!-- Form Title -->
            <h3 class="text-xl font-semibold text-gray-700 mb-6">Add New Client</h3>

            <!-- Client Form -->
            <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="text-gray-600 text-sm font-medium">Full Name</label>
                    <input name="name" type="text" placeholder="Enter full name" 
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- GSM -->
                <div>
                    <label for="GSM" class="text-gray-600 text-sm font-medium">GSM</label>
                    <input name="GSM" type="number" placeholder="Enter GSM" 
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Address -->
                <div>
                    <label for="adress" class="text-gray-600 text-sm font-medium">Address</label>
                    <input name="adress" type="text" placeholder="Enter address" 
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="text-gray-600 text-sm font-medium">Email</label>
                    <input name="email" type="email" placeholder="Enter email" 
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition hover:bg-blue-700">
                        Add Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
