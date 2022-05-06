<?php session_start();
    $token = '';
    if (isset($_GET['token']) and !empty($_GET['token'])){
        $token = $_GET['token'];
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

    <title>גט אייג'נט - איפוס סיסמה</title>

    <style>

        .status_container{
            background-color: #2da44e;
            border-radius: 10px;
            width: 100%;
            height: fit-content;
            text-align: center;
            font-weight: 500;
        }
        .center input[type='submit'] {
            margin-bottom: 10px;
        }
        .center label{
            width: fit-content;
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
        <form action="resetPwCode.php" method="POST">
            <div class="txt_field">
                <input type="password" name="pw" required>
                <span></span>
                <label>סיסמה חדשה</label>
            </div>
            <div class="txt_field">
                <input type="password" name="vpw" required>
                <span></span>
                <label>אימות סיסמה חדשה</label>
            </div>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <input type="submit" name="submit" value="איפוס">
            
        </form>

    </div>
</body>
</html>