<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Payment Voucher
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

                                {{-- <x-input-text title="shname" name="shname" id="shname" class="col-span-2" value="{{ $supplier->title }}" disabled  /> --}}

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
                                    <select autocomplete="on" class="col-span-2" name="head_id" id="head_id" >
                                        {{-- <option value="" selected>--Payment Head</option> --}}
                                        @foreach($heads as $head)
                                        @if ($head->id == $banktransaction->head_id)
                                            <option value="{{$head->id}}" selected> {{$head->title}} </option>
                                        @endif
                                        <option value="{{$head->id}}"> {{$head->title}} </option>
                                        @endforeach
                                    </select>

                                    <div class="w-96 relative grid grid-cols-4 gap-1 px-10 py-5  "   onclick="event.stopImmediatePropagation();" >
                                        {{-- <label for="autocompleted1">Sub Head<x-req /></label> --}}
                                        <input id="autocompleted1" title="Head Name" placeholder="Select Sub Head Name" value="{{ $banktransaction->supname }}" class=" px-5 py-3 w-auto border border-gray-400 rounded-md"
                                        onkeyup="onkeyUp1(event)" />
                                        <div>
                                            <select  id="supplier_id" name="supplier_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            </select>
                                        </div>
                                    </div>

                                <x-input-text title="shname" name="shname" id="shname" class="col-span-2" value="{{ $banktransaction->supname }}" hidden disabled  />
                                <x-input-date title="Payment Date" name="documentdate" class="col-span-2" value="{{ $banktransaction->documentdate->format('Y-m-d') }}"  />

                                    {{-- <label for="head_id">Payment To<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Payment Head</option>
                                        @foreach($heads as $head)
                                        <option value="{{$head->id}}"> {{$head->title}} </option>
                                        @endforeach
                                    </select> --}}
                                    <x-input-text title="Payment Seq.#" name="transno" id="transno" value="{{ $banktransaction->transno }}"  class="col-span-2"    />
                                    <x-input-numeric title="" name="paymentid" id="paymentid" value="{{ $banktransaction->id }}" hidden   />
                                    <x-input-numeric title="subhdid" name="subhdid" id="subhdid" value="{{ $banktransaction->subhead_id }}" hidden    />
                                     <x-input-numeric title="" name="lastsupplier_id" id="lastsupplier_id" value="{{ $banktransaction->subhead_id }}" hidden   />
                                        <x-input-numeric title="" name="hdid" id="hdid" value="{{ $banktransaction->head_id }}" hidden   />


                                    </div>

                            <div class="grid grid-cols-12 gap-2 py-2 ">

                            {{-- <label for="bank_id">Payment From<x-req /></label>
                            <select autocomplete="on"  name="bank_id" id="bank_id" class="col-span-2" >
                                <option value="" selected>--Payment From</option>
                                @foreach($banks as $bank)
                                @if ($bank->id == $banktransaction->bank_id)
                                    <option value="{{$bank->id}}" selected> {{$bank->title}} </option>
                                @endif
                                @endforeach
                            </select> --}}

                            <label for="bank_id">Payment From<x-req /></label>
                            <select autocomplete="on"  name="bank_id" id="bank_id" class="col-span-2" >
                                {{-- <option value="" selected>--Payment From</option> --}}
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" @if ($bank->id == $banktransaction->bank_id) selected @endif>{{$bank->title}}</option>
                                @endforeach
                            </select>


                            <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" req required class="col-span-2" value="{{ $banktransaction->cheque_no }}"  />
                            <x-input-date title="Cheque Date" id="cheque_date" name="cheque_date" req required class="col-span-2" value="{{ $banktransaction->cheque_date->format('Y-m-d') }}" />
                            <x-input-text title="Payment to" name="pmntto" id="pmntto" req required class="col-span-2" value="{{ $banktransaction->pmntto }}"  />
                           </div>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" class="col-span-2" onkeyup="chngpkr(event)" value="{{ $banktransaction->amount_fc }}"   disabled     />
                            <x-input-numeric title="Conversion Rate" name="conversion_rate" id="conversion_rate" onkeyup="chngpkr(event)" class="col-span-2" value="{{ $banktransaction->conversion_rate }}" disabled   />
                            <x-input-numeric title="Amount(PKR)" name="amount_pkr" id="amount_pkr" class="col-span-2" value="{{ $banktransaction->amount_pkr }}" disabled />
                            <label for="">
                                Invoice Level Payment <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none "  type="checkbox" name="per" id="per" @if( $banktransaction->invslvl==1  )  checked else unchecked @endif   onclick="EnableDisableTextBox(this)" >
                            <x-input-numeric title="" name="advtxt" id="advtxt"    value="{{ $banktransaction->advance }}" hidden    />
                             <x-input-numeric title="" name="head_id" class="col-span-2" value="{{ $banktransaction->head_id}}" hidden  />
                        </div>
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <label for="">
                                Description <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <textarea name="description" id="description" cols="150" rows="2" maxlength="150" class="col-span-2" required class="rounded"> {{ $banktransaction->description }} </textarea>
                            <x-input-text title="G.D No For Import Expenses" name="impgdno" id="impgdno"   class="col-span-2"  value="{{ $banktransaction->impgdno }}" disabled  />


                            {{-- <label for="">
                                Advance Payment For Clearance Future Invoices <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv" @if( $banktransaction->advance==1  )  checked else unchecked @endif    onclick="advpayment(this)" > --}}
                            <x-input-text title="Cust.DC No" name="cusinvid" id="cusinvid" class="col-span-2;w-20" value="{{ $banktransaction->cusinvid }}"  disabled     />
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="invid" id="invid" onclick="enbldspl(this)" >
                        </div>

                    </fieldset>

                        {{-- Contract Details --}}
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button
                                id="submitbutton" onclick="validateForm()"
                                class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                            <x-input-text title="Password For Edition" name="edtpw" id="edtpw" type="password"     />
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
let table;
let searchValue = "";

var getDetails = @json(route('banktransaction.quotationsdtl'));

const headlistp = @json(route('banktransaction.headlistp1'));
const head = document.getElementById('head_id')
const value = head.value

document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
        filldrplst();
        // hidedropdown();
        hidedropdown1();
     })



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

