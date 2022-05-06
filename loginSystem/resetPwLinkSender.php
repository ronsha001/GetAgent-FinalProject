<?php session_start();
    use PHPMailer\PHPMailer\PHPMailer;

    if(isset($_SESSION['email']) or isset($_SESSION['verify_token'])) {
        header("Location: ../index.php");
        exit();
    }

    function sendMail($email, $token, $first_name, $last_name, $pw) {
        $fullName = $first_name.' '.$last_name;

        $body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewpoint' content='width=device-width, initial-scale=1.0'>
                <title>גט אייג'נט - איפוס סיסמה</title>
            
                <style>
                    body{
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        direction: rtl;
                    }
                    .link_container{
                        text-align: center;
                        background-color: #2691d9;
                        border-radius: 10px;
                        padding: 10px;
                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                    }
                    
                </style>
            </head>
            <body>
                <div class='link_container'>
                    <h1>שלום $fullName</h1>
                    <h2>לינק לאיפוס סיסמה:</h2>
                    <a href='http://localhost/www/Self%20Projects/GetAgent/loginSystem/resetPwPage.php?token=$token' target='_blank'>איפוס סיסמה</a>
                </div>
            </body>
            </html>
        ";

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";

        $mail = new PHPMailer();

        //smtp settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "getagent0111@gmail.com";
        $mail->Password = "$pw";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";

        //email settings
        $mail->isHTML(true);
        $mail->setFrom("getagent0111@gmail.com", "GetAgent");
        $mail->addAddress($email);
        $mail->Subject = "GetAgent - Reset Password";
        $mail->Body = $body;

        if($mail->send()){
            return true;
        } else {
            echo $mail->ErrorInfo;
            return false;
        }
    }

    try{
        if(isset($_POST) and !empty($_POST) and isset($_POST['email']) and !empty($_POST['email'])){
            if(isset($_POST['submit'])) {
                $email = $_POST['email'];

                include_once('db.php');
                
                // check if email exists in db (accounts table)
                $isAccount = "SELECT email, verify_token, first_name, last_name
                            FROM accounts
                            WHERE email='$email'";
                $isAccount_run = mysqli_query($con, $isAccount);
                $account_details = mysqli_fetch_array($isAccount_run);

                if(mysqli_num_rows($isAccount_run)) {
                    $token = $account_details['verify_token'];
                    $first_name = $account_details['first_name'];
                    $last_name = $account_details['last_name'];

                    $mailSent = sendMail($email, $token, $first_name, $last_name, $pw);
                    
                    if($mailSent) {
                        $_SESSION['status'] = "מייל עם לינק לאיפוס סיסמה נשלח אליך.";
                    } else {
                        $_SESSION['status'] = "משהו השתבש #1";
                    }
                } else {
                    $_SESSION['status'] = "מייל לא רשום.";
                }

                mysqli_close($con);
            }
        }
    } catch (Exception $e) {
        $e->getMessage();
    } finally {
        header("Location: forgotPassPage.php");
        exit();
    }

?>