<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Contract') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-10xl mx-auto sm:px-2 lg:px-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            {{-- Create Form --}}
            <div class="px-12 py-2" >

            <form action="{{ route('contracts.store') }}" method="post" >
            @csrf
                <div class="flex flex-row justify-start space-x-12 items-center">
                {{-- Contract Master --}}
                <div class="row">
                    {{-- Contract Master --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select class="form-control" required name="supcode" id="supcode" >
                                <option value="" disabled >Contract</option>
                                @foreach($supdta as $list)
                                    <option value="{{$list->supid}}" >  {{$list->supname}}  </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Contract Master - Invoice Date --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="date" class="form-control" name="invdate" placeholder="Invoice Date">
                        </div>
                    </div>

                    {{-- Contract Master - Invoice Number --}}
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text" class="form-control" name="invno" placeholder="Invoice No">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                        <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fa fa-save fa-fw bg-green-900"></i>
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>

                {{-- Contract Details --}}
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <table class="table table-bordered" >

                        <thead class="table-dark" >
                            <th> Category </th>
                            <th> Name </th>
                            <th> Size </th>
                            <th> Brand </th>
                            <th> Bnd </th>
                            <th> Pcs/Bnd </th>
                            <th> Bnd </th>
                            <th> Pcs/Bnd </th>
                            <th> TotPcs </th>
                            <th> Wt(MT) </th>
                            <th> Rs($) </th>
                            <th> Val($) </th>
                            <th> <a href="#" class=" btn btn-primary addRow">
                                <i class="glyphicon glyphicon-plus"> </i>+</a>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select onchange="popItemId(this)" name="categoryId[]" id="categoryId">
                                        <option value="" selected>--Category</option>
                                        @foreach($grpdta as $grplist)
                                            <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select onchange="popItemSize(this)"  name="itemId[]" id="itemId" style="min-width:150px " >
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control itemSizeId" name="itemSizeId[]" id="itemSizeId" style="min-width:100px " >
                                        {{-- <option value="" disabled >Item Size</option>
                                        @foreach($szedta as $szelist)
                                            <option value="{{$szelist->szeid}}" >  {{$szelist->szename}}  </option>
                                        @endforeach
                                    </select> --}}

                                </td>
                                <td>
                                    <select class="form-control brandid" required name="brandid[]" id="brandid" style="min-width:100px " >
                                        <option value="" disabled >Item Size</option>
                                        @foreach($brddta as $brdlist)
                                            <option value="{{$brdlist->bid}}" >  {{$brdlist->bname}}  </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td> <input type="text" class="form-control Bundles w-20" name="bundle1[]" id="bundle1"   > </td>
                                <td> <input type="text" class="form-control Bundles w-20" name="pcspbundle1[]" id="pcspbundle1" style="min-width:50px " > </td>
                                <td> <input type="text" class="form-control Bundles2 w-20" name="bundle2[]" id="bundle2" style="min-width:50px " > </td>
                                <td> <input type="text" class="form-control Bundles2 w-20" name="pcspbundle2[]" id="pcspbundle2" style="min-width:50px " > </td>
                                <td> <input type="text" class="form-control ttpcs w-20" name="ttpcs" id="ttpcs" disabled="true" style="min-width:80px " > </td>
                                <td> <input type="text" class="form-control gdswt w-20" name="gdswt" id="gdswt" style="min-width:70px " > </td>
                                <td> <input type="text" class="form-control gdsprice w-20" name="gdsprice" id="gdsprice" style="min-width:70px "  > </td>
                                <td> <input type="text" class="form-control gamount w-20" name="gamount" id="gamount" disabled="true" style="min-width:100px "  > </td>
                                <td> <a href="javascript:;" class="btn btn-danger deletrow w-20"> </a></td>
                            </tr>
                        </tbody>

                        </table>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>



@push('scripts')
<script>
function popItemId(el){
    var selItemId = el.options[el.selectedIndex].value
    //  The Seletion Box
    var selItmId = document.getElementById('itemId')
    var selItmSizeId = document.getElementById('itemSizeId')
    selItmId.innerHtml = ""
    selItmId.innerText = ""
    selItmSizeId.innerHtml = ""
    selItmSizeId.innerText = ""
    if(selItemId == '')
    {
        return // Don't work on empty selItemId
    }
    let url = window.origin + "/getItem?cid=" + selItemId
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
                selItmId.appendChild(startOption)
                //
                element.forEach(e => {
                    // console.log(e.icode, e.iname)
                    var sel = document.createElement('option')
                    sel.value = e.icode
                    sel.text = e.iname
                    selItmId.appendChild(sel)
                        });
                }


        })
        .catch(err => {
            console.log(err.message)
        })
}
function popItemSize(el){
    var selItemId = el.options[el.selectedIndex].value // Name Select
    var selCategoryId = document.getElementById('categoryId').options[el.selectedIndex].value
    var selItemSizeId = document.getElementById('itemSizeId')

    // console.log(selItemId)
    if(selItemId == '')
    {
        return // Don't work on empty selItemId
    }
    let url = window.origin + "/getSize?cid=" + selItemId + "&categoryid=" + selCategoryId
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
</script>






<script type="text/javascript">

    $('.addRow').on('click',function()
    {
        addRow();
    });
    function addRow()
    {
        var tr=' <tr>'+
        '    <td>'+
        '            <select class="form-control categoryId" required name="categoryId[]" id="categoryIdid" style="min-width:150px " >'+
        '                <option value="" disabled >Category</option>'+
        '                @foreach($grpdta as $grplist)'+
        '                    <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>'+
        '                 @endforeach'+
        '            </select>'+
        '    </td>'+
        '<td>'+
        '    <select class="form-control itemId"   required name="itemId[]" id="itemIdid" style="min-width:150px " >'+
        '        {{-- <option value="" disabled >Item</option> --}}'+
        '        {{-- @foreach($itmdta as $itmlist) --}}'+
        '            <option value="0" >  -- select item ---  </option>'+
        '         {{-- @endforeach --}}'+
        '    </select>'+
        '</td>'+
        '<td>'+
        '    <select class="form-control itemSizeId" required name="itemSizeId[]" id="itemSizeId" style="min-width:100px " >'+
        '        <option value="" disabled >Item Size</option>'+
        '        @foreach($szedta as $szelist)'+
        '            <option value="{{$szelist->szeid}}" >  {{$szelist->szename}}  </option>'+
        '         @endforeach'+
        '    </select>'+
        '</td>'+
        '<td>'+
        '    <select class="form-control brandid" required name="brandid[]" id="brandid" style="min-width:100px " >'+
        '        <option value="" disabled >Item Size</option>'+
        '        @foreach($brddta as $brdlist)'+
        '            <option value="{{$brdlist->bid}}" >  {{$brdlist->bname}}  </option>'+
        '         @endforeach'+
        '    </select>'+
        '</td>'+
        '<td> <input type="text" class="form-control Bundles" name="bundle1[]" id="bundle1" style="min-width:50px "  > </td>'+
        '<td> <input type="text" class="form-control Bundles" name="pcspbundle1[]" id="pcspbundle1" style="min-width:50px " > </td>'+
        '<td> <input type="text" class="form-control Bundles2" name="bundle2[]" id="bundle2" style="min-width:50px " > </td>'+
        '<td> <input type="text" class="form-control Bundles2" name="pcspbundle2[]" id="pcspbundle2" style="min-width:50px " > </td>'+
        '<td> <input type="text" class="form-control ttpcs" name="ttpcs" id="ttpcs" disabled="true" style="min-width:80px " > </td>'+
        '<td> <input type="text" class="form-control gdswt" name="gdswt" id="gdswt" style="min-width:70px " > </td>'+
        '<td> <input type="text" class="form-control gdsprice" name="gdsprice" id="gdsprice" style="min-width:70px "  > </td>'+
        '<td> <input type="text" class="form-control gamount" name="gamount" id="gamount" disabled="true" style="min-width:100px "  > </td>'+
        '</td>'+
        '<td> <a href="javascript:;" class="btn btn-danger deletrow">-</a></td>'+
        '</td>'+
        '</tr>'
            $('tbody').append(tr);

    };

    $('tbody').on('click','.deletrow',function()
    {
        $(this).parent().parent().remove();
    });

    // $('body').delegate('.remove','click',function()
    // {
    //     alert("dfafdsafdsfdsf");
    // });


</script>





@endpush



</x-app-layout>
