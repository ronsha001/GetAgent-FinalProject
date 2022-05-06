<?php session_start();

    if(isset($_SESSION['email']) or isset($_SESSION['verify_token'])) {
        header("Location: ../index.php");
        exit();
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
    
    <title>גט אייג'נט - שכחתי סיסמה</title>

    <style>

        .status_container{
            background-color: #2da44e;
            border-radius: 10px;
            width: 100%;
            height: fit-content;
            text-align: center;
            font-weight: 500;
        }

    </style>
</head>
<body>
    <div class="center">
        <?php 
            if(isset($_SESSION['status'])) {
                echo "
                    <div class='status_container'>
                        <h3>$_SESSION[status]</h3>
                    </div>
                ";
                unset($_SESSION['status']);
            }
        ?>
        
        
        <h1>מייל לאיפוס סיסמה</h1>
        <form action="resetPwLinkSender.php" method="POST">
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>אימייל</label>
            </div>
            <input type="submit" name="submit" value="שלח מייל">
            <div class="signup_link">
                עוד לא רשום? <a href="sign_up_page.php">הירשם</a>
            </div>
            <div class="signup_link">
                המשך במצב אורח <a href="../index.php">המשך</a>
            </div>
        </form>

    </div>
</body>
</html>