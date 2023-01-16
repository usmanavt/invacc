<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Journal Voucher
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                 {{-- Create Form --}}
                 <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('jv.edit',$jv) }}" method="post" class="flex flex-col">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $jv->id }}">
                                <x-input-date title="Dcoument Date" name="document_date" req required/>
                                <label for="">Transaction Type</label>
                                <div>
                                    <input type="radio" name="transaction_type" id="transaction_type" value="DEBIT" @if($jv->transaction_type === 'DEBIT') checked @endif>
                                    <label for="">DEBIT</label>
                                    <input type="radio" name="transaction_type" id="transaction_type" value="CREDIT"  @if($jv->transaction_type === 'CREDIT') checked @endif >
                                    <label for="">CREDIT</label>
                                </div>
                                {{-- Head --}}
                                <label for="">Head</label>
                                <select autocomplete="on" name="head_id" id="head_id" required onchange="populateSelect()">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($heads as $head)
                                        <option value="{{ $head->id }}" @if($head->id === $jv->head_id) selected @endif>{{ $head->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Subhead --}}
                                <label for="">Subead</label>
                                <select autocomplete="on" name="subhead_id" id="subhead_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                </select>

                                <x-input-numeric title="Amount" name="amount" id="amount" min="1" req required class="" value="{{ $jv->amount }}"/>
                                <x-input-text title="JV #" name="jvno" id="amount" req required class="" value="{{ $jv->jvno }}"/>

                                <div class="flex flex-col">
                                    <label for="">
                                        Description <span class="text-red-500 font-semibold">(*)</span>
                                    </label>
                                    <textarea name="description" id="description" cols="30" rows="3" maxlength="255" required class="rounded">{{ $jv->description }}</textarea>
                                </div>

                                <div class="mt-2">
                                    <x-button id="submitButton">
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@push('scripts')
<script>
    const subheads = @json($subheads);
    const jv = @json($jv);
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')

    document.addEventListener('DOMContentLoaded',()=>{
       populateSelect()
       setSelectedSubHead()
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

