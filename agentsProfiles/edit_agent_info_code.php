<?php session_start();
    if(isset($_POST['submit'])){
        if($_SESSION['is_agent'] === '1' and isset($_SESSION['email']) and isset($_SESSION['verify_token']) and !empty($_SESSION['email']) and !empty($_SESSION['verify_token'])){
            $token = $_SESSION['verify_token'];
            $email = $_SESSION['email'];
            $folder_path = $_SESSION['folder_path'];
            $old_logo_path = $_SESSION['logo_path'];
            $file = $_FILES['my_logo'];
            $agent_cities = trim($_POST['agent_cities']);
            $phone_number = trim($_POST['phone_number']);
            $birth_date = trim($_POST['birth_date']);
            $website_link = trim($_POST['website_link']);
            $office_address = trim($_POST['office_address']);
            $years_of_exp = trim($_POST['years_of_exp']);
            $about_agent2 = trim($_POST['about_agent']);
            $about_agent = "";
            $right = "";
            for($i = 0, $j = strlen($about_agent2)-1; $i < $j; $i++, $j--){
                if($about_agent2[$i] == '\''){
                    $about_agent = $about_agent . '\'';
                }
                if($about_agent2[$j] == '\''){
                    $right = '\'' . $right;
                }
                $about_agent = $about_agent. $about_agent2[$i];
                $right = $about_agent2[$j] . $right;
            }
            $about_agent = $about_agent . $right;

            $office_name = trim($_POST['office_name']);
            $license_year = trim($_POST['license_year']);

            $images_folder_path ="$folder_path./images";
            $fileDestination = "";
            include_once('../loginSystem/db.php');
            if (!empty($file['name'])){
                $fileName = $_FILES['my_logo']['name'];
                $fileTmpName = $_FILES['my_logo']['tmp_name'];
                $fileSize = $_FILES['my_logo']['size'];
                $fileError = $_FILES['my_logo']['error'];
                $fileType = $_FILES['my_logo']['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png', 'gif');

                if(in_array($fileActualExt, $allowed)){
                    if($fileError === 0){
                        if($fileSize < 2097152){
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = "$images_folder_path./".$fileNameNew;
                            if(file_exists($old_logo_path)){
                                unlink($old_logo_path);
                            }
                            move_uploaded_file($fileTmpName, $fileDestination);
                            $update_agent_logo= "UPDATE agents_info_table SET logo_path='$fileDestination' WHERE verify_token='$token' AND email='$email' LIMIT 1";
                            $update_agent_logo_run = mysqli_query($con, $update_agent_logo);
                            if (!$update_agent_logo_run){
                                mysqli_close($con);
                                $_SESSION['status'] = "משהו השתבש בהעלאת התמונה";
                                header("Location: edit_agent_info_page.php");
                                exit();
                            }
                        } else {
                            mysqli_close($con);
                            $_SESSION['status'] = "נפח הקובץ גדול מידי";
                            header("Location: edit_agent_info_page.php");
                            exit();
                        }
                    } else {
                        mysqli_close($con);
                        $_SESSION['status'] = "משהו השתבש בהעלאת הקובץ";
                        header("Location: edit_agent_info_page.php");
                        exit();
                    }
                } else {
                    mysqli_close($con);
                    $_SESSION['status'] = "jpg/jpeg/png/gif קובץ חייב להיות מסוג";
                    header("Location: edit_agent_info_page.php");
                    exit();
                }
            }

            
            $get_id = "SELECT id FROM accounts WHERE email='$email' AND verify_token='$token' LIMIT 1";
            $get_id_run = mysqli_query($con, $get_id);
            $result = mysqli_fetch_assoc($get_id_run);
            $id = $result['id'];

            try{
                if($about_agent > ""){
                    $update_agent_info = "UPDATE agents_info_table SET agent_cities='$agent_cities', phone_number='$phone_number', birth_date='$birth_date', website_link='$website_link', office_address='$office_address', years_of_exp='$years_of_exp', about_agent='$about_agent', office_name='$office_name', license_year='$license_year' WHERE verify_token='$token' AND email='$email' AND id='$id' LIMIT 1";
                } else {
                $update_agent_info = "UPDATE agents_info_table SET agent_cities='$agent_cities', phone_number='$phone_number', birth_date='$birth_date', website_link='$website_link', office_address='$office_address', years_of_exp='$years_of_exp', office_name='$office_name', license_year='$license_year' WHERE verify_token='$token' AND email='$email' AND id='$id' LIMIT 1";
                }
                $update_agent_info_run = mysqli_query($con, $update_agent_info);
            } catch(Exception $e) {
                mysqli_close($con);
                $_SESSION['status'] = "משהו השתבש בעידכון הפרטים";
                header("Location: edit_agent_info_page.php");
                exit();
            }
            

            $get_info = "SELECT * FROM agents_info_table WHERE email='$email' AND verify_token='$token' LIMIT 1";
            $get_info_run = mysqli_query($con, $get_info);

            $rows2 = mysqli_num_rows($get_info_run);
            $agent_info = mysqli_fetch_array($get_info_run);

            if (mysqli_num_rows($get_info_run) == 1) {
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
            } else {
                mysqli_close($con);
                $_SESSION['status'] = "משהו השתבש בעידכון המשתנים";
                header("Location: edit_agent_info_page.php");
                exit();
            }
            

            mysqli_close($con);
            header("Location: agent_profile_page.php");
            exit();
            
        } else {
            header("Location: ../index.php");
            exit();
        }
    }
    
?>