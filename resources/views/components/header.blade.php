<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Learnify')</title>
    <link rel="stylesheet" href="{{ asset('client/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @stack('styles')
</head>

<body>
    <header>
        <div class="container header-container">
            <div class="logo">LandPage</div>
            <div class="nav-center">
                <a href="{{ route('home.index') }}">Home</a>
                <a href="{{ route('course.index') }}">Course</a>
                <a href="#">About</a>
            </div>
            <div class="nav-right">
                <a href="{{ route('login.index') }}">Log In</a>
            </div>
        </div>
    </header>
    <section>
        @yield('content')
    </section>

    @include('components.footer')

    @stack('scripts')
    <script>
        function toggleChat() {
            const chat = document.getElementById("chatBox");
            chat.classList.toggle("active");
        }

        function sendMessage(event) {
            if (event.key === "Enter") {
                const input = document.getElementById("chatInput");
                const message = input.value.trim();
                if (message !== "") {
                    const body = document.getElementById("chatBody");
                    body.innerHTML += `<p><strong>You:</strong> ${message}</p>`;
                    input.value = "";
                    body.scrollTop = body.scrollHeight;
                }
            }
        }
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/686c8a4a0f70621913af115a/1ivjvodsr';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
