<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Delivery Challan Without Purchase Order
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-1 py-1">

                    {{-- <div class="grid grid-cols-1"> --}}
                        {{-- Contract Master --}}
                        {{-- <div class="grid grid-cols-12 gap-2 py-2 items-center"> --}}
                            {{-- Contract Master --}}
                        <div class=" grid grid-cols-6   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full   ">
                            <label for="customer_id">Customer</label>
                            <select  autocomplete="on" class="col-span-1" name="customer_id" id="customer_id"  disabled>
                                @foreach($customer as $customer)
                                    @if ($customer->id == $saleinvoices->customer_id)
                                    <option value="{{$customer->id}}" selected> {{$customer->title}} </option>
                                @endif
                                    <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>


                            <label for="autocompleted1"  >Items:</label>
                            <div class="relative"   onclick="event.stopImmediatePropagation();" >
                                <input type="text"  id="autocompleted1 " size=30
                             {{-- class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Items" --}}
                                onkeyup="onkeyUp1(event)" />
                                <div>
                                    <select  id="item_id" name="item_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </select>
                                </div>

                            </div>



                            {{-- <x-input-date style="text-align: right" title="Deilivery Date" id="deliverydt" name="deliverydt"  class="col-span-2" value="{{ $saleinvoices->saldate->format('Y-m-d') }}" /> --}}

                                <x-input-date  title="Deilivery Date" id="deliverydt" name="deliverydt" value="{{ $saleinvoices->saldate->format('Y-m-d') }}"  class="col-span-1" />
                                <x-input-text tabindex="-1" title="DC No" name="dcno" id="dcno"  class="col-span-1 " value="{{ $saleinvoices->dcno }}"        />
                                <x-input-text tabindex="-1" title="Bill No" name="billno" id="billno" class="col-span-1"  value="{{ $saleinvoices->billno }}"     />
                                <label for="">
                                    Descripiton <span class="text-red-500 font-semibold"></span>
                                </label>
                                <textarea name="saldescription" id="saldescription" class="col-span-1" cols="30" rows="1" maxlength="150" required class="rounded">{{ $saleinvoices->saldescription }}</textarea>
                                <x-input-numeric tabindex="-1" title="Discou(%)" name="discntper" id="discntper" value="{{ $saleinvoices->discntper }}" class="col-span-1" disabled    />
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $saleinvoices->discntamt }}" class="col-span-1"   />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" value="{{ $saleinvoices->rcvblamount }}" class="col-span-1" disabled />
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" value="{{ $saleinvoices->saletaxper }}" class="col-span-1"   onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" value="{{ $saleinvoices->saletaxamt }}" class="col-span-1" disabled    />
                                <x-input-numeric title="Cartage" name=cartage value="{{ $saleinvoices->cartage }}" class="col-span-1"    onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" value="{{ $saleinvoices->totrcvbamount }}" class="col-span-1" disabled />

                                <label for="per">
                                    <span style="color: brown;font-weight: bold"> Enable Descount% TextBox </span> <span class="text-red-500 font-semibold  "></span>
                                     </label>
                                <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-left "
                                type="checkbox" class="col-span-1"  name="per" id="per" onclick="EnableDisableTextBox(this)" >
                        </div>


                        {{-- <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-text tabindex="-1" title="DC No" name="dcno" id="dcno" value="{{ $saleinvoices->dcno }}"    class="col-span-2"   />
                            <x-input-text tabindex="-1" title="Bill No" name="billno" id="billno"   value="{{ $saleinvoices->billno }}"  class="col-span-2"   />
                                <label for="">
                                    Descripiton <span class="text-red-500 font-semibold"></span>
                                </label>
                                <textarea name="saldescription" id="saldescription" cols="100" rows="2" maxlength="150" class="rounded"> {{ $saleinvoices->saldescription }} </textarea>
                        </div> --}}
                    </fieldset>


                        </div>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <legend>Other Invoice Level Charges</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" value="{{ $saleinvoices->discntper }}" disabled    />
                                        <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >

                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" class="col-span-2" value="{{ $saleinvoices->discntamt }}"    />
                                <x-input-numeric title="Payble Amount" name="rcvblamount" class="col-span-2" value="{{ $saleinvoices->rcvblamount }}" disabled />
                                <x-input-numeric title="" name="sale_invoice_id" id="sale_invoice_id" class="col-span-2" value="{{ $saleinvoices->id }}" hidden  />
                            </div>

                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" class="col-span-2" value="{{ $saleinvoices->saletaxper }}"   onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" class="col-span-2" value="{{ $saleinvoices->saletaxamt }}" disabled    />
                                <x-input-numeric title="Cartage" name="cartage" class="col-span-2" value="{{ $saleinvoices->cartage }}"  required  onblur="tnetamount()"  />
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Total Amount" name="totrcvbamount" class="col-span-2" value="{{ $saleinvoices->totrcvbamount }}" disabled />
                            </div>



                        </fieldset> --}}
                        <x-input-text title="" name="custplan_id" id="custplan_id" value="{{ $saleinvoices->custplan_id }}" hidden     />
                        <x-input-numeric title="" name="sale_invoice_id" id="sale_invoice_id" class="col-span-2" value="{{ $saleinvoices->id }}" hidden  />

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

