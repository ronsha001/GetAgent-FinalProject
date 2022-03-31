<?php session_start();
    if (isset($_SESSION['email']) and !empty($_SESSION['email'])){
        header("Location: ../index.php");
        exit();
    }
    $value = '';
    $type = 'hidden';
    $color = '#fff';
    if (isset($_SESSION['status']) and !empty($_SESSION['status'])){
        $color = $_SESSION['color'];
        $value = $_SESSION['status'];
        $type = 'text';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Get real estate agent / agency">
    <meta name="keywords" content="Get Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <link rel="icon" type="png" href="../images/title_icon.png">
    <link rel='stylesheet' type="text/css" href="login_page_style.css">
    
    <title>גט אייג'נט התחברות</title>

    <style>
        .error input {
            background: <?php echo $color; ?>;
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="error">
            <input type="<?php echo $type ?>" value="<?php echo $value; session_destroy(); ?>" disabled>
        </div>
        
        <h1>התחברות</h1>
        <form action="login.php" method="POST">
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>אימייל</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>סיסמה</label>
            </div>
            <div class="signup_link"><a href="forgotPass.php">שכחתה את הסיסמה?</a></div>
            <input type="submit" name="submit" value="התחבר">
            <div class="signup_link">
                עוד לא רשום? <a href="sign_up_page.php">הירשם</a>
            </div>
            <div class="signup_link">
                המשך במצב אורח <a href="../index.php">המשך</a>
            </div>
        </form>

    </div>

    <!-- Google Translator -->
    <!-- <div id="google_element"></div>
    <script src="http://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
    <script>
        function loadGoogleTranslate(){
            new google.translate.TranslateElement("google_element");
        }
    </script> -->
</body>
</html>