<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Contract
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
                            {{-- <label for="supplier_id">Supplier</label>
                            <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                @foreach($suppliers as $supplier)
                                    @if ($supplier->id == $contract->supplier_id)
                                        <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                    @endif
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select> --}}

                            <label for="autocompleted" >Supplier/Item/Date<x-req /></label>
                            <div class="w-96 relative"   onclick="event.stopImmediatePropagation();" >
                                <input id="autocompleted" placeholder="Select Supplier Name" disabled value="{{$pcontract}}"   class=" px-5 py-3 w-full border border-gray-400 rounded-md"
                                onkeyup="onkeyUp(event)" />




                                <div>
                                    <select  id="supplier_id" name="supplier_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                   </select>
                                </div>
                            </div>


                            <label for="autocompleted1" >Items<x-req /></label>
                            <div class="w-96 relative"   onclick="event.stopImmediatePropagation();" >
                                {{-- <label for="autocompleted1">Item Name<x-req /></label> --}}
                                {{-- <input type="text"  class="col-span-2" id="autocompleted1" name="autocompleted1" placeholder="Select Items Name"
                                onkeyup="onkeyUp1(event)"  > --}}
                                <input id="autocompleted1" placeholder="Select Item Name" class=" px-5 py-10 w-full border border-gray-400 rounded-md"
                                onkeyup="onkeyUp1(event)" />

                            <div>
                                <select  id="item_id" name="item_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </select>
                            </div>

                            </div>


                            {{-- Contract Master - Invoice Date --}}
                            <label for="invoice_date">Contract Date</label>
                            <input type="date" class="col-span-2" id="invoice_date" style="text-align: right" name="invoice_date" value="{{ $contract->invoice_date->format('Y-m-d') }}" required>

                            {{-- Contract Master - Invoice Number --}}
                            <label for="number">Contract #</label>
                            <input type="text" class="col-span-2" id="number" name="number" placeholder="Invoice No"
                                minlength="3" title="minimum 3 characters required" value="{{ $contract->number }}" required>

                                <input type="text"  id="supid" name="supid" class="col-span-2" hidden   value="{{ $contract->supplier_id }}" >
                        </div>



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
                            <x-input-text title="Password For Edition Permission" name="edtpw" id="edtpw" type="password"     />
                            <x-input-text title="" name="dbpwrd2" id="dbpwrd2"  class="col-span-2" hidden  value="{{$passwrd}}" />

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
const getMaster = @json(route('mat.master'));
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);


