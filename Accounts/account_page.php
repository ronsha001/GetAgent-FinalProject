<?php session_start();
    $token = '';
    $username = '';
    $email = '';
    $isRegistered = false;
    $picture_path = '';
    $agent_link = '../loginSystem/login_page.php';
    $agent_profile = '<i class="fa-solid fa-plus"></i> צור פרופיל סוכן';
    $agent_profile_footer = 'צור פרופיל סוכן';
    $agency_profile = 'צור פרופיל סוכנות';
    if (isset($_SESSION['verify_token'])){
        $email = $_SESSION['email'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $gender = $_SESSION['gender'];
        $isRegistered = true;
        $picture_path = $_SESSION['picture_path'];
        $agent_link = '../createProfiles/create_agent_page.php';
        if ($_SESSION['is_agent'] == 1) {
            $agent_link = '../agentsProfiles/agent_profile_page.php'; // TODO create agent page
            $agent_profile = 'פרופיל הסוכן שלי';
            $agent_profile_footer = 'פרופיל הסוכן שלי';
        } 
        if ($_SESSION['is_agency'] == 1) {
            $agency_profile = 'פרופיל הסוכנות שלי';
        } 
    } else {
        header("Location: ../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get real estate agent / agency">
    <meta name="keywords" content="Get Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <link rel="icon" type="png" href="../images/title_icon.png">
    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="../OpenProfiles.css">
    <link rel="stylesheet" type="text/css" href="../public/Reviews.css">
    <link rel="stylesheet" type="text/css" href="account_page_style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>

    <title>גט אייג'נט החשבון שלי</title>

</head>
<body>
    <!-- Navigation bar, Ty Dev Ed-->
    <nav>
        <div class="logo">
            <a href="../index.php">
            <img class="myLogo" src="../images/Logo.png" style="width: 60px;" alt="logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">בית</a></li>
            <li><a href="#">סוכנים</a></li>
            <li><a href="#">נכסים</a></li>
            <li><a href="../About/about_page.php">עלינו</a></li>
            <li><a href='../loginSystem/logout.php' >התנתק</a></li>
        </ul>
        <div class="burger">
            <div class="lin1"></div>
            <div class="lin2"></div>
            <div class="lin3"></div>
        </div>        
    </nav>
    <script src="../Nav.js" type="text/javascript"></script>

    <!-- TOP SECTION -->
    <div class="container">
        <form action="upload_picture_code.php" method="POST" enctype="multipart/form-data">
            <div class="img-section" style="background-image: url('<?php echo $picture_path; ?>');">
                <input type="file" onchange="check_files()" class="my_file" name="file" accept="image/png, image/gif, image/jpeg, image/jpg">
            </div>
            <input class="update_picture" type="submit" name="submit" value="עדכן תמונה">
        </form>
        <div class="details">
            <ul class="list">
                <li><span>שם: </span><?php echo $first_name ?></li>
                <li><span>שם משפחה: </span><?php echo $last_name ?></li>
                <li><span>מין: </span><?php echo $gender ?></li>
                <li><span>אימייל: </span><?php echo $email ?></li>
                <br>
                <div class="social">
                    <a href="" target="_blank"><i class="fa-brands fa-facebook"></i></a>    
                    <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="" target="_blank"><i class="fab fa-twitter" ></i></a>
                    <a href="" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </ul>  
        </div>
        <div class="edit">
            <a href="edit_info_page.php"><i class="fa-solid fa-user-pen"></i></a>
            <span>ערוך את חשבונך</span>
        </div>
    </div>

    <!-- OPEN PROFILES SECTION -->
    <div class="profiles-section">
        <button type="button" class="button-1" onclick="window.location.href='<?php echo $agent_link; ?>'"><?php echo $agent_profile; ?></button>
        <button type="button" class="button-2"><i class="fa-solid fa-plus"></i>צור פרופיל סוכנות</button>
        <button type="button" class="button-3" onclick="'Accounts/account_page.php'">החשבון שלי</button>
    </div>

    <!-- ACCOUNT'S REVIEWS SECTION -->
    <div class="reviews_wrapper">
        <div class="review_section_title">
            <h1>ביקורות קודמים שלך</h1>
        </div>
    <?php 
        include_once('../loginSystem/db.php');
        $order = "DESC";
        $reviews_query = "SELECT * 
                            FROM reviews_info_table 
                            WHERE reviews_info_table.from_email='$email'
                            ORDER BY reviews_info_table.date $order";
        try{
            $reviews_query_run = mysqli_query($con, $reviews_query);
            if (mysqli_num_rows($reviews_query_run) < 1){
                echo "<h3>אין ביקורות קודמים.</h3>";
            }
            while($review = mysqli_fetch_array($reviews_query_run)){
                $emoji = "😠";
                if($review['stars'] == 2){
                    $emoji = "😞";
                } elseif ($review['stars'] == 3){
                    $emoji = "🙂";
                } elseif ($review['stars'] == 4){
                    $emoji = "😊";
                } elseif ($review['stars'] == 5){
                    $emoji = "😍";
                }
                echo "
                <div class='review_container'>
                    <div class='pic_and_name'>
                        <img src='$picture_path' alt='account pic'>
                        <div class='reviewer_name'>
                            <span>$review[account_name] <i class='fa-solid fa-arrow-left'></i> <a href='../public/AgentProfile.php?email=$review[to_email]' target='_blank'> $review[agent_name] </a> </span>
                        </div>
                        <div class='edit_review'>
                            <form action='../public/delete_review_code.php' method=POST>
                                <input type='hidden' name='review_id' value=$review[id]>
                                <input type='hidden' name='to_email' value=$review[to_email]>
                                <button type='submit' name='delete_submit' title='מחק ביקורת'><i class='fa-solid fa-trash-can'></i></button>
                            </form>
                        </div>
                    </div>

                    <div class='review_details'>
                        <div class='review_top_details'>
                            <span>$review[subject] $emoji</span>
                            <div class='review_stars'>
                                "; for($i = 5; $i > 0; $i--){
                                    if($i <= $review['stars']){
                                        echo "<i class='fa-solid fa-star'></i>";
                                    } else {
                                        echo "<i class='fa-regular fa-star'></i>";
                                    }
                                } echo "
                            </div>
                        </div>

                        <div class='review_subject'>
                            <p>$review[body]</p>
                            <small>$review[date]</small>
                        </div>
                    </div>
                </div>
                ";
            }
        } catch (Exception $e) {
            echo $e;
        } finally {
            mysqli_close($con);
        }
        
    ?>
    </div>
    
    <!-- FOOTER SECTION -->
    <div class="footer-container">
        <section class="footer-subscription">
            <p class="footer-subscription-heading">
                הצטרף לניוזלטר כדי לקבל את העדכונים החדשים שלנו
            </p>
            <p class="footer-subscription-text">
                ניתן לבטל את המנוי בכל עת.
            </p>
            <div class="input-areas">
                <form action="#" method="POST">
                    <input type="email" name="email" placeholder="אימייל" class="footer-input">
                    <input type="submit" class="subscribe-btn" value="הירשם">
                </form>
            </div>
        </section>
        <div class="footer-links">
            <div class="footer-link-wrapper">
                <div class="footer-link-items">
                    <h2>עלינו</h2>
                    <a href="../About/about_page.php">על גט אייג'נט</a>
                    <a href="#">איך זה עובד</a>
                </div>
                <div class="footer-link-items">
                    <h2>צור קשר</h2>
                    <a href="#">צור איתנו קשר</a>
                    <a href="#">תמיכה</a>
                    <a href="#">המלצות</a>
                </div>
                <div class="footer-link-items">
                    <h2>חשבון</h2>
                    <?php if(!$isRegistered){echo "<a href='../loginSystem/login_page.php'>התחבר</a>";}else{echo "<a href='../Accounts/account_page.php'>החשבון שלי</a>";} ?>
                    <a href="<?php echo $agent_link; ?>"> <?php echo $agent_profile_footer; ?> </a>
                    <a href="#"> <?php echo $agency_profile; ?> </a>
                </div>
                <div class="footer-link-items">
                    <h2>חיפושים</h2>
                    <a href="#">חיפוש סוכנים</a>
                    <a href="#">חיפוש סוכנויות</a>
                    <a href="#">חיפוש נכסים</a>
                    <a href="#">נכסים שנמכרו/הושכרו</a>
                </div>
            </div>
        </div>
        <section class="social-media">
            <div class="social-media-wrap">
                <div class="footer-logo">
                    <a href="../index.php"><img src="../images/Logo.png" style="width: 60px;"></img></a>
                </div>
                <small class="website-rights">גט אייג'נט © 2022</small>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fa-brands fa-facebook-square"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
        </section>
    </div>
    
    <script>
        var submit_picture = document.querySelector('.update_picture');
        var input_picture = document.querySelector('.my_file');

        function check_files(){
            if (input_picture.files.length == 0 ) {
                submit_picture.style.visibility = 'invisible';
            } else {
                submit_picture.style.visibility = 'visible';
            }
        }
        
        
    </script>

</body>
</html>