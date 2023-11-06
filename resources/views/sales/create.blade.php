<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Delivery Challan
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
                                <x-input-text title="Customer Name" name="custname" id="custname" req required class="col-span-2" disabled  />
                                <x-input-text title="P.O No" name="pono" id="pono" req required class="col-span-2" disabled  />
                                <x-input-date title="P.O Date" name="podate" id="podate" req required class="col-span-2" disabled  />
                                <x-input-text title="G.Pass No" name="gpno" id="gpno" value="{{$maxgpno}}"     required   />
                            </div>
                            <div class="grid grid-cols-12 gap-1 py-2 items-center">
                                <x-input-date title="Deilivery Date" id="deliverydt" name="deliverydt" req required class="col-span-2" />
                                <x-input-text title="DC No" name="dcno" id="dcno" value="{{$maxdcno}}"     required   />
                                <x-input-text title="Bill No" name="billno" id="billno" value="{{$maxbillno}}"     required   />
                                {{-- <label for="">
                                    Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                                <textarea name="remarks" id="remarks" cols="100" rows="2" maxlength="150" required class="rounded"></textarea> --}}
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            {{-- <legend>Invoice Level Expenses</legend> --}}
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
                        </fieldset>

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

<x-tabulator-modal title="Pending Sale Order" />

@push('scripts')
    <script>

        const locations = @json($locations);
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})

        });





        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


             const getMaster = @json(route('sales.custplan')) ;
             const getDetails = @json(route('sales.custplandtl'));

            //  if (document.getElementById("woq").checked)

            //     {

            //         var getMaster = @json(route('custorders.quotations')) ;
            //             var getDetails = @json(route('custorders.quotationsdtl'));

            //         var abc = "checkbox is TRU'))";
            //         } else {
            //         var getMaster = @json(route('custorders.quotations')) ;
            //             var getDetails = @json(route('custorders.quotationsdtl'));
            //         var abc = "checkbox is FALSE";
            //         }

            //         console.log(abc)


        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let custplan_id = '';
        let customer_id = '';


        // let prno= document.getElementById("prno")
        document.addEventListener('DOMContentLoaded',()=>{
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){

                if(!adopted)
                {
                    showModal()
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
            width:"1200px",
            height:"600px",
            // autoResize:true,
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
            initialSort:[ {column:"id", dir:"desc"} ],

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Customer", field:"custname" , responsive:0},
                {title:"P.O Date", field:"podated" , responsive:0},
                {title:"P.O No", field:"pono" , visible:true ,headerSort:false, responsive:0},
                {title:"Amount WO/GST", field:"rcvblamount" , visible:true ,headerSort:false,headerVertical:true,responsive:0},
                {title:"Amount W/GST", field:"totrcvbamount" , visible:true ,headerSort:false,headerVertical:true,responsive:0},
                {title:"Delivery Date", field:"deliverydtd", visible:true ,headerSort:false, responsive:0},
                {title:"Delivered", field:"delivered", visible:true ,headerSort:false, responsive:0},
                {title:"OrderBalance", field:"salbal", visible:true ,headerSort:false, responsive:0},

                // {title:"Valid Date", field:"valdate" , responsive:0},


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
            customer_id=data.customer_id
            custplan_id = data.id
            customer_id=data.customer_id
            pono.value = data.pono
            podate.value = data.podate
            deliverydt.value=data.deliverydt

        //    console.log(data.podate)
            discntper.value=data.discntper
            custname.value=data.custname


            discntper.value=data.discntper
            discntamt.value=data.discntamt
            cartage.value=data.cartage

            saletaxper.value=data.saletaxper
            saletaxamt.value=data.saletaxamt
            rcvblamount.value=data.rcvblamount
            totrcvbamount.value=data.totrcvbamount
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
                        custplan_id :      obj.custplan_id,
                        material_id :       obj.material_id,
                        customer_id :       obj.customer_id,
                        user_id :           obj.user_id,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,
                        // pono:               '',

                        dimension_id :      obj.dimension_id,
                        dimension :         obj.dimension,
                        mybrand :           obj.mybrand,
                        repname :           obj.repname,
                        qtykg :           obj.qtykg ,
                        qtypcs :           obj.qtypcs ,
                        qtyfeet :           obj.qtyfeet ,
                        balqty :            obj.balqty,
                        feedqty :            obj.feedqty,

                        sqtykg :           obj.sqtykg ,
                        sqtypcs :           obj.sqtypcs ,
                        sqtyfeet :           obj.sqtyfeet ,

                        totqty:             obj.totqty,
                        wtper:              obj.wtper,
                        pcper:              obj.pcper,
                        feetper:            obj.feetper,

                        salcostkg:          obj.salcostkg,
                        salcostpcs:          obj.salcostpcs,
                        salcostfeet:          obj.salcostfeet,


                        price   :           obj.price,
                        saleamnt:           obj.feedqty * obj.price,
                        unitconver:           1,

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

            if (discntper.disabled)
            {discntper.value=(discntamt.value/tamount*100).toFixed(2)};
            if (!discntper.disabled)
            {discntamt.value=(tamount*discntper.value/100).toFixed(0);};
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) ).toFixed(0)  ;
            saletaxamt.value=((Number(rcvblamount.value) * Number(saletaxper.value) )/100).toFixed(0) ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

var updateValues = (cell) => {
        var data = cell.getData();
        // var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
       // var sum = (Number(data.saleqty) * Number(data.price))

        if(cell.getData().sku_id==1)
         {

            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100

            var pr2=( pr1 / Number(data.wtper))*100
            qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(2)
            qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            // qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            qtykg=Number(data.sqtykg)


         }
         if(cell.getData().sku_id==2 || cell.getData().sku_id==6 )
         {
            // var sum = (Number(data.feedqty) * Number(data.price))
            // var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            // var pr2=( pr1 / Number(data.pcper))*100
            // qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            // qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            // qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(2)
            var sum = (Number(data.feedqty) * Number(data.price))
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.pcper))*100
            qtykg=(((pr2*Number(data.sqtykg))/100) * Number(data.unitconver)).toFixed(2)
            qtyfeet=(((pr2*Number(data.sqtyfeet))/100)* Number(data.unitconver)).toFixed(2)
            qtypcs=(Number(data.feedqty) * Number(data.unitconver))

         }

         if(cell.getData().sku_id==3)
         {
            var sum = (Number(data.feedqty) * Number(data.price))
            // var pr1=(Number(data.qtyfeet) / Number(data.totqty))*100
            var pr1=(Number(data.feedqty) / Number(data.totqty))*100
            var pr2=( pr1 / Number(data.feetper))*100
            qtykg=((pr2*Number(data.sqtykg))/100).toFixed(2)
            qtypcs=((pr2*Number(data.sqtypcs))/100).toFixed(2)
            // qtyfeet=((pr2*Number(data.sqtyfeet))/100).toFixed(2)
            qtyfeet=Number(data.sqtyfeet)

         }


        var row = cell.getRow();

        // if(cell.getData().sku_id==1)
        // {
        row.update({
            // "mybrand": pr2,
            "qtypcs":qtypcs,
            "qtyfeet":qtyfeet,
            "qtykg":qtykg,
            "saleamnt": sum,
            totalVal: sum,

        });
    // }

        // if(cell.getData().sku_id==2)
        // {
        // row.update({
        //     "saleamnt": sum,
        //     // "mybrand": pr2,
        //     // "qtypcs":qtypcs,
        //     "qtyfeet":qtyfeet,
        //     "qtykg":qtykg,
        //     totalVal: sum

        // });}

        // if(cell.getData().sku_id==3)
        // {
        // row.update({
        //     "saleamnt": sum,
        //     // "mybrand": pr2,
        //     "qtypcs":qtypcs,
        //     // "qtyfeet":qtyfeet,
        //     "qtykg":qtykg,
        //     totalVal: sum

        // });}



}


