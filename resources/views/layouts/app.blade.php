{{-- @extends('layouts.auth') --}}
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css' integrity='sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ==' crossorigin='anonymous'/>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @stack('styles')
        {{-- Snackbar --}}
        <style>
            /* Learn More : https://www.w3schools.com/howto/howto_js_snackbar.asp */
            /* The snackbar - position it at the bottom and in the middle of the screen */

            #snackbar {
                visibility: hidden; /* Hidden by default. Visible on click */
                min-width: 250px; /* Set a default minimum width */
                margin-left: -125px; /* Divide value of min-width by 2 */
                background-color: #333; /* Black background color */
                color: #fff; /* White text color */
                text-align: center; /* Centered text */
                border-radius: 2px; /* Rounded borders */
                padding: 16px; /* Padding */
                position: fixed; /* Sit on top of the screen */
                z-index: 1; /* Add a z-index if needed */
                left: 50%; /* Center the snackbar */
                bottom: 30px; /* 30px from the bottom */
            }

            /* Show the snackbar when clicking on a button (class added with JavaScript) */
            #snackbar.show {
                visibility: visible; /* Show the snackbar */
                /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
                However, delay the fade out process for 2.5 seconds */
                -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
                animation: fadein 0.5s, fadeout 0.5s 2.5s;
            }

            /* Animations to fade the snackbar in and out */
            @-webkit-keyframes fadein {
                from {bottom: 0; opacity: 0;}
                to {bottom: 30px; opacity: 1;}
            }

            @keyframes fadein {
                from {bottom: 0; opacity: 0;}
                to {bottom: 30px; opacity: 1;}
            }

            @-webkit-keyframes fadeout {
                from {bottom: 30px; opacity: 1;}
                to {bottom: 0; opacity: 0;}
            }

            @keyframes fadeout {
                from {bottom: 30px; opacity: 1;}
                to {bottom: 0; opacity: 0;}
            }
        </style>
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-blue-100">

            @include('layouts.navigation')




            {{-- @include('layouts.auth') --}}
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- The actual snackbar -->
        <div id="snackbar" class="hidden">
            <span></span>
            <span></span>
        </div>

        @stack('scripts')
        {{-- Snackbar --}}
        <script>
            // Snackbar Setup
            var div = document.getElementById("snackbar"); // Snackbar
            function showSnackbar() {
                var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0]: "some error";
                var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "default";
                var seconds = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 3000;

                // console.log(message);
                // div.innerText = message;
                var span1 = div.getElementsByTagName('span')[0];
                var span = div.getElementsByTagName('span')[1];
                span.innerHTML = message;

                // console.log(i);
                // console.log(span);

                switch (type) {
                    case "success":
                    div.style.backgroundColor = "green";
                    span1.innerHTML = '<i class="fa fa-fw fa-check-circle text-white"></i>';
                    break;

                    case "info":
                    div.style.backgroundColor = "blue";
                    span1.innerHTML = '<i class="fa fa-fw fa-info-circle text-white"></i>';
                    break;

                    case "error":
                    div.style.backgroundColor = "red";
                    span1.innerHTML = '<i class="fa fa-fw fa-exclamation-circle text-white"></i>';
                    break;

                    default:
                    break;
                }
                div.className = div.className.replace("hidden", "show");
                setTimeout(function () {
                    div.className = div.className.replace("show", "hidden");
                }, seconds);
            }
            // Snackbar
            @if(Session::has('success'))
                showSnackbar(@json(Session::get('success')),"success");
            @elseif(Session::has('info'))
                showSnackbar(@json(Session::get('info')),"info");
            @elseif(Session::has('error'))
                showSnackbar(@json(Session::get('error')),"error");
            @endif
        </script>
    </body>


</html>
