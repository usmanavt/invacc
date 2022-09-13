<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Hscode
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >
                    
                    <div class="flex gap-8">
                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('hscodes.store') }}" method="post" >
                            @csrf
                                <x-label for="hscode" value="Hscode Number"/>
                                <x-input id="hscode" class="bg-indigo-100" type="text" name="hscode" :value="old('hscode')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('hscode'))<div class="text-red-500 text-xs">{{ $errors->first('hscode') }}</div>@endif
                                
                                <x-label for="cd" value="CD"/>
                                <x-input id="cd" class="bg-indigo-100" type="number" step="0.01" name="cd" :value="old('cd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('cd'))<div class="text-red-500 text-xs">{{ $errors->first('cd') }}</div>@endif
                                
                                <x-label for="st" value="ST"/>
                                <x-input id="st" class="bg-indigo-100" type="number" step="0.01" name="st" :value="old('st')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('st'))<div class="text-red-500 text-xs">{{ $errors->first('st') }}</div>@endif
                                
                                <x-label for="rd" value="RD"/>
                                <x-input id="rd" class="bg-indigo-100" type="number" step="0.01" name="rd" :value="old('rd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('rd'))<div class="text-red-500 text-xs">{{ $errors->first('rd') }}</div>@endif
                                
                                <x-label for="acd" value="ACD"/>
                                <x-input id="acd" class="bg-indigo-100" type="number" step="0.01" name="acd" :value="old('acd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('acd'))<div class="text-red-500 text-xs">{{ $errors->first('acd') }}</div>@endif
                                
                                <x-label for="ast" value="AST"/>
                                <x-input id="ast" class="bg-indigo-100" type="number" step="0.01" name="ast" :value="old('ast')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('ast'))<div class="text-red-500 text-xs">{{ $errors->first('ast') }}</div>@endif
                                
                                <x-label for="it" value="IT"/>
                                <x-input id="it" class="bg-indigo-100" type="number" step="0.01" name="it" :value="old('it')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('it'))<div class="text-red-500 text-xs">{{ $errors->first('it') }}</div>@endif
                                
                                <x-label for="wse" value="WSE"/>
                                <x-input id="wse" class="bg-indigo-100" type="number" step="0.01" name="wse" :value="old('wse')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('wse'))<div class="text-red-500 text-xs">{{ $errors->first('wse') }}</div>@endif

                                <div class="mt-2">
                                    <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw"></i>
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        {{-- Listing --}}
                        <div class="ml-4 pt-1 border border-slate-300 w-full p-2">
                            <span class="text-indigo-500 border-b">Existing Hscodes</span>
                            <ul class="h-28 overflow-y-scroll">
                                @foreach ($hscodes as $hscode)
                                    <li>{{ $hscode->hscode }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
