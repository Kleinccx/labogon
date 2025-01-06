

<?php
session_start();

// Check if the user is logged in and is not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
    header("Location: /labogon/login.php");
    exit;
}

$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'barangay_labogon');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session

// Get the count of unread notifications
$result = $conn->query("SELECT COUNT(*) AS count FROM notifications WHERE user_id = '$user_id' AND status = 'unread'");
$notification_count = $result->fetch_assoc()['count'];

// Fetch all notifications for the user
$notifications = $conn->query("SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 50")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mediaquery.css">
    <title>Document</title>
</head>
<body>
    <style>
        <style>
        .logo-text {
            font-size: 24px;
            font-weight: bold;
        }

        .logo-text span {
            color: #4CAF50;
        }

        main {
            padding: 20px;
        }

        h2 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            color: #c0c0c0;
            text-align: center;
            padding: 4rem;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card h3 {
            font-size: 20px;
            color: #4CAF50;
            margin: 10px 0;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 0 10px 10px;
        }

        .card .date {
            font-size: 12px;
            color: #999;
            margin-bottom: 10px;
        }

    </style>
  <!-- NAVIGATION BAR -->
<header class="header">
    <div class="logo-img">
        <img class="logopic" src="/labogon/logo.png" alt="" />
    </div>
    <nav class="main-nav">
        <ul class="main-nav-list">
            <li><a class="main-nav-link" href="./index.php">Dashboard</a></li>
            <li><a class="main-nav-link" href="Pages/buyandsell.php">Buy & Sell</a></li>
            <li><a class="main-nav-link" href="Pages/events.php">Events</a></li>
            <li><a class="main-nav-link" href="Pages/newsfeed.php">NewsFeed</a></li>
            <li><a class="main-nav-link" href="Pages/appointments.php">Appointment</a></li>
            <li><a class="main-nav-link" href="Pages/wastemanagement.php">Waste Management</a></li>

            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                <li class="nav-cta">
                    <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                    <li><a class="main-nav-link nav-cta" href="logout.php?role=user">Logout</a></li>
                </li>
            <?php else: ?>
                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            <?php endif; ?>
  <!-- Notification Bell with dynamic count -->
  <li class="notification-bell">
                <a href="#" class="main-nav-link" id="notificationIcon">
                    <i class="fas fa-bell"></i>
                    <?php if ($notification_count > 0): ?>
                        <span class="notification-badge"><?php echo $notification_count; ?></span>
                    <?php endif; ?>
                </a>

                <!-- Dropdown for notifications -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <ul>
                        <?php while ($notification = $notifications->fetch_assoc()): ?>
                            <li>
                                <a href="#" onclick="markNotificationAsRead(<?php echo $notification['id']; ?>)">
                                    <?php echo htmlspecialchars($notification['message']); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                        <?php if ($notification_count == 0): ?>
                            <li>No new notifications</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</header>
<!-- Add CSS for styling the bell, badge, and dropdown -->
<style>
     .notification-bell {
        position: relative;
    }

    .notification-bell i {
        font-size: 24px;
        color: #333;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .notification-dropdown {
        display: none;
        position: absolute;
        background-color: white;
        top: 30px;
        right: 0;
        width: 250px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 100;
    }

    .notification-dropdown ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .notification-dropdown li {
        padding: 10px;
        border-bottom: 1px solid #f4f4f4;
    }

    .notification-dropdown li:hover {
        background-color: #f1f1f1;
    }

    #notificationIcon:hover + .notification-dropdown {
        display: block;
    }
    .diets{
        background-color: white !important;
color: white !important;
    }
