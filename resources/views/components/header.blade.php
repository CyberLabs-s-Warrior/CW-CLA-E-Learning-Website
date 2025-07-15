<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Learnify')</title>
    <link rel="stylesheet" href="{{ asset('client/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .form-field {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-icon-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
        }

        .edit-icon-overlay:hover {
            opacity: 1;
            cursor: pointer;
        }

        .btn-primary,
        .btn-secondary {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
    </style>
    @stack('styles')
</head>

<body>
    <header>
        <div class="container header-container"
            style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
            <div class="logo">LandPage</div>
            <div class="nav-center" style="display: flex; gap: 30px;">
                <a href="{{ route('home.index')}}">Home</a>
                <a href="{{ route('course.index')}}">Course</a>
                <a href="{{ route('about.index')}}">About</a>

            </div>

            {{-- login button --}}

            <div class="nav-right">
                <a href="{{ route('login.index') }}">Log In</a>
            </div>


            {{-- <div class="nav-right" style="position: relative;">
                <div id="profile-btn" style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                    <img src="https://ui-avatars.com/api/?name=User" alt="avatar"
                        style="width: 32px; height: 32px; border-radius: 50%;" />
                    <span>Username</span>
                    <i class="fas fa-caret-down"></i>
                </div>

                <!-- Dropdown -->
                <div id="dropdown-menu"
                    style="display: none; position: absolute; top: 120%; right: 0; background: white; border: 1px solid #ddd; padding: 10px; border-radius: 5px; width: 150px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div id="setting-btn" style="padding: 5px 10px; cursor: pointer;">Setting</div>
                    <div style="padding: 5px 10px; cursor: pointer;">Logout</div>
                </div>
            </div> --}}
        </div>
    </header>

    <!-- Setting Modal -->
    <div id="setting-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
        background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">

        <div id="setting-content" style="background: white; padding: 30px; border-radius: 10px;
            width: 90%; max-width: 500px; position: relative; transform: scale(0.9); opacity: 0;
            transition: all 0.3s ease;">

            <h2 style="margin-bottom: 20px;">Edit Profil</h2>

            <form>
                <!-- Foto Profile -->
                <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <div style="position: relative; width: 120px; height: 120px;">
                        <img id="profile-preview" src="https://ui-avatars.com/api/?name=User" alt="Foto Profil"
                            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; cursor: pointer;">
                        <div class="edit-icon-overlay">
                            <i class="fas fa-pen text-white" style="font-size: 20px;"></i>
                        </div>
                        <input type="file" id="profile-input" accept="image/*" style="display: none;">
                    </div>
                </div>

                <label>Nama:</label>
                <input type="text" class="form-field" placeholder="Nama"><br><br>

                <label>Email:</label>
                <input type="email" class="form-field" placeholder="Email"><br><br>

                <label>Password:</label>
                <input type="password" class="form-field" placeholder="Password"><br><br>

                <label>Nomor HP:</label>
                <input type="text" class="form-field" placeholder="Nomor HP"><br><br>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" id="cancel-btn" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Ganti</button>
                </div>
            </form>
        </div>
    </div>

    <section>
        @yield('content')
    </section>
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
    @include('components.footer')
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