var tamountpkr=0;
var tamountusd=0;
    function tnetamount()
        {

            // console.log(tamount)
          if(tamountusd!=0 || tamountpkr!=0 )
            {
                amount_fc.value=  tamountusd
                amount_pkr.value=  tamountpkr
            }
        }




var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.payedusd) * Number(data.convrate))
        var invbal = (Number(data.invoice_amount) - Number(data.payedusd) - Number(data.purretamount))


        var amtinusd = Number(data.payedusd)

        // var invbal = (Number(data.invoice_amount) )
        var row = cell.getRow();
        row.update({
             "payedrup": sum,
             "invoice_bal":invbal,
             totalVal: sum,

             totalVal1:sum,
             totalVal2:amtinusd,


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
        var calc1 = 0;
        values.forEach(function(value){
            calc1 += Number(value) ;
        });
        tamountpkr = calc1;
        tnetamount();
        return calc1;

    }

    var totalVal2 = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        tamountusd = calc;
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
                {title:"Invoice No",     field:"invoice_no",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Invoice_Date",    field:"invoice_date",responsive:0,cssClass:"bg-gray-200 font-semibold"},



                // {title:"Variance", field:"varqty",cellEdited: updateValues,},

                {
                    title:'Payable Amount', headerHozAlign:"center",
                    columns:[
                        // {   title:"Replace Name",headerHozAlign :'center',
                        //     field:"repname",
                        //     responsive:0,
                        //     editor:true,
                        // },

                        // {   title:"Brand",headerHozAlign :'center',
                        //     field:"mybrand",
                        //     responsive:0,
                        //     editor:true,
                        // },





                        {   title:"Payable",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"invoice_amount",
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:3},
                        },


                        {   title:"Purchase Return",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"purretamount",
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:3},
                        },








                        {   title:"Currency",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"curncy",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },
                    ]},

                {
                        title:'Amount Payed', headerHozAlign:"center",
                    columns:[


                        {title:"Payed In USD.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"payedusd",
                        editor:"number",
                        cellEdited: updateValues,
                        formatter:"money",
                        formatterParams:{thousand:",",precision:3},
                        // formatter:function(cell,row)
                        // {
                        //     return (cell.getData().invoice_amount * cell.getData().convrate).toFixed(0)
                        // },
                        bottomCalc:totalVal2  },
                        // totalVal

                        {   title:"Conversion Rate",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            editor:"number",
                            field:"convrate",
                            // bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:3},
                        },


                        {title:"Payed In Rup.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"payedrup",
                        cssClass:"bg-gray-200 font-semibold",
                        formatter:"money",
                        cssClass:"bg-gray-200 font-semibold",
                        formatterParams:{thousand:",",precision:3},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().payedusd * cell.getData().convrate).toFixed(0)
                        },
                        bottomCalc:totalVal1  },
                        // bottomCalc:totalVal
                    ]},

                    {title:"Invoice Balance.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"invoice_bal",
                        formatter:"money",
                        cssClass:"bg-gray-200 font-semibold",
                        formatterParams:{thousand:",",precision:3},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().invoice_amount - cell.getData().payedusd - cell.getData().purretamount ).toFixed(0)

                        },
                         bottomCalc:totalVal,


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
            var transno = document.getElementById("transno");
            var subhdid = document.getElementById("subhdid");
            var hdid = document.getElementById("hdid");

            if(bank_id.value <0)
            {
                showSnackbar("Payment Head Required","error");
                bank_id.focus();
                return;
            }
         if(subhdid.value == "" || subhdid.value == 0 )
         {
             showSnackbar("Please select Subhead");
             autocompleted1.focus();
             return;
         }
         if(hdid.value == "" || hdid.value == 0 )
         {
             showSnackbar("Please select MainHead");
             head_id.focus();
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

    var data = { 'banktransaction' : dynamicTableData,'supplier_id':supplier_id.value,'transno':transno.value,'bank_id':bank_id.value,'documentdate':documentdate.value,
            'cheque_no':cheque_no.value,'cheque_date':cheque_date.value,'head_id':head_id.value ,'description': description.value,'transno':transno.value
        ,'amount_fc':amount_fc.value,'amount_pkr':amount_pkr.value,'conversion_rate':conversion_rate.value,'advtxt':advtxt.value,'hdid':hdid.value,'subhdid':subhdid.value,
        'paymentid':paymentid.value,'shname':shname.value,'impgdno':impgdno.value,'cusinvid':cusinvid.value,'pmntto':pmntto.value,'lastsupplier_id':lastsupplier_id.value};





    fetch(@json(route('banktransaction.update',$banktransaction)),{
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
            window.open(window.location.origin + "/banktransaction","_self" );
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
        // amount_fc.value =0;


        var conversion_rate = document.getElementById("conversion_rate");
        conversion_rate.disabled = per.checked ? true : false;
        conversion_rate.style.color ="black";
        // amount_pkr.value =0;
        // conversion_rate.value =0;


    }

    var impgdno = document.getElementById("impgdno");
        impgdno.disabled = per.checked ? true : false;
        impgdno.style.color ="black";
        // impgdno.value ='';

    function advpayment(adv) {
        var advtxt = document.getElementById("advtxt");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(adv.checked==true)
        {
            advtxt.value=1;
        }
        else
        {
            advtxt.value=0;
        }

    }

//     amount_fc.onblur=function(){
//     amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
//     // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
//    }

//    conversion_rate.onblur=function(){
//     amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
//     // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
//    }


function chngpkr()
   {

    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);

   }



   bank_id.addEventListener("change", () => {
    var sid = document.getElementById("bank_id");
        var bank_id = sid.options[sid.selectedIndex];
        if(bank_id.value==1)
        { cheque_no.disabled=true;
          cheque_date.disabled=true;
        }
        else
        { cheque_no.disabled=false;
          cheque_date.disabled=false;
        }

});



// supplier_id.addEventListener("change", () => {
//     var supname = document.getElementById("supname");
//     supname.value=supplier_id.options[supplier_id.selectedIndex].text;

//     // if(supplier_id.value != lastsupplier_id.value)
//     // { alert('subhead changed') }

// });






function enbldspl(invid) {
        var supinvid = document.getElementById("cusinvid");
        supinvid.disabled = invid.checked ? false : true;
        supinvid.style.color ="black";
        supinvid.value =0;

    }

    edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }

    supplier_id.addEventListener("click", () => {

        let supplier_id= document.getElementById("supplier_id");
        let input1= document.getElementById("autocompleted1");
        let subhdid= document.getElementById("subhdid");
        let hdid= document.getElementById("hdid");
        let shname= document.getElementById("shname");
        // dynamicTable.setData();
        input1.value=supplier_id.options[supplier_id.selectedIndex].text;
        subhdid.value=supplier_id.options[supplier_id.selectedIndex].value;
        // hdid.value =$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].mnhdid;
        shname.value =$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].shdname;
        dynamicTable.setData();
        detailsUrl = `${getDetails}/?id=${supplier_id.options[supplier_id.selectedIndex].value}`
        fetchDataFromServer(detailsUrl)
        adopted = true

        hidedropdown1();
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
                        invoice_id :        obj.invoice_id,
                        invoice_date :      obj.invoice_date,
                        invoice_dated :      obj.invoice_dated,
                        invoice_no :        obj.invoice_no,
                        invoice_amount :     obj.invoice_amount,
                        curncy:             obj.curncy,
                        convrate:           obj.convrate,
                        payedusd:           obj.payedusd,
                        payedrup:           obj.payedrup,
                        invoice_bal:        obj.invoice_bal,
                        purretamount:       obj.purretamount,

                    }
                ])
            }
        }







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

    let filteredContries=list.filter((c)=>c.supname.toLowerCase().includes(keyword.toLowerCase()));
    // console.log(filteredContries);
    renderOptions1(filteredContries);
    // e.id + '      '+ e.srchb+' '+e.dimension
}

