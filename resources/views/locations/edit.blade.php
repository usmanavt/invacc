<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Location') }}
        </h2>
    </x-slot>



    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-12 py-2" >
                    <div class="flex flex-col justify-start items-center">
                        <form action="{{route('locations.update',$location)}}" method="post" >
                            @csrf
                            @method('PUT')
                                <x-label for="locname" :value="__('Item Category')" class="w-24"/>
                                <x-input id="locname" class="bg-indigo-100" type="text" name="locname" value="{{$location->locname}}" />
                                @if($errors->has('locname'))<div class="text-red-500 text-xs">{{ $errors->first('locname') }}</div>@endif

                                <x-label for="locaddress" :value="__('Knick Name')" class="w-24"/>
                                <x-input id="locaddress" class="bg-indigo-100" type="text" name="locaddress" value="{{$location->locaddress}}" />
                                @if($errors->has('locaddress'))<div class="text-red-500 text-xs">{{ $errors->first('locaddress') }}</div>@endif

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
