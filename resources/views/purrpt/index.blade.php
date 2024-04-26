<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Purchase Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('purrpt.fetch')}}" method="POST" target="_blank">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2 justify-center">
                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                {{-- <x-input-text title="hdid" name="hdid" id="hdid" /> --}}

                                <div>
                                    <input type="radio" name="report_type" value="glhw" required onchange="checkReportType('glhw')">
                                    <label for="">CONTRACTS </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="gdnrcvd" required onchange="checkReportType('gdnrcvd')" >
                                    <label for="">GOODS RECEIPT NOTE IMPORTED ( GRN ) </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="gdnrcvdlocal" required onchange="checkReportType('gdnrcvdlocal')" >
                                    <label for="">GOODS RECEIPT NOTE LOCAL ( GRN ) </label>
                                </div>






                                <div>
                                    <input type="radio" name="report_type" value="impcominvs" required onchange="checkReportType('impcominvs')">
                                    <label for="">PURCHASE INVOICE IMPORT </label>
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="imppurf2" id="imppurf2"   onclick="imppur(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Import Purchase Detail </span> <span class="text-red-500 font-semibold  "></span>
                                        </label>
                                        <input type="text" title="t5"  id="p5" name="p5" value="0" hidden   >

                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="impcominvs1" required onchange="checkReportType('impcominvs1')">
                                    <label for="">COMMERCIAL INVOICE IMPORT </label>
                                </div>



                                <div>
                                    <input type="radio" name="report_type" value="impcominvspc" required onchange="checkReportType('impcominvspc')">
                                    <label for="">IMPORT PAYABLE SUMMARY </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="dtyclrnc" required onchange="checkReportType('dtyclrnc')">
                                    <label for="">CUSTOM DUTY CLEARED </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="dtypnding" required onchange="checkReportType('dtypnding')">
                                    <label for="">CUSTOM DUTY PENDING </label>
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="dtypndsmry" id="dtypndsmry"   onclick="dtypndsmryfun(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold">  Summary </span> <span class="text-red-500 font-semibold  "></span>
                                        </label>
                                        <input type="text" title="t7"  id="p7" name="p7" value="0" hidden   >


                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="dtysmry" required onchange="checkReportType('dtysmry')">
                                    <label for="">CUSTOM DUTY SUMMARY </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="pndcontr" required onchange="checkReportType('pndcontr')">
                                    <label for="">PENDING CONTRACTS</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="cc" required onchange="checkReportType('cc')">
                                    <label for="">COMPLETED CONTRACTS</label>
                                </div>



                                <div>
                                    <input type="radio" name="report_type" value="loccominvs" required onchange="checkReportType('loccominvs')">
                                    <label for="">PURCHASE INVOICE LOCAL </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="purret" required onchange="checkReportType('purret')">
                                    <label for="">PURCHASE RETURN </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="tpl" required onchange="checkReportType('tpl')">
                                    <label for="">CONTRACTS HISTORY</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="imppurhist" required onchange="checkReportType('imppurhist')">
                                    <label for="">IMPORT PURCHASE HISTORY</label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="locpurhist" required onchange="checkReportType('locpurhist')">
                                    <label for="">LOCAL PURCHASE HISTORY</label>
                                </div>

                                <div class="flex flex-col ">
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
                                        PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744"
                                        Phone : 021-32588781, 021-32574285 , Fax : 021-32588782

                                    </textarea>
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
                                    <legend>Category Selection</legend>



                                    <div class="flex justify-between py-1">
                                        <select autocomplete="on" name="source_id" id="source_id"  required>
                                            {{-- <option disabled selected value="">--Select</option> --}}
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">{{ $source->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                </fieldset>
                                {{-- <x-input-text title="Searching" name="srch" id="srch"/> --}}


                                {{-- <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Supplier Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="head_id" id="head_id" required class="w-full"  onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset> --}}

                                <div class="w-96 relative grid grid-cols-4 gap-1 px-10 py-5  "   onclick="event.stopImmediatePropagation();" >
                                    {{-- <label for="autocompleted1">Sub Head<x-req /></label> --}}
                                    <input id="autocompleted1" title="Head Name" placeholder="Select Sub Head Name" class=" px-5 py-3 w-full border border-gray-400 rounded-md"
                                    onkeyup="onkeyUp1(event)" />
                                    <div>
                                        <select
                                            id="head_id" name="head_id" size="20" onchange="headSelected()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </select>
                                    </div>
                                </div>







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
    const subheadscomp = @json($subheadscomp);



    const vchrheads = @json($vchrheads);
    const contlistfill = @json(route('purrpt.contlistfill'));

    const funcgetsuplr = @json(route('purrpt.funcgetsuplr'));


    const funcpurcat = @json(route('purrpt.funcpurcat'));
    const funcpurcatlocal = @json(route('purrpt.funcpurcatlocal'));

    const dutycategory = @json(route('purrpt.dutycategory'));
    const pnddutycategory = @json(route('purrpt.pnddutycategory'));
    const pndcontractcategory = @json(route('purrpt.pndcontractcategory'));

    const compcontractcategory = @json(route('purrpt.compcontractcategory'));







    const cominvsloc = @json(route('purrpt.cominvsloc'));
    const cominvsimp = @json(route('purrpt.cominvsimp'));

    const funcpurretcategory = @json(route('purrpt.funcpurretcategory'));





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
                case 'glhw':
            //  console.log(todate.value)
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



    case 'tpl':
            //  console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData8 = async (value) =>{
        let data = await fetch(contlistfill + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getTpl =async  (value) => {
        const tpl = await getSubheadVoucherData8(value)
        return tpl
    }





    case 'gdnrcvd':
            //  console.log(todate.value)
            fetch(funcpurcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
// const getSubheadVoucherData2 = async (value) =>{
//         let data = await fetch(funcpurcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
//             method:"GET",
//             headers: { 'Accept':'application/json','Content-type':'application/json'},
//             })
//             .then(response => response.json())
//             .then( data => { return data })
//             .catch(error => console.error(error))
//     }
//     const getGdnrcvd =async  (value) => {
//         const gdnrcvd = await getSubheadVoucherData2(value)
//         return gdnrcvd
//     }


    case 'gdnrcvdlocal':
            //  console.log('21212')
            fetch(funcpurcatlocal + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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




    case 'dtyclrnc':
            //  console.log(todate.value)
            fetch(dutycategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData3 = async (value) =>{
        let data = await fetch(dutycategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getDtyclrnc =async  (value) => {
        const dtyclrnc = await getSubheadVoucherData3(value)
        return dtyclrnc
    }


    case 'dtypnding':
            //  console.log(todate.value)
            fetch(pnddutycategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData4 = async (value) =>{
        let data = await fetch(pnddutycategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getDtypnding =async  (value) => {
        const dtypnding = await getSubheadVoucherData4(value)
        return dtypnding
    }


    case 'pndcontr':
            //   console.log(todate.value)
            fetch(pndcontractcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData5 = async (value) =>{
        let data = await fetch(pndcontractcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getPndcontr =async  (value) => {
        const pndcontr = await getSubheadVoucherData5(value)
        return pndcontr
    }


    case 'cc':
            //   console.log(todate.value)
            fetch(compcontractcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData6 = async (value) =>{
        let data = await fetch(compcontractcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getCc =async  (value) => {
        const cc = await getSubheadVoucherData6(value)
        return cc
    }


    case 'impcominvspc':
            //   console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData7 = async (value) =>{
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getImpcominvspc =async  (value) => {
        const impcominvspc = await getSubheadVoucherData7(value)
        return impcominvspc
    }





    case 'dtysmry':
            //   console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData11 = async (value) =>{
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getDtysmry =async  (value) => {
        const dtysmry = await getSubheadVoucherData11(value)
        return dtysmry
    }










    case 'locpurhist':
            //   console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData9 = async (value) =>{
        let data = await fetch(cominvsloc + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getLocpurhist =async  (value) => {
        const locpurhist = await getSubheadVoucherData9(value)
        return locpurhist
    }

    case 'imppurhist':
            //   console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData10 = async (value) =>{
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getImppurhist =async  (value) => {
        const imppurhist = await getSubheadVoucherData10(value)
        return imppurhist
    }


    case 'impcominvs1':
            //   console.log(todate.value)
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

// FOR CONTRACT FILL
const getSubheadVoucherData19 = async (value) =>{
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getImpcominvs1 =async  (value) => {
        const impcominvs1 = await getSubheadVoucherData19(value)
        return impcominvs1
    }




    case 'purret':
            //   console.log(todate.value)
            fetch(funcpurretcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData15 = async (value) =>{
        let data = await fetch(funcpurretcategory + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getPurret =async  (value) => {
        const purret = await getSubheadVoucherData15(value)
        return purret
    }







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
                // dtyclrnc

                // impcominvspc
                case 'impcominvs':
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
        let data = await fetch(cominvsimp + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getImpcominvs =async  (value) => {
        const impcominvs = await getSubheadVoucherData(value)
        return impcominvs
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
            // case 'tpl':
            //     rptType = 'tpl'
            //     head.removeAttribute('required')
            //     head.disabled = true
            //     head.length = 0
            //     subhead.removeAttribute('required')
            //     subhead.disabled = true
            //     subhead.length = 0
            //     subheadavailable = false
            //     break;

            // case 'gl':
            //     //  Show Head
            //      rptType = 'gl'
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
                case 'cc':
                //  Show Head
                 rptType = 'cc'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;







            case 'glhw':
                // Show Head
                rptType = 'glhw'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'tpl':
                // Show Head
                rptType = 'tpl'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;


                case 'gdnrcvd':
                // Show Head
                rptType = 'gdnrcvd'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'gdnrcvdlocal':
                // Show Head
                rptType = 'gdnrcvdlocal'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;







                case 'dtyclrnc':
                // Show Head
                rptType = 'dtyclrnc'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'dtypnding':
                // Show Head
                rptType = 'dtypnding'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'dtypnding':
                // Show Head
                rptType = 'dtypnding'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'pndcontr':
                // Show Head
                rptType = 'pndcontr'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;



                case 'impcominvspc':
                // Show Head
                rptType = 'impcominvspc'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;



            case 'impcominvs':
                // Show Head
                rptType = 'impcominvs'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'impcominvs1':
                // Show Head
                rptType = 'impcominvs1'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;







                case 'dtysmry':
                // Show Head
                rptType = 'dtysmry'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;












                case 'loccominvs':
                // Show Head
                rptType = 'loccominvs'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

                case 'purret':
                // Show Head
                rptType = 'purret'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;





                case 'cominvsimp':
                // Show Head
                rptType = 'cominvsimp'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;

            case 'imppurhist':
                // Show Head
                rptType = 'imppurhist'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;






                case 'locpurhist':
                // Show Head
                rptType = 'locpurhist'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });
                headSelected()
                break;




                // case 'glhw':
                // //  Head Not Required
                // rptType = 'glhw'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                // subhead.removeAttribute('required')
                // subhead.disabled = true
                // subhead.length = 0
                // //  Add in Head added [6,7,8,9] RESTRICT
                // vchrheads.forEach(e => {
                //     // console.info(e)
                //     addSelectElement(head,e.id,e.title)
                // });
                // headSelected()
                // break;

            case 'agng':
                // Show Head
                rptType = 'agng'
                // head.setAttribute('required','')
                // head.disabled = false
                // head.length = 0
                // heads.forEach(e => {
                //     // console.info(e)
                //     addSelectElement(head,e.id,e.title)
                // });
                subhead.setAttribute('required','')
                subhead.disabled = false
                break;
        }
    }


    document.addEventListener('DOMContentLoaded',()=>{
        // heads.forEach(e => {
        //             addSelectElement(head,e.id,e.title)
        //         });
        //         headSelected()

                // sources.forEach(e => {
                //     addSelectElement(source,e.id,e.title)
                // });
                hidedropdown();

//     var sid = document.getElementById("source_id");
//     var source_id = sid.options[sid.selectedIndex];
//     const value = source_id.value

// //   console.info(value)
//   //  const value = 6
// fetch(funcgetsuplr + `?source_id=${value} `,{
//             method:"GET",
//             headers: { 'Accept':'application/json','Content-type':'application/json'},
//             })
//             .then(response => response.json())
//             .then( data => {
//                 if(data.length > 0)
//                 {


//                 //     head.length = 0
//                 // heads.forEach(e => {

//                 //     addSelectElement(head,e.id,e.title)
//                 // });


//                 head.length = 0
//                     let a = 0;
//                     data.forEach(e => {

//                         a += 1;
//                         addSelectElement(head,e.id,e.title)
//                     });
//                     // heads.setAttribute('required','')
//                     // heads.removeAttribute('disabled','')
//                 }else{
//                     // heads.removeAttribute('required','')
//                     // heads.setAttribute('disabled','')
//                 }
//             })
//             .catch(error => console.error(error))
//         // break;

// // FOR CONTRACT FILL
// const getSubheadVoucherData1 = async (value) =>{
// let data = await fetch(funcgetsuplr + `?source_id=${value} `,{
//     method:"GET",
//     headers: { 'Accept':'application/json','Content-type':'application/json'},
//     })
//     .then(response => response.json())
//     .then( data => { return data })
//     .catch(error => console.error(error))
// }
// const getFuncgetsuplr =async  (value) => {
// const Funcgetsuplr = await getSubheadVoucherData1(value)
// return Funcgetsuplr
// }


    });

 source_id.addEventListener("change", () => {

    var sid = document.getElementById("source_id");
    var source_id = sid.options[sid.selectedIndex];


    const value = source_id.value

//   console.info(value)
  //  const value = 6
fetch(funcgetsuplr + `?source_id=${value} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => {
                if(data.length > 0)
                {


                //     head.length = 0
                // heads.forEach(e => {

                //     addSelectElement(head,e.id,e.title)
                // });


                head_id.length = 0
                subhead.length=0
                    let a = 0;
                    list=data;
                    list.forEach(e => {

                        a += 1;
                        addSelectElement(head_id,e.id,e.title)
                    });
                    // heads.setAttribute('required','')
                    // heads.removeAttribute('disabled','')
                }else{
                    // heads.removeAttribute('required','')
                    // heads.setAttribute('disabled','')
                }
            })
            .catch(error => console.error(error))
        // break;

// FOR CONTRACT FILL
const getSubheadVoucherData1 = async (value) =>{
let data = await fetch(funcgetsuplr + `?source_id=${value} `,{
    method:"GET",
    headers: { 'Accept':'application/json','Content-type':'application/json'},
    })
    .then(response => response.json())
    .then( data => { return data })
    .catch(error => console.error(error))
}
const getFuncgetsuplr =async  (value) => {
const Funcgetsuplr = await getSubheadVoucherData1(value)
return Funcgetsuplr
}

});




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

    function dtypndsmryfun(dtypndsmry) {
        var p7 = document.getElementById("p7");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(dtypndsmry.checked==true)
        {
            p7.value=1;
        }
        else
        {
            p7.value=0;
        }

    }

//     srch.onblur=function(){
//     //  console.log('dfadsfasf');


//     var sid = document.getElementById("head_id");
//     var head_id = sid.options[sid.selectedIndex];
//     var xyz=head_id.data.value;
//     const subheadsList = [];
//     xyz.forEach(e => {
//                         subheadsList.push({value:e.title, label:e.title})
//                     })

//     // const valuess = head_id.value;
//     // console.log({subheadsList});

// }




// For Supplier List load


list=@json($resultArray);
// const contries1 = myarray1;
function onkeyUp1(e)
{
    let keyword= e.target.value;
    var head_id = document.getElementById("head_id");
    head_id.classList.remove("hidden");

    let filteredContries=list.filter((c)=>c.supname.toLowerCase().includes(keyword.toLowerCase()));
    // console.log($mychqno);
    renderOptions1(filteredContries);

}


var mychqno=[] ;
function renderOptions1(sup){

    let dropdownEl=document.getElementById("head_id");


                //  $mychqdt= [];
                //  $mychqno=[];
                //  $mnhdid=[];
                dropdownEl.length = 0
                // a=0;
                sup.forEach( e =>  {
                    addSelectElement(dropdownEl,e.id,e.supname )
                    // a=a+1;
                    // $shid =e.id;
                    // $mnhdid =e.head_id;
                    // $mychqdt =e.cheque_date;
                    //  $mychqno[e.id]=[ { chqno:e.cheque_no,chqdt:e.cheque_date,mychqamount:e.received,mychkid:e.cheque_id }  ];

                    });


}

document.addEventListener("click" , () => {
    hidedropdown();
});


function hidedropdown()
{
    var head_id = document.getElementById("head_id");
    head_id.classList.add("hidden");
}




head_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
// event.preventDefault();
head_id.click();

}
});



head_id.addEventListener("click", () => {

let input1= document.getElementById("autocompleted1");
let hdid= document.getElementById("hdid");


input1.value=head_id.options[head_id.selectedIndex].text;
// hdid.value=head_id.options[head_id.selectedIndex].value;

hidedropdown();

});






// document.onkeydown=function(e){
//         if(e.ctrlKey && e.which === 83){
//         submitbutton.click();
//         return false;
//     }
// }



source_id.addEventListener("change", () => {

    var sid = document.getElementById("source_id");
    var source_id = sid.options[sid.selectedIndex];
    const value = source_id.value
    // console.log(value);
    let dropdownEl=document.getElementById("head_id");
    autocompleted1.value='';
    dropdownEl.options.length = 0 // Reset List
        fetch(funcgetsuplr + `?source_id=${value} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => {
                if(data.length > 0)
                {

                    // console.log(data);
                //     head.length = 0
                // heads.forEach(e => {

                //     addSelectElement(head,e.id,e.title)
                // });


                // head.length = 0
                // subhead.length=0
                //     let a = 0;
                    data.forEach(e => {
                        addSelectElement(dropdownEl,e.id,e.supname)
                    });
                    // heads.setAttribute('required','')
                    // heads.removeAttribute('disabled','')
                }else{
                    data.forEach(e => {
                        addSelectElement(dropdownEl,e.id,e.supname)
                    });


                }
            })
            .catch(error => console.error(error))
        // break;

// FOR CONTRACT FILL
// const getSubheadVoucherData1 = async (value) =>{
// let data = await fetch(funcgetsuplr + `?source_id=${value} `,{
//     method:"GET",
//     headers: { 'Accept':'application/json','Content-type':'application/json'},
//     })
//     .then(response => response.json())
//     .then( data => { return data })
//     .catch(error => console.error(error))
// }
// const getFuncgetsuplr =async  (value) => {
// const Funcgetsuplr = await getSubheadVoucherData1(value)
// return Funcgetsuplr
// }

});







</script>
@endpush
</x-app-layout>
