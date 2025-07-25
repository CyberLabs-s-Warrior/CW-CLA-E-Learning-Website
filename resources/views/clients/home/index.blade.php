<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Learnify')</title>
    <link rel="stylesheet" href="{{ asset('client/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/footer.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @stack('styles')
    <style>
        header {
            padding: 20px 0;
            background-color: #f9fbfc;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            font-weight: 700;
            font-size: 1.6em;
        }

        .nav-center {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-center a,
        .nav-right a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 1em;
        }
    </style>
</head>

<body>
    <header>
        <div class="container header-container">
            <div class="title">LandPage</div>
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

    <main class="hero">
        <div class="container hero-content">
            <div class="text-content">
                <h1>
                    Learn and grow <br />
                    your skills
                </h1>
                <p>
                    Take your learning to the next level. Join our platform and explore
                    a variety of online courses.`
                </p>
                <a href="#" class="btn">Get Started</a>
            </div>
            <div class="image">
                <img src="{{ asset('image/iconpage.png') }}" alt="Foto Profil" class="main-img" />
            </div>
        </div>
    </main>
    <section class="learning-paths">
        <div class="container">
            <h2 class="section-title">Learning Paths</h2>
            <div class="card-container">
                <div class="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/1055/1055687.png" alt="Web Development"
                        class="card-icon" />
                    <h3>Web Development</h3>
                    <p><span class="badge">49k</span> students</p>
                    <a href="#" class="view-link">View Path</a>
                </div>

                <div class="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/2920/2920257.png" alt="Mobile Development"
                        class="card-icon" />
                    <h3>Mobile Development</h3>
                    <p><span class="badge">138k</span> students</p>
                    <a href="#" class="view-link">View Path</a>
                </div>

                <div class="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/3799/3799931.png" alt="Data Science"
                        class="card-icon" />
                    <h3>Data Science</h3>
                    <p><span class="badge">164k</span> students</p>
                    <a href="#" class="view-link">View Path</a>
                </div>

                <div class="card">
                    <img src="https://cdn-icons-png.flaticon.com/512/5977/5977585.png" alt="Machine Learning"
                        class="card-icon" />
                    <h3>Machine Learning</h3>
                    <p><span class="badge">191k</span> students</p>
                    <a href="#" class="view-link">View Path</a>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">What Our Students Say</h2>
            <div class="testimonial-container">
                <div class="testimonial-card">
                    <p class="testimonial-text">
                        “This platform helped me land my first job as a web developer. The
                        courses are very clear and easy to follow!”
                    </p>
                    <div class="testimonial-user">
                        <img src="https://randomuser.me/api/portraits/women/49.jpg" alt="Student"
                            class="testimonial-img" />
                        <div>
                            <h4>Sarah Johnson</h4>
                            <span>Web Development Student</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">
                        “I love how flexible the learning schedule is. I can study at my
                        own pace and still get quality content.”
                    </p>
                    <div class="testimonial-user">
                        <img src="https://randomuser.me/api/portraits/men/35.jpg" alt="Student"
                            class="testimonial-img" />
                        <div>
                            <h4>Michael Lee</h4>
                            <span>Mobile Development Student</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <p class="testimonial-text">
                        “The data science path was exactly what I needed to start
                        freelancing. Highly recommend this platform!”
                    </p>
                    <div class="testimonial-user">
                        <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Student"
                            class="testimonial-img" />
                        <div>
                            <h4>David Kim</h4>
                            <span>Data Science Student</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="instructors-split">
        <div class="container">
            <h2 class="section-title">Meet Our Instructors</h2>
            <div class="split-wrapper">
                <!-- Kiri -->
                <div class="split-left">
                    <div class="instructor-box">
                        <img src="https://randomuser.me/api/portraits/men/10.jpg" alt="Instructor" class="photo" />
                        <div class="info">
                            <h3>Prof. Dimas Aditya</h3>
                            <p>Machine Learning Expert with 15+ years experience.</p>
                            <span class="badge">15k students</span>
                        </div>
                    </div>

                    <div class="instructor-box">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Instructor" class="photo" />
                        <div class="info">
                            <h3>Dr. Nabila Putri</h3>
                            <p>Data Science Lecturer and AI Researcher.</p>
                            <span class="badge">12k students</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="split-right">
                    <div class="instructor-box">
                        <img src="https://randomuser.me/api/portraits/men/14.jpg" alt="Instructor" class="photo" />
                        <div class="info">
                            <h3>Arief Nugroho, M.Kom</h3>
                            <p>Senior Web Developer & Fullstack Instructor.</p>
                            <span class="badge">18k students</span>
                        </div>
                    </div>

                    <div class="instructor-box">
                        <img src="https://randomuser.me/api/portraits/women/15.jpg" alt="Instructor"
                            class="photo" />
                        <div class="info">
                            <h3>Intan Fadilah, M.T</h3>
                            <p>Mobile Developer and UI/UX Design Expert.</p>
                            <span class="badge">10k students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
