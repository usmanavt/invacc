<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Item
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
                            <form action="{{ route('items.update',$item) }}" method="post" >
                            @csrf
                            @method('PUT')
                                <x-label for="iname" :value="__('Name')"/>
                                <x-input class="bg-indigo-100" type="text" name="iname" value="{{ $item->iname }}"  required minlength="3"/>
                                @if($errors->has('iname'))<div class="text-red-500 text-xs">{{ $errors->first('iname') }}</div>@endif
                                
                                <x-label for="inname" :value="__('Knick Name')"/>
                                <x-input class="bg-indigo-100" type="text" name="inname" value="{{ $item->inname }}"  required minlength="3"/>
                                @if($errors->has('inname'))<div class="text-red-500 text-xs">{{ $errors->first('inname') }}</div>@endif
    

                                <x-label for="" value="Category"/>
                                <select required name="category_id" class="bg-indigo-100 w-full" required>
                                    @foreach ($categories as $category)
                                        @if ($item->category_id == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->iname0 }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->iname0 }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="ItemSize"/>
                                <select required name="item_size_id" class="bg-indigo-100 w-full" required>
                                    @foreach ($itemsizes as $itemsize)
                                        @if ($item->item_size_id == $itemsize->id)
                                            <option value="{{ $itemsize->id }}" selected>{{ $itemsize->sizename }}</option>
                                        @else                                            
                                            <option value="{{ $itemsize->id }}">{{ $itemsize->sizename }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Source"/>
                                <select required name="source_id" class="bg-indigo-100 w-full" required>
                                    @foreach ($sources as $source)
                                        @if ($item->source_id == $source->id)
                                            <option value="{{ $source->id }}" selected>{{ $source->srcname }}</option>
                                        @else
                                            <option value="{{ $source->id }}">{{ $source->srcname }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Unit"/>
                                <select required name="unit_id" class="bg-indigo-100 w-full" required>
                                    @foreach ($units as $unit)
                                        @if ($item->unit_id == $unit->id)
                                            <option value="{{ $unit->id }}" selected>{{ $unit->unitname }}</option>
                                        @else
                                            <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Brand"/>
                                <select required name="brand_id" class="bg-indigo-100 w-full" required>
                                    @foreach ($brands as $brand)
                                    @if ($item->brand_id == $brand->id)
                                        <option value="{{ $brand->id }}" selected>{{ $brand->brandname }}</option>
                                    @else                                    
                                        <option value="{{ $brand->id }}">{{ $brand->brandname }}</option>
                                    @endif
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
                        
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
