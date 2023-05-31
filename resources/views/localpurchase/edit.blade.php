<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
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
                            <select  autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                @foreach($suppliers as $supplier)
                                    @if ($supplier->id == $commercialInvoice->supplier_id)
                                    <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                @endif
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select>


                            <label for="invoice_date">Invoice Date</label>
                            <input type="date" class="col-span-2" id="invoice_date" name="invoice_date" value="{{ $commercialInvoice->invoice_date->format('Y-m-d') }}"  required>
                            {{-- ->format('Y-m-d') --}}
                            {{-- Contract Master - Invoice Number --}}
                            <label for="invoiceno">Invoice #</label>
                            <input type="text" class="col-span-2" id="invoiceno" name="invoiceno" placeholder="Invoice No"
                                minlength="3" title="minimum 3 characters required" value="{{ $commercialInvoice->invoiceno }}" required>

                        </div>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="bankcharges" value="{{ $commercialInvoice->bankcharges }}" required  onblur="tnetamount()" />
                                <x-input-numeric title="Discount(Amount)" name="collofcustom" value="{{ $commercialInvoice->collofcustom }}" disabled   />
                                <x-input-numeric title="Cartage" name="exataxoffie" value="{{ $commercialInvoice->exataxoffie }}"  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Payble Amount" name="bankntotal" value="{{ $commercialInvoice->total }}" disabled />
                                <x-input-numeric title="" name="contract_id" value="{{ $commercialInvoice->id }}" hidden />
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
console.log(@json($cd))
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
const getMaster = @json(route('materials.master')); // For Material Modal
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
    //  dyanmicTable.setData()
     dynamicTable.setData(dynamicTableData);
}
var updateValues = (cell) => {

    var data = cell.getData();
    var sum = (Number(data.gdswt) * Number(data.perkg)).toFixed(0)
    var sum2 =  (Number(data.gdswt) * Number(data.gdsprice)).toFixed(0)
    var row = cell.getRow();
    //  console.info(abc);
    row.update({

        "amtinpkr": sum,
        "gdspricetot": sum2,
    });

}

//  var tamount=0;
    function tnetamount()
        {
            //  crtg=parseFloat(exataxoffie.value).toFixed(0);

            collofcustom.value=0;
            bankntotal.value=0;
            collofcustom.value=(tamount*bankcharges.value/100).toFixed(0);
            bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value)   ;

        }




var totalVal = function(values, data, calcParams){
    //values - array of column values
    //data - all table data
    //calcParams - params passed from the column definition object
    // console.log(data);

    var calc = 0;
    values.forEach(function(value){
        // calc=amtinpkr;
        calc += value ;
    });
    // console.log(calc);
    // tamount = calc;
    //  tnetamount();
     return calc;
}

var totval = function(values, data, calcParams){
    //values - array of column values
    //data - all table data
    //calcParams - params passed from the column definition object

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

        {title: "id",field: "myid",visible:false},
                {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                        values:newList,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },


        //  {title: "Location",field: "locid"},
        {title:"Id",                field:"material_id",            cssClass:"bg-gray-200 font-semibold"},
        {title:"Material",          field:"material_title",         cssClass:"bg-gray-200 font-semibold"},
        {title:"Category_id",       field:"material.category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Category",          field:"material.category",       cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension",         field:"dimension_id",            cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Dimension",         field:"material.dimension",      cssClass:"bg-gray-200 font-semibold"},
        {title:"Replace Description",       field:"repname",                 cssClass:"bg-gray-200 font-semibold",editor:true},
        {title:"Source",            field:"material.source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
         {title:"Source",            field:"material.source",         cssClass:"bg-gray-200 font-semibold"},
        {title:"Sku",               field:"material.sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Sku",               field:"material.sku",            cssClass:"bg-gray-200 font-semibold"},
        {title:"Brand",             field:"material.brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
        {title:"Brand",             field:"material.brand",          cssClass:"bg-gray-200 font-semibold"},

        {   title:"Qunaity",
            field: "gdswt",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            validator:"required",
            formatter:"money",
            formatterParams:{thousand:",",precision:2},
            validator:["required","integer"],
            cellEdited: updateValues,
            bottomCalc:"sum"


            },

        {   title:"Rate",
            field:"perkg",
            editor:"number",
            cssClass:"bg-green-200 font-semibold",
            validator:"required" ,
            formatter:"money",
            formatterParams:{thousand:",",precision:2},
            validator:["required","decimal(10,2)"] ,
            cellEdited: updateValues  ,
            },


        {   title:"Amount",
            field:"amtinpkr",
            cssClass:"bg-gray-200 font-semibold",
            formatter:"integer",
             formatterParams:{thousand:",",precision:0},
               formatter:function(cell,row)
            {
                //   return (cell.getData().gdswt * cell.getData().perkg)
                return (cell.getData().amtinpkr )
            },
            bottomCalc:totval
        },

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
    for (let index = 0; index < dynamicTableData.length; index++) {
        const element = dynamicTableData[index];


               if(element.location === undefined)
               {
                showSnackbar("Location must be Enter","info");
                return;
               }




        if(element.bundle1 == 0 || element.pcspbundle1 == 0  || element.gdswt == 0)
        {
            showSnackbar("Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");
            return;
        }
    }
    // 'total' : parseFloat(banktotal.value).toFixed(2),
    disableSubmitButton(true);
     var data = { 'localpurchase' : dynamicTableData,'contract_id':parseFloat(contract_id.value).toFixed(0),'bankntotal':parseFloat(bankntotal.value).toFixed(0),'collofcustom':parseFloat(exataxoffie.value).toFixed(0),'exataxoffie':parseFloat(exataxoffie.value).toFixed(0) ,'bankcharges':parseFloat(bankcharges.value).toFixed(0) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':invoiceno.value};
    // var data = { 'contracts' : dynamicTableData,'banktotal':parseFloat(total.value).toFixed(2),'exataxoffie':parseFloat(exataxoffie.value).toFixed(2),'collofcustom':parseFloat(collofcustom.value).toFixed(2),'bankcharges':parseFloat(bankcharges.value).toFixed(2) ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'invoiceno':number.value};
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



</script>


@endpush






</x-app-layout>



