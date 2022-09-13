<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Material
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
                            <form action="{{ route('materials.store') }}" method="post" >
                            @csrf

                            <input type="hidden" id="dimension" name="dimension" value="">
                            <input type="hidden" id="category" name="category" value="">
                            <input type="hidden" id="source" name="source" value="">
                            <input type="hidden" id="brand" name="brand" value="">
                            <input type="hidden" id="sku" name="sku" value="">


                                <x-label for="title" value="Title"/>
                                <x-input id="title" class="bg-indigo-100" type="text" name="title" :value="old('title')"  required minlength="3"/>
                                @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif
                                
                                <x-label for="nick" value="Nick"/>
                                <x-input id="nick" class="bg-indigo-100" type="text" name="nick" :value="old('nick')"  required minlength="3"/>
                                @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif
    

                                <x-label for="" value="Category"/>
                                <select required name="category_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Dimension"/>
                                <select required name="dimension_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Dimension</option>
                                    @foreach ($dimensions as $dimension)
                                        <option value="{{ $dimension->id }}">{{ $dimension->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Source"/>
                                <select required name="source_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Source</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Sku"/>
                                <select required name="sku_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Sku</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->id }}">{{ $sku->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Brand"/>
                                <select required name="brand_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
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
                            <span class="text-indigo-500 border-b">Existing Materials</span>
                            <ul class="h-28 overflow-y-scroll">
                                @foreach ($materials as $material)
                                    <li>{{ $material->title }} | {{ $material->dimension }}</li>
                                @endforeach
                            </ul>
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
        }
    </script>
    @endpush

</x-app-layout>
