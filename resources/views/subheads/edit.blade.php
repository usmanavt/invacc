<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Account Head
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

                        <form action="{{ route('subheads.update',$subhead) }}" method="post" >
                            @csrf
                            @method('PUT')
                            <x-label for="head_id" :value="__('Source')" />
                            <select autocomplete="on" required name="head_id" id="head_id" class="bg-indigo-100">
                                <option value="" selected>--Chart of Accounts</option>
                                @foreach($heads as $head)
                                    @if ($head->id == $subhead->head_id)
                                        <option value="{{$head->id}}" selected>{{$head->title}}</option>
                                    @else
                                        <option value="{{$head->id}}">{{$head->title}}</option>
                                    @endif
                                @endforeach
                            </select>

                            <x-label for="title" value="Title"/>
                            <x-input id="title" class="bg-indigo-100" type="text" name="title" value="{{ $subhead->title }}"  required minlength="3"/>
                            @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

                            <x-label for="ob" :value="__('O/Balance')"/>
                            <x-input id="ob" class="bg-indigo-100" type="text" name="ob" value="{{ $subhead->ob }}"  required minlength="3"/>
                            @if($errors->has('ob'))<div class="text-red-500 text-xs">{{ $errors->first('ob') }}</div>@endif

                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status"
                                @if ($subhead->status == 1)
                                    checked
                                @endif
                            >
                            <label class="inline-block text-gray-800 mt-2">
                                Sub Head Active?
                            </label>

                            <div class="mt-2">
                                <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-save fa-fw"></i>
                                    {{ __('Submit') }}
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
