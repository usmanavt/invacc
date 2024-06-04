<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit GatePass
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
                                    @if ($customer->id == $gatepasse->customer->id)
                                    <option value="{{$customer->id}}" selected> {{$customer->title}} </option>
                                @endif
                                    <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>

                            <x-input-text title="DC No" name="dcno" id="dcno"  value="{{$gatepasse->dcno}}"  disabled  />
                            <x-input-date title="DC Date" id="saldate" name="saldate" value="{{$gatepasse->saldate}}"  disabled />
                        </div>
                        <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-date title="GatePass Date" id="gpdate" name="gpdate" value="{{$gatepasse->gpdate}}"  />
                            <x-input-text title="GatePass#" name="gpseqid" id="gpseqid" class="col-span-2" value="{{$gatepasse->gpseqid }}"  disabled />
                             <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                             <x-input-text title="" name="gpid" id="gpid" value="{{$gatepasse->id }}" hidden  disabled />
                             <x-input-text title="" name="sale_invoice_id" id="sale_invoice_id" value="{{$gatepasse->sale_invoice_id }}"  hidden />

                        </div>

                        <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-text title="Vehicle No" name="vehno" id="vehno" value="{{$gatepasse->vehno }}"    />
                            <x-input-text title="Driver Name" name="drvrname" id="drvrname" value="{{$gatepasse->drvrname }}"    />
                            <x-input-text title="Driver Tel.No" name="drvrtelno" id="drvrtelno" value="{{$gatepasse->drvrtelno }}"    />
                            <x-input-text title="Departure Time" name="deptime" id="deptime" value="{{$gatepasse->deptime }}"    />

                        </div>





                    </fieldset>


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
                            <x-input-text title="Password For Edition" name="edtpw" id="edtpw" type="password"  autocomplete="off"     />
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
        document.addEventListener('DOMContentLoaded',()=>{
            // calculateButton.disabled = true
            submitbutton.disabled = true
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

var headerMenu = function(){
    var menu = [];
    var columns = this.getColumns();

    for(let column of columns){

        //create checkbox element using font awesome icons
        let icon = document.createElement("i");
        icon.classList.add("fas");
        icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

        //build label
        let label = document.createElement("span");
        let title = document.createElement("span");

        title.textContent = " " + column.getDefinition().title;

        label.appendChild(icon);
        label.appendChild(title);

        //create menu item
        menu.push({
            label:label,
            action:function(e){
                //prevent menu closing
                e.stopPropagation();

                //toggle current column visibility
                column.toggle();

                //change menu item icon
                if(column.isVisible()){
                    icon.classList.remove("fa-square");
                    icon.classList.add("fa-check-square");
                }else{
                    icon.classList.remove("fa-check-square");
                    icon.classList.add("fa-square");
                }
            }
        });
    }

   return menu;
};






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


        // For Feet
        // var e13ft=Number(data.purpcse13)*Number(data.length)
        // var gn2ft=Number(data.purpcsgn2)*Number(data.length)
        // var amsft=Number(data.purpcsams)*Number(data.length)
        // var e24ft=Number(data.purpcse24)*Number(data.length)
        // var bsft=Number(data.purpcsbs)*Number(data.length)
        // var othft=Number(data.purpcsoth)*Number(data.length)




        var sumpcs=Number(data.gppcse13)+Number(data.gppcsgn2)+Number(data.gppcsams)+Number(data.gppcse24)+Number(data.gppcsbs)+Number(data.gppcsoth)
        var sumwt=Number(data.gpwte13)+Number(data.gpwtgn2)+Number(data.gpwtams)+Number(data.gpwte24)+Number(data.gpwtbs)+Number(data.gpwtoth)
        var sumfeet=Number(data.gpfeete13)+Number(data.gpfeetgn2)+Number(data.gpfeetams)+Number(data.gpfeete24)+Number(data.gpfeetbs)+Number(data.gpfeetoth)
        var row = cell.getRow();
        row.update({
            //  "purfeete13": e13ft,
            //  "purfeetgn2": gn2ft,
            //  "purfeetams": amsft,
            //  "purfeetbs": bsft,
            //  "purfeete24": e24ft,
            //  "purfeetoth": othft,


             "gppcstot":sumpcs,
             "gpwttot":sumwt,
             "gpfeettot":sumfeet
            //  totalVal: e13ft

        });
    }
    // var tamount=0;



var totval = function(values, data, calcParams){
var calc = 0;
// var abc=0;
values.forEach(function(value){
    // if(value > 18){
        calc += Number(value) ;
        // abc += Number(value) ;
    // }

});
//  tamount = calc;
//   tnetamount();
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
                {title:"Id",           field:"id", visible:false,cssClass:"bg-gray-200 font-semibold"},
                {title:"Material Name", field:"material_title",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Material Size",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu,cssClass:"bg-gray-200 font-semibold"},
                {title:"UOM",         field:"sku",responsive:0, hozAlign:"center",cssClass:"bg-gray-200 font-semibold"},
                {title:"Unitid",       field:"sku_id",visible:false},

                {
                    title:'Sale Invoice Data', headerHozAlign:"center",
                    columns:[
                        // {   title:"Replace Name",headerHozAlign :'center',field:"repname",responsive:0,editor:true},
                        // {   title:"Brand",headerHozAlign :'center',field:"mybrand",responsive:0,editor:true},
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"totpcs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gdswt",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"salefeet",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            ]},

                // {   title:"length",headerHozAlign :'right',hozAlign:"right",editor:true,responsive:0,field:"length",bottomCalc:"sum"},

                {title:"Replace Description",field:"repname",responsive:0,       editor:true},
                {title:"Brand",              field:"brand",responsive:0,     editor:true},



                {title:"dimension_id", field:"dimension_id",visible:false},
                {
                    title:'E-13', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcse13",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwte13",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},

                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeete13",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},





                        ]},

                        {
                    title:'GALI NO 2', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcsgn2",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwtgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeetgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}}
                        ]},

                        {
                    title:'A.MALIK SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcsams",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwtams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeetams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}}
                        ]},

                        {
                        title:'E-24', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcse24",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwte24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeete24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}}
                        ]},

                        {
                        title:'BOLTON SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcsbs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwtbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeetbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}}
                        ]},

                       {
                        title:'OTHERS', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",visible:false,editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcsoth",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",visible:false,editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwtoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",editor:true,visible:false,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeetoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:2}}
                        ]},

                        {
                        title:'TOTAL', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gppcstot",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:2}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpwttot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:2}},
                            {   title:"Feet",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gpfeettot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:2}}
                        ]},

                        {title:"gpkgrate",           field:"gpkgrate", visible:false},
                        {title:"gppcsrate",           field:"gppcsrate", visible:false},
                        {title:"gpfeetrate",           field:"gpfeetrate", visible:false},





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
        var per= document.getElementById("per");
        // var purinvsno = document.getElementById("purinvsno")


    // Required
    // if(customer_id.value < 0)
    //     {
    //         showSnackbar("Please select From Customer");
    //         // customer_id.focus();
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

        // if(purinvsno.value == "")
        // {
        //     showSnackbar("Please add prno");
        //     purinvsno.focus();
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
    // dynamicTableData = dynamicTable.getData();
    // // Qty Required
    for (let index = 0; index < dynamicTableData.length; index++) {
        const element = dynamicTableData[index];
        if(element.gppcstot > element.totpcs || element.gpwttot > element.gdswt || element.gpfeettot > element.salefeet )
                {
                    showSnackbar("GatePass Qty must be less than sale invoice qty","info");
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

    // var data = { 'customerorder' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
    //     'customer_id': customer_id.value,'deliverydt':deliverydt.value,'quotation_id':quotation_id.value,'poseqno':poseqno.value,
    //     'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
    //     'podate':podate.value,'pono':pono.value,'qutno':qutno.value,'qutdate':qutdate.value,'prno':prno.value
    // ,'sale_invoice_id':sale_invoice_id.value};

    var data = { 'gatepasse' : dynamicTableData,'gpid':gpid.value,
        'customer_id': customer_id.value,'sale_invoice_id':sale_invoice_id.value,'saldate':saldate.value,'gpseqid':gpseqid.value,
                          'gpdate':gpdate.value,'dcno':dcno.value,'vehno':vehno.value,'drvrname':drvrname.value,'drvrtelno':drvrtelno.value,'deptime':deptime.value      };




    fetch(@json(route('gatepasse.update',$gatepasse)),{
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
            window.open(window.location.origin + "/gatepasse","_self" );
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


    function EnableDisableTextBox(per) {
        var gpseqid = document.getElementById("gpseqid");
        gpseqid.disabled = per.checked ? false : true;
        gpseqid.style.color ="black";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }

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



