<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Goods Receive Note (Local)
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm  sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">

                                {{-- <label for="customer_id">Customer<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                        @endforeach
                                    </select> --}}
                                <x-input-text title="Supplier Name" name="supname" id="supname" req required class="col-span-2" disabled  />
                                <x-input-text title="Purchase.Invoice id" name="contract_id" id="contract_id"  disabled  />
                                <x-input-date title="Purchase.Invoice Date" id="contract_date" name="contract_date"  disabled />
                                <x-input-text title="Purchase.Invice#" id="continvsno" name="continvsno"   disabled />

                                {{-- <x-input-date title="Receiving Date" name="purdate" id="purdate"    /> --}}
                                {{-- <x-input-text title="P.R No" name="prno" id="prno" req required class="col-span-2" disabled  /> --}}

                            </div>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">
                                <x-input-date title="G.R Date" id="purdate" name="purdate"  />
                                {{-- <x-input-text title="G.R #" name="purinvsno" class="col-span-2" hidden    /> --}}
                                <x-input-text title="G.R #" name="purseqid" id="purseqid" value="{{$maxpurseqid}}"   />
                                {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" > --}}

                                {{-- <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{$maxpurseqid}}"    placeholder="poseqno" required   /> --}}


                                <label for="">
                                    Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                                <textarea name="remarks" id="remarks" cols="10" rows="2" maxlength="200" class="col-span-2" class="rounded"></textarea>

                            </div>

                        </fieldset>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Discou(%)" name="discntper" id="discntper" disabled    />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt"   />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" disabled />
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
                            </div>
                        </fieldset> --}}

                        <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>

                            {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" title="W/Qutation" type="checkbox" value="checked" name="woq" id="woq"   > --}}
                        </div>



                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" type="button" onclick="validateForm()">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
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
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


        // var getMaster = @json(route('custorders.quotations')) ;
        const getMaster = @json(route('purinvs.master'));
        const getDetails = @json(route('purinvs.detail'));
         let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        // let contract_id = '';
        let supplier_id = 0;


        // let prno= document.getElementById("prno")
        document.addEventListener('DOMContentLoaded',()=>{
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){

                if(!adopted)
                {
                    // if (document.getElementById("woq").checked) {
                    //     var getMaster = @json(route('custorders.quotations')) ;
                        showModal()
                    // }else {
                    //     var getMaster = @json(route('materials.master')) ;
                    //     showModal()
                    // }
                }
            }
        })
    </script>
@endpush

