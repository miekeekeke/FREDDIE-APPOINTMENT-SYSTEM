<?php require_once 'includes/landing_header.php'; ?>

<!-- Hero Section -->
<div class="hero-section position-relative bg-dark text-white">
    <div class="container-fluid px-0">
        <div class="row min-vh-100 m-0" style="background: url('assets/images/mr-freddie-bg.jpg') center/cover no-repeat;">
            <!-- Text column with semi-transparent overlay -->
            <div class="col-lg-6 py-5 px-5 d-flex align-items-center" style="background: rgba(0,0,0,0.7); margin-top: 20px;">
                <div>
                    <h1 class="display-4 fw-bold mb-4">Expert Shoe Repair & Leather Craft Services</h1>
                    <p class="lead mb-4">Transform your worn favorites into renewed treasures with our professional shoe repair and leather crafting services. Quality workmanship guaranteed.</p>
                    <div class="d-flex gap-3">
                        <a href="register.php" class="btn btn-primary btn-lg px-4">Get Started</a>
                        <a href="#services" class="btn btn-outline-light btn-lg px-4">Our Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-tools fs-1"></i>
                        </div>
                        <h5 class="card-title">Shoe Repair</h5>
                        <p class="card-text">Professional repair services for all types of footwear</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-brush fs-1"></i>
                        </div>
                        <h5 class="card-title">Shoe Cleaning</h5>
                        <p class="card-text">Deep cleaning and restoration services</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-droplet fs-1"></i>
                        </div>
                        <h5 class="card-title">Shoe Polishing</h5>
                        <p class="card-text">Professional shoe polishing and finishing</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="bi bi-heart fs-1"></i>
                        </div>
                        <h5 class="card-title">Leather Conditioning</h5>
                        <p class="card-text">Leather care and maintenance services</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>MR.FREDDIE Repair Shop</h5>
                <p class="mb-0">Quality craftsmanship since 2023</p>
            </div>
            <div class="col-md-4">
                <h5>Contact</h5>
                <p class="mb-0">Email: info@mrfreddie.com<br>Phone: (123) 456-7890</p>
            </div>
            <div class="col-md-4">
                <h5>Hours</h5>
                <p class="mb-0">Mon-Fri: 9am - 6pm<br>Sat: 10am - 4pm</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> MR.FREDDIE Repair Shop. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php
require_once 'includes/footer.php';
?>
