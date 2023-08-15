<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Delivery Challan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            {{-- Contract Master --}}



                            <label for="customer_id">Customer</label>
                            <select  autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" disabled required>
                                @foreach($customer as $customer)
                                    @if ($customer->id == $saleinvoices->customer_id)
                                    <option value="{{$customer->id}}" selected> {{$customer->title}} </option>
                                @endif
                                    <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>

                            <x-input-text title="" name="custplan_id" id="custplan_id" value="{{ $saleinvoices->custplan_id }}" hidden     />
                            {{-- <x-input-text title="Quotation No" name="qutno" id="qutno" value="{{ $customerorder->pqutno }}" disabled     />
                            <x-input-text title="P.R No" name="prno" id="prno" value="{{ $customerorder->pprno }}" disabled     />
                            <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{ $customerorder->poseqno }}"    required   /> --}}

                                <x-input-text title="P.O No" name="pono" id="pono" req required class="col-span-2" value="{{ $saleinvoices->pono }}" disabled  />
                                <x-input-date title="P.O Date" name="podate" id="podate" req required class="col-span-2" value="{{ $saleinvoices->podate->format('Y-m-d') }}" disabled  />
                                <x-input-text title="G.Pass No" name="gpno" id="gpno" value="{{ $saleinvoices->gpno }}"     required   />





                        </div>
                        <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-date title="Deilivery Date" id="deliverydt" name="deliverydt" req required class="col-span-2" value="{{ $saleinvoices->saldate->format('Y-m-d') }}" />
                            <x-input-text title="DC No" name="dcno" id="dcno" value="{{ $saleinvoices->dcno }}"     required   />
                            <x-input-text title="Bill No" name="billno" id="billno" value="{{ $saleinvoices->billno }}"     required   />


                            {{-- <x-input-date title="P.O Date" id="podate" name="podate" value="{{ $customerorder->podate->format('Y-m-d') }}" req required class="col-span-2" />
                            <x-input-text title="P.O #" name="pono" id="pono" value="{{ $customerorder->pono }}"  />
                            <x-input-date title="Delivery Date" name="deliverydt" value="{{ $customerorder->deliverydt->format('Y-m-d') }}" />


                            <label for="">
                                Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                            <textarea name="remarks" id="remarks" cols="100" rows="2" maxlength="150" required class="rounded">
                                {{ $customerorder->remarks }}

                            </textarea> --}}
                        </div>
                    </fieldset>


                        </div>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" value="{{ $saleinvoices->discntper }}" disabled    />
                                    {{-- <div class="basis-0 md:basis-1/5 self-center pt-4"> --}}
                                        <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                        {{-- <label class="inline-block text-gray-800"> --}}

                                        {{-- </label> --}}
                                    {{-- </div> --}}


                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $saleinvoices->discntamt }}"    />
                                <x-input-numeric title="Cartage" name="cartage" value="{{ $saleinvoices->cartage }}"  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Payble Amount" name="rcvblamount" value="{{ $saleinvoices->rcvblamount }}" disabled />
                                <x-input-numeric title="" name="sale_invoice_id" id="sale_invoice_id" value="{{ $saleinvoices->id }}" hidden  />
                            </div>

                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" value="{{ $saleinvoices->saletaxper }}" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" value="{{ $saleinvoices->saletaxamt }}" disabled    />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" value="{{ $saleinvoices->totrcvbamount }}" disabled />
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

const locations = @json($locations);
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})

        });

let table;
let searchValue = "";


// console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
const getMaster = @json(route('materials.master')); // For Material Modal
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);


// Populate sku in Tabulator
const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})
        });

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
            {title:"Material", field:"title" , visible:true ,headerSort:false, responsive:0},
            {title:"Category", field:"category" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Source", field:"source" ,  responsive:0},
            {title:"Sku", field:"sku" ,  responsive:0},
            {title:"Brand", field:"brand" ,  responsive:0},
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
        // location:datea.location;

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

    sum = 0;
    sum2=0;
    var data = cell.getData();
        //   var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var row = cell.getRow();
            // var sum = (Number(data.qtykg) * Number(data.price))
            if(cell.getData().sku_id==1)
         {
            var sum = (Number(data.qtykg) * Number(data.price))
         }
         if(cell.getData().sku_id==2)
         {
            var sum = (Number(data.qtypcs) * Number(data.price))
         }

         if(cell.getData().sku_id==3)
         {
            var sum = (Number(data.qtyfeet) * Number(data.price))
         }

        row.update({

            // "rcvblamount":sum2,
            //  "saleamnt": sum,
            //  "totval":sum,
            //  "gdspricetot": sum2
            "saleamnt": sum,
            totval: sum

            });

    }
    // var tamount=0;
    function tnetamount()
        {

            // tamount=rcvblamount
            if (discntper.disabled)
            {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            if (!discntper.disabled)
            {discntamt.value=(tamount*discntper.value/100).toFixed(0);};


            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);



        }


