<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Commercial Invoices
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('cis.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>

    {{-- Tabulator --}}
    <div class="py-6">
        <div class="max-w-9xl mx-auto sm:px-2 lg:px-4">
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
    var hideIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-eye text-green-600'></i>";};
    var viewIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-binoculars text-purple-600'></i>";};
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    var deleteIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-trash text-red-600'></i>";};
    var printIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-print text-pink-500'></i>";};

    const getMaster = @json(route('cis.master'));
    const getDetails = @json(route('cis.details'));
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
        initialSort:[ {column:"invoiceno", dir:"desc"} ],
        height:"100%",

        columns:[
            //  Detail Data
            {formatter:hideIcon, hozAlign:"center", title:"Details",headerSort:false, cellClick:function(e, row, formatterParams){
                let tableHolder = document.getElementById("subTable" + row.getData().id + "");
                tableHolder.classList.toggle('hide-subtable');
                var r = row.getElement() //  Get Info About Cell
                if(tableHolder.classList.contains('hide-subtable'))
                {
                    r.childNodes[0].classList.remove('fa-eye-slash','text-gray-500')
                    r.childNodes[0].classList.add('fa-eye','text-gray-400')
                }
                else {
                    r.childNodes[0].classList.add('fa-eye-slash','text-gray-500')
                    r.childNodes[0].classList.remove('fa-eye','text-gray-400')
                }
                subTable = new Tabulator(tableHolder, {
                    layout:"fitData",                       //fit columns to width of table
                    responsiveLayout:"collapse",            //hide columns that dont fit on the table
                    index:'id',                             //Table Row Id
                    placeholder:"No Data Available",        //Placeholder text for empty table
                    // Pagination
                    pagination:"remote",                    //paginate the data
                    paginationSize:10,                      //starting page size
                    paginationSizeSelector:[10,25,50,100],  //  Page Size Selector
                    ajaxParams: function(){
                        return {id:row.getData().id};
                    },
                    ajaxURL: getDetails,
                    columns: [
                        {title: "material_id",field: "material_id"},
                        {title: "pcs",field: "pcs"},
                        {title: "gdswt",field: "gdswt"},
                        {title: "inkg",field: "inkg"},
                        {title: "gdsprice",field: "gdsprice"},
                        {title: "amtindollar",field: "amtindollar"},
                        {title: "amtinpkr",field: "amtinpkr"},
                        {title: "lenght",field: "lenght"},
                        {title: "itmratio",field: "itmratio"},
                        {title: "insuranceperitem",field: "insuranceperitem"},
                        {title: "amountwithoutinsurance",field: "amountwithoutinsurance"},
                        {title: "onepercentdutypkr",field: "onepercentdutypkr"},
                        {title: "pricevaluecostsheet",field: "pricevaluecostsheet"},
                        {title: "cda",field: "cda"},
                        {title: "sta",field: "sta"},
                        {title: "rda",field: "rda"},
                        {title: "acda",field: "acda"},
                        {title: "asta",field: "asta"},
                        {title: "ita",field: "ita"},
                        {title: "wsca",field: "wsca"},
                        {title: "total",field: "total"},
                        {title: "perpc",field: "perpc"},
                        {title: "perkg",field: "perkg"},
                        {title: "perft",field: "perft"},

                    ],
                    ajaxResponse:function(getDetails, params, response){
                        return response.data;
                    },
                })}
            },
            // Master Data
            {title: "id",field: "id"},
            {title: "Dated",field: "created_at"},
            {title: "Inv Dt",field: "invoice_date"},
            {title: "Invoice#",field: "invoiceno"},
            {title: "Challan#",field: "challanno"},
            {title: "conversionrate",field: "conversionrate"},
            {title: "insurance",field: "insurance"},
            {title: "bankcharges",field: "bankcharges"},
            {title: "collofcustom",field: "collofcustom"},
            {title: "exataxoffie",field: "exataxoffie"},
            {title: "lngnshipdochrgs",field: "lngnshipdochrgs"},
            {title: "localcartage",field: "localcartage"},
            {title: "miscexplunchetc",field: "miscexplunchetc"},
            {title: "customsepoy",field: "customsepoy"},
            {title: "weighbridge",field: "weighbridge"},
            {title: "miscexpenses",field: "miscexpenses"},
            {title: "agencychrgs",field: "agencychrgs"},
            {title: "otherchrgs",field: "otherchrgs"},
            {title: "Total",field: "total"},
            {title:"View" , formatter:viewIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
                }
            },
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id + "/edit" ,"_self");
                }
            },
            {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
                }
            },
            {title:"Print" , formatter:printIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id + "/printcontract"  ,"_self");
                }
            },
        ],
        // Extra Pagination Data for End Users
        ajaxResponse:function(getDataUrl, params, response){
            remaining = response.total;
            let doc = document.getElementById("example-table-info");
            doc.classList.add('font-weight-bold');
            doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
            return response;
        },
        rowFormatter: function(row, e) {
            //create and style holder elements
            var holderEl = document.createElement("div");
            var tableEl = document.createElement("div");

            const id = row.getData().id;

            holderEl.setAttribute('id', "subTable" + id + "");
            holderEl.setAttribute('class',"hide-subtable subtable");

            tableEl.setAttribute('class', "subTable" + id + "" );

            holderEl.appendChild(tableEl);
            row.getElement().appendChild(holderEl);
        },
    })

</script>
@endpush

</x-app-layout>

