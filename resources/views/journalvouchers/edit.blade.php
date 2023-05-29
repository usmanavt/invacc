<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Journal Voucher {{ $transaction }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                 {{-- Create Form --}}
                 <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('jv.edit',$transaction) }}" method="post" class="flex flex-col">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $transaction }}">
                                {{-- Dynamic Tabulator --}}
                                <x-tabulator-dynamic />
                                <div class="pt-2">
                                    <x-button id="submitButton" type="button"  onclick="submitData()">
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
    const jvs = @json($jvs);
    const transaction = @json($transaction);
    const document_date = @json($document_date);
    const headsList = []    //  To get Value / Label Objects
    const subheadsList = []    //  To get Value / Label Objects

    console.info(document_date)

    document.addEventListener('DOMContentLoaded', () => {
        heads.forEach(e => {headsList.push({value:e.title, label:e.title})})
    })
    document.addEventListener('keyup', (e)=>{
        //  We are using ctrl key + 'ArrowUp'
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
        data:jvs,
        reactiveData:true,
        columns:[
            {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    cell.getRow().delete();
                    const rowCount = dynamicTable.getDataCount()
                    if(rowCount <=0 ) { submitButton.setAttribute('disabled','') }
                }
            },
            {title:'Type',field:'transaction_type',editor:"list",validator:['required'],editorParams:{ values:['DEBIT','CREDIT']}, width:70} ,
            {title:"Head",  field:"head_title",headerSort: false,width:200,validator:['required'],editor:"list",  editorParams:{
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
               }
            },
            {title:"Subhead", width:150, field:"subhead_title",headerSort: false, editor:"list",validator:['required'], editorParams:{
                values: subheadsList
            }},
            {title:"JV #", width:100,validator:['required'],  field:"jvno",headerSort: false, editor:"input",cssClass:"bg-green-200 font-semibold"},
            {title:"Amount (PKR)", field:"amount",headerSort: false, editor:"number",cssClass:"bg-green-200 font-semibold",validator:['required','numeric']},
            {title:"Description", width:300, field:"description",headerSort: false,validator:['required'],  editor:"input",cssClass:"bg-green-200 font-semibold"},
        ],
    })

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
        data.forEach(e => {
            if(e.transaction_type === 'DEBIT') { valid -= parseInt(e.amount)}
            if(e.transaction_type === 'CREDIT') { valid += parseInt(e.amount)}
        })
        document.getElementById('balance').value = valid
        if(valid != 0) { alert('Debit/Credit should be settled before procedding'); return }
        //  Correct Data
        data.forEach(e => {
            e.transaction = transaction
            e.document_date = document_date
        })
        //  Now Post Data
        var mydata = {
            'vouchers': data
        }
        fetch(@json(route('jv.update',$transaction)),{
            credentials: 'same-origin', // 'include', default: 'omit'
            method: 'PUT', // 'GET', 'PUT', 'DELETE', etc.
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
</script>
@endpush

</x-app-layout>
