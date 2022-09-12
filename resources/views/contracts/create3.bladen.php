<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Contract
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full mx-auto sm:px-2 lg:px-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            {{-- Create Form --}}
            <div class="px-6 py-2" >

                <form action="{{ route('contracts.store') }}" method="post" onsubmit="formValidation(event)">
                @csrf
                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            {{-- Contract Master --}}
                            <label for="supplier_id">Supplier</label>
                            <select class="col-span-2"  name="supplier_id" id="supplier_id" required>
                                <option value="" selected>--Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}" >  {{$supplier->sname}}  </option>
                                @endforeach
                            </select>

                            {{-- Contract Master - Invoice Date --}}
                            <label for="invdate">Invoice Date</label>

                            <input type="date" class="col-span-2" name="invdate" required>

                            {{-- Contract Master - Invoice Number --}}
                            <label for="invno">Invoice #</label>
                            <input type="text" class="col-span-2" name="invno" placeholder="Invoice No" minlength="3"  title="minimum 3 characters required" required>

                        </div>

                        {{-- Contract Details --}}
                        <div class="flex flex-row pt-8">
                            <table class="table table-fixed relative rounded pt-4" >
                                <caption class="absolute inline-block text-indigo-500 text-sm" style="top:-20px;">
                                To add a new row, press <kbd class="bg-slate-500 text-white rounded px-2">Ctrl + Space</kbd>
                                </caption>
                                <thead class="">
                                    <tr class="bg-slate-700 text-white" >
                                        <th class="border border-slate-300 px-3">Delete</th>
                                        <th class="border border-slate-300 px-3">RowId</th>
                                        <th class="border border-slate-300 px-3">Item</th>
                                        <th class="border border-slate-300 px-3">Category</th>
                                        <th class="border border-slate-300 px-3">Size</th>
                                        <th class="border border-slate-300 px-3">Brand</th>
                                        <th class="border border-slate-300 px-3">Unit</th>
                                        <th class="border border-slate-300 px-3">Bundle1</th>
                                        <th class="border border-slate-300 px-3">Pcs/Bnd1</th>
                                        <th class="border border-slate-300 px-3">Bundle2</th>
                                        <th class="border border-slate-300 px-3">Pcs/Bnd2</th>
                                        <th class="border border-slate-300 px-3">TotalPcs</th>
                                        <th class="border border-slate-300 px-3" class="w-24">Weight(MT)</th>
                                        <th class="border border-slate-300 px-3" class="w-24">Rs($)</th>
                                        <th class="border border-slate-300 px-3" class="w-24">Value($)</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>

                            </table>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Modal --}}
<div id="myModal" class="fixed bg-gray-300 bg-opacity-70 duration-500 mx-auto z-10 h-full w-full top-0">

    <!-- Modal content -->
    <div class="max-w-5xl mx-auto mt-52 bg-white rounded shadow px-6">
        <div class="flex justify-between py-4">
            <h1 class="font-semibold">Items List</h1>
            <span class="close px-2 bg-gray-300 rounded-full text-white cursor-pointer hover:bg-gray-400" onclick="closeModal()">&times;</span>
        </div>
        <div class="">
            {{-- Search --}}
            <x-input id="search" class="block my-2 w-full" type="search" name="search" :value="old('search')" autofocus placeholder="search database" onclick="searchFilter(this)" />
            {{-- Table --}}
            <table class="min-w-full divided-y divide-gray-500">
                <thead>
                    <tr class="bg-gray-500 text-white">
                        <td class="">Id</td>
                        <td class="">Item</td>
                        <td class="">Category</td>
                        <td class="">Size</td>
                        <td class="">Brand</td>
                        <td class="">Unit</td>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 py-6" id="modalTableBody">
                   
                </tbody>
            </table>
        </div>
        <div class="flex justify-between py-2">
            <div id="links"></div>
            <button class="border px-4 py-1 bg-slate-700 text-white rounded-lg" onclick="closeModal()">Close</button>
        </div>
    </div>
  
</div>

@push('scripts')
<script>
const modal = document.getElementById("myModal")
let search = document.getElementById("search")
const links = document.getElementById("links")
const modalTableBody = document.getElementById("modalTableBody")

let rowNumber = 0
let delRows = 0


// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to add new Row
    if(e.ctrlKey && e.keyCode == 32){
        // addNewRow()
        openModal()
    }
})
function searchFilter(e)
{
    search = e.value;
    console.log(search);
}
//  Modal Functions
function openModal()
{
    modal.style.display = 'block'
    modalTableBody.innerHTML = ''
    var url = @json(route('contracts.getitemdata')) + `?search=${search.value}`
    console.log(url);
    return fetch(url,{
        method:"GET",
        headers: { 'Accept':'application/json','Content-type':'application/json'},
        })
        .then((response) => response.json()) //Transform data to json
        .then(function(response){
            console.log(response);
            var data = response.data
            
            data.forEach(e => {
                var tr = document.createElement('tr')
                console.log(e);
                var template = `
                    <td class="border" name="id">${e.id}</td>
                    <td class="border" name="iname">${e.iname}</td>
                    <td class="border hidden" name="category_id">${e.category_id}</td>
                    <td class="border" name="category">${e.category}</td>
                    <td class="border hidden" name="item_size_id">${e.item_size_id}</td>
                    <td class="border" name="itemsize">${e.itemsize}</td>
                    <td class="border hidden" name="brand_id">${e.brand_id}</td>
                    <td class="border" name="brand">${e.brand}</td>
                    <td class="border hidden" name="unit_id">${e.unit_id}</td>
                    <td class="border" name="unit">${e.unit}</td>
                    `
                tr.innerHTML = template
                modalTableBody.appendChild(tr)
            });
            links.innerHTML = response.links
            return response;
        })
        .catch(function(error){
        console.log("Error : " + error);
        })
 
}
function closeModal()
{
    modal.style.display = 'none'
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    console.log(event);
    if (event.target == modal) {
    modal.style.display = "none";
  }
} 

function calculateTotalQty(rowNumber){
    var bundle1 = parseInt(document.getElementById(`bundle1${rowNumber}`).value)
    var pcspbundle1 =  parseInt(document.getElementById(`pcspbundle1${rowNumber}`).value)
    var pcspbundle2 =  parseInt(document.getElementById(`pcspbundle2${rowNumber}`).value)
    var bundle2 =  parseInt(document.getElementById(`bundle2${rowNumber}`).value)

    var ttpcs = document.getElementById(`ttpcs${rowNumber}`)

    ttpcs.value = (bundle1 * pcspbundle1 ) + (pcspbundle2 * bundle2 )
}
function calculateValue(rowNumber)
{
    var gdswt = document.getElementById('gdswt' + rowNumber).value
    var gdsprice = document.getElementById('gdsprice' + rowNumber).value
    var gamount = document.getElementById('gamount' + rowNumber)

    gamount.value = parseFloat(gdswt) * parseFloat(gdsprice)
}
function numbersOnly(element)
{
    element.value = element.value.replace(/[^0-9]/g, '')
}
function addNewRow()
{
    rowNumber++ // increment row number
    delRows++
    var tr = document.createElement('tr')
    tr.id = rowNumber
    var template = `
    <td>${rowNumber}</td>
    <td>
     
    </td>
    <td>
    
    </td>
    <td>
    
    </td>
    <td>
        
    </td>

    <td><input class="bg-green-500 w-16" type="number" min="0"     step="1"  name="bundle1[]"      id="bundle1${rowNumber}" onblur="calculateTotalQty(${rowNumber})" required></td>
    <td><input class="bg-green-500 w-16" type="number" min="0"     step="1"  name="pcspbundle1[]"  id="pcspbundle1${rowNumber}" onblur="calculateTotalQty(${rowNumber})" required></td>

    <td><input class="bg-orange-500 w-16" type="number" min="0"     step="1"    value="0" name="bundle2[]"      id="bundle2${rowNumber}" onblur="calculateTotalQty(${rowNumber})"></td>
    <td><input class="bg-orange-500 w-16" type="number" min="0"     step="1"    value="0" name="pcspbundle2[]"  id="pcspbundle2${rowNumber}" onblur="calculateTotalQty(${rowNumber})"></td>

    <td><input class="w-16" type="number" min="0"     step="1"    value="0" name="ttpcs[]" id="ttpcs${rowNumber}" disabled="true"></td>

    <td><input class="bg-green-500 w-24" type="number" min="0.01"  step=".01"  value="0" max="1000000"     name="gdswt[]"    id="gdswt${rowNumber}" onblur="calculateValue(${rowNumber})" required></td>
    <td><input class="bg-green-500 w-24" type="number" min="0.001" step=".001" value="0" max="1000000"     name="gdsprice[]" id="gdsprice${rowNumber}" onblur="calculateValue(${rowNumber})" required></td>
    <td><input class="w-24" type="number" min="0.01"  step=".01"  value="0" max="1000000"     name="gamount"  id="gamount${rowNumber}" disabled="true"></td>
    <td><span onclick="deleteRow(${rowNumber})">❌</span></td>
    `
    tr.innerHTML = template
    document.getElementById("tableBody").appendChild(tr)
    tr.focus()
    
}
function deleteRow(rowNumber)
{
    var tr = document.getElementById(rowNumber);
    document.getElementById("tableBody").removeChild(tr)
    delRows--
}
// For JS: we need to do initial validation here
function formValidation(event)
{
    // event.preventDefault();
    if(delRows <= 0)
    {
        event.preventDefault();
        alert('Add atleast 1 recorrd')
        return;
    }
    
}
</script>

@endpush



</x-app-layout>
