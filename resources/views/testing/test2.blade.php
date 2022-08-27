<!doctype html >
<html  >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

<head>
    <title>SIDE MENUE BAR CSS</title>

 <link href="{{ asset('css/style.css')}}" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- <style>
    .container{overflow: hidden}
    .tab{float: left;}
    .tab-2{margin-left: 50px;}
    .tab-2 input{display: block;margin-bottom: 20px}
    tr{transition: all .25s ease-in-out}
    tr:hover{background-color:#EEE;cursor: pointer; }
</style> --}}
</head>
<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn">  </i>
        <i class="fas fa-times" id="cancel">  </i>
    </label>
    <div class="sidebar">
        <header> Main Menu</header>
        <ul>
            <li> <a href="{{ url('/testing/test2/1')}} "><i class="fas fa-qrcode"></i> Master Setup </a>  </li>
            <li> <a href="{{ url('/testing/test2/2')}} "><i class="fas fa-link"></i>Transaction </a>  </li>
            <li> <a href="{{ url('/testing/test2/3')}} "><i class="fas fa-stream"></i> Reports </a>  </li>
            <li> <a href="#"><i class="fas fa-calendar-week"></i>Utility</a>   </li>
            <li> <a href="#"><i class="fas fa-question-circle"></i>Permission Setup</a>   </li>
            <li> <a href="#"><i class="fas fa-sliders-h"></i>Locking </a>  </li>
            <li> <a href="#"><i class="fas fa-envelope"></i>About </a>  </li>
        </ul>

    </div>
<div>
    <select id="month" name="month" style="width:250px">
        {{-- <option value="January"> january </option>
        <option value="February"> February </option>
        <option value="March"> March </option>
        <option value="April"> April </option>
        <option value="5"> May </option>
        <option value="6"> june </option>
        <option value="7"> july </option>
        <option value="8"> August </option>
        <option value="9"> Septmenber </option> --}}
        <option value="" disabled >Select careof</option>
        @if(isset($co))
            @foreach($co as $list)
            <option value="{{$list->mmid}}"> {{$list->smenuname}}   </option>
            @endforeach
        @endif




    </select>
</div>


{{-- <div class="container">
    <div class="tab tab-1">
        <table id="table" border="1">
            <tr>
                <th> First Name </th>
                <th> Last Name </th>
                <th> Age </th>
            </tr>
        </table>
    </div>
</div> --}}

{{-- <div class="tab tab-2">
first name:<input type="text" name="fname" id="fname">
Last name:<input type="text" name="lname" id="lname">
Age:<input type="number" name="age" id="age">

<button onclick="addHtmlTableRow();"> add </button>
<button onclick="EditHtmlTableRow();"> edit </button>
<button onclick="DelSelectedRow();"> remove </button>

</div> --}}


<script>
// var rindex,table=document.getElementById("table");

// function checkEmptyInput()
// {
//     var isEmpty=false,
//     fname=document.getElementById("fname").value,
//     lname=document.getElementById("lname").value,
//     age=document.getElementById("age").value;

//     if (fname==="") {
//         alert("First name cat not empty")
//         isEmpty=true;
//     }
//     if (lname==="") {
//         alert("Last name cat not empty")
//         isEmpty=true;
//     }
// }



// function addHtmlTableRow()
// {

// if(!checkEmptyInput())
// {
//     var newRow=table.insertRow(table.length),
//     cell1=newRow.insertCell(0),
//     cell2=newRow.insertCell(1),
//     cell3=newRow.insertCell(2),
//     fname=document.getElementById("fname").value,
//     lname=document.getElementById("lname").value,
//     age=document.getElementById("age").value;

//     cell1.innerHTML=fname;
//     cell2.innerHTML=lname;
//     cell3.innerHTML=age;

//     // For textbox clear
//     document.getElementById("fname").value="";
//     document.getElementById("lname").value="";
//     document.getElementById("age").value="";
// }

// SelectedRowToInput();
// }

// function SelectedRowToInput()
// {


// for(var i=1;i < table.rows.length;i++)
// {
// table.rows[i].onclick=function()

// {
//     rindex=this.rowIndex;
//     // console.log(rindex);
//     document.getElementById("fname").value=this.cells[0].innerHTML;
//     document.getElementById("lname").value=this.cells[1].innerHTML;
//     document.getElementById("age").value=this.cells[2].innerHTML;

// };
// }
// }
// // SelectedRowToInput();
// function EditHtmlTableRow()
// {
//     var fname = document.getElementById("fname").value,
//         lname = document.getElementById("lname").value,
//         age = document.getElementById("age").value;

//         table.rows[rindex].cells[0].innerHTML = fname;
//         table.rows[rindex].cells[1].innerHTML = lname;
//         table.rows[rindex].cells[2].innerHTML = age;
//         rindex=-1;
// }

// function DelSelectedRow()
// {
//     table.deleteRow(rindex);
//     document.getElementById("fname").value="";
//     document.getElementById("lname").value="";
//     document.getElementById("age").value="";

// }


</script>
<script type="text/javascript">
$(document).ready(function()
{
    $('#month').select2();
})
</script>

</body>
</html>
