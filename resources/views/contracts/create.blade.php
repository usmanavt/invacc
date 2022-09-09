<x-app-layout>

    @push('styles')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.3.3/css/tabulator_simple.min.css' integrity='sha512-MiBxahZcoFzbr3jfdy0MzAzdqPy0q9/ZX6usJ4QfsvVPMe4ywyKui1+lWEEOLwpDkEtEgkRxb2r9+RGOVCRhMw==' crossorigin='anonymous'/>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Contract') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    {{-- <form action="{{ route('contracts.store') }}" method="post" onsubmit="formValidation(event)"> --}}
                    {{-- @csrf --}}
                        <div class="grid grid-cols-1">
                            {{-- Contract Master --}}
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                {{-- Contract Master --}}
                                <label for="supplier_id">Supplier</label>
                                <select class="col-span-2" name="supplier_id" id="supplier_id" required>
                                    <option value="" selected>--Supplier</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                    @endforeach
                                </select>

                                {{-- Contract Master - Invoice Date --}}
                                <label for="invoice_date">Invoice Date</label>
                                <input type="date" class="col-span-2" id="invoice_date" name="invoice_date" required>

                                {{-- Contract Master - Invoice Number --}}
                                <label for="number">Invoice #</label>
                                <input type="text" class="col-span-2" id="number" name="number" placeholder="Invoice No"
                                    minlength="3" title="minimum 3 characters required" required>

                            </div>

                            {{-- Contract Details --}}
                            <div class="flex flex-row pt-8">
                                
                                <div class="grid grid-cols-1 justify-between gap-4">
                                    <h1 class=" text-indigo-500 text-sm">
                                        To add a new row, press <kbd class="bg-slate-500 text-white rounded px-2">Ctrl + Space</kbd>
                                    </h1>
                                    <div id="dynamicTable"></div>
                                </div>

                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-2">
                                <button
                                    id="submitbutton" onclick="validateForm()"
                                    class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                    <i class="fa fa-save fa-fw"></i>
                                    Submit
                                </button>
                            </div>

                    {{-- </form> --}}
                </div>

            </div>
        </div>
    </div>

{{-- Modal --}}
<div id="myModal" class="fixed hidden bg-gray-300 bg-opacity-70 duration-500 mx-auto z-10 h-full w-full top-0">

    <!-- Modal content -->
    <div class="max-w-3xl mx-auto mt-52 bg-white rounded shadow px-6">
        <div class="flex justify-between py-4">
            <h1 class="font-semibold">Items List</h1>
            <span class="close px-2 bg-gray-300 rounded-full text-white cursor-pointer hover:bg-gray-400" onclick="closeModal()">&times;</span>
        </div>
        <div class="">
            <div class="flex flex-row relative">
                <i class="fa fa-search fa-fw text-indigo-500 absolute top-1 left-1"></i>
                <input type="text" class="pl-8 border focus:ring focus:ring-indigo-500 h-8" id="data_filter" onkeyup="dataFilter(this)" placeholder="Search here...">
            </div>
                <div id="example-table-info" class="mr-2 text-sm text-gray-500"></div>
            </div>
            
            <div id="tableData">
                {{-- table data --}}
            </div>
        </div>
    </div>
</div>

   


@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.3.3/js/tabulator.min.js' integrity='sha512-LUXZzTaZ4dfN43AUEQtKG6xxKYlThiiBtjdmgs7FK5OnUFNE2FnQTb/n+DdQX7CDg9wZDeYKYUk1FVfUgIw7ug==' crossorigin='anonymous'>
</script>

<script>
const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
const getMaster = @json(route('materials.master'));
let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
let modal = document.getElementById("myModal")

let table;
let searchValue = "";
let dyanmicTable = ""; // Tabulator 
let dynamicTableData = [];

//  Table Filter
function dataFilter(element)
{
    searchValue = element.value;
    table.setData(getMaster,{search:searchValue});
}

// The Table for Materials Modal
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
    // console.log('hi');
    var simple = {...row}
    var data = simple._row.data
    //  Filter Data here . 
    var result = dynamicTableData.filter( dt => dt.id == data.id)
    if(result.length <= 0)
    {
        pushDynamicData(data)
    }

})
//  Adds actual data to row
function pushDynamicData(data)
{
    dynamicTableData.push({ 
        id:data.id,
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

        bundle1:0,
        bundle2:0,
        pcspbundle1:0,
        pcspbundle2:0,
        gdswt:0,
        gdsprice:0,
        gdspricetot:0
    })
}
//  Modal Functions
function showModal(){ modal.style.display = "block"}
function closeModal(){  modal.style.display = "none"}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
    modal.style.display = "none";
  }
} 

