<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Get real estate agent / agency">
    <meta name="keywords" content="Get Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="icon" type="png" href="../images/title_icon.png">

    <title>גט אייג'נט אימות חשבון</title>

    <style>
        body{
            margin: 0;
            padding: 0;
            /* font-family: montserrat; */
            background: url("../images/login_page_background.jpg");
            overflow: hidden;
        }
        #wrapper{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #container{
            width: 400px;
            height: 400px;
            display: flex;
            flex-direction: column;
            text-align: center;
            justify-content: center;
            align-items: center;
            background-color: rgba(38, 145, 217, 0.8);
            border: 1px solid black;
            border-radius: 10px;
        }
        #container h1{
            color: #dddddd;
            font-family: sans-serif;
        }
        #container i{
            font-size: 80px;
            color: #1ae38f;
        }
        #container a{
            font-size: 25px;
            padding: 20px;
            margin: 10px;
            border-radius: 18px;
            background: #dddddd;
            text-decoration: none;
            color: #242424;
            font-family: sans-serif;
            font-weight: 700;
            transition: .3s ease-out;
            box-shadow: 0 0 8px 0;
        }
        #container a:hover{
            background-color: #1ae38f;
        }
    </style>
</head>
<body>
    <?php
        if(!isset($_GET['email'])){
            echo "
                        <div id='wrapper'>
                            <div id='container'>
                                <h1>משהו השתבש, ניתן לבקש לשלוח מייל אימות חדש</h1>
                                <i class='fa-solid fa-circle-xmark' style='color: #ff3336;'></i>
                                <a href='http://localhost/www/Self%20Projects/GetAgent/loginSystem/login_page.php'>המשך אל גט אייג'נט</a>
                            </div>
                        </div>
                    ";
            exit();
        } else {
            $email_token = $_GET['email'];
        }
        include_once('db.php');

        $find_email = "SELECT * FROM accounts WHERE verify_token='$email_token' LIMIT 1";
        $find_email_run = mysqli_query($con, $find_email);
        $account_details = mysqli_fetch_array($find_email_run);
        
        if($account_details){
            $token = md5(rand());

            $verify_account = "UPDATE accounts SET verify_token='$token' WHERE verify_token='$email_token' LIMIT 1";
            $verify_account_run = mysqli_query($con, $verify_account);
            mysqli_close($con);

            if($verify_account){
                echo "
                    <div id='wrapper'>
                        <div id='container'>
                            <h1>.חשבונך אומת בהצלחה</h1>
                            <i class='fa-solid fa-circle-check'></i>
                            <a href='http://localhost/www/Self%20Projects/GetAgent/loginSystem/login_page.php'>המשך אל גט אייג'נט</a>
                        </div>
                    </div>
                ";
            } else {
                echo "משהו השתבש";
            }
        } else {
            mysqli_close($con);
            echo "
                    <div id='wrapper'>
                        <div id='container'>
                            <h1>.חשבונך אומת כבר</h1>
                            <i class='fa-solid fa-circle-check'></i>
                            <a href='http://localhost/www/Self%20Projects/GetAgent/loginSystem/login_page.php'>המשך אל גט אייג'נט</a>
                        </div>
                    </div>
                ";
        }
    ?>
</body>
</html>
