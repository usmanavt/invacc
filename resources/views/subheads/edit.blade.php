
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Subhead') }}
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

                    <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('subheads.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a>

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ url('/subhead/update')."/".$subhead->id }} " method="post" >
                        @csrf

                        <div class="mt-2">
                            <div>
                                <x-label for="mheadid" :value="__('Account Man Head')" />
                                <select required name="mheadid" id="mheadid" class="block mt-1 bg-slate-200 text-sm rounded-lg">
                                    <option value="" disabled >Select careof</option>
                                    @foreach($co as $list)
                                        <option value="{{$list->mid1}}"  {{ $list->mid1==$subhead->mheadid? 'selected':'' }}  > {{$list->mheadname}}   </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                            <div class="flex flex-row justify-start space-x-12 items-center mt-1">
                                <div>
                                    <x-label for="subheadname" :value="__('Subhead Name')" />
                                    <x-input id="subheadname" class="block  bg-slate-200 w-96" type="subheadname" name="subheadname" value="{{$subhead->subheadname}}"  />
                                </div>
                            </div>

                            <div class="flex flex-row justify-start space-x-12 items-center mt-2">
                            <div>
                                <x-label for="ob" :value="__('O/Balance')" />
                                <x-input id="ob" class="block  bg-slate-200" type="ob" name="ob" value="{{$subhead->ob}}"  />
                            </div>
                            </div>




                            <div class="flex flex-row justify-start items-start mt-2">
                                {{-- <div>
                                    <x-label for="sstatus" :value="__('Active Stauts')" />
                                    <x-input id="sstatus" class="block mt-1 bg-slate-200" type="sstatus" name="sstatus" :value="old('sstatus')"  />
                                </div> --}}

                                <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Active" type="radio" name="sstatus" id="flexRadioDefault1" {{ ($subhead->sstatus=="Active")? "checked":"" }}>
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                      Active
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" value="Stop" type="radio" name="sstatus" id="flexRadioDefault2" {{ ($subhead->sstatus=="Stop")? "checked":"" }} >
                                    <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                      Stop
                                    </label>
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

    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#mheadid').select2();
        })

        </script>
</x-app-layout>
