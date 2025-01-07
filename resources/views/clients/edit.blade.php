<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-[#f5f7fa] p-9  ">
        <div class="bg-[#f5f7fa] w-[50%]">
            <form class="flex flex-wrap gap-5" action="{{ route('clients.update', $client->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="flex flex-col gap-3 w-[40%] ">
                    <label for="Name">Full name</label>
                    <input name="name" value="{{ old('id',$client->name) }}" type="text" placeholder="Full Name" class="rounded-lg">
                </div>
                <div class="flex flex-col gap-3 w-[40%] ">
                    <label for="Name">GSM</label>
                    <input name="GSM" value="{{ old('GSM',$client->GSM) }}" type="text" placeholder="GSM" class="rounded-lg">
                </div>
                <div class="flex flex-col gap-3 w-[40%] ">
                    <label for="Name">Adress</label>
                    <input name="adress" value="{{ old('adress',$client->adress) }}" type="text" placeholder="Full Name" class="rounded-lg">
                </div>
                <div class="flex flex-col gap-3 w-[40%] ">
                    <label for="Name">Email</label>
                    <input name="email" value="{{ old('email',$client->email) }}" type="email" placeholder="Full Name" class="rounded-lg">
                </div>
                <button type="submit" class=" bg-blue-600 text-white rounded-md  w-[100px] p-3 hover:bg-blue-700 ">Add</button>
            </form>
        </div>
    </div>
</x-app-layout>
