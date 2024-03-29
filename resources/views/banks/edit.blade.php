<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Bank
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2" >

                    <div class="flex gap-8">
                        {{-- Form Data --}}
                        <div class="flex flex-col items-center">
                            <form action="{{ route('banks.update',$bank) }}" method="post" class="flex flex-col">
                                @method('PUT')
                                @csrf
                                <x-input-text title="Title" name="title" value="{{ $bank->title }}" req required class=""/>
                                <x-input-text title="Nick" name="nick" value="{{ $bank->nick }}" req required class=""/>
                                <x-input-text title="Account #" name="account_no" value="{{ $bank->account_no }}" req required class=""/>
                                <x-input-text title="Branch" name="branch" value="{{ $bank->branch }}" req required class=""/>
                                <x-input-numeric title="Balance" name="balance" value="{{ $bank->balance }}"  req required class=""/>

                                <div class="flex flex-col">
                                    <label for="">
                                        Address <span class="text-red-500 font-semibold">(*)</span>
                                    </label>
                                    <textarea name="address" id="address" cols="30" rows="10" required class="rounded">{{ $bank->address }}</textarea>
                                </div>


                                <div class="mt-2">
                                    <x-button>
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
