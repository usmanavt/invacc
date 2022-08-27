<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Group Relation') }}
        </h2>
    </x-slot>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- Create Form --}}
                <div class="px-12 py-2" >


                    <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('grouprelations.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a>

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ route('grouprelations.store') }}" method="post" >
                        @csrf
                            <div class="flex flex-row justify-start space-x-12 items-center mt-2">

                                {{-- <div class="mt-2"> --}}
                                    <div>
                                        <x-label for="itmid0" :value="__('Category')" />
                                        <select required name="itmid0" id="itmid0" class="block  bg-slate-200 text-sm rounded-lg ">
                                            <option value="" disabled >Category</option>
                                            @foreach($grpdta as $grplist)
                                                <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>
                                             @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <x-label for="itmid" :value="__('Item')" />
                                        <select required name="itmid" id="itmid" class="block  bg-slate-200 text-sm rounded-lg ">
                                            <option value="" disabled >Item</option>
                                            @foreach($itmdta as $itmlist)
                                                <option value="{{$itmlist->itmid}}" >  {{$itmlist->itmname}}  </option>
                                             @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <x-label for="itmsizeid" :value="__('Item Size')" />
                                        <select required name="itmsizeid" id="itmsizeid" class="block  bg-slate-200 text-sm rounded-lg ">
                                            <option value="" disabled >Item Size</option>
                                            @foreach($szedta as $szelist)
                                                <option value="{{$szelist->szeid}}" >  {{$szelist->szename}}  </option>
                                             @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-start space-x-12 items-center mt-4">
                                        <div>
                                            <x-label for="srcid" :value="__('Source')" />
                                            <select required name="srcid" id="srcid" class="block  bg-slate-200 text-sm rounded-lg ">
                                                <option value="" disabled >Source</option>
                                                @foreach($srcdta as $srclist)
                                                    <option value="{{$srclist->sid}}" >  {{$srclist->sname}}  </option>
                                                 @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <x-label for="brandid" :value="__('Brand')" />
                                            <select required name="brandid" id="brandid" class="block  bg-slate-200 text-sm rounded-lg ">
                                                <option value="" disabled >Source</option>
                                                @foreach($brddta as $brdlist)
                                                    <option value="{{$brdlist->bid}}" >  {{$brdlist->bname}}  </option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <x-label for="purunitid" :value="__('Purchase Unit')" />
                                            <select required name="purunitid" id="purunitid" class="block  bg-slate-200 text-sm rounded-lg ">
                                                <option value="" disabled >Unit</option>
                                                @foreach($untdta as $untlist)
                                                    <option value="{{$untlist->uid}}" >  {{$untlist->uname}}  </option>
                                                 @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <x-label for="locid" :value="__('Storage Location')" />
                                            <select required name="locid" id="locid" class="block  bg-slate-200 text-sm rounded-lg ">
                                                <option value="" disabled >Unit</option>
                                                @foreach($locdta as $loclist)
                                                    <option value="{{$loclist->lid}}" >  {{$loclist->lname}}  </option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>

                            <div class="flex flex-row justify-start space-x-12 items-center mt-6">
                                <div>
                                    <x-label for="obqty" :value="__('O/Balance')" />
                                    <x-input id="obqty" class="block  bg-slate-200 w-96" type="obqty" name="obqty" :value="old('obqty')"  />
                                </div>
                                <div>
                                    <x-label for="purrate" :value="__('Purchase Rate')" />
                                    <x-input id="purrate" class="block  bg-slate-200" type="purrate" name="purrate" :value="old('purrate')"  />
                                </div>

                                <div>
                                    <x-label for="costrate" :value="__('Cost Rate')" />
                                    <x-input id="costrate" class="block  bg-slate-200" type="costrate" name="costrate" :value="old('costrate')"  />
                                </div>
                            </div>



                                <div class="flex flex-row justify-start space-x-12 items-center mt-8">
                                    <div class="form-check">
                                        <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Active" type="radio" name="sstatus" id="flexRadioDefault1" checked>
                                        <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                        Active
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Stop" type="radio" name="sstatus" id="flexRadioDefault2" >
                                        <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                        Stop
                                        </label>
                                    </div>
                                    <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw bg-green-900"></i>
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#mheadid').select2();
        })

    </script>

</x-app-layout>
