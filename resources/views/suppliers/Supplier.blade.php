@extends('dashboard')
@section('main-section')
<!doctype html >
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.css">

    {{-- <link rel="stylesheet" href={{ asset('css/style.css') }}> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}


</head>

<body onload="getfocustxt()"; class="bg-dark">


    {{-- id="frmsubmit" onsubmit="event.preventDefault()" --}}

<form  action="{{$url}}"   method="post"  >
@csrf
{{-- action="{{$url}}" --}}
<div class="container mt-3 ml-4">
    <div class='row'>
        @if($mode==1)
        <button  class="btn btn-primary  btn-lg disabled "  > <h3> {{$title}} </h3> </button>
        @else
        <button  class="btn btn-danger btn-lg disabled "  > <h3> {{$title}} </h3></button>
        @endif
    </div>

</div>

{{-- <div class="container py-3 text-left"> card p-2 bg-white"> --}}
{{-- <h3 class="text-center text-primary"> Title </h3> --}}
<!-- <span class = "label label-default">Default Label</span> -->

<div class="container">
    <div class="row ml-4">
                <div class="col py-3">
                    <div class="btn-toolbar ">
                        <div class="bt-group mr-3">
                            <button  class="btn btn-primary" >Refresh</button>
                            <button  class="btn btn-info">Main Screen</button>
                            <a href="redirect('/supplier/view')">
                                <button class="btn btn-danger">Data View</button> </a>
                        </div>
                    </div>
                    {{-- <i class="fa fa-align-right"></i> --}}
            </div>
    </div>
</div>

<div class="container mt-1 ml-4 card p-2 ">
  <div class='row ml-2'>
            <div class="form-group col-md-5  required">
                <label for="">name</label>
                    <input type="text" name="sname" id="sname"  class="form-control sup_form "  @if(isset($tblesupplier)) value="{{$tblesupplier->sname}}" @endif  placeholder="" aria-describedby="helpid">
                <span class="text-danger"> @error('sname') {{$message}} @enderror </span>
            </div>

            <div class="form-group col-md-2 required">
                <label for="">Knic Name</label>
                        <input type="text" name="snname" id="snname" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->snname}}" @endif  placeholder="" aria-describedby="helpid">
            </div>

            <div class="form-group col-md-2 sup_form required">
                <label for="">Source</label>
                <select id="srcId" name="srcId" class="custom-select" required="required">
                    <option value="" disabled>Please select a location</option>
                        @foreach($src as $list)
                            <option value="{{$list->srcId}}" @if(isset($tblesupplier)) {{ $list->srcId==$tblesupplier->srcId? 'selected':'' }} @else  {{ $list->srcId==1? 'selected':'' }} @endif  >  {{$list->srcName}}  </option>
                        @endforeach
                </select>
            </div>
    </div>

  <div class='row ml-2'>
        <div class="form-group col-md-3 required">
            <label for="">Email</label>
                    <input type="email" name="semail" id="semail" class="form-control sup_form " maxlength="30" @if(isset($tblesupplier)) value="{{$tblesupplier->semail}}" @endif   placeholder="" aria-describedby="helpid">
            <span class="text-danger"> @error('semail') {{$message}}  @enderror    </span>
        </div>

        <div class="form-group col-md-2 required">
                <label for="">Fax No</label>
                    <input type="text" name="sfax" id="sfax" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->sfax}}" @endif  placeholder="" aria-describedby="helpid">
        </div>



        <div class="form-group col-md-2 required">
            <label for="">Phone-Office</label>
                <input type="text" name="sphoneoff" id="sphoneoff" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->sphoneoff}}" @endif  placeholder="" aria-describedby="helpid">
        </div>

        <div class="form-group col-md-2 required">
            <label for="">Phone-Residence</label>
                <input type="text" name="sphoneres" id="sphoneres" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->sphoneres}}" @endif   placeholder="" aria-describedby="helpid">
        </div>
  </div>


  <div class='row ml-2'>
        <div class="form-group col-md-2 required">
            <label for="">NTN No</label>
                <input type="text" name="ntnno" id="ntnno" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->ntnno}}" @endif   placeholder="" aria-describedby="helpid">
        </div>

        <div class="form-group col-md-2 required">
            <label for="">Sale Rej. No</label>
                <input type="text" name="staxNo" id="staxNo" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->staxNo}}" @endif   placeholder="" aria-describedby="helpid">
        </div>

        <div class="form-group col-md-2 required">
            <label for="">Opening Balance</label>
                <input type="text" name="obalance" id="obalance" class="form-control sup_form " @if(isset($tblesupplier)) value="{{$tblesupplier->obalance}}" @endif  placeholder="" aria-describedby="helpid">
        </div>



        <div class="form-group col-md-4  required">
            <label for="">Active Status</label>
            <br/>
            @if(isset($tblesupplier))
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sstatus" id="Stop" value="Stop" {{ ($tblesupplier->sstatus=="Stop")? "checked":"" }}>
                        <label class="form=check-label" for ="Stop">Stop </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sstatus" id="Active" value="Active" {{ ($tblesupplier->sstatus=="Active")? "checked":"" }} >
                        <label class="form=check-label" for ="Active">Active </label>
                    </div>

            @else
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sstatus" id="Active" value="Active" checked />
                        <label class="form=check-label" for ="Active">Active </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sstatus" id="Stop" value="Stop" />
                        <label class="form=check-label" for ="Stop">Stop </label>
                    </div>
            @endif



        </div>

</div>
<div class='row ml-2'>
    <div class="form-group col-md-9 ">
        <label for="">Address</label>
            <textarea row="2" col="5" type="textarea" name="spaddress" id="spaddress" class="form-control sup "    placeholder="" aria-describedby="helpid"> @if(isset($tblesupplier)) {{ $tblesupplier->spaddress }} @endif </textarea>
    </div>
</div>
{{-- end rows --}}

    {{-- </a> --}}
    <div class="container col-6 ">
        <button class="btn btn-primary mt-2  float-right ">Save Record</button>
    </div>


</div>

<div class="container">
    <div class="row ml-4">
        @if($mode==1)
        <button  class="btn btn-primary btn-lg disabled "  > </button>
        @else
        <button  class="btn btn-danger btn-lg disabled "  > </button>
        @endif
    </div>
 </div>



</form>

<script>
function getfocustxt()
{
document.getElementById(sname.focus());

}

</script>

<script>
var allFields = document.querySelectorAll( ".sup_form ");
for (var i = 0;i < allFields.length;i++)
{

    allFields[i].addEventListener("keyup",function(event)
    {
        if (event.keyCode===13)
        {
            event.preventDefault();
                // if (this.parentElement.nextElementSibling.querySelector('input'))
                // {
                    console.log(this.parentElement.nextElementSibling)
                    this.parentElement.nextElementSibling.querySelector('input').focus();
                // }
        }
    });
}

</script>

<script>
    jQuery('#frmsubmit').submit(function(e)
    {
    e.preventDefault();
    jQuery.ajax({
    url:"{{$url}}",
    data:jQuery('#frmsubmit').serialize(),
    type:'post',success:function(result)
    {
    jQuery('#message'),html(result.msg);
    Jquery('#frmsubmit') [''].reset();
    }
    });
    </script>




</body>

</html>

@endsection
