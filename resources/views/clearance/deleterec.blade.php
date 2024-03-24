<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    @endpush


    <x-slot name="header">
        <div style="font-size: 3rem;font-weight: bold;color:brown;border:blue">
            Delete Record Information for Dury Clearance
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-text title="Invoice #" name="invoiceno"  value="{{ $clearance->invoiceno }}"  disabled/>
                                <x-input-text title="Mac. No" name="machineno" value="{{ $clearance->machineno }}"  disabled/>
                                <x-input-date title="Mac. Date" name="machine_date" req required class="col-span-2" disabled />
                                <x-input-date title="Clearance Date" id="invoicedate" name="invoicedate" disabled class="col-span-2" />

                                <x-input-text title="" name="id" value="{{ $clearance->id }}"  hidden/>

                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-date title="GD Date" name="gd_date" value="{{ $clearance->gd_date->format('Y-m-d') }}" disabled   />
                                    <x-input-text title="GD #" name="gdno"  value="{{ $clearance->gdno }}" disabled />

                                <x-input-numeric title="Conversion Rate" name="conversionrate" disabled value="{{ $clearance->conversionrate }}"  />
                                {{-- <x-input-numeric title="Supp.Conv. Rate" name="sconversionrate"  req required class=""/> --}}
                                <x-input-numeric title="Insurance" name="insurance"  value="{{ $clearance->insurance }}" disabled/>

                                    <x-label for="" value="Unit as Per Duty Calculation"/>
                                    <select autocomplete="on" required name="dunitid" id ="dunitid"  disabled >
                                        <option value="" selected>--Unit</option>
                                        @foreach ($cd as $sku)
z                                           @if ($sku->id == $clearance->dunitid)
                                            <option value="{{$sku->id}}" selected>{{$sku->title}}</option>
                                            @else
                                            <option value="{{ $sku->id }}">{{ $sku->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                            </div>
                        </fieldset>

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            <label for="">Debit to </label>
                            <select autocomplete="on" name="bank_id" id="bank_id" disabled>
                                <option disabled selected value="">--Select</option>
                                @foreach ($banks as $bank)
                                @if ($bank->id == $clearance->bank_id)
                                    <option value="{{$bank->id}}" selected>{{$bank->title}}</option>
                                @else
                                    <option value="{{ $bank->id }}">{{ $bank->title }}</option>
                                @endif
                                @endforeach
                            </select>
                            <x-input-date title="cheque date" name="cheque_date" value="{{ $clearance->cheque_date->format('Y-m-d') }}" disabled />
                            <x-input-numeric title="cheque no" name="cheque_no" value="{{ $clearance->cheque_no }}" disabled    />
                                <x-input-numeric title="cominvsid" name="cominvsid" value="{{ $clearance->commercial_invoice_id }}" disabled    />
                        </div>


                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">



                                    <x-input-numeric title="Bank Chrgs" name="bankcharges" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Cust Coll" name="collofcustom" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Ex Tax of" name="exataxoffie" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Lcl Cartage" name="localcartage" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Custom Sepoy" name="customsepoy" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Weigh Bridge" name="weighbridge" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Misc Exp" name="miscexpenses" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Agency Chgs" name="agencychrgs" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Other Chgs" name="otherchrgs" 0  required  onblur="calculateBankCharges()"/>
                                        <x-input-numeric title="Total" name="banktotal" value="{{ $clearance->banktotal }}" disabled />

                            </div>
                        </fieldset> --}}

                        {{-- Contract Details --}}
                        <div class="flex flex-row px-4 py-2 items-center">
                            {{-- <x-label value="Add Pcs & Feet Size & Press"></x-label> --}}
                            {{-- <x-button id="calculate" class="mx-2" onclick="calculate();calculate();calculate();">Calculate</x-button> --}}

                            {{-- <x-label value="This will prepare your commercial invoice for Submission"></x-label> --}}
                        </div>
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" onclick="validateForm()">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                            <x-input-text title="Password For Deletion" name="edtpw" id="edtpw" type="password"     />
                            <x-input-text title="" name="dbpwrd2" id="dbpwrd2"  class="col-span-2" hidden value="{{$passwrd}}" />

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Contracts" />

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitbutton").disabled = true;
     })

        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        let rcvIsMoreThenPending = [] // if reciving is more then pending pcs
        const getDetails = @json(route('clearances.details'));
        const cid = @json("$clearance->id");
        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []

        // Bank Charges
        // let bankcharges= document.getElementById("bankcharges")
        // let collofcustom= document.getElementById("collofcustom")
        // let exataxoffie= document.getElementById("exataxoffie")
        // let lngnshipdochrgs= document.getElementById("lngnshipdochrgs")
        // let localcartage= document.getElementById("localcartage")
        // let miscexplunchetc= document.getElementById("miscexplunchetc")
        // let customsepoy= document.getElementById("customsepoy")
        // let weighbridge= document.getElementById("weighbridge")
        // let miscexpenses= document.getElementById("miscexpenses")
        // let agencychrgs= document.getElementById("agencychrgs")
        //  let otherchrgs= document.getElementById("otherchrgs")
        // let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        var insurance = document.getElementById("insurance");
        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            // calculateButton.disabled = true
            submitButton.disabled = true
        })
        // Calculate Bank Charges [ onblur ]
        // function calculateBankCharges()
        // {
        //     // var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) + parseFloat(otherchrgs.value)
        //     // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
        //     // banktotal.value = t.toFixed(2)
        //     // console.log(banktotal.value);
        // }
    </script>
