<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Received Voucher
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
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-text title="Customer Name" name="custname" id="custname" class="col-span-2" disabled  />
                                <x-input-date title="Received Date" name="documentdate" class="col-span-2" />
                                {{-- <label for="head_id">Payment To<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Payment Head</option>
                                        @foreach($heads as $head)
                                        <option value="{{$head->id}}"> {{$head->title}} </option>
                                        @endforeach
                                    </select> --}}
                                    <x-input-text title="Received Seq.#" name="transno" id="transno" value="{{$maxposeqno}}"  class="col-span-2"    />

                            </div>

                        <div class="grid grid-cols-12 gap-2 py-2 ">

                            <label for="bank_id">Received From<x-req /></label>
                            <select autocomplete="on"  name="bank_id" id="bank_id" class="col-span-2" >
                                <option value="" selected>--Received From</option>
                                @foreach($banks as $bank)
                                <option value="{{$bank->id}}"> {{$bank->title}} </option>
                                @endforeach
                            </select>

                            <x-input-text title="Cheque No/Received From" name="cheque_no" id="cheque_no" req required class="col-span-2"  />
                            <x-input-date title="Cheque Date" id="cheque_date" name="cheque_date" req required class="col-span-2" />

                        </div>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">

                            <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" class="col-span-2" disabled     />
                            <x-input-numeric title="conversion_rate" name="conversion_rate" id="conversion_rate"  class="col-span-2" value=1 disabled     />
                            <x-input-numeric title="Amount(PKR)" name="amount_pkr" id="amount_pkr" class="col-span-2" disabled  />
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" class="col-span-2" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >

                        </div>

                        <div>

                                {{-- Invoice Level Receive <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="per" id="per" checked=true onclick="EnableDisableTextBox(this)" >


                        <label for="">
                            Advance Received For Clearance Future Invoices <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                        <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv"  onclick="advpayment(this)" > --}}

                        <x-input-numeric title="Prvs. Credit Amount" name="prvscrdtamt" id="prvscrdtamt" class="col-span-2" disabled     />
                        <x-input-numeric title="Prvs. Invs.Clrd Amount" name="prvsinvsamt" id="prvsinvsamt" class="col-span-2" disabled     />

                        <x-input-numeric title="" name="advtxt" id="advtxt" value="0" hidden       />

                        <label for="">
                            Description <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                        <textarea name="description" id="description" cols="100" rows="2" maxlength="100"  required class="rounded"></textarea>
                        <label for="">



                        </div>






                    </fieldset>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                               <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                               <label for="">
                                Description <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <textarea name="description" id="description" cols="50" rows="2" maxlength="150" required class="rounded"></textarea>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
                            </div>
                        </fieldset> --}}

                        {{-- <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>

                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" title="W/Qutation" type="checkbox" value="checked" name="woq" id="woq"   >
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

window.onload = function() {
            var input = document.getElementById("bank_id").focus();
        }



        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


        var getMaster = @json(route('banktransactionr.quotations')) ;
        var getDetails = @json(route('banktransactionr.quotationsdtl'));

         let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        // let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let head_id = '';
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
            paginationSize:25,
            paginationSizeSelector:[10,25,50,100],
            ajaxParams: function(){
                return {search:searchValue};
            },
            ajaxURL: getMaster,
            ajaxContentType:"json",
            initialSort:[ {column:"custname", dir:"asc"} ],

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"", field:"mheadid" , responsive:0,visible:false},
                {title:"Master Head", field:"mhead" , responsive:0},
                {title:"Sub Head", field:"custname" , visible:true ,headerSort:false, responsive:0},
                {title:"Cheque No", field:"cheque_no" , visible:true ,headerSort:false, responsive:0},
                {title:"Cheque Date", field:"cheque_date" , visible:true ,headerSort:false, responsive:0},
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
             supplier_id=data.id
             head_id = data.head_id
             custname.value=data.custname
             cheque_no.value=data.cheque_no

             cheque_date.value= data.cheque_date

             prvscrdtamt.value=data.crdtcust
             prvsinvsamt.value=data.invsclrd
             amount_fc.value=data.AdvanceAmount
            if (data.head_id==33)
            { detailsUrl = `${getDetails}/?id=${data.id}` }
            fetchDataFromServer(detailsUrl)
            adopted = true
         //   calculateButton.disabled = false
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
                var vpcs = obj.totpcs
                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {


                        pono :        obj.pono,
                        invoice_id :  obj.invoice_id,
                        billno :      obj.billno,
                        saldate :     obj.saldate,
                        saldated :     obj.saldated,
                        dcno :        obj.dcno,
                        dcamount:     obj.dcamount,
                        staxper:      obj.staxper,
                        staxamount:   obj.staxamount,
                        totrcvble:    obj.totrcvble,
                        totrcvd :     obj.totrcvd,
                        cartage :     obj.cartage,
                        invoice_bal:  obj.invoice_bal,

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


            // console.log(tamount)
            amount_fc.value= (prvsinvsamt.value - prvscrdtamt.value) + tamount
            // console.log(amount_fc.value)

            //  discntamt.value=0;
            //   rcvblamount.value=0;
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // if (discntper.disabled)
            // {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            // if (!discntper.disabled)
            // {discntamt.value=(tamount*discntper.value/100).toFixed(0);};

            //  rcvblamount.value=  Number(tamount)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.totrcvd) )
        var invbal = (Number(data.totrcvble) - Number(data.totrcvd))
        // var varqty = ( Number(data.balqty) - Number(data.saleqty) )
        var row = cell.getRow();
        row.update({
            //  "payedrup": sum,
             "invoice_bal":invbal,
             totalVal1: sum

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


    var totalVal1 = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        tamount = calc;
        tnetamount();
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
                {title:"invoice Id",           field:"invoice_id",cssClass:"bg-gray-200 font-semibold"},
                {title:"P.O No",           field:"pono",cssClass:"bg-gray-200 font-semibold"},
                {title:"Delivery Date",     field:"saldated",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"",     field:"saldate",responsive:0,visible:false},
                {title:"DC No",     field:"dcno",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Bill No",    field:"billno",responsive:0,cssClass:"bg-gray-200 font-semibold"},



                // {title:"Variance", field:"varqty",cellEdited: updateValues,},

                {
                    title:'Receivable Amount', headerHozAlign:"center",
                    columns:[

                        {   title:"Sale Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"dcamount",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Sale Tax(%)",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"staxper",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Sale Tax Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"staxamount",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Cartage",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"cartage",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },





                        {   title:"Total Receivable Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"totrcvble",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                    ]},

                {
                        title:'Amount Received', headerHozAlign:"center",
                    columns:[


                        {title:"Received Amount.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        editor:"number",
                        field:"totrcvd",
                        formatter:"money",
                        cellEdited: updateValues,
                        formatterParams:{thousand:",",precision:1},
                        // formatter:function(cell,row)
                        // {
                        //     return (cell.getData().payedusd * cell.getData().convrate).toFixed(0)
                        // },
                        bottomCalc:totalVal1  },
                    ]},

                    {title:"Invoice Balance.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"invoice_bal",
                        formatter:"money",
                        cssClass:"bg-gray-200 font-semibold",
                        formatterParams:{thousand:",",precision:1},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().totrcvble - cell.getData().totrcvd).toFixed(0)
                        },
                        bottomCalc:totalVal

                    },





            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {


            var sid = document.getElementById("bank_id");
            var bank_id = sid.options[sid.selectedIndex];
            var transno = document.getElementById("transno")
            // var per= document.getElementById("per");

            if(bank_id.value <0)
            {
                showSnackbar("Payment Head Required","error");
                bank_id.focus();
                return;
            }








            const dynamicTableData = dynamicTable.getData();
            // if(dynamicTableData.length == 0)
            // {
            //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
            //     return;
            // }

            // for (let index = 0; index < dynamicTableData.length; index++) {
            //     const element = dynamicTableData[index];

            //     if(element.location === undefined)
            //     {
            //         showSnackbar("Location must be Enter","info");
            //         return;
            //     }
            // }


            var data = { 'banktransactionr' : dynamicTableData,'supplier_id':supplier_id,'transno':transno.value,'bank_id':bank_id.value,'documentdate':documentdate.value,
            'cheque_no':cheque_no.value,'cheque_date':cheque_date.value,'head_id':head_id ,'description': description.value,'transno':transno.value
        ,'amount_fc':amount_fc.value,'amount_pkr':amount_pkr.value,'conversion_rate':conversion_rate.value,'advtxt':advtxt.value,'custname':custname.value};


            // All Ok - Proceed
            fetch(@json(route('banktransactionr.store')),{
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
                    window.open(window.location.origin + "/banktransactionr","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

        function EnableDisableTextBox(per) {
        var amount_fc = document.getElementById("amount_fc");
        amount_fc.disabled = per.checked ? false : true;
        amount_fc.style.color ="black";
        amount_fc.value =0;


        var conversion_rate = document.getElementById("conversion_rate");
        conversion_rate.disabled = per.checked ? false : true;
        conversion_rate.style.color ="black";
        amount_pkr.value =0;
        conversion_rate.value =1;


    }

    // function advpayment(adv) {
    //     var advtxt = document.getElementById("advtxt");
    //     amount_fc.disabled = advtxt.checked ? true : false;

    //     amount_fc.disabled = per.checked ? true : false;

    //     if(adv.checked==true)
    //     {
    //         advtxt.value=1;
    //     }
    //     else
    //     {
    //         advtxt.value=0;
    //     }


    // }

    amount_fc.onblur=function(){
    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
    // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
   }

   conversion_rate.onblur=function(){
    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
    // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
   }

    </script>
@endpush

</x-app-layout>
