<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Contract') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">

                            <label for="supplier_id">Supplier<x-req /></label>
                            <select autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                <option value="" selected>--Supplier</option>
                                @foreach($suppliers as $supplier)
                                @if ($supplier->id>1)
                                    <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endif
                                @endforeach
                            </select>

                            <label for="invoice_date">Invoice Date<x-req /></label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="col-span-2" id="invoice_date" name="invoice_date" required>

                            <label for="number">Invoice #<x-req /></label>
                            <input type="text" class="col-span-2" id="number" name="number" placeholder="Invoice No"
                                minlength="3" title="minimum 3 characters required" required>


                        </div>

                        {{-- Contract Details --}}
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                id="submitbutton" onclick="validateForm()"
                                class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </button>
                        </div>

                    </div>

            </div>
        </div>
    </div>


@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Materials" />

@push('scripts')
<script>
    let table;
    let searchValue = "";
    const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
    const getMaster = @json(route('materials.master'));
    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let modal = document.getElementById("myModal")
    // console.log(getMaster);

    let dyanmicTable = ""; // Tabulator
    let dynamicTableData = [];

    // Add event handler to read keyboard key up event
    document.addEventListener('keyup', (e)=>{
        //  We are using ctrl key + 'ArrowUp' to show Modal
        if(e.ctrlKey && e.keyCode == 32){
            showModal()
        }
    })
    // Ensure Buttons Are Closed
    function disableSubmitButton()
    {
        if(dynamicTableData.length <= 0 )
        {
            document.getElementById("submitbutton").disabled = true;
        }else {
            document.getElementById("submitbutton").disabled = false;
        }
    }
</script>
@endpush

@push('scripts')
<script>
    //  ---------------- For MODAL -----------------------//
    function showModal(){ modal.style.display = "block"}
    function closeModal(){  modal.style.display = "none"}
    //  When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    //  ------------------Dynamic Table----------------------//
    //  Adds actual data to row
    function pushDynamicData(data)
    {
        var inArray = dynamicTableData.filter( i => dynamicTableData.id == data.id)

        dynamicTableData.push({ id:data.id})

        dynamicTable.addData([
            {
                id:data.id,
                title:data.title,
                category_id:data.category_id,
                category:data.category,

                source_id:data.source_id,
                source:data.source,

                brand_id:data.brand_id,
                brand:data.brand,

                sku_id:data.sku_id,
                sku:data.sku,

                dimension_id:data.dimension_id,
                dimension:data.dimension,

                bundle1:0,
                bundle2:0,
                pcspbundle1:0,
                pcspbundle2:0,
                gdswt:0,
                gdsprice:0,
                dtyrate:0,
                invsrate:0,
                gdspricetot:0
            }
        ])
    }
</script>
@endpush

@push('scripts')
<script>
    //  Table Filter
    function dataFilter(element)
    {
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue});
    }
    //  The Table for Materials Modal
    table = new Tabulator("#tableData", {
        autoResize:true,
        responsiveLayout:"collapse",
        layout:"fitData",
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
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Material", field:"title" , visible:true ,headerSort:false, responsive:0},
            {title:"Category", field:"category" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Source", field:"source" ,  responsive:0},
            {title:"Sku", field:"sku" ,  responsive:0},
            {title:"Sku_id", field:"sku_id" ,  responsive:0},
            {title:"Brand", field:"brand" ,  responsive:0},
        ],
        // Extra Pagination Data for End Users
        ajaxResponse:function(getDataUrl, params, response){
            remaining = response.total;
            let doc = document.getElementById("example-table-info");
            doc.classList.add('font-weight-bold');
            doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
            return response;
        }
    })
    //  Adds New row to dyanmicTable
    table.on('rowClick',function(e,row){
        var simple = {...row}
        var data = simple._row.data
        // console.log(data);
        //  Filter Data here .
        var result = dynamicTableData.filter( dt => dt.id == data.id)
        if(result.length <= 0)
        {
            pushDynamicData(data)
        }
    })
    var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))

         if(cell.getData().sku_id==1)
         {
             var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
             var sum3 =  Number(data.gdswt) * Number(data.dtyrate)
         }
         if(cell.getData().sku_id==2)
         {
             var sum2 =  ( (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2)) ) * Number(data.gdsprice)
             var sum3 =  ( (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2)) ) * Number(data.dtyrate)
         }



        // var sum2 =  sum *  Number(data.gdsprice)
        var row = cell.getRow();
        row.update({
            "ttpcs": sum,
            "gdspricetot": sum2,
            "gdspricedtytot":sum3

        });
    }

    var totalVal = function(values, data, calcParams){
        //values - array of column values
        //data - all table data
        //calcParams - params passed from the column definition object
        // console.log(data);
        var calc = 0;
        values.forEach(function(value){
            calc += value ;
            // totwt+= value ;
        });
        totwt=calc;
        return calc;
    }
    //  Dynamic Table [User data]
    var tableDataNested = [{
    id: 1,
    name: "BalanceOil",
    _children: [{
        id: 11,
        name: "BalanceOil+",
        cena: 31,
        mn: 1,
        cena_1: 159
      },
      {
        id: 12,
        name: "BalanceOil Aqua",
        cena: 41,
        mn: 1,
        cena_1: 159
      },
    ]
  },
  {
    id: 2,
    name: "Xtend",
    cena: 23,
    mn: 1
  },
  {
    id: 2,
    name: "Xtend",
    cena: 23,
    mn: 1
  },
  {
    id: 2,
    name: "Xtend",
    cena: 23,
    mn: 1
  },
  {
    id: 3,
    name: "Zinobiotic",
    cena: 24,
    mn: 1
  }
];

