<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Received Voucher
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

                                {{-- <x-input-text title="Supplier Name" name="supname" id="supname" class="col-span-2" value="{{ $banktransaction->supname }}" disabled  /> --}}

                                    {{-- <label for="supplier_id">Supplier</label>
                                    <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                        @foreach($suppliers as $supplier)
                                            @if ($supplier->id == $banktransaction->subhead_id)
                                                <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                            @endif
                                            <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                        @endforeach
                                    </select> --}}

                                    <label for="head_id">Main Head<x-req /></label>

                                    <select  autocomplete="on" class="col-span-2" name="head_id" id="head_id" style="text-align: right"  >
                                            {{-- <option value="" selected>--Payment Head</option> --}}
                                            @foreach($heads as $head)
                                            @if ($head->id == $banktransaction->head_id)
                                                <option value="{{$head->id}}" selected> {{$head->title}} </option>
                                            @else
                                            <option value="{{$head->id}}"> {{$head->title}} </option>
                                            @endif

                                            @endforeach
                                        </select>


                                        <div class="w-96 relative grid grid-cols-4 gap-1 px-10 py-5  "   onclick="event.stopImmediatePropagation();" >
                                            {{-- <label for="autocompleted1">Sub Head<x-req /></label> --}}
                                            {{-- <input id="autocompleted1" title="Head Name" value="{{ $banktransaction->supname }}" placeholder="Select Sub Head Name" class="col-span-2 px-5 py-3 w-auto border border-gray-400 rounded-md" --}}
                                            <input id="autocompleted1" title="Head Name" placeholder="Select Sub Head Name" class=" px-5 py-3 w-auto border border-gray-400 rounded-md"
                                            onkeyup="onkeyUp1(event)" />
                                            <div>
                                                <select  id="supplier_id" name="supplier_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </select>
                                            </div>
                                        </div>
                                        {{-- </div> --}}


                                        {{-- <x-input-text title="Customer Name" name="supname" id="supname" class="col-span-2" value="{{ $banktransaction->supname }}" disabled  /> --}}
                                <x-input-date title="Received Date" name="documentdate" style="text-align:right" class="col-span-2" value="{{ $banktransaction->documentdate->format('Y-m-d') }}"  />
                                    <x-input-text title="Received Seq.#" name="transno" id="transno" value="{{ $banktransaction->transno }}"  class="col-span-2"    />
                                    <x-input-numeric title="" name="receivedid" id="receivedid" value="{{ $banktransaction->id }}" hidden   />
                                    <x-input-numeric title="" name="subhead_id" id="subhead_id"  value="{{ $banktransaction->subhead_id }}" hidden  />
                                    </div>

                        <div class="grid grid-cols-12 gap-2 py-2 ">

                            <label for="bank_id">Received From<x-req /></label>
                            <select autocomplete="on"  name="bank_id" id="bank_id" class="col-span-2" >
                                {{-- <option value="" selected>--Received From</option> --}}
                                @foreach($banks as $bank)
                                {{-- @if ($bank->id == $banktransaction->bank_id) --}}
                                    {{-- <option value="{{$bank->id}}" selected> {{$bank->title}} </option> --}}
                                    <option value="{{ $bank->id }}" @if ($bank->id == $banktransaction->bank_id) selected @endif>{{$bank->title}}</option>

                                {{-- @endif --}}
                                @endforeach
                            </select>

                            <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" req required class="col-span-2" value="{{ $banktransaction->cheque_no }}"  />
                            <x-input-date title="Cheque Date" id="cheque_date" name="cheque_date" req required class="col-span-2" value="{{ $banktransaction->cheque_date->format('Y-m-d') }}" />
                            <x-input-text title="Cheque Amount" name="chqamount" id="chqamount" disabled  class="col-span-2"    />
                            <x-input-text title="Payment to" name="pmntto" id="pmntto"  class="col-span-2" value="{{ $banktransaction->pmntto }}"  />



                        </div>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" class="col-span-2" onkeyup="chngpkr(event)" value="{{ $banktransaction->amount_fc }}"      />


                                {{-- <label for="">
                                    Invoice Level Receive <span class="text-red-500 font-semibold  ">(*)</span>
                                    </label>



                                <label for="">
                                    Advance Receive For Clearance Future Invoices <span class="text-red-500 font-semibold  ">(*)</span>
                                    </label>
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv" @if( $banktransaction->advance==1  )  checked else unchecked @endif    onclick="advpayment(this)" > --}}

                                <x-input-numeric tabindex="-1" title="conversion_rate" name="conversion_rate" id="conversion_rate" onkeyup="chngpkr(event)" class="col-span-2"  value="{{ $banktransaction->conversion_rate }}"    />
                                <x-input-numeric title="Amount(pkr)" name="amount_pkr" id="amount_pkr" class="col-span-2"  value="{{ $banktransaction->amount_pkr }}" disabled />
                                 <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none " class="col-span-2"  type="checkbox" name="per" id="per"   onclick="EnableDisableTextBox(this)" >
                                 {{-- @if( $banktransaction->invslvl==1  )  checked else unchecked @endif  --}}
                                 <x-input-numeric title="" name="advtxt" id="advtxt"    value="{{ $banktransaction->advance }}" hidden    />
                                <x-input-numeric title="" name="head_id" class="col-span-2" value="{{ $banktransaction->head_id}}" hidden  />

                                </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <label for="">
                                    Description <span class="text-red-500 font-semibold  ">(*)</span>
                                    </label>
                                <textarea name="description" id="description" cols="150" rows="2" maxlength="150" class="col-span-2" required class="rounded"> {{ $banktransaction->description }} </textarea>
                                <x-input-text title="Supp.Invoice No" name="supinvid" id="supinvid" class="col-span-2" value="{{ $banktransaction->supinvid }}"    disabled     />
                                <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="invid" id="invid" onclick="enbldspl(this)" >

                            </div>

                            <div>

                                <x-input-text  title="" name="hdid" id="hdid" value="{{ $banktransaction->head_id }}" hidden       />
                                {{-- <x-input-text  title="subhead" name="subhdid" id="subhdid" value="{{ $banktransaction->subhead_id }}"        /> --}}
                                <x-input-text  title="" name="shname" id="shname" value="{{ $banktransaction->supname }}" hidden      />
                                <x-input-text title="" name="chqno" id="chqno" class="col-span-2"  hidden value="{{ $banktransaction->cheque_no }}"  hidden   />
                                <x-input-text  title="" name="lastsubhdid" id="lastsubhdid" value="{{ $banktransaction->subhead_id }}" hidden       />


                            </div>


                        </fieldset>

                        {{-- Contract Details --}}
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button
                                id="submitbutton"  onclick="validateForm()"
                                class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                            <x-input-text title="Password For Edition Permission" name="edtpw" id="edtpw" type="password"     />
                            <x-input-text title="" name="dbpwrd2" id="dbpwrd2"  class="col-span-2" hidden value="{{$passwrd}}" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
    @endpush

    {{-- Modal - Should come below Tabulator --}}
    <x-tabulator-modal title="Material"/>



    @push('scripts')
<script>

let submitButton = document.getElementById("submitbutton")

document.addEventListener('DOMContentLoaded',()=>{
        //  submitButton.disabled = true
        document.getElementById("submitbutton").disabled = true;
        filldrplst();
        // hidedropdown();
        hidedropdown1();



     })



let table;
let searchValue = "";


const headlist = @json(route('banktransactionr.headlist'));
        const head = document.getElementById('head_id')
        const value = head.value
        var getDetails = @json(route('banktransactionr.quotationsdtl'));

var tamount=0;
function tnetamount()
        {

        if(tamount!==0)
          {
            amount_fc.value=  tamount
            amount_pkr.value=  tamount
          }

        }




// console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
const getMaster = @json(route('banktransaction.quotations')); // For Material Modal
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);
// let head_id = '';
// let supplier_id = '';


// Populate sku in Tabulator

    //  ---------------- For MODAL -----------------------//
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
        paginationSize:15,
        paginationSizeSelector:[10,15,20,30],
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
                {title:"", field:"mheadid" , responsive:0,visible:false},
                {title:"Master Head", field:"mhead" , responsive:0},

                {title:"Sub Head", field:"supname" , visible:true ,headerSort:false, responsive:0},
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
        }
    })
    //  Adds New row to dyanmicTable
    table.on('rowClick',function(e,row){
        var simple = {...row}
        var data = simple._row.data
        //  Filter Data here .
        // console.log(data.id)
        // var result = dynamicTableData.filter( dt => dt.material_id == data.id)
        var result = dynamicTableData.filter( dt => dt.material_id == data.id)
        if(result.length <= 0)
        {
            pushDynamicData(data)

        }
    })
    function showModal(){ modal.style.display = "block"}
    function closeModal(){  modal.style.display = "none"}
    //  When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    // -----------------FOR MODAL -------------------------------//

