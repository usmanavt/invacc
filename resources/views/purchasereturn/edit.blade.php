<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Purchase Return Invoice
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



                            <label for="supplier_id">Supplier</label>
                            <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" disabled required>
                                @foreach($supplier as $supplier)
                                    @if ($supplier->id == $purchasereturn->supplier_id)
                                    <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                @endif
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select>

                            {{-- <x-input-text title="" name="quotation_id" id="quotation_id" value="{{ $customerorder->quotation_id }}" hidden     />
                            <x-input-text title="Quotation No" name="qutno" id="qutno" value="{{ $customerorder->pqutno }}" disabled     />
                            <x-input-date title="Quotation Date" name="qutdate" id="qutdate" value="{{ $customerorder->qutdate->format('Y-m-d') }}"  class="col-span-2" disabled  />
                            <x-input-text title="P.R No" name="prno" id="prno" value="{{ $customerorder->pprno }}" disabled     /> --}}

                            <x-input-date title="Purchase Invoice Date" name="invoice_date" id="invoice_date" req required class="col-span-2"  value="{{ $purchasereturn->prinvdate }}" disabled  />
                            <x-input-text title="Purchase Invoice No" name="invoiceno" id="invoiceno" req required class="col-span-2" value="{{ $purchasereturn->prinvno }}" disabled  />
                        </div>
                        <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-date title="Purchase Return Date" id="prdate" name="prdate" value="{{ $purchasereturn->prdate }}" req required class="col-span-2" />
                            <x-input-text title="Purchase Return No" name="prno" id="prno" value="{{ $purchasereturn->prno }}"      />

                            <x-input-text title="" name="prid" id="prid" value="{{ $purchasereturn->id }}"      />


                                {{-- <x-input-date title="P.O Date" id="podate" name="podate" value="{{ $customerorder->podate->format('Y-m-d') }}" req required class="col-span-2" />
                            <x-input-text title="P.O #" name="pono" id="pono" value="{{ $customerorder->pono }}"  />
                            <x-input-date title="Delivery Date" name="deliverydt" value="{{ $customerorder->deliverydt->format('Y-m-d') }}" />
                            <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{ $customerorder->poseqno }}"    required   /> --}}

                            {{-- <label for="">
                                Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                            <textarea name="remarks" id="remarks" cols="100" rows="2" maxlength="150" required class="rounded">
                                {{ $customerorder->remarks }}

                            </textarea> --}}
                        </div>
                    </fieldset>


                        </div>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" value="{{ $customerorder->discntper }}" disabled    />
                                 <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >

                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $customerorder->discntamt }}"    />
                                <x-input-numeric title="Payble Amount" name="rcvblamount" value="{{ $customerorder->rcvblamount }}" disabled />
                                <x-input-numeric title="" name="sale_invoice_id" id="sale_invoice_id" value="{{ $customerorder->id }}" hidden  />
                            </div>

                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" value="{{ $customerorder->saletaxper }}" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" value="{{ $customerorder->saletaxamt }}" disabled    />
                                <x-input-numeric title="Cartage" name="cartage" value="{{ $customerorder->cartage }}"  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" value="{{ $customerorder->totrcvbamount }}" disabled />
                            </div>

                        </fieldset> --}}

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
const getMaster = @json(route('materials.master')); // For Material Modal
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);



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

        {title:"Id",           field:"id", visible:false},
                {title:"Material Name",     field:"matname",responsive:0},
                {title:"Material Size",    field:"size",responsive:0,frozen:true},
                {title:"UOM",         field:"unitname",responsive:0, hozAlign:"center"},
                {title:"Unitid",       field:"sku_id",visible:true},
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
                            formatterParams:{thousand:",",precision:2},
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
                            formatterParams:{thousand:",",precision:2},
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
                            formatterParams:{thousand:",",precision:2},
                        },

                        {title:"Return Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"pramount",
                        formatter:"money",
                        cellEdited: updateValues,
                        cssClass:"bg-gray-200 font-semibold",
                        // formatter:function(cell,row)
                        // {
                        //     var data = cell.getData()
                        //      if(cell.getData().sku_id===1)
                        //     {
                        //         return  Number(cell.getData().prwt) * Number(cell.getData().prprice)
                        //     }
                        //     if(cell.getData().sku_id===2)
                        //     {
                        //          return  Number(cell.getData().prpcs ) * Number(cell.getData().prprice)
                        //     }

                        //     if(cell.getData().sku_id===3)
                        //     {
                        //         return  Number(cell.getData().prfeet ) * Number(cell.getData().prprice)
                        //     }
                        // },formatterParams:{thousand:",",precision:0},
                        bottomCalc:totalVal
                    },
                    ]},

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
    var sid = document.getElementById("supplier_id");
        var supplier_id = sid.options[sid.selectedIndex];
        var deliverydt = document.getElementById("deliverydt");
        var qutno = document.getElementById("qutno");
        var prno = document.getElementById("prno");
        var podate = document.getElementById("podate");
        var quotation_id = document.getElementById("quotation_id");

        // var discntper= document.getElementById("discntper");
        // var cartage= document.getElementById("cartage");
        // var discntamt= document.getElementById("discntamt");
        // var rcvblamount= document.getElementById("rcvblamount");
        // var per= document.getElementById("per");


    // Required
    if(supplier_id.value < 0)
        {
            showSnackbar("Please select From Customer");
            supplier_id.focus();
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

        // if(supplier_id.value == 0)
        // {


            // if(pono.value == "" )
            // {
            // showSnackbar("Please add pono");
            // pono.focus();
            // return;
            //  }
        // }



        // if(gpno.value == "")
        // {
        //     showSnackbar("Please add gpno");
        //     gpno.focus();
        //     return;
        // }
    if(dynamicTableData.length == 0)
    {
        showSnackbar("You must have atleast 1 row of item to Proceed","info");
        return;
    }
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
    disableSubmitButton(true);

    // var data = { 'purchasereturn' : dynamicTableData,
    //     'supplier_id': supplier_id.value,'deliverydt':deliverydt.value,'quotation_id':quotation_id.value,'poseqno':poseqno.value,
    //     'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
    //     'podate':podate.value,'pono':pono.value,'qutno':qutno.value,'qutdate':qutdate.value,'prno':prno.value
    // ,'sale_invoice_id':sale_invoice_id.value};

    var data = { 'purchasereturn' : dynamicTableData ,
        'supplier_id': supplier_id.value,'prdate':prdate.value,'prid':prid.value,'prno':prno.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value };




    fetch(@json(route('purchasereturn.update',$purchasereturn)),{
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
            window.open(window.location.origin + "/purchasereturn","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
}

// function EnableDisableTextBox(per) {
//         var discntper = document.getElementById("discntper");
//         discntper.disabled = per.checked ? false : true;
//         discntper.style.color ="black";
//         // if (!discntper.disabled) {
//         //     discntper.focus();
//         // }
//     }


// discntper.onblur=function(){
//     // per=false

//     // discntamt.value=(tamount*discntper.value/100).toFixed(0);
//     tnetamount();
//     }


// discntamt.onblur=function(){
//     // tnetamount1();
//     // discntper.value=(discntamt.value/tamount*100).toFixed(2);
//     tnetamount();
//     }


</script>


@endpush






</x-app-layout>



