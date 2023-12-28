<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sale Return
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('salereturn.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
            {{-- <span> | </span> --}}
            {{-- <button class="text-sm text-blue-300" onclick="setStatus(1)">Pending</button> --}}
            <span> | </span>
            <button class="text-sm text-blue-300" onclick="setStatus(2)">Sales Return History</button>
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

    const getMaster = @json(route('saler.master'));
    const getDetails = @json(route('saler.details'));
    let table;
    let searchValue = "";
    let statusValue="1";  // 1 = Pending, 2 - Completed
    //  Status Setter
    function setStatus(status)
        {
            statusValue = status
            table.setData(getMaster,{search:searchValue,status:statusValue});
        }
    //  Table Filter
    function dataFilter(element)
    {
        searchValue =  element.value;
        table.setData(getMaster,{search:searchValue,status:statusValue});
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
            return {search:searchValue,status:statusValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"dcno", dir:"desc"} ],
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
                        {title: "material_title",field: "material_title" ,headerVertical:true,},
                        {title: "pcs",field: "pcs" ,headerVertical:true,},
                        {title: "gdswt",field: "gdswt" ,headerVertical:true,},
                        {title: "inkg",field: "inkg" ,headerVertical:true,},
                        {title: "gdsprice",field: "gdsprice" ,headerVertical:true,},
                        {title: "otherexpenses",field: "otherexpenses" ,headerVertical:true,},
                        {title: "amtindollar",field: "amtindollar" ,headerVertical:true,},
                        {title: "amtinpkr",field: "amtinpkr" ,headerVertical:true,},
                        {title: "length",field: "length" ,headerVertical:true,},
                        {title: "itmratio",field: "itmratio" ,headerVertical:true,},
                        {title: "insuranceperitem",field: "insuranceperitem" ,headerVertical:true,},
                        {title: "amountwithoutinsurance",field: "amountwithoutinsurance" ,headerVertical:true,},
                        {title: "onepercentdutypkr",field: "onepercentdutypkr" ,headerVertical:true,},
                        {title: "pricevaluecostsheet",field: "pricevaluecostsheet" ,headerVertical:true,},
                        {title: "cda",field: "cda" ,headerVertical:true,},
                        {title: "sta",field: "sta" ,headerVertical:true,},
                        {title: "rda",field: "rda" ,headerVertical:true,},
                        {title: "acda",field: "acda" ,headerVertical:true,},
                        {title: "asta",field: "asta" ,headerVertical:true,},
                        {title: "ita",field: "ita" ,headerVertical:true,},
                        {title: "wsca",field: "wsca" ,headerVertical:true,},
                        {title: "total",field: "total" ,headerVertical:true,},
                        {title: "perpc",field: "perpc" ,headerVertical:true,},
                        {title: "perkg",field: "perkg" ,headerVertical:true,},
                        {title: "perft",field: "perft" ,headerVertical:true,},

                    ],
                    ajaxResponse:function(getDetails, params, response){
                        return response.data;
                    },
                })}
            },
      //      Master Data


      {
            title:'Data Description', headerHozAlign:"center",
            columns:[
            {title: "id",field: "id"},
            {title: "Customer",field: "customer.title"},
            {title: "Return Date",field:  "rdate"},
            {title: "D.C No",field: "dcno"},
            {title: "G.P No",field: "gpno"},
            {title: "Bill No",field: "billno"},
            {title: "Delivery Date",field: "dcdate"}
      ]},


      {
            title:'Invoice Level Summary', headerHozAlign:"center",
            columns:[
            {title: "Weight",field: "tsrwt"},
            {title: "Pcs",field: "tsrpcs"},
            {title: "Feet",field: "tsrfeet"},
            {title: "Amount",field: "rcvblamount"}
      ]},

      {
            title:'Pending Data Against Godown Entry', headerHozAlign:"center",
            columns:[
            {title: "Weight",field: "psrwt"},
            {title: "Pcs",field: "psrpcs"},
            {title: "Feet",field: "psrfeet"},
      ]},



            // {title: "Rcvbl Amount",field: "rcvblamount"},
            // {title: "Remarks",field: "remarks"},
            {title:"View" , formatter:viewIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
                }
            },
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    console.log(cell.getRow().getData())
                    window.open(window.location + "/" + cell.getRow().getData().id + "/edit" ,"_self");
                }
            },
            // {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e, cell){
            //         window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
            //     }
            // },
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

