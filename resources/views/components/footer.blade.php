<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<footer class="site-footer">
    <footer class="site-footer" data-aos="fade-up" data-aos-duration="500">
        <div class="footer-container">
            <div class="footer-brand">
                <h3>LandPage</h3>
                <p>Belajar lebih mudah dan fleksibel di platform kami.</p>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-tiktok fa-2x"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                </div>

            </div>

            <div class="footer-links">
                <h4>Menu</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact</h4>
                <ul>
                    @if ($contact)
                        <li>Email: {{ $contact->email }}</li>
                        <li>Telepon: {{ $contact->phone_number }}</li>
                        <li>
                            Lokasi: <a href="{{ $contact->location_url }}" target="_blank" class="underline">
                                {{ $contact->location_label }}
                            </a>
                        </li>
                    @else
                        <pre>{{ var_dump($contact) }}</pre>

                        <li>Data kontak belum tersedia</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 LandPage. All rights reserved.</p>
        </div>

    </footer>