var totalVal = function(values, data, calcParams){
        var calc = 0;
        values.forEach(function(value){
            calc += Number(value) ;
        });
        tamount = calc;
        tnetamount();
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
                {title:"Id",           field:"id", visible:false},
                {title:"Material Name",     field:"material_title",responsive:0, cssClass:"bg-gray-200 font-semibold"},
                {title:"Material Size",    field:"dimension",cssClass:"bg-gray-200 font-semibold",responsive:0},
                // ,frozen:true, headerMenu:headerMenu,},
                {title:"UOM",         field:"sku",responsive:0, hozAlign:"center", cssClass:"bg-gray-200 font-semibold"},
                {title:"Unitid",       field:"sku_id",visible:false},
                // {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},
                {title:"user_id",      field:"user_id",visible:false},
                {title:"category_id",  field:"category_id",visible:false},
                {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},

                {title:"costkg", field:"salcostkg",visible:true},
                {title:"costpcs", field:"salcostpcs",visible:true},
                {title:"costfeet", field:"salcostfeet",visible:true},


                {
                title:'STOCK QUANTITY', headerHozAlign:"center",
                    columns:[
                {title:"InKg", field:"sqtykg", cssClass:"bg-gray-200 font-semibold"},
                {title:"InPcs", field:"sqtypcs", cssClass:"bg-gray-200 font-semibold"},
                {title:"InFeet", field:"sqtyfeet", cssClass:"bg-gray-200 font-semibold"}]},

                {title:"Order BalQty",headerHozAlign :'center',
                            field:"balqty", cssClass:"bg-gray-200 font-semibold",
                },

                {
                    title:'SALE QUANTITY', headerHozAlign:"center",
                    columns:[


                        {   title:"InKg",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            field:"qtykg",
                            // editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},

                        },

                        {   title:"InPcs",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"qtypcs",
                            // editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"InFeet",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"qtyfeet",
                            // editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-gray-200 font-semibold",
                            formatterParams:{thousand:",",precision:2},
                        },


                        ]
                },



                {
                    title:'Item Description', headerHozAlign:"center",
                    columns:[

                // {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                //         values:newList,
                //         // cssClass:"bg-green-200 font-semibold",
                //         validator:["required"]
                //     }
                // },

                {   title:"Replace Name",headerHozAlign :'center',
                            field:"repname",
                            responsive:0,
                            editor:true,
                        },

                        {   title:"Brand",headerHozAlign :'center',
                            field:"mybrand",
                            editor:true,
                        },

                    ]},



                    // {title:"feedqty", field:"feedqty",cellEdited: updateValues,editor:"number"},

                    {
                    title:'SALE', headerHozAlign:"center",
                    columns:[


                    {title:"Conversion", field:"unitconver",cellEdited: updateValues,editor:"number"},
                    {title:"Quantity", field:"feedqty",cellEdited: updateValues,editor:"number"},

                    {   title:"Price",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            field:"price",
                            editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },


                        {title:"Sale Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        field:"saleamnt",
                        bottomCalc:"sum",
                        cssClass:"bg-green-200 font-semibold",
                        formatter:"money",
                        formatterParams:{thousand:",",precision:3},
                        formatter:function(cell,row)
                        {
                            // if(cell.getData().sku_id == 1)
                            //    { return (cell.getData().qtykg * cell.getData().price).toFixed(0) }
                            // else if (cell.getData().sku_id == 2)
                            //    { return (cell.getData().qtypcs * cell.getData().price).toFixed(0) }
                            // else if (cell.getData().sku_id == 3)
                            //    { return (cell.getData().qtyfeet * cell.getData().price).toFixed(0) }

                            return  ( Number(cell.getData().feedqty) * Number(cell.getData().price)).toFixed(0)

                        },
                        bottomCalc:totalVal  },


                    ]},


            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
        // Validation & Post
        function validateForm()
        {

            var pono = document.getElementById("pono")
            var poseqno = document.getElementById("poseqno")
            var per= document.getElementById("per");

            if(pono.value === '')
            {
                showSnackbar("P.O No Required","error");
                pono.focus();
                return;
            }



            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

            for (let index = 0; index < dynamicTableData.length; index++) {
                const element = dynamicTableData[index];

                        if(Number(element.feedqty) > Number(element.balqty) )
                            {
                                showSnackbar("Sale Qty must be less than Plan qty","info");
                                return;
                            }

                if( element.sku_id===2)
                {
                if(Number(element.feedqty) > Number(element.sqtypcs) )
                             {

                                showSnackbar("sale qty must be less than stock qty","info");
                                return;
                            }
                }

                if( element.sku_id===1)
                {
                if(Number(element.feedqty) > Number(element.sqtykg) )
                             {

                                showSnackbar("sale qty must be less than stock qty","info");
                                return;
                            }
                }

                if( element.sku_id===3)
                {
                if(Number(element.feedqty) > Number(element.sqtyfeet) )
                             {

                                showSnackbar("sale qty must be less than stock qty","info");
                                return;
                            }
                }

            }


            var data = { 'sales' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id,'deliverydt':deliverydt.value,'custplan_id':custplan_id,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'podate':podate.value,'pono':pono.value,'dcno':dcno.value,'gpno':gpno.value,'billno':billno.value};

            // All Ok - Proceed
            fetch(@json(route('saleinvoices.store')),{
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
                    window.open(window.location.origin + "/saleinvoices","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

        function EnableDisableTextBox(per) {
        var discntper = document.getElementById("discntper");
        discntper.disabled = per.checked ? false : true;
        discntper.style.color ="black";
        // if (!discntper.disabled) {
        //     discntper.focus();
        // }
    }



    discntper.onblur=function(){
    per=false
    // discntamt.value=(tamount*discntper.value/100).toFixed(0);
     tnetamount();
            // discntamt.value=(tamount*discntper.value/100).toFixed(0);
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);
}

discntamt.onblur=function(){
    // discntper.value=(discntamt.value/tamount*100).toFixed(2);
     tnetamount();
            // discntper.value=(discntamt.value/tamount*100).toFixed(2);
            // rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            // saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            // totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);


}
    </script>
@endpush

</x-app-layout>
