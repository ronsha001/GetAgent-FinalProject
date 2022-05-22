<?php session_start();
    if(isset($_POST['submit'])){
        if($_SESSION['is_agent'] == 0 and isset($_SESSION['email']) and isset($_SESSION['verify_token']) and !empty($_SESSION['email']) and !empty($_SESSION['verify_token'])){
            $token = $_SESSION['verify_token'];
            $email = $_SESSION['email'];
            $file = $_FILES['my_logo'];
            $agent_cities = trim($_POST['agent_cities']);
            $phone_number = trim($_POST['phone_number']);
            $birth_date = trim($_POST['birth_date']);
            $website_link = trim($_POST['website_link']);
            $office_address = trim($_POST['office_address']);
            $years_of_exp = trim($_POST['years_of_exp']);
            $about_agent = trim($_POST['about_agent']);
            $office_name = trim($_POST['office_name']);
            $license_year = trim($_POST['license_year']);
            $for_sale = 0;
            $for_rent = 0;

            // echo $token.'---';
            // echo $email.'---';
            // print_r($file).'---';
            // echo $agent_cities.'---';
            // echo $phone_number.'---';
            // echo $birth_date.'---';
            // echo $website_link.'---';
            // echo $office_address.'---';
            // echo $years_of_exp.'---';
            // echo $description.'---';
            
            $new_folder_uniqid = "../agentsProfiles/".uniqid('', true).".".$email;
            mkdir("$new_folder_uniqid", 0777, true);
            

            $new_agent_images_folder = $new_folder_uniqid."/images";
            mkdir("$new_agent_images_folder", 0777, true);

            $fileDestination = "../images/title_icon.png";
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
                            $fileDestination = "$new_agent_images_folder/".$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
                        } else {
                            $_SESSION['status'] = "נפח הקובץ גדול מידי";
                            header("Location: ../createProfiles/create_agent_page.php");
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "משהו השתבש בהעלאת הקובץ";
                        header("Location: ../createProfiles/create_agent_page.php");
                        exit();
                    }
                } else {
                    $_SESSION['status'] = "jpg/jpeg/png/gif קובץ חייב להיות מסוג";
                    header("Location: ../createProfiles/create_agent_page.php");
                    exit();
                }
            }

            include_once('../loginSystem/db.php');
            $get_id = "SELECT id FROM accounts WHERE email='$email' AND verify_token='$token' LIMIT 1";
            $get_id_run = mysqli_query($con, $get_id);
            $result = mysqli_fetch_assoc($get_id_run);
            $id = $result['id'];
            //$agent_info_table_name = "agent_info_table_$id";

            // $create_agent_table = "CREATE TABLE `".$agent_info_table_name."` (logo_path VARCHAR(255), agent_cities VARCHAR(255), phone_number VARCHAR(255), birth_date VARCHAR(255), website_link VARCHAR(1500), office_address VARCHAR(255), years_of_exp VARCHAR(255), descrip VARCHAR(255))";
            // $create_agent_table_run = mysqli_query($con, $create_agent_table);
            try{
                $insert_info = "INSERT INTO agents_info_table (`folder_path`, `logo_path`, `agent_cities`, `phone_number`, `birth_date`, `website_link`, `office_address`, `years_of_exp`, `about_agent`, `office_name`, `license_year`, `for_sale`, `for_rent`, `email`, `verify_token`, `id`, `email_likes`) VALUES ('$new_folder_uniqid', '$fileDestination', '$agent_cities', '$phone_number', '$birth_date', '$website_link', '$office_address', '$years_of_exp', '$about_agent', '$office_name', '$license_year', '$for_sale', '$for_rent', '$email', '$token', '$id', ',')";
                $insert_info_run = mysqli_query($con, $insert_info);
    
                $change_to_agent = "UPDATE accounts SET isAgent='1' WHERE verify_token='$token' AND email='$email' AND id='$id' LIMIT 1";
                $change_to_agent_run = mysqli_query($con, $change_to_agent);
                $_SESSION['is_agent'] = '1';
            } catch(Exception $e) {
                array_map('rmdir', glob("$new_folder_uniqid/*"));
                rmdir($new_folder_uniqid);
                
                $_SESSION['status'] = "משהו השתבש, נסה לשנות את שדה התיאור הכללי.";
                header("Location: ../createProfiles/create_agent_page.php");
                exit();
            }
            

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
                    $_SESSION['for_sale'] = $for_sale;
                    $_SESSION['for_rent'] = $for_rent;
                }
            }

            mysqli_close($con);

        } else {
            header("Location: ../index.php");
            exit();
        }
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }
    
?>