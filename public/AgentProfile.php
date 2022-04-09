<?php session_start();

    // if email does not exist or empty go to main page
    if(!isset($_GET['email']) or empty($_GET['email'])){
        header("Location: ../index.php");
        exit();
    }
    $isConnected = false;
    $isNotSameAgent = false;
    if(isset($_SESSION['verify_token']) and !empty($_SESSION['verify_token'])){
        $isConnected = true;
        $isNotSameAgent = $_SESSION['email'] != $_GET['email'];
    }

    $email = $_GET['email'];
    include_once("../loginSystem/db.php");
    // agent details query
    $get_agent_details = "SELECT * FROM agents_info_table WHERE email='$email' LIMIT 1";
    $get_agent_details_run = mysqli_query($con, $get_agent_details);
    $foundAgent = mysqli_num_rows($get_agent_details_run);
    
    // if could not find agent with this email, go to main page
    if(!$foundAgent){
        mysqli_close($con);
        header("Location: ../index.php");
        exit();
    }

    $agent_details = mysqli_fetch_array($get_agent_details_run);
    
    $email = $agent_details['email'];
    $id = $agent_details['id'];
    $logo = $agent_details['logo_path'];
    $agent_cities = $agent_details['agent_cities'];
    $phone_number = $agent_details['phone_number'];
    $birth_date = $agent_details['birth_date'];
    $website_link = $agent_details['website_link'];
    $office_address = $agent_details['office_address'];
    $years_of_exp = $agent_details['years_of_exp'];
    $about_agent = $agent_details['about_agent'];
    $office_name = $agent_details['office_name'];
    $license_year = $agent_details['license_year'];
    $for_sale = $agent_details['for_sale'];
    $for_rent = $agent_details['for_rent'];

    # Add space after each comma in agent_cities
    $formatted_agent_cities = "";
    for($i = 0; $i < strlen($agent_cities); $i++){
        if($agent_cities[$i] == ','){
            $formatted_agent_cities .= $agent_cities[$i].' ';
        } else {
            $formatted_agent_cities .= $agent_cities[$i];
        }
    }

    if (isset($_SESSION['is_agency']) and $_SESSION['is_agency'] == 1) {
        $agency_link = '#'; // TODO create agency page
        $agency_profile = 'פרופיל הסוכנות שלי';
    }
    $login_text = "התחבר";
    $login_link = "../loginSystem/login_page.php";
    $account_footer_text = "התחבר";
    $account_footer_link = "../loginSystem/login_page.php";
    $agent_footer_text = "צור פרופיל סוכן";
    $agent_footer_link = "../loginSystem/login_page.php";
    if(isset($_SESSION['email'], $_SESSION['verify_token']) and !empty($_SESSION['email']) and !empty($_SESSION['verify_token'])){
        $login_text = "התנתק";
        $login_link = "../loginSystem/logout.php";
        $account_footer_text = "החשבון שלי";
        $account_footer_link = "../Accounts/account_page.php";
        $agent_footer_link = "../createProfiles/create_agent_page.php";
        if(isset($_SESSION['is_agent']) and $_SESSION['is_agent'] == 1){
            $agent_footer_text = "פרופיל הסוכן שלי";
            $agent_footer_link = "../agentsProfiles/agent_profile_page.php";
        }
    }
    



    // echo $about_agent;

    

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
    
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="../AssetsCards.css">
    <link rel="stylesheet" type="text/css" href="ReportBtn.css">
    <link rel="stylesheet" type="text/css" href="Reviews.css">
    <link rel="stylesheet" type="text/css" href="NewReviewForm.css">
    <link rel="stylesheet" type="text/css" href="../agentsProfiles/agent_profile_page_style.css">
    <title>גט אייג'נט<?php echo " - ".$office_name; ?></title>

    <style>
        body{
            margin: 0;
            padding: 0;
        }
    </style>
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
            <li><a href='../Accounts/account_page.php'>חשבון</a></li>
            <li><a href="../About/about_page.php">עלינו</a></li>
            <li><a href='<?php echo $login_link; ?>' ><?php echo $login_text; ?></a></li>
        </ul>
        <div class="burger">
            <div class="lin1"></div>
            <div class="lin2"></div>
            <div class="lin3"></div>
        </div>        
    </nav>
    <script src="../Nav.js" type="text/javascript"></script>
    


    <!-- INFO SECTION -->
    <div class="info_wrapper">
        <div class="info">
            <div class="report_wrapper">
                <form id="reportForm" action="report_page.php" target="_blank" method="GET">
                    <input type="hidden" name="type" value="agent">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit"><i class="fa-solid fa-bell"></i>  דווח על שימוש לרעה</button>
                </form>
            </div>
            <div class="title_and_logo">
                <h1><?php echo $office_name; ?></h1>
                <div class="images_container">
                    <?php if($logo > ""){echo ("<img src='$logo' alt='LOGO' onclick='clickedIMG(this.src)'>");} ?>
                </div>
                
            </div>
            <div class="basic_info">
                <span>רישיון מתאריך: <b><?php echo $license_year; ?></b></span>
                <span>עריי פעילות: <b><?php echo $formatted_agent_cities; ?></b></span>
                <span>טלפון: <b><?php echo $phone_number; ?></b></span>
                <span>נכסים למכירה: <b><?php echo $for_sale; ?></b></span>
                <span>נכסים להשכרה: <b><?php echo $for_rent; ?></b></span>
                <?php if($website_link > ""){echo ("<span>לינק לאתר: <a href='$website_link' target='_blank'>לחץ כאן</a></span>");} ?>
                <?php if($office_address > ""){echo ("<span>כתובת משרד: <a target='_blank' href='https://www.google.co.il/maps/place/$office_address, ישראל'>$office_address</a></span>");} ?>
            </div>
            <div class="map">
            <?php
            if($office_address > ""){
                echo("<iframe
                width='100%'
                height='250'
                style='border:0'
                loading='lazy'
                allowfullscreen
                src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBXRumEWyF_l3cYf0xrzAWQsFeyUzB-zzA
                    &q=$office_address'>
                </iframe>");
            }
            ?>
            </div>
            <div class="about">
                <?php if($about_agent > ""){echo ("<p>$about_agent</p>");} ?>
            </div>
        </div>
        
        <div class="contact">
            <h2><i class="fa-solid fa-phone-flip"></i> התקשר לפרטים נוספים</h2>
            <h1><?php echo $phone_number; ?></h1>
            <small>מלא פרטים לחזרה:</small>
            <div class="call_back">
                <form action="#" method="POST">
                    <div class="new_btn_container">
                        <div class="form">
                            <input type="text" name="name" class="form__input" required>
                            <label class="form__label"><i class="fa-solid fa-user"></i> שם</label>
                        </div>
                    </div>

                    <div class="new_btn_container">
                        <div class="form">
                            <input type="text" name="name" class="form__input" required>
                            <label class="form__label"><i class="fa-solid fa-phone-flip"></i> טלפון</label>
                        </div>
                    </div>

                    <input type="submit" name="submit" id="submit" value="חזור אליי">
                </form>
            </div>
        </div>
    </div>

    <!-- REVIEWS SECTION -->
    <div class="reviews_wrapper">
        <div class="review_section_title">
            <h1>ביקורות מלקוחות קודמים</h1>
        </div>
        <?php 
            include_once('../loginSystem/db.php');
            $order = "DESC";
            $reviews_query = "SELECT reviews_info_table.id, reviews_info_table.from_email, reviews_info_table.to_email, reviews_info_table.account_name, reviews_info_table.account_picture, reviews_info_table.agent_name, reviews_info_table.subject, reviews_info_table.stars, reviews_info_table.body, reviews_info_table.date, accounts.picture_path 
                            FROM reviews_info_table 
                            LEFT JOIN accounts ON accounts.email=reviews_info_table.from_email 
                            WHERE reviews_info_table.to_email='$email'
                            ORDER BY reviews_info_table.date $order";
            try{
                $reviews_query_run = mysqli_query($con, $reviews_query);
                if (mysqli_num_rows($reviews_query_run) < 1){
                    echo "אין ביקורות קודמים.";
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
                                <img src='$review[picture_path]' alt='account pic'>
                                <div class='reviewer_name'>
                                    <span>$review[account_name]</span>
                                </div>";
                                if($isConnected and $review['from_email'] == $_SESSION['email']){
                                    echo "<div class='edit_review'>
                                        <form action='delete_review_code.php' method=POST>
                                            <input type='hidden' name='review_id' value=$review[id]>
                                            <input type='hidden' name='to_email' value='$review[to_email]'>
                                            <button type='submit' name='delete_submit' title='מחק ביקורת'><i class='fa-solid fa-trash-can'></i></button>
                                        </form>
                                    </div>";
                                }
                            echo "</div>

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
                                        } echo"
                                    </div>
                                </div>

                                <div class='review_subject'>
                                    <p>$review[body]</p>
                                    <div class='date_and_report'>
                                        <small>$review[date]</small>
                                        <div class='report_review'>
                                            <form class='reportReviewForm' action='report_page.php' target='_blank' method='GET'>
                                                <input type='hidden' name='type' value='review'>
                                                <input type='hidden' name='id' value='$review[id]'>
                                                <button type='submit'><i class='fa-solid fa-bell'></i>  דווח על שימוש לרעה</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }catch (Exception $e){
                echo $e;
            }
        ?>

        <div class="new_review_container">
            <div class="star_widget">
                    <input type="radio" name="rate" id="rate-5">
                    <label for="rate-5" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-4">
                    <label for="rate-4" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-3">
                    <label for="rate-3" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-2">
                    <label for="rate-2" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-1">
                    <label for="rate-1" class="fas fa-star"></label>
                <form id="new_review_form" action="new_review_code.php" method="POST">
                    <header></header>
                    <div class="textarea">
                        <textarea cols="30" maxlength="260" name="body" placeholder="תאר את החוויה שלך.." required></textarea>
                    </div>
                    <input type="hidden" id="subject" name="subject">
                    <input type="hidden" name="agent_email" value="<?php echo $email; ?>">
                    <input type="hidden" name="agent_name" value="<?php echo $office_name; ?>">
                    <div class="btn">
                        <input type="submit" name="new_review_submit" value="השאר ביקורת">
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- ASSETS SECTION -->   
    <!-- FOR SALE      -->
    <div class="assets_wrapper">
        <div class="for_sale_title">
            <h1>נכסים למכירה</h1>
        </div>
        <?php 
            $assets_for_sale = "SELECT * FROM assets_info_table WHERE email='$email' AND sale_or_rent='sale'";
            $assets_for_sale_run = mysqli_query($con, $assets_for_sale);

            while($card = mysqli_fetch_array($assets_for_sale_run)){
                if($card['sale_or_rent'] == 'sale'){
                    $background_path = '../images/title_icon.png';
                    for($i = 1; $i < 9; $i++){
                        if($card['file'.$i.'_path']){
                            $background_path = $card['file'.$i.'_path'];
                            break;
                        }
                    }
                    $price = "";
                    $symbol = "";
                    if($card['price'] > "" and $card['currency'] == 'shekel'){
                        $price = "מחיר: $card[price] ₪";
                        $symbol = "₪";
                    } elseif ($card['price'] > "" and $card['currency'] == 'dollar'){
                        $price = "מחיר: $card[price] $";
                        $symbol = "$";
                    }
                    echo ("
                    <div class='asset_card' id=$card[id] onclick='window.location.href=`AssetPage.php?id=$card[id]`' style='background-image: url($background_path)'>
                        <div class='description'>
                            <h4>$card[street] $card[house_number], $card[city]</h4>
                            <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                            <span>$price</span>
                        </div>
                    </div>
                
                    ");
                }
            }
        ?>
    </div>

    <!-- FOR RENT -->
    <div class="assets_wrapper" style="background: #f5f5f5;">
        <div class="for_sale_title">
            <h1>נכסים להשכרה</h1>
        </div>
        <?php 
            $assets_for_rent = "SELECT * FROM assets_info_table WHERE email='$email' AND sale_or_rent='rent'";
            $assets_for_rent_run = mysqli_query($con, $assets_for_rent);

            while($card = mysqli_fetch_array($assets_for_rent_run)){
                if($card['sale_or_rent'] == 'rent'){
                    $background_path = '../images/title_icon.png';
                    for($i = 1; $i < 9; $i++){
                        if($card['file'.$i.'_path']){
                            $background_path = $card['file'.$i.'_path'];
                            break;
                        }
                    }
                    $price = "";
                    $symbol = "";
                    if($card['price'] > "" and $card['currency'] == 'shekel'){
                        $price = "מחיר: $card[price] ₪";
                        $symbol = "₪";
                    } elseif ($card['price'] > "" and $card['currency'] == 'dollar'){
                        $price = "מחיר: $card[price] $";
                        $symbol = "$";
                    }
                    echo ("
                    <div class='asset_card' id=$card[id] onclick='window.location.href=`AssetPage.php?id=$card[id]`' style='background-image: url($background_path)'>
                        <div class='description'>
                            <h4>$card[street] $card[house_number], $card[city]</h4>
                            <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                            <span>$price</span>
                        </div>
                    </div>
                    ");
                }
                
            }
            mysqli_close($con);
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
                    <a href="<?php echo $account_footer_link; ?>"><?php echo $account_footer_text; ?></a>
                    <a href="<?php echo $agent_footer_link; ?>"><?php echo $agent_footer_text; ?></a>
                    <a href="#">צור פרופיל סוכנות</a>
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
    
    <!-- SHOW PICTURES -->
    <div class="show_picture" id="show_picture" onclick="closeIMG()">
        <img id="show_picture_img_element" onclick="">
    </div>
    
    <script>
        var show_picture = document.getElementById("show_picture");
        var show_picture_img_element = document.getElementById("show_picture_img_element");
        
        function clickedIMG(img_source){
            show_picture.style.height = "100%";
            show_picture_img_element.src = img_source;
        }
        function closeIMG(){
            show_picture.style.height = "0";
            show_picture_img_element.src = "";
        }

        var subject = document.getElementById("subject");
        document.getElementById("rate-5").addEventListener("change", function(){
            subject.value = 5;
        });
        document.getElementById("rate-4").addEventListener("change", function(){
            subject.value = 4;
        });
        document.getElementById("rate-3").addEventListener("change", function(){
            subject.value = 3;
        });
        document.getElementById("rate-2").addEventListener("change", function(){
            subject.value = 2;
        });
        document.getElementById("rate-1").addEventListener("change", function(){
            subject.value = 1;
        });

        // new review submit function
        document.getElementById('new_review_form').onsubmit = function() {
            return isReviewFormValid();
        }
        // report agent function
        document.getElementById('reportForm').onsubmit = function(){
            return isAgentReportValid();
        }
        // report review function
        var reportReviewForms = document.getElementsByClassName('reportReviewForm');
        for(var i = 0; i < reportReviewForms.length; i++){
            reportReviewForms[i].addEventListener('submit', function(event){
                if (isConnected){
                    return true;
                } else {
                    event.preventDefault();
                    alert("עליך להירשם על מנת לדווח.");
                    return false;
                }
            });
        }

        const isConnected = <?php echo json_encode($isConnected); ?>;
        const isNotSameAgent = <?php echo json_encode($isNotSameAgent); ?>;

        function isReviewFormValid(){
    
            if(isConnected){
                if(isNotSameAgent){
                    if(subject.value > 0){
                        return true;
                    } else {
                        alert("יש למלא לפחות כוכב אחד או יותר");
                        return false;
                    }
                    
                } else {
                    alert("לא ניתן להשאיר ביקורת על הפרופיל של עצמך");
                    return false;
                }
                
            } else {
                alert("על מנת לכתוב ביקורת - חייב להתחבר");
                return false;
            }
        }

        function isAgentReportValid(){
            if (isConnected){
                if(isNotSameAgent){
                    return true;
                } else {
                    alert("לא ניתן לדווח על הפרופיל של עצמך");
                    return false;
                }
            } else {
                alert("עליך להירשם על מנת לדווח.");
                return false;
            }
        }

    </script>
</body>
</html>