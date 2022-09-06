<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot>



    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-12 py-2" >
                    <div class="flex flex-col justify-start items-center">
                        <form action="{{route('items.update',$item)}}" method="post" >
                            @csrf
                            @method('PUT')
                                <x-label for="iname" :value="__('Item item')" class="w-24"/>
                                <x-input id="iname" class="bg-indigo-100" type="text" name="iname" value="{{$item->iname}}" />
                                @if($errors->has('iname'))<div class="text-red-500 text-xs">{{ $errors->first('iname') }}</div>@endif

                                <x-label for="inname" :value="__('Knick Name')" class="w-24"/>
                                <x-input id="inname" class="bg-indigo-100" type="text" name="inname" value="{{$item->inname}}" />
                                @if($errors->has('inname'))<div class="text-red-500 text-xs">{{ $errors->first('inname') }}</div>@endif

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