@push('scripts')
    <script>



        // window.onload = function() {
        //     var input = document.getElementById("pono.focus").focus();
        // }

        // -----------------FOR MODAL -------------------------------//
        function showModal(){ modal.style.display = "block"}
        function closeModal(){ modal.style.display = "none"}
        //  When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        //  Table Filter
        function dataFilter(element)
        {
            searchValue = element.value;
            table.setData(getMaster,{search:searchValue});
        }
        //  The Table for Materials Modal
        table = new Tabulator("#tableData", {
            width:"1000px",
            height:"600px",
            autoResize:true,
            responsiveLayout:"collapse",
            // layout:"fitData",
            layout:'fitDataTable',

            index:"id",
            placeholder:"No Data Available",
            pagination:true,
            paginationMode:"remote",
            sortMode:"remote",
            filterMode:"remote",
            paginationSize:10,
            paginationSizeSelector:[10,25,50,100],
            ajaxParams: function(){
                return {search:searchValue};
            },
            ajaxURL: getMaster,
            ajaxContentType:"json",
            initialSort:[ {column:"id", dir:"asc"} ],

             columns:[

             {
                 title:'Contract Description', headerHozAlign:"center",
                 columns:[

                // {title:"InvsType", field:"InvsDescr" , responsive:0},
                {title:"Id", field:"id" , responsive:0},
                {title:"Invoice #", field:"invoiceno" , visible:true ,headerSort:false, responsive:0},
                {title:"Date", field:"invoice_date" , visible:true ,headerSort:false, responsive:0},
                {title:"Supplier", field:"supname", visible:true ,headerSort:false, responsive:0},
             ]},


             {
                 title:'Contract Data', headerHozAlign:"center",
                 columns:[
                {title:"Weight", field:"tweight" , visible:true ,headerSort:false, responsive:0},
                {title:"TotalPcs", field:"ttotalpcs" , visible:true ,headerSort:false, responsive:0},
             ]},

             {
                 title:'Pending Data', headerHozAlign:"center",
                 columns:[
                 {title:"Weight", field:"pweight" , visible:true ,headerSort:false, responsive:0},
                 {title:"TotalPcs", field:"ptotalpcs" , visible:true ,headerSort:false, responsive:0},
             ]},





           ],
        // },
            // Extra Pagination Data for End Users
            ajaxResponse:function(getDataUrl, params, response){
                remaining = response.total;
                let doc = document.getElementById("example-table-info");
                doc.classList.add('font-weight-bold');
                doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
                return response;
            }
        })
        //  Adds New row to dynamicTable
        table.on('rowClick',function(e,row){
            var simple = {...row}
            var data = simple._row.data

            // Fill Master Data
            supplier_id=data.supid
            contract_id.value =data.id
            continvsno.value=data.invoiceno
            contract_date.value=data.invoice_date
            supname.value=data.supname
            // purinvsno.value=data.invoiceno


            // quotation_id = data.id
            // qutdate.value=data.qutdate
            // supplier_id=data.supplier_id
            // prno.value = data.prno
            // qutno.value = data.qutno
            // discntper.value=data.discntper
            // supname.value=data.supname


            // discntper.value=data.discntper
            // discntamt.value=data.discntamt
            // cartage.value=data.cartage

            // saletaxper.value=data.saletaxper
            // saletaxamt.value=data.saletaxamt
            // rcvblamount.value=data.rcvblamount
            // totrcvbamount.value=data.totrcvbamount
            detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
            calculateButton.disabled = false
            closeModal()
        })
    </script>
@endpush

@push('scripts')
    <script>

        //  ------------------Dynamic Table----------------------//
        async function fetchDataFromServer(url)
        {
            var data =  await fetch(url,{
                method:"GET",
                headers: { 'Accept':'application/json','Content-type':'application/json'},
                })
                .then((response) => response.json()) //Transform data to json
                .then(function(response){
                    // console.log(response);
                    return response;
                })
                .catch(function(error){
                    console.log("Error : " + error);
            })
            //  Stremaline Data for Tabulator
            for (let index = 0; index < data.length; index++) {

                const obj = data[index];
                const mat = obj['material']
                var vpcs = obj.totpcs

                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {
                        id :                obj.id,
                        material_title :    obj.material_title,
                        material_id :       obj.material_id,
                        supplier_id :       obj.supid,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,
                        dimension_id :      obj.dimension_id,
                        dimension :         obj.dimension,
                        brand :             '',
                        repname :           obj.repname,
                         totpcs :            obj.totpcs ,
                         gdswt   :           obj.gdswt,
                         qtyinfeet:          obj.balqtyinfeet,
                         purpcse13:          obj.totpcs,
                         purwte13:           obj.gdswt,
                         length:0,
                         purfeete13:         obj.balqtyinfeet,

                        //  dtyrate:            obj.dtyrate,
                         gdsprice:            obj.gdsprice,
                        //  invsrate:            obj.invsrate,
                        //  purval:            obj.purval,
                        //  dutval:            obj.dutval,
                        //  bundle1:            obj.bundle1,
                        //  bundle2:            obj.bundle2,


                        purpcstot:obj.totpcs,purwttot:obj.gdswt,purfeettot:obj.balqtyinfeet,

                        purwtgn2:0,purpcsgn2:0,purfeetgn2:0,
                        purwtams:0,purpcsams:0,purfeetams:0,
                        purwte24:0,purpcse24:0,purfeete24:0,
                        purwtbs:0,purpcsbs:0,purfeetbs:0,
                        purwtoth:0,purpcsoth:0,purfeetoth:0

                    }
                ])
            }
        }



        //  Dynamic Table [User data]


        var rowMenu = [
    {
        label:"<i class='fas fa-user'></i> Change Name",
        action:function(e, row){
            row.update({name:"Steve Bobberson"});
        }
    },
    {
        label:"<i class='fas fa-check-square'></i> Select Row",
        action:function(e, row){
            row.select();
        }
    },
    {
        separator:true,
    },
    {
        label:"Admin Functions",
        menu:[
            {
                label:"<i class='fas fa-trash'></i> Delete Row",
                action:function(e, row){
                    row.delete();
                }
            },
            {
                label:"<i class='fas fa-ban'></i> Disabled Option",
                disabled:true,
            },
        ]
    }
]

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