@endpush

@push('scripts')
    <script>
        // var calculate = function()
        // {
        //     // calculateBankCharges()
        //     rcvIsMoreThenPending = []
        //     // alert(dynamicTable.getData())
        //     const data = dynamicTable.getData()
        //     //  Get Ratio after price/length/pcs update
        //     var amtinpkrtotal = 0
        //     data.forEach(e => {
        //         amtinpkrtotal += parseFloat(e.amtinpkr)
        //     });
        //     data.forEach(e => {
        //         //  make sure reciving is not more then pending
        //         if(e.pcs_rcv > e.pcs_pending || e.pcs_rcv === undefined)
        //         {
        //             showSnackbar("Rcv Pcs is Required & cannot be more then PCS","error");
        //             rcvIsMoreThenPending.push(true)
        //             return;
        //         }

        //         if(e.kg_rcv > e.gdswt_pending || e.kg_rcv === undefined)
        //         {
        //             showSnackbar("Rcv kg is Required & cannot be more then kg","error");
        //             rcvIsMoreThenPending.push(true)
        //             return;
        //         }

        //         var pcs = e.pcs
        //         var gdswt = e.gdswt
        //         var inkg = ((e.gdswt / e.pcs ) * 1000).toFixed(3)
        //         var length = e.length
        //         var gdsprice = e.gdsprice

        //         var bundle1 = e.bundle1
        //         var pcspbundle1 = e.pcspbundle1
        //         var bundle2 = e.bundle2
        //         var pcspbundle2 = e.pcspbundle2





        //         // var amtindollar = gdsprice * gdswt
        //         var amtindollar =  gdsprice * e.kg_rcv
        //         var amtinpkr = conversionrate.value * amtindollar
        //         var itmratio = amtinpkr / amtinpkrtotal * 100
        //         var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
        //         var amountwithoutinsurance = ( amtindollar + insuranceperitem ) * parseFloat(conversionrate.value)
        //         var onepercentdutypkr = amountwithoutinsurance * 0.01
        //         var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)

        //         var cda = e.cd * pricevaluecostsheet / 100
        //         var rda = e.rd * pricevaluecostsheet / 100
        //         var acda = e.acd * pricevaluecostsheet / 100
        //         var sta = (pricevaluecostsheet + cda + rda + acda) * e.st / 100
        //         var asta = (pricevaluecostsheet + cda + rda + acda) * e.ast / 100
        //         var ita =(pricevaluecostsheet + cda + sta + rda + acda + asta) * e.it / 100
        //         var wsca = (pricevaluecostsheet * e.wse) /100
        //         var total = cda + rda + sta + acda + asta + ita + wsca

        //         e.pcs = pcs
        //         e.gdswt = gdswt
        //         e.inkg = inkg
        //         e.length = length
        //         e.gdsprice = gdsprice

        //         e.bundle1 =     bundle1
        //         e.pcspbundle1 = pcspbundle1
        //         e.bundle2 =     bundle2
        //         e.pcspbundle2 = pcspbundle2







        //         e.amtindollar = amtindollar
        //         e.amtinpkr = amtinpkr
        //         e.itmratio = itmratio
        //         e.insuranceperitem = insuranceperitem
        //         e.amountwithoutinsurance = amountwithoutinsurance
        //         e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
        //         e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)

        //         e.cda = (cda).toFixed(2)
        //         e.rda = (rda).toFixed(2)
        //         e.acda = (acda).toFixed(2)
        //         e.sta = (sta).toFixed(2)
        //         e.asta = (asta).toFixed(2)
        //         e.ita = (ita).toFixed(2)
        //         e.wsca = (wsca).toFixed(2)
        //         e.total = (total).toFixed(2)
        //         e.perkg = perkg
        //         e.totallccostwexp = totallccostwexp
        //         e.perpc = perpc
        //         e.perft = (perpc / length )
        //          e.otherexpenses = e.otherexpenses
        //     })
        //     dynamicTable.setData(data)

        //     rcvIsMoreThenPending.forEach(e => {
        //         if(e === true)
        //         {
        //             submitButton.disabled = true
        //         }
        //     })
        //     if(rcvIsMoreThenPending.length <= 0)
        //     {
        //         submitButton.disabled = false
        //     }
        // }
        //  Dynamic Table [User data]

        /// NEW CODING #############################3
 var calculate = function(){

if(dunitid.value <= 0)
    {
        showSnackbar("Please select Duty Unit","error");
        dunitid.focus();
        return;
    }
    if(conversionrate.value <= 0)
    {
        showSnackbar("conversionrate must be greater than 0","error");
        conversionrate.focus();
        return;
    }

    if(gdno.value === '' )
    {
        showSnackbar("GD # required ","error");
        gdno.focus();
        return;
    }

// calculateBankCharges()
//  console.log($unt)
// alert(dynamicTable.getData())
// const data = dynamicTable.getData()
// Get Selected HSCode Value
// var hscode;
//  First Iteration to calculate Basic Data
data.forEach(e => {



    var bundle1 = e.bundle1
    var pcspbundle1 = e.pcspbundle1
    var bundle2 = e.bundle2
    var pcspbundle2 = e.pcspbundle2


    var pcs = e.pcs
    var gdswt = e.gdswt
    var dutygdswt = e.dutygdswt
    var hscode = e.hscode

    var cd = e.cd
    var st = e.st
    var rd = e.rd
    var acd = e.acd
    var ast = e.ast
    var it = e.it
    var wse = e.wse

    var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
    var length = e.length
    var gdsprice = e.gdsprice
    var dtyrate = e.dtyrate
    var invsrate = e.invsrate
    var totpcs = e.totpcs
    var amtindollar=e.amtindollar
    // var dtyamtinpkr=e.dtyamtinpkr
    // var comamtinpkr=e.comamtinpkr

     var dutval=e.dutval
    // var purval=e.purval
    // var comval=e.comval


    e.bundle1 =     bundle1
    e.pcspbundle1 = pcspbundle1
    e.bundle2 =     bundle2
    e.pcspbundle2 = pcspbundle2
    e.amtindollar =amtindollar



     e.pcs = pcs
     e.gdswt = gdswt
     e.inkg = inkg
     e.length = length
     e.dutygdswt=dutygdswt
     e.hscode=hscode

     e.cd =     cd
     e.st =     st
     e.rd =     rd
     e.acd =    acd
     e.ast =    ast
     e.it =     it
     e.wse =    wse
     e.gdsprice = gdsprice
     e.dtyrate = dtyrate
    //  e.purval=purval
     e.dutval=dutval
    //  e.comval=comval
    //  e.amtinpkr=amtinpkr
    //  e.dtyamtinpkr=dtyamtinpkr
    //  e.comamtinpkr=comamtinpkr

    //  console.log(e.dtyrate)

var sid = document.getElementById("dunitid");
var dunitid = sid.options[sid.selectedIndex];


if(dunitid.value==1)
       {
            e.amtindollar = parseFloat(e.gdswt) * parseFloat(e.gdsprice)
       }
     else
         {
             e.amtindollar = parseFloat(e.pcs) * parseFloat(e.gdsprice)
        }
    // if(e.sku_id==1)
    //    {
    //         // e.dutval = parseFloat(e.dutygdswt) * parseFloat(e.dtyrate)
    //         e.purval = parseFloat(e.gdswt) * parseFloat(e.gdsprice)
    //         // e.comval = parseFloat(e.gdswt) * parseFloat(e.invsrate)
    //    }
    //  else
    //      {
    //         //  e.dutval = parseFloat(e.pcs) * parseFloat(e.dtyrate)
    //          e.purval = parseFloat(e.pcs) * parseFloat(e.gdsprice)
    //          e.comval = parseFloat(e.pcs) * parseFloat(e.invsrate)
    //     }
            // e.amtindollar=e.purval
                    //  e.amtindollar=e.dutval
            // e.dtyamtindollar=e.dtyamtindollar
            // e.comamtindollar=e.comval

            // e.amtinpkr=e.amtindollar * sconversionrate.value
            e.amtinpkr=e.amtindollar * conversionrate.value
            // e.comamtinpkr=e.comamtindollar * conversionrate.value

    // console.log(e.dtyamtinpkr)








    //   break
    ////////////////////////////////////////////////////////////////////////
    // Get Values of HSCode Selected in List and Populate Data
    ///////////////////////////////////////////////////////////////////////
                // hscode = hscodes.find(  function(el) { return el.hscode === e.hscode })
    // e.cd = hscode.cd
    // e.st = hscode.st
    // e.rd = hscode.rd
    // e.acd = hscode.acd
    // e.ast = hscode.ast
    // e.it = hscode.it
    // e.wsc = hscode.wse

                    // var cd = hscode.cd
                    // var st = hscode.st
                    // var rd = hscode.rd
                    // var acd = hscode.acd
                    // var ast = hscode.ast
                    // var it = hscode.it
    // var wse = wse


                        // e.cd=cd
                        // e.st=st
                        // e.rd=rd
                        // e.acd=acd
                        // e.ast=ast
                        // e.it=it
    // e.wse=wse
})

//  Get Ratio after price/length/pcs update
var amtinpkrtotal = 0
// var amtinpkrtotal = 0

data.forEach(e => {
    // amtinpkrtotal += parseFloat(e.amtinpkr)
    amtinpkrtotal += parseFloat(e.amtinpkr)
});

data.forEach(e => {

    var amtinpkr = parseFloat(conversionrate.value) * parseFloat(e.dutval)
    var itmratio = (( parseFloat(e.amtinpkr) / parseFloat(amtinpkrtotal) ) * 100).toFixed(2)
    var insuranceperitem =  ( parseFloat(insurance.value) * itmratio / 100 ).toFixed(2)
    var dtyinsuranceperitemrs = ( ( parseFloat(insurance.value) * itmratio / 100 ) * conversionrate.value ).toFixed(0)
    var amountwithoutinsurance = ( parseFloat(e.amtindollar) + parseFloat(insuranceperitem) ) * parseFloat(conversionrate.value)
    var onepercentdutypkr = amountwithoutinsurance * 0.01
    var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)
    var cda = parseFloat(e.cd) * pricevaluecostsheet / 100
    var rda = parseFloat(e.rd) * pricevaluecostsheet / 100
    var acda = parseFloat(e.acd) * pricevaluecostsheet / 100
    var sta = (pricevaluecostsheet + cda + rda + acda) * parseFloat(e.st) / 100
    var asta = (pricevaluecostsheet + cda + rda + acda) * parseFloat(e.ast) / 100
    var ita =(pricevaluecostsheet + cda + sta + rda + acda + asta) * parseFloat(e.it) / 100
    var wsca = (pricevaluecostsheet * parseFloat(e.wse)) /100
    var total = cda + rda + sta + acda + asta + ita

    e.amtindollar = e.amtindollar
    e.itmratio = itmratio
    e.insuranceperitem = insuranceperitem
    e.dtyinsuranceperitemrs = dtyinsuranceperitemrs

    e.amountwithoutinsurance = amountwithoutinsurance
    e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
    e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)
    e.cda = (cda).toFixed(2)
    e.rda = (rda).toFixed(2)
    e.acda = (acda).toFixed(2)
    e.sta = (sta).toFixed(2)
    e.asta = (asta).toFixed(2)
    e.ita = (ita).toFixed(2)
    e.wsca = (wsca).toFixed(2)
    e.total = (total).toFixed(2)
})
dynamicTable.setData(data)
submitButton.disabled = false
}


