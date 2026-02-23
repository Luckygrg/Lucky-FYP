@extends('layouts.main')

@section('title', 'About Us - SpaLush')

@section('content')

<style>
    .about-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=1920') center/cover;
        padding: 100px 20px;
        text-align: center;
        color: white;
    }
    
    .about-hero h1 {
        font-size: 48px;
        font-weight: 300;
        letter-spacing: 2px;
        margin-bottom: 15px;
        font-family: 'Georgia', serif;
    }
    
    .about-nav {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: sticky;
        top: 80px;
        z-index: 100;
    }
    
    .about-nav-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        gap: 50px;
        padding: 20px;
    }
    
    .about-nav-link {
        color: #666;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 500;
        padding: 10px 0;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .about-nav-link:hover,
    .about-nav-link.active {
        color: #c9a961;
        border-bottom-color: #c9a961;
    }
    
    .about-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 40px;
        scroll-margin-top: 150px;
    }
    
    .section-title {
        font-size: 42px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 40px;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
        text-align: center;
    }
    
    .section-content {
        color: #666;
        font-size: 16px;
        line-height: 1.8;
        text-align: justify;
    }
    
    .section-content p {
        margin-bottom: 20px;
    }
    
    .mission-vision-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        margin-top: 40px;
    }
    
    .mission-box,
    .vision-box {
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        position: relative;
    }
    
    .mission-box::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #c9a961;
    }
    
    .vision-box::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #1a1a1a;
    }
    
    .box-title {
        font-size: 28px;
        font-weight: 400;
        color: #1a1a1a;
        margin-bottom: 20px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }
    
    .box-content {
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }
    
    .history-section {
        background: #f8f9fa;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #c9a961;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 24px;
        font-weight: 300;
        color: #666;
        margin-bottom: 10px;
        font-family: 'Georgia', serif;
    }
    
    @media (max-width: 768px) {
        .about-nav-container {
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .mission-vision-grid {
            grid-template-columns: 1fr;
        }
        
        .about-hero h1 {
            font-size: 32px;
        }
        
        .section-title {
            font-size: 32px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Hero Section -->
<section class="about-hero">
    <h1>About SpaLush</h1>
    <p>Your Premier Spa Booking Platform</p>
</section>

<!-- Navigation Tabs -->
<nav class="about-nav">
    <div class="about-nav-container">
        <a href="#welcome" class="about-nav-link">Welcome To SpaLush</a>
        <a href="#mission-vision" class="about-nav-link">Mission and Vision</a>
    </div>
</nav>

<!-- Welcome Section -->
<section id="welcome" class="about-section">
    <h2 class="section-title">WELCOME TO SPALUSH</h2>
    <div class="section-content">
        <p>
            SpaLush is a pioneering digital wellness platform that revolutionizes the spa and wellness booking experience in Nepal. 
            Established with a vision to bridge the gap between customers seeking premium spa services and establishments offering 
            them, SpaLush combines cutting-edge technology with a commitment to wellness excellence. Our platform is designed to 
            provide customers with seamless access to quality spa services while enabling spa owners to operate efficiently through 
            organized appointment management and customer relationship tools. We are dedicated to transforming the traditional 
            manual spa booking process into a modern, transparent, and user-friendly online experience that prioritizes both customer 
            satisfaction and business growth.
        </p>
        <p>
            Through our comprehensive web-based platform, we have successfully eliminated the challenges of phone calls, walk-ins, 
            and scheduling conflicts that have long plagued the spa industry. SpaLush stands as a testament to innovation, providing a 
            peaceful and organized environment where customers can discover, book, and enjoy spa and wellness treatments with 
            confidence and convenience. We are committed to setting the gold standard in digital wellness solutions while honoring 
            the traditions of quality spa care.
        </p>
    </div>
</section>

<!-- Mission and Vision Section -->
<section id="mission-vision" class="about-section">
    <h2 class="section-title">MISSION AND VISION</h2>
    <div class="mission-vision-grid">
        <div class="mission-box">
            <h3 class="box-title">MISSION</h3>
            <div class="box-content">
                <p>
                    To provide a seamless, user-friendly online platform that revolutionizes spa booking in Nepal by connecting 
                    customers with quality spa and wellness services while empowering spa establishments to manage their operations 
                    efficiently. We commit to delivering exceptional digital experiences, promoting holistic wellness, and setting 
                    new standards in the spa industry through innovation, reliability, and customer-centric solutions.
                </p>
            </div>
        </div>
        
        <div class="vision-box">
            <h3 class="box-title">VISION</h3>
            <div class="box-content">
                <p>
                    To become Nepal's leading digital platform for spa and wellness bookings, recognized for pioneering excellence 
                    in online spa services and wellness transformation. We aspire to create a thriving community where customers enjoy 
                    convenient access to premium wellness experiences, spa owners operate with efficiency and transparency, and the 
                    entire spa industry benefits from organized, technology-driven solutions that enhance service quality and 
                    customer satisfaction.
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    // Smooth scroll to sections
    document.querySelectorAll('.about-nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update active state
                document.querySelectorAll('.about-nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
    
    // Update active link on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.about-section');
        const navLinks = document.querySelectorAll('.about-nav-link');
        
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - 200)) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });
</script>

@endsection
