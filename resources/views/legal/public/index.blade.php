<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    
    <title>DIGI MC - Legal Information Portal</title>
    
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #e8e8e8;
            overflow-x: hidden;
        }

        /* Purple Wave Decorations */
        .wave-decoration {
            position: fixed;
            z-index: 0;
        }

        .wave-top-left {
            top: 0;
            left: 0;
            width: 470px;
            height: 395px;
            background-image: url("{{ asset('Top-left.svg') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top left;
        }

        .wave-bottom-right {
            bottom: 0;
            right: 0;
            width: 470px;
            height: 395px;
            background-image: url("{{ asset('Bottom-Right.svg') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: bottom right;
        }

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: transparent;
            padding: 1.5rem 0;
            position: relative;
            z-index: 10;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #6b21a8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand .legal {
            color: #6b21a8;
        }

        .navbar-brand .it {
            color: #f59e0b;
        }

        .navbar-brand .ease {
            color: #6b21a8;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .navbar-menu a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #6b21a8;
        }

        .btn-signin {
            background: #6b21a8;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(107, 33, 168, 0.3);
        }

        .btn-signin:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(107, 33, 168, 0.4);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 4rem 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .logo-container {
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            width: 180px;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .hero-title .highlight {
            color: #6b21a8;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-chat {
            background: #6b21a8;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(107, 33, 168, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-chat:hover {
            background: #7c3aed;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(107, 33, 168, 0.4);
        }

        /* Features Section */
        .features-section {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .feature-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .feature-icon.info {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .feature-description {
            font-size: 0.95rem;
            color: #6b7280;
            line-height: 1.6;
        }

        /* Services Section */
        .services-section {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .service-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .service-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .service-description {
            font-size: 0.85rem;
            color: #6b7280;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 3rem 2rem 2rem;
            margin-top: 4rem;
            border-top: 1px solid #e5e7eb;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h6 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .footer-section p,
        .footer-section a {
            font-size: 0.85rem;
            color: #6b7280;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #6b21a8;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.85rem;
        }

        /* Responsive Design */
        @media (max-width: 968px) {
            .wave-top-left {
                width: 250px;
                height: 210px;
            }

            .wave-bottom-right {
                width: 300px;
                height: 250px;
            }

            .navbar-menu {
                display: none;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .wave-top-left {
                width: 180px;
                height: 150px;
            }

            .wave-bottom-right {
                width: 220px;
                height: 180px;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .logo-container img {
                width: 140px;
            }
        }
    </style>
</head>

<body>
    
    <!-- Purple Wave Decorations -->
    <div class="wave-decoration wave-top-left"></div>
    <div class="wave-decoration wave-bottom-right"></div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-container">
                <a href="{{ route('legal.public.index') }}" class="navbar-brand">
                    <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
                </a>
                <ul class="navbar-menu">
                    <li><a href="{{ route('legal.public.index') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="#about"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="#services"><i class="fas fa-briefcase"></i> Services</a></li>
                    <li><a href="{{ route('user.login') }}" class="btn-signin"><i class="fas fa-sign-in-alt"></i> Sign In</a></li>
                </ul>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="logo-container">
                <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Malaybalay Logo">
            </div>
            <h1 class="hero-title">
                Welcome to <span class="highlight">DIGI MC</span> Legal Portal
            </h1>
            <p class="hero-subtitle">
                Access legal documents, gazettes, and information with ease. 
                Our AI-powered chatbot is here to assist you 24/7.
            </p>
            <button class="btn-chat" onclick="openChatbot()">
                <i class="fas fa-comments"></i>
                Chat with Legal Assistant
            </button>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="about">
            <h2 class="section-title">Our Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="feature-title">Legal Documents</h3>
                    <p class="feature-description">
                        Browse and access a comprehensive collection of legal documents, 
                        including Republic Acts, Memorandums, and Proclamations.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon success">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="feature-title">Official Gazette</h3>
                    <p class="feature-description">
                        Stay updated with the latest official gazettes and 
                        government publications in one convenient location.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon info">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="feature-title">AI Assistant</h3>
                    <p class="feature-description">
                        Get instant answers to your legal questions with our 
                        AI-powered chatbot assistant, available 24/7.
                    </p>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section" id="services">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-books"></i>
                    </div>
                    <h4 class="service-title">Document Repository</h4>
                    <p class="service-description">Access thousands of legal documents</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="service-title">Search & Filter</h4>
                    <p class="service-description">Find documents quickly and easily</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h4 class="service-title">Download & Share</h4>
                    <p class="service-description">Save and share documents securely</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="service-title">AI Support</h4>
                    <p class="service-description">Get instant answers 24/7</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h6>DIGI MC</h6>
                    <p>Your trusted source for legal information and documentation.</p>
                </div>
                <div class="footer-section">
                    <h6>Resources</h6>
                    <a href="#">Documents</a>
                    <a href="#">Gazette</a>
                </div>
                <div class="footer-section">
                    <h6>Help & Support</h6>
                    <a href="#">Contact Us</a>
                    <a href="#">FAQ</a>
                </div>
                <div class="footer-section">
                    <h6>Legal</h6>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} DIGI MC. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Chatbot Component -->
    @include('components.chatbot')

    <script>
        // Function to open chatbot from the main CTA button
        function openChatbot() {
            const chatbotButton = document.getElementById('chatbot-button');
            const chatbotWindow = document.getElementById('chatbot-window');
            
            if (chatbotWindow && chatbotWindow.style.display === 'none') {
                chatbotButton.click();
            }
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