function renderOptions1(sup){

    let dropdownEl=document.getElementById("supplier_id");


                // $shid= [];
                // $mnhdid= [];
                // $shdname= [];
                $itmdata=[];
                dropdownEl.length = 0
                sup.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.supname )
                    // $shid =e.id;
                    // $mnhdid =e.head_id;
                    // $shdname =e.osuppname;
                    $itmdata[e.id]=[ { shid:e.id,mnhdid:e.head_id,shdname:e.osuppname }  ];
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

// document.onkeydown=function(e){
//     // if(e.keyCode == 17) isCtrl=true;
//     // if(e.keyCode == 83 && isCtrl == true) {
//         if(e.ctrlKey && e.which === 83){
//         //run code for CTRL+S -- ie, save!
//         // alert("dfadfasd");
//         submitbutton.click();
//         return false;
//     }
// }


function filldrplst()
{

    const value = head.value
        // autocompleted1.value='';
        supplier_id.options.length = 0 // Reset List
        fetch(headlistp + `?head_id=${value} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;

                            $itmdata= [];
                            list=data;
                            list.forEach(e => {
                                a += 1;
                                addSelectElement(supplier_id,e.id,a + '         ' + e.supname )
                                $itmdata[e.id]=[ { shid:e.id,mnhdid:e.head_id,shdname:e.osuppname }  ];
                            });
                        }else{
                        }
                    })
                    .catch(error => console.error(error))
                // break;

}


head_id.addEventListener("change", () => {
    filldrplst();
    autocompleted1.value="";
    subhdid.value="";

});


</script>


@endpush






</x-app-layout>



