<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Supplier') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >
                    <div class="flex gap-8">
                        
                        <form action="{{ route('suppliers.store') }}" method="post" >
                            @csrf
                            <div class="flex flex-col md:flex-row justify-start flex-wrap gap-2 items-center">
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="sname" :value="__('Supplier Name')" />
                                    <x-input id="sname" class="bg-indigo-100" type="text" name="sname" :value="old('sname')"  />
                                    @if($errors->has('sname'))<div class="text-red-500 text-xs">{{ $errors->first('sname') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="snname" :value="__('Knick Name')" />
                                    <x-input id="snname" class="bg-indigo-100" type="text" name="snname" :value="old('snname')"  />
                                    @if($errors->has('snname'))<div class="text-red-500 text-xs">{{ $errors->first('snname') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="sphoneoff" :value="__('Tel.(Office)')" />
                                    <x-input id="sphoneoff" class="bg-indigo-100" type="text" name="sphoneoff" :value="old('sphoneoff')"  />
                                    @if($errors->has('sphoneoff'))<div class="text-red-500 text-xs">{{ $errors->first('sphoneoff') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="sphoneres" :value="__('Tel.(Residence)')" />
                                    <x-input id="sphoneres" class="bg-indigo-100" type="text" name="sphoneres" :value="old('sphoneres')"  />
                                    @if($errors->has('sphoneres'))<div class="text-red-500 text-xs">{{ $errors->first('sphoneres') }}</div>@endif
                                </div>
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="sfax" :value="__('Fax No')" />
                                    <x-input id="sfax" class="bg-indigo-100" type="text" name="sfax" :value="old('sfax')"  />
                                    @if($errors->has('sfax'))<div class="text-red-500 text-xs">{{ $errors->first('sfax') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="semail" :value="__('Email')" />
                                    <x-input id="semail" class="bg-indigo-100" type="email" name="semail" :value="old('semail')"   />
                                    @if($errors->has('semail'))<div class="text-red-500 text-xs">{{ $errors->first('semail') }}</div>@endif
                                </div>
        
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="ntnno" :value="__('NTN No')" />
                                    <x-input id="ntnno" class="bg-indigo-100" type="text" name="ntnno" :value="old('ntnno')"  />
                                    @if($errors->has('ntnno'))<div class="text-red-500 text-xs">{{ $errors->first('ntnno') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="staxNo" :value="__('Sale Tax Registration No')" />
                                    <x-input id="staxNo" class="bg-indigo-100" type="text" name="staxNo" :value="old('staxNo')"  />
                                    @if($errors->has('staxNo'))<div class="text-red-500 text-xs">{{ $errors->first('staxNo') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="obalance" :value="__('O/Balance')" />
                                    <x-input id="obalance" class="bg-indigo-100" type="text" name="obalance" :value="old('obalance')"  />
                                    @if($errors->has('obalance'))<div class="text-red-500 text-xs">{{ $errors->first('obalance') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="srcId" :value="__('Source')" />
                                    <select required name="srcId" id="srcId" class="bg-indigo-100">
                                        <option value="" selected>--Source</option>
                                        <option value="{{ Constants::LOCAL }}">{{ Constants::LOCAL_STRING }}</option>
                                        <option value="{{ Constants::IMPORTED }}">{{ Constants::IMPORTED_STRING }}</option>
                                    </select>
                                </div>   

                                <div class="basis-0 md:basis-3/5">
                                    <x-label for="spaddress" :value="__('Supplier Address')" />
                                    <x-input id="spaddress" class="bg-indigo-100 w-full" type="text" name="spaddress" :value="old('spaddress')"  />
                                </div>

                                <div class="basis-0 md:basis-1/5 self-center pt-4">
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="sstatus" checked>
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
