<!doctype html >
<html  >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

<head>
    <title>SIDE MENUE BAR CSS</title>

 {{-- <link href="{{ asset('css/style.css')}}" rel="stylesheet"> --}}
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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







</body>
</html>
