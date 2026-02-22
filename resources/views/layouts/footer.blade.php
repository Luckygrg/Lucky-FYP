<footer class="luxury-footer">
        <div class="luxury-footer-container">
            <div class="luxury-footer-grid">
                
                <!-- About Section -->
                <div class="luxury-footer-section">
                    <h3>About SpaLush</h3>
                    <p>Your premier destination for wellness and relaxation in Nepal. We connect you with the finest spa and wellness experiences, curated for those who seek tranquility and rejuvenation.</p>
                </div>

                <!-- Quick Links -->
                <div class="luxury-footer-section">
                    <h3>Explore</h3>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="#services">Our Spas</a></li>
                        <li><a href="#experiences">Experiences</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="luxury-footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li>Pokhara, Nepal</li>
                        <li>+977-9800000000</li>
                        <li>info@spalush.com</li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="luxury-footer-section">
                    <h3>Stay Connected</h3>
                    <p style="margin-bottom: 15px; font-size: 13px;">Be the first to discover our latest offerings and exclusive wellness experiences.</p>
                    <div class="luxury-social-links">
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="Twitter">TW</a>
                        <a href="#" aria-label="LinkedIn">IN</a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="luxury-copyright">
                <p>&copy; {{ date('Y') }} SpaLush. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        /* Luxury Footer Styles */
        .luxury-footer {
            background: #1a1a1a;
            color: rgba(255,255,255,0.7);
            padding: 80px 0 30px;
            margin-top: 0;
        }
        
        .luxury-footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }
        
        .luxury-footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 50px;
        }
        
        .luxury-footer-section h3 {
            color: #c9a961;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Georgia', serif;
        }
        
        .luxury-footer-section p {
            color: rgba(255,255,255,0.6);
            line-height: 1.8;
            font-size: 14px;
            font-weight: 300;
        }
        
        .luxury-footer-section ul {
            list-style: none;
            padding: 0;
        }
        
        .luxury-footer-section li {
            margin-bottom: 12px;
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            font-weight: 300;
        }
        
        .luxury-footer-section a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }
        
        .luxury-footer-section a:hover {
            color: #c9a961;
        }
        
        .luxury-social-links {
            display: flex;
            gap: 15px;
        }
        
        .luxury-social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .luxury-social-links a:hover {
            background: #c9a961;
            border-color: #c9a961;
            color: #1a1a1a;
        }
        
        .luxury-copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            text-align: center;
        }
        
        .luxury-copyright p {
            color: rgba(255,255,255,0.4);
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 300;
        }
        
        @media (max-width: 768px) {
            .luxury-footer {
                padding: 60px 0 30px;
            }
            
            .luxury-footer-container {
                padding: 0 20px;
            }
            
            .luxury-footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
    </style>

</body>
</html>