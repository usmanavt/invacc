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


                    <form action="{{ route('analysis.fetch')}}" method="POST" target="_blank">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2   justify-center">
                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <div>
                                    <input type="radio" name="report_type" value="tb" required onchange="checkReportType('tb')">
                                    <label for="">Trail Balance</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="bs" required onchange="checkReportType('bs')">
                                    <label for="">Balance Sheet</label>

                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="glhw" required onchange="checkReportType('glhw')">
                                    <label for="">Income Statement</label>

                                    {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="glhsum" id="glhsum"   onclick="GLHWSUMRY(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Summary </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                        </label> --}}



                                </div>
                                {{-- <div>
                                    <input type="radio" name="report_type" value="glhws" required onchange="checkReportType('glhws')">
                                    <label for="">General Ledger Summary (Head Wise)</label>
                                </div> --}}
{{--
                                <div>
                                    <input type="radio" name="report_type" value="invwspay" required onchange="checkReportType('invwspay')">
                                    <label for="">Invoice Wise Payment/Collection</label>

                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv"   onclick="advpayment(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Show Only Pending Invoices </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                        </label>

                                </div>
 --}}
                                {{-- <div>
                                    <input type="radio" name="report_type" value="chktran" required onchange="checkReportType('chktran')">
                                    <label for="">Cheque Transaction</label>

                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="chq" id="chq"   onclick="chqcol(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Show Only Pending Cheques </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                        </label>

                                </div> --}}






                                {{-- <div>
                                    <input type="radio" name="report_type" value="invwscol" required onchange="checkReportType('invwscol')">
                                    <label for="">Invoice Wise Collection</label>
                                </div> --}}


                                {{-- <div>
                                    <input type="radio" name="report_type" value="vchr" required onchange="checkReportType('vchr')">
                                    <label for="">Voucher</label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="agng" required onchange="checkReportType('agng')">
                                    <label for="">Aging Detail</label>

                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="agdtl" id="agdtl"   onclick="vagng(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Summary </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                        </label>

                                </div> --}}

                            </fieldset>





                            {{-- <fieldset class="border px-4 py-2 rounded">
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
                            </fieldset> --}}
                        </div>
                        <input type="text" title="t1"  id="p1" name="p1" value="0" hidden  >
                        <input type="text" title="t2"  id="p2" name="p2" value="0" hidden  >
                        <input type="text" title="t3"  id="p3" name="p3" value="0" hidden  >
                        <input type="text" title="t4"  id="p4" name="p4" value="0" hidden   >
                        <input type="text" title="t5"  id="p5" name="p5" value="0" hidden   >
                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Date Selection</legend>
                                <div class="flex justify-between py-1">
                                    <x-input-date title="From Date" req id="fromdate" name="fromdate" required/>
                                </div>
                                <div class="flex justify-between py-1">
                                    <x-input-date title="To Date" req id="todate" name="todate" required/>
                                </div>
                            </fieldset>
                        </div>
                        {{-- <div class="flex flex-col ">
                            <label for="">
                                Customer Name<span class="text-red-500 font-semibold w-10">(*)</span>
                            </label>
                            <textarea name="cname" id="cname" cols="40" rows="1"  maxlength="150" required class="rounded">
                                MUHAMMAD NAZIR & Co
                            </textarea>

                            <label for="">
                                Customer Address <span class="text-red-500 font-semibold w-10 ">(*)</span>
                            </label>
                            <textarea name="csdrs" id="csdrs" cols="40" rows="5" maxlength="255"   class="rounded">
                                Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes
                                Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,
                                Phone : 021-32588781, 021-32574285 , Fax : 021-32588782
                            </textarea>
                        </div> --}}






                        {{-- <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Heads</legend>
                                <div class="flex justify-between py-1">
                                    <select  name="head_id" id="head_id" required class="w-full" disabled onchange="headSelected()">
                                    </select>
                                </div>
                            </fieldset>
                        </div> --}}

                        <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4">

                            {{-- <fieldset class="border px-4 py-2 rounded w-full">
                                <legend>Sub Head <span class="text-xs text-mute">shift & click to select multiple items</span></legend>
                                <div class="flex justify-between py-1">
                                    <select size="12" multiple class="h-full w-full" name="subhead_id[]" id="subhead_id" required class="w-full disabled:opacity-50" disabled>
                                    </select>
                                </div>
                            </fieldset> --}}


                            <x-button type="submit">
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
    const heads = @json($heads);
    const subheads = @json($subheads);
    const glheads = @json($glheads);
    const vchrheads = @json($vchrheads);
    const vouchers = @json(route('reports.vouchers'));
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const fromdate = document.getElementById('fromdate')
    const todate = document.getElementById('todate')
    let subheadavailable = false
    let rptType = ''
    let list;
    // console.info(heads)
    // console.info(subheads)
    // console.info(vchrcats)
    const headSelected = ()=>{
        const value = head.value
        subhead.options.length = 0 // Reset List
        // console.info(rptType)
        switch (rptType){
            case 'glhw':
                list = subheads.filter( l => l.MHEAD === value)
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

                case 'invwspay':
                list = subheads.filter( l => l.MHEAD === value)
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

                case 'agng':
                list = subheads.filter( l => l.MHEAD === value)
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






             case 'vchr':
            // console.log(subhead);
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

            case 'gl':
                //  Show Head
                rptType = 'gl'
                head.removeAttribute('required','')
                head.disabled = true
                head.length = 0
                subhead.setAttribute('required','')
                subhead.disabled = false
                subhead.length = 0
                subheadavailable = false
                glheads.forEach(e => {
                    // console.info(e)
                    addSelectElement(subhead,e.id,e.title)
                });
                // Show subheads
                break;

            case 'glhw':
                // Show Head
                rptType = 'glhw'
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

                case 'invwspay':
                // Show Head
                rptType = 'invwspay'
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

                case 'agng':
                // Show Head
                rptType = 'agng'
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

    function advpayment(adv) {
        var p1 = document.getElementById("p1");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(adv.checked==true)
        {
            p1.value=1;
        }
        else
        {
            p1.value=0;
        }

    }

    function chqcol(chq) {
        var p4 = document.getElementById("p4");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(chq.checked==true)
        {
            p4.value=1;
        }
        else
        {
            p4.value=0;
        }

    }





    function GLHWSUMRY(glhsum) {
        var p2 = document.getElementById("p2");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(glhsum.checked==true)
        {
            p2.value=1;
        }
        else
        {
            p2.value=0;
        }

    }


    function vagng(agdtl) {
        var p3 = document.getElementById("p3");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(agdtl.checked==true)
        {
            p3.value=1;
        }
        else
        {
            p3.value=0;
        }

    }


    function imppur(imppurf2) {
        var p5 = document.getElementById("p5");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(imppurf2.checked==true)
        {
            p5.value=1;
        }
        else
        {
            p5.value=0;
        }

    }








</script>
@endpush
</x-app-layout>
