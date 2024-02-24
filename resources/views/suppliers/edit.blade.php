<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Supplier
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7x1 mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        <form action="{{ route('suppliers.update',$supplier) }}" method="post" >
                            @csrf
                            @method('PUT')
                            <div class="flex flex-col md:flex-row justify-start flex-wrap gap-2 items-center">
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="title" :value="__('Supplier title')" />
                                    <x-input id="title" class="bg-indigo-100" type="text" name="title" :value="$supplier->title"  />
                                    @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="nick" :value="__('Knick Name')" />
                                    <x-input id="nick" class="bg-indigo-100" type="text" name="nick" :value="$supplier->nick"  />
                                    @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="phoneoff" :value="__('Tel.(Office)')" />
                                    <x-input id="phoneoff" class="bg-indigo-100" type="text" name="phoneoff" :value="$supplier->phoneoff"/>
                                    @if($errors->has('phoneoff'))<div class="text-red-500 text-xs">{{ $errors->first('phoneoff') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="phoneres" :value="__('Tel.(Residence)')" />
                                    <x-input id="phoneres" class="bg-indigo-100" type="text" name="phoneres" :value="$supplier->phoneres"/>
                                    @if($errors->has('phoneres'))<div class="text-red-500 text-xs">{{ $errors->first('phoneres') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="fax" :value="__('Fax No')" />
                                    <x-input id="fax" class="bg-indigo-100" type="text" name="fax" :value="$supplier->fax"/>
                                    @if($errors->has('fax'))<div class="text-red-500 text-xs">{{ $errors->first('fax') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="email" :value="__('Email')" />
                                    <x-input id="email" class="bg-indigo-100" type="email" name="email" :value="$supplier->email"/>
                                    @if($errors->has('email'))<div class="text-red-500 text-xs">{{ $errors->first('email') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="ntn" :value="__('NTN No')" />
                                    <x-input id="ntn" class="bg-indigo-100" type="text" name="ntn" :value="$supplier->ntn"/>
                                    @if($errors->has('ntn'))<div class="text-red-500 text-xs">{{ $errors->first('ntn') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="stax" :value="__('Sale Tax Registration No')" />
                                    <x-input id="stax" class="bg-indigo-100" type="text" name="stax" :value="$supplier->stax"/>
                                    @if($errors->has('stax'))<div class="text-red-500 text-xs">{{ $errors->first('stax') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="obalance" :value="__('O/Balance')" />
                                    <x-input id="obalance" class="bg-indigo-100" type="text" name="obalance" :value="$supplier->obalance"/>
                                    @if($errors->has('obalance'))<div class="text-red-500 text-xs">{{ $errors->first('obalance') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="obalance" :value="__('O/Balance(USD)')" />
                                    <x-input id="obusd" class="bg-indigo-100" type="text" name="obusd" :value="$supplier->obusd"/>
                                    @if($errors->has('obusd'))<div class="text-red-500 text-xs">{{ $errors->first('obusd') }}</div>@endif
                                </div>






                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="source_id" :value="__('Source')" />
                                    <select autocomplete="on" required name="source_id" id="source_id" class="bg-indigo-100">
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}" @if ($supplier->source_id == $source->id)
                                                selected
                                            @endif>{{ $source->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="basis-0 md:basis-3/5">
                                    <x-label for="address" :value="__('Supplier Address')" />
                                    <x-input id="address" class="bg-indigo-100 w-full" type="text" name="address" :value="$supplier->address"/>
                                </div>

                                <div class="basis-0 md:basis-1/5 self-center pt-4">
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status" @if ($supplier->status == 1)
                                        checked
                                    @endif >
                                    <label class="inline-block text-gray-800">
                                        Supplier Active?
                                    </label>
                                </div>
                            </div>

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
