<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Received Voucher
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm  sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-1 py-1">

                    {{-- <div class="grid"> --}}

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            {{-- <div class="grid grid-cols-12 gap-2 py-2 items-center"> --}}
                                <div class=" grid grid-cols-8   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full    ">

                                    <x-input-date  title="Date" name="documentdate" class="col-span-1 w-auto" />
                                    <x-input-text tabindex="-1" title="Payment Ref.#" name="transno" id="transno" value="{{$maxposeqno}}"  class="col-span-1"    />
                                    <x-input-text title="G.D No" name="impgdno" id="impgdno" disabled  class="col-span-1"  />

                                    <label for="per" class="gap-6">
                                        Invoice Level <span class="text-red-500 font-semibold   "></span>
                                        </label>
                                    <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-right  "   type="checkbox" name="per" id="per" checked=true onclick="EnableDisableTextBox(this)" >

                                    <label for="head_id">Main Head</label>
                                            <select autocomplete="on"  name="head_id" id="head_id" style="text-align:left" class="col-span-3" >
                                                @foreach($heads as $head)
                                                <option value="{{$head->id}}"> {{$head->title}} </option>
                                                @endforeach
                                            </select>

                                       <label for="autocompleted1">Sub Head</label>
                                       <div class=" relative col-span-3 "   onclick="event.stopImmediatePropagation();" >
                                        <input type="text" id="autocompleted1" size=48
                                        onkeyup="onkeyUp1(event)" />
                                        <div>
                                            <select  id="supplier_id" name="supplier_id" size="20"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            </select>
                                        </div>
                                    </div>

                                    <label for="autocompleted"   >Cash/Bank</label>
                                    <div class="relative col-span-3 "   onclick="event.stopImmediatePropagation();" >
                                        <input type="text"  id="autocompleted" size=48
                                        onkeyup="onkeyUp(event)" />
                                            <div>
                                                <select  id="bank_id" name="bank_id" size="20"  class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </select>
                                            </div>
                                    </div>

                                    <x-input-text title="Cheque No" name="cheque_no" id="cheque_no"   class="col-span-1 "  disabled  />
                                    <x-input-date title="Cheque Date" id="cheque_date" name="cheque_date"  class="col-span-1"  />
                                    <x-input-text title="Received From" name="pmntto" id="pmntto"  class="col-span-1"   />

                                    <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" onkeyup="chngpkr(event)" class="col-span-1"      />
                                    <x-input-numeric title="Exc. Rate" name="conversion_rate" id="conversion_rate" value="1"  onkeyup="chngpkr(event)"  class="col-span-1" disabled   />
                                    <x-input-numeric title="Amount(PKR)" name="amount_pkr" id="amount_pkr" class="col-span-1" disabled />

                                    <label for="">
                                        Description <span class="text-red-500 font-semibold  "></span>
                                        </label>
                                    <textarea name="description" id="description" cols="150" rows="3" maxlength="150" class="col-span-3 rounded" ></textarea>
                                    <x-input-text title="Cheque Amount" name="chqamount" id="chqamount" disabled  class="col-span-1"    />
                                    <x-input-text tabindex="-1" title="Supp.Inv.No" name="supinvid" id="supinvid" class="col-span-1 " value=0        />


                                    {{-- <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-left "  type="checkbox" name="invid" id="invid" onclick="enbldspl(this)" > --}}



                                    {{-- <x-input-text tabindex="-1" title="Cust.DC No" name="cusinvid" id="cusinvid" class="col-span-1" value=0  disabled     /> --}}
                                    {{-- <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-left "  type="checkbox"  name="invid" id="invid" onclick="enbldspl(this)" > --}}

                                </div>















                                {{-- <label for="head_id" style="text-align:right ">Main Head</label>
                                <select  autocomplete="on"  name="head_id" id="head_id"  style="text-align: left"  >
                                        @foreach($heads as $head)
                                        <option value="{{$head->id}}"> {{$head->title}} </option>
                                        @endforeach
                                    </select>

                                    <label for="autocompleted1">Sub Head</label>
                                    <div class=" relative "   onclick="event.stopImmediatePropagation();" >
                                     <input type="text" id="autocompleted1" size=20
                                     onkeyup="onkeyUp1(event)" />
                                     <div>
                                         <select  id="supplier_id" name="supplier_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-auto h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                         </select>
                                     </div>
                                 </div>

                                 <x-input-date title="Date" name="documentdate"  />
                                 <x-input-text tabindex="-1" title="Seq.#" name="transno" id="transno" value="{{$maxposeqno}}"      />

                                <label for="autocompleted"   >Bank </label>
                                <div class="relative"   onclick="event.stopImmediatePropagation();" >
                                    <input type="text"  id="autocompleted"
                                    onkeyup="onkeyUp(event)" />
                                        <div>
                                            <select  id="bank_id" name="bank_id" size="20"  class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            </select>
                                        </div>
                                </div>

                                <x-input-text title="Chq.No" name="cheque_no" id="cheque_no"  class="col-span-1" disabled />
                                <x-input-date title="Chq.Date" id="cheque_date" name="cheque_date"  class="col-span-1" disabled />
                                <x-input-text title="Chq.Amount" name="chqamount" id="chqamount" disabled  class="col-span-1"    />
                                <x-input-text title="Received From" name="pmntto" id="pmntto"  class="col-span-1"   />
                                <x-input-numeric title="Amount(USD)" name="amount_fc" id="amount_fc" onkeyup="chngpkr(event)"  class="col-span-1"      />
                                <x-input-numeric tabindex="-1" title="conversion_rate" name="conversion_rate" id="conversion_rate" onkeyup="chngpkr(event)"  class="col-span-1" value=1      />
                                <x-input-numeric title="Amount(PKR)" name="amount_pkr" id="amount_pkr" class="col-span-1" disabled    />

                                <x-input-text title="Supp.Inv.No" name="supinvid" id="supinvid" class="col-span-1  "   disabled     />
                                <input tabindex="-1" class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none mt-2 float-left "  type="checkbox" name="invid" id="invid" onclick="enbldspl(this)" >
                                <label for="">
                                    Description <span class="text-red-500 font-semibold  "></span>
                                    </label>
                                <textarea name="description" id="description" cols="100" rows="1" maxlength="100"  required class="col-span-4" ></textarea>
                                <label for="">
                            </div> --}}

                        <div>
                            <x-input-text  title="" name="subhdid" id="subhdid"   hidden     />
                            <x-input-text  title="" name="hdid" id="hdid"  hidden     />
                            <x-input-text  title="" name="shname" id="shname" hidden     />
                            <x-input-numeric title="" name="advtxt" id="advtxt" value="0" hidden       />
                            <x-input-text title="" name="chqno" id="chqno" class="col-span-2"  hidden    />
                            <x-input-numeric title="" name="prvscrdtamt" id="prvscrdtamt" class="col-span-1" hidden disabled     />
                            <x-input-numeric title="" name="prvsinvsamt" id="prvsinvsamt" class="col-span-1" hidden disabled     />
                            {{-- Prvs. Credit Amount --}}
                            {{-- Prvs. Invs.Clrd Amount --}}

                        </div>

                    </fieldset>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                               <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                               <label for="">
                                Description <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                            <textarea name="description" id="description" cols="50" rows="2" maxlength="150" required class="rounded"></textarea>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
                            </div>
                        </fieldset> --}}

                        {{-- <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>

                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" title="W/Qutation" type="checkbox" value="checked" name="woq" id="woq"   >
                        </div> --}}



                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" type="button" onclick="validateForm()">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                        </div>

                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Contracts" />

@push('scripts')
    <script>

window.onload = function() {
            var input = document.getElementById("documentdate").focus();
        }

        let list;
        const headlist = @json(route('banktransactionr.headlist'));
        const head = document.getElementById('head_id')
        const value = head.value
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


        var getMaster = @json(route('banktransactionr.quotations')) ;
        var getDetails = @json(route('banktransactionr.quotationsdtl'));

         let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        // let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        // let head_id = '';
        // let supplier_id = '';


        // let prno= document.getElementById("prno")
        document.addEventListener('DOMContentLoaded',()=>{
            filldrplst();
            hidedropdown();
            hidedropdown1();

        })
        // Add event handler to read keyboard key up event & conversionrate
        // document.addEventListener('keyup', (e)=>{

        //     if(e.ctrlKey && e.keyCode == 500){
        //         if(!adopted)
        //         {
        //                 showModal()
        //         }
        //     }
        // })
    </script>
@endpush

@push('scripts')
    <script>



        // window.onload = function() {
        //     var input = document.getElementById("pono.focus").focus();
        // }

        // -----------------FOR MODAL -------------------------------//
        // function showModal()
        // {
        //     modal.style.display = "block"
        //     const inp = document.getElementById('data_filter')
        //     inp.focus()
        // }
        // function closeModal(){ modal.style.display = "none"}
        //  When the user clicks anywhere outside of the modal, close it
        // window.onclick = function(event) {
        //     if (event.target == modal) {
        //         modal.style.display = "none";
        //     }
        // }
        //  Table Filter
        // function dataFilter(element)
        // {
        //     searchValue = element.value;
        //     table.setData(getMaster,{search:searchValue});
        // }
        //  The Table for Materials Modal
        table = new Tabulator("#tableData", {
            width:"1000px",
            height:"600px",
            autoResize:true,
            responsiveLayout:"collapse",
            // layout:"fitData",
            layout:'fitDataTable',

            index:"id",
            placeholder:"No Data Available",
            pagination:true,
            paginationMode:"remote",
            sortMode:"remote",
            filterMode:"remote",
            paginationSize:25,
            paginationSizeSelector:[10,25,50,100],
            ajaxParams: function(){
                return {search:searchValue};
            },
            ajaxURL: getMaster,
            ajaxContentType:"json",
            initialSort:[ {column:"custname", dir:"asc"} ],

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"", field:"mheadid" , responsive:0,visible:false},
                {title:"Master Head", field:"mhead" , responsive:0},
                {title:"Sub Head", field:"custname" , visible:true ,headerSort:false, responsive:0},
                {title:"Cheque No", field:"cheque_no" , visible:true ,headerSort:false, responsive:0},
                {title:"Cheque Date", field:"cheque_date" , visible:true ,headerSort:false, responsive:0},
                // {title:"Quotation Values", field:"totrcvbamount", visible:true ,headerSort:false, responsive:0},
                // {title:"Valid Date", field:"dvaldate" , responsive:0},


           ],
        // },
            // Extra Pagination Data for End Users
            ajaxResponse:function(getDataUrl, params, response){
                remaining = response.total;
                let doc = document.getElementById("example-table-info");
                doc.classList.add('font-weight-bold');
                doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
                return response;
            }
        })
        //  Adds New row to dynamicTable
        table.on('rowClick',function(e,row){
            var simple = {...row}
            var data = simple._row.data

            // Fill Master Data
             supplier_id=data.id
             head_id = data.head_id
             custname.value=data.custname
             cheque_no.value=data.cheque_no

             cheque_date.value= data.cheque_date

             prvscrdtamt.value=data.crdtcust
             prvsinvsamt.value=data.invsclrd
             amount_fc.value=data.received
             conversion_rate.value=1
             amount_pkr.value=data.received
             chqamount.value=data.received
             chqno.value=data.cheque_no



            //  amount_pkr.value=data.AdvanceAmount
            // if (data.head_id==33)
             detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
         //   calculateButton.disabled = false
            closeModal()
        })