var headerMenu = function(){
    var menu = [];
    var columns = this.getColumns();

    for(let column of columns){

        //create checkbox element using font awesome icons
        let icon = document.createElement("i");
        icon.classList.add("fas");
        icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

        //build label
        let label = document.createElement("span");
        let title = document.createElement("span");

        title.textContent = " " + column.getDefinition().title;

        label.appendChild(icon);
        label.appendChild(title);

        //create menu item
        menu.push({
            label:label,
            action:function(e){
                //prevent menu closing
                e.stopPropagation();

                //toggle current column visibility
                column.toggle();

                //change menu item icon
                if(column.isVisible()){
                    icon.classList.remove("fa-square");
                    icon.classList.add("fa-check-square");
                }else{
                    icon.classList.remove("fa-check-square");
                    icon.classList.add("fa-square");
                }
            }
        });
    }

   return menu;
};

var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var row = cell.getRow();
        row.update({
             "pcs": sum,
            // "gdspricetot": sum2,
            // "gdspricedtytot":sum3

        });
    }




















// dynamicTable = new Tabulator("#dynamicTable", {
//             height:"450px",
//             width:"1000px",
//             layout:'fitDataTable',
//             responsiveLayout:"collapse",
//             ajaxParams: function(){
//                 return {id:cid, status:1};
//             },
//             ajaxURL: getDetails,
//             columns:[
//                 {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
//                     cellClick:function(e, cell){
//                         cell.getRow().delete();
//                     }
//                 },

