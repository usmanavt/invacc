<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Journal Vouchers
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('jv.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                        <div class="p-2 pb-2 border border-slate-300 w-full rounded-md">
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
    var lockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-red-600'></i>";};
    var unlockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-green-600'></i>";};

    const getMaster = @json(route('jv.master'));
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
        paginationSizeSelector:[10,25,50,100],
        ajaxParams: function(){
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",
        groupBy:'transaction',
        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0,visible:false},
            {title:"Transaction", field:"transaction" , responsive:0},
            {title:"Doc Date", field:"document_date" ,  responsive:0},
            {title:"Tran", field:"transaction_type" ,  responsive:0,
                formatter:function(cell){
                    return cell.getData().transaction_type === 'DEBIT'? '<span class="text-green-500">DEBIT</span>':'<span class="text-red-500">CREDIT</span>'
                    console.info(cell.getData())
                }},
            {title:"Head", field:"head_title" , visible:true , responsive:0 },
            {title:"Subhead", field:"subhead_title" , visible:true , responsive:0},
            // {title:"Supplier", field:"supplier_id" , visible:true , responsive:0},
            // {title:"Customer", field:"customer_id" , visible:true , responsive:0},
            {title:"JV#", field:"jvno",hozAlign:"right" ,  responsive:0},
            {title:"Amount Rs", field:"amount",hozAlign:"right" ,  responsive:0,formatter:"money",formatterParams:{thousand:",",precision:2}},
            {title:"Description", field:"description" ,  responsive:0},
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().transaction + "/edit" ,"_self");
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

