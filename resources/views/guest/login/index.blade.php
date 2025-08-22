<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('client/login.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <h1>Create Account</h1>
                <span>Use your data to register</span>

                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                @error('name') <small style="color:red">{{ $message }}</small> @enderror

                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required />
                @error('username') <small style="color:red">{{ $message }}</small> @enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                @error('email') <small style="color:red">{{ $message }}</small> @enderror

                <input type="text" name="phone" placeholder="No HP" value="{{ old('phone') }}" required />
                @error('phone') <small style="color:red">{{ $message }}</small> @enderror

                <input type="password" name="password" placeholder="Password" required />
                @error('password') <small style="color:red">{{ $message }}</small> @enderror

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

                <button type="submit">Sign Up</button>
            </form>


        </div>
        <div class="form-container sign-in-container">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf 
                <h1>Sign in</h1>
                <input type="email" name="email" placeholder="Email" required />
                    @error('email')
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                <input type="password" name="password" placeholder="Password" required />

                <a href="{{ route('password.request') }}">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

 
        <script>
            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');

            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
            });

            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
            });
        </script>
</body>

</html>
