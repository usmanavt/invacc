<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">


                    <form action="{{ route('getreport') }}">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2 justify-center">
                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <div>
                                    <input type="radio" name="report_type" value="tpl" required onchange="checkReportType('tpl')">
                                    <label for="">Transaction Prove List</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="gl" required onchange="checkReportType('gl')">
                                    <label for="">General Ledger</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="glhw" required onchange="checkReportType('glhw')">
                                    <label for="">General Ledger (Head Wise)</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="vchr" required onchange="checkReportType('vchr')">
                                    <label for="">Voucher</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="agng" required onchange="checkReportType('agng')">
                                    <label for="">Aging</label>
                                </div>
                            </fieldset>

                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Additional Requests</legend>
                                <div>
                                    <input type="checkbox" name="additional[]" value="wdrfa">
                                    <label for="">With Detail Report (For Aging)</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="additional[]" value="mmbfa">
                                    <label for="">Mention Minus Balance (For Aging)</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="additional[]" value="wsfgl">
                                    <label for="">With Summary (For General Ledger)</label>
                                </div>
                                <div>
                                    <input type="checkbox" name="additional[]" value="wiwcd">
                                    <label for="">With Invoice Wise Collections Details</label>
                                </div>
                            </fieldset>
                        </div>

                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Date Selection</legend>
                                <div class="flex justify-between py-1">
                                    <x-input-date title="From Date" req name="fromdate" required/>
                                </div>
                                <div class="flex justify-between py-1">
                                    <x-input-date title="To Date" req name="todate" required/>
                                    {{-- <x-input-date name="to"  id="to" required> --}}
                                </div>
                            </fieldset>
                        </div>

                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Heads</legend>
                                <div class="flex justify-between py-1">
                                    <select  name="head_id" id="head_id" required class="w-full" disabled onchange="headSelected()">
                                    </select>
                                </div>
                            </fieldset>
                        </div>

                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Sub Head <span class="text-xs text-mute">shift & click to select multiple items</span></legend>
                                <div class="flex justify-between py-1">
                                    <select size="5" multiple class="h-full w-full" name="subhead_id[]" id="subhead_id" required class="w-full disabled:opacity-50" disabled>
                                    </select>
                                </div>
                            </fieldset>

                            <x-button>
                                Submit
                            </x-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    let heads = @json($heads);
    let subheads = @json($subheads);
    let glheads = @json($glheads);
    let vchrheads = @json($vchrheads);
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')

    const headSelected = ()=>{
        const val = head.value
        subhead.options.length = 0 // Reset List
        let list = subheads.filter( l => l.head_id === parseInt(val))
        list.forEach(e => {
            addSelectElement(subhead,e.id,e.title)
        });
        subhead.removeAttribute('required','')
        subhead.removeAttribute('disabled','')
        // console.info(list)
    }

    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

    const calculate = () =>{
        amount_pkr.value = (parseFloat(conversion_rate.value) * parseFloat(amount_fc.value)).toFixed(2)
        submitButton.disabled = false
    }

    const checkReportType = (type) => {
        switch (type) {
            case 'tpl':
                head.removeAttribute('required')
                head.disabled = true
                subhead.removeAttribute('required')
                subhead.disabled = true
                break;

            case 'gl':
                //  Show Head
                head.removeAttribute('required','')
                head.disabled = true
                head.length = 0
                subhead.setAttribute('required','')
                subhead.disabled = false
                subhead.length = 0
                glheads.forEach(e => {
                    console.info(e)
                    addSelectElement(subhead,e.id,e.title)
                });
                // Show subheads
                break;

            case 'glhw':
                // Show Head
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.length = 0
                heads.forEach(e => {
                    console.info(e)
                    addSelectElement(head,e.id,e.title)
                });
                subhead.setAttribute('required','')
                subhead.disabled = false
                break;

            case 'vchr':
                //  Head Not Required
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                //  Add in Head added [6,7,8,9] RESTRICT
                vchrheads.forEach(e => {
                    console.info(e)
                    addSelectElement(head,e.id,e.title)
                });
                break;

            case 'agng':
                // Show Head
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                heads.forEach(e => {
                    console.info(e)
                    addSelectElement(head,e.id,e.title)
                });
                subhead.setAttribute('required','')
                subhead.disabled = false
                break;
        }
    }
</script>
@endpush
</x-app-layout>
