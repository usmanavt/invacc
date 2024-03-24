<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <div style="font-size: 3rem;font-weight: bold;color:brown;border:blue">
            Delete Record Information
        </div>
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
                                    @if ($customer->id == $salereturn->customer_id)
                                    <option value="{{$customer->id}}" selected> {{$customer->title}} </option>
                                @endif
                                    <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>

                                {{-- <x-input-text title="" name="custplan_id" id="custplan_id" value="{{ $saleinvoices->custplan_id }}" hidden     />
                                <x-input-text title="P.O No" name="pono" id="pono" req required class="col-span-2" value="{{ $saleinvoices->pono }}" disabled  />
                                <x-input-date title="P.O Date" name="podate" id="podate" req required class="col-span-2" value="{{ $saleinvoices->podate->format('Y-m-d') }}" disabled  />
                                <x-input-text title="G.Pass No" name="gpno" id="gpno" value="{{ $saleinvoices->gpno }}"     required   /> --}}
                                    {{-- <x-input-text title="Customer Name" name="custname" id="custname" value="{{ $customer->custname }}" req required class="col-span-2" disabled  /> --}}
                                    <x-input-date title="Deilivery Date" id="dcdate" name="dcdate" value="{{ $salereturn->dcdate }}"   class="col-span-2" disabled />
                                    <x-input-text title="DC No" name="dcno" id="dcno" value="{{ $salereturn->dcno }}"    disabled class="col-span-2"   />
                                    <x-input-text title="Bill No" name="billno" id="billno" value="{{ $salereturn->billno }}" class="col-span-2"   disabled   />
                                    <x-input-text title="G.Pass No" name="gpno" id="gpno" value="{{ $salereturn->gpno }}" class="col-span-2"   disabled   />
                                    <x-input-date title="Return Date" name="rdate" id="rdate" value="{{ $salereturn->rdate }}"  class="col-span-2" />
                                    <x-input-text title="" name="pcustno" id="pcustno" hidden value="{{ $salereturn->customer_id }}"  class="col-span-2" />
                                     <x-input-text title="" name="invsid" id="invsid" hidden  value="{{ $salereturn->invoice_id }}"  class="col-span-2" />
                        </div>
                        <div>


                        </div>




                    </fieldset>


                        </div>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            {{-- <div class="grid grid-cols-12 gap-2 py-2 items-center"> --}}
                                {{-- <x-input-numeric title="Discou(%)" name="discntper" id="discntper" value="{{ $saleinvoices->discntper }}" disabled    /> --}}
                                    {{-- <div class="basis-0 md:basis-1/5 self-center pt-4"> --}}
                                        {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" > --}}
                                        {{-- <label class="inline-block text-gray-800"> --}}

                                        {{-- </label> --}}
                                    {{-- </div> --}}


                                {{-- <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $saleinvoices->discntamt }}"    />
                                <x-input-numeric title="Cartage" name="cartage" value="{{ $saleinvoices->cartage }}"  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Payble Amount" name="rcvblamount" value="{{ $saleinvoices->rcvblamount }}" disabled /> --}}
                            {{-- </div> --}}

                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" value="{{ $salereturn->discntper }}" disabled     />
                                {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" > --}}
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" value="{{ $salereturn->discntamt }}"   />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" value="{{ $salereturn->rcvblamount }}" disabled />
                                <x-input-numeric title="" name="sale_return_id" id="sale_return_id" value="{{ $salereturn->id }}" hidden   />
                                    <label for="">
                                        Descripiton <span class="text-red-500 font-semibold"></span>
                                    </label>
                                    <textarea name="sretdescription" id="sretdescription" cols="30" rows="2" maxlength="150" required class="rounded"> {{ $salereturn->sretdescription }} </textarea>
                                </div>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Sale Tax(%)" name="saletaxper" value="{{ $salereturn->saletaxper }}" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" value="{{ $salereturn->saletaxamt }}" disabled    />
                                    <x-input-numeric title="Total Amount" name="totrcvbamount" value="{{ $salereturn->totrcvbamount }}" disabled />

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
document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
     })


