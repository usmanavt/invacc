<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hscodes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="p-6" >
                    <div class="flex gap-4">
                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('hscodes.store') }}" method="post" >
                                @csrf
                                <p class="font-semibold pb-6">Create New Acct Head</p>
                                <x-label for="hscode" value="Hscode Number"/>
                                <x-input id="hscode" type="text" name="hscode" :value="old('hscode')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('hscode'))<div class="text-red-500 text-xs">{{ $errors->first('hscode') }}</div>@endif

                                <x-label for="cd" value="CD"/>
                                <x-input id="cd" type="number" step="0.01" name="cd" :value="old('cd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('cd'))<div class="text-red-500 text-xs">{{ $errors->first('cd') }}</div>@endif

                                <x-label for="st" value="ST"/>
                                <x-input id="st" type="number" step="0.01" name="st" :value="old('st')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('st'))<div class="text-red-500 text-xs">{{ $errors->first('st') }}</div>@endif

                                <x-label for="rd" value="RD"/>
                                <x-input id="rd" type="number" step="0.01" name="rd" :value="old('rd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('rd'))<div class="text-red-500 text-xs">{{ $errors->first('rd') }}</div>@endif

                                <x-label for="acd" value="ACD"/>
                                <x-input id="acd" type="number" step="0.01" name="acd" :value="old('acd')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('acd'))<div class="text-red-500 text-xs">{{ $errors->first('acd') }}</div>@endif

                                <x-label for="ast" value="AST"/>
                                <x-input id="ast" type="number" step="0.01" name="ast" :value="old('ast')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('ast'))<div class="text-red-500 text-xs">{{ $errors->first('ast') }}</div>@endif

                                <x-label for="it" value="IT"/>
                                <x-input id="it" type="number" step="0.01" name="it" :value="old('it')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('it'))<div class="text-red-500 text-xs">{{ $errors->first('it') }}</div>@endif

                                <x-label for="wse" value="WSE"/>
                                <x-input id="wse" type="number" step="0.01" name="wse" :value="old('wse')"  required minlength="1" title="numeric input required"/>
                                @if($errors->has('wse'))<div class="text-red-500 text-xs">{{ $errors->first('wse') }}</div>@endif

                                <div class="mt-2">
                                    <x-button  id="submitButton">
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                </div>
                            </form>
                        </div>
                        {{-- Listing --}}
                        <div class="px-4 pb-14 border rounded-md w-full">
                            {{-- tabulator component --}}
                            <x-tabulator />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush
@push('scripts')
<script>
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    const getMaster = @json(route('hscodes.master'));
    let table;
    let searchValue = "";
    //  Table Filter
    function dataFilter(element)
    {
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue});
    }
    // The Table for Items Modal
    table = new Tabulator("#tableData", {
        autoResize:true,
        responsiveLayout:"collapse",
        layout:"fitData",
        index:"id",
        placeholder:"No Data Available",
        pagination:true,
        paginationMode:"remote",
        sortMode:"remote",
        filterMode:"remote",
        paginationSize:10,
        paginationSizeSelector:[10,25,50],
        ajaxParams: function(){
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0,visible:false},
            {title:"Hscode", field:"hscode", responsive:0},
            {title:"CD", field:"cd", responsive:0},
            {title:"ST", field:"st", responsive:0},
            {title:"RD", field:"rd", responsive:0},
            {title:"ACD", field:"acd", responsive:0},
            {title:"AST", field:"ast", responsive:0},
            {title:"IT", field:"it", responsive:0},
            {title:"WSE", field:"wse", responsive:0},
            {title:"Status", field:"status", responsive:0,
                formatter:function(cell){
                    return cell.getData().status === 1 ? '<span class="text-green-500">Active</span>':'<span class="text-gray-500">Deactive</span>'
                }
            },
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().id + "/edit" ,"_self");
            }},

        ],
        // Extra Pagination Data for End Users
        ajaxResponse:function(getDataUrl, params, response){
            remaining = response.total;
            let doc = document.getElementById("example-table-info");
            doc.classList.add('font-weight-bold');
            doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
            return response;
        },
    })
</script>
@endpush
</x-app-layout>