supplier_id.addEventListener("click", () => {

let supplier_id= document.getElementById("supplier_id");
let input1= document.getElementById("autocompleted1");
let subhdid= document.getElementById("subhdid");
let hdid= document.getElementById("hdid");
let shname= document.getElementById("shname");
let cheque_date= document.getElementById("cheque_date");
let cheque_no= document.getElementById("cheque_no");
let chqno= document.getElementById("chqno");
let chqamount= document.getElementById("chqamount");

dynamicTable.setData();
// $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id }  ];

subhdid.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].shid;

// hdid.value=$mnhdid;

// shname.value= supplier_id.options[supplier_id.selectedIndex].text;

shname.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].subhdname;
hdid.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].mnhdid;
cheque_no.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqno;
chqno.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqno;
cheque_date.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].chqdt;
chqamount.value=$mychqno[supplier_id.options[supplier_id.selectedIndex].value][0].mychqamount;
input1.value=supplier_id.options[supplier_id.selectedIndex].text;

hidedropdown1();

// detailsUrl = `${getDetails}/?id=${supplier_id.options[supplier_id.selectedIndex].value}`

if(hdid.value==33)
{
    detailsUrl = `${getDetails}/?id=${subhdid.value}`
    fetchDataFromServer(detailsUrl)
}
    adopted = true

});








