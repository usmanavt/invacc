<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Contract') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="w-full mx-auto sm:px-2 lg:px-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            {{-- Create Form --}}
            <div class="px-6 py-2" >

                <form action="{{ route('contracts.store') }}" method="post" onsubmit="formValidation(event)">
                @csrf
                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            {{-- Contract Master --}}
                            <label for="supcode">Supplier</label>
                            <select class="col-span-2"  name="supcode" id="supcode" required>
                                <option value="" selected>Contract</option>
                                @foreach($supdta as $list)
                                    <option value="{{$list->supid}}" >  {{$list->supname}}  </option>
                                @endforeach
                            </select>

                            {{-- Contract Master - Invoice Date --}}
                            <label for="invdate">Invoice Date</label>

                            <input type="date" class="col-span-2" name="invdate" required>

                            {{-- Contract Master - Invoice Number --}}
                            <label for="invno">Invoice ID #</label>
                            <input type="text" class="col-span-2" name="invno" placeholder="Invoice No" minlength="3"  title="minimum 3 characters required" required>

                        </div>

                        {{-- Contract Details --}}
                        <div class="flex flex-row pt-8">
                            <table class="table table-fixed relative rounded" >
                                <caption class="absolute inline-block text-indigo-500 text-sm" style="top:-20px;">
                                To add a new row, press <kbd class="bg-slate-500 text-white rounded px-2">Ctrl + Space</kbd>
                                </caption>
                                <thead>
                                    <tr class="bg-slate-700 text-white" >
                                        <th>RowId</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Brand</th>
                                        <th>Bnd</th>
                                        <th>Pcs/Bnd</th>
                                        <th>Bnd</th>
                                        <th>Pcs/Bnd</th>
                                        <th>TotPcs</th>
                                        <th class="w-24">Wt(MT)</th>
                                        <th class="w-24">Rs($)</th>
                                        <th class="w-24">Val($)</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>

                            </table>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button class="inline-flex items-center px-4 py-1 w-36 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                {{ __('Submit') }}
                            </button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
let rowNumber = 0
let delRows = 0
document.addEventListener('DOMContentLoaded',()=>{
    // addNewRow()
})
// Add event handler to read keyboard key up event
document.addEventListener('keyup', (e)=>{
    //  We are using ctrl key + 'ArrowUp' to add new Row
    if(e.ctrlKey && e.keyCode == 32){
        addNewRow()
    }
})
function popItemId(el,id){
    var selectCategoryId = el.options[el.selectedIndex].value
    var selectCategoryRowNumber = id
    console.log(selectCategoryId , selectCategoryRowNumber);
    //  The Seletion Box
    var selectedItemId = document.getElementById(`itemId${id}`)
    var selItemSizeId = document.getElementById(`itemSizeId${id}`)
    selectedItemId.innerHtml = ""
    selectedItemId.innerText = ""
    selItemSizeId.innerHtml = ""
    selItemSizeId.innerText = ""
    if(selectCategoryId == '')
    {
        return // Don't work on empty selectedItemId
    }
    let url = window.origin + "/getItem?categoryId=" + selectCategoryId
    // console.log(url)
    fetch(url,{
        method:"GET",
         headers:{'Accept':'application/json','Content-type':'application/json'},
        })
        .then(response => response.json())
        .then(function(response){
            // console.log(response)

            // This object has array in array, that's why dbl loop
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                // Add select initial
                var startOption = document.createElement('option')
                startOption.value = ""
                startOption.text = "--Name"
                selectedItemId.appendChild(startOption)
                //
                element.forEach(e => {
                    // console.log(e.icode, e.iname)
                    var sel = document.createElement('option')
                    sel.value = e.icode
                    sel.text = e.iname
                    selectedItemId.appendChild(sel)
                        });
                }
        })
        .catch(err => {
            console.log(err.message)
        })
}
function popItemSize(el,id){
    var selectedItemId = el.options[el.selectedIndex].value // Name Select
    var selectedItemIdRowNumber = id
    console.log(selectedItemId, selectedItemIdRowNumber)
    var selCategory = document.getElementById(`categoryId${id}`)
    var selCategoryId = selCategory.options[selCategory.selectedIndex].value
    var selItemSizeId = document.getElementById(`itemSizeId${id}`)
    selItemSizeId.innerHtml = ""
    selItemSizeId.innerText = ""
    // console.log(selectedItemId)
    if(selectedItemId == '')
    {
        return // Don't work on empty selectedItemId
    }
    let url = window.origin + "/getSize?itemId=" + selectedItemId + "&categoryid=" + selCategoryId
    console.log(url)
    fetch(url,{
        method:"GET",
            headers:{'Accept':'application/json','Content-type':'application/json'},
        })
        .then(response => response.json())
        .then(function(response){
            // Add select initial
            var startOption = document.createElement('option')
            startOption.value = ""
            startOption.text = "--Size"
            selItemSizeId.appendChild(startOption)
            // This object has array in array, that's why dbl loop
            for (let index = 0; index < response.length; index++) {
                const element = response[index];
                element.forEach(e => {
                    // console.log(e.icode, e.iname)
                    var sel = document.createElement('option')
                    sel.value = e.trid
                    sel.text = e.sizename
                    selItemSizeId.appendChild(sel)
                });
            }
        })
        .catch(err => {
            console.log(err.message)
        })
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
        <select onchange="popItemId(this,${rowNumber})" name="categoryId[]" id="categoryId${rowNumber}" required>
            <option value="" selected>--Category</option>
            @foreach($grpdta as $grplist)
                <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>
            @endforeach
        </select>
    </td>
    <td>
        <select onchange="popItemSize(this,${rowNumber})"  name="itemId[]" id="itemId${rowNumber}" required>
        </select>
    </td>
    <td>
        <select class="form-control itemSizeId" name="itemSizeId[]" id="itemSizeId${rowNumber}" required>
        </select>
    </td>
    <td>
        <select class="form-control brandid" required name="brandid[]" id="brandid${rowNumber}" required>
            <option value="" selected>Item Size</option>
            @foreach($brddta as $brdlist)
                <option value="{{$brdlist->bid}}" >  {{$brdlist->bname}}  </option>
            @endforeach
        </select>
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
