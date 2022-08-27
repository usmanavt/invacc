<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Location') }}
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
                <div class="px-12 py-2 " >

                    <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('locations.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a>

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ url('/location/update')."/".  $location->id   }} " method="post"  >
                        @csrf
                            <div class="flex flex-row justify-start space-x-6 items-center">
                                <div>
                                    <x-label for="locname" :value="__('Location Name')" />
                                    <x-input id="locname" class="block mt-2 bg-slate-200 w-96 " type="locname"  name="locname" value="{{$location->locname}}"  />
                                </div>
                            </div>
                            <div class="mt-4">
                                <div>
                                          <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
                                            >Address</label>
                                          <textarea  class=" form-control block w-full px-3 py-1.5 text-base font-normal  text-gray-700  bg-white bg-clip-padding  border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="locaddress" id="locaddress" rows="2" placeholder="">{{$location->locname}}</textarea>
                                        {{-- </div>
                                      </div> --}}
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

    <script>
        function getfocustxt()
        {
        document.getElementById(sname.focus());

        }

        </script>
</x-app-layout>
