<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            S u p p l i e r s
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('suppliers.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>

    {{-- Tabulator --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                {{-- tabulator component --}}
                <x-tabulator />

            </div>
        </div>
    </div>


@push('scripts')
<script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    var lockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-red-600'></i>";};
    var unlockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-green-600'></i>";};

     const getMaster = @json(route('suppliers.master'));
    // const getMaster = @json('suppliers.index');
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
        paginationSize:20,
        paginationSizeSelector:[10,25,50,100],
        ajaxParams: function(){
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Title", field:"title" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Address", field:"address" , visible:true , responsive:0},
            {title:"Source", field:"source.title" , visible:true , responsive:0},
            {title:"Email", field:"email" ,  responsive:0},
            {title:"NTN No", field:"ntn" ,  responsive:0},
            {title:"S.Tax Regis. No", field:"stax" ,  responsive:0},
            // {title:"Status", field:"status" ,  responsive:0,
            //     formatter:function(cell){
            //         if(cell.getData().status === 1)
            //         {
            //             table.hideColumn('unlock')
            //             table.showColumn('lock')
            //         }else{
            //             table.showColumn('unlock')
            //             table.hideColumn('lock')
            //         }
            //     return cell.getData().status === 1 ? 'Active':'Locked';
            // }},
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().id + "/edit" ,"_self");
            }},
            // {title:"Unlock",field:'unlock' , formatter:unlockIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e,cell){
            //         if(confirm('Do you really want to Unlock this Bank?'))
            //         {
            //             window.open(window.location + "/" + cell.getData().id  ,"_self");
            //         }
            //     }
            // },
            // {title:"Lock",field:'lock' , formatter:lockIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e,cell){
            //         if(confirm('Do you really want to Lock this Bank?'))
            //         {
            //             window.open(window.location + "/" + cell.getData().id  ,"_self");
            //         }
            //     }
            // }

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

