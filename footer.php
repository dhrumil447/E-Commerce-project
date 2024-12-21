
   
    
    <style>
        /* Footer Styling */
        .footer-area {
            background-color: #000000; /* Dark background for the footer */
            color: #ffffff; /* Light text color */
            padding: 20px 20px; /* Top and bottom spacing */
            font-size: 25px; /* Adjust text size */
        }

        .footer-area a {
            color: #17a2b8; /* Light blue link color */
            text-decoration: none; /* Remove underline from links */
        }

        .footer-area a:hover {
            color: #ffc107; /* Golden hover effect for links */
            text-decoration: underline; /* Add underline on hover */
        }

        .footer-text {
            margin: 10px 0; /* Adjust spacing for footer text */
        }

        .footer-text ul {
            list-style: none; /* Remove bullet points */
            padding: 0; /* Remove padding */
            margin: 0; /* Remove margin */
        }

        .footer-text ul li {
            margin-bottom: 20px; /* Add spacing between items */
        }

        .footer-bottom {
            border-top: 1px solid #495057; /* Add a border line above footer bottom */
            padding-top: 10px; /* Spacing above the copyright text */
            font-size: 25px; /* Smaller text for the bottom section */
        }


        .footer-bottom a:hover {
            color: #28a745; /* Green hover effect */
        }
    </style>


    <!-- Footer Section -->
    <footer class="footer-area">
        <div class="container">
            <div class="row">
                <!-- Footer Navigation -->
                <div class="col-md-6 text-center text-md-start footer-text m-0">
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-decoration-none">Home</a></li>
                        <li><a href="about.php" class="text-decoration-none">About Us</a></li>
                        <li><a href="contact.php" class="text-decoration-none">Contact Us</a></li>
                        <li><a href="order_history.php" class="text-decoration-none">Your Orders</a></li>
                        <li><a href="cart.php" class="text-decoration-none">Cart</a></li>
                    </ul>
                </div>
                <!-- Contact Details -->
                <div class="col-md-6 text-center text-md-end footer-text m-0">
                    <p>Email: <a href="mailto:watchvouge9@gmail.com" class="text-decoration-none">watchvouge9@gmail.com</a></p>
                    <p>Phone: <a href="tel:+919512721508" class="text-decoration-none">+91 9512721508</a></p>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap mt-3">
                <p class="footer-text m-0">
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                    | Designed by <a href="index.php" class="text-decoration-none">Watch Vouge</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

