<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Copy Material
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

                            <input type="hidden" id="dimension" name="dimension" value="{{ $material->dimension }}">

                            <x-label for="title" :value="__('Name')"/>
                            <x-input class="" type="text" name="title" value="{{ $material->title }}"  required minlength="3"/>
                            @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

                            <x-label for="nick" :value="__('Knick Name')"/>
                            <x-input class="" type="text" name="nick" value="{{ $material->nick }}"  required minlength="3"/>
                            @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif


                            <x-label for="" value="Category"/>
                            <x-input class="" type="text"  name="category" value="{{ $material->category }}" disabled />
                            <input type="hidden" name="category_id" value="{{ $material->category_id }}">
                            <input type="hidden" name="category" value="{{ $material->category }}">

                            <x-label for="" value="dimension"/>
                            <select required id="dimension_id" name="dimension_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                @foreach ($dimensions as $dimension)
                                    @if ($material->dimension_id == $dimension->id)
                                        <option value="{{ $dimension->id }}" selected>{{ $dimension->title }}</option>
                                    @else
                                        <option value="{{ $dimension->id }}">{{ $dimension->title }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <x-label for="" value="Source"/>
                            <x-input class="" type="text"  name="source" value="{{ $material->source }}" disabled />
                            <input type="hidden" name="source_id" value="{{ $material->source_id }}">
                            <input type="hidden" name="source" value="{{ $material->source }}">

                            <x-label for="" value="Sku"/>
                            <x-input class="" type="text"  name="sku" value="{{ $material->sku }}" disabled />
                            <input type="hidden" name="sku_id" value="{{ $material->sku_id }}">
                            <input type="hidden" name="sku" value="{{ $material->sku }}">


                            <x-label for="" value="Brand"/>
                            <x-input class="" type="text"  name="brand" value="{{ $material->brand }}" disabled />
                            <input type="hidden" name="brand_id" value="{{ $material->brand_id }}">
                            <input type="hidden" name="brand" value="{{ $material->brand }}">

                            <x-label for="" value="hscode"/>
                            <x-input class="" type="text"   value="{{ $material->hscodes->hscode }}" disabled />
                                <input type="hidden" name="hscode_id" value="{{ $material->hscode_id }}">

                                <div >
                                    <x-label for="Qty(Kg)" value="Qty(Kg)"/>
                                    <x-input id="qtykg" class="bg-indigo-100" type="text" name="qtykg" :value="old('qtykg')"   />

                                    <x-label for="Cost(Kg)" value="Cost(Kg)"/>
                                    <x-input id="qtykgrt" class="bg-indigo-100" type="text" name="qtykgrt" :value="old('qtykgrt')"   />
                                </div>

                                <div >
                                    <x-label for="Qty(pcs)" value="Qty(pcs)"/>
                                    <x-input id="qtypcs" class="bg-indigo-100" type="text" name="qtypcs" :value="old('qtypcs')"   />

                                    <x-label for="Cost(pcs)" value="Cost(pcs)"/>
                                    <x-input id="qtypcsrt" class="bg-indigo-100" type="text" name="qtypcsrt" :value="old('qtypcsrt')"   />
                                </div>

                                <div >
                                    <x-label for="Qty(feet)" value="Qty(feet)"/>
                                    <x-input id="qtyfeet" class="bg-indigo-100" type="text" name="qtyfeet" :value="old('qtyfeet')"   />

                                    <x-label for="Cost(feet)" value="Cost(feet)"/>
                                    <x-input id="qtyfeetrt" class="bg-indigo-100" type="text" name="qtyfeetrt" :value="old('qtyfeetrt')"   />
                                </div>







                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="status"
                            @if ($material->status == 1)
                                checked
                            @endif
                            >
                            <label class="inline-block text-gray-800 mt-2">
                                Material Active?
                            </label>


                                <div class="mt-2">
                                    <button name="coypMaterial" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw"></i>
                                        Submit
                                    </button>
                                </div>

                            </form>
                        </div>

                        {{-- Listing --}}
                        <div class="ml-4 pt-1 border border-slate-300 w-full p-2">
                        <span class="text-indigo-500 border-b">Existing Materials</span>
                        <ul class="h-auto overflow-y-scroll">
                            {{-- @foreach ($materials as $material)
                                <li>{{ $material->title }} | {{ $material->dimension }}</li>
                            @endforeach --}}
                            <ul class="h-auto overflow-y-scroll">
                                @foreach ($materials as $material)
                                    <li>{{ $material->title }} | {{ $material->dimension }}</li>
                                @endforeach
                            </ul>
                        </ul>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@push('scripts')
<script>
    const dimension = document.getElementById('dimension')
    const dimension_id = document.getElementById('dimension_id')

    function getHiddenValues(el)
    {
        dimension.value = dimension_id.options[dimension_id.selectedIndex].innerText
    }
</script>
@endpush

</x-app-layout>
