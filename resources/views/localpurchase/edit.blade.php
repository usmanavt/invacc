<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Local Purchasing
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
                            <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" disabled >
                                @foreach($suppliers as $supplier)
                                    @if ($supplier->id == $commercialInvoice->supplier_id)
                                    <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                @endif
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select>

                            <label for="autocompleted1" >Items<x-req /></label>
                            <div class="w-96 relative"   onclick="event.stopImmediatePropagation();" >
                                <input id="autocompleted1" placeholder="Select Item Name" class=" px-5 py-10 w-full border border-gray-400 rounded-md"
                                onkeyup="onkeyUp1(event)" />

                            <div>
                                <select  id="item_id" name="item_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-96 h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </select>
                            </div>

                            </div>

                            <label for="invoice_date">Invoice Date</label>
                            <input type="date"  id="invoice_date" size="10" name="invoice_date" value="{{ $commercialInvoice->invoice_date->format('Y-m-d') }}"  required>
                            {{-- ->format('Y-m-d') --}}
                            {{-- Contract Master - Invoice Number --}}
                            <label for="invoiceno">Invoice #</label>
                            <input type="text"  id="invoiceno" size="10" name="invoiceno" placeholder="Invoice No"
                                minlength="3" title="minimum 3 characters required" value="{{ $commercialInvoice->invoiceno }}" required>

                            <label for="challanno">Bill #<x-req /></label>
                            <input type="text"  id="challanno" name="challanno" size="10" value="{{ $commercialInvoice->challanno }}" >


                                {{-- <label for="gpassno">GatePass #<x-req /></label> --}}
                                <input type="text" class="col-span-2" id="gpassno" name="gpassno" value="{{ $commercialInvoice->gpassno }}" hidden   placeholder="gpassno"
                                    minlength="1" title="minimum 1 characters required" required>
                        </div>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="insurance" value="{{ $commercialInvoice->insurance }}" disabled  />
                                 <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                 <x-input-numeric title="Discount(Amount)" name="collofcustom" value="{{ $commercialInvoice->collofcustom }}"    />
                                <x-input-numeric title="Cartage/Loading Charges" name="exataxoffie" value="{{ $commercialInvoice->exataxoffie }}"  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Cutting/Repairing Charges" name="otherchrgs" value="{{ $commercialInvoice->otherchrgs }}" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Payble Amount" name="bankntotal" value="{{ $commercialInvoice->total }}"  />
                                <x-input-numeric title="" name="contract_id" value="{{ $commercialInvoice->id }}" hidden />
                                    <x-input-numeric title="Delete Mode" name="dltid" id="dltid" hidden />
                            </div>
                        </fieldset>

                        <div class="flex flex-row px-4 py-2 items-center">
                            {{-- <x-label value="Add Pcs & Feet Size & Press"></x-label> --}}
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Generate Item Cost With Other Charges</x-button>
                            {{-- <x-label value="This will prepare your commercial invoice for Submission"></x-label> --}}
                            <label for="">
                                Descripiton <span class="text-red-500 font-semibold"></span>
                            </label>
                            <textarea name="comdescription" id="comdescription" cols="30" rows="2" maxlength="150" required class="rounded"> {{ $commercialInvoice->comdescription }} </textarea>
                        </div>
                        <div>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" {{ $commercialInvoice->ttype === 1 ? 'checked' : '' }} type="checkbox" name="comp" id="comp"   onclick="chqcol(this)" >

                            <label for="">
                                <span style="color: brown;font-weight: bold"> Temporary </span> <span class="text-red-500 font-semibold  "></span>
                                 </label>
                                 <input type="text" title="t1"  id="p9" name="p9" value="0"  hidden    >
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
        document.getElementById("autocompleted1").focus();
        hidedropdown1();
     })

let table;
let searchValue = "";
console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
// const getMaster = @json(route('materials.master')); // For Material Modal

const getMaster = @json(route('locmat.master'));
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let dyanmicTable = ""; // Tabulator
let dynamicTableData = @json($cd);

// Populate Locations in Tabulator
// const locations = @json($locations);
//         var newList=[]
//         locations.forEach(e => {
//             newList.push({value:e.title,label:e.title , id:e.id})

