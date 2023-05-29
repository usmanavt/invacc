<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Purchase Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('purrpt.fetch')}}" method="POST">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2 justify-center">
                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <div>
                                    <input type="radio" name="report_type" value="glhw" required onchange="checkReportType('glhw')">
                                    <label for="">Contracts </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="gl" required onchange="checkReportType('gl')">
                                    <label for="">Pending Contracts</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="impcominvs" required onchange="checkReportType('impcominvs')">
                                    <label for="">Imported Commercial Invoices </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="loccominvs" required onchange="checkReportType('loccominvs')">
                                    <label for="">Local Commercial Invoices </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="purret" required onchange="checkReportType('purret')">
                                    <label for="">Purchase Return </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="tpl" required onchange="checkReportType('tpl')">
                                    <label for="">Contact History</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="Imppurhist" required onchange="checkReportType('Imppurhist')">
                                    <label for="">Imported Purchase History</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="locpurhist" required onchange="checkReportType('locpurhist')">
                                    <label for="">Local Purchase History</label>
                                </div>


                                {{-- <div>
                                    <input type="radio" name="report_type" value="vchr" required onchange="checkReportType('vchr')">
                                    <label for="">Voucher</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="agng" required onchange="checkReportType('agng')">
                                    <label for="">Aging</label>
                                </div> --}}
                            </fieldset>

                            <fieldset class="border px-6 py-1.5  rounded ">
                                <legend>Report Criteria</legend>
                                {{-- <div>
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
                                </div> --}}

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
                                    <legend>Supplier Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="head_id" id="head_id" required class="w-full" disabled onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Inoices Selection <span class="text-xs text-mute">shift & click to select multiple items</span></legend>
                                    <div class="flex justify-between py-1">
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
    const subheadsci = @json($subheadsci);
    const subheadsciloc = @json($subheadsciloc);
    const glheads = @json($glheads);
    const subheadspend = @json($subheadspend);
    const vchrheads = @json($vchrheads);
    const contlistfill = @json(route('purrpt.contlistfill'));
    const cominvsloc = @json(route('purrpt.cominvsloc'));
    const cominvsimp = @json(route('purrpt.cominvsimp'));




    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const fromdate = document.getElementById('fromdate')
    const todate = document.getElementById('todate')
    let subheadavailable = false
    let rptType = ''
    let list;
    // console.info(heads)
        // console.info(subheadsci)
    // console.info(vchrcats)
    const headSelected = ()=>{
          const value = head.value
        //  const value = 6
        subhead.options.length = 0 // Reset List
        //   console.info(value)
        switch (rptType){
            // case 'glhw':
                // list = subheads.filter( l => l.MHEAD === Number(value)  )
                // if(list.length > 0)
                // {
                //     list.forEach(e => {
                //         addSelectElement(subhead,e.Subhead,e.title)
                //     });
                //     subhead.setAttribute('required','')
                //     subhead.removeAttribute('disabled','')
                // }else{
                //     subhead.removeAttribute('required','')
                //     subhead.setAttribute('disabled','')
                // }
                // break;


        // switch (rptType){
            // case 'impcominvs':
            //     list = subheadsci.filter( l => l.MHEAD === Number(value)  )
            //     if(list.length > 0)
            //     {
            //         list.forEach(e => {
            //             addSelectElement(subhead,e.Subhead,e.title)
            //         });
            //         subhead.setAttribute('required','')
            //         subhead.removeAttribute('disabled','')
            //     }else{
            //         subhead.removeAttribute('required','')
            //         subhead.setAttribute('disabled','')
            //     }
            //     break;

                // case 'loccominvs':
                // list = subheadsciloc.filter( l => l.MHEAD === Number(value)  )
                // if(list.length > 0)
                // {
                //     list.forEach(e => {
                //         addSelectElement(subhead,e.Subhead,e.title)
                //     });
                //     subhead.setAttribute('required','')
                //     subhead.removeAttribute('disabled','')
                // }else{
                //     subhead.removeAttribute('required','')
                //     subhead.setAttribute('disabled','')
                // }
                // break;

                case 'gl':
                // list = subheads.filter( l => l.MHEAD === value  )

                list = subheadspend.filter( l => l.MHEAD === value  )
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

            case 'glhw':
            // console.log(value)
            fetch(contlistfill + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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


                case 'loccominvs':
            // console.log(value)
            fetch(cominvsloc + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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

                case 'impcominvs':
            // console.log(value)
            fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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





            }
    }

    // FOR CONTRACT FILL
    const getSubheadVoucherData = async (value) =>{
        let data = await fetch(contlistfill + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getGlhw =async  (value) => {
        const glhw = await getSubheadVoucherData(value)
        return glhw
    }

    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

    // FOR LOCAL INVOICE FILL
    const getCominvslocVoucherData = async (value) =>{
        let data = await fetch(cominvsloc + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getCominvsloc =async  (value) => {
        const cominvsloc = await getCominvslocVoucherData(value)
        return cominvsloc
    }

    const addSelectElement1 = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }



// FOR IMPORTED INVOICE FILL
const getCominvsimpVoucherData = async (value) =>{
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getCominvsimp =async  (value) => {
        const cominvsimp = await getCominvsimpVoucherData(value)
        return cominvsimp
    }

    const addSelectElement2 = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }




    // const calculate = () =>{
    //     amount_pkr.value = (parseFloat(conversion_rate.value) * parseFloat(amount_fc.value)).toFixed(2)
    //     submitButton.disabled = false
    // }

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

            case 'gl':
                //  Show Head
                 rptType = 'gl'
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




            // case 'glhw':
            //     // Show Head
            //     rptType = 'glhw'
            //     head.setAttribute('required','')
            //     head.disabled = false
            //     head.length = 0
            //     subhead.removeAttribute('required')
            //     subhead.disabled = true
            //     subhead.length = 0
            //     heads.forEach(e => {
            //         addSelectElement(head,e.id,e.title)
            //     });
            //     headSelected()
            //     break;






            case 'impcominvs':
                // Show Head
                rptType = 'impcominvs'
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



                case 'glhw':
                //  Head Not Required
                rptType = 'glhw'
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
