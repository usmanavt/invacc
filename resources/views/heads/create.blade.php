<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Account Head') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-12 py-2" >
                    <div class="flex gap-8">
                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">

                        <form action="{{ route('heads.store') }}" method="post" >
                            @csrf
                              
                            <x-label for="title" value="Title"/>
                            <x-input id="title" class="bg-indigo-100" type="text" name="title" :value="old('title')"  required minlength="3"/>
                            @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

                            <x-label for="nature" value="Nature"/>
                            <select required name="nature" id="nature" class="bg-indigo-100">
                                <option value="" selected>--Source</option>
                                <option value="0" selected>0</option>
                                <option value="1" selected>1</option>
                            </select>

                   
                            <div class="mt-2">
                                <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-save fa-fw"></i>
                                    Submit
                                </button>
                            </div>

                        </form>
                    </div>

                    {{-- Listing --}}
                    <div class="ml-4 pt-1 border border-slate-300 w-full p-2">
                        <span class="text-indigo-500 border-b">Existing heads</span>
                        <ul class="h-28 overflow-y-scroll">
                            @foreach ($heads as $head)
                                <li>{{ $head->title }}</li>
                            @endforeach
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
