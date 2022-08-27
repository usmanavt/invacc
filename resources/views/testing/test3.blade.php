<!doctype html >
<html  >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

<head>
    <title>SIDE MENUE BAR CSS</title>

 {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>
<body>
    <nav id="sidebarMenu" class="px-0 pe-0 pt-0 sidebar sidebar-sticky animate__fadeInUpBig animate__animated scroller">
        <div class="position-sticky sidebar-scroll">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1">
                <span>Menu</span>
            </h6>
            <ul class="nav flex-column" id="metismenu">
                <li class="nav-item mm-active">
                    <a class="nav-link" href="#" aria-expanded="true">
                        <span data-feather="home"></span>
                        <span class="category-name">Dashboard</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level" aria-expanded="true">
                        <li class="nav-item"><a class="nav-link" href="/home"><span data-feather="circle"></span> Analytics</a></li>
                        <li class="nav-item"><a class="nav-link" href="/dashboard-demographic"><span data-feather="circle"></span> Demographic</a></li>
                        <li class="nav-item"><a class="nav-link" href="/dashboard-project"><span data-feather="circle"></span> Project</a></li>
                        <li class="nav-item"><a class="nav-link" href="/dashboard-hospital"><span data-feather="circle"></span> Hospital</a></li>
                        <li class="nav-item"><a class="nav-link" href="/dashboard-hrm"><span data-feather="circle"></span> HRM Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/dashboard-real-estate"><span data-feather="circle"></span> Real Estate</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" aria-expanded="true">
                        <span data-feather="settings"></span>
                        <span class="category-name">E-Commerce</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level mm-collapse" aria-expanded="true">
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-dashboard"><span data-feather="circle"></span> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-products"><span data-feather="circle"></span> Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-product-detail"><span data-feather="circle"></span> Product Detail</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-add-product"><span data-feather="circle"></span> Add Product</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-orders"><span data-feather="circle"></span> Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-cart"><span data-feather="circle"></span> Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="/ecommerce-checkout"><span data-feather="circle"></span> Checkout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    </div>







<script>



</script>
{{-- <script type="text/javascript">
$(document).ready(function()
{
    $('#month').select2();
})
</script> --}}

</body>
</html>
