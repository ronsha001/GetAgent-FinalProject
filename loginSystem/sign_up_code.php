<?php session_start();
    # creating new account
    include_once 'db.php';
    $table = 'accounts';
    
    if(isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
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
            $token = md5(rand());
            $create_new_account = "INSERT INTO $table (`email`, `password`, `verify_token`, `first_name`, `last_name`, `gender`, `address`, `city`, `picture_path`, `isAgent`, `isAgency`) VALUES ('$email', '$pass', '$token', '$first_name', '$last_name', '$gender', '$address', '$city', '$picture_path', '$is_agent', '$is_agency')";
            $create_new_account_run = mysqli_query($con, $create_new_account);
            if ($create_new_account_run){
                mysqli_close($con);
                header("Location: login_page.php");
                exit();
            } else {
                $_SESSION['status'] = "Something went wrong. #2";
                mysqli_close($con);
                header("Location: sign_up_page.php");
                exit();
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