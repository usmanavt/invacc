<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Price Quotation
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-1 py-1">

                    {{-- <div class="grid grid-cols-1"> --}}
                        {{-- Contract Master --}}
                        {{-- <div class="grid grid-cols-9 gap-2 py-2 items-center"> --}}
                        <div class=" grid grid-cols-9   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">
                            {{-- Contract Master --}}
                            <label for="customer_id" style="text-align: right">Customer</label>
                            <select  autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" disabled>
                                @foreach($customer as $customer)
                                    @if ($customer->id == $quotation->customer_id)
                                    <option value="{{$customer->id}}" selected> {{$customer->title}} </option>
                                @endif
                                    <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>


                            <label for="autocompleted1"  >Items:</label>
                            <div class="relative"   onclick="event.stopImmediatePropagation();" >
                                <input type="text" id="autocompleted1"
                             {{-- class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Items" --}}
                                onkeyup="onkeyUp1(event)" />
                                <div>
                                    <select  id="item_id" name="item_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </select>
                                </div>

                            </div>

                            <label for="saldate" >Date</label>
                            <input type="date"    id="saldate" name="saldate" value="{{ $quotation->saldate->format('Y-m-d') }}"  >
                            <label for="qutno">Qut.# </label>
                            <input type="text"  id="qutno" name="qutno" value="{{ $quotation->qutno }}"    placeholder="qutno" disabled>
                            <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-left  "
                            type="checkbox"  name="qutid" id="qutid"  onclick="EnableDisableTextBox(this)" >
                            <label for="prno">P.R No#</label>
                            <input type="text" class="col-span-1" id="prno" name="prno" value="{{ $quotation->prno }}"  placeholder="prno" >
                            <label for="">
                                Cash Customer <span class="text-red-500 font-semibold"></span>
                            </label>
                            <textarea name="cashcustomer" id="cashcustomer" cols="20" rows="1" maxlength="100"  class=" col-span-1  rounded">{{ $quotation->cashcustomer }}</textarea>

                            <label for="">
                                Cash Cust.Address <span class="text-red-500 font-semibold"></span>
                            </label>
                            <textarea name="cashcustadrs" id="cashcustadrs" class="col-span-3" cols="30" rows="1" maxlength="150"  class="rounded">{{ $quotation->cashcustadrs }}</textarea>

                        </div>

                        <div class=" grid grid-cols-9   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">
                            <x-input-numeric title="Discount(%)" name="discntper" id="discntper" value="{{ $quotation->discntper }}" class="col-span-1"    />
                            <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $quotation->discntamt }}" class="col-span-1"   />
                            <x-input-numeric title="Rcvbl Amount" name="rcvblamount" class="col-span-3" value="{{ $quotation->rcvblamount }}" disabled />
                        </div>

                        <div class=" grid grid-cols-9 py-0  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">
                            <x-input-numeric title="Sale Tax(%)" name="saletaxper" class="col-span-1" value="{{ $quotation->saletaxper }}"   onblur="tnetamount()"  />
                            <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" class="col-span-1" value="{{ $quotation->saletaxamt }}" disabled    />
                            <x-input-numeric title="Cartage" name=cartage  class="col-span-1" value="{{ $quotation->cartage }}"  onblur="tnetamount()"  />
                            <x-input-numeric title="Total Amount" name="totrcvbamount" class="col-span-1" value="{{ $quotation->totrcvbamount }}" disabled />
                        </div>

                        <div class=" grid grid-cols-9 py-2  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">
                            <label for="t1">Term & Condition </label>
                            <input type="text" class="col-span-2" id="t1" name="t1" placeholder="T&C-1" value="{{ $quotation->t1 }}"  >
                            <input type="text" class="col-span-2" id="t2" name="t2" placeholder="T&C-2" value="{{ $quotation->t2 }}"  >
                            <input type="text" class="col-span-1" id="t3" name="t3" placeholder="T&C-3" value="{{ $quotation->t3 }}"  >
                            <input type="text" class="col-span-1" id="t4" name="t4" placeholder="T&C-4" value="{{ $quotation->t4 }}"  >
                            <input type="text" class="col-span-1" id="t5" name="t5" placeholder="T&C-5" value="{{ $quotation->t5 }}"  >
                        </div>



                        <input type="date"  size="10"  id="valdate" style="text-align: right" class="col-span-2" name="valdate" value="{{ $quotation->valdate->format('Y-m-d') }}" hidden required>
                        <input type="text"  id="p5" name="p5" value="{{ $quotation->closed }}" hidden   >
                        <x-input-numeric title="" name="sale_invoice_id" id="sale_invoice_id" value="{{ $quotation->id }}" hidden  />


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

                    {{-- </div> --}}
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

