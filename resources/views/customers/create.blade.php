<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Customer') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        <form action="{{ route('customers.store') }}" method="post" >
                            @csrf

                            <div class="flex flex-col md:flex-row justify-start flex-wrap gap-2 items-center">
                            
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="title" :value="__('Customer title')" />
                                    <x-input id="title" class="bg-indigo-100" type="text" title="title" :value="old('title')"  required/>
                                    @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="nick" :value="__('Knick Name')" />
                                    <x-input id="nick" class="bg-indigo-100" type="text" name="nick" :value="old('nick')"  />
                                    @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="phoneoff" :value="__('Tel.(Office)')" />
                                    <x-input id="phoneoff" class="bg-indigo-100" type="text" name="phoneoff" :value="old('phoneoff')"  />
                                    @if($errors->has('phoneoff'))<div class="text-red-500 text-xs">{{ $errors->first('phoneoff') }}</div>@endif
                                </div>
                            
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="phoneres" :value="__('Tel.(Residence)')" />
                                    <x-input id="phoneres" class="bg-indigo-100" type="text" name="phoneres" :value="old('phoneres')"  />
                                    @if($errors->has('phoneres'))<div class="text-red-500 text-xs">{{ $errors->first('phoneres') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="fax" :value="__('Fax No')" />
                                    <x-input id="fax" class="bg-indigo-100" type="text" name="fax" :value="old('fax')"  />
                                    @if($errors->has('fax'))<div class="text-red-500 text-xs">{{ $errors->first('fax') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="email" :value="__('Email')" />
                                    <x-input id="email" class="bg-indigo-100" type="text" name="email" :value="old('email')" />
                                    @if($errors->has('email'))<div class="text-red-500 text-xs">{{ $errors->first('email') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="ntn" :value="__('NTN No')" />
                                    <x-input id="ntn" class="bg-indigo-100" type="text" name="ntn" :value="old('ntn')"  />
                                    @if($errors->has('ntn'))<div class="text-red-500 text-xs">{{ $errors->first('ntn') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="stax" :value="__('Sale Tax Registration No')" />
                                    <x-input id="stax" class="bg-indigo-100" type="text" name="stax" :value="old('stax')"  />
                                    @if($errors->has('stax'))<div class="text-red-500 text-xs">{{ $errors->first('stax') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="obalance" :value="__('O/Balance')" />
                                    <x-input id="obalance" class="bg-indigo-100" type="text" name="obalance" :value="old('obalance')"  />
                                    @if($errors->has('obalance'))<div class="text-red-500 text-xs">{{ $errors->first('obalance') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-3/5">
                                    <x-label for="address2" :value="__('Customer Address')" />
                                    <x-input id="address2" class="bg-indigo-100 w-full" type="text" name="address2" :value="old('address2')"  />
                                    @if($errors->has('address2'))<div class="text-red-500 text-xs">{{ $errors->first('address2') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/5 self-center pt-4">
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status" checked>
                                    <label class="inline-block text-gray-800">
                                        Customer Active?
                                    </label>
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="care_id" :value="__('Source')" />
                                    <select required name="care_id" id="care_id" class="bg-indigo-100">
                                        <option value="" selected>--Care of</option>
                                        @foreach($care as $list)
                                        <option value="{{$list->id}}" >{{$list->title}}</option>
                                        @endforeach
                                    </select>
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