//  Adds actual data to row - EDIT Special
function pushDynamicData(data)
{

    dynamicTableData.push({
        material_id:data.id,
        material_title:data.title,
        category_id:data.category_id,
        category:data.category,


        sku_id:data.sku_id,
        sku:data.sku,

        dimension_id:data.dimension_id,
        dimension:data.dimension,

        bundle1:0,
        bundle2:0,
        pcspbundle1:0,
        pcspbundle2:0,
        gdswt:0,
        gdsprice:0,
        gdspricetot:0
    })
    //  dyanmicTable.setData()
     dynamicTable.setData(dynamicTableData);
}

supplier_id.addEventListener("click", () => {

let supplier_id= document.getElementById("supplier_id");
let input1= document.getElementById("autocompleted1");
let subhead_id= document.getElementById("subhead_id");
// let hdid= document.getElementById("hdid");
let shname= document.getElementById("shname");
let cheque_date= document.getElementById("cheque_date");
let cheque_no= document.getElementById("cheque_no");
let chqno= document.getElementById("chqno");
let chqamount= document.getElementById("chqamount");

dynamicTable.setData();
subhead_id.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].shid;
shname.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].subhdname;
// hdid.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].mnhdid;
cheque_no.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqno;
chqno.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqno;
cheque_date.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqdt;
chqamount.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].mychqamount;
input1.value=supplier_id.options[supplier_id.selectedIndex].text;
hidedropdown1();
detailsUrl = `${getDetails}/?id=${subhead_id.value}`
    fetchDataFromServer(detailsUrl)
    adopted = true

});

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
                        saleretamount:obj.saleretamount,

                    }
                ])
            }
        }