document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
        // document.getElementById("autocompleted1").focus();

        hidedropdown1();

     })


const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})

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
        // if(result.length <= 0)
        // {
        //     pushDynamicData(data)

        // }

        // console.log(material_id)
        if(!dynamicTableData.filter( dt => dt.material_id === data.id).length){
        pushDynamicData(data)
    }

    })

item_id.addEventListener("click", () => {

        var result = dynamicTableData.filter( dt => dt.id == item_id.options[item_id.selectedIndex].value)
        if(result.length <= 0)
        {

        var inArray = dynamicTableData.filter( i => dynamicTableData.id == item_id.options[item_id.selectedIndex].value)

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

        bundle1:0,
        bundle2:0,
        pcspbundle1:0,
        pcspbundle2:0,
        gdswt:0,
        gdsprice:0,
        gdspricetot:0,
        qtykg:0,
        qtypcs:0,
        qtyfeet:0


    }
])


}


});







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
        munit:data.sku,
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


// var updateValues = (cell) => {

//     sum = 0;
//     sum2=0;
//     var data = cell.getData();
//         var row = cell.getRow();
//             if(cell.getData().sku_id==1)
//          {
//             var sum = (Number(data.qtykg) * Number(data.price))
//          }
//          if(cell.getData().sku_id==2)
//          {
//             var sum = (Number(data.qtypcs) * Number(data.price))
//          }

//          if(cell.getData().sku_id==3)
//          {
//             var sum = (Number(data.qtyfeet) * Number(data.price))
//          }

//         row.update({
//             "saleamnt": sum,
//             totval: sum

//             });

