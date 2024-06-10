
<x-app-layout>


{{-- @include('layouts.auth') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create User
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-2xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >

                    <div class="flex gap-8">
                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('users.store') }}" method="post" >
                            @csrf
                                <x-label for="name" value="Name"/>
                                <x-input id="name" class="bg-indigo-100" type="text" name="name" :value="old('name')"  required minlength="3"/>
                                @if($errors->has('name'))<div class="text-red-500 text-xs">{{ $errors->first('name') }}</div>@endif

                                <x-label for="email" value="Email"/>
                                <x-input id="email" class="bg-indigo-100" type="email" name="email" :value="old('email')"  required />
                                @if($errors->has('email'))<div class="text-red-500 text-xs">{{ $errors->first('email') }}</div>@endif

                                <fieldset class="border rounded my-2 py-2 px-2">
                                    <legend>Password Setup</legend>

                                    <x-label for="password" value="Password"/>
                                    <x-input id="password" class="bg-indigo-100" type="password" name="password" :value="old('password')"  required />
                                    @if($errors->has('password'))<div class="text-red-500 text-xs">{{ $errors->first('password') }}</div>@endif

                                    <x-label for="password_confirmation" value="Confirm Password"/>
                                    <x-input id="password_confirmation" class="bg-indigo-100" type="password" name="password_confirmation" :value="old('password_confirmation')"  required />
                                    @if($errors->has('password_confirmation'))<div class="text-red-500 text-xs">{{ $errors->first('password_confirmation') }}</div>@endif

                                </fieldset>

                                <div class="mt-2">
                                    <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw"></i>
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
