<?php session_start();
    if(!isset($_SESSION['verify_token']) or empty($_SESSION['verify_token'])){
        header("Location: ../index.php");
        exit();
    } elseif (!isset($_SESSION['is_agent']) or $_SESSION['is_agent'] != 1){
        header("Location: ../index.php");
        exit();
    } elseif (!isset($_POST) or empty($_POST)) {
        header("Location: agent_profile_page.php");
        exit();
    } elseif (!isset($_POST['submit'])){
        header("Location: agent_profile_page.php");
        exit();
    }

    $agent_email = $_SESSION['email'];
    $asset_id = $_POST['id'];

    // Delete all the files that selected for deletion or the files that have been changed
    include_once("../loginSystem/db.php");
    for ($i = 1, $j = 8; $i < $j; $i++, $j--){

        if (str_contains($_POST['img'.$i], '*deleteMe*')){
            $fileToDelete = substr( $_POST['img'.$i], 0, strlen($_POST['img'.$i]) - 10 );

            if( file_exists( $fileToDelete ) ){
                // update sql server
                $column = "file".($i)."_path";
                $update_asset = "UPDATE assets_info_table SET $column='' WHERE email='$agent_email' AND id='$asset_id' LIMIT 1";
                try{
                    $update_asset_run = mysqli_query($con, $update_asset);
                } catch (Exception $e){
                    echo $e;
                }
                // update web server
                unlink($fileToDelete);
            }
        }
        if (str_contains($_POST['img'.$j], '*deleteMe*')){
            $fileToDelete = substr( $_POST['img'.$j], 0, strlen($_POST['img'.$j]) - 10 );

            if( file_exists( $fileToDelete ) ){
                // update sql server
                $column = "file".($j)."_path";
                $update_asset = "UPDATE assets_info_table SET $column='' WHERE email='$agent_email' AND id='$asset_id' LIMIT 1";
                try{
                    $update_asset_run = mysqli_query($con, $update_asset);
                } catch (Exception $e){
                    echo $e;
                }
                // update web server
                unlink($fileToDelete);
            }
        }

    }

    
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


    $asset_dir_path = $_POST['asset_directory_path'];

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
                        $fileDestination[$i] = "$asset_dir_path./".$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination[$i]);
                    }
                }
            }
        }
    }
    try{
        $update_asset = "UPDATE assets_info_table
                        SET sale_or_rent='$sale_or_rent', asset_type='$asset_type',
                        asset_condition='$asset_condition', city='$city', street='$street', house_number='$house_number',
                        max_floor='$max_floor', num_of_rooms='$num_of_rooms', balcony='$balcony',
                        size_in_sm='$size_in_sm', parking_station='$parking_station',
                        entrance_date='$entrance_date', price='$price', tax='$tax', currency='$currency',
                        asset_description='$asset_description', check_boxes='$check_boxes'
                        WHERE email='$agent_email' AND id='$asset_id' LIMIT 1";
        try{
            // update db server
            $update_asset_run = mysqli_query($con, $update_asset);
        } catch (Exception $e){
            echo $e;
        }
        // UPDATE ASSET PICTURES
        for($i = 0; $i < 8; $i++){
            if($fileDestination[$i]){
                try{
                    $column = "file".($i+1)."_path";
                    $update_asset = "UPDATE assets_info_table SET $column='$fileDestination[$i]' WHERE email='$agent_email' AND id='$asset_id' LIMIT 1";
                    // update db server
                    mysqli_query($con, $update_asset);
                } catch (Exception $e) {
                    echo $e;
                }
            }
        }
    } catch (Exception $e){
        echo $e;
    } finally {
        mysqli_close($con);
        // clearing cache memory
        clearstatcache();
        header("Location: agent_profile_page.php");
        exit();
    }
?>