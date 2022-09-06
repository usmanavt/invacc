<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        <form action="{{ route('customers.update',$customer) }}" method="post" >
                            @csrf
                            @method('PUT')
                            <div class="flex flex-col md:flex-row justify-start flex-wrap gap-2 items-center">
                            
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cname" :value="__('Customer Name')" />
                                    <x-input id="cname" class="bg-indigo-100" type="text" name="cname" value="{{ $customer->cname }}"  required/>
                                    @if($errors->has('cname'))<div class="text-red-500 text-xs">{{ $errors->first('cname') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cnname" :value="__('Knick Name')" />
                                    <x-input id="cnname" class="bg-indigo-100" type="text" name="cnname" value="{{ $customer->cnname }}"  />
                                    @if($errors->has('cnname'))<div class="text-red-500 text-xs">{{ $errors->first('cnname') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cphoneoff" :value="__('Tel.(Office)')" />
                                    <x-input id="cphoneoff" class="bg-indigo-100" type="text" name="cphoneoff" value="{{ $customer->cphoneoff }}"  />
                                    @if($errors->has('cphoneoff'))<div class="text-red-500 text-xs">{{ $errors->first('cphoneoff') }}</div>@endif
                                </div>
                            
                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cphoneres" :value="__('Tel.(Residence)')" />
                                    <x-input id="cphoneres" class="bg-indigo-100" type="text" name="cphoneres" value="{{ $customer->cphoneres }}"  />
                                    @if($errors->has('cphoneres'))<div class="text-red-500 text-xs">{{ $errors->first('cphoneres') }}</div>@endif
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cfax" :value="__('Fax No')" />
                                    <x-input id="cfax" class="bg-indigo-100" type="text" name="cfax" value="{{ $customer->cfax }}"  />
                                    @if($errors->has('cfax'))<div class="text-red-500 text-xs">{{ $errors->first('cfax') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cemail" :value="__('Email')" />
                                    <x-input id="cemail" class="bg-indigo-100" type="text" name="cemail" value="{{ $customer->cemail }}" required/>
                                    @if($errors->has('cemail'))<div class="text-red-500 text-xs">{{ $errors->first('cemail') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="ntnno" :value="__('NTN No')" />
                                    <x-input id="ntnno" class="bg-indigo-100" type="text" name="ntnno" value="{{ $customer->ntnno }}"  />
                                    @if($errors->has('ntnno'))<div class="text-red-500 text-xs">{{ $errors->first('ntnno') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="staxno" :value="__('Sale Tax Registration No')" />
                                    <x-input id="staxno" class="bg-indigo-100" type="text" name="staxno" value="{{ $customer->staxno }}"  />
                                    @if($errors->has('staxno'))<div class="text-red-500 text-xs">{{ $errors->first('staxno') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="obalance" :value="__('O/Balance')" />
                                    <x-input id="obalance" class="bg-indigo-100" type="text" name="obalance" value="{{ $customer->obalance }}"  />
                                    @if($errors->has('obalance'))<div class="text-red-500 text-xs">{{ $errors->first('obalance') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-3/5">
                                    <x-label for="cpaddress" :value="__('Customer Address')" />
                                    <x-input id="cpaddress" class="bg-indigo-100 w-full" type="text" name="cpaddress" value="{{ $customer->cpaddress }}"  />
                                    @if($errors->has('cpaddress'))<div class="text-red-500 text-xs">{{ $errors->first('cpaddress') }}</div>@endif

                                </div>

                                <div class="basis-0 md:basis-1/5 self-center pt-4">
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="cstatus" 
                                    @if ($customer->cstatus == 'Active')
                                        checked
                                    @endif
                                    >
                                    <label class="inline-block text-gray-800">
                                        Customer Active?
                                    </label>
                                </div>

                                <div class="basis-0 md:basis-1/6">
                                    <x-label for="cop" :value="__('Care Of')" />
                                    <select required name="cop" id="cop" class="bg-indigo-100">
                                        <option value="" selected>--Care of</option>
                                        @foreach($careof as $list)
                                            @if ($customer->tbleco_id == $list->id) 
                                            <option value="{{$list->id}}" selected>{{$list->coname}}</option>    
                                            @else
                                            <option value="{{$list->id}}">{{$list->coname}}</option>    
                                            @endif  
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
