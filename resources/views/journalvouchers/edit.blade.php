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
                                {{--
                                <div class="mt-2">
                                    <x-button id="submitButton">
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                </div> --}}
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
    const headsList = []    //  To get Value / Label Objects
    const subheadsList = []    //  To get Value / Label Objects

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
            {title:"Head",  field:"head_id",headerSort: false, width:200,validator:['required'],editor:"list",  editorParams:{
                    values: headsList,
                    emptyValue:null,
                },
                cellEdited:function(cell){
                    // console.info(cell.getData())
                    const head_id = cell.getData().head_id  // Note, we are using head_title append to populate subheads
                    // console.info(head_id)
                    const subs = subheads.filter( s => s.head_title=== head_id)
                    // console.info(subs)
                    subheadsList.length = 0
                    subheadsList.push({value:'-->select',label:'-->select',item:0})
                    //  Setup Heads
                    subs.forEach(e => {
                        subheadsList.push({value:e.title, label:e.id + " " + e.title, item:e.id})
                    })
                    // var id = cell.getRow().getIndex()
                    // console.info(cell.get)
                    // console.info("row id : ",id )
                    // dynamicTable.updateRow(id,{subhead_id:''})
                }
            },
            {title:"Subhead", width:150, field:"subhead_id",headerSort: false, editor:"list",validator:['required'], editorParams:{
                values: subheadsList
            }},
            {title:"JV #", width:100,validator:['required'],  field:"jvno",headerSort: false, editor:"input",cssClass:"bg-green-200 font-semibold"},
            {title:"Amount (PKR)", field:"amount",headerSort: false, editor:"number",cssClass:"bg-green-200 font-semibold",validator:['required','numeric']},
            {title:"Description", width:300, field:"description",headerSort: false,validator:['required'],  editor:"input",cssClass:"bg-green-200 font-semibold"},
        ],
    })

    document.addEventListener('DOMContentLoaded',()=>{
        //  Iterate heads and populate heads[] for tabulator
        heads.forEach(e => {headsList.push({value:e.title, label:e.id + " " + e.title ,item:e.id})})
        console.info(jvs)
        // dynamicTable.setData(jvs)
        // populateSelect()
        // setSelectedSubHead()
    })

    const populateSelect = ()=>{
        const val = head.value
        subhead.options.length = 0 // Reset List
        let list = subheads.filter( l => l.MHEAD === val)
        //  Setup subhead dropdown
        addSelectElement(subhead,'','--Select')
        list.forEach(e => {
            addSelectElement(subhead,e.Subhead,e.title)
        });
        if(list.length > 0)
        {
            subhead.setAttribute('required','')
            subhead.removeAttribute('disabled','')
        }else {
            subhead.removeAttribute('required','')
            subhead.setAttribute('disabled','')
        }
    }

    const setSelectedSubHead = () =>{
       for(i = 0 ; i < subhead.length ; i++)
       {
        if(subhead[i].value === jv.subhead_id)
        {
            subhead[i].selected
        }
        console.info(subhead[i])
       }
    }

    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }
</script>
@endpush

</x-app-layout>