var tamount=0;
    function tnetamount()
        {
            //  discntamt.value=0;
            //  rcvblamount.value=0;
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // if (discntper.disabled)
            // {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            // if (!discntper.disabled)
            // {discntamt.value=(tamount*discntper.value/100).toFixed(0);};

            // rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

var updateValues = (cell) => {
        var data = cell.getData();


        // For Feet
        // var e13ft=Number(data.purpcse13)*Number(data.length)
        // var gn2ft=Number(data.purpcsgn2)*Number(data.length)
        // var amsft=Number(data.purpcsams)*Number(data.length)
        // var e24ft=Number(data.purpcse24)*Number(data.length)
        // var bsft=Number(data.purpcsbs)*Number(data.length)
        // var othft=Number(data.purpcsoth)*Number(data.length)

        // var e13wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcse13)
        // var gn2wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsgn2)
        // var amswt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsams)
        // var e24wt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcse24)
        // var bswt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsbs)
        // var othwt=Number(data.gdswt)/(Number(data.totpcs))*Number(data.purpcsoth)


        var sumpcs=Number(data.purpcse13)+Number(data.purpcsgn2)+Number(data.purpcsams)+Number(data.purpcse24)+Number(data.purpcsbs)+Number(data.purpcsoth)
        var sumwt=Number(data.purwte13)+Number(data.purwtgn2)+Number(data.purwtams)+Number(data.purwte24)+Number(data.purwtbs)+Number(data.purwtoth)
        var sumfeet=Number(data.purfeete13)+Number(data.purfeetgn2)+Number(data.purfeetams)+Number(data.purfeete24)+Number(data.purfeetbs)+Number(data.purfeetoth)

        //  var e13pcst= sumpcs - Number(data.purpcstot)
        //  console.info(e13pcst)

        var row = cell.getRow();
        row.update({
            //  "purfeete13": e13ft,
            //  "purfeetgn2": gn2ft,
            //  "purfeetams": amsft,
            //  "purfeetbs": bsft,
            //  "purfeete24": e24ft,
            //  "purfeetoth": othft,

            //  "purwte13":e13wt,
            //  "purwtgn2":gn2wt,
            //  "purwtams":amswt,
            //  "purwte24":e24wt,
            //  "purwtbs":bswt,
            //  "purwtoth":othwt,

             "purpcstot":sumpcs,
             "purwttot":sumwt,
             "purfeettot":sumfeet,


            //  "purpcse13":e13pcst
            // "purfeete13":e13feett,
            //   totalVal: e13ft

        });
    }

    var totalVal = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        tamount = calc;
        // tnetamount();
        return calc;

    }




        dynamicTable = new Tabulator("#dynamicTable", {
            height:"350px",
            width:"1000px",
            rowContextMenu: rowMenu,
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            // movableRows:true,
            // groupBy:"material_title",
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"S.No",            field:"sno", formatter:"rownum",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Id",           field:"id", visible:false,cssClass:"bg-gray-200 font-semibold"},
                {title:"Material Name", field:"material_title",responsive:0,cssClass:"bg-gray-200 font-semibold"},
                {title:"Material Size",    field:"dimension",cssClass:"bg-gray-200 font-semibold",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"UOM",         field:"sku",responsive:0, hozAlign:"center",cssClass:"bg-gray-200 font-semibold"},
                {title:"Unitid",       field:"sku_id",visible:false},

                {
                    title:'Contracts Data', headerHozAlign:"center",
                    columns:[
                        // {   title:"Replace Name",headerHozAlign :'center',field:"repname",responsive:0,editor:true},
                        // {   title:"Brand",headerHozAlign :'center',field:"mybrand",responsive:0,editor:true},
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"totpcs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"gdswt",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"QtyInFeet",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"qtyinfeet",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-gray-200 font-semibold",formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},


                        ]},

                {title:"Replace Description",field:"repname",responsive:0, editor:true},
                {title:"Brand",              field:"brand",responsive:0, editor:true},
                // {   title:"length",headerHozAlign :'right',hozAlign:"right",cellEdited: updateValues,editor:true,responsive:0,field:"length",bottomCalc:"sum"},



                {title:"dimension_id", field:"dimension_id",visible:false},
                {
                    title:'E-13', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcse13",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwte13",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},

                            {   title:"Feet",editor:true,editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeete13",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        ]},

                        {
                    title:'GALI NO 2', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsgn2",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetgn2",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                    title:'A.MALIK SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsams",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetams",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'E-24', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcse24",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwte24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeete24",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'BOLTON SHOP', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsbs",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetbs",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                       {
                        title:'OTHERS', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",visible:false,editor:true,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcsoth",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",editor:true,visible:false,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwtoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",editor:true,visible:false,headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeetoth",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],formatterParams:{thousand:",",precision:0}}
                        ]},

                        {
                        title:'TOTAL', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purpcstot",bottomCalc:"sum",
                                        formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}},
                        {   title:"Weight",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purwttot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}, bottomCalcParams:{precision:2}},
                            {   title:"Feet",headerHozAlign :'right',hozAlign:"right",responsive:0,field:"purfeettot",bottomCalc:"sum",
                            formatter:"money",cellEdited: updateValues,validator:["required","numeric"],cssClass:"bg-green-200 font-semibold",formatterParams:{thousand:",",precision:0}}
                        ]},
                        // {title:"dtyrate",           field:"dtyrate", visible:false},
                        // {title:"gdsprice",           field:"gdsprice", visible:false},
                        // {title:"invsrate",           field:"invsrate", visible:false},
                        // {title:"bundle1",           field:"bundle1", visible:false},
                        // {title:"bundle2",           field:"bundle2", visible:false},

                        // dtyrate,gdsprice,invsrate,purval,dutval,bundle1,bundle2
                        // {title:"Sale Amount",
                        // headerHozAlign :'right',
                        // hozAlign:"right",
                        // field:"saleamnt",
                        // cssClass:"bg-gray-200 font-semibold",
                        // formatter:"money",
                        // cssClass:"bg-green-200 font-semibold",
                        // formatterParams:{thousand:",",precision:3},
                        // formatter:function(cell,row)
                        // {
                        //     return (cell.getData().saleqty * cell.getData().price).toFixed(0)
                        // },
                        // bottomCalc:totalVal  },





            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {

            //  var purinvsno = document.getElementById("purinvsno")
            // var poseqno = document.getElementById("poseqno")
            var per= document.getElementById("per");

            // if(purinvsno.value === '')
            // {
            //     showSnackbar("Invoice No Required","error");
            //     purinvsno.focus();
            //     return;
            // }








            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

             for (let index = 0; index < dynamicTableData.length; index++) {
                 const element = dynamicTableData[index];

                 if(element.purpcstot>element.totpcs || element.purwttot>element.gdswt  )
                 {
                     showSnackbar("Purchase Data must be less than Contract Data","info");
                     return;
                 }
             }


            var data = { 'purchasingloc' : dynamicTableData,
        'supplier_id': supplier_id,'contract_id':contract_id.value,'contract_date':contract_date.value,'purseqid':purseqid.value,
                          'purdate':purdate.value,'continvsno':continvsno.value,'remarks':remarks.value      };

            // All Ok - Proceed
            fetch(@json(route('purchasingloc.store')),{
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
                    window.open(window.location.origin + "/purchasingloc","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

        function EnableDisableTextBox(per) {
        var purseqid = document.getElementById("purseqid");
        purseqid.disabled = per.checked ? false : true;
        purseqid.style.color ="black";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }



    // discntper.onblur=function(){
    // per=false
    // discntamt.value=(tamount*discntper.value/100).toFixed(0);
    //  tnetamount();
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);
// }

// discntamt.onblur=function(){
    // discntper.value=(discntamt.value/tamount*100).toFixed(2);
    //  tnetamount();
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);


// }
    </script>
@endpush

</x-app-layout>
