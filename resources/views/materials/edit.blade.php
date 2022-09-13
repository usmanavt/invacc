<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Material
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
                            <form action="{{ route('materials.update',$material) }}" method="post" >
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="dimension" name="dimension" value="{{ $material->dimension }}">
                            <input type="hidden" id="category" name="category" value="{{ $material->category }}">
                            <input type="hidden" id="source" name="source" value="{{ $material->source }}">
                            <input type="hidden" id="brand" name="brand" value="{{ $material->brand }}">
                            <input type="hidden" id="sku" name="sku" value="{{ $material->sku }}">


                                <x-label for="title" :value="__('Name')"/>
                                <x-input class="bg-indigo-100" type="text" name="title" value="{{ $material->title }}"  required minlength="3"/>
                                @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif
                                
                                <x-label for="nick" :value="__('Knick Name')"/>
                                <x-input class="bg-indigo-100" type="text" name="nick" value="{{ $material->nick }}"  required minlength="3"/>
                                @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif
    

                                <x-label for="" value="Category"/>
                                <select required name="category_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($categories as $category)
                                        @if ($material->category_id == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="dimension"/>
                                <select required name="dimension_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($dimensions as $dimension)
                                        @if ($material->dimension_id == $dimension->id)
                                            <option value="{{ $dimension->id }}" selected>{{ $dimension->title }}</option>
                                        @else                                            
                                            <option value="{{ $dimension->id }}">{{ $dimension->title }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Source"/>
                                <select required name="source_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($sources as $source)
                                        @if ($material->source_id == $source->id)
                                            <option value="{{ $source->id }}" selected>{{ $source->title }}</option>
                                        @else
                                            <option value="{{ $source->id }}">{{ $source->title }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Sku"/>
                                <select required name="sku_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($skus as $sku)
                                        @if ($material->sku_id == $sku->id)
                                            <option value="{{ $sku->id }}" selected>{{ $sku->title }}</option>
                                        @else
                                            <option value="{{ $sku->id }}">{{ $sku->title }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="Brand"/>
                                <select required name="brand_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($brands as $brand)
                                    @if ($material->brand_id == $brand->id)
                                        <option value="{{ $brand->id }}" selected>{{ $brand->title }}</option>
                                    @else                                    
                                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                    @endif
                                    @endforeach
                                </select>

                                <x-label for="" value="hscode"/>
                                <select required name="hscode_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    @foreach ($hscodes as $hscode)
                                        @if ($material->hscode_id == $hscode->id)
                                            <option value="{{ $hscode->id }}" selected>{{ $hscode->hscode }}</option>
                                        @else                                            
                                            <option value="{{ $hscode->id }}">{{ $hscode->hscode }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status"
                                @if ($material->status == 1)
                                    checked
                                @endif
                            >
                            <label class="inline-block text-gray-800 mt-2">
                                Material Active?
                            </label>


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

@push('scripts')
<script>
    const category = document.getElementById('category')
        const source = document.getElementById('source')
        const brand = document.getElementById('brand')
        const dimension = document.getElementById('dimension')
        const sku = document.getElementById('sku')
        function getHiddenValues(el)
        {
            switch (el.name)
            {
                case 'category_id':
                    category.value = el.options[el.selectedIndex].innerText
                    break;
                case 'sku_id':
                    sku.value = el.options[el.selectedIndex].innerText
                    break;
                case 'brand_id':
                    brand.value = el.options[el.selectedIndex].innerText
                    break;
                case 'source_id':
                    source.value = el.options[el.selectedIndex].innerText
                    break;
                case 'dimension_id':
                    dimension.value = el.options[el.selectedIndex].innerText
                    break;
            }
            // var selectCategoryId = el.options[el.selectedIndex].value
        }
</script>
@endpush

</x-app-layout>
