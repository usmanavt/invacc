<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Receive Goods
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="grid">

                    <fieldset class="border px-4 py-2 rounded">
                        <legend>Goods Receive Master</legend>
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">

                            <x-input-text title="Comm Inv #" name="commercial" value="{{ $reciving->commercial_invoice_id  }}" disabled class="col-span-2"/>

                            <x-input-text title="Invoice #" name="invoiceno" value="{{ $reciving->invoiceno  }}" disabled class="col-span-2"/>

                            <x-input-date title="Mac. Date" name="machine_date" value="{{ $reciving->machine_date->format('Y-m-d') }}" disabled class="col-span-2"/>

                            <x-input-text title="Machine #" name="machineno" value="{{ $reciving->machineno }}" disabled class="col-span-2"/>

                            <x-input-text title="Supplier" name="supplier" value="{{ $reciving->supplier->title }}" disabled class="col-span-2"/>

                        </div>
                    </fieldset>

                    {{-- Contract Details --}}
                    {{-- <div class="px-4 py-2 items-center">
                        <x-button id="calculate" type="button" onclick="calculate()">Calculate</x-button>
                    </div> --}}

                    <div class="px-4">
                        <x-tabulator-nosearch />
                    </div>

                </div>

            </div>

            {{-- Submit Button --}}
<div class="py-2 px-4">
    <x-button id="submitbutton" type="button" onclick="submitForm()">
        <i class="fa fa-save fa-fw"></i>
        Submit
    </x-button>
</div>

        </div>
    </div>



@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        const getDetails = @json(route('recivings.details'));
        const id = @json($reciving->id);
        const status = @json($reciving->status);
        const reciving = @json($reciving);
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content
        // Populate Locations in Tabulator
        const locations = @json($locations);
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})
        });

        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")
           // changed from usman on 16-12-2022
        //submitButton.disabled = true
        //*************************************

        let tableData
        var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";}

        //  Add Event on  Page Load

        tableData = new Tabulator("#tableData", {
            autoResize:true,
            responsiveLayout:"collapse",
            layout:"fitData",
            placeholder:"No Data Available",
            pagination:true,
            paginationMode:"remote",
            sortMode:"remote",
            filterMode:"remote",
            paginationSize:10,
            paginationSizeSelector:[10,25,50,100],
            ajaxParams: function(){
                return {id:id , status:status};
            },
            ajaxURL: getDetails,
            ajaxContentType:"json",
            initialSort:[ {column:"id", dir:"desc"} ],
            height:"100%",
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                // Master Data
                {title: "id",field: "id",visible:false},
                {title:"Location", field:"location" ,editor:"list" ,        editorParams:   {
                        values:newList,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },
                {title: "Material",field: "material.title"},
                // {title: "material_id",field: "material_id"},
                {title: 'Pieces',headerHozAlign:"center",
                    columns:[
                        {title: "QtyInPcs",field: "qtyinpcs"},
                       {title: "QtyInKg",field: "qtyinkg"},
                       {title: "QtyInFeet",field: "qtyinfeet"},
                       // {title: "Pending",field: "qtyinpcspending"},
                       //     {title: "Received",field: "qtyinpcsrcv",editor:"number",
                       //     cssClass:"bg-green-200 font-semibold",
                       //     validator:["required","integer"],
                       //     formatterParams:{thousand:","}},
                        // {title: "Rejected",field: "qtyinpcsrejected",
                        //     editor:"number",
                        //     cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","integer"],
                        //     formatterParams:{thousand:","}},
                        // {title: "This GR",field: "qtythisgr",formatter:"money"},
                    ]
                },
                // {title:'Others', headerHozAlign:"center",
                //     columns:[
                //         {title: "Wt (KG)",field: "qtyinkg"},
                //         {title: "Feet",field: "qtyinfeet"},
                // ]},

                {title:'Rate', headerHozAlign:"center",
                columns:[
                    {title: "Per Pc",field: "rateperpc"},
                    {title: "Per Kg",field: "rateperkg"},
                    {title: "Per Ft",field: "rateperft"},
                ]}

            ],
        })
        tableData.on("dataLoaded", function(data){
            data.forEach((e)=>{
                if(e.qtyinpcsrejected === undefined){ e.qtyinpcsrejected = 0}
                // e.qtyinpcsrcv = 0
                // e.qtyinpcsrejected = 0
                // e.qtythisgr = 0
            })
        })

        //  This function calculates Recevied/Rejected & ThisGR
        const calculate = () => {
            const data = tableData.getData()
            let allowSubmit = true
            let positivePcs = true
            let rejectMore = false

            /// oldcoding
            let receivedMore = false
            // changed from usman on 16-12-2022
              //  let receivedMore = true
            //**************************

            let moreThenAvailabel = false
            //  First Iteration to calculate Basic Data
            data.forEach(e => {
               console.info(e)
               if(e.location === undefined)
               {
                allowSubmit = false
               }

            //change from usman on 16-12-2022
            //    if(e.qtyinpcsrcv === undefined || e.qtyinpcsrcv <= 0 )
            //    {
            //     positivePcs = false
            //    }
            //***************************************
            //    if(e.qtyinpcsrejected > e.qtyinpcsrcv)
            //    {
            //     rejectMore = true
            //    }
            //    if(e.qtyinpcsrcv > e.qtyinpcspending)
            //    {
            //     receivedMore = true
            //    }
            })
            // Update Data
            data.forEach(e => {
                e.qtythisgr = e.qtyinpcsrcv - e.qtyinpcsrejected
            })

            if(!allowSubmit) showSnackbar('add location before proceeding','error')
            // if(!positivePcs) showSnackbar('"Received" is required should be positive number only','error')
            // if(rejectMore) showSnackbar('Rejection should be less then received Quantity',)
            // if(receivedMore) showSnackbar('Cannot receive more then Pending Quantity','error')

            tableData.setData(data)

            if(allowSubmit && positivePcs && !rejectMore && !receivedMore) { submitButton.disabled = false }
        }

        // coding from usman 16-12-2022
        const submitForm = () => {
            calculate();
            const tData = tableData.getData();
            if(tData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }
            console.info(tData)

            var data = {
                'pendings' : tData
            };
            // All Ok - Proceed
            fetch(@json(route('recivings.update',['reciving' => $reciving])),{
                credentials: 'same-origin', // 'include', default: 'omit'
                method: 'PUT', // 'GET', 'PUT', 'DELETE', etc.
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
            })
        }
    </script>
@endpush
</x-app-layout>
