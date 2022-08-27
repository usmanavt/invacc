<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- Create Form --}}
                <div class="px-12 py-2 " ;>

                    <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('suppliers.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a>

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ url('/supplier/update')."/".  $supplier->id   }} "  method="post" >
                        @csrf
                            <div class="flex flex-row justify-start space-x-12 items-center">
                                {{-- <div>5------------------------------------8\7---788*-/*/
                                    1.12

                                    44<x-label for="scode" :value="__('Scode')" />
                                    <x-input id="scode" class="block mt-1 bg-slate-200" type="scode" name="scode" :value="old('scode')" required autofocus />
                                </div> --}}
                                <div>
                                    <x-label for="sname" :value="__('Supplier Name')" />
                                    <x-input id="sname" class="block mt-2 bg-slate-200 w-96" type="sname" name="sname" value="{{$supplier->sname}}"  />
                                </div>
                                <div>
                                    <x-label for="snname" :value="__('Knick Name')" />
                                    <x-input id="snname" class="block mt-2 bg-slate-200" type="snname" name="snname" value="{{$supplier->snname}}"   />
                                </div>

                                <div>
                                    <x-label for="sphoneoff" :value="__('Tel.(Office)')" />
                                    <x-input id="sphoneoff" class="block mt-2 bg-slate-200" type="sphoneoff" name="sphoneoff" value="{{$supplier->sphoneoff}}"   />
                                </div>
                                <div>
                                    <x-label for="sphoneres" :value="__('Tel.(Residence)')" />
                                    <x-input id="sphoneres" class="block mt-2 bg-slate-200" type="sphoneres" name="sphoneres" value="{{$supplier->sphoneres}}"   />
                                </div>
                            </div>

                            <div class="flex flex-row justify-between items-center mt-6">

                                <div>
                                    <x-label for="sfax" :value="__('Fax No')" />
                                    <x-input id="sfax" class="block mt-1 bg-slate-200 w-10" type="sfax" name="sfax" value="{{$supplier->sfax}}"   />
                                </div>
                            <div>
                                    <x-label for="semail" :value="__('Email')" />
                                    <x-input id="semail" class="block mt-1 bg-slate-200" type="semail" name="semail" value="{{$supplier->semail}}"    />
                                </div>

                                <div>
                                    <x-label for="ntnno" :value="__('NTN No')" />
                                    <x-input id="ntnno" class="block mt-1 bg-slate-200" type="ntnno" name="ntnno" value="{{$supplier->ntnno}}"   />
                                </div>
                                <div>
                                    <x-label for="staxNo" :value="__('Sale Tax Registration No')" />
                                    <x-input id="staxNo" class="block mt-1 bg-slate-200" type="staxNo" name="staxNo" value="{{$supplier->staxNo}}"   />
                                </div>
                                <div>
                                    <x-label for="obalance" :value="__('O/Balance')" />
                                    <x-input id="obalance" class="block mt-1 bg-slate-200" type="obalance" name="obalance" value="{{$supplier->obalance}}"   />
                                </div>
                            </div>

                            <div class="mt-4">
                                <div>
                                    {{-- <x-label for="spaddress" :value="__('Address')" />
                                    <x-input  id="spaddress" class="block mt-1 bg-slate-200 w-full" type="spaddress" name="spaddress" :value="old('spaddress')"   /> --}}

                                    {{-- <div class="flex justify-center">
                                        <div class="mb-3 xl:w-96"> --}}
                                          <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
                                            >Supplier Address</label>
                                          <textarea  class=" form-control block w-full px-3 py-1.5 text-base font-normal  text-gray-700  bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="spaddress" id="spaddress" rows="3" placeholder="">{{$supplier->spaddress}}</textarea>
                                        {{-- </div>
                                      </div> --}}



                                </div>
                            </div>



                            <div class="flex flex-row justify-start items-start mt-2">
                                {{-- <div>
                                    <x-label for="sstatus" :value="__('Active Stauts')" />
                                    <x-input id="sstatus" class="block mt-1 bg-slate-200" type="sstatus" name="sstatus" :value="old('sstatus')"  />
                                </div> --}}

                                <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Active" type="radio" name="sstatus" id="flexRadioDefault1" {{ ($supplier->sstatus=="Active")? "checked":"" }}>
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                      Active
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Stop" type="radio" name="sstatus" id="flexRadioDefault2" {{ ($supplier->sstatus=="Stop")? "checked":"" }} >
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                      Stop
                                    </label>
                                  </div>




                            </div>

                            <div class="mt-2">
                                <div>
                                    <x-label for="srcId" :value="__('Source')" />
                                    <select required name="srcId" id="srcId" class="block mt-1 bg-slate-200 text-sm rounded-lg">
                                        <option value="" disabled>Select Source</option>
                                        <option value="{{ Constants::LOCAL }}" {{ $supplier->srcId==1? 'selected':'' }}>{{ Constants::LOCAL_STRING }}</option>
                                        <option value="{{ Constants::IMPORTED }}" {{ $supplier->srcId==2? 'selected':'' }}>{{ Constants::IMPORTED_STRING }}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="mt-2">
                                <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-save fa-fw bg-green-900"></i>
                                    {{ __('Confirm') }}
                                </button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
