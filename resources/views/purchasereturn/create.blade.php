<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Purchase Return Invoice
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm  sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">

                                {{-- <label for="supplier_id">Customer<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" >
                                        <option value="" selected>--Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                        @endforeach
                                    </select> --}}
                                <x-input-text title="Supplier Name" name="supname" id="supname" req required class="col-span-2" disabled  />
                                <x-input-date title="Purchase Invoice Date" name="invoice_date" id="invoice_date" req required class="col-span-2" disabled  />
                                <x-input-text title="Purchase Invoice No" name="invoiceno" id="invoiceno" req required class="col-span-2" disabled  />

                            </div>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">
                                <x-input-date title="Purchase Return Date" id="prdate" name="prdate" req required class="col-span-2" />
                                <x-input-text title="Purchase Return No" name="prno" id="prno" value="{{$maxposeqno}}"      />

                            </div>
                        </fieldset>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" disabled    />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt"   />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" disabled />
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
                            </div>
                        </fieldset> --}}

                        <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>

                            {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" title="W/Qutation" type="checkbox" value="checked" name="woq" id="woq"   > --}}
                        </div>



                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" type="button" onclick="validateForm()">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Purchase Invoice" />

@push('scripts')
    <script>
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


        var getMaster = @json(route('purchasereturn.quotations')) ;
        var getDetails = @json(route('purchasereturn.quotationsdtl'));

         let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let purchase_id = '';
        let supplier_id = '';


        // let prno= document.getElementById("prno")
        document.addEventListener('DOMContentLoaded',()=>{
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){

                if(!adopted)
                {
                    // if (document.getElementById("woq").checked) {
                    //     var getMaster = @json(route('custorders.quotations')) ;
                        showModal()
                    // }else {
                    //     var getMaster = @json(route('materials.master')) ;
                    //     showModal()
                    // }
                }
            }
        })
    </script>
@endpush

@push('scripts')
    <script>



        // window.onload = function() {
        //     var input = document.getElementById("pono.focus").focus();
        // }

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
            width:"600px",
            height:"600px",
            autoResize:true,
            responsiveLayout:"collapse",
            // layout:"fitData",
            layout:'fitDataTable',

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

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Supplier", field:"supname" , responsive:0},
                {title:"Invoice Date", field:"invoice_date" , responsive:0},

                {title:"Invoice No", field:"invoiceno" , visible:true ,headerSort:false, responsive:0},
                // {title:"P.R No", field:"prno" , visible:true ,headerSort:false, responsive:0},
                // {title:"Quotation Values", field:"totrcvbamount", visible:true ,headerSort:false, responsive:0},
                // {title:"Valid Date", field:"dvaldate" , responsive:0},


           ],
        // },
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

            // Fill Master Data
            supplier_id=data.supplier_id
            purchase_id = data.id
            invoice_date.value=data.invoice_date
            invoiceno.value=data.invoiceno
            supplier_id=data.supplier_id
            //  prno.value = data.prno
            // qutno.value = data.qutno
            // discntper.value=data.discntper
             supname.value=data.supname


            // discntper.value=data.discntper
            // discntamt.value=data.discntamt
            // cartage.value=data.cartage

            // saletaxper.value=data.saletaxper
            // saletaxamt.value=data.saletaxamt
            // rcvblamount.value=data.rcvblamount
            // totrcvbamount.value=data.totrcvbamount
            detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
            calculateButton.disabled = false
            closeModal()
        })
    </script>
@endpush

@push('scripts')
    <script>

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
            for (let index = 0; index < data.length; index++) {

                const obj = data[index];
                // const mat = obj['material']
                // var vpcs = obj.totpcs
                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                // var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {
                        id :                obj.id,
                        matname :           obj.matname,
                        purchase_id :      obj.purchase_id,
                        material_id :       obj.material_id,
                        supplier_id :       obj.supplier_id,
                        user_id :           obj.user_id,
                        sku_id :            obj.sku_id,
                        unitname:                obj.unitname,
                        // pono:               '',

                        // dimension_id :      obj.dimension_id,
                        size :         obj.size,
                        // mybrand :           obj.mybrand,
                        // repname :           obj.repname,
                        pcs :           obj.pcs ,
                        gdswt   :           obj.gdswt,
                        qtyinfeet:           obj.qtyinfeet,
                        prprice:             obj.gdsprice,
                        amtinpkr:             obj.amtinpkr,

                        prpcs :              obj.prpcs ,
                        prwt   :            obj.prgdswt,
                        prfeet:             obj.prqtyinfeet,
                        pramount:         obj.pramtinpkr,



                    }
                ])
            }
        }



        //  Dynamic Table [User data]


        var rowMenu = [
    {
        label:"<i class='fas fa-user'></i> Change Name",
        action:function(e, row){
            row.update({name:"Steve Bobberson"});
        }
    },
    {
        label:"<i class='fas fa-check-square'></i> Select Row",
        action:function(e, row){
            row.select();
        }
    },
    {
        separator:true,
    },
    {
        label:"Admin Functions",
        menu:[
            {
                label:"<i class='fas fa-trash'></i> Delete Row",
                action:function(e, row){
                    row.delete();
                }
            },
            {
                label:"<i class='fas fa-ban'></i> Disabled Option",
                disabled:true,
            },
        ]
    }
]

