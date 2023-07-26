<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Customer Order
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

                                <label for="customer_id">Customer<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                        @endforeach
                                    </select>
                                <x-input-text title="Quotation No" name="qutno" id="qutno" req required class="col-span-2" disabled  />
                                <x-input-text title="P.R No" name="prno" id="prno" req required class="col-span-2" disabled  />
                                <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" req required class="col-span-2"  />

                            </div>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">
                                <x-input-date title="P.O Date" id="podate" name="podate" req required class="col-span-2" />
                                <x-input-text title="P.O #" name="pono" id="pono" req required class="col-span-2"  />
                                <x-input-date title="Delivery Date" name="deliverydt" req required class="col-span-2"/>

                                <label for="">
                                    Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                                <textarea name="remarks" id="remarks" cols="100" rows="2" maxlength="150" required class="rounded"></textarea>
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            {{-- <legend>Invoice Level Expenses</legend> --}}
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper"    />
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt"   />
                                <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" disabled />
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
                            </div>
                        </fieldset>





                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Cust Coll" name="collofcustom" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ex Tax of" name="exataxoffie" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Lcl Cartage" name="localcartage" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Custom Sepoy" name="customsepoy" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Weigh Bridge" name="weighbridge" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp" name="miscexpenses" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" required  onblur="calculateBankCharges()"/> --}}
                                {{-- <x-input-numeric title="Other Chgs ($)" name="otherchrgs" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="banktotal" disabled />

                            </div>
                        </fieldset>
                        Contract Details --}}

                        {{-- <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <label for="">Debit to </label>
                            <select autocomplete="on" name="bank_id" id="bank_id" required>
                                <option disabled selected value="">--Select</option>
                                @foreach ($bnk as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->title }}</option>
                                @endforeach
                            </select>
                            <x-input-date title="cheque date" name="cheque_date" req required />
                            <x-input-numeric title="cheque no" name="cheque_no" req required    />

                        </div> --}}







                        <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>
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

<x-tabulator-modal title="Contracts" />