</script>
@endpush

@push('scripts')
    <script>

        //  ------------------Dynamic Table----------------------//
        async function fetchDataFromServer(url)
        {
            var data =  await fetch(url,{
                method:"GET",
                headers: { 'Accept':'application/json','Content-type':'application/json'},
                })
                .then((response) => response.json()) //Transform data to json
                .then(function(response){
                    // console.log(response);
                    return response;
                })
                .catch(function(error){
                    console.log("Error : " + error);
            })
            //  Stremaline Data for Tabulator
            for (let index = 0; index < data.length; index++) {

                const obj = data[index];
                const mat = obj['material']
                var vpcs = obj.totpcs
                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {


                        pono :        obj.pono,
                        invoice_id :  obj.invoice_id,
                        billno :      obj.billno,
                        saldate :     obj.saldate,
                        saldated :     obj.saldated,
                        dcno :        obj.dcno,
                        dcamount:     obj.dcamount,
                        staxper:      obj.staxper,
                        staxamount:   obj.staxamount,
                        totrcvble:    obj.totrcvble,
                        totrcvd :     obj.totrcvd,
                        cartage :     obj.cartage,
                        invoice_bal:  obj.invoice_bal,
                        saleretamount:obj.saleretamount,

                    }
                ])
            }
        }



        //  Dynamic Table [User data]


        var rowMenu = [
    {
        label:"<i class='fas fa-user'></i> Change Name",
        action:function(e, row){
            row.update({name:"Steve Bobberson"});
        }
    },
    {
        label:"<i class='fas fa-check-square'></i> Select Row",
        action:function(e, row){
            row.select();
        }
    },
    {
        separator:true,
    },
    {
        label:"Admin Functions",
        menu:[
            {
                label:"<i class='fas fa-trash'></i> Delete Row",
                action:function(e, row){
                    row.delete();
                }
            },
            {
                label:"<i class='fas fa-ban'></i> Disabled Option",
                disabled:true,
            },
        ]
    }
]

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

