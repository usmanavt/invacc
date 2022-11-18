<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recivings
            <button class="text-sm text-blue-300" onclick="setStatus(1)">Pending</button>
            <span> | </span>
            <button class="text-sm text-blue-300" onclick="setStatus(2)">Completed</button>
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
            var grIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-print text-green-500'></i>";};

            const getMaster = @json(route('recivings.master'));
            const getDetails = @json(route('recivings.details'));
            let table;
            let searchValue = "";
            let statusValue= 1;  // 1 = Pending, 2 - Completed
            let visibility; // Depends on Status Value

            //  Status Setter
            const setStatus = (status) => {
                statusValue = status
                visibility = ( status === 1 ? true:false )
                console.info(visibility)
                table.setData(getMaster,{search:searchValue,status:statusValue})
            }
            const getStatus = () => {
                return statusValue === 1 ? true:false
            }
            //  Table Filter
            const dataFilter = (element) =>{
                searchValue = element.value;
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
                    return {search:searchValue, status:statusValue};
                },
                ajaxURL: getMaster,
                ajaxContentstatus:"json",
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
                                return {id:row.getData().id, status:row.getData().status};
                            },
                            ajaxURL: getDetails,
                            columns: [
                                {title: "machine_date",field: "machine_date"},
                                {title: "machineno",field: "machineno"},
                                {title: "material_id",field: "material_id"},
                                {title: "material.title",field: "material.title"},
                                {title: "qtyinpcs",field: "qtyinpcs"},
                                {title: "qtyinkg",field: "qtyinkg"},
                                {title: "qtyinfeet",field: "qtyinfeet"},
                                {title: "rateperpc",field: "rateperpc"},
                                {title: "rateperkg",field: "rateperkg"},
                                {title: "rateperft",field: "rateperft"},
                            ],
                            ajaxResponse:function(getDetails, params, response){
                                return response.data;
                            },
                        })}
                    },
                    // Master Data
                    {title: "id",field: "id"},
                    {title: "Machine Date",field: "machine_date"},
                    {title: "Machine #",field: "machineno"},
                    {title: "Supplier",field: "supplier.title"},
                    {title: "Comm Inv #",field: "commercial_invoice_id"},
                    {title: "Inv #",field: "invoiceno"},
                    // {title: "Reciving Date",field: "reciving_date"},
                    {title: "Status",field: "status" ,
                        formatter:function(cell,row)
                        {
                            return cell.getData().status === 1 ? 'Pending':'Completed'
                        }
                    },
                    // {title:"View" , formatter:viewIcon, hozAlign:"center",headerSort:false, responsive:0,
                    //     cellClick:function(e, cell){
                    //         window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
                    //     }
                    // },
                    {title:"Receive Goods", visible:getStatus , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                        cellClick:function(e, cell){
                            if(cell.getRow().getData().status === 2)
                            {
                                showSnackbar('Completed GR cannot be edited','info');
                            }else{
                                window.open(window.location + "/" + cell.getRow().getData().id +
                                "/edit" ,"_self");
                            }
                        }
                    },
                    // {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
                    //     cellClick:function(e, cell){
                    //         window.open(window.location + "/" + cell.getRow().getData().id  ,"_self");
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

                    tableEl.setAttribute('class', "subTable" + id + "" );

                    holderEl.appendChild(tableEl);
                    row.getElement().appendChild(holderEl);
                },
            })

        </script>
    @endpush

</x-app-layout>
