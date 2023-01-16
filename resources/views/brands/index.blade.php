<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Brands
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p4">
            {{-- Create Form --}}
            <div class="p-6" >
                <div class="flex gap-4">

                    {{-- Form Data --}}
                    <div class="flex flex-col justify-start items-center border rounded-md px-2">
                        <form action="{{ route('brands.store') }}" method="post" >
                            @csrf
                            <p class="font-semibold pb-6">Create New Brand</p>
                            <x-label for="title" value="Title"/>
                            <x-input id="title" type="text" name="title"  required minlength="3" :value="old('title')"/>
                            @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

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

@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush
@push('scripts')
<script>
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    const getMaster = @json(route('brands.master'));
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
            {title:"Title", field:"title", responsive:0},
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
