<?php session_start();
    $agent_footer_link = "../createProfiles/create_agent_page.php";
    $agent_footer_text = "צור פרופיל סוכן";
    
    if(!isset($_SESSION) or empty($_SESSION)){
        header("Location: ../index.php");
        exit();
    }
    if(isset($_SESSION['isAgent']) and $_SESSION['isAgent'] == 1){
        $agent_footer_link = "../agentsProfiles/agent_profile_page.php";
        $agent_footer_text = "פרופיל הסוכן שלי";
    }
    if(!isset($_SESSION['verify_token']) or empty($_SESSION['verify_token'])){
        header("Location: ../index.php");
        exit();
    }
    if(!isset($_GET) or empty($_GET)){
        header("Location: ../index.php");
        exit();
    }
    if(!isset($_GET['type'], $_GET['id']) or empty($_GET['type']) or empty($_GET['id'])){
        header("Location: ../index.php");
        exit();
    }
    
    $type = $_GET['type'];
    $id = $_GET['id'];

    $status_display = 'none';
    $status_value = '';
    if(isset($_SESSION['status']) and !empty($_SESSION['status'])){
        $status_display = 'block';
        $status_value = $_SESSION['status'];
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
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>

    <link rel="icon" type="png" href="../images/title_icon.png">
    <link rel="stylesheet" type="text/css" href="report_page_style.css">
    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <title>גט אייג'נט - דיווח</title>

    <style>
        body{
            margin: 0;
            padding: 0;
            direction: rtl;
        }
        .status{
            font-size: 15px;
            font-weight: bold;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            width: fit-content;
            height: fit-content;
        }
        .status_container{
            display: <?php echo $status_display; ?>;
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
            <li><a href='../loginSystem/logout.php' >התנתק</a></li>
        </ul>
        <div class="burger">
            <div class="lin1"></div>
            <div class="lin2"></div>
            <div class="lin3"></div>
        </div>        
    </nav>
    <script src="../Nav.js" type="text/javascript"></script>

    <!-- REPORT SECTION -->
    <div class="container">
        <form action="send_report_code.php" method="POST">
            <div class="leave_review_container">
                <div class="status_container">
                    <span class="status"><?php echo $status_value; unset($_SESSION['status']);?></span>
                </div>
                <h2>דיווח</h2>
                <div class="new_review_details">
                    <label for="subject">נושא:(25 תווים)</label>
                    <input type="text" class="subject" maxlength="25" name="subject" id="subject" required>
                    <br>
                    <label for="body">תיאור:(260 תווים)</label>
                    <textarea name="body" maxlength="260" class="body" id="body" required></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="submit" name="new_review_submit" class="new_review_submit" value="שלח דיווח" >
            </div>
        </form>

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
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-facebook-square"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" tarPOST="_blank"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
        </section>
    </div>

</body>
</html>