@push('scripts')
    <script>
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        // const getMaster = @json(route('contracts.masterI'));
        // const getMaster = @json(route('dutyclear.master'));
        const getMaster = @json(route('custorders.quotations'));
        //  console.log(getMaster)
        // const getDetails = @json(route('cis3.condet'));
        const getDetails = @json(route('custorders.quotationsdtl'));


        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let contract_id = '';


        let prno= document.getElementById("prno")
        // let invoicedate= document.getElementById("invoicedate")

        // Bank Charges
        // let bankcharges= document.getElementById("bankcharges")
        // let collofcustom= document.getElementById("collofcustom")
        // let exataxoffie= document.getElementById("exataxoffie")
        // let lngnshipdochrgs= document.getElementById("lngnshipdochrgs")
        // let localcartage= document.getElementById("localcartage")
        // let miscexplunchetc= document.getElementById("miscexplunchetc")
        // let customsepoy= document.getElementById("customsepoy")
        // let weighbridge= document.getElementById("weighbridge")
        // let miscexpenses= document.getElementById("miscexpenses")
        // let agencychrgs= document.getElementById("agencychrgs")

        // let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        // var sconversionrate = document.getElementById("sconversionrate");
        var insurance = document.getElementById("insurance");
        // var otherchrgs = document.getElementById("otherchrgs");
        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            // calculateButton.disabled = true
            // submitButton.disabled = true
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){
                // if(conversionrate.value <= 0 || sconversionrate.value <= 0 )
                // {
                //     showSnackbar("Please add conversion rate before proceeding","error");
                //     conversionrate.focus();
                //     return;
                // }
                // if(insurance.value <= 0)
                // {
                //     showSnackbar("Please add insurance rate before proceeding","error");
                //     insurance.focus();
                //     return;
                // }

                if(!adopted)
                {
                    showModal()

                }
            }
        })
        // Calculate Bank Charges [ onblur ]

        function calculateBankCharges()
        {
            // var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) //+ parseFloat(otherchrgs.value)
            // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
            // banktotal.value = t.toFixed(2)
            // banktotal.value = 0
        }
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
            width:"1000px",
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
            // height:"100%",

            // {
            //     title:'Revise WSE', headerHozAlign:"center",
            //         columns:[
            //     {title:"WSE",  field:"wse",   formatter:"money",editor:"number",
            //             formatterParams:{thousand:",",precision:2},          responsive:0}]},

            //      {


          //      {
                //  title:'Revise WSE', headerHozAlign:"center",

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Customer", field:"custname" , responsive:0},
                {title:"Quotation Date", field:"qutdate" , responsive:0},

                {title:"Quotation #", field:"qutno" , visible:true ,headerSort:false, responsive:0},
                {title:"P.R No", field:"prno" , visible:true ,headerSort:false, responsive:0},
                {title:"Quotation Values", field:"totrcvbamount", visible:true ,headerSort:false, responsive:0},
                {title:"Valid Date", field:"valdate" , responsive:0},


                // {
                //  title:'Total Import Data', headerHozAlign:"center",
                //  columns:[
                //  {title:"Weight", field:"tweight" , visible:true ,headerSort:false, responsive:0},
                //  {title:"TotalPcs", field:"ttotalpcs" , visible:true ,headerSort:false, responsive:0},
                //  {title:"TotalVal($)", field:"tvalue" , visible:true ,headerSort:false, responsive:0},

                // ]},

                // {
                //  title:'Pending Duty Clearance', headerHozAlign:"center",
                //  columns:[
                //  {title:"Weight", field:"pweight" , visible:true ,headerSort:false, responsive:0},
                //  {title:"TotalPcs", field:"ptotalpcs" , visible:true ,headerSort:false, responsive:0},
                //  {title:"TotalVal($)", field:"ptvalue" , visible:true ,headerSort:false, responsive:0},

                // ]}
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
            prno.value = data.prno
            qutno.value = data.qutno









            // customer_id.value=data.customer_id
            // invoicedate = data.invoice_date->format('dd/mm/YYYY')

            //***********************
            // contract_id = data.contract_id
            // console.info(contract_id)
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
                const mat = obj['material']
                // const hsc = mat['hscodes']

                // contract_id = obj.contract_id
                // console.log(obj.bundle1 , obj.pcspbundle1 ,obj.bundle2 , obj.pcspbundle2);
                // var vpcs = ((obj.bundle1 * obj.pcspbundle1) + (obj.bundle2 * obj.pcspbundle2)).toFixed(2)
                var vpcs = obj.totpcs
                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {
                        id :                obj.id,
                        material_title :    obj.material_title,
                        // contract_id :    obj.contract_id,
                        material_id :       obj.material_id,
                        customer_id :       obj.customer_id,
                        user_id :           obj.user_id,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,

                        dimension_id :      obj.dimension_id,
                        dimension :         obj.dimension,
                        mybrand :           obj.mybrand,
                        repname :           obj.repname,
                        saleqty :           obj.saleqty ,
                        price   :           obj.price,
                        saleamnt:           obj.saleamnt,

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

var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var row = cell.getRow();
        row.update({
             "pcs": sum,
            // "gdspricetot": sum2,
            // "gdspricedtytot":sum3

        });
    }






        dynamicTable = new Tabulator("#dynamicTable", {
            height:"550px",
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
                {title:"Material Name",     field:"material_title",responsive:0},
                {title:"Material Size",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"UOM",         field:"sku",responsive:0},
                {title:"Unitid",       field:"sku_id",visible:false},
                // {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},
                {title:"user_id",      field:"user_id",visible:false},
                {title:"category_id",  field:"category_id",visible:false},
                {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},

                {
                    title:'Quantity', headerHozAlign:"center",
                    columns:[
                        {   title:"Replace Name",headerHozAlign :'center',
                            field:"repname",
                            // editor:"list",
                            responsive:0,
                            // headerVertical:true,
                            editor:true,
                        },

                        {   title:"Brand",headerHozAlign :'center',
                            field:"mybrand",
                            // editor:"list",
                            responsive:0,
                            // headerVertical:true,
                            editor:true,
                        },





                        {   title:"Sale Qty",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"saleqty",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Sale Price",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"price",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Sale Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"saleamnt",
                            // editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },







                        // {   title:"Pcs/Bund",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"pcspbundle1",
                        //     headerVertical:true,
                        //     // bottomCalc:"sum",
                        //     formatter:"money",
                        //     cellEdited: updateValues,
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        // {   title:"Bundle2",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"bundle2",
                        //     editor:"number",
                        //     cellEdited: updateValues,
                        //     headerVertical:true,
                        //     bottomCalc:"sum",
                        //     formatter:"money",
                        //      cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        // {   title:"Pcs/Bund",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"pcspbundle2",
                        //     // editor:"number",
                        //     headerVertical:true,
                        //     cellEdited: updateValues,
                        //     // bottomCalc:"sum",
                        //     formatter:"money",
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        // {   title:"Pcs",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"pcs",
                        //     // editor:"number",
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        //     formatter:function(cell,row)
                        //     {
                        //         return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)
                        //     },bottomCalc:"sum",


                        // },

                        // {   title:"Duty.Wt(Kg)",
                        //     field:"dutygdswt",
                        //     responsive:0,
                        //     bottomCalc:"sum",
                        //     editor:"number",
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:2},
                        // },

                        // {   title:"Duty.Price($)",
                        //     field:"dtyrate",
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     editor:"number",
                        //     responsive:0,
                        //     formatterParams:{thousand:",",precision:2},
                        //     validator:["required","numeric"],
                        //     bottomCalcParams:{precision:2}  ,
                        // },

                        // {   title:"Duty.Val($)",
                        //     field:"dtyamtindollar",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        // },
                        // {   title:"Duty.Val(Rs)",
                        //     field:"dtyamtinpkr",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:0},
                        // },




                        // {   title:"Wt(pcs/kg)",
                        //     field:"inkg",
                        //     responsive:0,
                        //     headerVertical:true,
                        // },

                        // {   title:"Lng(pcs/feet)",
                        //     field:"length",
                        //     headerVertical:true,
                        //     editor:"number",
                        //     formatter:"money",
                        //     responsive:0,
                        //     formatterParams:{thousand:",",precision:2},
                        //     validator:["required","numeric"],
                        //     bottomCalcParams:{precision:2}  ,
                        // },

                        // {   title:"QtyInFeet",
                        //     field:"qtyinfeet",
                        //     headerVertical:true,
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     responsive:0,
                        //     formatterParams:{thousand:",",precision:0},
                        //     validator:["required","numeric"],
                        //     bottomCalcParams:{precision:0}  ,
                        // },


                    ]
                },

                // {   title:"Item Ratio(%)",
                //             field:"dtyitmratio",
                //             responsive:0,
                //             bottomCalc:"sum",bottomCalcParams:{precision:0},
                //             headerVertical:true,
                //             formatter:"money",
                //             formatterParams:{thousand:",",precision:2},
                // },

                // {
                //     title:"Insurance/Item($)",
                //     field:"dtyinsuranceperitem",
                //     responsive:0,
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     headerVertical:true,
                //     formatter:"money",
                // },
                // {
                //     title:"Insurance/Item(Rs)",
                //     field:"dtyinsuranceperitemrs",
                //     responsive:0,
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     headerVertical:true,
                //     formatter:"money",
                // },

                // {
                //     title:"Amt W/Insurance (Rs)",
                //     field:"dtyamountwithoutinsurance",
                //     responsive:0,
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     headerVertical:true,
                //     formatter:"money",
                // },
                //  {
                //     title:"1% Duty (PKR)",
                //     field:"dtyonepercentdutypkr",
                //     responsive:0,
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     headerVertical:true,
                //     formatter:"money",
                // },





                // {
                // title:'Revise WSE', headerHozAlign:"center",
                //     columns:[
                // {title:"WSE",  field:"wse",   formatter:"money",editor:"number",
                //         formatterParams:{thousand:",",precision:2},          responsive:0}]
                // },

                // {
                //     title:'Price',
                //     columns:[
                //         {   title:"Supp.Price($)",
                //             field:"gdsprice",
                //             formatter:"money" ,
                //             // editor:"number",
                //             responsive:0,
                //             headerVertical:true,
                //             // cssClass:"bg-green-200 font-semibold",
                //             validator:["required","numeric"],
                //             formatterParams:{thousand:",",precision:2}
                //         },

                //     ]
                // },

                //  {
                //     title:'Amount', headerHozAlign:"center",
                //     columns:[
                        // {   title:"Supp.Val($)",
                        //     field:"amtindollar",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        // },
                        // {   title:"Supp.Val(Rs)",
                        //     field:"amtinpkr",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:0},
                        // },






                        // {   title:"Com.Invs.Price",
                        //     field:"invsrate",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     editor:"number",
                        //     formatter:"money",
                        //     // bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        // },

                        // {   title:"Com.Invs.Val($)",
                        //     field:"comamtindollar",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //      bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        // },

                        // {   title:"Com.Invs.Val(Rs)",
                        //     field:"comamtinpkr",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //      bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:0},
                        // },




                        // {title:"CD",                field:"cda", formatter:"money",
                        // formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"ST",                field:"sta", formatter:"money",
                        // formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"RD",                field:"rda", formatter:"money",
                        // formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"ACD",               field:"acda", formatter:"money",
                        // formatterParams:{thousand:",",precision:0},            responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"AST",               field:"asta",  formatter:"money",
                        // formatterParams:{thousand:",",precision:0},           responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"IT",                field:"ita",  formatter:"money",
                        // formatterParams:{thousand:",",precision:0},            responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"WSE",               field:"wsca",  formatter:"money",
                        // formatterParams:{thousand:",",precision:0},           responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                        //     {title:"Total Duty", cssClass:"bg-green-200 font-semibold",  field:"total", headerVertical:true,  formatter:"money",formatterParams:{thousand:",",precision:0},
                        //  responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},



                // {
                //     title:"Invoice Level Exp.",
                //     headerVertical:true,
                //     field:"invlvlchrgs",
                //     cssClass:"bg-green-200 font-semibold",
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     responsive:0,
                //     formatter:"money",
                //     formatterParams:{thousand:",",precision:0},
                // },




                // {
                //     title:"Tot Cost(Rs)",
                //     headerVertical:true,
                //     field:"totallccostwexp",
                //     cssClass:"bg-green-200 font-semibold",
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     responsive:0,
                //     formatter:"money",
                //     formatterParams:{thousand:",",precision:0},
                // },



                //     ]
                // },


                // {   title:"OtherExpFrPaym.",
                //             field:"otherexpenses",
                //             headerVertical:true,
                //             cssClass:"bg-green-200 font-semibold",
                //             formatter:"money",
                //             responsive:0,
                //             bottomCalc:"sum",bottomCalcParams:{precision:0},
                //             formatterParams:{thousand:",",precision:0},
                //             validator:["required","numeric"],
                //             bottomCalcParams:{precision:0}  ,
                //         },





                // {title:"CD",                field:"cd",editor:"number",responsive:0,
                // headerVertical:true,        visible:true},
                // {title:"ST",                field:"st",editor:"number",responsive:0,
                // headerVertical:true,          visible:true},
                // {title:"RD",                field:"rd",editor:"number",responsive:0,
                // headerVertical:true,        visible:true},
                // {title:"ACD",               field:"acd",editor:"number",responsive:0,
                // headerVertical:true,          visible:true},
                // {title:"AST",               field:"ast",editor:"number",responsive:0,
                // headerVertical:true,        visible:true},
                // {title:"IT",                field:"it",editor:"number",responsive:0,
                // headerVertical:true,        visible:true},
                // {title:"WSE",               field:"wse",
                // headerVertical:true,         visible:true},


                // {
                //     title:'Cost Rate/Unit', headerHozAlign:"center",
                //     columns:[
                //         {title:"Per Pc",    field:"perpc",         responsive:0 ,formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //         {title:"Per Kg",    field:"perkg",         responsive:0 , formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //         {title:"Per Feet",  field:"perft",       responsive:0 ,formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //     ]
                // },
                // {title:"Material",     field:"material_title",responsive:2},
                // {title:"Size",         field:"dimension",responsive:2},
                // {title:"Unit",         field:"sku",responsive:2},
            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {

            // var invoicedate = document.getElementById("invoicedate")
            var invoiceno = document.getElementById("invoiceno")
            var gdno = document.getElementById("gdno")
            var machineno = document.getElementById("machineno")
            // var machine_date = document.getElementById("machine_date")
            var conversionrate = document.getElementById("conversionrate")

            var sid = document.getElementById("bank_id");
            var bank_id = sid.options[sid.selectedIndex];

            if(bank_id.value <= 0)
            {
                showSnackbar("Please select From Bank");
                bank_id.focus();
                return;
            }





            if(invoiceno.value === ''){
                showSnackbar("Invoice # required ","error");
                invoiceno.focus()
                return;
            }
            if(machineno.value === ''){
                showSnackbar("machineno # required ","error");
                machineno.focus()
                return;
            }

            if(gdno.value === ''){
                showSnackbar("GD # required ","error");
                gdno.focus()
                return;
            }

            if(conversionrate.value === ''){
                showSnackbar("conversionrate # required ","error");
                conversionrate.focus()
                return;
            }



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

            // disableSubmitButton(true);
            var data = {
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                // 'sconversionrate' : parseFloat(sconversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                // 'contract_id' : contract_id,
                'invoiceno' : invoiceno.value,
                // 'challanno' : challanno.value,
                'machineno' : machineno.value,
                // 'machine_date' :machine_date.value,
                // 'invoicedate' : invoicedate.value,
                'gdno' : gdno.value,
                'gd_date' : gd_date.value,
                'dunitid' : parseFloat(dunitid.value).toFixed(0),
                'cheque_no' : cheque_no.value,
                'cheque_date' :cheque_date.value,
                'bank_id' :bank_id.value,


                // 'total' : parseFloat(banktotal.value).toFixed(2),

                'comminvoice' : dynamicTableData

            };
            // All Ok - Proceed
            fetch(@json(route('clearance.store')),{
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
                    window.open(window.location.origin + "/clearance","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }



    </script>
@endpush

</x-app-layout>
