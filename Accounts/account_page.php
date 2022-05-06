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
    $max_reviews = 6;
    $max_asset_cards = 10;
    $max_agent_cards = 4;
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
    <link rel="stylesheet" type="text/css" href="../PagerStyle.css">
    <link rel="stylesheet" type="text/css" href="../AssetsCards.css">
    <link rel="stylesheet" type="text/css" href="../AgentCards.css">
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
            <li><a href="../public/agentSearch.php">סוכנים</a></li>
            <li><a href="../public/assetSearch.php">נכסים</a></li>
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
            $j = 1;
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
                <div class='review_container query'"; if($j > $max_reviews){echo " style='display: none;'";} echo">
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
                $j++;
            }
            echo "
                <div class='pager_container'>
                    <div class='pagination'>
                        <ul id='queryPager'>
                            
                        </ul>
                    </div>
                </div>
                ";

        } catch (Exception $e) {
            echo $e;
        }
        
    ?>

    </div>

    <!-- ACCOUNT'S ASSETS LIKES SECTION -->
    <div class='assets_wrapper'>
        <div class='for_sale_title'>
            <h1>הנכסים שאהבתה</h1>
        </div>
        <?php 
            $liked_asset_query = "SELECT *
                                    FROM assets_info_table
                                    WHERE email_likes LIKE '%$email%'";
            try{
                $liked_asset_query_run = mysqli_query($con, $liked_asset_query);
                $index = 1;
                while($card = mysqli_fetch_array($liked_asset_query_run)){
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
                    echo "
                    <div class='asset_card asset' id=$card[id] onclick='window.location.href=`../public/AssetPage.php?id=$card[id]`' style='background-image: url($background_path);"; if($index > $max_asset_cards){echo "display: none;";} echo "'>
                        <form class='unlikeForm' action='../public/UnlikeCode.php' method='POST'>
                            <button class='unlikeBtn' type='submit' title='הסר מהרשימה'><i class='fa-regular fa-heart'></i></button>
                            <input type='hidden' name='type' value='asset'>
                            <input type='hidden' name='type_id' value=$card[id]>
                        </form>
                        <div class='description'>
                            <h4>$card[street] $card[house_number], $card[city]</h4>
                            <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                            <span>$price</span>
                        </div>
                    </div>             
                    ";
                    $index++;
                }
                echo "  <div class='pager_container'>
                            <div class='pagination'>
                                <ul id='assetsPager'>

                                </ul>
                            </div>
                        </div>";
            } catch (Exception $e){
                echo $e->getMessage();
            }
        ?>
    </div>

    <!-- ACCOUNT'S AGENTS LIKES SECTION -->
    <div class="agents_wrapper">
        <div class="agents_container">
            <div class="top_title">
                <h1>הסוכנים שאהבתה</h1>
            </div>
    <?php 
        try{
            $search_agents = "SELECT agents_info_table.office_name, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, agents_info_table.logo_path, agents_info_table.id, agents_info_table.email_likes, AVG(reviews_info_table.stars) as min_rank
                                FROM agents_info_table
                                LEFT JOIN reviews_info_table on agents_info_table.email = reviews_info_table.to_email
                                GROUP BY agents_info_table.email
                                HAVING agents_info_table.email_likes LIKE '%$email%'
                                ORDER BY min_rank DESC";
            
            $search_agents_run = mysqli_query($con, $search_agents);
            $index = 1;
            while($agent = mysqli_fetch_array($search_agents_run)) {
                $picture_path = $agent['logo_path'];
                $cities = str_replace(",", ", ", $agent['agent_cities']);

                echo "
                    <div class='agent_card agent'>
                        <div class='agent_top_card'>
                            <div class='agent_pic_container'>
                                <img src=$picture_path onclick='window.location.href=`../public/AgentProfile.php?email=$agent[email]`' alt=agent_pic>
                            </div>
                            <div class='agent_top_details'>
                                <div class='title'>
                                    <a class='agent_title' href='../public/AgentProfile.php?email=$agent[email]'>$agent[office_name]</a>
                                    <form class='unlikeForm' action='../public/UnlikeCode.php' method='POST'>
                                        <button class='unlikeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                        <input type='hidden' name='type' value='agent'>
                                        <input type='hidden' name='type_id' value=$agent[id]>
                                    </form>
                                </div>
                                <span class='agent_forsale'>נכסים למכירה: $agent[for_sale]</span>
                                <span class='agent_forsale'>נכסים להשכרה: $agent[for_rent]</span>
                                <span class='agent_forsale'>ממוצע דירוג לקוחות: $agent[min_rank]</span>
                            </div>
                        </div>
                        <div class='agent_bottom_card'>
                            <div class='agent_cities'>
                                <div>
                                    <label>עריי פעילות:</label>
                                    <p class='title'>$cities</p>
                                </div>
                                <div>
                                    <label>צור קשר:</label>
                                    <p class='title'>$agent[phone_number]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
                $index++;
            }
            echo "
                <div class='pager_container'>
                    <div class='pagination'>
                        <ul id='agentsPager'>
                            
                        </ul>
                    </div>
                </div>
            ";
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            mysqli_close($con);
        }
    ?>
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
                    <?php if(!$isRegistered){echo "<a href='../loginSystem/login_page.php'>התחבר</a>";}else{echo "<a href='../Accounts/account_page.php'>החשבון שלי</a>";} ?>
                    <a href="<?php echo $agent_link; ?>"> <?php echo $agent_profile_footer; ?> </a>
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
    <script type="text/javascript" src="../PagerScript.js"></script>
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
        
        // reviews pager
        const MAX_CARDS = <?php echo json_encode($max_reviews) ?>;
            
        let numOfCards = document.querySelectorAll('.review_container');
        let numOfPages = Math.ceil(numOfCards.length / MAX_CARDS);
            
        element("queryPager", numOfPages, 1, "query", MAX_CARDS);

        // assets pager
        const MAX_ASSET_CARDS = <?php echo json_encode($max_asset_cards) ?>;
        
        let numOfAssetCards = document.querySelectorAll(".asset");
        let numOfAssetPages = Math.ceil(numOfAssetCards.length / MAX_ASSET_CARDS);

        element("assetsPager", numOfAssetPages, 1, "asset", MAX_ASSET_CARDS);

        // agents pager
        const MAX_AGENT_CARDS = <?php echo json_encode($max_agent_cards) ?>;

        let numOfAgentCards = document.querySelectorAll('.agent');
        let numOfAgentPages = Math.ceil(numOfAgentCards.length / MAX_AGENT_CARDS);

        element("agentsPager", numOfAgentPages, 1, "agent", MAX_AGENT_CARDS);
    </script>

</body>
</html>