var updateValues = (cell) => {
        var data = cell.getData();
        var invbal = (Number(data.totrcvble) - Number(data.totrcvd) - Number(data.saleretamount))
        var row = cell.getRow();
        row.update({
             "invoice_bal":invbal
            //  totalVal1: sum,

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




//  Dynamic Table [User data]
dynamicTable = new Tabulator("#dynamicTable", {
    data:dynamicTableData,
    layout:'fitData',
    reactiveData:true,
    columns:[
        {title:"Delete" , formatter:deleteIcon, headerSort:false, responsive:0,
            cellClick:function(e, cell){
                cell.getRow().delete();
                dynamicTableData = dynamicTable.getData(); // Ensure that our data is clean
                dynamicTable.redraw();
                // disableSubmitButton();
            }
        },

                {title:"S.No",            field:"sno", formatter:"rownum",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"invoice Id",           field:"invoice_id",cssClass:"bg-gray-200 font-semibold"},
                {title:"P.O No",           field:"pono",cssClass:"bg-gray-200 font-semibold"},
                {title:"Delivery Date",     field:"saldate",responsive:0,cssClass:"bg-gray-200 font-semibold"},
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

                        {   title:"Sale Return",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"saleretamount",
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
                            return (cell.getData().totrcvble - cell.getData().totrcvd - cell.getData().saleretamount  ).toFixed(0)
                        },
                        bottomCalc:totalVal

                    },


            ],
        })

        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });

// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to show Modal
    if(e.ctrlKey && e.keyCode == 532){
        showModal()
    }
})
// Ensure Buttons Are Closed
function disableSubmitButton()
{
    if(dynamicTableData.length <= 0 )
    {
        document.getElementById("submitbutton").disabled = true;
    }else {
        document.getElementById("submitbutton").disabled = false;
    }
}
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
         if(subhead_id.value == "" || subhead_id.value==0 )
         {
             showSnackbar("Please select Subhead");
             autocompleted1.focus();
             return;
         }
        // if(poseqno.value == 0)
        // {
        //     showSnackbar("Please add poseqno");
        //     poseqno.focus();
        //     return;
        // }

        // if(prno.value == "")
        // {
        //     showSnackbar("Please add prno");
        //     prno.focus();
        //     return;
        // }

        // if(customer_id.value == 0)
        // {



        // }



        // if(gpno.value == "")
        // {
        //     showSnackbar("Please add gpno");
        //     gpno.focus();
        //     return;
        // }
    // if(dynamicTableData.length == 0)
    // {
    //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
    //     return;
    // }
    dynamicTableData = dynamicTable.getData();
    // Qty Required
    for (let index = 0; index < dynamicTableData.length; index++) {
        const element = dynamicTableData[index];
        if(element.qtykg == 0 || element.price == 0  || element.saleamnt == 0)
        {
            showSnackbar("Please fill qtykg,price,saleamnt  all rows to proceed","info");
            return;
        }
    }
    // 'total' : parseFloat(banktotal.value).toFixed(2),
    disableSubmitButton(true);
    //  var data = { 'sales' : dynamicTableData,'contract_id':parseFloat(contract_id.value).toFixed(0),'bankntotal':parseFloat(bankntotal.value).toFixed(0),'collofcustom':parseFloat(exataxoffie.value).toFixed(0),'exataxoffie':parseFloat(exataxoffie.value).toFixed(0) ,'bankcharges':parseFloat(bankcharges.value).toFixed(0) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value};
    //  var data = { 'customerorder' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value ,
    //  'customer_id': customer_id.value,'saldate':saldate.value,'qutno':qutno.value,'prno':prno.value,'sale_invoice_id':sale_invoice_id.value,
    //  'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
    //  'valdate':valdate.value,'cashcustomer':cashcustomer.value,'cashcustadrs':cashcustadrs.value};

     // var data = { 'contracts' : dynamicTableData,'banktotal':parseFloat(total.value).toFixed(2),'exataxoffie':parseFloat(exataxoffie.value).toFixed(2),'collofcustom':parseFloat(collofcustom.value).toFixed(2),'bankcharges':parseFloat(bankcharges.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':number.value};
    // All Ok - Proceed

    var data = { 'banktransactionr' : dynamicTableData,'subhead_id':subhead_id.value,'transno':transno.value,'bank_id':bank_id.value,'documentdate':documentdate.value,
            'cheque_no':cheque_no.value,'cheque_date':cheque_date.value,'head_id':head_id.value ,'description': description.value,'transno':transno.value
        ,'amount_fc':amount_fc.value,'amount_pkr':amount_pkr.value,'conversion_rate':conversion_rate.value,'advtxt':advtxt.value,
        'shname':shname.value,'receivedid':receivedid.value,'supinvid':supinvid.value,'pmntto':pmntto.value,'hdid':hdid.value,'lastsubhdid':lastsubhdid.value};

    fetch(@json(route('banktransactionr.update',$banktransaction)),{
        credentials: 'same-origin', // 'include', default: 'omit'
        method: 'PUT', // 'GET', 'PUT', 'DELETE', etc.
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
        disableSubmitButton(false);
    })
}

function EnableDisableTextBox(per) {
        var amount_fc = document.getElementById("amount_fc");
        amount_fc.disabled = per.checked ? true : false;
        amount_fc.style.color ="black";

        var conversion_rate = document.getElementById("conversion_rate");
        conversion_rate.disabled = per.checked ? true : false;
        conversion_rate.style.color ="black";

    }
    function enbldspl(invid) {
        var supinvid = document.getElementById("supinvid");
        supinvid.disabled = invid.checked ? false : true;
        supinvid.style.color ="black";
        supinvid.value ='';

    }


function chngpkr()
   {

    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);

   }

   edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }


// ********* search list for suppliers

const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

list=@json($resultArray1);
// const contries1 = myarray1;
function onkeyUp1(e)
{
    let keyword= e.target.value;
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.remove("hidden");

    let filteredContries=list.filter((c)=>c.custname.toLowerCase().includes(keyword.toLowerCase()));
    // console.log($mychqno);
    renderOptions1(filteredContries);

}


var mychqno=[] ;
function renderOptions1(sup){

    let dropdownEl=document.getElementById("supplier_id");


                 $mychqno=[];
                //  $mnhdid=[];
                dropdownEl.length = 0
                // a=0;
                sup.forEach( e =>  {
                    addSelectElement(dropdownEl,e.id,e.custname )
                    // a=a+1;
                    // $shid =e.id;
                    // $mnhdid =e.head_id;
                    // $mychqdt =e.cheque_date;
                     $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id,subhdname:e.dspcustname }  ];

                    });


}

document.addEventListener("click" , () => {
    // hidedropdown();
    hidedropdown1();
});


function hidedropdown1()
{
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.add("hidden");
}






supplier_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
// event.preventDefault();
supplier_id.click();

}
});


head_id.addEventListener("change", () => {
    filldrplst();
    autocompleted1.value="";
    subhead_id.value="";
    shname.value=''


});

function filldrplst()
{
    const value = head.value
        // autocompleted1.value='';
        supplier_id.options.length = 0 // Reset List
        fetch(headlist + `?head_id=${value} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;

                            $mychqno=[];
                            list=data;
                            list.forEach(e => {
                                a += 1;
                                addSelectElement(supplier_id,e.id,e.custname )
                                $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id,subhdname:e.dspcustname }  ];
                            });
                        }else{
                        }
                    })
                    .catch(error => console.error(error))

}




</script>


@endpush






</x-app-layout>