var totval = function(values, data, calcParams){
var calc = 0;
// var abc=0;
values.forEach(function(value){
    // if(value > 18){
        calc += Number(value) ;
        // abc += Number(value) ;
    // }

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

        {title:"Id",                field:"material_id",    cssClass:"bg-gray-200 font-semibold"},
        {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
        {title:"Replace Description",field:"repname",       cssClass:"bg-gray-200 font-semibold",editor:true},
        {title:"Brand",             field:"brand",editor:true,         cssClass:"bg-gray-200 font-semibold"},
        {title:"UOM",               field:"sku"},

        {
                title:'STOCK QUANTITY', headerHozAlign:"center",
                    columns:[
                {title:"Qty(kg)", field:"sqtykg"},
                {title:"Qty(pcs)", field:"sqtypcs"},
                {title:"Qty(feet)", field:"sqtyfeet"}]},

                // {title:"Order BalQty",headerHozAlign :'center',
                //             field:"balqty",


                        },






        {title: "id",field: "myid",visible:false},
                {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                        values:newList,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },







            {   title:"Sale Qty(kg)",
                field:"qtykg",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
               },

               {   title:"Sale Qty(pcs)",
                field:"qtypcs",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
               },

               {   title:"Sale Qty(feet)",
                field:"qtyfeet",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
               },




               { title:"Rate",
                field:"price",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,3)"] ,
                cellEdited: updateValues   ,
            },



            {   title:"Amount",
                field:"saleamnt",
                cssClass:"bg-gray-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:0},
                // formatter:function(cell,row)
                // {
                //     //  return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)
                //      return  ( cell.getData().qtykg * cell.getData().price)
                // },
                bottomCalc:totval  },



    ],
})

// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to show Modal
    if(e.ctrlKey && e.keyCode == 32){
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
    var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        var deliverydt = document.getElementById("deliverydt");
        var qutno = document.getElementById("qutno");
        var prno = document.getElementById("prno");
        var podate = document.getElementById("podate");
        var custplan_id = document.getElementById("custplan_id");

        var discntper= document.getElementById("discntper");
        var cartage= document.getElementById("cartage");
        var discntamt= document.getElementById("discntamt");
        var rcvblamount= document.getElementById("rcvblamount");
        var per= document.getElementById("per");


    // Required
    if(customer_id.value < 0)
        {
            showSnackbar("Please select From Customer");
            customer_id.focus();
            return;
        }
        // if(saldate.value === "")
        // {
        //     showSnackbar("Please select From Invoice Date");
        //     saldate.focus();
        //     return;
        // }
        // if(dcno.value == 0)
        // {
        //     showSnackbar("Please add dcno");
        //     dcno.focus();
        //     return;
        // }

        if(dcno.value == "")
        {
            showSnackbar("Please add dcno");
            dcno.focus();
            return;
        }

        // if(customer_id.value == 0)
        // {


            if(pono.value == "" )
            {
            showSnackbar("Please add pono");
            pono.focus();
            return;
             }
        // }



        if(gpno.value == "")
        {
            showSnackbar("Please add gpno");
            gpno.focus();
            return;
        }
    if(dynamicTableData.length == 0)
    {
        showSnackbar("You must have atleast 1 row of item to Proceed","info");
        return;
    }
    dynamicTableData = dynamicTable.getData();
    // Qty Required
    // for (let index = 0; index < dynamicTableData.length; index++) {
    //     const element = dynamicTableData[index];
    //     if(element.qtykg == 0 || element.price == 0  || element.saleamnt == 0)
    //     {
    //         showSnackbar("Please fill qtykg,price,saleamnt  all rows to proceed","info");
    //         return;
    //     }
    // }
    // 'total' : parseFloat(banktotal.value).toFixed(2),
    disableSubmitButton(true);
    //  var data = { 'sales' : dynamicTableData,'contract_id':parseFloat(contract_id.value).toFixed(0),'bankntotal':parseFloat(bankntotal.value).toFixed(0),'collofcustom':parseFloat(exataxoffie.value).toFixed(0),'exataxoffie':parseFloat(exataxoffie.value).toFixed(0) ,'bankcharges':parseFloat(bankcharges.value).toFixed(0) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value};
    //  var data = { 'customerorder' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value ,
    //  'customer_id': customer_id.value,'saldate':saldate.value,'qutno':qutno.value,'prno':prno.value,'sale_invoice_id':sale_invoice_id.value,
    //  'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
    //  'valdate':valdate.value,'cashcustomer':cashcustomer.value,'cashcustadrs':cashcustadrs.value};

     // var data = { 'contracts' : dynamicTableData,'banktotal':parseFloat(total.value).toFixed(2),'exataxoffie':parseFloat(exataxoffie.value).toFixed(2),'collofcustom':parseFloat(collofcustom.value).toFixed(2),'bankcharges':parseFloat(bankcharges.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':number.value};
    // All Ok - Proceed

    var data = { 'saleinvoices' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id.value,'deliverydt':deliverydt.value,'custplan_id':custplan_id.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'podate':podate.value,'pono':pono.value,'dcno':dcno.value,'gpno':gpno.value,'billno':billno.value
    ,'sale_invoice_id':sale_invoice_id.value};





    fetch(@json(route('saleinvoices.update',$saleinvoices)),{
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
            window.open(window.location.origin + "/saleinvoices","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
}

function EnableDisableTextBox(per) {
        var discntper = document.getElementById("discntper");
        discntper.disabled = per.checked ? false : true;
        discntper.style.color ="black";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }


discntper.onblur=function(){
    // per=false

    // discntamt.value=(tamount*discntper.value/100).toFixed(0);
    tnetamount();
    }


discntamt.onblur=function(){
    // tnetamount1();
    // discntper.value=(discntamt.value/tamount*100).toFixed(2);
    tnetamount();
    }


</script>


@endpush






</x-app-layout>



