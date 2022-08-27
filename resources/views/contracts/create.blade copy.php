<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Contract') }}
        </h2>
    </x-slot>


    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" --}}
    {{-- integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
        {{-- <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}> --}}
        {{-- <link rel="stylesheet" href={{ asset('js/select2.min.js') }}> --}}

    <div class="py-6">
        <div class="max-w-10xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- Create Form --}}
                <div class="px-12 py-2" >


                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('contracts.index')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        View
                    </a> --}}

                    {{-- <a class="text-sm text-indigo-500 hover:text-gray-900 mb-2" href="{{route('dashboard')}}">
                        <i class="fa fa-edit fa-fw"></i>
                        Dashboard
                    </a> --}}

                    <form action="{{ route('contracts.store') }}" method="post" >
                        @csrf
                            <div class="flex flex-row justify-start space-x-12 items-center">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {{-- <x-label for="supcode" :value="__('Supplier')" /> --}}
                                        <select class="form-control" required name="supcode" id="supcode" >
                                            <option value="" disabled >Contract</option>
                                            @foreach($supdta as $list)
                                                <option value="{{$list->supid}}" >  {{$list->supname}}  </option>

                                             @endforeach
                                        </select>
                                    </div>
                                    </div>



                                <div class="col-lg-4">
                                    <div class="form-group">
                                      <input type="date" class="form-control" name="invdate" placeholder="Invoice Date">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                      <input type="text" class="form-control" name="invno" placeholder="Invoice No">
                                    </div>
                                </div>
                            {{-- </div> --}}

                            <div class="col-lg-4">
                                <div class="form-group">
                                <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fa fa-save fa-fw bg-green-900"></i>
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>





{{-- <div class="col-lg-12 col-sm-12"> --}}

        <div class="col-lg-12 col-sm-12">
         <div class="form-group">
        <table class="table table-bordered" >

        <thead class="table-dark" >
            {{-- <section class="panel ">
            <div class="panel panel-footer"> --}}
            <th> Category </th>
            <th> Name </th>
            <th> Size </th>
            <th> Brand </th>

            <th> Bnd </th>
            <th> Pcs/Bnd </th>
            {{-- <th> TPcs </th> --}}

            <th> Bnd </th>
            <th> Pcs/Bnd </th>
            {{-- <th> TPcs </th> --}}

            {{-- <th> Bundle </th>
            <th> Bnd/Pcs </th>
            <th> TotPcs </th> --}}
            <th> TotPcs </th>
            <th> Wt(MT) </th>
            <th> Rs($) </th>
            <th> Val($) </th>
            <th> <a href="#" class=" btn btn-primary addRow"> <i class="glyphicon glyphicon-plus"> </i>+</a></th>

        {{-- </div>
    </section> --}}
            {{-- <th>
            <a class="addRow" href="#">
                <i class="fa fa-edit fa-fw">add row</i>
            </th> --}}
            </thead>
        <tbody>
            <tr>
                <td>
                    {{-- <select class="form-control itmid0"  onchange="popTwo(this)" name="itmid0[]" id="itmid0" style="min-width:150px " > --}}
                    <select onchange="popTwo(this)" name="itmid0" id="itmid0" style="min-width:150px " >
                        <option value="" disabled >Category</option>
                        @foreach($grpdta as $grplist)
                            <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>
                            @endforeach
                    </select>
                </td>
            <td>
                <select class="form-control itmid"    name="itmid[]" id="itmid" style="min-width:150px " >
                        <option value="" >  -- select item ---  </option>
                </select>
            </td>
            <td>
                <select class="form-control itmsizeid" required name="itmsizeid[]" id="itmsizeid" style="min-width:100px " >
                    <option value="" disabled >Item Size</option>
                    @foreach($szedta as $szelist)
                        <option value="{{$szelist->szeid}}" >  {{$szelist->szename}}  </option>
                     @endforeach
                </select>

            </td>
            <td>
                <select class="form-control brandid" required name="brandid[]" id="brandid" style="min-width:100px " >
                    <option value="" disabled >Item Size</option>
                    @foreach($brddta as $brdlist)
                        <option value="{{$brdlist->bid}}" >  {{$brdlist->bname}}  </option>
                     @endforeach
                </select>
            </td>
            <td> <input type="text" class="form-control Bundles" name="bundle1[]" id="bundle1" style="min-width:50px "  > </td>
            <td> <input type="text" class="form-control Bundles" name="pcspbundle1[]" id="pcspbundle1" style="min-width:50px " > </td>
            <td> <input type="text" class="form-control Bundles2" name="bundle2[]" id="bundle2" style="min-width:50px " > </td>
            <td> <input type="text" class="form-control Bundles2" name="pcspbundle2[]" id="pcspbundle2" style="min-width:50px " > </td>
            <td> <input type="text" class="form-control ttpcs" name="ttpcs" id="ttpcs" disabled="true" style="min-width:80px " > </td>
            <td> <input type="text" class="form-control gdswt" name="gdswt" id="gdswt" style="min-width:70px " > </td>
            <td> <input type="text" class="form-control gdsprice" name="gdsprice" id="gdsprice" style="min-width:70px "  > </td>
            <td> <input type="text" class="form-control gamount" name="gamount" id="gamount" disabled="true" style="min-width:100px "  > </td>
            <td> <a href="javascript:;" class="btn btn-danger deletrow">- </a></td>
        </tr>
        </div>

        </tbody>




    </table>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
{{-- <script type="text/javascript">
    $(document).ready(function()
            {
                $('#supcode').select2();
                // $('#itmid0id').select2();
                // $('#itmidid').select2();
                // $('#itmsizeid').select2();

            });
    </script> --}}


