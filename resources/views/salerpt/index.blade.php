<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sale Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('salerpt.fetch')}}" method="POST" target="_blank">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2  justify-center">
                            {{-- <fieldset class="border px-4 py-2 height 30 rounded"> --}}
                                <fieldset class="border h-60 w-32 px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <div>
                                    <input type="radio" name="report_type" value="quotation" required onchange="checkReportType('quotation')">
                                    <label for="">Price Quotation </label>
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="chq" id="chq"   onclick="chqcol(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Format II </span> <span class="text-red-500 font-semibold  "></span>
                                        </label>
                                        <input type="text" title="t1"  id="p1" name="p1" value="0" hidden   >

                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="pendquotation" required onchange="checkReportType('pendquotation')">
                                    <label for="">Pending Price Quotation </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="compquotation" required onchange="checkReportType('compquotation')">
                                    <label for="">Completed Price Quotation </label>
                                </div>



                                <div>
                                    <input type="radio" name="report_type" value="custorder" required onchange="checkReportType('custorder')">
                                    <label for="">Purchase Order </label>

                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="comp" id="comp"   onclick="chqcomp(this)" >

                                    <label for="">
                                        <span style="color: brown;font-weight: bold"> Show Only Completed P.O </span> <span class="text-red-500 font-semibold  "></span>
                                         </label>
                                         <input type="text" title="t1"  id="p2" name="p2" value="0" hidden   >



                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="pendcustorder" required onchange="checkReportType('pendcustorder')">
                                    <label for="">Pending Purchase Order </label>
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
                                    <label for="">Commercial Invoice </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="salret" required onchange="checkReportType('salret')">
                                    <label for="">Sale Return Invoice </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="salhist" required onchange="checkReportType('salhist')">
                                    <label for="">Sale History </label>
                                </div>
                                <div>
                                    <input type="radio" name="report_type" value="salrethist" required onchange="checkReportType('salrethist')">
                                    <label for="">Sale Return History</label>
                                </div>
                                <br>


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
                                        Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,
                                        Phone : 021-32588781, 021-32574285 , Fax : 021-32588782
                                    </textarea>

                                    <label for="">
                                        Term of Condition(For Quotation) <span class="text-red-500 font-semibold w-10 ">(*)</span>
                                    </label>
                                    {{-- <textarea name="toc" id="toc" cols="40" rows="4" maxlength="255"  class="rounded"></textarea> --}}

                                    <input type="text" title="Term-a" class="col-span-2" id="t1" name="t1"  >
                                    <input type="text" title="Term-b" class="col-span-2" id="t2" name="t2"  >
                                    <input type="text" title="Term-c" class="col-span-2" id="t3" name="t3"  >
                                    <input type="text" title="Term-d" class="col-span-2" id="t4" name="t4"  >
                                    <input type="text" title="Term-e" class="col-span-2" id="t5" name="t5"  >


                                </div>


                            </fieldset>

                            <fieldset class="border px-6 py-1.5  rounded  ">
                                <legend>Report Criteria</legend>
                                {{-- <div class="flex flex-col md:flex-row w-full gap-2 px-6 pt-4"> --}}

                                    <fieldset class="border px-4 py-2  rounded w-full">
                                        <legend>Date Selection</legend>
                                        <div class="flex justify-between py-1">
                                            <x-input-date title="From" req id="fromdate" name="fromdate" required/>
                                            <x-input-date title="To" req id="todate" name="todate" required/>
                                        </div>
                                    </fieldset>
                                {{-- </div> --}}

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

                            </fieldset>
                            <div class="flex flex-col md:flex-row w-full gap-2 px-6 py-2">
                                <x-button type="submit">
                                    Generate PDF
                                </x-button>
                            </div>

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
    const funcquotation = @json(route('salerpt.funcquotation'));

    const funcpendquotation = @json(route('salerpt.funcpendquotation'));
    const funccompquotation = @json(route('salerpt.funccompquotation'));

    const funccustorder = @json(route('salerpt.funccustorder'));
    const funcpendcustorder = @json(route('salerpt.funcpendcustorder'));




    const funcdlvrychln = @json(route('salerpt.funcdlvrychln'));
    const funcsalinvs = @json(route('salerpt.funcsalinvs'));
    const funcsaltxinvs = @json(route('salerpt.funcsaltxinvs'));
    const funcsalhist = @json(route('salerpt.funcsalhist'));

    const funcsalretcat = @json(route('salerpt.funcsalretcat'));


    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const fromdate = document.getElementById('fromdate')
    const cname = document.getElementById('cname')
    const todate = document.getElementById('todate')
    let subheadavailable = false
    let rptType = ''
    let list;

    const headSelected = ()=>{
          const value = head.value
        //  const value = 6
        subhead.options.length = 0 // Reset List
        //  console.info(rptType)
        switch (rptType){

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







    case 'pendquotation':
            // console.log(value)
            fetch(funcpendquotation + `?&head=${value}`,{
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
const getSubheadVoucherDatapnd = async (value) =>{
        let data = await fetch(funcpendquotation + `?head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getQuotationpend =async  (value) => {
        const quotationpend = await getSubheadVoucherDatapnd(value)
        return quotationpend
    }


    case 'compquotation':
            // console.log(value)
            fetch(funccompquotation + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherDatacmp = async (value) =>{
    let data = await fetch(funccompquotation + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getQuotationcomp =async  (value) => {
        const quotationcomp = await getSubheadVoucherDatacmp(value)
        return quotationcomp
    }



    case 'custorder':
            // console.log(value)
            fetch(funccustorder + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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

// // FOR CONTRACT FILL
const getSubheadVoucherData1 = async (value) =>{
        let data = await fetch(funccustorder + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getCustorder =async  (value) => {
        const custorder = await getSubheadVoucherData1(value)
        return custorder
    }


    case 'pendcustorder':
            // console.log(value)
            fetch(funcpendcustorder + `?head=${value}`,{
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

// // FOR CONTRACT FILL
const getSubheadVoucherData10 = async (value) =>{
        let data = await fetch(funcpendcustorder + `?head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getPendCustorder =async  (value) => {
        const pendcustorder = await getSubheadVoucherData10(value)
        return pendcustorder
    }


















    case 'dlvrychln':
            // console.log(value)
            fetch(funcdlvrychln + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData2 = async (value) =>{
        let data = await fetch(funcdlvrychln + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getDlvrychln =async  (value) => {
        const dlvrychln = await getSubheadVoucherData2(value)
        return dlvrychln
    }



    case 'salinvs':
            // console.log(value)
            fetch(funcsalinvs + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
        let data = await fetch(funcsalinvs + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getSalinvs =async  (value) => {
        const salinvs = await getSubheadVoucherData3(value)
        return salinvs
    }


    case 'saltxinvs':
            // console.log(value)
            fetch(funcsaltxinvs + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
        let data = await fetch(funcsaltxinvs + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getSaltxinvs =async  (value) => {
        const saltxinvs = await getSubheadVoucherData4(value)
        return saltxinvs
    }

    case 'salhist':
            // console.log(value)
            fetch(funcsalhist + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
        let data = await fetch(funcsalhist + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getSalhist =async  (value) => {
        const salhist = await getSubheadVoucherData11(value)
        return salhist
    }



    case 'salret':
            // console.log(value)
            fetch(funcsalretcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData13 = async (value) =>{
        let data = await fetch(funcsalretcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getSalret =async  (value) => {
        const salret = await getSubheadVoucherData13(value)
        return salret
    }


    case 'salrethist':
            // console.log(value)
            fetch(funcsalretcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
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
const getSubheadVoucherData14 = async (value) =>{
        let data = await fetch(funcsalretcat + `?todate=${todate.value}&fromdate=${fromdate.value}&head=${value}`,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getSalrethist =async  (value) => {
        const salrethist = await getSubheadVoucherData14(value)
        return salrethist
    }









            // switch (rptType){
            // case 'saltxinvs':
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

                // case 'salret':
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

                // case 'salinvs':
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

                case 'pendquotation':
                // Show Head
                rptType = 'pendquotation'
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

                case 'compquotation':
                // Show Head
                rptType = 'compquotation'
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





                case 'custorder':
                // Show Head
                rptType = 'custorder'
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

                case 'pendcustorder':
                // Show Head
                rptType = 'pendcustorder'
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


                case 'salhist':
                // Show Head
                rptType = 'salhist'
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





                case 'salret':
                // Show Head
                rptType = 'salret'
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

                case 'salrethist':
                // Show Head
                rptType = 'salrethist'
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

    function chqcol(chqcomp) {
        var p1 = document.getElementById("p1");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(chqcomp.checked==true)
        {
            p1.value=1;
        }
        else
        {
            p1.value=0;
        }

    }

    function chqcomp(chqcomp) {
        var p2 = document.getElementById("p2");
        // amount_fc.disabled = advtxt.checked ? true : false;

        // amount_fc.disabled = per.checked ? true : false;

        if(chqcomp.checked==true)
        {
            p2.value=1;
        }
        else
        {
            p2.value=0;
        }

    }

</script>
@endpush
</x-app-layout>