</style>
<!-- JavaScript to Toggle Notification Dropdown -->
<script>
    document.getElementById('notificationIcon').addEventListener('click', function (e) {
        e.preventDefault();
        var dropdown = document.getElementById('notificationDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Function to mark notifications as read
    function markNotificationAsRead(notificationId) {
        fetch('markNotificationAsRead.php?notificationId=' + notificationId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload page to update the notification count
                }
            });
    }
</script>

<!-- Add FontAwesome link in the <head> section of your HTML to use the bell icon -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</body>
</html>


        <button class="btn-mobile-nav">
            <ion-icon class="icon-mobile-nav" name="menu-outline"></ion-icon>
            <ion-icon class="icon-mobile-nav" name="close-outline"></ion-icon>
        </button>
    </header>
    <!--END NAVIGATION BAR-->
</body>
</html>

     <!--END NAVIGATION BAR-->

     <main>
        <!--Home HOME PAGE/HERO SECTION-->
        <section class="section-hero" id="hero">
            <div class="hero">
                <!-- <div class="hero-text-box">
                    <h1 class="primary-heading">A healthy meal delivered to your door</h1>
                    <p class="description">From simple home-cooked dinners at home, 
                    to tasting new dishes while traveling — food connects us all.</p>
                 </div>
                <a href="#meal" class="btn"></a> -->
            </div>
        </section>
        <!--END HOME PAGE/HERO SECTION-->

        

        <!---FEATURED IN SECTION --->
        <!-- <section class="featured">
            <div class="featured-in-text">
                <p>Featured in:</p>
            </div>
            <div class="featured-in-img">
                <img src="Source/Img logo/FoodPandalogo.png" alt="delivery logo" />
                <img src="Source/Img logo/delivero.png" alt="delivery logo" />
                <img src="Source/Img logo/grabfoodlogo.jpg" alt="delivery logo" />
                <img src="Source/Img logo/maganlogo.webp" alt="delivery logo" />
                <img src="Source/Img logo/zamatologo.png" alt="delivery logo" />
            </div>
        </section> -->
        <!---END FEATURED IN SECTION -->

        <!---DIET SECTION--->
        <section class="diets" id="diet">
            <h1 class="primary-heading">MISSION/VISION</h1>

            <!---DIET PLAN 1-->
            <div class="dietplan grid--2 container">
                <div class="diet-text">
                    <h2>1.</h2>
                    <h3 class="heading">VISION</h3>
                    <p class="description--2"><span>A PROGRESSIVE</span> CLEAN, PEACEFUL, ORDERLY AND RESILIENT BARANGAY in MANDAUE CITY</p>
                  
                </div>
            

         
                <div class="diet-text">
                    <h2>2.</h2>
                    <h3 class="heading">MISSION</h3>
                    <p class="description--2"><span>TO PROVIDE</span> AN ENVIRONMENT FOR A HOLISTIC AND SUSTIANABLE DEVELOPMENT THROUGH A RESPONSIVE, INCLUSIVE, UNIFYING AND CARING GOVERNANCE</p>
                   
                </div>
            </div>


            <!---DIET PLAN 3-->
            <div class="dietplan grid--2 container">
                <div class="diet-text">
                    <h2>3.</h2>
                    <h3 class="heading">CORE VALUES</h3>
                    <p class="description--2"><span>TRANPARANCY</span> ACCOUNTABILLITY INTEGRITY PARTICIPATORY EXCELLENCE (Taipe)
                        </p>
                    
                </div>
             
            <!---END MISSION/VISSION-->

        </section>
        <!---END MISSION/VSSION-->

      <!-- OUR COUNCIL -->
<section class="meals" id="meal">
    <div class="container">
        <h2>Labogon</h2>
        <h1 class="primary-heading">Meet Our Public Servants</h1>
    </div>

    <div class="carousel-container container">
        <button class="carousel-btn prev-btn">&lt;</button>
        <div class="carousel">
            <!-- Carousel Card 1 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Agnes I. Ermac (Brgy. Kagawad).jpg" alt="Hon. Agnes I. Ermac" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Agnes I. Ermac</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 2 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Corazon D. Tumulak (Brgy. Kagawad).jpg" alt="Hon. Corazon D. Tumulak" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Corazon D. Tumulak</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 3 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Helbert B. Nejana (Punong Barangay).jpg" alt="Hon. Helbert B. Nejana" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Helbert B. Nejana</h3>
                <p class="carousel-role">Punong Barangay</p>
            </div>
            
            <!-- Carousel Card 4 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Janice M. Mondares (S.K Chairman).jpg" alt="Hon. Janice M. Mondares" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Janice M. Mondares</h3>
                <p class="carousel-role">S.K Chairman</p>
            </div>
            
            <!-- Carousel Card 5 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Lyn Delia Sarausad (Brgy. Kagawad).jpg" alt="Hon. Lyn Delia Sarausad" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Lyn Delia Sarausad</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 6 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Mariano S. Bayon-on Jr. (Brgy. Kagawad).jpg" alt="Hon. Mariano S. Bayon-on Jr." class="carousel-image"/>
                <h3 class="carousel-name">Hon. Mariano S. Bayon-on Jr.</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 7 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/nelson.jpg" alt="Hon. Nelson B. Gitgano" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Nelson B. Gitgano</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 8 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/renato.jpg" alt="Hon. Renato P. Suson" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Renato P. Suson</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 9 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Hon. Reynaldo B. Lloren (Brgy. Kagawad).jpg" alt="Hon. Reynaldo B. Lloren" class="carousel-image"/>
                <h3 class="carousel-name">Hon. Reynaldo B. Lloren</h3>
                <p class="carousel-role">Brgy. Kagawad</p>
            </div>
            
            <!-- Carousel Card 10 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Jane C. Calunsag (Brgy. Secretary).jpg" alt="Jane C. Calunsag" class="carousel-image"/>
                <h3 class="carousel-name">Jane C. Calunsag</h3>
                <p class="carousel-role">Brgy. Secretary</p>
            </div>
            
            <!-- Carousel Card 11 -->
            <div class="carousel-card">
                <img src="/labogon/brgyofficialspictures/Sarah O. Arrofo (Brgy. Treasurer).jpg" alt="Sarah O. Arrofo" class="carousel-image"/>
                <h3 class="carousel-name">Sarah O. Arrofo</h3>
                <p class="carousel-role">Brgy. Treasurer</p>
            </div>
        </div>
        <button class="carousel-btn next-btn">&gt;</button>
    </div>
</section>
<!-- END COUNCIL -->



        
        <!--LOCATION/CONTACT SECTION-->

        <section class="location-contact" id="location-contact">
            <h2>Contact Us</h2>
            <div class="location-wrap">
                <!--Map-->
                <div class="location">
                    <h3>Our Location</h3>
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.0504139066525!2d123.92836557321371!3d10.337850768781532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9991d0b937dc3%3A0xfd24a6b7116bcc73!2sEskina%20Gloria!5e0!3m2!1sen!2sus!4v1714121356864!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                 <!--Contact-->
                 <div class="contact">
                    <h3>Get Intouch with Us</h3>
                    <p>Fill out with you contact info so that we can reach you out</p>
                    <form name ="submit-to-google-sheet" class="form">
                        <input type="text" name="Name" placeholder="Your Name" required>
                        <input type="email" name="Email" placeholder="Your Email" required>
                        <textarea name="Message" rows="6" placeholder="Your Message"></textarea>
                        <div class="link"><button type="submit" class="btn" >Submit</button></div>
                    </form>


                 </div>
                 
            </div>
        </section>

       <!--END LOCATION/CONTACT SECTION-->


         <!--BOOKING SECTION-->
         <section class="reservations" id="reservation">
            <h2>Online Service</h2>
            <h1 class="heading">Click and Go Service</h1>
            <div class="reservation grid--3">
                <div class="reservation-plan">
                    <img class="reservation-img"
                    src="Source/reservation img/pic1.jpg"
                    alt=""
                    />

                    <h3>Buy & Sell</h3>
                    <ul class="attribute-list">
                        <li><ion-icon class="meal-icon" name="people-outline"></ion-icon><span>Search:</span> Look thing's online</li>
                        <li><ion-icon class="meal-icon" name="cash-outline"></ion-icon><span>Find:</span> Find valueble thing's online</li>
                        <li><ion-icon class="meal-icon" name="fast-food-outline"></ion-icon><span>What's In:</span> A marketplace online where you can Buy and Sell 2nd hand thing's </li>
                    </ul>
                    <div class="btn-reserve">
                    <a class="btn" href="pages/buyandsell.php">Shop now</a>
                    </div>
                </div>

                <div class="reservation-plan">
                    <img class="reservation-img"
                    src="Source/reservation img/pic2.jpg"
                    alt=""
                    />
                    <h3>Event's</h3>
                    <ul class="attribute-list">
                        <li><ion-icon class="meal-icon" name="people-outline"></ion-icon><span>Search:</span> What's in the barangay</li>
                        <li><ion-icon class="meal-icon" name="cash-outline"></ion-icon><span>Find:</span> Be updated with Event's</li>
                        <li><ion-icon class="meal-icon" name="fast-food-outline"></ion-icon><span>What's In:</span>  Stay up to date with event's within the barangay</li>
                    </ul>

                    <div class="btn-reserve">
                        <a class="btn" href="pages/events.php">Check event's</a>
                    </div>
                </div>

                <div class="reservation-plan plan-3rd">
                    <img class="reservation-img"
                    src="Source/reservation img/pic3.jpg"
                    alt=""
                    />

                    <h3>Appointment</h3>
                    <ul class="attribute-list">
                        <li><ion-icon class="meal-icon" name="people-outline"></ion-icon><span>Search:</span> Online Applicantion</li>
                        <li><ion-icon class="meal-icon" name="cash-outline"></ion-icon><span>Find:</span> Save more time to get a document</li>
                        <li><ion-icon class="meal-icon" name="fast-food-outline"></ion-icon><span>What's In:</span> Set appointment with barangay officials, Online application for documents</li>
                    </ul>
                    <div class="btn-reserve">
                        <a class="btn" href="pages/appointments.php">Apply now</a>
                    </div>
                </div>
            </div>
        </section>
        <!--END BOOKING SECTION-->


        <!--Gallery SECTION-->
        <section class="" id="">
        
        <h1 class="heading heading-text">Our own Barangay Labogon</h1>
            
            <div class="gallery">
               <figure class="gallery-item">
                    <img src="Images/Labogonphotos/photo1.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 
                
                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo2.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo3.jpg"  
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo4.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo5.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo6.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo7.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 
                
                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo8.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

                <figure class="gallery-item">
                <img src="Images/Labogonphotos/photo9.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 
                <figure class="gallery-item">
                    <img src="Images/Labogonphotos/photo10.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 
                <figure class="gallery-item">
                    <img src="Images/Labogonphotos/photo11.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 
                <figure class="gallery-item">
                    <img src="Images/Labogonphotos/photo12.jpg" 
                    alt="Gallery Photos" 
                    />
                </figure> 

        </section>
        <!--END TESTIMONIAL SECTION-->

    </main>

    <!--FOOTER SECTION-->
    <footer class="footer">

        <div class="upper--footer">
            <div class="flex--footer">
                <div class="Company">
                    <h4> Company</h4>
                    <ul class="footer-list">
                        <li><a href="" class="">Featured In</a> </li>
                        <li><a href="" class="">About Us</a> </li>
                        <li><a href="" class="">Location</a> </li>
                    </ul>
                </div>
    
                <div class="Account">
                    <h4> Account</h4>
                    <ul class="footer-list">
                        <li><a href="" class="">Sign In</a> </li>
                        <li><a href="" class="">Sign up</a> </li>
                    </ul>
                </div>
            </div>

            <div class="socials">

                <div class="logo-img-footer">
                <img class="logopic" src="/labogon/logo.png" alt="" />
             
                </div>

                <ul class="socialmedia--icon">
                    <li><a href="https://www.facebook.com/p/Labogon-Public-Information-Office-61554378655504/"><ion-icon class="icon" name="logo-facebook"></ion-icon></a></li>
                    
                </ul>
            </div>

            <div class="contact-us">
                <ul class="footer-list">
                    <li><ion-icon class="icon" name="mail-unread-outline"></ion-icon>barangayhalllabogon@gmail.com</li>
                    <li><ion-icon class="icon" name="phone-portrait-outline"></ion-icon>328-7148</li>
                    <li><ion-icon class="icon" name="location-outline"></ion-icon>Labogon Mandaue City</li>
                </ul>
            </div>
        </div>
        <div class="lower--footer copyright">
            <p>Copyright © <span class="year">2026</span> All right reserved</p>
        </div>

    </footer>


    <!--JS ICON!-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
</body>
</html>