//                 {title:"Id",           field:"id", visible:false},
//                 {title:"Packaging Type",     field:"packing",responsive:0},


//                 // {title:"Id",           field:"material_id", visible:false},
//                 // {title:"Material",     field:"material.title",responsive:0},
//                 // {title:"dimension",    field:"material.dimension",responsive:0,frozen:true, headerMenu:headerMenu},
//                 // {title:"Unit",         field:"material.sku",responsive:0},
//                 // {title:"Unitid",       field:"material.sku_id",visible:false},
//                 {title:"supplier_id",  field:"supplier_id",visible:false},
//                 // {title:"user_id",      field:"user_id",visible:false},
//                 // {title:"category_id",  field:"category_id",visible:false},
//                 // {title:"dimension_id", field:"dimension_id",visible:false},
//                 {
//                     title:'Quantity', headerHozAlign:"center",
//                     columns:[

//                     {   title:"HS code",headerHozAlign :'center',
//                             field:"hscode",
//                             // editor:"list",
//                             responsive:0,
//                             headerVertical:true,
//                             // cssClass:"bg-green-200 font-semibold",
//                             // editorParams:   {
//                             //     values:hscodeList,
//                             //     validator:["required"]
//                             // }
//                         },

//                         {   title:"Nos Of Bundles",headerHozAlign :'center',
//                             responsive:0,
//                             field:"bundle1",
//                             editor:"number",
//                             headerVertical:true,
//                             bottomCalc:"sum",
//                             formatter:"money",
//                             // cellEdited: updateValues,
//                             validator:["required","numeric"],
//                             cssClass:"bg-green-200 font-semibold",
//                             formatterParams:{thousand:",",precision:0},
//                         },

