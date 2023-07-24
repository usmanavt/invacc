<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sale Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('salerpt.fetch')}}" method="POST" target="_blank">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2  justify-center">
                            {{-- <fieldset class="border px-4 py-2 height 30 rounded"> --}}
                                <fieldset class="border h-40 w-32 px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <div>
                                    <input type="radio" name="report_type" value="quotation" required onchange="checkReportType('quotation')">
                                    <label for="">Sale Quotation </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="dlvrychln" required onchange="checkReportType('dlvrychln')">
                                    <label for="">Delivery Challan </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="salinvs" required onchange="checkReportType('salinvs')">
                                    <label for="">Sale Invoice</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="saltxinvs" required onchange="checkReportType('saltxinvs')">
                                    <label for="">Sale Tax invoice </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="loccominvs" required onchange="checkReportType('loccominvs')">
                                    <label for="">Credit Note </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="purret" required onchange="checkReportType('purret')">
                                    <label for="">Sale History </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="tpl" required onchange="checkReportType('tpl')">
                                    <label for="">Sale Return History</label>
                                </div>

                                {{-- <div>
                                    <input type="radio" name="report_type" value="Imppurhist" required onchange="checkReportType('Imppurhist')">
                                    <label for="">Imported Purchase History</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="locpurhist" required onchange="checkReportType('locpurhist')">
                                    <label for="">Local Purchase History</label>
                                </div> --}}


                                {{-- <div>
                                    <input type="radio" name="report_type" value="vchr" required onchange="checkReportType('vchr')">
                                    <label for="">Voucher</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="agng" required onchange="checkReportType('agng')">
                                    <label for="">Aging</label>
                                </div> --}}
                            </fieldset>

                            <fieldset class="border px-6 py-1.5  rounded  ">
                                <legend>Report Criteria</legend>
                                <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                                    <fieldset class="border px-4 py-2  rounded w-full">
                                        <legend>Date Selection</legend>
                                        <div class="flex justify-between py-1">
                                            <x-input-date title="From" req id="fromdate" name="fromdate" required/>
                                            <x-input-date title="To" req id="todate" name="todate" required/>
                                        </div>
                                    </fieldset>
                                </div>

                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Customer Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="head_id" id="head_id" required class="w-full" disabled onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Inoices Selection <span class="text-xs text-mute">shift & click to select multiple items</span></legend>
                                        <select size="20" multiple class="h-full w-full" name="subhead_id[]" id="subhead_id" required class="w-full disabled:opacity-50" disabled>
                                        </select>
                                    </div>
                                </fieldset>





                            </div>

                            <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">



                            </fieldset>
                        </div>

                        {{-- <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Date Selection</legend>
                                <div class="flex justify-between py-1">
                                    <x-input-date title="From Date" req id="fromdate" name="fromdate" required/>
                                    <x-input-date title="To Date" req id="todate" name="todate" required/>
                                </div>
                                {{-- <div class="flex justify-between py-1"> --}}
                                    {{-- <x-input-date title="To Date" req id="todate" name="todate" required/> --}}
                                    {{-- <x-input-date name="to"  id="to" required> --}}
                                {{-- </div> --}}
                            </fieldset>
                        {{-- </div> --}}

                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            {{-- <fieldset class="border px-4 py-2 rounded w-full">
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
                            </fieldset> --}}

                            <x-button type="submit">
                                Generate PDF
                            </x-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    const heads = @json($heads);
    const subheads = @json($subheads);

    const subheadsqut = @json($subheadsqut);

    const subheadsci = @json($subheadsci);
    const subheadsciloc = @json($subheadsciloc);
    const glheads = @json($glheads);
    const subheadspend = @json($subheadspend);
    const vchrheads = @json($vchrheads);
    const funcquotation = @json(route('salerpt.funcquotation'));


    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const fromdate = document.getElementById('fromdate')
    const todate = document.getElementById('todate')
    let subheadavailable = false
    let rptType = ''
    let list;
    //   console.info(fromdate.value)
    //   console.info(todate.value)
        // console.info(subheadsqut)
    // console.info(vchrcats)
    const headSelected = ()=>{
          const value = head.value
        //  const value = 6
        subhead.options.length = 0 // Reset List
        //  console.info(rptType)
        switch (rptType){
            case 'dlvrychln':

                list = subheads.filter( l => l.MHEAD === Number(value)  )
                if(list.length > 0)
                {
                    list.forEach(e => {
                        addSelectElement(subhead,e.Subhead,e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
                break;

        // case 'quotation':


        //         list = subheadsqut.filter( l => l.MHEAD === Number(value)  )
        //         if(list.length > 0)
        //         {
        //             list.forEach(e => {
        //                 addSelectElement(subhead,e.Subhead,e.title)
        //             });
        //             subhead.setAttribute('required','')
        //             subhead.removeAttribute('disabled','')
        //         }else{
        //             subhead.removeAttribute('required','')
        //             subhead.setAttribute('disabled','')
        //         }
        //         break;



        case 'quotation':
            // console.log(value)
            fetch(funcquotation + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {
                            data.forEach(e => {
                                addSelectElement(subhead,e.Subhead,e.title)
                            });
                            subhead.setAttribute('required','')
                            subhead.removeAttribute('disabled','')
                        }else{
                            subhead.removeAttribute('required','')
                            subhead.setAttribute('disabled','')
                        }
                    })
                    .catch(error => console.error(error))
                break;

// FOR CONTRACT FILL
const getSubheadVoucherData = async (value) =>{
        let data = await fetch(funcquotation + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getQuotation =async  (value) => {
        const quotation = await getSubheadVoucherData(value)
        return quotation
    }

    // const addSelectElement = (select,id,value) => {
    //     var option = document.createElement('option')
    //     option.value = id
    //     option.text  = value
    //     select.appendChild(option)
    // }






            // switch (rptType){
            case 'saltxinvs':
                list = subheadsci.filter( l => l.MHEAD === Number(value)  )
                if(list.length > 0)
                {
                    list.forEach(e => {
                        addSelectElement(subhead,e.Subhead,e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
                break;

                case 'loccominvs':
                list = subheadsciloc.filter( l => l.MHEAD === Number(value)  )
                if(list.length > 0)
                {
                    list.forEach(e => {
                        addSelectElement(subhead,e.Subhead,e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
                break;

                case 'salinvs':
                // list = subheads.filter( l => l.MHEAD === value  )

                list = subheads.filter( l => l.MHEAD === Number(value)  )
                // console.info(value)
                if(list.length > 0)
                {
                    list.forEach(e => {
                        // addSelectElement(subhead,e.Subhead,e.title)
                        addSelectElement(subhead,e.Subhead,e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
                break;


            case 'vchr':m
                fetch(vouchers + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {
                            data.forEach(e => {
                                addSelectElement(subhead,e.id,e.Title)
                            });
                            subhead.setAttribute('required','')
                            subhead.removeAttribute('disabled','')
                        }else{
                            subhead.removeAttribute('required','')
                            subhead.setAttribute('disabled','')
                        }
                    })
                    .catch(error => console.error(error))
                break;
        }

    }

    const getSubheadVoucherData = async (value) =>{
        let data = await fetch(vouchers + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getVchr =async  (value) => {
        const vchr = await getSubheadVoucherData(value)
        return vchr
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
                rptType = 'tpl'
                head.removeAttribute('required')
                head.disabled = true
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                subheadavailable = false
                break;

            case 'salinvs':
                //  Show Head
                 rptType = 'salinvs'
                // head.removeAttribute('required','')
                // head.disabled = true
                // head.length = 0
                // subhead.setAttribute('required','')
                // subhead.disabled = false
                // subhead.length = 0
                // subheadavailable = false
                // glheads.forEach(e => {
                //     // console.info(e)
                //     addSelectElement(subhead,e.id,e.title)
                // });
                // // Show subheads
                // break;

                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;




            case 'dlvrychln':
                // Show Head
                rptType = 'dlvrychln'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;


                case 'quotation':
                // Show Head
                rptType = 'quotation'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;





            case 'saltxinvs':
                // Show Head
                rptType = 'saltxinvs'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;

            case 'loccominvs':
                // Show Head
                rptType = 'loccominvs'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;



                case 'vchr':
                //  Head Not Required
                rptType = 'vchr'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                //  Add in Head added [6,7,8,9] RESTRICT
                vchrheads.forEach(e => {
                    // console.info(e)
                    addSelectElement(head,e.id,e.title)
                });
                headSelected()
                break;

            case 'agng':
                // Show Head
                rptType = 'agng'
                head.setAttribute('required','')
                head.disabled = false
                head.length = 0
                heads.forEach(e => {
                    // console.info(e)
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
