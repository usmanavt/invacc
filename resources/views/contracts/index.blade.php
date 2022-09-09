<x-app-layout>

    @push('styles')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.3.3/css/tabulator_simple.min.css' integrity='sha512-MiBxahZcoFzbr3jfdy0MzAzdqPy0q9/ZX6usJ4QfsvVPMe4ywyKui1+lWEEOLwpDkEtEgkRxb2r9+RGOVCRhMw==' crossorigin='anonymous'/>
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
        <div class="max-w-9xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <div class="flex justify-between items-center py-2">
                    <div class="flex flex-row relative">
                        <i class="fa fa-search fa-fw text-indigo-500 absolute top-1 left-1"></i>
                        <input type="text" class="pl-8 border focus:ring focus:ring-indigo-500 h-8" id="data_filter" onkeyup="dataFilter(this)" placeholder="Search here...">
                    </div>
                    <div id="example-table-info" class="mr-2 text-sm text-gray-500"></div>
                </div>
                
                <div id="tableData" class="py-2">
                    {{-- tabulator Data --}}
                </div>

            </div>
        </div>
    </div>

    
@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.3.3/js/tabulator.min.js' integrity='sha512-LUXZzTaZ4dfN43AUEQtKG6xxKYlThiiBtjdmgs7FK5OnUFNE2FnQTb/n+DdQX7CDg9wZDeYKYUk1FVfUgIw7ug==' crossorigin='anonymous'>
</script>
@endpush

@push('scripts')
<script>
    var hideIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-eye text-green-600'></i>";};
    const getMaster = @json(route('contracts.master'));
    const getDetails = @json(route('contracts.details'));
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
            //  Detail Data
            {formatter:hideIcon, hozAlign:"center", title:"Details",headerSort:false, cellClick:function(e, row, formatterParams){
                let tableHolder = document.getElementById("subTable" + row.getData().id + "");
                tableHolder.classList.toggle('hide-subtable');
                var r = row.getElement() //  Get Info About Cell
                console.log(r)  
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
                        {title: "Category",field: "category" , minWidth:512},
                        {title: "Sku",field: "sku"},
                        {title: "Dimension",field: "dimension"},
                        {title: "Source",field: "source"},
                        {title: "Brand",field: "brand"},
                        {title: "Bundle1",field: "bundle1"},
                        {title: "Pcs/Bnd1",field: "pcspbundle1"},
                        {title: "Bundle2",field: "bundle2"},
                        {title: "Pcs/Bnd2",field: "pcspbundle2"},
                        {title: "Gdswt",field: "gdswt"},
                        {title: "Value",field: "gdsprice"},

                        // {title:"Approve Single" , hozAlign:"center",visible:visibleApprove,headerSort:false, responsive:0,
                        //     formatter:function(cell, onRendered){
                        //         return (cell.getRow().getData().type === 1 && cell.getRow().getData().locked === 0) ? "<i class='fa fa-thumbs-up text-green-500'></i>":"";
                        //     },
                        //     cellClick:function(e, cell){ 
                        //         (cell.getRow().getData().type === 2 || cell.getRow().getData().locked == 1) ? "":
                        //         //  Fetch the Data from Rest Api
                        //         fetch(window.location + `/approveall?gp=2&id=${cell.getRow().getData().id}`,{
                        //         method:"GET",
                        //         headers: { 'Accept':'application/json','Content-type':'application/json'},
                        //         })
                        //         .then((response) => response.json()) //Transform data to json
                        //         .then(function(response){
                        //             if(response == "success")
                        //             showSnackbar("Returnable Gatepass approved","green");
                        //             window.open(window.location.origin + `/gatepass`,"_self");
                        //         })
                        //         .catch(function(error){
                        //             showSnackbar(error,"red");
                        //         })
                        //     }
                        // },
                    ],
                    ajaxResponse:function(getDetails, params, response){
                        return response.data;
                    },
                })}
            },
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Invoice #", field:"number" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dated", field:"invoice_date" , visible:true , responsive:0},
            {title:"Supplier", field:"supplier.title" ,  responsive:0},
            {title:"Created By", field:"user.name" ,  responsive:0},
            // {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e, cell){ 
            //         // window.open(window.location + "/" + cell.getRow().getData().id + "/delete" ,"_self");
            //     }
            // },
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

            tableEl.setAttribute('class', "subTable" + id + "");

            holderEl.appendChild(tableEl);
            row.getElement().appendChild(holderEl);
        },
    })

</script>
@endpush

</x-app-layout>

