<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Journal Voucher
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-1">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >

                    {{-- Form Data --}}
                    <div class="flex">
                        <form action="{{ route('jv.store') }}" method="post" >
                        @csrf
                        {{-- <fieldset class="max-w-7xl border px-4 py-2 gap-4 rounded"> --}}
                            {{-- <legend>Transaction Date</legend> --}}
                            {{-- <x-input-date title="Dcoument Date" name="document_date" req required/>
                            <x-input-text title="Dcoument No" name="document_no" value="{{$maxjvno}}"/>

                             <label for="j vtype">J.V Type</label>
                              <select  autocomplete="on" class="col-span-2" name="jvtype" id="jvtype"  >
                                <option value="1">Debit</option>
                                <option value="2">Credit</option>
                              </select> --}}

                        {{-- </fieldset> --}}

                        <fieldset class="max-w-7xl border px-4 py-2 gap-4 rounded">
                            <legend>Transaction Date</legend>
                            <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" req required class="col-span-2" disabled  />
                            <x-input-text title="Cheque Amount" name="cheque_amt" id="cheque_amt" req required class="col-span-2" disabled  />

                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                            <label for="">
                                <span style="color: brown;font-weight: bold"> J.V Against Cheque Collection </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                 </label>
                        </fieldset>


                        <fieldset class="max-w-7xl border px-1 py-1 gap-1 rounded">

                            <div class="grid grid-cols-12 gap-2 py-1 items-center">
                                <x-input-date title="Dcoument Date" class="col-span-2" name="document_date" req required/>
                                <x-input-text tabindex="-1" title="Dcoument No" class="col-span-2" name="document_no" value="{{$maxjvno}}"/>

                                <label for="j vtype">J.V Type</label>
                                <select  autocomplete="on" class="col-span-2"  name="jvtype" id="jvtype"  >
                                    <option value="1">DEBIT</option>
                                    <option value="2">CREDIT</option>
                                </select>
                            </div>



                            <div class="grid grid-cols-12 gap-2 py-1 items-center">
                                <label for="head_id">Main Head<x-req /></label>
                                        <select autocomplete="on" class="col-span-2" name="head_id" id="head_id" >
                                            {{-- <option value="" selected>--Payment Head</option> --}}
                                            @foreach($heads as $head)
                                            <option value="{{$head->id}}"> {{$head->title}} </option>
                                            @endforeach
                                        </select>

                                <div class="w-96 relative grid grid-cols-4 gap-1 px-10 py-5  "   onclick="event.stopImmediatePropagation();" >
                                    {{-- <label for="autocompleted1">Sub Head<x-req /></label> --}}
                                    <input id="autocompleted1" title="Head Name" placeholder="Select Sub Head Name" class=" px-5 py-3 w-auto border border-gray-400 rounded-md"
                                    onkeyup="onkeyUp1(event)" />
                                    <div>
                                        <select  id="supplier_id" name="supplier_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </select>
                                    </div>
                                </div>
                                </div>
                                <div class="grid grid-cols-12 gap-2 py-1 items-center">
                                <x-input-numeric title="Amount" name="amount" id="amount"  class="col-span-2"      />
                                <x-input-text title="Description" name="mdescription" id="mdescription" class="col-span-2" />
                                <x-button   id="arw" class="mx-2" type="button" onclick="addgrdrw()">Add Row</x-button>
                                <x-input-text title="" name="chqtext" id="chqtext" value=0  hidden  />
                            </div>
                            </fieldset>


                        {{-- Dynamic Tabulator --}}
                        <x-tabulator-dynamic />

                        <div class="pt-2">
                            <x-button id="submitButton" type="button" disabled onclick="submitData()">
                                Submit
                            </x-button>
                            {{-- <label>Over/Under</label> --}}
                            {{-- <x-input id="balance" type="number" disabled/> --}}
                        </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

@push('scripts')
<script>


let list;
const headlistp = @json(route('jv.headlistp'));
const head = document.getElementById('head_id')
const value = head.value

