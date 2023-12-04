<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Material Stock Reports
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('stockledgers.fetch')}}" method="POST">
                        @csrf
                        <div class="flex flex-col md:flex-row flex-wrap gap-2 justify-center">
                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Report Type</legend>
                                <input type="text" title="t1"  id="p1" name="p1" value="0" hidden  >
                                <tr>
                                    <td  style="text-align: center;">
                                        <span style="font-size:1.5rem">--- FOR OFFICE ---</span>
                                    </td>
                                </tr>

                                <div>
                                    <input type="radio" name="report_type" value="dlvrychln" required >
                                    {{-- onchange="checkReportType('dlvrychln')" --}}
                                    <label for="">SMLS Master Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="sraluntos" >
                                    {{-- required onchange="checkReportType('sraluntos')" --}}
                                    <label for="">SMLS All Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="smsind" >
                                    <label for="">SMSL Individual Master Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="smsval" >
                                    <label for="">SMSL Valuation </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="sto" >
                                    <label for="">Stock Transfer Order </label>
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox" name="adv" id="adv"   onclick="psto(this)" >
                                    <label for="">
                                       <span style="color: brown;font-weight: bold"> Show Only Pending STO </span> <span class="text-red-500 font-semibold  ">(*)</span>
                                        </label>

                                </div>



                                <tr>
                                    <td  style="text-align: center;">
                                        <span style="font-size:1.5rem">--- FOR GODOWN ---</span>
                                    </td>
                                </tr>

                                <div>
                                    <input type="radio" name="report_type" value="dlvrychlngd" required >
                                    {{-- onchange="checkReportType('dlvrychlngd')" --}}
                                    <label for="">SMLS Master Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="sraluntgs" >
                                    {{-- required onchange="checkReportType('sraluntgs')" --}}
                                    <label for="">SMLS All Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="gwsmu" required >
                                    {{-- onchange="checkReportType('gwsmu')" --}}
                                    <label for="">Godown Wise Master Unit</label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="gwsau" required onchange="checkReportType('gwsau')">
                                    <label for="">Godown Wise All Unit </label>
                                </div>


                                <div>
                                    <input type="radio" name="report_type" value="smsindgs" required onchange="checkReportType('smsindgs')">
                                    <label for="">SMSL Individual Master Unit </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="smsvalgs" >
                                    <label for="">Godown Wise Valuation </label>
                                </div>

                                <div>
                                    <input type="radio" name="report_type" value="smsvalgssmry" >
                                    <label for="">Godown Wise Valuation Summary </label>
                                </div>




                            </fieldset>

                            <fieldset class="border px-6 py-1.5  rounded h-120 ">
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
                                    <legend>Item Group Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="head_id" id="head_id" required class="w-full" disabled onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Category Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="source_id" id="source_id" required class="w-full" disabled onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Specification Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="brand_id" id="brand_id" required class="w-full" disabled onchange="headSelected()">
                                        </select>
                                    </div>
                                </fieldset>





                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Godown Selection</legend>
                                    <div class="flex justify-between py-1">
                                        <select  name="gc" id="gc" required class="w-full" >
                                            {{-- disabled onchange="headSelected()" --}}
                                        </select>
                                    </div>
                                </fieldset>






                                {{-- <input type="text" title="Search List Text" class="col-span-2" id="srch" name="srch"  onchange="headSelected()" > --}}


                                <fieldset class="border px-4 py-2 rounded w-full">
                                    <legend>Inoices Selection <span class="text-xs text-mute">shift & click to select multiple items</span></legend>
                                        <select size="20" multiple class="h-full w-full" name="subhead_id[]" id="subhead_id" required class="w-full disabled:opacity-50" disabled>
                                        </select>
                                    </div>
                                </fieldset>





                            </div>

                            <div class="flex flex-col md:flex-row w-full gap-1 px-6 pt-4">



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

                        <div class="flex flex-col md:flex-row w-full gap-1 px-6 pt-4">

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

                            <x-button type="submit" >
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
    const sources = @json($source);
    const specifications = @json($specification);
    const locations = @json($location);
    const subheads = @json($subheads);
    const subheadsci = @json($subheadsci);
    const subheadsciloc = @json($subheadsciloc);
    const glheads = @json($glheads);
    const subheadspend = @json($subheadspend);
    const vchrheads = @json($vchrheads);

    const funcstkos = @json(route('stockledgers.funcstkos'));


    const head = document.getElementById('head_id')
    const source = document.getElementById('source_id')
    const specification = document.getElementById('brand_id')


    const locationss = document.getElementById('gc')
    const subhead = document.getElementById('subhead_id')
    const fromdate = document.getElementById('fromdate')
    const todate = document.getElementById('todate')
    let subheadavailable = false
    let rptType = ''
    let list;
    //  console.info(head)
        // console.info(subheadsci)
    // console.info(vchrcats)
    const headSelected = ()=>{
          const value = head.value
          const value1 = source.value
          const value3 = specification.value
          console.info(value)
          //  const value = 6
        subhead.options.length = 0 // Reset List
        //  console.info(rptType)


        switch (rptType){
//             case 'dlvrychln' :

//                 fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//                     method:"GET",
//                     headers: { 'Accept':'application/json','Content-type':'application/json'},
//                     })
//                     .then(response => response.json())
//                     .then( data => {
//                         if(data.length > 0)
//                         {

//                             let a = 0;
//                             data.forEach(e => {
//                                 a += 1;
//                                 addSelectElement(subhead,e.Subhead,a + ' - ' + e.title)
//                             });
//                             subhead.setAttribute('required','')
//                             subhead.removeAttribute('disabled','')
//                         }else{
//                             subhead.removeAttribute('required','')
//                             subhead.setAttribute('disabled','')
//                         }
//                     })
//                     .catch(error => console.error(error))
//                 break;

// // FOR CONTRACT FILL
// const getSubheadVoucherData = async (value) =>{
//         let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//             method:"GET",
//             headers: { 'Accept':'application/json','Content-type':'application/json'},
//             })
//             .then(response => response.json())
//             .then( data => { return data })
//             .catch(error => console.error(error))
//     }
//     const getStkos =async  (value) => {
//         const Stkos = await getSubheadVoucherData(value)
//         return Stkos
//     }


            case 'dlvrychlngd':
//             fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//                     method:"GET",
//                     headers: { 'Accept':'application/json','Content-type':'application/json'},
//                     })
//                     .then(response => response.json())
//                     .then( data => {
//                         if(data.length > 0)
//                         {

//                             let a = 0;
//                             data.forEach(e => {

//                                 a += 1;
//                                 addSelectElement(subhead,e.Subhead,a + ' - ' + e.title)
//                             });
//                             subhead.setAttribute('required','')
//                             subhead.removeAttribute('disabled','')
//                         }else{
//                             subhead.removeAttribute('required','')
//                             subhead.setAttribute('disabled','')
//                         }
//                     })
//                     .catch(error => console.error(error))
//                 break;

// // FOR CONTRACT FILL
// const getSubheadVoucherData1 = async (value) =>{
//         let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//             method:"GET",
//             headers: { 'Accept':'application/json','Content-type':'application/json'},
//             })
//             .then(response => response.json())
//             .then( data => { return data })
//             .catch(error => console.error(error))
//     }
//     const getStkos1 =async  (value) => {
//         const Stkos1 = await getSubheadVoucherData1(value)
//         return Stkos1
//     }


                case 'sraluntos':
                fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;
                            data.forEach(e => {

                                a += 1;
                                addSelectElement(subhead,e.Subhead,a + ' - ' + e.title)
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
        let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getStkos2 =async  (value) => {
        const Stkos2 = await getSubheadVoucherData2(value)
        return Stkos2
    }





                // switch (rptType){
            // case 'saltxinvs':

            case 'sraluntos':
                fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;
                            data.forEach(e => {

                                a += 1;
                                addSelectElement(subhead,e.Subhead,a + ' - ' + e.title)
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
        let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getStkos3 =async  (value) => {
        const Stkos3 = await getSubheadVoucherData3(value)
        return Stkos3
    }

    case 'gwsmu':
                fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3}`,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;
                            data.forEach(e => {

                                a += 1;
                                addSelectElement(subhead,e.Subhead,a + ' - ' + e.title)
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
        let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getStkos4 =async  (value) => {
        const Stkos4 = await getSubheadVoucherData4(value)
        return Stkos4
    }







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




            // case 'dlvrychln':
                // Show Head
                // rptType = 'dlvrychln'
                // head.setAttribute('required','')
                // source.setAttribute('required','')
                // specification.setAttribute('required','')
                // head.disabled = false
                // source.disabled=false
                // specification.disabled=false
                // head.length = 0
                // source.length=0
                // specification.length=0
                // subhead.removeAttribute('required')
                // subhead.disabled = true
                // subhead.length = 0
                // // For Second Category
                // heads.forEach(e => {
                //     addSelectElement(head,e.id,e.title)
                // });


                // // For First Category
                // sources.forEach(e => {
                //     addSelectElement(source,e.id,e.title)
                // });

                // specifications.forEach(e => {
                //     addSelectElement(specification,e.id,e.title)
                // });

                // // locations.forEach(e => {
                // //     addSelectElement(locationss,e.id,e.title)
                // // });


                // // sourceSelected()
                // headSelected()
                // break;


                // case 'gwsmu':
                // // Show Head
                // rptType = 'gwsmu'
                // locationss.setAttribute('required','')
                // locationss.disabled=false
                // locationss.length=0
                // locations.forEach(e => {
                //     addSelectElement(locationss,e.id,e.title)
                // });


                // sourceSelected()
                // headSelected()
                // break;


// ;

             case 'dlvrychlngd':
            //     // Show Head
                //  rptType = 'dlvrychlngd'
            //     head.setAttribute('required','')
            //     source.setAttribute('required','')

            //     head.disabled = false
            //     source.disabled=false

            //     head.length = 0
            //     source.length=0

            //     subhead.removeAttribute('required')
            //     subhead.disabled = true
            //     subhead.length = 0
            //     heads.forEach(e => {
            //         addSelectElement(head,e.id,e.title)
            //     });

            //     // For First Category
            //     sources.forEach(e => {
            //         addSelectElement(source,e.id,e.title)
            //     });

                //  headSelected()
            //     // sourceSelected()
                 break;

                case 'sraluntos':
                // Show Head
                rptType = 'sraluntos'
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

    document.addEventListener('DOMContentLoaded',()=>{


                head.setAttribute('required','')
                source.setAttribute('required','')
                specification.setAttribute('required','')
                head.disabled = false
                source.disabled=false
                specification.disabled=false
                head.length = 0
                source.length=0
                specification.length=0
                subhead.removeAttribute('required')
                subhead.disabled = true
                subhead.length = 0
                // For Second Category
                heads.forEach(e => {
                    addSelectElement(head,e.id,e.title)
                });

                // For First Category
                sources.forEach(e => {
                    addSelectElement(source,e.id,e.title)
                });

                specifications.forEach(e => {
                    addSelectElement(specification,e.id,e.title)
                });

                // sourceSelected()


                locationss.setAttribute('required','')
                locationss.disabled=false
                locationss.length=0
                locations.forEach(e => {
                    addSelectElement(locationss,e.id,e.title)
                });
                headSelected();

            })


    head_id.addEventListener("change", () => {

        const value = head.value
          const value1 = source.value
          const value3 = specification.value
          console.info(value)
          //  const value = 6
        subhead.options.length = 0 // Reset List
        fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
                    method:"GET",
                    headers: { 'Accept':'application/json','Content-type':'application/json'},
                    })
                    .then(response => response.json())
                    .then( data => {
                        if(data.length > 0)
                        {

                            let a = 0;
                            data.forEach(e => {

                                a += 1;
                                addSelectElement(subhead,e.Subhead,a + ' - '+ e.Subhead + ' - ' + e.title)
                            });
                            subhead.setAttribute('required','')
                            subhead.removeAttribute('disabled','')
                        }else{
                            subhead.removeAttribute('required','')
                            subhead.setAttribute('disabled','')
                        }
                    })
                    .catch(error => console.error(error))
                // break;

// FOR CONTRACT FILL
const getSubheadVoucherData1 = async (value) =>{
        let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => { return data })
            .catch(error => console.error(error))
    }
    const getStkos1 =async  (value) => {
        const Stkos1 = await getSubheadVoucherData1(value)
        return Stkos1
    }

});


source_id.addEventListener("change", () => {

const value = head.value
  const value1 = source.value
  const value3 = specification.value
  console.info(value)
  //  const value = 6
subhead.options.length = 0 // Reset List
fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => {
                if(data.length > 0)
                {

                    let a = 0;
                    data.forEach(e => {

                        a += 1;
                        addSelectElement(subhead,e.Subhead,a + ' - '+ e.Subhead + ' - ' + e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
            })
            .catch(error => console.error(error))
        // break;

// FOR CONTRACT FILL
const getSubheadVoucherData1 = async (value) =>{
let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
    method:"GET",
    headers: { 'Accept':'application/json','Content-type':'application/json'},
    })
    .then(response => response.json())
    .then( data => { return data })
    .catch(error => console.error(error))
}
const getStkos1 =async  (value) => {
const Stkos1 = await getSubheadVoucherData1(value)
return Stkos1
}

});


brand_id.addEventListener("change", () => {

const value = head.value
  const value1 = source.value
  const value3 = specification.value
  console.info(value)
  //  const value = 6
subhead.options.length = 0 // Reset List
fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
            method:"GET",
            headers: { 'Accept':'application/json','Content-type':'application/json'},
            })
            .then(response => response.json())
            .then( data => {
                if(data.length > 0)
                {

                    let a = 0;
                    data.forEach(e => {

                        a += 1;
                        addSelectElement(subhead,e.Subhead,a + ' - '+ e.Subhead + ' - ' + e.title)
                    });
                    subhead.setAttribute('required','')
                    subhead.removeAttribute('disabled','')
                }else{
                    subhead.removeAttribute('required','')
                    subhead.setAttribute('disabled','')
                }
            })
            .catch(error => console.error(error))
        // break;

// FOR CONTRACT FILL
const getSubheadVoucherData1 = async (value) =>{
let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
    method:"GET",
    headers: { 'Accept':'application/json','Content-type':'application/json'},
    })
    .then(response => response.json())
    .then( data => { return data })
    .catch(error => console.error(error))
}
const getStkos1 =async  (value) => {
const Stkos1 = await getSubheadVoucherData1(value)
return Stkos1
}

});

function psto(adv) {
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


</script>
@endpush
</x-app-layout>
