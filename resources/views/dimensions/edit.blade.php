<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Dimension
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-12 py-2" >
                    <div class="flex flex-col justify-start items-center">
                        <form action="{{route('dimensions.update',$dimension)}}" method="post" >
                            @csrf
                            @method('PUT')
                                <x-label for="title" value="Title" class="w-40"/>
                                <x-input id="title" class="bg-indigo-100" type="text" name="title" value="{{$dimension->title}}" />
                                @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status" @if ($dimension->status == 1)
                                        checked
                                @endif >
                                <label class="inline-block text-gray-800">
                                    Dimension Active?
                                </label>

                                <div class="mt-2">
                                    <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw"></i>
                                        {{ __('Confirm') }}
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
