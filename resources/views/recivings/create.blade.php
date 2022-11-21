<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Goods Reciving
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >

                    <div class="flex gap-8">
                        {{-- Form Data --}}
                        <div class="flex  justify-start items-center">
                            <form action="{{ route('materials.store') }}" method="post" >
                            @csrf

                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-date title="Rec.Date" name="reciving_date" req required class="col-span-2" />

                                    <input type="hidden" id="commercial_invoice_id" >
                                    <input type="hidden" id="supplier_id" >

                                    <x-input-text title="Invoice #" name="invoiceno" disabled class="col-span-2"/>
                                    <x-input-text title="Supplier" name="supplier" disabled class="col-span-2"/>
                                </div>

                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-text title="Mac. Date" name="machine_date" disabled class="col-span-2"/>
                                    <x-input-text title="Machine #" name="machineno" disabled class="col-span-2"/>
                                </div>

                                <x-tabulator-dynamic />

                                <div class="mt-2">
                                    <x-button id="submitbutton" type="button" onclick="validateForm()">
                                        <i class="fa fa-save fa-fw"></i>
                                        Submit
                                    </x-button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Commercial Invoices" />

@push('scripts')
    <script>
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        const getMaster = @json(route('recivings.cismaster'));
        const getDetails = @json(route('recivings.cisdetails'));
        //
        let modal = document.getElementById("myModal")
        let submitButton = document.getElementById("submitbutton")
        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

        let invoiceno = document.getElementById("invoiceno")
        let machine_date = document.getElementById("machine_date")
        let machineno = document.getElementById("machineno")
        let supplier_id = document.getElementById("supplier_id")
        let commercial_invoice_id = document.getElementById("commercial_invoice_id")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''

        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            submitButton.disabled = true
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{
            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){
                if(!adopted)
                {
                    showModal()
                }
            }
        })
    </script>
@endpush
@push('scripts')
    <script>
        // -----------------FOR MODAL -------------------------------//
        function showModal(){ modal.style.display = "block"}
        function closeModal(){ modal.style.display = "none"}
        //  When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        //  Table Filter
        function dataFilter(element)
        {
            searchValue = element.value;
            table.setData(getMaster,{search:searchValue});
        }
        //  The Table for Materials Modal
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
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Inv Date", field:"invoice_date" , visible:true ,headerSort:false, responsive:0},
                {title:"Invoice #", field:"invoiceno" , visible:true ,headerSort:false, responsive:0},
                {title:"Challan #", field:"challanno" , visible:true ,headerSort:false, responsive:0},
                {title:"Machine #", field:"machineno" , visible:true ,headerSort:false, responsive:0},
                {title:"Supplier", field:"supplier.title" , visible:true ,headerSort:false, responsive:0},
            ],
            // Extra Pagination Data for End Users
            ajaxResponse:function(getDataUrl, params, response){
                remaining = response.total;
                let doc = document.getElementById("example-table-info");
                doc.classList.add('font-weight-bold');
                doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
                return response;
            }
        })
        //  Adds New row to dynamicTable
        table.on('rowClick',function(e,row){
            var simple = {...row}
            var data = simple._row.data

            detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
            closeModal()
            submitButton.disabled = false
        })
    </script>
@endpush

@push('scripts')
    <script>
        var newList=[]
        //  ------------------Dynamic Table----------------------//
        async function fetchDataFromServer(url)
        {
            var data =  await fetch(url,{
                method:"GET",
                headers: { 'Accept':'application/json','Content-type':'application/json'},
                })
                .then((response) => response.json()) //Transform data to json
                .then(function(response){
                    // console.log(response);
                    return response;
                })
                .catch(function(error){
                    console.log("Error : " + error);
            })
            //  Stremaline Data for Tabulator
            data.locations.forEach(e => {
                newList.push({value:e.id,label:e.title})
            });
            data.contractDetails.forEach(e => {
                invoiceno.value = e.invoiceno
                machine_date.value = e.machine_date
                machineno.value = e.machineno
                supplier.value = e.supplier.title
                supplier_id.value = e.supplier_id
                commercial_invoice_id.value = e.commercial_invoice_id

                dynamicTable.addData([
                    {
                        id :                e.id,
                        material_title :    e.material_title,
                        pcs :               e.pcs,
                        inkg :              e.inkg,
                        length :            e.length,
                        perpc:              e.perpc,
                        perkg:              e.perkg,
                        perft:              e.perft,
                    }
                ])
            });
        }
        //  Dynamic Table [User data]
        dynamicTable = new Tabulator("#dynamicTable", {
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"Id",           field:"id", visible:false},
                {title:"Material",     field:"material_title"},
                {title:"Location",     field:"location" ,editor:"list" ,editorParams:{
                    values:newList,cssClass:"bg-green-200 font-semibold",
                    validator:["required"]
                }},
                {title:"Qty[Pcs]",     field:"pcs"},
                {title:"Qty[Kg]",     field:"inkg"},
                {title:"Qty[Ft]",     field:"length"},
                {title:"Rate/Pc",     field:"perpc"},
                {title:"Rate/Kg",     field:"perkg"},
                {title:"Rate/Ft",     field:"perft"},
            ],
        })

        function checkData(tData)
        {
            for (let index = 0; index < tData.length; index++) {
                const e = tData[index]
                if(e.location === undefined)
                {
                    return false
                    break
                }
            }
            return true
        }
        // Validation & Post
        function validateForm()
        {
            var reciving_date = document.getElementById("reciving_date")
            var tData = dynamicTable.getData();
            if(tData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info")
                return
            }

            if(checkData(tData))
            {
                // disableSubmitButton(true);
                var data = {
                    'reciving_date' :reciving_date.value,
                    'recivings' : tData,
                    'invoiceno':invoiceno.value,
                    'machine_date':machine_date.value,
                    'machineno':machineno.value,
                    'supplier_id':supplier_id.value,
                    'commercial_invoice_id':commercial_invoice_id.value,

                };
                // All Ok - Proceed
                fetch(@json(route('recivings.store')),{
                    credentials: 'same-origin', // 'include', default: 'omit'
                    method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
                    // body: formData, // Coordinate the body type with 'Content-Type'
                    body:JSON.stringify(data),
                    headers: new Headers({
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token":csrfToken
                    }),
                })
                .then(response => response.json())
                .then( response => {
                    if (response == 'success')
                    {
                        window.open(window.location.origin + "/recivings","_self" );
                    }
                })
                .catch(error => {
                    showSnackbar("Errors occured","red");
                    // disableSubmitButton(false);
                })

            }else{
                showSnackbar("Location is required","red")
            }
        }
    </script>
@endpush

</x-app-layout>