let dyanmicTable = ""; // Tabulator
    let dynamicTableData = [];



    const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    const heads = @json($heads);
    const subheads = @json($subheads);
    console.info(subheads)
    const headsList = []    //  To get Value / Label Objects
    const subheadsList = []    //  To get Value / Label Objects
    const submitButton = document.getElementById('submitButton')

    document.addEventListener('DOMContentLoaded', () => {
        heads.forEach(e => {headsList.push({value:e.title, label:e.title})})
        var document_date = document.getElementById("document_date").focus();
        hidedropdown1();
        filldrplst();
   })
    document.addEventListener('keyup', (e)=>{
        if(e.ctrlKey && e.keyCode == 500){
            addRow()
        }
    })
    const addRow = () => {
        dynamicTable.addRow({})
        dataSet = dynamicTable.getData()
        dynamicTable.redraw()
        submitButton.removeAttribute('disabled')
    }


    var updateValues = (cell) => {
        var data = cell.getData();
        var ctamount =  Number(data.debitamt) + Number(data.creditamt)
        var row = cell.getRow();
        row.update({
            "tamount": ctamount

        });
    }


    //  Dynamic Table [User data]
    dynamicTable = new Tabulator("#dynamicTable", {
        width:"1000px",
        height:"300px",
        layout:'fitDataTable',
        responsiveLayout:"collapse",
        reactiveData:true,
        columns:[
            {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    cell.getRow().delete();
                    const rowCount = dynamicTable.getDataCount()
                    if(rowCount <=0 ) { submitButton.setAttribute('disabled','') }
                }
            },
            // {title:'Type',field:'transaction_type',editor:"list",validator:['required'],editorParams:{ values:['DEBIT','CREDIT']}, width:70 , responsive:0} ,
            // {title:"Head",  field:"head_title",headerSort: false, width:200,validator:['required'],editor:"list", responsive:0,  editorParams:{
            //         values: headsList,
            //     },
            //     cellEdited:function(cell){
            //         const head_title = cell.getData().head_title
            //         const subs = subheads.filter( s => s.mtitle === head_title)
            //         console.info(subs)
            //         subheadsList.length = 0
            //         subheadsList.push({value:'-->select',label:'-->select'})
            //         //  Setup Heads
            //         subs.forEach(e => {
            //             subheadsList.push({value:e.title, label:e.title})
            //         })
            //         // grdummary();
            //    }
            // },
            // {title:"Subhead", width:150, field:"subhead_title",headerSort: false, editor:"list", responsive:0,validator:['required'], editorParams:{
            //     values: subheadsList
            // }},

            {title:"Transaction Type", field:"ttype",id:"ttype",headerSort: false, responsive:0,width:"100"},
            {title:"Main Head", field:"mhead",headerSort: false, responsive:0,width:"200"},
            {title:"Sub Head", field:"shead",headerSort: false, responsive:0,width:"400"},

            {title:"Main Head id", field:"mheadid",headerSort: false, responsive:0,width:"50",visible:false},
            {title:"Sub Head id", field:"sheadid",headerSort: false, responsive:0,width:"50",visible:false},


            {title:"Debit", field:"debitamt",headerSort: false, editor:"number", responsive:0,width:"100",cellEdited: updateValues,
            validator:['required','numeric'],bottomCalc:"sum"},
            {title:"Credit", field:"creditamt",headerSort: false, editor:"number", responsive:0,width:"100",cellEdited: updateValues,
            validator:['required','numeric'],bottomCalc:"sum"},
            {title:"tamount", field:"tamount",headerSort: false, editor:"number", responsive:0,visible:false,validator:['required','numeric'],bottomCalc:"sum"},
            {title:"Description", width:300, field:"description",headerSort: false, responsive:0,validator:['required'],  editor:"input"},
        ],
    })
    // dynamicTable.on("cellEdited", (cell) => {
    //     //data - all data loaded into the table
    //     console.info('cell is editing')
    //     const name = cell.getData()
    //     console.info(name)
    //     const row = cell.getRow()
    //     const subs = subheads.filter( s => s.head_id === name)
    //     subheadsList.length = 0
    //      //  Setup Heads
    //     subs.forEach(e => {
    //         // console.info(e)
    //         subheadsList.push({'value':e.id, 'label':e.id + " " + e.title})
    //     })
    //     console.info(subheadsList)
    // });

    // const grdummary = () =>{
    //     const data = dynamicTable.getData()
    //     //  Filter -->select data
    //     data.forEach(e => {
    //         if(e.transaction_type === 'DEBIT')
    //         { vdbamt+=e.amount }
    //         if(e.transaction_type === 'CREDIT')
    //         {  vcdamt+=e.amount  }
    //     })

    //     document.getElementById('cdtamt').value =  vcdamt
    //     document.getElementById('dbtamt').value = vdbamt


    // }


    const submitData = () =>{
        const rowCount = dynamicTable.getDataCount()
        if(rowCount < 2 ) { alert('Atleast 2 rows for Credit/Debit required'); return }
        //  Validate dynamicTable - It only works, if cells are marked with validation
        var resp = dynamicTable.validate()
        if(resp != true)
        {
            alert('validation erros')
            return
        }

        const data = dynamicTable.getData()
        //  Filter -->select data
        // const filtered = data.filter(f => f.subhead_id === '-->select')
        // console.log(filtered);
        // if(filtered.length>0){ alert('Select proper subhead'); return}
        //  Calculate and check if Debit/Credit is 0
        let valid = 0;
        let vdbamt=0;
        let vcdamt=0;
        // let crdtto='';
         data.forEach(e => {
            // if(e.ttype === 'DEBIT')
            // { valid -= Number(e.tamount)
            // }
            // if(e.ttype === 'CREDIT')
            // { valid += Number(e.tamount)
            // }
            vdbamt+=Number(e.debitamt)
            valid+=Number(e.debitamt)-Number(e.creditamt)
        })

        console.log(vdbamt);
        // document.getElementById('cdtamt').value =  vcdamt
        // document.getElementById('dbtamt').value = vdbamt

        // document.getElementById('balance').value =valid

        // console.log(vcdamt);
        if(valid != 0) { alert('Debit/Credit should be settled before procedding'); return }
        //  Correct Data

        if(per.checked==true)
        {

            if(vdbamt != cheque_amt.value) { alert('Cheque Amount must be Equal to JV Amount'); return }

        }



        data.forEach(e => {
            // var head = e.head_id
            // var dHead = heads.filter(h => h.title === head)
            // e.head_id = dHead[0].id
            // var subhead = e.subhead_id
            // var sHead = subheads.filter(h => h.title === subhead)
            // e.subhead_id = sHead[0].id
            var mhead=e.mhead
            var shead=e.shead
            var mheadid=e.mheadid
            var subheadid=e.sheadid
            var ttype=e.ttype
            var tamount=e.tamount
            var description=e.description

        })
        //  Now Post Data
        var mydata = {
            'document_date': document.getElementById('document_date').value,
            'document_no': document.getElementById('document_no').value,
            'cheque_no': document.getElementById('cheque_no').value,
            // 'dbtamt': document.getElementById('dbtamt').value,
            // 'cdtamt': document.getElementById('cdtamt').value,
            'voucher': data
        }
        fetch(@json(route('jv.store')),{
            credentials: 'same-origin', // 'include', default: 'omit'
            method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
            // body: formData, // Coordinate the body type with 'Content-Type'
            body:JSON.stringify(mydata),
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
                // window.open(window.location.origin + "/jv","_self" );

                alert("Record Saved Successfully")
                document.getElementById("autocompleted1").value="";
                document.getElementById("cheque_no").value="";
                document.getElementById("cheque_amt").value=0;
                document.getElementById("chqtext").value=0;
                document.getElementById("amount").value=0;
                document.getElementById("mdescription").value='';
                dynamicTable.setData();
                var input = document.getElementById("jvtype").focus();

            }
        })
        .catch(error => {
            showSnackbar("Errors occured","red");
        })
    }

    function EnableDisableTextBox(per) {
        var cheque_no = document.getElementById("cheque_no");
        // cheque_no.disabled = per.checked ? false : true;
        // cheque_no.style.color ="black";

        // newchqno();

        if(per.checked==true)
        {
            chqtext.value=1;


        }
        else
        {
            chqtext.value=0;
            cheque_no.value="";
            cheque_amt.value=0;
        }
    filldrplst();


    }




