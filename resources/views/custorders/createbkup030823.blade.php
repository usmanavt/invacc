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

                                {{-- <label for="customer_id">Customer<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                        @endforeach
                                    </select> --}}
                                <x-input-text title="Customer Name" name="custname" id="custname" req required class="col-span-2" disabled  />
                                <x-input-text title="Quotation No" name="qutno" id="qutno" req required class="col-span-2" disabled  />
                                <x-input-text title="P.R No" name="prno" id="prno" req required class="col-span-2" disabled  />
                                <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{$maxposeqno}}"    placeholder="poseqno" required   />

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

                        {{-- <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>

                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" title="W/Qutation" type="checkbox" value="checked" name="woq" id="woq"  >
                        </div> --}}



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
        const getMaster = @json(route('custorders.quotations'));
        //  console.log(getMaster)
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
        let quotation_id = '';
        let customer_id = '';


        let prno= document.getElementById("prno")
        // var conversionrate = document.getElementById("conversionrate");
        // var insurance = document.getElementById("insurance");
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
            customer_id=data.customer_id
            quotation_id = data.id
            customer_id=data.customer_id
            prno.value = data.prno
            qutno.value = data.qutno
            discntper.value=data.discntper
            custname.value=data.custname


            discntper.value=data.discntper
            discntamt.value=data.discntamt
            cartage.value=data.cartage

            saletaxper.value=data.saletaxper
            saletaxamt.value=data.saletaxamt
            rcvblamount.value=data.rcvblamount
            totrcvbamount.value=data.totrcvbamount












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
                        quotation_id :      obj.quotation_id,
                        material_id :       obj.material_id,
                        customer_id :       obj.customer_id,
                        user_id :           obj.user_id,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,
                        // pono:               '',

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

var tamount=0;
    function tnetamount()
        {
            //  discntamt.value=0;
            //  rcvblamount.value=0;
            discntamt.value=(tamount*discntper.value/100).toFixed(0);
            discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);
        }








var updateValues = (cell) => {
        var data = cell.getData();
        // var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var sum = (Number(data.saleqty) * Number(data.price))
        var row = cell.getRow();
        row.update({
             "saleamnt": sum,
             totalVal: sum

        });
    }

    var totalVal = function(values, data, calcParams){
        //values - array of column values
        //data - all table data
        //calcParams - params passed from the column definition object
        // console.log(data);
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;

        });
        tamount = calc;
        tnetamount();
        // discntamt.value=(calc*bankcharges.value/100).toFixed(0);
        // rcvblamount.value=calc - discntamt.value ;
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
                {title:"Material Name",     field:"material_title",responsive:0},
                {title:"Material Size",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"UOM",         field:"sku",responsive:0, hozAlign:"center"},
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


                        {title:"Sale Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"saleamnt",
                        cssClass:"bg-gray-200 font-semibold",
                        formatter:"money",
                        cssClass:"bg-green-200 font-semibold",
                        formatterParams:{thousand:",",precision:3},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().saleqty * cell.getData().price)
                        },
                        bottomCalc:totalVal  },


                    ]
                },


            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {

            // var invoicedate = document.getElementById("invoicedate")
            var pono = document.getElementById("pono")
            var poseqno = document.getElementById("poseqno")
            // var machineno = document.getElementById("machineno")
            // var machine_date = document.getElementById("machine_date")
            // var conversionrate = document.getElementById("conversionrate")

            // var sid = document.getElementById("bank_id");
            // var bank_id = sid.options[sid.selectedIndex];

            if(pono.value === '')
            {
                showSnackbar("P.O No Required","error");
                pono.focus();
                return;
            }





            // if(invoiceno.value === ''){
            //     showSnackbar("Invoice # required ","error");
            //     invoiceno.focus()
            //     return;
            // }
            // if(machineno.value === ''){
            //     showSnackbar("machineno # required ","error");
            //     machineno.focus()
            //     return;
            // }

            // if(gdno.value === ''){
            //     showSnackbar("GD # required ","error");
            //     gdno.focus()
            //     return;
            // }

            // if(conversionrate.value === ''){
            //     showSnackbar("conversionrate # required ","error");
            //     conversionrate.focus()
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

            // // disableSubmitButton(true);
            // var data = {
            //     // 'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
            //     // 'sconversionrate' : parseFloat(sconversionrate.value).toFixed(2),
            //     // 'insurance' : parseFloat(insurance.value).toFixed(2),
            //     // 'contract_id' : contract_id,
            //     'invoiceno' : invoiceno.value,
            //     // 'challanno' : challanno.value,
            //     'pono' : pono.value,
            //     // 'machine_date' :machine_date.value,
            //     // 'invoicedate' : invoicedate.value,
            //     // 'gdno' : gdno.value,
            //     'podate' : podate.value,
            //     // 'sku_id' : sku_id.value,
            //     'cheque_no' : cheque_no.value,
            //     'cheque_date' :cheque_date.value,
            //     'bank_id' :bank_id.value,


            //     // 'total' : parseFloat(banktotal.value).toFixed(2),

            //     'comminvoice' : dynamicTableData

            // };

            var data = { 'contracts' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id,'deliverydt':deliverydt.value,'quotation_id':quotation_id,'poseqno':poseqno.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'podate':podate.value,'pono':pono.value,'remarks':remarks.value,'qutno':qutno.value,'prno':prno.value};




            // All Ok - Proceed
            fetch(@json(route('customerorder.store')),{
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
                    window.open(window.location.origin + "/customerorder","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }





    discntper.onblur=function(){
    per=false
    // discntamt.value=(tamount*discntper.value/100).toFixed(0);
    // tnetamount();
            discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);
}

discntamt.onblur=function(){
    // discntper.value=(discntamt.value/tamount*100).toFixed(2);
    // tnetamount1();
            discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);


}
    </script>
@endpush

</x-app-layout>
