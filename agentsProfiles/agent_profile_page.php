<?php session_start();

    if(!isset($_SESSION['verify_token']) or !isset($_SESSION['email'])) {
        header("Location: ../loginSystem/login_page.php");
        exit();
    } elseif (!isset($_SESSION['is_agent']) or $_SESSION['is_agent'] != '1'){
        header("Location: ../createProfiles/create_agent_page.php");
        exit();
    }
    $email = $_SESSION['email'];
    $picture_path = $_SESSION['picture_path'];
    $logo = $_SESSION['logo_path'];
    $agent_cities = $_SESSION['agent_cities'];
    $phone_number = $_SESSION['phone_number'];
    $birth_date = $_SESSION['birth_date'];
    $website_link = $_SESSION['website_link'];
    $office_address = $_SESSION['office_address'];
    $years_of_exp = $_SESSION['years_of_exp'];
    $about_agent = $_SESSION['about_agent'];
    $office_name = $_SESSION['office_name'];
    $license_year = $_SESSION['license_year'];
    $for_sale = $_SESSION['for_sale'];
    $for_rent = $_SESSION['for_rent'];
    $agency_profile = 'צור פרופיל סוכנות';
    if ($_SESSION['is_agency'] == 1) {
        $agency_link = '#'; // TODO create agency page
        $agency_profile = 'פרופיל הסוכנות שלי';
    }

    # Add space after each comma in agent_cities
    $formatted_agent_cities = "";
    for($i = 0; $i < strlen($agent_cities); $i++){
        if($agent_cities[$i] == ','){
            $formatted_agent_cities .= $agent_cities[$i].' ';
        } else {
            $formatted_agent_cities .= $agent_cities[$i];
        }
    }
    $id = 0;
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
    <link rel="stylesheet" type="text/css" href="agent_profile_page_style.css">

    <title>פרופיל הסוכן שלי</title>