//                         // {   title:"Pcs/Bund",headerHozAlign :'center',
//                         //     responsive:0,
//                         //     field:"pcspbundle1",
//                         //     headerVertical:true,
//                         //     // bottomCalc:"sum",
//                         //     formatter:"money",
//                         //     cellEdited: updateValues,
//                         //     // cssClass:"bg-green-200 font-semibold",
//                         //     validator:["required","numeric"],
//                         //     formatterParams:{thousand:",",precision:0},
//                         // },

//                         // {   title:"Bundle2",headerHozAlign :'center',
//                         //     responsive:0,
//                         //     field:"bundle2",
//                         //     editor:"number",
//                         //     cellEdited: updateValues,
//                         //     headerVertical:true,
//                         //     bottomCalc:"sum",
//                         //     formatter:"money",
//                         //      cssClass:"bg-green-200 font-semibold",
//                         //     validator:["required","numeric"],
//                         //     formatterParams:{thousand:",",precision:0},
//                         // },

//                         // {   title:"Pcs/Bund",headerHozAlign :'center',
//                         //     responsive:0,
//                         //     field:"pcspbundle2",
//                         //     // editor:"number",
//                         //     headerVertical:true,
//                         //     cellEdited: updateValues,
//                         //     // bottomCalc:"sum",
//                         //     formatter:"money",
//                         //     // cssClass:"bg-green-200 font-semibold",
//                         //     validator:["required","numeric"],
//                         //     formatterParams:{thousand:",",precision:0},
//                         // },