var updateBundles = (cell) => {
    var data = cell.getData();
    var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
    var row = cell.getRow();
    row.update({
        "ttpcs": sum
    });
}

var updateCost = (cell) => {
    var data = cell.getData();
    var sum = Number(data.gdswt) * Number(data.gdsprice)
    var row = cell.getRow();
    row.update({
        "gdspricetot": sum
    });
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
        {title:"Id", field:"id",cssClass:"bg-gray-200 font-semibold"},
        {title:"Material", field:"title",cssClass:"bg-gray-200 font-semibold"},
        {title:"Category_id", field:"category_id",visible:false,cssClass:"bg-gray-200 font-semibold"},
        {title:"Category", field:"category",cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension", field:"dimension_id",visible:false,cssClass:"bg-gray-200 font-semibold"},
        {title:"Dimension", field:"dimension",cssClass:"bg-gray-200 font-semibold"},
        {title:"Source", field:"source_id",visible:false,cssClass:"bg-gray-200 font-semibold"},
        {title:"Source", field:"source",cssClass:"bg-gray-200 font-semibold"},
        {title:"Sku", field:"sku_id",visible:false,cssClass:"bg-gray-200 font-semibold"},
        {title:"Sku", field:"sku",cssClass:"bg-gray-200 font-semibold"},
        {title:"Brand", field:"brand_id",visible:false,cssClass:"bg-gray-200 font-semibold"},
        {title:"Brand", field:"brand",cssClass:"bg-gray-200 font-semibold"},

        {title:"Bundle1", field:"bundle1",editor:"number",cssClass:"bg-green-200 font-semibold",validator:"required" ,formatter:"money", formatterParams:{thousand:",",precision:2},validator:["required","integer"] ,cellEdited: updateBundles},
        {title:"Pcs/Bnd1", field:"pcspbundle1",editor:"number",cssClass:"bg-green-200 font-semibold",validator:"required" ,formatter:"money", formatterParams:{thousand:",",precision:2},validator:["required","integer"] , cellEdited: updateBundles},
        {title:"Bundle2", field:"bundle2",editor:"number",cssClass:"bg-yellow-200 font-semibold",formatter:"money", formatterParams:{thousand:",",precision:2},validator:["required","integer"],cellEdited: updateBundles},
        {title:"Pcs/Bnd2", field:"pcspbundle2",editor:"number",cssClass:"bg-yellow-200 font-semibold",formatter:"money", formatterParams:{thousand:",",precision:2},validator:["required","integer"],cellEdited: updateBundles},

        {title:"TotPcs", field:"ttpcs",cssClass:"bg-gray-200 font-semibold" ,formatter:"money",editable:false ,validator:["required","float"]},

        {title:"Wt(MT)", field:"gdswt",editor:"number",cssClass:"bg-green-200 font-semibold",formatter:"money",validator:["required","float"],cellEdited:updateCost},
        {title:"Rs($)", field:"gdsprice",editor:"number",cssClass:"bg-green-200 font-semibold",formatter:"money",validator:["required","float"], cellEdited:updateCost},
        {title:"Val($)", field:"gdspricetot",cssClass:"bg-gray-200 font-semibold",formatter:"money",validator:["required","float"], formatterParams:{
            decimal:".",
            thousand:",",
            symbol:"$"
        }},

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
    dynamicTableData.forEach((item) => {
        // console.log(item);
    }) 
    if(dynamicTableData.length <= 0 )
    {
        document.getElementById("submitbutton").disabled = true;
    }else {
        document.getElementById("submitbutton").disabled = false;
    }
}
//  For Setting Dates
function setDateToToday()
{
    var arr = document.getElementById('invdate');
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    // console.log(today);
    arr.setAttribute("min",today);
    //  LearnMore - https://stackoverflow.com/questions/12346381/set-date-in-input-type-date?answertab=active#tab-top
}
  // Validation & Post
function validateForm()
{
    var sid = document.getElementById("supplier_id");
    var supplier_id = sid.options[sid.selectedIndex];
    var invoice_date = document.getElementById("invoice_date");
    var number = document.getElementById("number");

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
        // console.log(element);
        if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.gdsprice == 0 || element.gdswt == 0)
        {
            showSnackbar("Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");
            return;
        }
    }
    disableSubmitButton(true);
    var data = { 'contracts' : dynamicTableData ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'number':number.value};
    // All Ok - Proceed
    fetch(@json(route('contracts.store')),{
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
            window.open(window.location.origin + "/contracts","_self" );
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