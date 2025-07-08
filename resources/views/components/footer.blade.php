<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3>LandPage</h3>
            <p>Belajar lebih mudah dan fleksibel di platform kami.</p>
            <div class="social-icons">
                <a href="#" target="_blank"><img src="{{asset('image/facebook.png')}}" alt="Facebook" /></a>
                <a href="#" target="_blank"><img src="{{asset('image/instagram.png')}}" alt="Instagram" /></a>
                <a href="#" target="_blank"><img src="{{asset('image/tiktok.png')}}" alt="TikTok" /></a>
                <a href="#" target="_blank"><img src="{{asset('image/twitter.png')}}" alt="Twitter" /></a>
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
                <li><i class="fas fa-envelope"></i> support@landpage.com</li>
                <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                <li><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 LandPage. All rights reserved.</p>
    </div>
</footer>
<div class="chat-widget">
    <button class="chat-toggle" onclick="toggleChat()">💬 Live Chat</button>
    <div class="chat-box" id="chatBox">
        <div class="chat-header">
            <span>Chat with Support</span>
            <button onclick="toggleChat()">✖️</button>
        </div>
        <div class="chat-body" id="chatBody">
            <p><strong>Admin:</strong> Halo! Ada yang bisa kami bantu?</p>
        </div>
        <div class="chat-input">
            <input type="text" id="chatInput" placeholder="Ketik pesan..." onkeypress="sendMessage(event)" />
        </div>
    </div>
</div>