//                     {   title:"Pcs",headerHozAlign :'center',
//                             responsive:0,
//                             field:"pcs",
//                             visible:false,
//                             headerVertical:true,
//                             bottomCalc:"sum",
//                             formatter:"money",
//                             formatterParams:{thousand:",",precision:0},
//                         },

//                         {   title:"Duty.Wt(Kg)",
//                             field:"gdswt",
//                             responsive:0,
//                             editor:"number",
//                             headerVertical:true,
//                             bottomCalc:"sum",
//                             formatter:"money",
//                             cssClass:"bg-green-200 font-semibold",
//                             validator:["required","numeric"],
//                             formatterParams:{thousand:",",precision:2},
//                         },

//                     ]
//                 },
//                 {
//                     title:'Price',
//                     columns:[
//                         {   title:"Duty.Price($)",
//                             editor:"number",
//                             field:"gdsprice",
//                             formatter:"money" ,
//                             responsive:0,
//                             headerVertical:true,
//                             validator:["required","numeric"],
//                             formatterParams:{thousand:",",precision:2}
//                         },
//                     ]
//                 },
//                 {
//                     title:'Amount', headerHozAlign:"center",
//                     columns:[
//                         {   title:"Duty.Val($)",
//                             field:"amtindollar",
//                             responsive:0,
//                             formatter:"money",
//                             bottomCalc:"sum",
//                             bottomCalcFormatter:"money",
//                             formatterParams:{thousand:",",precision:0},
//                         },
//                         {   title:"Duty.Val(Rs)",
//                             field:"amtinpkr",
//                             formatter:"money",
//                             responsive:0,
//                             bottomCalc:"sum",
//                             bottomCalcFormatter:"money",
//                             formatterParams:{thousand:",",precision:0},
//                         },

//                         {   title:"Item Ratio(%)",
//                             field:"itmratio",
//                             responsive:0,
//                             headerVertical:true,
//                             formatter:"money",
//                             formatterParams:{thousand:",",precision:2},
//                         },


//                         {
//                     title:"Insurance/Item($)",
//                     field:"insuranceperitem",
//                     headerVertical:true,
//                     bottomCalc:"sum",
//                     formatterParams:{thousand:",",precision:0},
//                     responsive:0,
//                     formatter:"money",
//                 },
//                 {
//                     title:"Insurance/Item(Rs)",
//                     field:"dtyinsuranceperitemrs",
//                     headerVertical:true,
//                     bottomCalc:"sum",
//                     formatterParams:{thousand:",",precision:0},
//                     responsive:0,
//                     formatter:"money",
//                     formatterParams:{thousand:",",precision:0},
//                 },

//                 {
//                     title:"Amt W/Insurance (Rs)",
//                     field:"amountwithoutinsurance",
//                     responsive:0,
//                     bottomCalc:"sum",bottomCalcParams:{precision:0},
//                     headerVertical:true,
//                     formatter:"money",
//                     formatterParams:{thousand:",",precision:0},
//                 },