let table;
let searchValue = "";


// console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
const getMaster = @json(route('materials.master')); // For Material Modal
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);
// let invoice_id = invoice_id;


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

        if(data.sku==='KG'  )
         {

            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
           var pr2=( pr1 / Number(data.wtper))*100
            qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(2)
            qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtykg=Number(data.feedqty)
         }
         else if(data.sku==='PCS'  )
         {
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.pcper))*100
            qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtypcs=Number(data.feedqty)



         }

         else if(data.sku==='FEET'  )
         {
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.feetper))*100
            qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(2)
            qtyfeet=Number(data.feedqty)

         }

         else
        {
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.pcper))*100
            qtykg=(((pr2*Number(data.sqtykg))/100) / Number(data.unitconversr)).toFixed(2)
            qtyfeet=(((pr2*Number(data.sqtyfeet))/100) / Number(data.unitconversr)).toFixed(2)
            qtypcs=((Number(data.feedqty) / Number(data.unitconversr))).toFixed(0)
         }



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
            // if (discntper.disabled)
            // {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            // if (!discntper.disabled)
            // {discntamt.value=(tamount*discntper.value/100).toFixed(0);};


            // rcvblamount.value=  Number(tamount)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);

            discntamt.value=(tamount*discntper.value/100).toFixed(0);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) ).toFixed(0)  ;
            saletaxamt.value=((Number(rcvblamount.value) * Number(saletaxper.value) )/100).toFixed(0) ;
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
// dynamicTable = new Tabulator("#dynamicTable", {
//     data:dynamicTableData,
//     layout:'fitData',
//     reactiveData:true,
//     columns:[
//         {title:"Delete" , formatter:deleteIcon, headerSort:false, responsive:0,
//             cellClick:function(e, cell){
//                 cell.getRow().delete();
//                 dynamicTableData = dynamicTable.getData(); // Ensure that our data is clean
//                 dynamicTable.redraw();
//                 // disableSubmitButton();
//             }
//         },

//         {title:"Id",                field:"material_id",    cssClass:"bg-gray-200 font-semibold"},
//         {title:"Material Name",          field:"material_title",width:300, cssClass:"bg-gray-200 font-semibold"},
//         {title:"Material Size",         field:"dimension",width:200,      cssClass:"bg-gray-200 font-semibold"},

//         {title:"UOM",               field:"sku",cssClass:"bg-gray-200 font-semibold"},

//         {
//                 title:'Sale Quantity', headerHozAlign:"center",
//                     columns:[
//                 {title:"InKg", field:"sqtykg",width:120,cssClass:"bg-gray-200 font-semibold"},
//                 {title:"InPcs", field:"sqtypcs",width:120,cssClass:"bg-gray-200 font-semibold"},
//                 {title:"InFeet", field:"sqtyfeet",width:120,cssClass:"bg-gray-200 font-semibold"},
//             ]},

//             // {title:"ORDER BALANCE", field:"balqty",cssClass:"bg-gray-200 font-semibold"},
//                 {
//                 title:'Sale Return Qty', headerHozAlign:"center",
//                     columns:[
//             {   title:"InKg",
//                 field:"qtykg",
//                 editor:"number",
//                 cssClass:"bg-gray-200 font-semibold",
//                 validator:"required",
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","integer"],
//                 // cellEdited: updateValues,
//                },

//                {title:"InPcs",
//                 field:"qtypcs",
//                 editor:"number",
//                 cssClass:"bg-gray-200 font-semibold",
//                 validator:"required",
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","integer"],
//                 // cellEdited: updateValues,
//                },

//                {   title:"InFeet",
//                 field:"qtyfeet",
//                 editor:"number",
//                 cssClass:"bg-gray-200 font-semibold",
//                 validator:"required",
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","integer"],
//                 // cellEdited: updateValues,
//                },