// ********* search list for suppliers


const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }


list=@json($resultArray1);
// const contries1 = myarray1;
function onkeyUp1(e)
{
    let keyword= e.target.value;
    var supplier_id = document.getElementById("supplier_id");
    supplier_id.classList.remove("hidden");

    let filteredContries=list.filter((c)=>c.supname.toLowerCase().includes(keyword.toLowerCase()));
    // console.log(filteredContries);
    renderOptions1(filteredContries);
    // e.id + '      '+ e.srchb+' '+e.dimension
}

function renderOptions1(list){

    let dropdownEl=document.getElementById("supplier_id");


                $itmdata=[];
                dropdownEl.length = 0
                list.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.supname+' '+ e.chqno )
                    // $itmdata[e.id]=[ { shid:e.id,mnhdid:e.head_id,shdname:e.osuppname }  ];
                    $itmdata[e.id]=[ { shid:e.subheadid,mnhdid:e.head_id,mnhead:e.mhead,shdname:e.osuppname,chqno:e.chqno,chqamount:e.chqamount }  ];
                });
    // filldrplst();

}

document.addEventListener("click" , () => {
    // hidedropdown();
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


supplier_id.addEventListener("click", () => {
    let input1= document.getElementById("autocompleted1");
    autocompleted1.value=supplier_id.options[supplier_id.selectedIndex].text;

    if(per.checked==true && ($itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].chqamount) !=0 )
        {
        cheque_no.value =$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].chqno;
        cheque_amt.value =$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].chqamount;
        }
    hidedropdown1();

});


