<?php session_start();
    $isRegistered = false;
    $agent_profile = 'צור פרופיל סוכן';
    $agency_profile = 'צור פרופיל סוכנות';
    $agent_link = '../loginSystem/login_page.php';
    $login_or_logout = '';
    $loginLink_or_logoutLink = '';
    $first_name = 'אורח';
    if (!isset($_SESSION['first_name']) or empty($_SESSION['first_name'])){
        $login_or_logout = "התחבר";
        $loginLink_or_logoutLink = "../loginSystem/login_page.php";
    } else {
        $first_name = $_SESSION['first_name'];
        $login_or_logout = "התנתק";
        $loginLink_or_logoutLink = "../loginSystem/logout.php";
        $isRegistered = true;
        $agent_link = '../createProfiles/create_agent_page.php';
        if ($_SESSION['is_agent'] == 1) {
            $agent_link = '../agentsProfiles/agent_profile_page.php'; // TODO create agent page
            $agent_profile = 'פרופיל הסוכן שלי';
        } 
        if ($_SESSION['is_agency'] == 1) {
            $agency_profile = 'פרופיל הסוכנות שלי';
        } 
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
    <link rel="stylesheet" type="text/css" href="about_page_style.css">

    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>

    <title>על גט אייג'נט</title>

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
            <li><a href='<?php if($isRegistered){echo "../Accounts/account_page.php";}else{echo "../loginSystem/login_page.php";} ?>'>חשבון</a></li>
            <li><a href=<?php echo $loginLink_or_logoutLink ?> > <?php echo $login_or_logout ?></a></li>
        </ul>
        <div class="burger">
            <div class="lin1"></div>
            <div class="lin2"></div>
            <div class="lin3"></div>
        </div>        
    </nav>
    <script src="../Nav.js" type="text/javascript"></script>
    
    <!-- TOP SECTION -->
    <div class="section">
        <div class="container">
            <div class="content-section">
                <div class="title">
                    <h1>על גט אייג'נט</h1>
                </div>
                <div class="content">
                    <h3>שלום <?php echo $first_name ?>, אתר גט אייג'נט הינו אתר אשר מכיל מאגר של סוכני וסוכנויות נדל"ן בכל הארץ.</h3>
                    <p>האתר הוקם ע"י סטודנט בהנדסת תוכנה והוקם במטרה להקל על חיפוש אחר סוכן נדל"ן המתאים ביותר לציפיות הלקוח. באתר אפשר לקרוא ביקורות וחוות דעת על סוכנים וסכונויות נדל"ן, כמו כן ניתן גם לקרוא את פרטיי הנכסים של הסוכן/סוכנות. באתר ניתן גם לחפש נכסים לפי סינונים.</p>
                    <h4>האתר עובד במתכונת הבאה:</h4>
                    <p>על מנת להשאיר חוות דעת על סוכנות/סוכנות - חובה להתחבר לחשבון האישי.<br>על מנת לפתוח פרופיל סוכן - חובה להתחבר לחשבון האישי.<br>על מנת לפתוח פרופיל סוכנות - חובה להתחבר לחשבון האישי.<br>על מנת לפרסם נכסים - חובה לפתוח פרופיל סוכן/סוכנות.</p>
                    <div class="button">
                        <a href="https://github.com/ronsha001/GetAgent-FinalProject.git" target="_blank">קוד האתר</a>
                    </div>
                </div>
                <div class="social">
                    <a href="https://www.instagram.com/ronsharabii/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/ron-sharabi-54267921b/" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="https://github.com/ronsha001" target="_blank"><i class="fab fa-github" ></i></a>
                </div>
            </div>
            <div class="image-section">
                <img src="../images/title_icon.png" alt="logo">
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
                    <a href="about_page.php">על גט אייג'נט</a>
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
                    <a href="<?php echo $agent_link ?>"> <?php echo $agent_profile; ?> </a>
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

</body>
</html>