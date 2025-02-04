<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kisan Bazaar - Empowering Farmers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <nav class="top-nav" id="topnavi">

        </div>
       
        <a href="#FAQ">FAQ</a>

            <a href="#services">Services</a> 
            <a href="#how">How it works</a>
            <a href="#reviews">Reviews</a>
            <a href="#contactus">Contact Us</a>
            <a href="#about">About Us</a>
        </div>
    </nav>
        <div class="container text-center">
            <h1 class="display-4">Welcome to Kisan Bazaar</h1>
            <p class="lead">A Smart Supply Management System for Farmers</p>
        
            <!-- GIF as Background -->
            <div class="gif-container">
                <div class="button-container">
            <a href="signup.php" class="btn btn-custom">Login</a>
            <a href="signup.php" class="btn btn-light">Register</a>
        </div>
    </div>
</div>
        


    <div class="container intro-section" >
        <div class="intro-text">
            <h1>"Support Services for Agricultural Producers."</h1>
            <p class="fw-bold text-success">Maximize your yield and profits with Kisan Bazaar's support!</p>
            <p>Kisan Bazaar is a farmer-centric platform offering market insights, quality seeds, farming tools,
                and direct buyer connections. We help farmers optimize yield and maximize profits efficiently.
            </p>
        </div>
        <div class="intro-image">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlE8OLioQ4FUgYnrP1x-KBg9ToekwSxq1qVQ&s"
                alt="Agricultural Market Scene" class="img-fluid rounded">
        </div>
    </div>

    <div id="how" class= "container features">
        <h2>How It Works</h2>
        <div class="row">
            <div class="col-md-4 box text-center">
                <h4>📦 Product Listing</h4>
                <p>Farmers can list their produce and required supplies.</p>
            </div>
            <div class="col-md-4 box text-center">
                <h4>🔄 Efficient Supply Chain</h4>
                <p>Automated logistics and distribution system.</p>
            </div>
            <div class="col-md-4 box text-center">
                <h4>💰 Fair Pricing</h4>
                <p>Direct marketplace for fair pricing without middlemen.</p>
            </div>
        </div>
    </div>

    <div class="container services" id="services">
        <h2>Our Services</h2>
        <div class="row">
            <div class="col-md-4 box text-center">
                <h4>🤖 AI-Powered Tools</h4>
                <p>Advanced tools for precision farming and insights.</p>
            </div>
            <div class="col-md-4 box text-center">
                <h4>🔒 Secure Transactions</h4>
                <p>Encrypted and safe payment systems for farmers.</p>
            </div>
            <div class="col-md-4 box text-center">
                <h4>📍 Real-Time Order Tracking</h4>
                <p>Track your orders and supplies with real-time updates.</p>
            </div>
        </div>
    </div>
    <div id="reviews">

    <div class="container reviews">
        <h2>What Our Farmers Say</h2>
        <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="text-center">
                        <h4>🌟🌟🌟🌟🌟</h4>
                        <p>"Kisan Bazaar has changed the way I sell my crops! Fair prices and easy
                            transactions."</p>
                        <p>- Ramesh, Punjab</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="text-center">
                        <h4>🌟🌟🌟🌟</h4>
                        <p>"Real-time tracking helps me plan my deliveries better. A must-use platform!"</p>
                        <p>- Sunita, Maharashtra</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#reviewCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#reviewCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    </div>

    <div class="container contact" id="contactus">
        <h2>Contact Us</h2>
        <form id="contact-form" onsubmit="return submitForm()">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
        <div id="thank-you" class="text-success mt-3" style="display: none;">Thank you! We will get back to you
            soon.</div>
    </div>
    
    

    <script>
        function submitForm() {
            document.getElementById('thank-you').style.display = 'block';
            document.getElementById('contact-form').reset();
            return false;
        }
    </script>
   <section class="container py-5 bg-gradient" id="about">
    <div class="section-header text-center">
        <h2>About Us</h2>
        <p class="lead text-success font-weight-bold mb-5">Our goal is to empower farmers with the right tools, insights, and resources to improve their productivity and profits. We are here to change the future of agriculture.</p>
    </div>

    <div class="card p-4 shadow-lg">
        <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="team-card text-center">
                        <img src="" alt="Amisha Singh">
                        <h5>Amisha Singh</h5>
                        <p>Lead Developer</p>
                        <p></p>
                        <a href="#" class="btn btn-custom" data-bs-toggle="tooltip" title="Contact Amisha Singh">Contact</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="team-card text-center">
                        <img src="https://via.placeholder.com/150" alt="Deepanshi Goyal">
                        <h5>Deepanshi Goyal</h5>
                        <p>Lead Frontend Developer</p>
                        <p></p>
                        <a href="#" class="btn btn-custom" data-bs-toggle="tooltip" title="Contact Deepanshi Goyal">Contact</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="team-card text-center">
                        <img src="https://via.placeholder.com/150" alt="Tanaa Chauhan">
                        <h5>Tanaa Chauhan</h5>
                        <p>UI & UX Designer</p>
                        <p></p>
                        <a href="#" class="btn btn-custom" data-bs-toggle="tooltip" title="Contact Tanaa Chauhan">Contact</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="team-card text-center">
                        <img src="https://via.placeholder.com/150" alt="Mehul Khanna">
                        <h5>Mehul Khanna</h5>
                        <p> Lead Frontend Developer</p>
                        <p></p>
                        <a href="#" class="btn btn-custom" data-bs-toggle="tooltip" title="Contact Mehul Khanna">Contact</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="team-card text-center">
                        <img src="https://via.placeholder.com/150" alt="Devesh Taneja">
                        <h5>Devesh Taneja</h5>
                        <p>Lead Backend Developer</p>
                        <p></p>
                        <a href="#" class="btn btn-custom" data-bs-toggle="tooltip" title="Contact Devesh Taneja">Contact</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<div class="mt-4 p-3 bg-light rounded text-center">
    <p>📞 Phone: +91 9876543210</p>
    <p>📧 Email: support@kisanbazaar.com</p>
    <p>📍 Address: 123 Greenfield, Agri Nagar, India</p>
    <button class="btn btn-custom text-white" onclick="alert('Thank you for reaching out! We will get back to you soon.')">Get in Touch</button>
</div>

<div id="thank-you" class="text-success mt-3 text-center" style="display: none;">
    Thank you! We will get back to you soon.
</div>


    
        <!-- Modal for Contact -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    
    </body>
    </html>