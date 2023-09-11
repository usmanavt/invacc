<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Opening Balance
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">




                        {{-- </div> --}}

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Item Description</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-text title="Material Name" name="material_title" value="{{ $mat->title}}"  disabled    />
                                <x-input-text title="Dimension" name="dimension" value="{{ $mat->dimension}}" disabled    />
                                <x-input-date title="O/Date" name="opdate" value="{{ $openinggodownstock->opdate}}"  />
                                <x-input-numeric title="" name="material_id" value="{{ $openinggodownstock->material_id}}" hidden   />
                                <x-input-numeric title="" name="trans_id" value="{{ $openinggodownstock->id}}" hidden    />
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>E - 13</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwte13" value="{{ $openinggodownstock->ostkwte13}}" onblur="tnetamount()"    />
                                <x-input-numeric title="InPcs" name="ostkpcse13" value="{{ $openinggodownstock->ostkpcse13}}" onblur="tnetamount()"     />
                                <x-input-numeric title="InFeet" name="ostkfeete13" value="{{ $openinggodownstock->ostkfeete13}}" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="e13"  id="e13" onclick="grp1(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Gali No 2</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtgn2" value="{{ $openinggodownstock->ostkwtgn2}}" onblur="tnetamount()"     />
                                <x-input-numeric title="InPcs" name="ostkpcsgn2" value="{{ $openinggodownstock->ostkpcsgn2}}" onblur="tnetamount()"     />
                                <x-input-numeric title="InFeet" name="ostkfeetgn2" value="{{ $openinggodownstock->ostkfeetgn2}}" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="gn2"  id="gn2" onclick="grp2(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>ALLAH MALIK SHOP</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtams" value="{{ $openinggodownstock->ostkwtams}}" onblur="tnetamount()"     />
                                <x-input-numeric title="InPcs" name="ostkpcsams" value="{{ $openinggodownstock->ostkpcsams}}" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeetams" value="{{ $openinggodownstock->ostkfeetams}}" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="ams"  id="ams" onclick="grp3(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>E - 24</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwte24" value="{{ $openinggodownstock->ostkwte24}}" onblur="tnetamount()"    />
                                <x-input-numeric title="InPcs" name="ostkpcse24" value="{{ $openinggodownstock->ostkpcse24}}" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeete24" value="{{ $openinggodownstock->ostkfeete24}}" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="e24"  id="e24" onclick="grp4(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>BOLTON SHOP</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtbs" value="{{ $openinggodownstock->ostkwtbs}}"  onblur="tnetamount()"   />
                                <x-input-numeric title="InPcs" name="ostkpcsbs" value="{{ $openinggodownstock->ostkpcsbs}}" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeetbs" value="{{ $openinggodownstock->ostkfeetbs}}" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="bs"  id="bs" onclick="grp5(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>OTHERS</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtoth" value="{{ $openinggodownstock->ostkwtoth}}"  onblur="tnetamount()"   />
                                <x-input-numeric title="InPcs" name="ostkpcsoth" value="{{ $openinggodownstock->ostkpcsoth}}"  onblur="tnetamount()"   />
                                <x-input-numeric title="InFeet" name="ostkfeetoth" value="{{ $openinggodownstock->ostkfeetoth}}" onblur="tnetamount()" />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="oth"  id="oth" onclick="grp6(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>TOTAL STOCK</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwttot" value="{{ $openinggodownstock->ostkwttot}}" disabled     />
                                <x-input-numeric title="InPcs" name="ostkpcstot" value="{{ $openinggodownstock->ostkpcstot}}" disabled     />
                                <x-input-numeric title="InFeet" name="ostkfeettot" value="{{ $openinggodownstock->ostkfeettot}}" disabled  />
                            </div>
                        </fieldset>




                        <fieldset class="border px-4 py-2 rounded">
                            <legend>COST</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ocostwt" value="{{ $openinggodownstock->ocostwt}}"     />
                                <x-input-numeric title="InPcs" name="ocostpcs" value="{{ $openinggodownstock->ocostpcs}}"     />
                                <x-input-numeric title="InFeet" name="ocostfeet" value="{{ $openinggodownstock->ocostfeet}}"  />
                            </div>
                        </fieldset>


                        {{-- Contract Details --}}
                        {{-- <x-tabulator-dynamic /> --}}

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



const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
// const getMaster = @json(route('materials.master')); // For Material Modal
const getMaster = @json(route('materials.mastermat'));
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dynamicTable = ""
        let dynamicTableData = []



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
            {title:"Category_Id", field:"category_id" , headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            // {title:"Source", field:"source" ,  responsive:0},
            // {title:"Sku", field:"sku" ,  responsive:0},
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
// function pushDynamicData(data)
// {

//     dynamicTableData.push({
//         material_id:data.id,
//         material_title:data.title,
//         category_id:data.category_id,
//         category:data.category,


//         sku_id:data.sku_id,
//         sku:data.sku,

//         dimension_id:data.dimension_id,
//         dimension:data.dimension,

//         bundle1:0,
//         bundle2:0,
//         pcspbundle1:0,
//         pcspbundle2:0,
//         gdswt:0,
//         gdsprice:0,
//         gdspricetot:0
//     })
//     //  dyanmicTable.setData()
//      dynamicTable.setData(dynamicTableData);
// }


// var updateValues = (cell) => {

//     sum = 0;
//     sum2=0;
//     var data = cell.getData();
//         //   var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
//         var row = cell.getRow();
//             var sum = (Number(data.qtykg) * Number(data.price))
//             var varqty = ( Number(data.balqty) - Number(data.qtykg) )
//             // var sum2 = (Number(data.qtykg) * Number(data.price))

//         row.update({

//             // "rcvblamount":sum2,
//             //  "saleamnt": sum,
//             //  "totval":sum,
//             //  "gdspricetot": sum2
//             "saleamnt": sum,
//             "varqty":varqty,
//             totval: sum

//             });

//     }
    // var tamount=0;
    function tnetamount()
        {

        ostkwttot.value=Number(ostkwte13.value)+Number(ostkwtgn2.value)+Number(ostkwtams.value)+Number(ostkwte24.value)+Number(ostkwtbs.value)+Number(ostkwtoth.value)
        ostkpcstot.value=Number(ostkpcse13.value)+Number(ostkpcsgn2.value)+Number(ostkpcsams.value)+Number(ostkpcse24.value)+Number(ostkpcsbs.value)+Number(ostkpcsoth.value)
        ostkfeettot.value=Number(ostkfeete13.value)+Number(ostkfeetgn2.value)+Number(ostkfeetams.value)+Number(ostkfeete24.value)+Number(ostkfeetbs.value)+Number(ostkfeetoth.value)


        }


// var totval = function(values, data, calcParams){
// var calc = 0;
// // var abc=0;
// values.forEach(function(value){
//     // if(value > 18){
//         calc += Number(value) ;
//         // abc += Number(value) ;
//     // }

// });
//  tamount = calc;
//   tnetamount();
// return calc;
// }

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
//         {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold"},
//         {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
//         {title:"StockQty",         field:"balqty"   },
//         {title:"VarQty",         field:"varqty",cellEdited: updateValues    },
//         {title:"Replace Description",field:"repname",       cssClass:"bg-gray-200 font-semibold",editor:true},
//         {title:"Brand",             field:"brand",editor:true,         cssClass:"bg-gray-200 font-semibold"},
//         {title:"UOM",               field:"sku"},


//         {   title:"Quantity",
//                 field:"qtykg",
//                 editor:"number",
//                 cssClass:"bg-green-200 font-semibold",
//                 validator:"required",
//                 formatter:"money",
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","integer"],
//                 cellEdited: updateValues,
//                },


//                { title:"Rate",
//                 field:"price",
//                 editor:"number",
//                 cssClass:"bg-green-200 font-semibold",
//                 validator:"required" ,
//                 formatter:"money",
//                 formatterParams:{thousand:",",precision:2},
//                 validator:["required","decimal(10,3)"] ,
//                 cellEdited: updateValues   ,
//             },



//             {   title:"Amount",
//                 field:"saleamnt",
//                 cssClass:"bg-gray-200 font-semibold",
//                 formatter:"money",
//                 formatterParams:{thousand:",",precision:0},
//                 // formatter:function(cell,row)
//                 // {
//                 //     //  return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)
//                 //      return  ( cell.getData().qtykg * cell.getData().price)
//                 // },
//                 bottomCalc:totval  },



//     ],
// })

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
    // if(dynamicTableData.length <= 0 )
    // {
    //     document.getElementById("submitbutton").disabled = true;
    // }else {
    //     document.getElementById("submitbutton").disabled = false;
    // }
}
  // Validation & Post
function validateForm()
{
    // var sid = document.getElementById("customer_id");
    //     var customer_id = sid.options[sid.selectedIndex];
    //     var deliverydt = document.getElementById("deliverydt");
    //     var qutno = document.getElementById("qutno");
    //     var prno = document.getElementById("prno");
    //     var podate = document.getElementById("podate");
    //     var quotation_id = document.getElementById("quotation_id");

    //     var discntper= document.getElementById("discntper");
    //     var cartage= document.getElementById("cartage");
    //     var discntamt= document.getElementById("discntamt");
    //     var rcvblamount= document.getElementById("rcvblamount");
    //     var per= document.getElementById("per");


    // Required
    // if(customer_id.value < 0)
    //     {
    //         showSnackbar("Please select From Customer");
    //         customer_id.focus();
    //         return;
    //     }
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
    // if(dynamicTableData.length == 0)
    // {
    //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
    //     return;
    // }
    //  dynamicTableData = dynamicTable.getData();
    // // Qty Required
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

    var data = { 'openinggodownstock' : dynamicTableData,'opdate':opdate.value,
            'ostkwte13':ostkwte13.value,'ostkpcse13':ostkpcse13.value,'ostkfeete13':ostkfeete13.value,
            'ostkwtgn2':ostkwtgn2.value,'ostkpcsgn2':ostkpcsgn2.value,'ostkfeetgn2':ostkfeetgn2.value,
            'ostkwtams':ostkwtams.value,'ostkpcsams':ostkpcsams.value,'ostkfeetams':ostkfeetams.value,
            'ostkwte24':ostkwte24.value,'ostkpcse24':ostkpcse24.value,'ostkfeete24':ostkfeete24.value,
            'ostkwtbs':ostkwtbs.value,'ostkpcsbs':ostkpcsbs.value,'ostkfeetbs':ostkfeetbs.value,'material_id':material_id.value,
            'ostkwtoth':ostkwtoth.value,'ostkpcsoth':ostkpcsoth.value,'ostkfeetoth':ostkfeetoth.value,
            'ostkwttot':ostkwttot.value,'ostkpcstot':ostkpcstot.value,'ostkfeettot':ostkfeettot.value,
            'ocostwt':ocostwt.value,'ocostpcs':ocostpcs.value,'ocostfeet':ocostfeet.value,'trans_id':trans_id.value
            };





    fetch(@json(route('openinggodownstock.update',$openinggodownstock)),{
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
            window.open(window.location.origin + "/openinggodownstock","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
}

function grp1(e13) {
        var ostkwte13 = document.getElementById("ostkwte13");
        var ostkpcse13 = document.getElementById("ostkpcse13");
        var ostkfeete13 = document.getElementById("ostkfeete13");

        ostkwte13.disabled = e13.checked ? true : false;
        ostkpcse13.disabled = e13.checked ? true : false;
        ostkfeete13.disabled = e13.checked ? true : false;

        ostkwte13.style.color ="black";
        ostkpcse13.style.color ="black";
        ostkfeete13.style.color ="black";
        }


        function grp2(gn2) {
        var ostkwtgn2 = document.getElementById("ostkwtgn2");
        var ostkpcsgn2 = document.getElementById("ostkpcsgn2");
        var ostkfeetgn2 = document.getElementById("ostkfeetgn2");

        ostkwtgn2.disabled = gn2.checked ? true : false;
        ostkpcsgn2.disabled = gn2.checked ? true : false;
        ostkfeetgn2.disabled = gn2.checked ? true : false;

        ostkwtgn2.style.color ="black";
        ostkpcsgn2.style.color ="black";
        ostkfeetgn2.style.color ="black";
    }


        function grp3(ams) {
        var ostkwtams = document.getElementById("ostkwtams");
        var ostkpcsams = document.getElementById("ostkpcsams");
        var ostkfeetams = document.getElementById("ostkfeetams");

        ostkwtams.disabled = ams.checked ? true : false;
        ostkpcsams.disabled = ams.checked ? true : false;
        ostkfeetams.disabled = ams.checked ? true : false;

        ostkwtams.style.color ="black";
        ostkpcsams.style.color ="black";
        ostkfeetams.style.color ="black";
    }


function grp4(e24) {
        var ostkwte24 = document.getElementById("ostkwte24");
        var ostkpcse24 = document.getElementById("ostkpcse24");
        var ostkfeete24 = document.getElementById("ostkfeete24");

        ostkwte24.disabled = e24.checked ? true : false;
        ostkpcse24.disabled = e24.checked ? true : false;
        ostkfeete24.disabled = e24.checked ? true : false;

        ostkwte24.style.color ="black";
        ostkpcse24.style.color ="black";
        ostkfeete24.style.color ="black";
    }

function grp5(bs) {
        var ostkwtbs = document.getElementById("ostkwtbs");
        var ostkpcsbs = document.getElementById("ostkpcsbs");
        var ostkfeetbs = document.getElementById("ostkfeetbs");

        ostkwtbs.disabled = bs.checked ? true : false;
        ostkpcsbs.disabled = bs.checked ? true : false;
        ostkfeetbs.disabled = bs.checked ? true : false;

        ostkwtbs.style.color ="black";
        ostkpcsbs.style.color ="black";
        ostkfeetbs.style.color ="black";
    }

function grp6(bs) {
        var ostkwtoth = document.getElementById("ostkwtoth");
        var ostkpcsoth = document.getElementById("ostkpcsoth");
        var ostkfeetoth = document.getElementById("ostkfeetoth");

        ostkwtoth.disabled = oth.checked ? true : false;
        ostkpcsoth.disabled = oth.checked ? true : false;
        ostkfeetoth.disabled = oth.checked ? true : false;

        ostkwtoth.style.color ="black";
        ostkpcsoth.style.color ="black";
        ostkfeetoth.style.color ="black";
    }






</script>


@endpush






</x-app-layout>



