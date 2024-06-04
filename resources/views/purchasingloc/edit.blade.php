<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Goods Received Note (Local)
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
                                    @if ($supplier->id == $purchasing->supplier_id)
                                    <option value="{{$supplier->id}}" selected> {{$supplier->title}} </option>
                                @endif
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select>

                            <x-input-text title="Purchase.Invoice ID" name="contract_id" id="contract_id" value="{{ $purchasing->contract_id }}" disabled  />
                            <x-input-date title="Purchase.Invoice Date" id="contract_date" name="contract_date" value="{{ $purchasing->contract_date }}"  disabled />
                            <x-input-text title="Purchase.Invice#" id="continvsno" name="continvsno" value="{{ $purchasing->purinvsno }}"  disabled />
                            <x-input-numeric title="" name="purid" id="purid" value="{{ $purchasing->id }}" hidden  />



                        </div>
                        <div class="grid grid-cols-12 gap-1 py-2 items-center">
                            <x-input-date title="G.R Date" id="purdate" name="purdate" value="{{ $purchasing->purdate }}"  />
                            {{-- <x-input-text title="G.R #" name="purseqid" id= "purseqid" value="{{ $purchasing->purseqid }}" /> --}}
                            <x-input-text title="G.R No" name="purseqid" id="purseqid" value="{{ $purchasing->purseqid }}"   />
                            {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" > --}}


                            <label for="">
                                Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                            </label>
                            <textarea name="remarks" id="remarks" cols="10" rows="2" maxlength="200"  class="col-span-2" required class="rounded">
                                {{ $purchasing->remarks }}

                            </textarea>
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

        // var e13wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcse13)
        // var gn2wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsgn2)
        // var amswt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsams)
        // var e24wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcse24)
        // var bswt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsbs)
        // var othwt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsoth)




        var sumpcs=Number(data.purpcse13)+Number(data.purpcsgn2)+Number(data.purpcsams)+Number(data.purpcse24)+Number(data.purpcsbs)+Number(data.purpcsoth)
        var sumwt=Number(data.purwte13)+Number(data.purwtgn2)+Number(data.purwtams)+Number(data.purwte24)+Number(data.purwtbs)+Number(data.purwtoth)
        var sumfeet=Number(data.purfeete13)+Number(data.purfeetgn2)+Number(data.purfeetams)+Number(data.purfeete24)+Number(data.purfeetbs)+Number(data.purfeetoth)
        // +Number(data.purpcsgn2)+Number(data.purpcsams)+Number(data.purpcse24)+Number(data.purpcsbs)+Number(data.purpcsoth)
        var row = cell.getRow();
        row.update({
            //  "purfeete13": e13ft,
            //  "purfeetgn2": gn2ft,
            //  "purfeetams": amsft,
            //  "purfeetbs": bsft,
            //  "purfeete24": e24ft,
            //  "purfeetoth": othft,

            //  "purwte13":e13wt,
            //  "purwtgn2":gn2wt,
            //  "purwtams":amswt,
            //  "purwte24":e24wt,
            //  "purwtbs":bswt,
            //  "purwtoth":othwt,


             "purpcstot":sumpcs,
             "purwttot":sumwt,
             "purfeettot":sumfeet
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
                // {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                // {title:"supplier_id",  field:"supplier_id",visible:false},
                // {title:"user_id",      field:"user_id",visible:false},
                // {title:"category_id",  field:"category_id",visible:false},
                // {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},
                {
                    title:'Contracts Data', headerHozAlign:"center",
                    columns:[
                        // {   title:"Replace Name",headerHozAlign :'center',field:"repname",responsive:0,editor:true},
                        // {   title:"Brand",headerHozAlign :'center',field:"mybrand",responsive:0,editor:true},
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"totpcs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gdswt",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                            ]},


                {title:"Replace Description",field:"repname",       editor:true},
                {title:"Brand",              field:"brand",     editor:true},
                {title:"dimension_id", field:"dimension_id",visible:false},

                // {   title:"length",headerHozAlign :'right',hozAlign:"right",cellEdited: updateValues,editor:true,responsive:0,field:"length",bottomCalc:"sum"},
                {
                    title:'E-13', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcse13",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwte13",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},

                        {title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeete13",bottomCalc:"sum",
                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},

                        ]},

                        {
                    title:'GALI NO 2', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsgn2",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                    title:'A.MALIK SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsams",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'E-24', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcse24",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwte24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeete24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'BOLTON SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsbs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                       {
                        title:'OTHERS', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",visible:false,editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsoth",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,visible:false,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",editor:true,visible:false,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'TOTAL', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcstot",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwttot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                            {   title:"Feet",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeettot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}}
                        ]},


                        // {title:"Sale Amount",
                        // headerHozAlign :'right',
                        // hozAlign:"right",
                        // field:"saleamnt",
                        // cssClass:"bg-gray-200 font-semibold",
                        // formatter:"money",
                        // cssClass:"bg-green-200 font-semibold",
                        // formatterParams:{thousand:",",precision:3},
                        // formatter:function(cell,row)
                        // {
                        //     return (cell.getData().saleqty * cell.getData().price).toFixed(0)
                        // },
                        // bottomCalc:totalVal  },





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

    var data = { 'purchasingloc' : dynamicTableData,
        'supplier_id': supplier_id.value,'contract_id':contract_id.value,'contract_date':contract_date.value,'purseqid':purseqid.value,
                          'purdate':purdate.value,'continvsno':continvsno.value,'purid':purid.value,'remarks':remarks.value      };





    fetch(@json(route('purchasingloc.update',$purchasing)),{
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
            window.open(window.location.origin + "/purchasingloc","_self" );
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


    function EnableDisableTextBox(per) {
        var purseqid = document.getElementById("purseqid");
        purseqid.disabled = per.checked ? false : true;
        purseqid.style.color ="black";
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



