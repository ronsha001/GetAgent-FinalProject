<?php session_start();
    if(!isset($_POST['email']) or empty($_POST['email']) || !isset($_POST['password']) or empty($_POST['password'])){
        $_SESSION['status'] = "Wrong email or password";
        header("Location: login_page.php");
        exit();
    }
    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        include_once("db.php");
    
        $is_account = "SELECT * FROM accounts WHERE email='$email' AND password='$pass' LIMIT 1";
        $is_account_run = mysqli_query($con, $is_account);
        
        $rows = mysqli_num_rows($is_account_run);
        $account_details = mysqli_fetch_array($is_account_run);
        
        if ($rows === 1) {
            if( md5( md5( sha1($account_details['email']) ) ) == $account_details['verify_token'] or empty($account_details['verify_token'])){
                $_SESSION['color'] = '#ff2525';
                $_SESSION['status'] = "בבקשה אמת את חשבונך באמצעות המייל שנשלח אליך.";
                header("Location: login_page.php");
                exit();
            }
            $_SESSION['email'] = $account_details['email'];
            $_SESSION['time'] = $account_details['time'];
            $_SESSION['verify_token'] = $account_details['verify_token'];
            $_SESSION['first_name'] = $account_details['first_name'];
            $_SESSION['last_name'] = $account_details['last_name'];
            $_SESSION['gender'] = $account_details['gender'];
            if ($account_details['picture_path'] == null) {
                if ($account_details['gender'] == "Male"){
                    $_SESSION['picture_path'] = "../images/default_profile_picture_male.png";
                } else if($account_details['gender'] == "Female") {
                    $_SESSION['picture_path'] = "../images/default_profile_picture_female.png";
                } else {
                    $_SESSION['picture_path'] = "../images/default_profile_picture_none.png";
                }
            } else {
                $_SESSION['picture_path'] = $account_details['picture_path'];
            }
            $_SESSION['is_agent'] = $account_details['isAgent'];
            
            if($_SESSION['is_agent'] == 1){
                $token = $_SESSION['verify_token'];
                $get_info = "SELECT * FROM agents_info_table WHERE email='$email' AND verify_token='$token' LIMIT 1";
                $get_info_run = mysqli_query($con, $get_info);

                $rows2 = mysqli_num_rows($get_info_run);
                $agent_info = mysqli_fetch_array($get_info_run);

                if (mysqli_num_rows($get_info_run) == 1) {
                    $_SESSION['folder_path'] = $agent_info['folder_path'];
                    $_SESSION['logo_path'] = $agent_info['logo_path'];
                    $_SESSION['agent_cities'] = $agent_info['agent_cities'];
                    $_SESSION['phone_number'] = $agent_info['phone_number'];
                    $_SESSION['birth_date'] = $agent_info['birth_date'];
                    $_SESSION['website_link'] = $agent_info['website_link'];
                    $_SESSION['office_address'] = $agent_info['office_address'];
                    $_SESSION['years_of_exp'] = $agent_info['years_of_exp'];
                    $_SESSION['about_agent'] = $agent_info['about_agent'];
                    $_SESSION['office_name'] = $agent_info['office_name'];
                    $_SESSION['license_year'] = $agent_info['license_year'];
                    $_SESSION['for_sale'] = $agent_info['for_sale'];
                    $_SESSION['for_rent'] = $agent_info['for_rent'];
                }
            }
            
            mysqli_close($con);
            header("Location: ../index.php");
            exit();
        }
    }
    $_SESSION['color'] = '#ff2525';
    $_SESSION['status'] = "אימייל או סיסמה שגויים";
    header("Location: login_page.php");
    exit();
?>