//                 {
//                     title:"1% Duty (PKR)",
//                     field:"onepercentdutypkr",
//                     bottomCalc:"sum",bottomCalcParams:{precision:0},
//                     formatterParams:{thousand:",",precision:0},
//                     responsive:0,
//                     headerVertical:true,
//                     formatter:"money",
//                 },

//                     ]
//                 },

//                 // {
//                 //     title:"Price value (CS)",
//                 //     headerVertical:true,
//                 //     field:"pricevaluecostsheet",
//                 //     formatter:"money",
//                 //     formatterParams:{thousand:",",precision:2},
//                 // },
//                 // {
//                 //     title:'Duties Rate', headerHozAlign:"center",
//                 //     columns:[
//                 //         {title:"Code",              field:"material.hscodes.hscode",
//                 //         headerVertical:true,       visible:false},
//                 //         {title:"CD",                field:"material.hscodes.cd",
//                 //         headerVertical:true,        visible:false},
//                 //         {title:"ST",                field:"material.hscodes.st",
//                 //         headerVertical:true,          visible:false},
//                 //         {title:"RD",                field:"material.hscodes.rd",
//                 //         headerVertical:true,        visible:false},
//                 //         {title:"ACD",               field:"material.hscodes.acd",
//                 //         headerVertical:true,          visible:false},
//                 //         {title:"AST",               field:"material.hscodes.ast",
//                 //         headerVertical:true,        visible:false},
//                 //         {title:"IT",                field:"material.hscodes.it",
//                 //         headerVertical:true,        visible:false},
//                 //         {title:"WSC",               field:"material.hscodes.wsc",
//                 //         headerVertical:true,         visible:false},
//                 //     ]
//                 // },
//                 {
//                     title:'Duties Amount (PKR)', headerHozAlign:"center",
//                     columns:[
//                         {title:"CD",                field:"cda",bottomCalc:"sum",bottomCalcParams:{precision:0}, formatter:"money",
//                     formatterParams:{thousand:",",precision:0},             responsive:0},
//                         {title:"ST",                field:"sta",bottomCalc:"sum",bottomCalcParams:{precision:0},formatter:"money",
//                     formatterParams:{thousand:",",precision:0},             responsive:0},
//                         {title:"RD",                field:"rda",bottomCalc:"sum",bottomCalcParams:{precision:0}, formatter:"money",
//                     formatterParams:{thousand:",",precision:0},             responsive:0},
//                         {title:"ACD",               field:"acda",bottomCalc:"sum",bottomCalcParams:{precision:0}, formatter:"money",
//                     formatterParams:{thousand:",",precision:0},            responsive:0},
//                         {title:"AST",               field:"asta",bottomCalc:"sum",bottomCalcParams:{precision:0},  formatter:"money",
//                     formatterParams:{thousand:",",precision:0},           responsive:0},
//                         {title:"IT",                field:"ita",bottomCalc:"sum",bottomCalcParams:{precision:0},  formatter:"money",
//                     // formatterParams:{thousand:",",precision:0},            responsive:0},
//                     //     {title:"WSC",               field:"wsca",bottomCalc:"sum",bottomCalcParams:{precision:0},  formatter:"money",
//                     formatterParams:{thousand:",",precision:0},           responsive:0},
//                         {title:"Total",             field:"total",bottomCalc:"sum",bottomCalcParams:{precision:0},   formatter:"money",
//                     formatterParams:{thousand:",",precision:0},bottomCalc:"sum",bottomCalcParams:{precision:0},          responsive:0},
//                     ]
//                 },

//                 {title:"CD",                field:"cd",editor:"number",responsive:0,
//                 headerVertical:true,        visible:true},
//                 {title:"ST",                field:"st",editor:"number",responsive:0,
//                 headerVertical:true,          visible:true},
//                 {title:"RD",                field:"rd",editor:"number",responsive:0,
//                 headerVertical:true,        visible:true},
//                 {title:"ACD",               field:"acd",editor:"number",responsive:0,
//                 headerVertical:true,          visible:true},
//                 {title:"AST",               field:"ast",editor:"number",responsive:0,
//                 headerVertical:true,        visible:true},
//                 {title:"IT",                field:"it",editor:"number",responsive:0,
//                 headerVertical:true,        visible:true},