var tamount=0;
    function tnetamount()
        {

            amount_fc.value= (prvsinvsamt.value - prvscrdtamt.value) + tamount
            amount_pkr.value= (prvsinvsamt.value - prvscrdtamt.value) + tamount
        }

var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.totrcvd) )
        var invbal = (Number(data.totrcvble) - Number(data.totrcvd))
        // var varqty = ( Number(data.balqty) - Number(data.saleqty) )
        var row = cell.getRow();
        row.update({
            //  "payedrup": sum,
             "invoice_bal":invbal,
             totalVal1: sum

        });
    }

    var totalVal = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        // tamount = calc;
        tnetamount();
        return calc;

    }


    var totalVal1 = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        tamount = calc;
        tnetamount();
        return calc;

    }


        dynamicTable = new Tabulator("#dynamicTable", {
            height:"200px",
            width:"1000px",
            rowContextMenu: rowMenu,
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            // movableRows:true,
            // groupBy:"material_title",
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"S.No",            field:"sno", formatter:"rownum",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"invoice Id",           field:"invoice_id",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"P.O No",           field:"pono",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Delivery Date",     field:"saldated",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"",     field:"saldate",responsive:0,visible:false},
                {title:"DC No",     field:"dcno",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Bill No",    field:"billno",responsive:0,cssClass:"bg-gray-200 font-semibold"},



                // {title:"Variance", field:"varqty",cellEdited: updateValues,},

                {
                    title:'Receivable Amount', headerHozAlign:"center",
                    columns:[

                        {   title:"Sale Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"dcamount",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Sale Tax(%)",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"staxper",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Sale Tax Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"staxamount",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Cartage",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"cartage",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Sale Return",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"saleretamount",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },



                        {   title:"Total Receivable Amount",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"totrcvble",
                            // editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                    ]},

                {
                        title:'Amount Received', headerHozAlign:"center",
                    columns:[


                        {title:"Received Amount.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        editor:"number",
                        field:"totrcvd",
                        formatter:"money",
                        responsive:0,
                        cellEdited: updateValues,
                        formatterParams:{thousand:",",precision:1},
                        // formatter:function(cell,row)
                        // {
                        //     return (cell.getData().payedusd * cell.getData().convrate).toFixed(0)
                        // },
                        bottomCalc:totalVal1  },
                    ]},

                    {title:"Invoice Balance.",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"invoice_bal",
                        formatter:"money",
                        cssClass:"bg-gray-200 font-semibold",
                        responsive:0,
                        formatterParams:{thousand:",",precision:1},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().totrcvble - cell.getData().totrcvd).toFixed(0)
                        },
                        bottomCalc:totalVal

                    },





            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {


            var sid = document.getElementById("bank_id");
            var bank_id = sid.options[sid.selectedIndex];
            var transno = document.getElementById("transno")

            var sid1 = document.getElementById("supplier_id");
            var supplier_id = sid1.options[sid1.selectedIndex];



            // var per= document.getElementById("per");

            //  console.log(bank_id);

            if(bank_id==undefined || supplier_id==undefined    )
            {
                showSnackbar("Bank/SubHead Required","error");
                bank_id.focus();
                return;
            }


            if ( chqno.value !== '' &&  chqno.value == cheque_no.value && chqamount.value !== amount_pkr.value )

            {

            // if( chqamount.value <> amount_pkr.value)

                    // {
                            showSnackbar("Invalid Cheque Amont ","error");
                            amount_fc.value=chqamount.value;
                            amount_fc.focus();
                            return;


                        // }

            }





            const dynamicTableData = dynamicTable.getData();
            // if(dynamicTableData.length == 0)
            // {
            //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
            //     return;
            // }

            // for (let index = 0; index < dynamicTableData.length; index++) {
            //     const element = dynamicTableData[index];

            //     if(element.location === undefined)
            //     {
            //         showSnackbar("Location must be Enter","info");
            //         return;
            //     }
            // }


            var shouldDelete = confirm('Do you really want to save this Record?');
            if (shouldDelete) {
                                // alert("Record Save Successfully");
                              }
            else
            {
                return;
            }





            var data = { 'banktransactionr' : dynamicTableData,'supplier_id':supplier_id,'transno':transno.value,'bank_id':bank_id.value,'documentdate':documentdate.value,
            'cheque_no':cheque_no.value,'cheque_date':cheque_date.value,'head_id':head_id ,'description': description.value,'transno':transno.value
        ,'amount_fc':amount_fc.value,'amount_pkr':amount_pkr.value,'conversion_rate':conversion_rate.value,'advtxt':advtxt.value,
        'supinvid':supinvid.value,'pmntto':pmntto.value,'subhdid':subhdid.value,'hdid':hdid.value,'shname':shname.value};

            // All Ok - Proceed
            fetch(@json(route('banktransactionr.store')),{
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
                    // window.open(window.location.origin + "/banktransactionr","_self" );

                //   alert("Record Save Successfully")
                   clearform();
                   newsno();
                   dynamicTable.setData();
                   var input = document.getElementById("documentdate").focus();
                }

                else
                {
                    alert("Invalid Data")

                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

        function EnableDisableTextBox(per) {
        var amount_fc = document.getElementById("amount_fc");
        amount_fc.disabled = per.checked ? false : true;
        amount_fc.style.color ="black";
        // amount_fc.value =0;


        var conversion_rate = document.getElementById("conversion_rate");
        conversion_rate.disabled = per.checked ? false : true;
        conversion_rate.style.color ="black";
        // amount_pkr.value =0;
        conversion_rate.value =1;


    }


    function enbldspl(invid) {
        var supinvid = document.getElementById("supinvid");
        supinvid.disabled = invid.checked ? false : true;
        supinvid.style.color ="black";
        supinvid.value ='';

    }


    bank_id.addEventListener("change", () => {
    var sid = document.getElementById("bank_id");
        var bank_id = sid.options[sid.selectedIndex];
        // var cheque_no = document.getElementById("cheque_no");
        if(bank_id.value==1)
        {
        cheque_no.disabled=true;
          cheque_date.disabled=true;
        //   document.getElementById('cheque_no').style.color = 'green';
        //   document.getElementById('cheque_date').style.color = 'green';

        //   cheque_no.style.color ="black";
        //   cheque_date.style.color ="black";
        }
        else
        {
          cheque_no.disabled=false;
          cheque_date.disabled=false;
          cheque_no.value='';
          document.getElementById('cheque_no').style.color = 'black';
          document.getElementById('cheque_date').style.color = 'black';
          //   cheque_no.style.color ="black";
        //   cheque_date.style.color ="black";
        }

});







//     amount_fc.onblur=function(){
//     amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
//     // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
//    }

//    conversion_rate.onblur=function(){
//     amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);
//     // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
//    }

   function chngpkr()
   {

    amount_pkr.value=(amount_fc.value * conversion_rate.value).toFixed(0);

   }



//    function updateInput(amount_pkr){

//     // document.getElementById("fieldname").value = ish;
//     document.getElementById("amount_pkr").value=(amount_fc.value * conversion_rate.value).toFixed(0);
// }






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
    var bank_id = document.getElementById("bank_id");
    bank_id.classList.remove("hidden");

    let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));
    console.log(filteredContries);
    renderOptions(filteredContries);

}


// document.addEventListener('DOMContentLoaded',()=> {
//     hidedropdown();
//         });

function renderOptions(xyz){

    let dropdownEl=document.getElementById("bank_id");

                dropdownEl.length = 0
                xyz.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.title)
                });
}
// +' ' + e.cheque_no
document.addEventListener("click" , () => {
    hidedropdown();
});


function hidedropdown()
{
    var bank_id = document.getElementById("bank_id");
    bank_id.classList.add("hidden");
}


bank_id.addEventListener("click", () => {

    let bank_id= document.getElementById("bank_id");
    let input= document.getElementById("autocompleted");
    input.value=bank_id.options[bank_id.selectedIndex].text;
    hidedropdown();
});


bank_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
event.preventDefault();

let bank_id= document.getElementById("bank_id");
    let input= document.getElementById("autocompleted");
    input.value=bank_id.options[bank_id.selectedIndex].text;
    hidedropdown();

}
});


