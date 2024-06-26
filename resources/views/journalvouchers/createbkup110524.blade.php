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
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create Form --}}
                <div class="px-6 py-2" >

                    {{-- Form Data --}}
                    <div class="flex">
                        <form action="{{ route('jv.store') }}" method="post" >
                        @csrf
                        <fieldset class="max-w-7xl border px-4 py-2 gap-4 rounded">
                            <legend>Transaction Date</legend>
                            <x-input-date title="Dcoument Date" name="document_date" req required/>
                            <x-input-text title="Dcoument No" name="document_no" value="{{$maxjvno}}"/>

                        </fieldset>

                        <fieldset class="max-w-7xl border px-4 py-2 gap-4 rounded">
                            <legend>Transaction Date</legend>
                            {{-- <x-input-text title="Description" name="description"  /> --}}
                            <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" req required class="col-span-2" disabled  />
                            {{-- <x-input-numeric title="Cheque Amount" name="chequamt" id="chequamt" req required class="col-span-2"   /> --}}
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                            <label for="">
                                <span style="color: brown;font-weight: bold"> J.V Against Cheque Collection </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                 </label>

                        </fieldset>

                        <fieldset class="max-w-7xl border px-4 py-2 gap-4 rounded mt-8">
                            <legend>Total J.V Amount</legend>
                            <x-input-numeric title="Debit Amount" name="dbtamt" id="dbtamt" req required class="col-span-2" disabled   />
                            <x-input-numeric title="Credit Amount" name="cdtamt" id="cdtamt" req required class="col-span-2" disabled   />
                        </fieldset>



                        {{-- <fieldset class="border px-4 py-2 gap-2 rounded">
                            <legend>J.V Against Cheque Collection</legend>
                            <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" req required class="col-span-2"  />
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                        </fieldset> --}}


                        {{-- Dynamic Tabulator --}}
                        <x-tabulator-dynamic />

                        <div class="pt-2">
                            <x-button id="submitButton" type="button" disabled onclick="submitData()">
                                Submit
                            </x-button>
                            <label>Over/Under</label>
                            <x-input id="balance" type="number" disabled/>
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
    })
    document.addEventListener('keyup', (e)=>{
        if(e.ctrlKey && e.keyCode == 32){
            addRow()
        }
    })
    const addRow = () => {
        dynamicTable.addRow({})
        dataSet = dynamicTable.getData()
        dynamicTable.redraw()
        submitButton.removeAttribute('disabled')
    }
    //  Dynamic Table [User data]
    dynamicTable = new Tabulator("#dynamicTable", {
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
            {title:'Type',field:'transaction_type',editor:"list",validator:['required'],editorParams:{ values:['DEBIT','CREDIT']}, width:70 , responsive:0} ,
            {title:"Head",  field:"head_title",headerSort: false, width:200,validator:['required'],editor:"list", responsive:0,  editorParams:{
                    values: headsList,
                },
                cellEdited:function(cell){
                    const head_title = cell.getData().head_title
                    const subs = subheads.filter( s => s.mtitle === head_title)
                    console.info(subs)
                    subheadsList.length = 0
                    subheadsList.push({value:'-->select',label:'-->select'})
                    //  Setup Heads
                    subs.forEach(e => {
                        subheadsList.push({value:e.title, label:e.title})
                    })
                    // grdummary();
               }
            },
            {title:"Subhead", width:150, field:"subhead_title",headerSort: false, editor:"list", responsive:0,validator:['required'], editorParams:{
                values: subheadsList
            }},
            // {title:"JV #", width:100,validator:['required'],  field:"jvno",headerSort: false, responsive:0, editor:"input",cssClass:"bg-green-200 font-semibold"},
            // {title:"JV #", width:100,validator:['required'],  field:"jvno",headerSort: false, responsive:0, editor:"input",cssClass:"bg-green-200 font-semibold"},
            {title:"Amount (PKR)", field:"amount",headerSort: false, editor:"number", responsive:0,cssClass:"bg-green-200 font-semibold",
            validator:['required','numeric'],bottomCalc:"sum"},
            {title:"Description", width:300, field:"description",headerSort: false, responsive:0,validator:['required'],  editor:"input",cssClass:"bg-green-200 font-semibold"},
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
        const filtered = data.filter(f => f.subhead_id === '-->select')
        if(filtered.length>0){ alert('Select proper subhead'); return}
        //  Calculate and check if Debit/Credit is 0
        let valid = 0;
        let vdbamt=0;
        let vcdamt=0;

        data.forEach(e => {
            if(e.transaction_type === 'DEBIT')
            { valid -= e.amount
                vdbamt+=e.amount
            }
            if(e.transaction_type === 'CREDIT')
            { valid += e.amount
              vcdamt+=e.amount
            }
        })

        document.getElementById('cdtamt').value =  vcdamt
        document.getElementById('dbtamt').value = vdbamt

        document.getElementById('balance').value =valid


        if(valid != 0) { alert('Debit/Credit should be settled before procedding'); return }
        //  Correct Data
        // data.forEach(e => {
        //     var head = e.head_id
        //     var dHead = heads.filter(h => h.title === head)
        //     e.head_id = dHead[0].id
        //     var subhead = e.subhead_id
        //     var sHead = subheads.filter(h => h.title === subhead)
        //     e.subhead_id = sHead[0].id
        // })
        //  Now Post Data
        var mydata = {
            'document_date': document.getElementById('document_date').value,
            'document_no': document.getElementById('document_no').value,
            'cheque_no': document.getElementById('cheque_no').value,
            'dbtamt': document.getElementById('dbtamt').value,
            'cdtamt': document.getElementById('cdtamt').value,
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
                window.open(window.location.origin + "/jv","_self" );
            }
        })
        .catch(error => {
            showSnackbar("Errors occured","red");
        })
    }

    function EnableDisableTextBox(per) {
        var cheque_no = document.getElementById("cheque_no");
        cheque_no.disabled = per.checked ? false : true;
        cheque_no.style.color ="black";
        cheque_no.value="";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }



</script>
@endpush
</x-app-layout>
