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
                <a href="{{ route('home.index')}}">Home</a>
                <a href="{{ route('course.index')}}">Course</a>
                <a href="#">About</a>
            </div>
            <div class="nav-right">
                <a href="{{ route ('login.index') }}">Log In</a>
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
</body>

</html>