@push('scripts')
<script>
    console.log('hworking')
document.addEventListener('DOMContentLoaded',()=>
console.log('hworking')
)
function popTwo(el){
console.log("dfadfds");
}
</script>
@endpush

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
{{--
<script>
jQuery(document).ready(function()
        {

            jQuery('#itmid0').change(function()

            {
                let cid=jQuery(this).val();
                //  alert(cid);
                jQuery.ajax({
                    url:'/getItem',
                    type:'post',
                    data:'cid='+cid+
                    '&_token={{CSRF_token()}}',
                    success:function(result)
                    {
                        //   jQuery('#itmid').html(result)
                        console.log(result);

                        //  jQuery('#itmid').append(html);
                    }


                    success: function(response)
                     {

                         var len=0;
                         if (respnose['itmid']!= null)
                         {
                             len=response['itmid'].length;
                                alert(len)
                            }

                         if(len>0)
                         {
                             for(var i=0;i<len;i++)
                             {
                                 var icode=response['itmid'][i].icode;
                                 var iname=response['itmid'][i].iname;

                                 var option="<option value='"+icode+"'>"+iname+"</option>";
                                 $('#itmid').append(option);
                             }

                         }


                     }
                })
            });

        });
        alert (id);
       alert (len);
</script> --}}

{{-- $('select').on('change', function() {
    alert( this.value );
  }); --}}



<script type="text/javascript">

        $('.addRow').on('click',function()
        {
            addRow();
        });
        function addRow()
        {
            var tr=' <tr>'+
            '    <td>'+
            '            <select class="form-control itmid0" required name="itmid0[]" id="itmid0id" style="min-width:150px " >'+
            '                <option value="" disabled >Category</option>'+
            '                @foreach($grpdta as $grplist)'+
            '                    <option value="{{$grplist->grpid}}" >  {{$grplist->grpname}}  </option>'+
            '                 @endforeach'+
            '            </select>'+
            '    </td>'+
            '<td>'+
            '    <select class="form-control itmid"   required name="itmid[]" id="itmidid" style="min-width:150px " >'+
            '        {{-- <option value="" disabled >Item</option> --}}'+
            '        {{-- @foreach($itmdta as $itmlist) --}}'+
            '            <option value="0" >  -- select item ---  </option>'+
            '         {{-- @endforeach --}}'+
            '    </select>'+
            '</td>'+
            '<td>'+
            '    <select class="form-control itmsizeid" required name="itmsizeid[]" id="itmsizeid" style="min-width:100px " >'+
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




</x-app-layout>