// ********* search list for suppliers

list=@json($resultArray1);
// const contries1 = myarray1;
function onkeyUp1(e)
{
    let keyword= e.target.value;
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.remove("hidden");

    let filteredContries=list.filter((c)=>c.custname.toLowerCase().includes(keyword.toLowerCase()));
    // console.log($mychqno);
    renderOptions1(filteredContries);

}


var mychqno=[] ;
function renderOptions1(sup){

    let dropdownEl=document.getElementById("supplier_id");


                 $mychqno=[];
                //  $mnhdid=[];
                dropdownEl.length = 0
                // a=0;
                sup.forEach( e =>  {
                    addSelectElement(dropdownEl,e.id,e.custname )
                    // a=a+1;
                    // $shid =e.id;
                    // $mnhdid =e.head_id;
                    // $mychqdt =e.cheque_date;
                     $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id,subhdname:e.dspcustname }  ];

                    });


}

document.addEventListener("click" , () => {
    hidedropdown();
    hidedropdown1();
});


function hidedropdown1()
{
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.add("hidden");
}




supplier_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
// event.preventDefault();
supplier_id.click();

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

head_id.addEventListener("change", () => {
    filldrplst();
    // const value = head.value
    //     autocompleted1.value='';
    //     supplier_id.options.length = 0 // Reset List
    //     fetch(headlist + `?head_id=${value} `,{
    //                 method:"GET",
    //                 headers: { 'Accept':'application/json','Content-type':'application/json'},
    //                 })
    //                 .then(response => response.json())
    //                 .then( data => {
    //                     if(data.length > 0)
    //                     {

    //                         let a = 0;

    //                         $mychqno=[];
    //                         list=data;
    //                         list.forEach(e => {
    //                             a += 1;
    //                             addSelectElement(supplier_id,e.id,e.custname )
    //                             $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id,subhdname:e.custname }  ];
    //                         });
    //                     }else{
    //                     }
    //                 })
    //                 .catch(error => console.error(error))
                // break;


});

