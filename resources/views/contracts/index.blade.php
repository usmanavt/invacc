<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>


    @endpush

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contracts
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('contracts.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>

    {{-- Tabulator --}}
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                {{-- tabulator component --}}
                <x-tabulator />

            </div>
        </div>
    </div>

    {{-- <div class="pt-2">
        <button
            id="submitbutton" onclick="printselection()"
            class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
            <i class="fa fa-save fa-fw"></i>
            Print
        </button>
    </div> --}}
{{-- onclick="validateForm()" --}}

@push('scripts')
<script src="{{ asset('js/tabulator.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>
@endpush

@push('scripts')
<script>

    var hideIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-eye text-green-600'></i>";};
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    var deleteIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-trash text-red-600'></i>";};
    var printIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-print text-pink-500'></i>";};

    const getMaster = @json(route('contracts.master'));
    const getDetails = @json(route('contracts.details'));
    let table;
    let searchValue = "";
    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

    function printselection()
    {
        var selectedData = table.getSelectedData()
        var ids = []
        selectedData.forEach(e => {
            console.log(e.id)
            ids.push(e.id)
        });
        console.log(ids)

        fetch(@json(route('contracts.printselected')),{
            credentials: 'same-origin', // 'include', default: 'omit'
            method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
            // body: formData, // Coordinate the body type with 'Content-Type'
            body:JSON.stringify(ids),
            headers: new Headers({
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token":csrfToken
            }),
        })
        .then(response => response.blob() )
        .then( blob => {
            download(blob,"mulit-contract.pdf")
        })
        .catch(error => {
            console.log(error)
            showSnackbar("Errors occured","red");
        })

    }

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


        columns:[
            //  Detail Data
            {
        //         formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
        // cell.getRow().toggleSelect();
        // }


    },
            // {formatter:hideIcon, hozAlign:"center", title:"Details",headerSort:false, cellClick:function(e, row, formatterParams){
            //     let tableHolder = document.getElementById("subTable" + row.getData().id + "");
            //     tableHolder.classList.toggle('hide-subtable');
            //     var r = row.getElement() //  Get Info About Cell
            //     if(tableHolder.classList.contains('hide-subtable'))
            //     {
            //         r.childNodes[0].classList.remove('fa-eye-slash','text-gray-500')
            //         r.childNodes[0].classList.add('fa-eye','text-gray-400')
            //     }
            //     else {
            //         r.childNodes[0].classList.add('fa-eye-slash','text-gray-500')
            //         r.childNodes[0].classList.remove('fa-eye','text-gray-400')
            //     }
            //     subTable = new Tabulator(tableHolder, {
            //         layout:"fitData",                       //fit columns to width of table
            //         responsiveLayout:"collapse",            //hide columns that dont fit on the table
            //         index:'id',                             //Table Row Id
            //         placeholder:"No Data Available",        //Placeholder text for empty table
            //         // Pagination
            //         pagination:"remote",                    //paginate the data
            //         paginationSize:10,                      //starting page size
            //         paginationSizeSelector:[10,25,50,100],  //  Page Size Selector
            //         ajaxParams: function(){
            //             return {id:row.getData().id};
            //         },
            //         ajaxURL: getDetails,
            //         columns: [
            //             {title: "Material",field: "material_title"},
            //             {title: "Category",field: "category"},
            //             {title: "Sku",field: "sku"},
            //             {title: "Dimension",field: "dimension"},
            //             {title: "Source",field: "source"},
            //             {title: "Brand",field: "brand"},
            //             {title: "Bundle1",field: "bundle1"},
            //             {title: "Pcs/Bnd1",field: "pcspbundle1"},
            //             {title: "Bundle2",field: "bundle2"},
            //             {title: "Pcs/Bnd2",field: "pcspbundle2"},
            //             {title: "Gdswt",field: "gdswt" ,formatter:"money",
            //     formatterParams:{thousand:",",precision:3}},
            //             {title: "Value",field: "gdsprice" , formatter:"money",
            //     formatterParams:{thousand:",",precision:3}},

            //             // {title:"Approve Single" , hozAlign:"center",visible:visibleApprove,headerSort:false, responsive:0,
            //             //     formatter:function(cell, onRendered){
            //             //         return (cell.getRow().getData().type === 1 && cell.getRow().getData().locked === 0) ? "<i class='fa fa-thumbs-up text-green-500'></i>":"";
            //             //     },
            //             //     cellClick:function(e, cell){
            //             //         (cell.getRow().getData().type === 2 || cell.getRow().getData().locked == 1) ? "":
            //             //         //  Fetch the Data from Rest Api
            //             //         fetch(window.location + `/approveall?gp=2&id=${cell.getRow().getData().id}`,{
            //             //         method:"GET",
            //             //         headers: { 'Accept':'application/json','Content-type':'application/json'},
            //             //         })
            //             //         .then((response) => response.json()) //Transform data to json
            //             //         .then(function(response){
            //             //             if(response == "success")
            //             //             showSnackbar("Returnable Gatepass approved","green");
            //             //             window.open(window.location.origin + `/gatepass`,"_self");
            //             //         })
            //             //         .catch(function(error){
            //             //             showSnackbar(error,"red");
            //             //         })
            //             //     }
            //             // },
            //         ],
            //         ajaxResponse:function(getDetails, params, response){
            //             return response.data;
            //         },
            //     })}
            // },
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Contract #", field:"number" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Contract Date", field:"invoice_date" , visible:true , responsive:0},
            {title:"Supplier", field:"supplier.title" ,  responsive:0},

            {
                title:'Contract Data', headerHozAlign:"center",
                    columns:[
            {title: "Weight",field: "conversion_rate" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:0}},
            {title: "Pcs",field: "totalpcs" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:0}},
            {title: "Supp.Val($)",field: "insurance" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:3}},
            {title: "Duty.Val($)",field: "dutyval" ,formatter:"money", responsive:0,
                formatterParams:{thousand:",",precision:3}} ]},

                {
                title:'Pending Data', headerHozAlign:"center",
                    columns:[
            {title: "Weight",field: "balwt" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:0}},
            {title: "Pcs",field: "balpcs" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:0}},
            {title: "Supp.Val($)",field: "balsupval" ,formatter:"money", responsive:0,formatterParams:{thousand:",",precision:0}}
             ]},


                {title:"Created By", field:"user.name" ,  responsive:0},
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    // console.log(cell.getData().id)
                    window.open(window.location + "/" + cell.getData().id + "/edit" ,"_self");
                }
            },
            {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().id + "/deleterec"   ,"_self");
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