//                 // {
//                 //     title:"Total LC Cost W/InvsExp",
//                 //     headerVertical:true,
//                 //     field:"totallccostwexp",
//                 //     responsive:0,
//                 //     formatter:"money",
//                 //     formatterParams:{thousand:",",precision:2},
//                 // },
//                 // {
//                 //     title:'Cost Rate/Unit', headerHozAlign:"center",
//                 //     columns:[
//                 //         {title:"Per Pc",    field:"perpc",          responsive:0 ,formatter:"money",
//                 //     formatterParams:{thousand:",",precision:2}, },
//                 //         {title:"Per Kg",    field:"perkg",          responsive:0 , formatter:"money",
//                 //     formatterParams:{thousand:",",precision:2}, },
//                 //         {title:"Per Feet",  field:"perft",        responsive:0 ,formatter:"money",
//                 //     formatterParams:{thousand:",",precision:2}, },

//                 //     ]
//                 // },
//             ],
//             ajaxResponse:function(getDetails, params, response){
//                 return response.data;
//             },
//         })
        // Validation & Post
        function validateForm()
        {
            var invoicedate = document.getElementById("invoicedate")
            var invoiceno = document.getElementById("invoiceno")
            var machineno = document.getElementById("machineno")
            var machine_date = document.getElementById("machine_date")
            var gdno = document.getElementById("gdno")
            var gd_date = document.getElementById("gd_date")
            var cheque_date = document.getElementById("cheque_date")
            var cheque_no = document.getElementById("cheque_no")

            var sid = document.getElementById("bank_id");
            var bank_id = sid.options[sid.selectedIndex];

            if(bank_id.value <= 0)
            {
                showSnackbar("Please select From Bank");
                bank_id.focus();
                return;
            }



            if(gdno.value === ''){
                showSnackbar("gdno # required ","error");
                gdno.focus()
                return
            }
            // const dynamicTableData = dynamicTable.getData();
            // if(dynamicTableData.length == 0)
            // {
            //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
            //     return;
            // }

            // disableSubmitButton(true);
            var data = {
                'commercial_invoice_id':@json($clearance->commercial_invoice_id),
                'clearance_id':@json($clearance->id),
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'invoiceno' : invoiceno.value,
                'machineno' : machineno.value,
                'machine_date' :machine_date.value,
                'gdno' : gdno.value,
                'gd_date' :gd_date.value,
                'dunitid' : dunitid.value,
                'cheque_no' : cheque_no.value,
                'cheque_date' :cheque_date.value,

                'bank_id' :bank_id.value,

                'invoicedate' : invoicedate.value,
                'cominvsid':cominvsid.value,
                // 'bankcharges' : parseFloat(bankcharges.value).toFixed(2),
                // 'collofcustom' : parseFloat(collofcustom.value).toFixed(2),
                // 'exataxoffie' : parseFloat(exataxoffie.value).toFixed(2),
                // 'lngnshipdochrgs' : parseFloat(lngnshipdochrgs.value).toFixed(2),
                // 'localcartage' : parseFloat(localcartage.value).toFixed(2),
                // 'miscexplunchetc' : parseFloat(miscexplunchetc.value).toFixed(2),
                // 'customsepoy' : parseFloat(customsepoy.value).toFixed(2),
                // 'weighbridge' : parseFloat(weighbridge.value).toFixed(2),
                // 'miscexpenses' : parseFloat(miscexpenses.value).toFixed(2),
                // 'agencychrgs' : parseFloat(agencychrgs.value).toFixed(2),
                //  'otherchrgs' : parseFloat(otherchrgs.value).toFixed(2),
                // 'total' : parseFloat(banktotal.value).toFixed(2),
                'dutyclearance' : dynamicTableData
            };
            // All Ok - Proceed
            fetch(@json(route('clearance.del')),{
                credentials: 'same-origin', // 'include', default: 'omit'
                method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
                // body: formData, // Coordinate the body type with 'Content-Type'
                body:JSON.stringify(data),
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
                    window.open(window.location.origin + "/clearance","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

     edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitbutton").disabled = false;

    }
    else
    {document.getElementById("submitbutton").disabled = true;}

    }









</script>
@endpush

</x-app-layout>
