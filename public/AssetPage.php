<?php session_start();
    // if id does not exist or empty go to main page
    if(!isset($_GET['id']) or empty($_GET['id'])){
        header("Location: ../index.php");
        exit();
    }
    $id = $_GET['id'];
    include_once("../loginSystem/db.php");

    // asset details query
    $get_asset_details = "SELECT * FROM assets_info_table WHERE id='$id' LIMIT 1";
    $get_asset_details_run = mysqli_query($con, $get_asset_details);
    $foundAsset = mysqli_num_rows($get_asset_details_run);

    // if could not find asset with this id, go to main page
    if(!$foundAsset){
        mysqli_close($con);
        header("Location: ../index.php");
        exit();
    }
    // asset details query to array
    $asset_details = mysqli_fetch_array($get_asset_details_run);

    mysqli_close($con);

    $checkboxes_sent = $asset_details['check_boxes'];
    $asset_address = $asset_details['street'] . ' ' . $asset_details['house_number'] . ' ' . $asset_details['city'];  

    if(!empty($asset_details['price'])){
        $price_per_sm = number_format(ceil(str_replace(",", "", $asset_details['price']) / $asset_details['size_in_sm']));
        if($asset_details['currency'] == 'dollar'){
            $symbol = "$";
        } else {
            $symbol = "₪";
        }
    }
    $images = array();
    for($i = 1; $i < 9; $i++){
        if($asset_details['file' . $i . '_path'] > ""){
            array_push($images, $asset_details['file' . $i . '_path']);
        }
    }
    if(empty($images)){
        array_push($images, "../images/title_icon.png");
    }
    $date = explode("-", $asset_details['entrance_date']);
    $entrance_date = $date[2].'-'.$date[1].'-'.$date[0];

    $time = explode("-", $asset_details['post_time']);
    $post_date = $time[2].'-'.$time[1].'-'.$time[0];

    $tax = "לא צויין";
    if($asset_details['tax'] > ""){
        $tax = $asset_details['tax'].' ₪';
    }

    $balcony = "לא צויין";
    if($asset_details['balcony'] > "" and $asset_details['balcony'] != "ללא"){
        $balcony = $asset_details['balcony'];
    }

    $parking_station = "לא צויין";
    if($asset_details['parking_station'] > "" and $asset_details['parking_station'] != "ללא"){
        $parking_station = $asset_details['parking_station'];
    }
    
    $asset_condition = "";
    if($asset_details['asset_condition']){
        $asset_condition = $asset_details['asset_condition'];
    }
    $isConnected = false;
    $login_text = "התחבר";
    $login_link = "../loginSystem/login_page.php";
    $account_footer_text = "התחבר";
    $account_footer_link = "../loginSystem/login_page.php";
    $agent_footer_text = "צור פרופיל סוכן";
    $agent_footer_link = "../loginSystem/login_page.php";
    if(isset($_SESSION['email'], $_SESSION['verify_token']) and !empty($_SESSION['email']) and !empty($_SESSION['verify_token'])){
        $isConnected = true;
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="POST real estate agent / agency">
    <meta name="keywords" content="POST Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <link rel="icon" type="png" href="../images/title_icon.png">
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <link rel="stylesheet" type="text/css" href="ReportBtn.css">
    <link rel="stylesheet" type="text/css" href="../agentsProfiles/assets_pages_style.css">
    <!-- IMAGES SLIDERS -->
    <title>גט אייג'נט - דף נכס</title>

    <style>
        body{
            margin: 0;
            padding: 0;
            direction: rtl;
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
            <li><a href="agentSearch.php">סוכנים</a></li>
            <li><a href="assetSearch.php">נכסים</a></li>
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

    
    
    <!-- ASSET SECTION -->
    <div class="asset_wrapper">
        <div class="asset_container">

            <div class="images_container">
                <div class="images">
                    <?php 
                        foreach($images as $img){
                            echo "<img src=$img>";
                            $i++;
                        }
                    ?>
                </div>
                <div class="slide right">
                    <span onclick="side_slide(1)" class="fas fa-angle-right"></span>
                </div>
                <div class="slide left">
                    <span onclick="side_slide(-1)" class="fas fa-angle-left"></span>
                </div>
                <div class="btn_sliders">
                    <?php 
                        for($i = 0, $j = 1; $i < count($images); $i++, $j++){
                            echo "<span onclick='btn_slide($j)'></span>";
                        }
                    ?>
                </div>
            </div>

            <div class="details_container">
                <div class="address_and_price">
                    <div class="address">
                        <?php if($asset_details['house_number']){ echo "<h1>$asset_details[street] $asset_details[house_number]</h1>";}else{echo "<h2>$asset_details[street]</h2>";} ?>
                        <h2><?php echo $asset_details['city']; ?></h2>
                        <h4>פורסם ב <?php echo $post_date; ?></h4>
                    </div>
                    <div class="price">
                    <?php if($asset_details['price']){ echo "<h1>$asset_details[price] $symbol</h1>";} ?>
                    </div>
                </div>

                <div class="asset_details">
                    <div class="asset_status">
                        <?php 
                            $status = "";
                            if($asset_details['sale_or_rent'] == 'sale'){$status = "מכירה";}else{$status = "השכרה";}
                            echo "<h3>$asset_details[asset_type] ל$status</h3>"; 
                        ?>
                    </div>
                    <div class="details">
                        <?php 
                            echo "
                                <span><i class='fa-solid fa-building'></i>$asset_details[asset_type]</span>
                                <span><i class='fa-solid fa-bed'></i> $asset_details[num_of_rooms] חד'</span>
                                <span><i class='fa-solid fa-stairs'></i> קומה $asset_details[floor] מתוך $asset_details[max_floor]</span>
                                <span><i class='fa-solid fa-maximize'></i> $asset_details[size_in_sm] מ\"ר</span>
                                <span><i class='fa-solid fa-money-bill-1'></i>"; if(!empty($price_per_sm)){echo $price_per_sm.' '.$symbol;} echo " למ\"ר בנוי</span>
                            ";
                        ?>
                    </div>
                    <div class="asset_description">
                        <?php 
                            if($asset_details['asset_description'] > ""){
                                echo "
                                    <h2>תיאור המקום</h2>
                                    <p>$asset_details[asset_description]</p>
                                ";
                            }
                        ?>
                    </div>
                    <div class="contact_wrapper">
                        <div class="contact_container">

                            <div class="agent_details">
                                <div class="icon_name" onclick="window.location.href='AgentProfile.php?email=<?php echo $asset_details['email']; ?>'">
                                    <i class="fa-solid fa-circle-user"></i>
                                    <span><?php echo $asset_details['office_name']; ?></span>
                                </div>
                                <div class="agent_phone">
                                    <i class="fa-solid fa-phone"></i>
                                    <span><?php echo $asset_details['agent_phone']; ?></span>
                                </div>
                            </div>

                            <hr>
                            <?php
                                if(isset($_SESSION['status'])){
                                    echo "<div class='status_container'>
                                            <h3>$_SESSION[status]</h3>
                                        </div>
                                    ";
                                    unset($_SESSION['status']);
                                } 
                            ?>

                            <div class="user_details">
                                <form action="mailAgent.php" method="POST">
                                    <input type="tel" name="phone" class="user_phone" placeholder="מספר פלאפון" required>
                                    <input type="hidden" name="agent_email" value="<?php echo $asset_details['email'] ?>">
                                    <input type="submit" class="contact_submit" name="submit" value="אני רוצה עוד פרטים">
                                </form>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="asset_specific">
                <div class="title">
                    <h2>מפרט</h2>
                </div>
                <div class="specific">
                    <span>מיזוג</span>
                    <span>סורגים</span>
                </div>
                <div class="specific">
                    <span>מעלית</span>
                    <span>מטבח כשר</span>
                </div>
                <div class="specific">
                    <span>גישה לנכים</span>
                    <span>ממ"ד</span>
                </div>
                <div class="specific">
                    <span>משופצת</span>
                    <span>מחסן</span>
                </div>
                <div class="specific">
                    <span>מזגן תדיראן</span>
                    <span>ריהוט</span>
                </div>
            </div>

            <div class="last_details">
                <div class="last_d">
                    <span><i class="fa-solid fa-circle"></i>מצב הנכס: <?php echo $asset_condition; ?></span>
                    <span><i class="fa-solid fa-circle"></i>תאריך כניסה: <?php echo $entrance_date; ?></span>
                </div>
                <div class="last_d">
                    <span><i class="fa-solid fa-circle"></i>ארנונה: <?php echo $tax; ?></span>
                    <span><i class="fa-solid fa-circle"></i>מרפסת: <?php echo $balcony; ?></span>
                </div>
                <div class="last_d">
                    <span><i class="fa-solid fa-circle"></i>חניה: <?php echo $parking_station; ?></span>
                </div>
            </div>

            <div class="report_wrapper">
                <form id="reportForm" action="report_page.php" target="_blank" method="GET">
                    <input type="hidden" name="type" value="asset">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit"><i class="fa-solid fa-bell"></i>  דווח על שימוש לרעה</button>
                </form>
            </div>
        </div>
        <div class="map_container">
            <div class="map">
                <?php
                    if($asset_address > ""){
                        echo("<iframe
                        width='100%'
                        height='250'
                        style='border:0'
                        loading='lazy'
                        allowfullscreen
                        src='https://www.google.com/maps/embed/v1/place?key=AIzaSyBXRumEWyF_l3cYf0xrzAWQsFeyUzB-zzA
                            &q=$asset_address'>
                        </iframe>");
                    }
                ?>
            </div>
        </div>
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
                    <a href="agentSearch.php">חיפוש סוכנים</a>
                    <a href="assetSearch.php">חיפוש נכסים</a>
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
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-facebook-square"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Displaying and Switching images functions
        var indexValue = 1;
        showImg(indexValue);
        function btn_slide(e){showImg(indexValue = e);}
        function side_slide(e){showImg(indexValue -= e);}
        function showImg(e){
            var i;
            const img = document.querySelectorAll('.images img');
            const sliders = document.querySelectorAll('.btn_sliders span');
            if (e > img.length){indexValue = 1}
            if (e < 1){indexValue = img.length}
            for(i = 0; i < img.length; i++){
                img[i].style.display = "none";
            }
            for(i = 0; i < sliders.length; i++){
                sliders[i].style.background = "rgba(255,255,255,0.1)";
            }
            img[indexValue - 1].style.display = "block";
            sliders[indexValue - 1].style.background = "#242424";

        }

        
        const asset_specification = document.querySelectorAll(".specific span");
        <?php echo "var checkboxes_sent = '$checkboxes_sent';"; ?>
        
        const specificArr = checkboxes_sent.split(",");
        // display CHECKED ICON and BOLD FONT next to each asset specific detail 
        for(var i = 0; i < asset_specification.length; i++){
            for(var j = 1; j < specificArr.length; j++){
                if(specificArr[j] == asset_specification[i].innerHTML){
                    asset_specification[i].style.fontWeight = "bold";
                    
                    // Create an "li" node:
                    const element = document.createElement("i");

                    // Set class to element
                    element.className = ("fa-solid fa-check");
                    // Append the "i" element to the span:
                    asset_specification[i].appendChild(element);

                    console.log(asset_specification[i].childNodes);
                }
            }
        }

        // report submit function
        document.getElementById('reportForm').onsubmit = function(){
            return isValidForm();
        }
        function isValidForm(){
            const isConnected = <?php echo json_encode($isConnected);?>;

            if (isConnected){
                return true;
            } else {
                alert("עליך להירשם על מנת לדווח.");
                return false;
            }
        }
    </script>
</body>
</html>
