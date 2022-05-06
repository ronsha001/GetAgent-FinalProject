<?php session_start();

    if(!(isset($_SESSION['verify_token'])) && !(isset($_SESSION['email']))){
        header("Location: ../index.php");
    } else if (!(isset($_POST['submit']))){
        header("Location: agent_profile_page.php");
    }

    $email = $_SESSION['email'];
    $verify_token = $_SESSION['verify_token'];
    $agent_phone = $_SESSION['phone_number'];
    $office_name = $_SESSION['office_name'];
    $folder_path = $_SESSION['folder_path'];
    $sale_or_rent = trim($_POST['sale_or_rent']);
    $asset_type = trim($_POST['asset_type']);
    $asset_condition = trim($_POST['asset_condition']);
    $city = trim($_POST['city']);
    $street = trim($_POST['street']);
    $house_number = trim($_POST['house_number']);
    $floor = trim($_POST['floor']);
    $max_floor = trim($_POST['max_floor']);
    $num_of_rooms = trim($_POST['num_of_rooms']);
    $balcony = trim($_POST['balcony']);
    $size_in_sm = trim($_POST['size_in_sm']);
    $parking_station = trim($_POST['parking_station']);
    $entrance_date = trim($_POST['entrance_date']);
    $price = trim($_POST['price']);
    $tax = trim($_POST['tax']);
    $currency = trim($_POST['currency']);
    $asset_description = $_POST['asset_description'];
    $file = array($_FILES['file1'], $_FILES['file2'], $_FILES['file3'], $_FILES['file4'], $_FILES['file5'], $_FILES['file6'], $_FILES['file7'], $_FILES['file8']);

    $check_boxes = "";
    if (isset($_POST['air_condition'])){
        $check_boxes = ',מיזוג';
    }
    if (isset($_POST['bars'])){
        $check_boxes = $check_boxes . ',סורגים';
    }
    if (isset($_POST['elevator'])){
        $check_boxes = $check_boxes . ',מעלית';
    }
    if (isset($_POST['cosher_kitchen'])){
        $check_boxes = $check_boxes . ',מטבח כשר';
    }
    if (isset($_POST['access_for_disabled'])){
        $check_boxes = $check_boxes . ',גישה לנכים';
    }
    if (isset($_POST['protected_space'])){
        $check_boxes = $check_boxes . ',ממ"ד';
    }
    if (isset($_POST['renovated'])){
        $check_boxes = $check_boxes . ',משופצת';
    }
    if (isset($_POST['storage'])){
        $check_boxes = $check_boxes . ',מחסן';
    }
    if (isset($_POST['tadiran_ac'])){
        $check_boxes = $check_boxes . ',מזגן תדיראן';
    }
    if (isset($_POST['furniture'])){
        $check_boxes = $check_boxes . ',ריהוט';
    }

    $new_folder_uniqid = $folder_path."/".uniqid('', true);
    mkdir("$new_folder_uniqid", 0777, true);

    $fileDestination = array("","","","","","","","");
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    for($i = 0; $i < 8; $i++){
        if(!empty($file[$i]['name'])){
            $fileName = $file[$i]['name'];
            $fileTmpName = $file[$i]['tmp_name'];
            $fileSize = $file[$i]['size'];
            $fileError = $file[$i]['error'];
            $fileType = $file[$i]['type'];
            
            
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));


            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0){
                    if($fileSize < 2097152){
                        $fileNameNew = uniqid('', true).".".$fileActualExt;
                        $fileDestination[$i] = "$new_folder_uniqid/".$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination[$i]);

                    } else {
                        array_map('rmdir', glob("$new_folder_uniqid/*"));
                        rmdir($new_folder_uniqid);

                        $_SESSION['status'] = "נפח הקובץ גדול מידי";
                        header("Location: upload_new_asset_page.php");
                        exit();

                    }
                } else {
                    array_map('rmdir', glob("$new_folder_uniqid/*"));
                    rmdir($new_folder_uniqid);

                    $_SESSION['status'] = "משהו השתבש בהעלאת הקובץ";
                    header("Location: upload_new_asset_page.php");
                    exit();

                }
                
            } else {
                array_map('rmdir', glob("$new_folder_uniqid/*"));
                rmdir($new_folder_uniqid);

                $_SESSION['status'] = "jpg/jpeg/png/gif קובץ חייב להיות מסוג";
                header("Location: upload_new_asset_page.php");
                exit();

            }
        }
        
    }

    try{
        include_once("../loginSystem/db.php");
        $insert_new_asset = "INSERT INTO assets_info_table 
        (`email`, `office_name`, `agent_phone`, `agent_directory_path`, `asset_directory_path`,
        `sale_or_rent`, `asset_type`, `asset_condition`, `city`, `house_number`, `street`,
        `floor`, `max_floor`, `num_of_rooms`, `balcony`, `size_in_sm`, `parking_station`,
        `entrance_date`, `check_boxes`, `price`, `tax`, `currency`, `asset_description`, `file1_path`, `file2_path`,
        `file3_path`, `file4_path`, `file5_path`, `file6_path`, `file7_path`, `file8_path`, `email_likes`)
        VALUES ('$email', '$office_name', '$agent_phone', '$folder_path', '$new_folder_uniqid',
        '$sale_or_rent', '$asset_type', '$asset_condition', '$city', '$house_number', '$street',
        '$floor', '$max_floor', '$num_of_rooms', '$balcony', '$size_in_sm', '$parking_station',
        '$entrance_date', '$check_boxes', '$price', '$tax', '$currency', '$asset_description', '$fileDestination[0]', '$fileDestination[1]',
        '$fileDestination[2]', '$fileDestination[3]', '$fileDestination[4]', '$fileDestination[5]', '$fileDestination[6]', '$fileDestination[7]', ',')";
        
        $insert_new_asset_run = mysqli_query($con, $insert_new_asset);     
        
        $for_sale = $_SESSION['for_sale'];
        $for_rent = $_SESSION['for_rent'];
        if($sale_or_rent == 'sale'){
            $for_sale += 1;
            $update_for_sale = "UPDATE agents_info_table SET for_sale='$for_sale' WHERE verify_token='$verify_token' AND email='$email' LIMIT 1";
            mysqli_query($con, $update_for_sale);
            $_SESSION['for_sale'] = $for_sale;

        } elseif ($sale_or_rent == 'rent'){
            $for_rent += 1;
            $update_for_rent = "UPDATE agents_info_table SET for_rent='$for_rent' WHERE verify_token='$verify_token' AND email='$email' LIMIT 1";
            mysqli_query($con, $update_for_rent);
            $_SESSION['for_rent'] = $for_rent;

        }
    } catch(Exception $e){
        array_map('unlink', glob("$new_folder_uniqid/*"));
        rmdir($new_folder_uniqid);
        echo $e;

    } finally {
        mysqli_close($con);
        header("Location: agent_profile_page.php");
        exit();

    }
    
?>