var headerMenu = function(){
    var menu = [];
    var columns = this.getColumns();

    for(let column of columns){

        //create checkbox element using font awesome icons
        let icon = document.createElement("i");
        icon.classList.add("fas");
        icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

        //build label
        let label = document.createElement("span");
        let title = document.createElement("span");

        title.textContent = " " + column.getDefinition().title;

        label.appendChild(icon);
        label.appendChild(title);

        //create menu item
        menu.push({
            label:label,
            action:function(e){
                //prevent menu closing
                e.stopPropagation();

                //toggle current column visibility
                column.toggle();

                //change menu item icon
                if(column.isVisible()){
                    icon.classList.remove("fa-square");
                    icon.classList.add("fa-check-square");
                }else{
                    icon.classList.remove("fa-check-square");
                    icon.classList.add("fa-square");
                }
            }
        });
    }

   return menu;
};

var tamount=0;
    // function tnetamount()
    //     {
    //         //  discntamt.value=0;
    //         //  rcvblamount.value=0;
    //         // discntamt.value=(tamount*discntper.value/100).toFixed(0);
    //         // discntper.value=(discntamt.value/tamount*100).toFixed(2);
    //         if (discntper.disabled)
    //         {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

    //         if (!discntper.disabled)
    //         {discntamt.value=(tamount*discntper.value/100).toFixed(0);};

    //         rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
    //         saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
    //         totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
    //     }

var updateValues = (cell) => {
        var data = cell.getData();

        if(cell.getData().sku_id===1)
         {
             var sum =  Number(data.prwt) * Number(data.prprice)
         }
         if(cell.getData().sku_id===2)
         {
            var sum =  Number(data.prpcs) * Number(data.prprice)
         }

         if(cell.getData().sku_id===3)
         {
            var sum =  Number(data.prfeet) * Number(data.prprice)
         }

        var row = cell.getRow();
        row.update({
            "pramount": sum,
            "totalVal": sum
            // "qtyinfeet":leninft
        });


    }

    var totalVal = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        // tamount = calc;
        // tnetamount();
        return calc;

    }




        dynamicTable = new Tabulator("#dynamicTable", {
            height:"350px",
            width:"1000px",
            rowContextMenu: rowMenu,
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            // movableRows:true,
            // groupBy:"material_title",
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"Id",           field:"id", visible:false},
                {title:"Material Name",     field:"matname",responsive:0},
                {title:"Material Size",    field:"size",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"UOM",         field:"unitname",responsive:0, hozAlign:"center"},
                {title:"Unitid",       field:"sku_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},

                {
                    title:'Purchase Qty', headerHozAlign:"center",
                    columns:[

                    {   title:"Pcs",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"pcs",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            // cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Kg",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"gdswt",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            // cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Feet",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"qtyinfeet",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            // cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },


                        {   title:"Price",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"prprice",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },


                        {title:"Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"amtinpkr",
                        cssClass:"bg-gray-200 font-semibold",
                        formatter:"money",
                        cssClass:"bg-gray-200 font-semibold",
                        formatterParams:{thousand:",",precision:0},
                        cssClass:"bg-gray-200 font-semibold",
                        // formatter:function(cell,row)
                        // {
                        //     // return (cell.getData().saleqty * cell.getData().price).toFixed(0)
                        // },
                        // bottomCalc:totalVal
                    },

                    ],


                },

                {
                title:'Purchase Return Qty', headerHozAlign:"center",
                    columns:[

                    {   title:"Pcs",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"prpcs",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Kg",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"prwt",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"feet",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"prfeet",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {title:"Return Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"pramount",
                        formatter:"money",
                        cellEdited: updateValues,
                        cssClass:"bg-gray-200 font-semibold",
                        formatter:function(cell,row)
                        {
                            //  return (cell.getData().saleqty * cell.getData().price).toFixed(0)

                             if(cell.getData().sku_id===1)
                            {
                                return  Number(cell.getData().prwt) * Number(cell.getData().prprice)
                            }
                            if(cell.getData().sku_id===2)
                            {
                                 return  Number(cell.getData().prpcs ) * Number(cell.getData().prprice)
                                //  return Number(cell.getData().prprice )
                            }

                            if(cell.getData().sku_id===3)
                            {
                                return  Number(cell.getData().prfeet ) * Number(cell.getData().prprice)
                            }
                        },formatterParams:{thousand:",",precision:0},
                        bottomCalc:totalVal
                    },
                    ]},





            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {

            // var pono = document.getElementById("pono")
            // var poseqno = document.getElementById("poseqno")
            // var per= document.getElementById("per");

            // if(pono.value === '')
            // {
            //     showSnackbar("P.O No Required","error");
            //     pono.focus();
            //     return;
            // }








            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

            // for (let index = 0; index < dynamicTableData.length; index++) {
            //     const element = dynamicTableData[index];

            //     if(element.location === undefined)
            //     {
            //         showSnackbar("Location must be Enter","info");
            //         return;
            //     }
            // }


            var data = { 'contracts' : dynamicTableData ,
        'supplier_id': supplier_id,'prdate':prdate.value,'purchase_id':purchase_id,'prno':prno.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value };




            // All Ok - Proceed
            fetch(@json(route('purchasereturn.store')),{
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
                    window.open(window.location.origin + "/purchasereturn","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

    //     function EnableDisableTextBox(per) {
    //     var discntper = document.getElementById("discntper");
    //     discntper.disabled = per.checked ? false : true;
    //     discntper.style.color ="black";
    // }



//     discntper.onblur=function(){
//     per=false
//      tnetamount();
// }

// discntamt.onblur=function(){
//      tnetamount();

// }
    </script>
@endpush

</x-app-layout>