//     }
    // var tamount=0;

    var updateValues = (cell) => {
        var data = cell.getData();

        if(Number(data.totqty) > 0  )

{
        if(data.sku==='KG' )
        {

            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100

            var pr2=( pr1 / Number(data.wtper))*100
            qtypcs=((pr2*Number(data.sqtypcs))/100)
            // .toFixed(0)
            qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtykg=Number(data.feedqty)
         }
        else if(data.sku==='PCS'   )
        {
            // || data.sku==='METER'
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.pcper))*100
            qtykg=((pr2*Number(data.sqtykg))/100)
            // .toFixed(0)
            qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtypcs=Number(data.feedqty)
         }

        else if(data.sku==='FEET')
         {
            var sum = (Number(data.feedqty) * Number(data.price))
            // var pr1=(Number(data.qtyfeet) / Number(data.totqty))*100
            var pr1=((Number(data.feedqty) / Number(data.totqty))*100)
            // .toFixed(6)
            var pr2=(( pr1 / Number(data.feetper))*100)
            // .toFixed(6)
            qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(0)
            // qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtyfeet=Number(data.feedqty)
         }
         else
        {
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.pcper))*100
            qtykg=(((pr2*Number(data.sqtykg))/100) / Number(data.unitconver)).toFixed(2)
            qtyfeet=(((pr2*Number(data.sqtyfeet))/100) / Number(data.unitconver)).toFixed(2)
            qtypcs=(Number(data.feedqty) / Number(data.unitconver))
         }
 }

 else
 {


    if(data.sku==='KG'  )
        {
        qtypcs=0
        qtyfeet=0
         qtykg=Number(data.feedqty) }
    else if(data.sku==='PCS'   )
    {
    qtykg=0
    qtyfeet=0
        qtypcs=Number(data.feedqty)}
    else if(data.sku==='FEET')
    {
    qtykg=0
    qtypcs=0
        qtyfeet=Number(data.feedqty)}
    else
    {
    qtykg=0
    qtyfeet=0
    qtypcs=((Number(data.feedqty) / Number(data.unitconver))).toFixed(0)}

 }
 var sum = (Number(data.feedqty) * Number(data.price))
        var row = cell.getRow();

        // if(cell.getData().sku_id==1)
        // {
        row.update({
            "saleamnt": sum,
            "qtypcs":qtypcs,
            "qtyfeet":qtyfeet,
            "qtykg":qtykg,
             totval: sum

        });
    }


    function tnetamount()
        {

            // tamount=rcvblamount
            if (discntper.disabled)
            {discntper.value=(discntamt.value/tamount*100).toFixed(6)};

            if (!discntper.disabled)
            {discntamt.value=(tamount*discntper.value/100).toFixed(0);};


            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) ).toFixed(0)  ;
            saletaxamt.value=((Number(rcvblamount.value) * Number(saletaxper.value) )/100).toFixed(0) ;
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
        {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold",width:300,responsive:0},
        {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
        {title:"Source",         field:"itemsource",width:100,responsive:0, hozAlign:"center", cssClass:"bg-gray-200 font-semibold"},
        {title:"UOM",               field:"sku",cssClass:"bg-gray-200 font-semibold"},

        {title:"qtykgcrt", field:"munit",visible:false},
        // {title:"qtypcscrt", field:"qtypcscrt",visible:false,editor:"number"},
        // {title:"qtyfeetcrt", field:"qtyfeetcrt",visible:false,editor:"number"},

        {
                title:'STOCK QUANTITY', headerHozAlign:"center",
                    columns:[
                {title:"InKg", field:"sqtykg",cssClass:"bg-gray-200 font-semibold",width:90,responsive:0},
                {title:"InPcs", field:"sqtypcs",cssClass:"bg-gray-200 font-semibold",width:90,responsive:0},
                {title:"InFeet", field:"sqtyfeet",cssClass:"bg-gray-200 font-semibold",width:90,responsive:0},
            ]},

            {title:"ORDER BALANCE", field:"balqty",visible:false},
                {
                title:'SALE QTY', headerHozAlign:"center",
                    columns:[
            {   title:"InKg",
                field:"qtykg",
                editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},width:90,responsive:0,
                validator:["required","integer"],
                // cellEdited: updateValues,
               },

               {title:"InPcs",
                field:"qtypcs",
                editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:0},width:90,responsive:0,
                validator:["required","integer"],
                // cellEdited: updateValues,
               },

               {   title:"InFeet",
                field:"qtyfeet",
                editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},width:90,responsive:0,
                validator:["required","integer"],
                // cellEdited: updateValues,
               },

            ]},




                {
                title:'ITEM DESCRIPTION', headerHozAlign:"center",
                    columns:[

          //          {title: "id",field: "myid",visible:false},
          //      {title:"Location", field:"location" ,editor:"list" , editorParams:   {
          //              values:newList,
          //              validator:["required"]
          //          }
          //      },

                {title:"Replace Description",field:"repname", editor:true},
                {title:"Brand",             field:"brand",editor:true,visible:false},


                ]},

                {title: "id",field: "skuid",visible:false},
                {title:"UOM", field:"sku",responsive:0 ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        cellEdited: updateValues,
                        validator:["required"]
                    }
                },



                {
                title:'SALE', headerHozAlign:"center",
                    columns:[

                    {title:"Conversion", field:"unitconver",cellEdited: updateValues,editor:"number",responsive:0},

                { title:"Quantity",
                field:"feedqty",
                editor:"number",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},width:90,responsive:0,
                validator:["required","decimal(10,3)"] ,
                cellEdited: updateValues   ,
            },

            { title:"Price",
                field:"price",
                editor:"number",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},width:90,responsive:0,
                validator:["required","decimal(10,3)"] ,
                cellEdited: updateValues   ,
            },



            {   title:"Amount",
                field:"saleamnt",
                cssClass:"bg-green-200 font-semibold",
                formatter:"money",
                bottomCalc:"sum",
                formatterParams:{thousand:",",precision:0},width:100,responsive:0,
                formatter:function(cell,row)
                {
                      return  ( cell.getData().feedqty * cell.getData().price).toFixed(0)
                },

                bottomCalc:totval
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
    var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        var deliverydt = document.getElementById("deliverydt");
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

        if(dcno.value == "")
        {
            showSnackbar("Please add dcno");
            dcno.focus();
            return;
        }




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
                           if( element.munit=='KG' &&  element.qtykg <=0 )
                            {
                                showSnackbar("Stock Unit Data must be Enter","info");
                                return;

                            }

                            if( element.munit=='PCS' &&  element.qtypcs <=0 )
                            {
                                showSnackbar("Stock Unit Data must be Enter","info");
                                return;

                            }

                            if( element.munit=='FEET' &&  element.qtyfeet <=0 )
                            {
                                showSnackbar("Stock Unit Data must be Enter","info");
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

    var data = { 'salewopo' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id.value,'deliverydt':deliverydt.value,'custplan_id':custplan_id.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'dcno':dcno.value,'billno':billno.value
    ,'sale_invoice_id':sale_invoice_id.value,'saldescription':saldescription.value};





    fetch(@json(route('salewopo.update',$saleinvoices)),{
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
            window.open(window.location.origin + "/salewopo","_self" );
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

    edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }


    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }




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

   item_id.onblur=function(){
   hidedropdown1();

   }


   document.addEventListener("click" , () => {
    hidedropdown1();
});

</script>


@endpush






</x-app-layout>