document.onkeydown=function(e){
    // if(e.keyCode == 17) isCtrl=true;
    // if(e.keyCode == 83 && isCtrl == true) {
        if(e.ctrlKey && e.which === 83){
        //run code for CTRL+S -- ie, save!
        // alert("dfadfasd");
        submitButton.click();
        return false;
    }
}




head_id.addEventListener("change", () => {

    filldrplst();
        // const value = head.value
        // autocompleted1.value='';
        // supplier_id.options.length = 0 // Reset List
        // // fetch(headlistp + `?head_id=${value} `,{
        //     fetch(headlistp + `?chqtext=${chqtext.value}&head_id=${value}`,{
        //             method:"GET",
        //             headers: { 'Accept':'application/json','Content-type':'application/json'},
        //             })
        //             .then(response => response.json())
        //             .then( data => {
        //                 if(data.length > 0)
        //                 {

        //                     let a = 0;

        //                     $itmdata= [];
        //                     list=data;
        //                     list.forEach(e => {
        //                         a += 1;
        //                         addSelectElement(supplier_id,e.id,a + '         ' + e.supname )
        //                         $itmdata[e.id]=[ { shid:e.subheadid,mnhdid:e.head_id,shdname:e.osuppname,chqno:e.chqno,chqamount:e.chqamount }  ];

        //                     });
        //                 }else{
        //                 }
        //             })
        //             .catch(error => console.error(error))

});