//         });
        const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})
        });

    var calculate = function(){
    const data = dynamicTable.getData()

    var amtinpkrtotal = 0
    var amtper = 0
    var perft=0
    var pricevaluecostsheet=0

    tnetamount();

            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                // dtyamtinpkrtotal += parseFloat(e.dtyamtinpkr)
            });

            data.forEach(e => {
                e.amtper = parseFloat(e.amtinpkr)/amtinpkrtotal*100
                e.pricevaluecostsheet= bankntotal.value * parseFloat(e.amtper)/100
                // console.log(bankntotal.value)

                   if(e.sku==='KG')
                    {
                        e.perft=((bankntotal.value * parseFloat(e.amtper)/100)/e.gdswt).toFixed(3)
                    }
                    if(e.sku==='PCS')
                    {
                        e.perft=((bankntotal.value * parseFloat(e.amtper)/100)/e.pcs).toFixed(3)                    }
                    if(e.sku==='FEET')
                    {
                        e.perft=((bankntotal.value * parseFloat(e.amtper)/100)/e.qtyinfeet).toFixed(3)
                    }

                    perft=e.cstrt
                    pricevaluecostsheet=e.cstamt
                    // console.log(cstrt)
            });
            dynamicTable.setData(data)

        }





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
        paginationSize:20,
        paginationSizeSelector:[10,25,50,100],
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
            {title:"Category_Id", field:"category_id" , visible:false ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Search Text", field:"srchi" ,  responsive:0},
            {title:"Unit", field:"sku" ,  responsive:0},
            {title:"sku_id", field:"sku_id",visible:false ,  responsive:0},
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

        // console.info(data)
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
let abc=0;
//  Adds actual data to row - EDIT Special

item_id.addEventListener("click", () => {

var result = dynamicTableData.filter( dt => dt.id == item_id.options[item_id.selectedIndex].value)

if(result.length <= 0)
{

// var inArray = dynamicTableData.filter( i => dynamicTableData.id == item_id.options[item_id.selectedIndex].value)

// dynamicTableData.push({ id:item_id.options[item_id.selectedIndex].value})

dynamicTableData.push({
// dynamicTable.addData([
//     {


        material_id:item_id.options[item_id.selectedIndex].value,
        id:0,
        title:item_id.options[item_id.selectedIndex].text,
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

            machineno:'',
            repname:'',
            forcust:'',
            purunit:'',

             gdswt:0,
             pcs:0,
             qtyinfeet:0,
             gdsprice:0,
             length:0,
             amtinpkr:0,
             cstrt:0,
             cstamt:0


    }

)
// dynamicTable.setData(dynamicTableData);

}


});



function pushDynamicData(data)
{


    dynamicTableData.push({
        material_id:data.id,
        title:data.title,
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
                // purunit:'',
                machineno:'',
                repname:'',
                forcust:'',
                purunit:'',

                 gdswt:0,
                 pcs:0,
                 qtyinfeet:0,
                 gdsprice:0,
                 length:0,
                 amtinpkr:0
    })
    //  dyanmicTable.setData()
     dynamicTable.setData(dynamicTableData);
}
var updateValues = (cell) => {
        var data = cell.getData();
        // var leninft = Number(data.pcs) * Number(data.length)
        if(data.sku==='KG')
         {

            var sum =  Number(data.gdswt) * Number(data.gdsprice)
             var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
         }
         if(data.sku==='PCS')
         {
             var sum =  Number(data.pcs) * Number(data.gdsprice)
             var sum2 =  Number(data.pcs) * Number(data.gdsprice)
         }
         if(data.sku==='FEET')
         {
             var sum =  Number(data.qtyinfeet) * Number(data.gdsprice)
             var sum2 =  Number(data.qtyinfeet) * Number(data.gdsprice)
         }
         var crt=data.gdsprice
        var row = cell.getRow();
        row.update({
            "amtinpkr": sum,
            "gdspricetot": sum2,
            "perft":crt,
            "pricevaluecostsheet":sum


        });
    }

//  var tamount=0;
    function tnetamount()
        {

            // bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
            // collofcustom.value=(tamount*insurance.value/100).toFixed(0);

            if (insurance.disabled)
            {insurance.value=(collofcustom.value/tamount*100).toFixed(2)};

            if (!insurance.disabled)
            {collofcustom.value=(tamount*insurance.value/100).toFixed(0);};
            bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;

        }




// var totalVal = function(values, data, calcParams){
//     var calc = 0;
//     values.forEach(function(value){
//         // calc=amtinpkr;
//         calc += Number(value);
//     });
//     // console.log(calc);
//      tamount = calc;
//     //  tnetamount();
//      return calc;
// }

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
        //  {title: "Location",field: "locid"},
        {title:"S.No",             field:"sno", formatter:"rownum",responsive:0,cssClass:"bg-gray-200 font-semibold"},
        {title:"Id",                field:"id",            cssClass:"bg-gray-200 font-semibold"},
        {title:"Material",          field:"title",         cssClass:"bg-gray-200 font-semibold"},
        {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Category",          field:"category",       cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
        // {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
        // {title:"M/Unit",            field:"sku",            cssClass:"bg-gray-200 font-semibold"},

        // {title: "id",field: "myid",visible:false},
        //         {title:"Location", field:"location" ,editor:"list" , editorParams:   {
        //                 values:newList,
        //                 cssClass:"bg-green-200 font-semibold",
        //                 validator:["required"]
        //             }
        //         },

                {title: "id",field: "skuid",visible:false},
                {title:"UOM", field:"sku" ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },


        // {title:"PurUnit",           field:"purunit",        cssClass:"bg-gray-200 font-semibold",validator:"in:p|k|f",editor:true},
        {title:"Replace Description",field:"repname",       editor:true},
        {title:"Brand",              field:"machineno",     editor:true},
        {title:"ForCustomer",        field:"forcust",       editor:true},


        {   title:"Weight",
            field: "gdswt",
            editor:"number",
            validator:"required",
            formatter:"money",
            formatterParams:{thousand:",",precision:2},
            // validator:["required","integer"],
            cellEdited: updateValues,
            bottomCalc:"sum"


            },

        {   title:"Qty(Pcs)",
            field:"pcs",
            editor:"number",
            validator:"required" ,
            formatter:"money",
            formatterParams:{thousand:",",precision:2},
            validator:["required","decimal(10,2)"] ,
            cellEdited: updateValues  ,
            bottomCalc:"sum"
            },

            // {title:"Length",
            //     field:"length",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     validator:"required",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     validator:["required","integer"],
            //     cellEdited: updateValues,
            //    },

               {title:"Qty(Feet)",
                field:"qtyinfeet",
                editor:"number",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                //  validator:["required","integer"],
                 cellEdited: updateValues,
                 bottomCalc:"sum"
               },

               {title:"Price",
                field:"gdsprice",
                editor:"number",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,2)"] ,
                cellEdited: updateValues   ,
            },

            {   title:"Amount",
                field:"amtinpkr",
                cssClass:"bg-gray-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:0},
                // formatter:function(cell,row)
                // {
                //     // return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)

                //     return console.log(cell.getData().skuid.sku_id)


                // },
                bottomCalc:totval  },

                {title:"CostPrice",
                field:"perft",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:3},
                validator:["required","decimal(10,0)"] ,
                cellEdited: updateValues   ,
            },

            {title:"CostAmount",
                field:"pricevaluecostsheet",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,0)"] ,
                cellEdited: updateValues   ,
                bottomCalc:"sum",
            },
    ],
})

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
    var sid = document.getElementById("supplier_id");
    var supplier_id = sid.options[sid.selectedIndex];
    var invoice_date = document.getElementById("invoice_date");
    var invoiceno = document.getElementById("invoiceno");

    // Required
    if(supplier_id.value <= 0)
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
    if(invoiceno.value == "")
    {
        showSnackbar("Please add Invoice Number");
        invoiceno.focus();
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


    //         //    if(element.location === undefined)
    //         //    {
    //         //     showSnackbar("Location must be Enter","info");
    //         //     return;
    //         //    }
    //         //    if(element.gdswt == 0 || element.pcs == 0 || element.qtyinfeet == 0 || element.gdsprice == 0 )

    //         //     {
    //         //         showSnackbar("Please fill all Weight,Length,Pcs & Price all rows to proceed","info");
    //         //         return;
    //         //     }

    // }
    // 'total' : parseFloat(banktotal.value).toFixed(2),
    disableSubmitButton(true);
     var data = { 'localpurchase' : dynamicTableData,'contract_id':parseFloat(contract_id.value).toFixed(0),'bankntotal':parseFloat(bankntotal.value).toFixed(0),
     'collofcustom':parseFloat(collofcustom.value).toFixed(0),'exataxoffie':parseFloat(exataxoffie.value).toFixed(0) ,
     'insurance':parseFloat(insurance.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value,
     'otherchrgs':otherchrgs.value,'gpassno':gpassno.value,'challanno':challanno.value,'comdescription':comdescription.value,'p9':p9.value,'dltid':dltid.value};
    // var data = { 'contracts' : dynamicTableData,'banktotal':parseFloat(total.value).toFixed(2),'exataxoffie':parseFloat(exataxoffie.value).toFixed(2),'collofcustom':parseFloat(collofcustom.value).toFixed(2),'insurance':parseFloat(insurance.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':number.value};
    // All Ok - Proceed
    fetch(@json(route('localpurchase.update',$commercialInvoice)),{
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
            window.open(window.location.origin + "/localpurchase","_self" );
        }
    })
    .catch(error => {
        showSnackbar("Errors occured","red");
        disableSubmitButton(false);
    })
}

function EnableDisableTextBox(per) {
        var insurance = document.getElementById("insurance");
        insurance.disabled = per.checked ? false : true;
        insurance.style.color ="black";
    }


insurance.onblur=function(){
    per=false
    tnetamount();
    // collofcustom.value=(tamount * insurance.value/100).toFixed(0);
    // bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
}

collofcustom.onblur=function(){
    // insurance.value=(collofcustom.value/tamount * 100).toFixed(2);
    // bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
    tnetamount();
}



function chqcol(comp) {
        var p9 = document.getElementById("p9");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(comp.checked==true)
        {
            p9.value=1;
        }
        else
        {
            p9.value=0;
        }

    }

    edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }





// ********* search list for item_id


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



