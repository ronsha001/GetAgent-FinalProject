<?php session_start();

    $value = '';
    $type = 'hidden';
    if (isset($_SESSION['status']) and !empty($_SESSION['status'])){
        $value = $_SESSION['status'];
        $type = 'text';
    }
    if (isset($_SESSION['email']) and !empty($_SESSION['email'])){
        header("Location: ../index.php");
        exit();
    }

    

    $filename = "../cities.txt";
    $file = fopen( $filename, "r" );
    
    if( $file == false ) {
        echo ( "Error in opening file" );
        exit();
    }
    
    $filesize = filesize( $filename );
    $filetext = fread( $file, $filesize );

    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Get real estate agent / agency">
    <meta name="keywords" content="Get Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link rel="icon" type="png" href="../images/title_icon.png">
    <link rel='stylesheet' type="text/css" href="sign_up_page_style.css">
    
    <title>גט אייג'נט הירשם</title>

</head>
<body>
    <div class="center">
        <div class="error">
            <input type="<?php echo $type ?>" value="<?php echo $value; session_destroy(); ?>" disabled>
        </div>

        <h1>הרשמה</h1>
        
            <form action="sign_up_code.php" method="POST">
                <div class="txt_field">
                    <input type="email" name="email" required>
                    <span></span>
                    <label>אימייל</label>
                </div>
                <div class="txt_field">
                    <input type="text" name="first_name" required>
                    <span></span>
                    <label>שם</label>
                </div>
                <div class="txt_field">
                    <input type="text" name="last_name" required>
                    <span></span>
                    <label>שם משפחה</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" autocomplete="off" required>
                    <span></span>
                    <label>סיסמה</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="verify_password" autocomplete="off" required>
                    <span></span>
                    <label>אימות סיסמה</label>
                </div>
            
            <div class="gender-details">
                <input type="radio" name="gender" id="dot-1" value="זכר" required>
                <input type="radio" name="gender" id="dot-2" value="נקבה" required>
                <input type="radio" name="gender" id="dot-3" value="מעדיף שלא לומר" required>
                <span class="gender-title">מין</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">זכר</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">נקבה</span>
                    </label>
                    <label for="dot-3">
                        <span class="dot three"></span>
                        <span class="gender">מעדיף שלא לומר</span>
                    </label>
                </div>
            </div>

            <input type="submit" name="submit" value="הירשם">
        </form>
        <div class="login_link">
                רשום כבר? <a href="login_page.php">התחבר</a>
        </div>
        
    </div>

</body>
</html>