function clearform()
{

    document.getElementById("autocompleted1").value="";
    document.getElementById("hdid").value=0;
    // document.getElementById("subhdid").value=0;
    document.getElementById("shname").value="";
    // document.getElementById("autocompleted").value='';
    document.getElementById("cheque_no").value='';
    document.getElementById("pmntto").value='';

    document.getElementById("amount_fc").value=0;
    document.getElementById("conversion_rate").value=1;
    document.getElementById("amount_pkr").value=0;
    document.getElementById("description").value='';
    // document.getElementById("impgdno").value='';
    document.getElementById("supinvid").value=0;
// document.getElementById("transno").value=document.getElementById("transno").value + 1;

// var shname = document.getElementById("shname");
// shname.value="";


}


const mseqno = @json(route('banktransactionr.mseqno'));

function newsno()
{

    const transno = document.getElementById('transno');
    fetch(mseqno ,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {
                            transno.value=data;
                        }else{
                            transno.value=data;
                            // console.log(data);
                            // subhead.removeAttribute('required','')
                            // subhead.setAttribute('disabled','')
                        }
                    })
                    .catch(error => console.error(error))

}

// const chqvalid = @json(route('banktransactionr.chqvalid'));

// function chqvld()
// {


//     fetch(chqvalid ,{
//                     method:"GET",
//                     headers: { 'Accept':'application/json','Content-type':'application/json'},
//                     })
//                     .then(response => response.json())
//                     .then( data => {
//                         if(data.length > 0)
//                         {
//                             console.log(data);
//                         }else{
//                             console.log(data);
//                             // console.log(data);
//                             // subhead.removeAttribute('required','')
//                             // subhead.setAttribute('disabled','')
//                         }
//                     })
//                     .catch(error => console.error(error))

// }



function filldrplst()
{
    const value = head.value
        autocompleted1.value='';
        supplier_id.options.length = 0 // Reset List
        fetch(headlist + `?head_id=${value} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;

                            $mychqno=[];
                            list=data;
                            list.forEach(e => {
                                a += 1;
                                addSelectElement(supplier_id,e.id,e.custname )
                                $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,shid:e.subheadid,mnhdid:e.head_id,subhdname:e.dspcustname }  ];
                            });
                        }else{
                        }
                    })
                    .catch(error => console.error(error))

}






    </script>
@endpush

</x-app-layout>
