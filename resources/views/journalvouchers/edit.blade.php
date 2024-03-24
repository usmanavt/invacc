<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

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
                                <fieldset class="border px-4 py-2 rounded">
                                    <legend>Transaction Date</legend>
                                    <x-input-date title="Dcoument Date" name="jvdate" value="{{ $document_date }}" />
                                    <x-input-text title="Dcoument No" name="document_no" value="{{ $jvno }}"  />
                                </fieldset>

                                <fieldset class="border px-4 py-2 rounded">
                                    <legend>Transaction Date</legend>
                                    {{-- <x-input-text title="Description" name="description" id="description" value="{{ $description }}" req required class="col-span-2"   /> --}}
                                    <x-input-text title="Cheque No" name="cheque_no" id="cheque_no" value="{{ $cheque_no }}" req required class="col-span-2" disabled  />
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                    <label for="">
                                        <span style="color: brown;font-weight: bold"> J.V Against Cheque Collection </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                         </label>
                                </fieldset>


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
                                    <x-input-text title="Password For Edition" name="edtpw" id="edtpw" type="password"     />
                                    <x-input-text title="" name="dbpwrd2" id="dbpwrd2"  class="col-span-2" hidden value="{{$passwrd}}" />

                                </div>
                                <div>

                                    {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox"  name="del" id="del" disabled   onclick="delmode(this)" >
                                    <label for="">
                                        <span style="color: brown;font-weight: bold"> Delete Mode </span> <span class="text-red-500 font-semibold font-size:1rem "></span>
                                        </label> --}}

                                    {{-- <x-input-text title="Password For Deletion" name="delpwrd" id="delpwrd" type="password" class="col-span-2"    />
                                    <x-input-text title="" name="delpwrd2" id="delpwrd2" hidden  class="col-span-2"    value="{{$passwrddel}}" /> --}}
                                    <x-input-text title="" name="p2" id="p2" value="0" hidden  />
                                    <x-input-text title="" name="cheque_nofd" id="cheque_nofd" hidden value="{{ $cheque_no }}" req required class="col-span-2" disabled  />
                                    <x-input-text title="" name="gdno" id="gdno" value="{{ $vgdno }}" hidden disabled  />
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

document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitButton").disabled = true;
     })





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
        // document.getElementById('del').disabled=true;

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
            // {title:"JV #", width:100,validator:['required'],  field:"jvno",headerSort: false, editor:"input",cssClass:"bg-green-200 font-semibold"},
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
        var mydata = {'document_no':document_no.value,'jvdate':jvdate.value,'cheque_no':cheque_no.value,'p2':p2.value,
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

    function EnableDisableTextBox(per) {
        var cheque_no = document.getElementById("cheque_no");
        cheque_no.disabled = per.checked ? false : true;
        cheque_no.style.color ="black";
        cheque_no.value="";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }

    edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitButton").disabled = false;

    }
    else
    {document.getElementById("submitButton").disabled = true;}

    }

    function delmode(del) {
        var p2 = document.getElementById("p2");
        if(del.checked==true)
        {
            document.getElementById("submitButton").disabled = false;
            p2.value=1;
        }
        else
        {
            document.getElementById("submitButton").disabled = true;
            p2.value=0;
        }

    }

    // delpwrd.onblur=function(){
    // if(delpwrd.value == delpwrd2.value )
    //  {
    //     // document.getElementById("submitButton").disabled = false;
    //     document.getElementById('del').disabled=false;

    // }
    // else
    // {
    //     // document.getElementById("submitButton").disabled = true;
    //     document.getElementById('del').disabled=true;

    // }


    // }




</script>
@endpush

</x-app-layout>

