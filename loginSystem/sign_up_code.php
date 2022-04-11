<?php session_start();
    use PHPMailer\PHPMailer\PHPMailer;

    function sendVerifyMail($email, $email_token, $first_name, $pw) {
        
        $body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Document</title>
                <style>
                    #verify_container1{
                        width:450px;
                        height:fit-content;
                        border-radius: 10px;
                        border: 1px solid silver;
                        text-align:center;
                        align-items:center;
                    }
                    #myVerifyLink{
                        padding:20px;
                        margin: 10px;
                        font-size:20px;
                        color:#e9f4fb;
                        cursor:pointer;
                        background-color:#2691d9;
                        border-radius:10px;
                        font-family:sans-serif;
                        text-decoration: none; 
                    }
                </style>
            </head>
            <body>
                <div id='verify_container1'>
                <h1>שלום, $first_name</h1>
                <h2>אימות חשבון:</h2>
                <a id='myVerifyLink' href='http://localhost/www/Self%20Projects/GetAgent/loginSystem/account_verification.php?email=$email_token' target='_blank'>אימות חשבון</a>
                <br><br>
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
        $mail->Subject = ("GetAgent Account Verification");
        $mail->Body = $body;
            
        
        if($mail->send()){
            return true;
        } else {
            // echo $email;
            echo $mail->ErrorInfo;
            return false;
        }

    }

    # creating new account
    
    if(isset($_POST['submit'])) {
        include_once 'db.php';
        $table = 'accounts';
        
        $email = trim($_POST['email']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $pass = trim($_POST['password']);
        $verify_pass = trim($_POST['verify_password']);
        $gender = trim($_POST['gender']);
        if ($gender == "זכר"){
            $picture_path = "../images/default_profile_picture_male.png";
        } else if($gender == "נקבה") {
            $picture_path = "../images/default_profile_picture_female.png";
        } else {
            $picture_path = "../images/default_profile_picture_none.png";
        }
        $is_agent = 0;
        $is_agency = 0; 
        # Check if this username is already taken or if this email already has an account.
        $email_taken = "SELECT * FROM $table WHERE email='$email'";
        $email_taken_run = mysqli_query($con, $email_taken);

        if (mysqli_num_rows($email_taken_run) > 0) {
            $_SESSION['status'] = "האימייל כבר רשום לאתר, השתמש באימייל אחר";
            mysqli_close($con);
            header("Location: sign_up_page.php");
            exit();
        }
        if ($pass == $verify_pass){
            $email_token = md5(md5(sha1($email)));
            $mailSent = sendVerifyMail($email, $email_token, $first_name, $pw);

            if($mailSent){
                $create_new_account = "INSERT INTO $table (`email`, `password`, `verify_token`, `first_name`, `last_name`, `gender`, `picture_path`, `isAgent`, `isAgency`) VALUES ('$email', '$pass', '$email_token', '$first_name', '$last_name', '$gender', '$picture_path', '$is_agent', '$is_agency')";
                $create_new_account_run = mysqli_query($con, $create_new_account);
                mysqli_close($con);

                $_SESSION['color'] = '#1aaa1a';
                $_SESSION['status'] = 'הרשמה בוצעה בהצלחה. אמת את חשבונך במייל שנשלח אליך.';
                header("Location: login_page.php");
                exit();

            } else {
                $_SESSION['status'] = "אימייל אינו תקין.";
                // header("Location: sign_up_page.php");
                // exit();

            }
            
        } else {
            $_SESSION['status'] = "סיסמה ואימות סיסמה אינם תואמים";
            mysqli_close($con);
            header("Location: sign_up_page.php");
            exit();
        }
        
    } else {
        $_SESSION['status'] = "משהו השתבש";
        mysqli_close($con);
        header("Location: sign_up_page.php");
        exit();
    }

?>