<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Purchase Order
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm  sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-2 py-2">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            {{-- <div class="grid grid-cols-12 gap-1 py-2 items-center"> --}}
                                <div class=" grid grid-cols-8   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">

                                <x-input-text title="Customer Name" name="custname" id="custname"   disabled  />
                                <x-input-text title="Quotation No" name="qutno" id="qutno"   disabled  />
                                <x-input-date title="Quotation Date" name="qutdate" id="qutdate"   disabled  />
                                <x-input-text title="P.R No" name="prno" id="prno"   disabled  />
                                <x-input-date title="P.O Date" id="podate" name="podate"  class="col-span-1" />
                                <x-input-text title="P.O #" name="pono" id="pono"  class="col-span-1"  />
                                <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{$maxposeqno}}" class="col-span-1"  />


                            </div>
                            <div class=" grid grid-cols-8   py-1  text-right  gap-1 divide-black focus:bg-blue-500 w-full  ">
                                <x-input-numeric title="Discount(%)" name="discntper" id="discntper" class="col-span-1"     />
                                {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" > --}}
                                <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt" class="col-span-1"   />
                                <x-input-numeric title="Receivable Amount" name="rcvblamount" class="col-span-1" disabled />

                                <x-input-numeric title="Sale Tax(%)" name="saletaxper" class="col-span-1"  onblur="tnetamount()"  />
                                <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" class="col-span-1" disabled    />
                                <x-input-numeric title="Cartage" name=cartage  class="col-span-1"  onblur="tnetamount()"  />
                                <x-input-numeric title="Total Amount" name="totrcvbamount" class="col-span-1" disabled />
                            </div>
                        </fieldset>

                        {{-- <fieldset class="border px-4 py-2 rounded">
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            </div>
                        </fieldset> --}}

                        {{-- <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>
                        </div> --}}
                        <x-input-date title="" name="deliverydt" hidden  class="col-span-2"/>


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


        var getMaster = @json(route('custorders.quotations')) ;
        var getDetails = @json(route('custorders.quotationsdtl'));

         let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let quotation_id = '';
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
        function showModal()
        {
            modal.style.display = "block"
            const inp = document.getElementById('data_filter')
            inp.focus()

        }
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
            initialSort:[ {column:"id", dir:"desc"} ],

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Customer", field:"custname" , responsive:0},
                {title:"Quotation Date", field:"dqutdate" , responsive:0},

                {title:"Quotation #", field:"qutno" , visible:true ,headerSort:false, responsive:0},
                {title:"P.R No", field:"prno" , visible:true ,headerSort:false, responsive:0},
                {title:"Quotation Values", field:"totrcvbamount", visible:true ,headerSort:false, responsive:0},
                {title:"Valid Date", field:"dvaldate" , responsive:0},


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
            quotation_id = data.id
            qutdate.value=data.qutdate
            customer_id=data.customer_id
            prno.value = data.prno
            qutno.value = data.qutno
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
            // calculateButton.disabled = false
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
                        quotation_id :      obj.quotation_id,
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
                        saleqty :           obj.saleqty ,
                        price   :           obj.price,
                        saleamnt:           obj.saleamnt,
                        balqty:             obj.balqty,
                        varqty:             obj.varqty,

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
            if (discntper.disabled)
            {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            if (!discntper.disabled)
            {discntamt.value=(tamount*discntper.value/100).toFixed(0);};

            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

var updateValues = (cell) => {
        var data = cell.getData();
        // var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var sum = (Number(data.saleqty) * Number(data.price))
        var varqty = ( Number(data.balqty) - Number(data.saleqty) )
        var row = cell.getRow();
        row.update({
             "saleamnt": sum,
             "varqty":varqty,
             totalVal: sum

        });
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
                {title:"S.No",         field:"sno", formatter:"rownum",responsive:0},
                {title:"Id",           field:"id", visible:false},
                {title:"Material Name",     field:"material_title",responsive:0,width:300,responsive:0},
                {title:"Material Size",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu,width:150,responsive:0},
                {title:"UOM",         field:"sku",responsive:0, hozAlign:"center"},
                {title:"Unitid",       field:"sku_id",visible:false},
                // {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},
                {title:"user_id",      field:"user_id",visible:false},
                {title:"category_id",  field:"category_id",visible:false},
                {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},


                {title:"StockQty", field:"balqty",width:120,responsive:0},



                {title:"Variance", field:"varqty",width:120,responsive:0,cellEdited: updateValues},

                {
                    title:'Quantity', headerHozAlign:"center",
                    columns:[
                        {   title:"Replace Name",headerHozAlign :'center',
                            field:"repname",
                            // editor:"list",
                            responsive:0,
                            width:150,
                            // headerVertical:true,
                            editor:true,
                        },

                        {   title:"Brand",headerHozAlign :'center',
                            field:"mybrand",
                            width:150,
                            responsive:0,
                            // headerVertical:true,
                            editor:true,
                        },





                        {   title:"Sale Qty",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            width:150,
                            field:"saleqty",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Sale Price",
                            headerHozAlign :'right',
                            hozAlign:"right",
                            responsive:0,
                            width:120,
                            field:"price",
                            editor:"number",
                            // headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            cellEdited: updateValues,
                            validator:["required","numeric"],
                            // cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },


                        {title:"Sale Amount",
                        headerHozAlign :'right',
                        hozAlign:"right",
                        width:120,
                        field:"saleamnt",
                        responsive:0,
                        cssClass:"bg-gray-200 font-semibold",
                        formatter:"money",
                        cssClass:"bg-green-200 font-semibold",
                        formatterParams:{thousand:",",precision:3},
                        formatter:function(cell,row)
                        {
                            return (cell.getData().saleqty * cell.getData().price).toFixed(0)
                        },
                        bottomCalc:totalVal  },


                    ]
                },


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

            // for (let index = 0; index < dynamicTableData.length; index++) {
            //     const element = dynamicTableData[index];

            //     if(element.location === undefined)
            //     {
            //         showSnackbar("Location must be Enter","info");
            //         return;
            //     }
            // }


            var data = { 'contracts' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id,'deliverydt':deliverydt.value,'quotation_id':quotation_id,'poseqno':poseqno.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'podate':podate.value,'pono':pono.value,'qutno':qutno.value,'qutdate':qutdate.value,'prno':prno.value};




            // All Ok - Proceed
            fetch(@json(route('customerorder.store')),{
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
                    window.open(window.location.origin + "/customerorder","_self" );
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