document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
     })





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
    paginationSize:10,
    paginationSizeSelector:[10,15],
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
        {title:"Category", field:"source" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
        {title:"Items", field:"category" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
        {title:"Category_Id", field:"category_id",visible:false ,headerSortStartingDir:"asc" , responsive:0},
        {title:"Dimesion", field:"dimension" ,  responsive:0},
        {title:"Search Text", field:"srchi" ,  responsive:0},
        {title:"Sku_id", field:"sku_id",visible:false ,  responsive:0},
        {title:"Unit", field:"sku" ,  responsive:0},
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
    ///////////////////// CORRECTION ////////////////////////////
    // check if data in table already
    if(!dynamicTableData.filter( dt => dt.material_id === data.id).length){
        pushDynamicData(data)
    }
    ///////////////////// CORRECTION ////////////////////////////
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



item_id.addEventListener("click", () => {

// var result = dynamicTableData.filter( dt => dt.id == item_id.options[item_id.selectedIndex].value)
if(!dynamicTableData.filter( dt => dt.material_id === item_id.options[item_id.selectedIndex].value).length)
{

    dynamicTableData.push({
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
            dtyrate:0,
            invsrate:0,
            gdspricetot:0.00,
            // sno : dynamicTable.getDataCount()+1,




        })


}


});







//  Adds actual data to row - EDIT Special
function pushDynamicData(data)
{
    dynamicTableData.push({
        material_id:data.id,
        material_title:data.title,
        category_id:data.category_id,
        category:data.category,

        source_id:data.source_id,
        source:data.source,

        brand_id:data.brand_id,
        brand:data.brand,

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
    ///////////////////// CORRECTION ////////////////////////////
    //  dyanmicTable.setData()
    //  dynamicTable.setData(dynamicTableData);
    // console.log(dynamicTableData)
    ///////////////////// CORRECTION ////////////////////////////
}

var updateValues = (cell) => {
    var data = cell.getData();

    var sum = Number(data.bundle1 * 1)
    // var sum2 = Number(Number(data.gdswt) * Number(data.gdsprice))

        if(cell.getData().sku_id==1)
         {
             var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
             var sum3 =  Number(data.gdswt) * Number(data.dtyrate)
         }
         if(cell.getData().sku_id==2)
         {
            //  var sum2 =  ( (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2)) ) * Number(data.gdsprice)
            //  var sum3 =  ( (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2)) ) * Number(data.dtyrate)
             var sum2 =   (Number(data.bundle1) * 1)   * Number(data.gdsprice)
             var sum3 =   (Number(data.bundle1) * 1)  * Number(data.dtyrate)


         }

    var row = cell.getRow();
    row.update({
        "totpcs": sum,
        "gdspricetot": sum2,
        "purval": sum2,
        "dutval":sum3
    });
}



// var totval = function(values, data, calcParams){
//     var calc = 0;
//     values.forEach(function(value){
//             calc += Number(value) ;

//     });

//     // console.info(abc);
//     return calc;
// }

var totalVal = function(values, data, calcParams){
        var calc = 0;
        // values=0;
        values.forEach(function(value){
            calc += Number(value) ;
            // totwt+= value ;
            console.log(calc);

        });
        // totwt=calc;
        return calc;
    }


var customMutator = function(value, data, type, params, component){
    //value - original value of the cell
    //data - the data for the row
    //type - the type of mutation occurring  (data|edit)
    //params - the mutatorParams object from the column definition
    //component - when the "type" argument is "edit", this contains the cell component for the edited cell, otherwise it is the column component for the column

    return data.gdswt + data.gdsprice ; //return the sum of the other two columns.
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

        {title:"S.No",             field:"sno", formatter:"rownum",    cssClass:"bg-gray-200 font-semibold"},
        {title:"Id",                field:"material_id",    cssClass:"bg-gray-200 font-semibold"},
        {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold"},
        {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Category",          field:"category",       cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
        {title:"Source",            field:"source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Source",            field:"source",         cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Unit",               field:"sku",            cssClass:"bg-gray-200 font-semibold"},
        {title:"Brand",             field:"brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Brand",             field:"brand",          cssClass:"bg-gray-200 font-semibold",visible:false},

        {   title:"Pcs",
            field:"bundle1",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            validator:"required",
            formatter:"money",
            bottomCalc:"sum",
            formatterParams:{thousand:",",precision:0},
            validator:["required","integer"],
            cellEdited: updateValues,

            },

        // {   title:"Pcs/Bnd1",
        //     field:"pcspbundle1",
        //     editor:"number",
        //     cssClass:"bg-green-200 font-semibold",
        //     validator:"required" ,
        //     formatter:"money",
        //     formatterParams:{thousand:",",precision:2},
        //     validator:["required","integer"] ,
        //     cellEdited: updateValues  ,
        //     },

        // {   title:"Bundle2",
        //     field:"bundle2",
        //     editor:"number",
        //     cssClass:"bg-yellow-200 font-semibold",
        //     formatter:"money",
        //     formatterParams:{thousand:",",precision:2},
        //     validator:["required","integer"],
        //     cellEdited: updateValues  ,
        //     },

        // {   title:"Pcs/Bnd2",
        //     field:"pcspbundle2",
        //     editor:"number",
        //     cssClass:"bg-yellow-200 font-semibold",
        //     formatter:"money",
        //     formatterParams:{thousand:",",precision:2},
        //     validator:["required","integer"],
        //     cellEdited: updateValues ,
        //     },

        {   title:"TotPcs",
            field:"totpcs",
            cssClass:"bg-gray-200 font-semibold",
            bottomCalc:"sum",
            formatter:"money",
            visible:false,
            formatterParams:{thousand:",",precision:0},
            cellEdited: updateValues,
            formatter:function(cell,row)
            {
                return Number(cell.getData().bundle1)
            },
             },

        {   title:"Wt(Kg)",
            field:"gdswt",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            formatter:"money",
            formatterParams:{thousand:",",precision:3},
            validator:["required","numeric"],
            cellEdited:updateValues,
             bottomCalc:"sum",
            bottomCalcParams:{precision:3}  },

        {   title:"Supp.Price($)",
            field:"gdsprice",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            formatter:"money",
            formatterParams:{thousand:",",precision:5},
            validator:["required","numeric"],
            cellEdited:updateValues,
        },

        {   title:"DutyPrice($)",
            field:"dtyrate",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            formatter:"money",
            formatterParams:{thousand:",",precision:3},
            validator:["required","numeric"],
            cellEdited:updateValues,
        },

        {   title:"ComInvRs($)",
            field:"invsrate",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            formatter:"money",
            formatterParams:{thousand:",",precision:3},
            validator:["required","numeric"],
            cellEdited:updateValues,
        },


        {   title:"Supp.Val($)",
            field:"purval",
            cssClass:"bg-gray-200 font-semibold",
            // bottomCalc:totalVal,
            // formatterParams:{thousand:",",precision:3},
            bottomCalcParams:{precision:3} ,
            formatter:"money",
            formatterParams:{
                decimal:".",
                thousand:",",
                symbol:"$",
                precision:3     },
            formatter:function(cell,row)
            {
                    // console.log(cell.getData().sku_id)
                    if(cell.getData().sku_id == 1)
                    {

                        return (cell.getData().gdswt * cell.getData().gdsprice).toFixed(3);


                    }
                    else if (cell.getData().sku_id == 2)
                    {
                        return ((cell.getData().bundle1)  * (cell.getData().gdsprice)).toFixed(3);
                    }
                    else {
                        // Add for other types
                    }

                }
                 ,bottomCalc:totalVal
        },


        {   title:"Duty.Val($)",
            field:"dutval",
            cssClass:"bg-gray-200 font-semibold",
            // bottomCalc:"sum2",
            bottomCalc:totalVal,
            bottomCalcParams:{precision:0} ,
            formatter:"money",
            formatterParams:{
                decimal:".",
                thousand:",",
                symbol:"$",
                precision:3     },
            formatter:function(cell,row)
            {
                    // console.log(cell.getData().sku_id)
                    if(cell.getData().sku_id == 1)
                    {

                        return (cell.getData().gdswt * cell.getData().dtyrate).toFixed(3)

                    }
                    else if (cell.getData().sku_id == 2)
                    {
                        return ((cell.getData().bundle1) *  (cell.getData().dtyrate)).toFixed(3)
                    }
                    else {
                        // Add for other types
                    }


                }
                // ,bottomCalc:totval
        }











    ],
})

// ("#dynamicTable").tabulator({
//     rowFormatter:function(row){
//         var data = row.getData(); //get data object for row

//         if(data.col == "green"){
//             row.getElement().css({"background-color":"#A6A6DF"}); //apply css change to row element
//         }
//     },

// });




// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to show Modal
    if(e.ctrlKey && e.keyCode == 500){
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
    // var sid = document.getElementById("supplier_id");
    // var supplier_id = sid.options[sid.selectedIndex];
    var invoice_date = document.getElementById("invoice_date");
    var supid = document.getElementById("supid");
    var number = document.getElementById("number");

    // Required
    if(supid.value == 0 )
    {
        showSnackbar("Please select From Supplier");
        supplier_id.focus();
        return;
    }
    if(invoice_date.value === "")
    {
        showSnackbar("Please select From Invoice Date");
        invoice_date.focus();
        return;
    }
    if(number.value == "")
    {
        showSnackbar("Please add Invoice Number");
        number.focus();
        return;
    }
    if(dynamicTableData.length == 0)
    {
        showSnackbar("You must have atleast 1 row of item to Proceed","info");
        return;
    }
    dynamicTableData = dynamicTable.getData();
    // Qty Required
    for (let index = 0; index < dynamicTableData.length; index++) {
        const element = dynamicTableData[index];
        // if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.gdsprice == 0 || element.gdswt == 0)
        // {
        //     showSnackbar("Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");
        //     return;
        // }
        if (element.sku_id==1)
            {
                if(element.gdsprice == 0 || element.gdswt == 0  )
                    {
                        showSnackbar("Please fill Weight & Price all rows to proceed","info");
                        return;
                    }
            }
            if (element.sku_id==2)
            {
                if(element.bundle1 == 0 || element.gdsprice == 0 )
                {
                    showSnackbar("Please fill Bundle,PcsBundle & Price all rows to proceed","info");
                    return;
                }
            }



    }
    disableSubmitButton(true);
    var data = { 'contracts' : dynamicTableData ,'supid': supid.value,'invoice_date':invoice_date.value,'number':number.value};
    // All Ok - Proceed
    fetch(@json(route('contracts.update',$contract)),{
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
             window.open(window.location.origin + "/contracts","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
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

myarray=@json($resultArray);
const contries = myarray;
function onkeyUp(e)
{
    let keyword= e.target.value;
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.remove("hidden");

    let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));
    // console.log(filteredContries);
    renderOptions(filteredContries);

}


document.addEventListener('DOMContentLoaded',()=> {
    hidedropdown();
    hidedropdown1();
        });

function renderOptions(xyz){

    let dropdownEl=document.getElementById("supplier_id");

                dropdownEl.length = 0
                xyz.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.title)
                });
}

document.addEventListener("click" , () => {
    hidedropdown();
    hidedropdown1();
});


function hidedropdown()
{
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.add("hidden");
}


supplier_id.addEventListener("click", () => {

    let supplier_id= document.getElementById("supplier_id");
    let input= document.getElementById("autocompleted");
    let supid= document.getElementById("supid");

    input.value=supplier_id.options[supplier_id.selectedIndex].text;
    supid.value=supplier_id.options[supplier_id.selectedIndex].value;


    hidedropdown();
});


supplier_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
event.preventDefault();
supplier_id.click();

// let supplier_id= document.getElementById("supplier_id");
//     let input= document.getElementById("autocompleted");
//     input.value=supplier_id.options[supplier_id.selectedIndex].text;
//     hidedropdown();

}
});




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
                                       dimension_id:e.dimension_id,dimension:e.dimension,brand:e.brand,brand_id:e.brand_id }  ];
                        // console.log($itmdata[e.id].data);

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






</script>
@endpush



</x-app-layout>
