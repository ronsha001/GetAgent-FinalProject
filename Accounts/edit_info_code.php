<?php session_start();

    if(isset($_POST['submit'])){
        if(isset($_SESSION['verify_token'])){
            $token = $_SESSION['verify_token'];
            $email =  $_SESSION['email'];
            include_once('../loginSystem/db.php');

            // update email
            if (trim($_POST['email']) != $_SESSION['email']){
                $new_email = trim($_POST['email']);

                // check if email already signed
                $check_email = "SELECT email FROM accounts WHERE email='$new_email'";
                $check_email_run = mysqli_query($con, $check_email);
                if(mysqli_num_rows($check_email_run) > 0) {
                    mysqli_close($con);
                    $_SESSION['status'] = 'השתמש באימייל אחר';
                    header("Location: edit_info_page.php");
                    exit();
                } else {
                    $update_email = "UPDATE accounts SET email='$new_email' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                    $update_email_run = mysqli_query($con, $update_email);
                    if($update_email_run){
                        $_SESSION['email'] = $new_email;
                    } else {
                        mysqli_close($con);
                        $_SESSION['status'] = "משהו השתבש";
                        header("Location: account_page.php");
                        exit();
                    }
                }
            }
            
            // update first name
            if(trim($_POST['first_name']) != $_SESSION['first_name']){
                $first_name = $_SESSION['first_name'];
                $new_first_name = trim($_POST['first_name']);

                $update_first_name = "UPDATE accounts SET first_name='$new_first_name' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_first_name_run = mysqli_query($con, $update_first_name);
                if($update_first_name_run){
                    $_SESSION['first_name'] = $new_first_name;
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
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
                }
            }

            // update address
            if(trim($_POST['address']) != $_SESSION['address']){
                $address = $_SESSION['address'];
                $new_address = trim($_POST['address']);

                $update_address = "UPDATE accounts SET address='$new_address' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_address_run = mysqli_query($con, $update_address);
                if($update_address_run){
                    $_SESSION['address'] = $new_address;
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
                }
            }

            // update city
            if(trim($_POST['city']) != $_SESSION['city']){
                $city = $_SESSION['city'];
                $new_city = trim($_POST['city']);

                $update_city = "UPDATE accounts SET city='$new_city' WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $update_city_run = mysqli_query($con, $update_city);
                if($update_city_run){
                    $_SESSION['city'] = $new_city;
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "משהו השתבש";
                    header("Location: account_page.php");
                    exit();
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