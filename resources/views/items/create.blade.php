<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Item') }}
        </h2>
    </x-slot>



    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- Create Form --}}
                <div class="px-12 py-2" >


                    <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('items.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a>

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ route('items.store') }}" method="post" >
                        @csrf
                                <div class="flex flex-row justify-start space-x-12 items-center">
                                    <x-label for="Iname" :value="__('Item ')" />
                                    <x-input id="iname" class="block mt-2 bg-slate-200 w-96" type="iname" name="iname" :value="old('iname')"  />
                                </div>
                                <div class="flex flex-row justify-start space-x-12 items-center">
                                    <x-label for="inname" :value="__('Knick Name')" />
                                    <x-input id="inname" class="block mt-2 bg-slate-200" type="inname" name="inname" :value="old('inname')"  />
                                </div>

                            <div class="mt-2">
                                <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-save fa-fw bg-green-900"></i>
                                    {{ __('Submit') }}
                                </button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