//             ]},




//                 {
//                 title:'ITEM DESCRIPTION', headerHozAlign:"center",
//                     columns:[

//                 //     {title: "id",field: "myid",visible:false},
//                 // {title:"Location", field:"location" ,editor:"list" , editorParams:   {
//                 //         values:newList,
//                 //         // cssClass:"bg-green-200 font-semibold",
//                 //         validator:["required"]
//                 //     }
//                 // },

//                 {title:"Replace Description",field:"repname", editor:true},
//                 {title:"Brand",             field:"brand",editor:true},


//                 ]},

//                 {
//                 title:'Pricing', headerHozAlign:"center",
//                     columns:[

//                 { title:"Convertion",
//                 field:"unitconversr",
//                 editor:"number",
//                 validator:"required" ,
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","decimal(10,3)"] ,
//                 cellEdited: updateValues   ,
//             },

//                 { title:"Revise Qty",
//                 field:"feedqty",
//                 editor:"number",
//                 validator:"required" ,
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","decimal(10,3)"] ,
//                 cellEdited: updateValues   ,
//             },

//             { title:"Rate",
//                 field:"price",
//                 editor:"number",
//                 validator:"required" ,
//                 formatter:"money",
//                 width:120,
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","decimal(10,3)"] ,
//                 cellEdited: updateValues   ,
//             },



//             {   title:"Amount",
//                 field:"saleamnt",
//                 cssClass:"bg-green-200 font-semibold",
//                 formatter:"money",
//                 bottomCalc:"sum",
//                 width:120,
//                 formatterParams:{thousand:",",precision:0},
//                 formatter:function(cell,row)
//                 {
//                       return  ( cell.getData().feedqty * cell.getData().price).toFixed(0)
//                 },

//                 bottomCalc:totval
//             },

//                 ]},

//     ],
// })

// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to show Modal
    if(e.ctrlKey && e.keyCode == 500){
        showModal()
    }
})
// Ensure Buttons Are Closed
// function disableSubmitButton()
// {
//     if(dynamicTableData.length <= 0 )
//     {
//         document.getElementById("submitbutton").disabled = true;
//     }else {
//         document.getElementById("submitbutton").disabled = false;
//     }
// }
  // Validation & Post
function validateForm()
{
    var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        var deliverydt = document.getElementById("deliverydt");
        var podate = document.getElementById("podate");
      //  var custplan_id = document.getElementById("custplan_id");

        // var discntper= document.getElementById("discntper");
        // var cartage= document.getElementById("cartage");
        // var discntamt= document.getElementById("discntamt");
        var rcvblamount= document.getElementById("rcvblamount");
        // var per= document.getElementById("per");


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



        if(gpno.value == "")
        {
            showSnackbar("Please add gpno");
            gpno.focus();
            return;
        }
    // if(dynamicTableData.length == 0)
    // {
    //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
    //     return;
    // }

    // dynamicTableData = dynamicTable.getData();
    // // Qty Required
    // for (let index = 0; index < dynamicTableData.length; index++) {
    //     const element = dynamicTableData[index];
    //     if(Number(element.feedqty ) > Number(element.balqty)+Number(element.balqty) )
    //     {
    //         showSnackbar("Sale Qty must be less than Plan qty","info");
    //         return;
    //     }
    // }


    var data = { 'salereturn' : dynamicTableData,'rcvblamount':rcvblamount.value,
        'customer_id': customer_id.value,'dcdate':dcdate.value,'sale_return_id':sale_return_id.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'dcno':dcno.value,'gpno':gpno.value,'billno':billno.value,'rdate':rdate.value,'sretdescription':sretdescription.value
    ,'discntamt':discntamt.value,'discntper':discntper.value,'invsid':invsid.value};



    fetch(@json(route('salereturn.del')),{
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
            window.open(window.location.origin + "/salereturn","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        // disableSubmitButton(false);
    })
}



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


edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }







</script>


@endpush






</x-app-layout>



