<?php session_start();
    $isRegistered = false;
    $agent_profile = '<i class="fa-solid fa-plus"></i> צור פרופיל סוכן';
    $agent_profile_footer = 'צור פרופיל סוכן';
    $agency_profile = 'צור פרופיל סוכנות';
    $agent_link = 'loginSystem/login_page.php';
    $first_name = '';
    $login_or_logout = '';
    $loginLink_or_logoutLink = '';
    if (!isset($_SESSION['email']) or empty($_SESSION['email'])){
        $first_name = "אורח";
        $login_or_logout = "התחבר";
        $loginLink_or_logoutLink = "loginSystem/login_page.php";
    } else {
        $first_name = $_SESSION['first_name'];
        $login_or_logout = "התנתק";
        $loginLink_or_logoutLink = "loginSystem/logout.php";
        $isRegistered = true;
        $agent_link = 'createProfiles/create_agent_page.php';
        if ($_SESSION['is_agent'] == 1) {
            $agent_link = 'agentsProfiles/agent_profile_page.php'; // TODO create agent page
            $agent_profile = 'פרופיל הסוכן שלי';
            $agent_profile_footer = 'פרופיל הסוכן שלי';
        } 
        if ($_SESSION['is_agency'] == 1) {
            $agency_link = '#'; // TODO create agency page
            $agency_profile = 'פרופיל הסוכנות שלי';
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		<meta name="description" content="Get real estate agent / agency">
		<meta name="keywords" content="Get Agent real estate agency buy sell rent">
		<meta name="author" content="Ron Sharabi">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0,' name='viewport' />
        <link rel="icon" type="png" href="images/title_icon.png">
        <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" type="text/css" href="Nav.css">
        <link rel="stylesheet" type="text/css" href="Footer.css">
        <link rel="stylesheet" type="text/css" href="TopSection.css">
        <link rel="stylesheet" type="text/css" href="ScrollBar.css">
        <link rel="stylesheet" type="text/css" href="OpenProfiles.css">
        <link rel="stylesheet" type="text/css" href="AgentCards.css">


        <title>גט אייג'נט</title>
        
        <style>
            body, html {
                margin: 0px;
                padding: 0px;
                overflow-x: hidden;
                direction: rtl;
            }    
        </style>
    </head>

    <body>

        <!-- Navigation bar, Ty Dev Ed-->
        <nav>
            <div class="logo">
                <a href="index.php">
                <img class="myLogo" src="images/Logo.png" style="width: 60px;" alt="logo">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#">בית</a></li>
                <li><a href="#">סוכנים</a></li>
                <li><a href="#">נכסים</a></li>
                <li><a href='<?php if($isRegistered){echo "Accounts/account_page.php";}else{echo "loginSystem/login_page.php";} ?>'>חשבון</a></li>
                <li><a href="About/about_page.php">עלינו</a></li>
                <li><a href=<?php echo $loginLink_or_logoutLink ?> > <?php echo $login_or_logout ?></a></li>
            </ul>
            <div class="burger">
                <div class="lin1"></div>
                <div class="lin2"></div>
                <div class="lin3"></div>
            </div>        
        </nav>
        <script src="Nav.js" type="text/javascript"></script>
        
        
        <!-- TOP SECTION -->
        <div class="top-container">
            <img src="images/login_page_background.jpg" visibility='hidden'>
            <h1>GET.AGENT</h1>
            <p>מאגר נכסים, סוכנים וסוכנויות נדל"ן</p>
        </div>

        <!-- OPEN PROFILES SECTION -->
        <div class="profiles-section">
            <button type="button" class="button-1" onclick="window.location.href='<?php echo $agent_link; ?>'"><?php echo $agent_profile; ?></button>
            <button type="button" class="button-2" onclick="window.location.href='createProfiles/create_agent_page.php'"><i class="fa-solid fa-plus"></i>צור פרופיל סוכנות</button>
            <button type="button" class="button-3" onclick="window.location.href='<?php if($isRegistered){echo 'Accounts/account_page.php';}else{echo 'loginSystem/login_page.php';} ?>'">החשבון שלי</button>
        </div>

        <!-- AGENTS SECTION -->
        <div class="agents_wrapper">
            <div class="agents_container">
                <?php 
                    include_once("loginSystem/db.php");
                    $search_agents = "SELECT * FROM agents_info_table LIMIT 3";
                    $search_agents_run = mysqli_query($con, $search_agents);

                    while($agent = mysqli_fetch_array($search_agents_run)) {
                        $picture_path = substr($agent['logo_path'], 3, strlen($agent['logo_path']));
                        $cities = str_replace(",", ", ", $agent['agent_cities']);

                        echo "
                            <div class='agent_card'>
                                <div class='agent_top_card'>
                                    <div class='agent_pic_container'>
                                        <img src=$picture_path onclick='window.location.href=`public/AgentProfile.php?email=$agent[email]`' alt=agent_pic>
                                    </div>
                                    <div class='agent_top_details'>
                                        <a class='agent_title' href='public/AgentProfile.php?email=$agent[email]'>$agent[office_name]</a>
                                        <span class='agent_forsale'>$agent[for_sale] נכסים למכירה</span>
                                        <span class='agent_forsale'>$agent[for_rent] נכסים להשכרה</span>
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
                    }

                    mysqli_close($con);
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
                        <a href="About/about_page.php">על גט אייג'נט</a>
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
                        <?php if(!$isRegistered){echo "<a href='loginSystem/login_page.php'>התחבר</a>";}else{echo "<a href='Accounts/account_page.php'>החשבון שלי</a>";} ?>
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
                        <a href="index.php"><img src="images/Logo.png" style="width: 60px;"></img></a>
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
    </body>
</html>