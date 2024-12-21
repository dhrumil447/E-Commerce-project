<style>
.product-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.product-item {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    text-align: center;
}
.product-item h4 {
    font-size: 18px;
    margin-bottom: 10px;
}
.product-item p {
    font-size: 14px;
    margin: 5px 0;
}
.product-item a {
    color: #007bff;
    text-decoration: none;
}
.product-item a:hover {
    text-decoration: underline;
}
</style>
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.php"><img src="img/logo.jpg" alt=""></a>
                
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Men's</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="mensmartwatch.php">Smart Watch</a></li>
                                <li class="nav-item"><a class="nav-link" href="mendigitalwatch.php">Digital Watch</a></li>
                                <li class="nav-item"><a class="nav-link" href="menanalouge.php">Analogue Watch</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Women's</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="womensmartwatch.php">Smart Watch</a></li>
                                <li class="nav-item"><a class="nav-link" href="womendigitalwatch.php">Digital Watch</a></li>
                                <li class="nav-item"><a class="nav-link" href="womenanalouge.php">Analog Watch</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="order_history.php">Your Order</a></li>


                        <!-- Show Login or Profile based on session -->
                        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
            // Use default profile photo if not set
            $defaultPhoto = "img/profile-user.png";
            $profilePhoto = isset($_SESSION['profile_photo']) && file_exists($_SESSION['profile_photo'])
                ? $_SESSION['profile_photo']
                : $defaultPhoto;

            // Get the username from the session
            $username = isset($_SESSION['username'])  ? $_SESSION['username'] : "User" ;
            ?>
            <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px;">
            
        </a>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
           
            <li><a class="dropdown-item" href="myprofile.php">My Profile</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </li>
<?php else: ?>
    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
<?php endif; ?>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"></span></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Search Bar -->
                        <li class="nav-item">
                            <div class="search-container">
                                <input type="text" id="search_input" class="form-control" placeholder="Search Watches..." onkeyup="liveSearch()">
                                <div id="live_search_results"></div>
                            </div>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
</header>
<script>
    function liveSearch() {
        const query = document.getElementById('search_input').value.trim();

        if (query.length === 0) {
            document.getElementById('live_search_results').style.display = 'none';
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const resultsDiv = document.getElementById('live_search_results');
                resultsDiv.innerHTML = xhr.responseText;
                resultsDiv.style.display = 'block';
            }
        };
        xhr.send(`query=${encodeURIComponent(query)}`);
    }

    // Hide results when clicking outside the search area
    document.addEventListener('click', function (e) {
        const resultsDiv = document.getElementById('live_search_results');
        const searchInput = document.getElementById('search_input');
        if (!resultsDiv.contains(e.target) && e.target !== searchInput) {
            resultsDiv.style.display = 'none';
        }
    });
</script>

<style>
    /* Styling for the search bar and results */
    #live_search_results {
        position: absolute;
        background: #fff;
        border: 1px solid #ddd;
        margin-top: 5px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        width: 300px;
        padding: 10px 0;
    }
    #live_search_results div {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
    }
    #live_search_results div:hover {
        background-color: #f8f9fa;
    }
    #live_search_results img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
    }
    #live_search_results span {
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }
</style>