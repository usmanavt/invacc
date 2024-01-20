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

                                {{-- <x-input-text title="Supplier Name" name="supname" id="supname" class="col-span-2" value="{{ $supplier->title }}" disabled  /> --}}

                                    {{-- <label for="supplier_id">Supplier</label>
                                    <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                        @foreach($suppliers as $supplier)
                                            @if ($supplier->id == $banktransaction->subhead_id)
                                                <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                            @endif
                                            <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                        @endforeach
                                    </select> --}}
                                <x-input-text title="Supplier Name" name="supname" id="supname" class="col-span-2" value="{{ $banktransaction->supname }}" disabled  />
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
                                    <x-input-numeric title="" name="supplier_id" id="supplier_id" value="{{ $banktransaction->subhead_id }}" hidden  />
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


                            <x-input-text title="Cheque No/Payment to" name="cheque_no" id="cheque_no" req required class="col-span-2" value="{{ $banktransaction->cheque_no }}"  />
                            <x-input-date title="Cheque Date" id="cheque_date" name="cheque_date" req required class="col-span-2" value="{{ $banktransaction->cheque_date->format('Y-m-d') }}" />

                        </div>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" class="col-span-2" value="{{ $banktransaction->amount_fc }}"   disabled     />
                            <x-input-numeric title="Conversion Rate" name="conversion_rate" id="conversion_rate" class="col-span-2" value="{{ $banktransaction->conversion_rate }}" disabled   />
                            <x-input-numeric title="Amount(PKR)" name="amount_pkr" id="amount_pkr" class="col-span-2" value="{{ $banktransaction->amount_pkr }}" disabled />
                            <x-input-numeric title="" name="advtxt" id="advtxt"    value="{{ $banktransaction->advance }}" hidden    />
                             <x-input-numeric title="" name="head_id" class="col-span-2" value="{{ $banktransaction->head_id}}" hidden  />
                        </div>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <label for="">
                                Description <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <textarea name="description" id="description" cols="150" rows="2" maxlength="150" class="col-span-2" required class="rounded"> {{ $banktransaction->description }} </textarea>
                            <x-input-text title="G.D No For Import Expenses" name="impgdno" id="impgdno"   class="col-span-2"  value="{{ $banktransaction->impgdno }}" disabled  />

                            <label for="">
                                Invoice Level Payment <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none "  type="checkbox" name="per" id="per" @if( $banktransaction->invslvl==1  )  checked else unchecked @endif   onclick="EnableDisableTextBox(this)" >


                            <label for="">
                                Advance Payment For Clearance Future Invoices <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv" @if( $banktransaction->advance==1  )  checked else unchecked @endif    onclick="advpayment(this)" >
                        </div>

                        </fieldset>

                        {{-- Contract Details --}}
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                id="submitbutton" onclick="validateForm()"
                                class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </button>
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

var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.payedusd) * Number(data.convrate))
        var invbal = (Number(data.invoice_amount) - Number(data.payedusd))
        // var varqty = ( Number(data.balqty) - Number(data.saleqty) )
        var row = cell.getRow();
        row.update({
             "payedrup": sum,
             "invoice_bal":invbal,
             totalVal: sum

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
                        bottomCalc:totalVal  },

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
                        bottomCalc:totalVal  },
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
                            return (cell.getData().invoice_amount - cell.getData().payedusd).toFixed(0)
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
        // if(saldate.value === "")
        // {
        //     showSnackbar("Please select From Invoice Date");
        //     saldate.focus();
        //     return;
        // }
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
        ,'amount_fc':amount_fc.value,'amount_pkr':amount_pkr.value,'conversion_rate':conversion_rate.value,'advtxt':advtxt.value,'paymentid':paymentid.value,'supname':supname.value,'impgdno':impgdno.value};





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
        amount_fc.value =0;


        var conversion_rate = document.getElementById("conversion_rate");
        conversion_rate.disabled = per.checked ? true : false;
        conversion_rate.style.color ="black";
        amount_pkr.value =0;
        conversion_rate.value =0;


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

    amount_fc.onblur=function(){
    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
    // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
   }

   conversion_rate.onblur=function(){
    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
    // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
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





</script>


@endpush






</x-app-layout>