function addgrdrw()
{

    submitButton.removeAttribute('disabled');
    var result = dynamicTableData.filter( dt => dt.id == supplier_id.options[supplier_id.selectedIndex].value)
        if(result.length <= 0)
        {

            // var inArray = dynamicTableData.filter( i => dynamicTableData.id == supplier_id.options[supplier_id.selectedIndex].value)
            // dynamicTableData.push({ id:supplier_id.options[supplier_id.selectedIndex].value})
            var vdbt=0;
            var vcrdt=0;
            // document.getElementById("submitButton").disabled = false;
            if(amount == 0)
        {
            alert('Amount must be Enter')
            return
        }


            if( jvtype.options[jvtype.selectedIndex].value==1 )

            {
                vdbt=amount.value;
                vcrdt=0;
            }

            if( jvtype.options[jvtype.selectedIndex].value==2 )

            {
                vdbt=0;
                vcrdt=amount.value;
            }



            dynamicTable.addData([
                {


                    // $itmdata[e.id]=[ { shid:e.subheadid,mnhdid:e.head_id,shdname:e.osuppname }  ];
                    ttype:jvtype.options[jvtype.selectedIndex].text,
                    // mhead:head_id.options[head_id.selectedIndex].text,
                    // shead:supplier_id.options[supplier_id.selectedIndex].text,
                    // mheadid:head_id.options[head_id.selectedIndex].value,
                    sheadid:supplier_id.options[supplier_id.selectedIndex].value,
                    mhead:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].mnhead,
                    shead:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].shdname,
                    mheadid:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].mnhdid,
                    sheadid:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].shid,
                    debitamt:vdbt,
                    creditamt:vcrdt,
                    tamount:amount.value,
                    description:mdescription.value
                    // title:supplier_id.options[supplier_id.selectedIndex].text,
                    // category_id:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].category_id,
                    // category:$itmdata[supplier_id.options[supplier_id.selectedIndex].value][0].category,

                }

            ])



            var input = document.getElementById("jvtype").focus();
        }


}

            // {title:"Transaction Type", field:"ttype",headerSort: false, responsive:0,width:"100",cssClass:"bg-green-200 font-semibold"},
            // {title:"Main Head", field:"mhead",headerSort: false, responsive:0,width:"200",cssClass:"bg-green-200 font-semibold"},
            // {title:"Sub Head", field:"shead",headerSort: false, responsive:0,width:"400",cssClass:"bg-green-200 font-semibold"},

            // {title:"Main Head id", field:"mheadid",headerSort: false, responsive:0,width:"50",cssClass:"bg-green-200 font-semibold"},
            // {title:"Sub Head id", field:"sheadid",headerSort: false, responsive:0,width:"50",cssClass:"bg-green-200 font-semibold"},


//     function newchqno()
//     {

//     const cheque_no = document.getElementById('cheque_no');
//     // fetch(getchqstts ,{
//         fetch(getchqstts + `?head_id=${head_id.value}&supplier_id=${supplier_id.value}`,{
//                     method:"GET",
//                     headers: { 'Accept':'application/json','Content-type':'application/json'},
//                     })
//                     .then(response => response.json())
//                     .then( data => {
//                         console.log(data[cheque_no]);

//                         if(data.length > 0)
//                         {
//                             cheque_no.value=data[0];
//                         }else{
//                             cheque_no.value=data;
//                         }
//                     })
//                     .catch(error => console.error(error))

// }



function filldrplst()
{

    const value = head.value
        autocompleted1.value='';
        supplier_id.options.length = 0 // Reset List
        fetch(headlistp + `?chqtext=${chqtext.value}&head_id=${value}`,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;

                            $itmdata= [];
                            list=data;
                            list.forEach(e => {
                                a += 1;
                                addSelectElement(supplier_id,e.id,a + '         ' + e.supname+' '+ e.chqno )
                                $itmdata[e.id]=[ { shid:e.subheadid,mnhdid:e.head_id,mnhead:e.mhead,shdname:e.osuppname,chqno:e.chqno,chqamount:e.chqamount }  ];

                            });
                        }else{
                        }
                    })
                    .catch(error => console.error(error))






}

</script>
@endpush
</x-app-layout>