var table = new Tabulator("#example-table", {
  movableColumns: true,
  data: tableDataNested,
  dataTree: true,
  selectable: true,
  columns: [{
      title: "Name",
      field: "name",
      headerSort: false,
      width: 200
    },
    {
      title: "Cena",
      field: "cena",
      headerSort: false
    },
    {
      formatter: function(cell, formatterParams, onRendered) {
        const data = cell.getRow().getData();
        if (do_not_show_checkbox_ids.indexOf(data['id']) == -1) {
          var checkbox = document.createElement("input");

          checkbox.type = 'checkbox';

          if (this.table.modExists("selectRow", true)) {

            checkbox.addEventListener("click", (e) => {
              e.stopPropagation();
            });

            if (typeof cell.getRow == 'function') {
              var row = cell.getRow();
              if (row._getSelf().type == "row") {

                checkbox.addEventListener("change", (e) => {
                  row.toggleSelect();
                });

                checkbox.checked = row.isSelected && row.isSelected();
                this.table.modules.selectRow.registerRowSelectCheckbox(row, checkbox);
              } else {
                checkbox = "";
              }
            } else {
              checkbox.addEventListener("change", (e) => {
                if (this.table.modules.selectRow.selectedRows.length) {
                  this.table.deselectRow();
                } else {
                  this.table.selectRow(formatterParams.rowRange);
                }
              });
              this.table.modules.selectRow.registerHeaderSelectCheckbox(checkbox);
            }
          }
          return checkbox;
        }
        return null;
      },
      titleFormatter: "rowSelection",
      hozAlign: "center",
      headerSort: false,
      cellClick: function(e, cell) {
        this.recalc();
      }
    },
    {
      title: "mn",
      field: "mn",
      editor: "number",
      headerSort: false,
      cellEdited: function(cell) {
        updateSum(cell);
      }
    },
    {
      title: "Sum",
      field: "sum",
      headerSort: false
    }
  ],
  rowClick: function(e, row) {
    // console.log(table.getRows().length);
  },
  renderComplete: function(t) {
    this.getRows().forEach(function(value, index) {
      console.log(value.isSelected());
      var children = value.getTreeChildren();
      for (let j = 0; j < children.length; j++) {
        const name = children[j].getData().name;
      }
      children.forEach(function(value, index) {
        // console.log("cena");
        var cena = value.getData().cena; //price

        // console.log(cena);
        var mnozstvi = value.getData().mn; //amount
        value.update({
          sum: cena * mnozstvi
        });
      });
      updateSum(value.getCell("mn"));
    });
  },
  selectableCheck: function(row) {
    //row - row component
    return row.getData().cena > 0; //allow selection of rows where the age is greater than 18
  },
});

function updateSum(cell) {
  var cena = cell.getData().cena; //price
  var mnozstvi = cell.getValue(); //amount
  if (mnozstvi) {
    cell.getRow().update({
      sum: cena * mnozstvi
    });
  }
}
    // Validation & Post
    function validateForm()
    {
        var sid = document.getElementById("supplier_id");
        var supplier_id = sid.options[sid.selectedIndex];
        var invoice_date = document.getElementById("invoice_date");
        var number = document.getElementById("number");

        // Required
        if(supplier_id.value <= 0)
        {
            showSnackbar("Please select From Supplier");
            supplier_id.focus();
            return;
        }
        if(invoice_date.value === "")
        {
            showSnackbar("Please select From Invoice Date");
            invoice_date.focus();
            return;
        }
        if(number.value == "")
        {
            showSnackbar("Please add Invoice Number");
            number.focus();
            return;
        }
        if(dynamicTableData.length == 0)
        {
            showSnackbar("You must have atleast 1 row of item to Proceed","info");
            return;
        }
        dynamicTableData = dynamicTable.getData();
        // Qty Required
        for (let index = 0; index < dynamicTableData.length; index++) {
            const element = dynamicTableData[index];
            // if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.gdsprice == 0 || element.gdswt == 0 and element.sku_id==2  )

            if (element.sku_id==1)
            {
                if(element.gdsprice == 0 || element.gdswt == 0  )
                    {
                        showSnackbar("Please fill Weight & Price all rows to proceed","info");
                        return;
                    }
            }
            if (element.sku_id==2)
            {
                if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.gdsprice == 0 )
                {
                    showSnackbar("Please fill Bundle,PcsBundle & Price all rows to proceed","info");
                    return;
                }
            }

        }
        disableSubmitButton(true);
        var data = { 'contracts' : dynamicTableData ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'number':number.value};
        // All Ok - Proceed
        fetch(@json(route('contracts.store')),{
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
                window.open(window.location.origin + "/contracts","_self" );
            }
        })
        .catch(error => {
            showSnackbar("Errors occured","red");
            disableSubmitButton(false);
        })
    }





</script>
@endpush

</x-app-layout>