</head>

    <style>
        body{
            margin: 0;
            padding: 0;
        }
    </style>

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
            <li><a href="../public/agentSearch.php">סוכנים</a></li>
            <li><a href="../public/assetSearch.php">נכסים</a></li>
            <li><a href='../Accounts/account_page.php'>חשבון</a></li>
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
    
    <!-- INFO SECTION -->
    <div class="info_wrapper">
        <div class="info">
            <div class="edit">
                <div class="btn_container">
                    <button onclick="window.location.href='edit_agent_info_page.php'"><i class="fa-solid fa-user-pen"> ערוך פרטים</i></button>
                </div>
                <div class="btn_container">
                    <button onclick="window.location.href='upload_new_asset_page.php'"><i class="fa-solid fa-plus"> פרסום נכס חדש</i></button>
                </div>
            </div>
            <div class="title_and_logo">
                <h1><?php echo ($_SESSION['first_name']." ".$_SESSION['last_name']) ?></h1>
                <div class="images_container">
                    <img src="<?php echo $picture_path; ?>" onclick="clickedIMG(this.src)" alt="profile picture">
                    <?php if($logo > ""){echo ("<img src='$logo' alt='LOGO' onclick='clickedIMG(this.src)'>");} ?>
                </div>
                
            </div>
            <div class="basic_info">
                <span>משרד: <b><?php echo $office_name; ?></b></span>
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

    <!-- ASSETS SECTION -->   
    <!-- FOR SALE      -->
    <div class="assets_wrapper">
        <div class="for_sale_title">
            <h1>נכסים למכירה</h1>
        </div>
        <?php 
            include_once('../loginSystem/db.php');
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
                    echo ("<form action='assets_pages.php' method='POST'>
                    <div class='asset_card' id=$id style='background-image: url($background_path)'>
                        <div class='description'>
                            <h4>$card[street] $card[house_number], $card[city]</h4>
                            <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                            <span>$price</span>
                        </div>
                    </div>
                    <input type=hidden name=office_name value='$office_name'>
                    <input type=hidden name=agent_phone value='$phone_number'>
                    <input type=hidden name=id value='$card[id]'>
                    <input type=hidden name=email value='$card[email]'>
                    <input type=hidden name=post_time value='$card[post_time]'>
                    <input type=hidden name=agent_directory_path value='$card[agent_directory_path]'>
                    <input type=hidden name=asset_directory_path  value='$card[asset_directory_path]'>
                    <input type=hidden name=sale_or_rent value='$card[sale_or_rent]'>
                    <input type=hidden name=asset_type value='$card[asset_type]'>
                    <input type=hidden name=asset_condition value='$card[asset_condition]'>
                    <input type=hidden name=city value='$card[city]'>
                    <input type=hidden name=street value='$card[street]'>
                    <input type=hidden name=house_number value='$card[house_number]'>
                    <input type=hidden name=floor value='$card[floor]'>
                    <input type=hidden name=max_floor value='$card[max_floor]'>
                    <input type=hidden name=num_of_rooms value='$card[num_of_rooms]'>
                    <input type=hidden name=balcony value='$card[balcony]'>
                    <input type=hidden name=size_in_sm value='$card[size_in_sm]'>
                    <input type=hidden name=parking_station value='$card[parking_station]'>
                    <input type=hidden name=entrance_date value='$card[entrance_date]'>
                    <input type=hidden name=check_boxes value='$card[check_boxes]'>
                    <input type=hidden name=price value='$card[price]'>
                    <input type=hidden name=tax value='$card[tax]'>
                    <input type=hidden name=currency value='$card[currency]'>
                    <input type=hidden name=symbol value='$symbol'>
                    <input type=hidden name=asset_description value='$card[asset_description]'>
                    <input type=hidden name=file1_path value='$card[file1_path]'>
                    <input type=hidden name=file2_path value='$card[file2_path]'>
                    <input type=hidden name=file3_path value='$card[file3_path]'>
                    <input type=hidden name=file4_path value='$card[file4_path]'>
                    <input type=hidden name=file5_path value='$card[file5_path]'>
                    <input type=hidden name=file6_path value='$card[file6_path]'>
                    <input type=hidden name=file7_path value='$card[file7_path]'>
                    <input type=hidden name=file8_path value='$card[file8_path]'>
                    </form>");
                    $id++;
                }
            }
        ?>
        
        <!-- <div class="asset_card" style="background-image: url(../images/house1.jpg);">
            <div class="description">
                <h4>בן אליעזר אריה 45, רמת גן</h4>
                <span>דירה, 4.5 חדרים, 100 מ"ר, קומה 5 מתוך 7.</span>
                <span>מחיר: 2,840,000 ₪</span>
            </div>
        </div> -->
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
                    echo ("<form action='assets_pages.php' method='POST'>
                    <div class='asset_card' id=$id style='background-image: url($background_path)'>
                        <div class='description'>
                            <h4>$card[street] $card[house_number], $card[city]</h4>
                            <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                            <span>$price</span>
                        </div>
                    </div>
                    <input type=hidden name=office_name value='$card[office_name]'>
                    <input type=hidden name=agent_phone value='$card[agent_phone]'>
                    <input type=hidden name=id value='$card[id]'>
                    <input type=hidden name=email value='$card[email]'>
                    <input type=hidden name=post_time value='$card[post_time]'>
                    <input type=hidden name=agent_directory_path value='$card[agent_directory_path]'>
                    <input type=hidden name=asset_directory_path  value='$card[asset_directory_path]'>
                    <input type=hidden name=sale_or_rent value='$card[sale_or_rent]'>
                    <input type=hidden name=asset_type value='$card[asset_type]'>
                    <input type=hidden name=asset_condition value='$card[asset_condition]'>
                    <input type=hidden name=city value='$card[city]'>
                    <input type=hidden name=street value='$card[street]'>
                    <input type=hidden name=house_number value='$card[house_number]'>
                    <input type=hidden name=floor value='$card[floor]'>
                    <input type=hidden name=max_floor value='$card[max_floor]'>
                    <input type=hidden name=num_of_rooms value='$card[num_of_rooms]'>
                    <input type=hidden name=balcony value='$card[balcony]'>
                    <input type=hidden name=size_in_sm value='$card[size_in_sm]'>
                    <input type=hidden name=parking_station value='$card[parking_station]'>
                    <input type=hidden name=entrance_date value='$card[entrance_date]'>
                    <input type=hidden name=check_boxes value='$card[check_boxes]'>
                    <input type=hidden name=price value='$card[price]'>
                    <input type=hidden name=tax value='$card[tax]'>
                    <input type=hidden name=currency value='$card[currency]'>
                    <input type=hidden name=symbol value='$symbol'>
                    <input type=hidden name=asset_description value='$card[asset_description]'>
                    <input type=hidden name=file1_path value='$card[file1_path]'>
                    <input type=hidden name=file2_path value='$card[file2_path]'>
                    <input type=hidden name=file3_path value='$card[file3_path]'>
                    <input type=hidden name=file4_path value='$card[file4_path]'>
                    <input type=hidden name=file5_path value='$card[file5_path]'>
                    <input type=hidden name=file6_path value='$card[file6_path]'>
                    <input type=hidden name=file7_path value='$card[file7_path]'>
                    <input type=hidden name=file8_path value='$card[file8_path]'>
                    </form>");
                    $id++;
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
                    <a href="../Accounts/account_page.php">החשבון שלי</a>
                    <a href="#">פרופיל הסוכן שלי</a>
                    <a href="#"> <?php echo $agency_profile; ?> </a>
                </div>
                <div class="footer-link-items">
                    <h2>חיפושים</h2>
                    <a href="../public/agentSearch.php">חיפוש סוכנים</a>
                    <a href="../public/assetSearch.php">חיפוש נכסים</a>
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
        
        // Set div's onclick = submit closest form
        var cards = Array(<?php echo $id ?>);
        for(var i = 0; i < cards.length; i++){
            cards[i] = document.getElementById(i);
            cards[i].onclick = function(){
                this.closest("form").submit();
                return false;
            }
        }
        
    </script>
</body>
</html>