window.onload = function() {
        customerDropdown = document.getElementById("autocompleted1").focus();
    }



document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
     })

let customerid = document.getElementById('customer_id');
let table;
let searchValue = "";
console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
// const getMaster = @json(route('materials.master')); // For Material Modal
const getMaster = @json(route('quotations.mmfrqut'));

let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);

// Populate Locations in Tabulator
const locations = @json($locations);
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})

        });

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
        table.setData(getMaster,{search:searchValue,customerid:customerid.options[customerid.selectedIndex].value});
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
            return {search:searchValue,customerid:customerid.options[customerid.selectedIndex].value};
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            // {title:"Customer", field:"custname" ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Material", field:"title" ,headerSort:false, responsive:0},
            {title:"Searching Text", field:"srchb" ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Items", field:"category" ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Category_Id", field:"category_id",visible:false ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Category", field:"category" ,headerSortStartingDir:"asc",visible:false , responsive:0},
            {title:"Last Sale Price", field:"pcspbundle1" ,  responsive:0},
            {title:"Sku", field:"sku" ,  responsive:0},
            // {title:"Brand", field:"brand" ,  responsive:0},
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
        console.log(data.id)
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




item_id.addEventListener("click", () => {

var result = dynamicTableData.filter( dt => dt.id == item_id.options[item_id.selectedIndex].value)
if(result.length <= 0)
{

// var inArray = dynamicTableData.filter( i => dynamicTableData.id == item_id.options[item_id.selectedIndex].value)
// dynamicTableData.push({ id:item_id.options[item_id.selectedIndex].value})
dynamicTable.addData([
    {
        id:0,
        material_id:item_id.options[item_id.selectedIndex].value,
        material_title:item_id.options[item_id.selectedIndex].text,
        category_id:$itmdata[item_id.options[item_id.selectedIndex].value][0].category_id,
        category:$itmdata[item_id.options[item_id.selectedIndex].value][0].category,

        source_id:$itmdata[item_id.options[item_id.selectedIndex].value][0].source_id,
        source:$itmdata[item_id.options[item_id.selectedIndex].value][0].source,

        brand_id:$itmdata[item_id.options[item_id.selectedIndex].value][0].brand_id,
        brand:$itmdata[item_id.options[item_id.selectedIndex].value][0].brand,

        sku_id:$itmdata[item_id.options[item_id.selectedIndex].value][0].sku_id,
        sku:$itmdata[item_id.options[item_id.selectedIndex].value][0].sku,

        dimension_id:$itmdata[item_id.options[item_id.selectedIndex].value][0].dimension_id,
        dimension:$itmdata[item_id.options[item_id.selectedIndex].value][0].dimension,

        supp1:'',
                supp2:'',
                supp3:'',

                mrktprice1:0,
                mrktprice2:0,
                mrktprice3:0,

                bundle1:0,
                bundle2:0,
                pcspbundle1:$itmdata[item_id.options[item_id.selectedIndex].value][0].lsalrate,
                lsalunit:$itmdata[item_id.options[item_id.selectedIndex].value][0].lsalunit,
                pcspbundle2:0,
                gdswt:0,
                gdsprice:0,
                dtyrate:0,
                invsrate:0,
                gdspricetot:0,
                price:0,
                repname:'',
                mybrand:'',

    }
])


}


});





function pushDynamicData(data)
{

    dynamicTableData.push({
        material_id:data.id,
        material_title:data.title,
        category_id:data.category_id,
        category:data.category,

        // source_id:data.source_id,
        // source:data.source,

        // brand_id:data.brand_id,
        // brand:data.brand,

        sku_id:data.sku_id,
        sku:data.sku,

        dimension_id:data.dimension_id,
        dimension:data.dimension,

        bundle1:0,
        bundle2:0,
        price:data.pcspbundle1,
        pcspbundle2:0,
        gdswt:0,
        gdsprice:0,
        gdspricetot:0,
        price:0
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
            var sum = (Number(data.qtykg) * Number(data.price))
            var sum2 = (Number(data.qtykg) * Number(data.price))

        row.update({

            "rcvblamount":sum2,
             "saleamnt": sum,
             "totval":sum,
             "gdspricetot": sum2

            });

    }
    // var tamount=0;
    function tnetamount()
        {
            //  discntamt.value=0;
            //  rcvblamount.value=0;


            // tamount=rcvblamount
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

        function tnetamount1()
        {
            // discntper.value=0;
            //  rcvblamount.value=0;
            //  discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
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
// console.info(abc);
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
        {title:"Id",                field:"material_id",    cssClass:"bg-gray-200 font-semibold"},
        {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
        {title:"Replace Description",field:"repname",       cssClass:"bg-gray-200 font-semibold",editor:true},
        {title:"Brand",             field:"mybrand",editor:true,         cssClass:"bg-gray-200 font-semibold"},
        // {title:"SaleUnitId",               field:"skus.skue",         cssClass:"bg-gray-200 font-semibold",visible:false},


        {title:"UOM", field:"sku" ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },


                {title:"LastSalePrice",
                field:"lstslprice",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                // validator:["required","integer"],
                cellEdited: updateValues,
               },

               {
            title:'Sale', headerHozAlign:"center",
            columns:[

            {   title:"Quantity",
                field:"qtykg",
                editor:"number",
                bottomCalc:"sum",
                responsive:0,
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","dec(12,2)"],
                cellEdited: updateValues,
               },


            { title:"Price",
                field:"price",
                editor:"number",
                responsive:0,
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
            ]},



               {
            title:'Market Suppliers', headerHozAlign:"center",
            columns:[

            {title:"1st",field:"supp1",width:150,editor:true,responsive:0,headerHozAlign:"center"},
            {title:"2nd",field:"supp2",width:150,editor:true,responsive:0,headerHozAlign:"center"},
            {title:"3rd",field:"supp3",width:150,editor:true,responsive:0,headerHozAlign:"center"},


        ]},


        {
            title:'Market Price', headerHozAlign:"center",
            columns:[

            {title:"1st",field:"mrktprice1",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
            {title:"2nd",field:"mrktprice2",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
            {title:"3rd",field:"mrktprice3",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
        ]},


    ],
})

// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to show Modal
    if(e.ctrlKey && e.keyCode == 32){

        if (
                customerid.options[customerid.selectedIndex].value != ""
                ||
                customerid.options[customerid.selectedIndex].value != 0 )  {
                    console.log(customerid.options[customerid.selectedIndex].value)
                    showModal()
            }


        // showModal()
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
        var saldate = document.getElementById("saldate");
        var qutno = document.getElementById("qutno");
        var prno = document.getElementById("prno");
        var valdate = document.getElementById("valdate");
        var cashcustomer = document.getElementById("cashcustomer");
        var cashcustadrs = document.getElementById("cashcustadrs");

        var discntper= document.getElementById("discntper");
        var cartage= document.getElementById("cartage");
        var discntamt= document.getElementById("discntamt");
        var rcvblamount= document.getElementById("rcvblamount");

    // Required
    if(customer_id.value < 0)
        {
            showSnackbar("Please select From Customer");
            customer_id.focus();
            return;
        }
        if(saldate.value === "")
        {
            showSnackbar("Please select From Invoice Date");
            saldate.focus();
            return;
        }
        if(qutno.value == "")
        {
            showSnackbar("Please add qutno");
            qutno.focus();
            return;
        }

        // if(prno.value == "")
        // {
        //     showSnackbar("Please add prno");
        //     prno.focus();
        //     return;
        // }

        if(customer_id.value == 0)
        {


            if(cashcustomer.value == "" )
            {
            showSnackbar("Cash Customer Name Must Be Enter");
            cashcustomer.focus();
            return;
            }
        }



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
        if(element.qtykg == 0 || element.sku_id == 0  )
        {
            showSnackbar("Please Required Data & Price all rows to proceed","info");
            return;
        }
    }
    // 'total' : parseFloat(banktotal.value).toFixed(2),
    disableSubmitButton(true);
    //  var data = { 'sales' : dynamicTableData,'contract_id':parseFloat(contract_id.value).toFixed(0),'bankntotal':parseFloat(bankntotal.value).toFixed(0),'collofcustom':parseFloat(exataxoffie.value).toFixed(0),'exataxoffie':parseFloat(exataxoffie.value).toFixed(0) ,'bankcharges':parseFloat(bankcharges.value).toFixed(0) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value};
     var data = { 'quotations' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value ,
     'customer_id': customer_id.value,'saldate':saldate.value,'qutno':qutno.value,'prno':prno.value,'sale_invoice_id':sale_invoice_id.value,
     'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
     'valdate':valdate.value,'cashcustomer':cashcustomer.value,'cashcustadrs':cashcustadrs.value,'p5':p5.value,
     't1':t1.value,'t2':t2.value,'t3':t3.value,'t4':t4.value,'t5':t5.value};

     // var data = { 'contracts' : dynamicTableData,'banktotal':parseFloat(total.value).toFixed(2),'exataxoffie':parseFloat(exataxoffie.value).toFixed(2),'collofcustom':parseFloat(collofcustom.value).toFixed(2),'bankcharges':parseFloat(bankcharges.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':number.value};
    // All Ok - Proceed
    fetch(@json(route('quotations.update',$quotation)),{
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
            window.open(window.location.origin + "/quotations","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
}

discntper.onblur=function(){
    // per=false
    discntamt.value=(tamount*discntper.value/100).toFixed(0);
    tnetamount();
}

discntamt.onblur=function(){
    // tnetamount1();
    discntper.value=(discntamt.value/tamount*100).toFixed(2);
    tnetamount();
}


function imppur(qutclose) {
    var p5 = document.getElementById("p5");
    // amount_fc.disabled = advtxt.checked ? true : false;
    // amount_fc.disabled = per.checked ? true : false;

    if(qutclose.checked==true)
    {
        p5.value=0;
    }
    else
    {
        p5.value=1;
    }

}

edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }







//    *********************** For Search List Box

const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

// myarray=@json($resultArray);
// const contries = myarray;
// function onkeyUp(e)
// {
//     let keyword= e.target.value;
//     var customer_id = document.getElementById("customer_id");
//     customer_id.classList.remove("hidden");

//     let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));
//     // console.log(filteredContries);
//     renderOptions(filteredContries);

// }


document.addEventListener('DOMContentLoaded',()=> {
    hidedropdown1();
        });

// function renderOptions(xyz){

//     let dropdownEl=document.getElementById("customer_id");

//                 dropdownEl.length = 0
//                 xyz.forEach(e => {
//                     addSelectElement(dropdownEl,e.id,e.title)
//                 });
// }

// document.addEventListener("click" , () => {
//     hidedropdown();
// });


// function hidedropdown()
// {
//     var customer_id = document.getElementById("customer_id");
//     customer_id.classList.add("hidden");
// }


// customer_id.addEventListener("click", () => {

//     let customer_id= document.getElementById("customer_id");
//     let custid= document.getElementById("custid");
//     let input= document.getElementById("autocompleted");
//     input.value=customer_id.options[customer_id.selectedIndex].text;
//     custid.value= (customer_id.options[customer_id.selectedIndex].value);
//     hidedropdown();
// });


// customer_id.addEventListener("keyup", function(event) {
// if (event.keyCode === 13) {
// event.preventDefault();

// let customer_id= document.getElementById("customer_id");
//     let input= document.getElementById("autocompleted");
//     let custid= document.getElementById("custid");
//     input.value=customer_id.options[customer_id.selectedIndex].text;
//     custid.value= (customer_id.options[customer_id.selectedIndex].value);
//     hidedropdown();

// }
// });











// ********* search list for item_id


list1=@json($resultArray1);
// const list1 = List1;
function onkeyUp1(e)
{
    let keyword= e.target.value;
    var item_id = document.getElementById("item_id");
    item_id.classList.remove("hidden");

    let filteredContries=list1.filter((c)=>c.srchb.toLowerCase().includes(keyword.toLowerCase()));
    renderOptions1(filteredContries);


    // e.id + '      '+ e.srchb+' '+e.dimension
}

function renderOptions1(xyz){

    let dropdownEl=document.getElementById("item_id");


                $itmdata= [];
                dropdownEl.length = 0
                xyz.forEach(e => {
                    // addSelectElement(dropdownEl,e.id,e.supname )
                    addSelectElement(dropdownEl,e.id,e.srchb)
                    $itmdata[e.id]=[ { sku_id:e.sku_id,sku:e.sku,source_id:e.source_id,source:e.source,category_id:e.category_id,category:e.category,
                                dimension_id:e.dimension_id,dimension:e.dimension,brand:e.brand,brand_id:e.brand_id,lsalunit:e.lsalunit,lsalrate:e.lsalrate }  ];

                 });


}



function hidedropdown1()
{
    var item_id = document.getElementById("item_id");
    item_id.classList.add("hidden");
}


item_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
// event.preventDefault();
item_id.click();

}
});

document.onkeydown=function(e){
    // if(e.keyCode == 17) isCtrl=true;
    // if(e.keyCode == 83 && isCtrl == true) {
        if(e.ctrlKey && e.which === 83){
        //run code for CTRL+S -- ie, save!
        // alert("dfadfasd");
        submitbutton.click();
        return false;
    }
}

    item_id.onblur=function(){
   hidedropdown1();

   }


const itemlistwrate = @json(route('quotations.itemlistwrate'));
const customer = document.getElementById('customer_id')
// const value = customer.value


customer.addEventListener("change", () => {
        const value = customer.value
        // console.log(value);
        autocompleted1.value='';
        let dropdownEl=document.getElementById("item_id");
        item_id.options.length = 0 // Reset List
        fetch(itemlistwrate + `?customer_id=${value} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                        //    console.log(data);
                            // let a = 0;

                            // $shid= [];
                            // $mnhdid= [];
                            // $shdname= [];

                            $itmdata= [];
                            list1=data;
                            list1.forEach(e => {
                                addSelectElement(dropdownEl,e.id,e.srchb)
                                $itmdata[e.id]=[ { sku_id:e.sku_id,sku:e.sku,source_id:e.source_id,source:e.source,category_id:e.category_id,category:e.category,
                                dimension_id:e.dimension_id,dimension:e.dimension,brand:e.brand,brand_id:e.brand_id,lsalunit:e.lsalunit,lsalrate:e.lsalrate }  ];
                        //    console.log($itmdata[e.id]);
                            });

                        }else{
                        }
                    })
                    .catch(error => console.error(error))
                // break;


});













function clearform()
{


    // document.getElementById("autocompleted").value='';
    // document.getElementById("autocompleted1").value="";
    // document.getElementById("qutno").value="";
    // document.getElementById("prno").value="";
    // document.getElementById("cashcustomer").value="";
    // document.getElementById("cashcustadrs").value='';
    // document.getElementById("discntper").value=0;
    // document.getElementById("discntamt").value=0;
    // document.getElementById("rcvblamount").value=0;
    // document.getElementById("saletaxper").value=0;
    // document.getElementById("saletaxamt").value=0;
    // document.getElementById("cartage").value=0;
    // document.getElementById("totrcvbamount").value=0;

}


function EnableDisableTextBox(qutid) {
        var qutno = document.getElementById("qutno");
        qutno.disabled = qutid.checked ? false : true;
        qutno.style.color ="black";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }



</script>







@endpush






</x-app-layout>



