<?php session_start();
    if(isset($_POST['submit'])){
        if(isset($_SESSION['verify_token'])){
            $token = $_SESSION['verify_token'];
            $email =  $_SESSION['email'];
            $update_user_reviews_name = false;

            include_once('../loginSystem/db.php');
            
            // update first name
            if(trim($_POST['first_name']) != $_SESSION['first_name']){
                $first_name = $_SESSION['first_name'];
                $new_first_name = trim($_POST['first_name']);

                $update_first_name = "UPDATE accounts SET first_name='$new_first_name' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_first_name_run = mysqli_query($con, $update_first_name);
                if($update_first_name_run){
                    $_SESSION['first_name'] = $new_first_name;
                    $update_user_reviews_name = true;
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
                }
            }

            // update last name
            if(trim($_POST['last_name']) != $_SESSION['last_name']){
                $last_name = $_SESSION['last_name'];
                $new_last_name = trim($_POST['last_name']);

                $update_last_name = "UPDATE accounts SET last_name='$new_last_name' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_last_name_run = mysqli_query($con, $update_last_name);
                if($update_last_name_run){
                    $_SESSION['last_name'] = $new_last_name;
                    $update_user_reviews_name = true;
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
                }
            }
            // update user's reviews - set each user's review with user's new name
            if($update_user_reviews_name){
                $userFullName = trim($_POST['first_name'])." ".trim($_POST['last_name']);
                $update_users_reviews = "UPDATE reviews_info_table SET account_name='$userFullName' WHERE from_email='$email'";
                try{
                    mysqli_query($con, $update_users_reviews);
                } catch (Exception $e) {
                    $_SESSION['status'] = "משהו השתבש בעידכון הביקורות";
                }
            }

            // update gender
            if(trim($_POST['gender']) != $_SESSION['gender']){
                $gender = $_SESSION['gender'];
                $new_gender = trim($_POST['gender']);

                $update_gender = "UPDATE accounts SET gender='$new_gender' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_gender_run = mysqli_query($con, $update_gender);
                if($update_gender_run){
                    $_SESSION['gender'] = $new_gender;
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
                }
            }
            $new_token = md5($token);
            $update_token = "UPDATE accounts SET verify_token='$new_token' WHERE email='$email' AND verify_token='$token' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);
            if($_SESSION['is_agent'] == 1) {
                $update_token = "UPDATE agents_info_table SET verify_token='$new_token' WHERE email='$email' AND verify_token='$token'";
                $update_token_run = mysqli_query($con, $update_token);
            }
            $_SESSION['verify_token'] = $new_token;
            mysqli_close($con);
            header("Location: account_page.php");
            exit();

        } else {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }

?>