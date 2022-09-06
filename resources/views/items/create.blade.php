<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Item') }}
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
                            <form action="{{ route('items.store') }}" method="post" >
                            @csrf
                                <x-label for="iname" :value="__('Name')"/>
                                <x-input id="iname" class="bg-indigo-100" type="text" name="iname" :value="old('iname')"  required minlength="3"/>
                                @if($errors->has('iname'))<div class="text-red-500 text-xs">{{ $errors->first('iname') }}</div>@endif
                                
                                <x-label for="inname" :value="__('Knick Name')"/>
                                <x-input id="inname" class="bg-indigo-100" type="text" name="inname" :value="old('inname')"  required minlength="3"/>
                                @if($errors->has('inname'))<div class="text-red-500 text-xs">{{ $errors->first('inname') }}</div>@endif
    

                                <x-label for="" value="Category"/>
                                <select required name="category_id" class="bg-indigo-100 w-full" required>
                                    <option value="" selected>--Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->iname0 }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="ItemSize"/>
                                <select required name="item_size_id" class="bg-indigo-100 w-full" required>
                                    <option value="" selected>--ItemSize</option>
                                    @foreach ($itemsizes as $itemsize)
                                        <option value="{{ $itemsize->id }}">{{ $itemsize->sizename }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Source"/>
                                <select required name="source_id" class="bg-indigo-100 w-full" required>
                                    <option value="" selected>--Source</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->srcname }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Unit"/>
                                <select required name="unit_id" class="bg-indigo-100 w-full" required>
                                    <option value="" selected>--Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Brand"/>
                                <select required name="brand_id" class="bg-indigo-100 w-full" required>
                                    <option value="" selected>--brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brandname }}</option>
                                    @endforeach
                                </select>


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
                            <span class="text-indigo-500 border-b">Existing Items</span>
                            <ul class="h-28 overflow-y-scroll">
                                @foreach ($items as $item)
                                    <li>{{ $item->iname }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
