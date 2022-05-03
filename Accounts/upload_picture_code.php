<?php session_start();

    if(isset($_POST['submit']) and isset($_SESSION['verify_token'])){
        $token = $_SESSION['verify_token'];
        $email = $_SESSION['email'];

        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = '../images/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    
                    include_once('../loginSystem/db.php');
                    $setProfilePicture = "UPDATE accounts SET picture_path='$fileDestination' WHERE verify_token='$token' AND email='$email' LIMIT 1";
                    $setProfilePicture_run = mysqli_query($con, $setProfilePicture);

                    if ($setProfilePicture_run) {
                        mysqli_close($con);
                        $male_default_picture = "../images/default_profile_picture_male.png";
                        $female_default_picture = "../images/default_profile_picture_female.png";
                        $none_gender_default_picture = "../images/default_profile_picture_none.png";
                        if ($_SESSION['picture_path'] != $male_default_picture and $_SESSION['picture_path'] != $female_default_picture and $_SESSION['picture_path'] != $none_gender_default_picture){
                            $file_pointer = $_SESSION['picture_path'];
                            if (file_exists($file_pointer)){
                                unlink($file_pointer);
                            }
                        }
                        
                        $_SESSION['picture_path'] = $fileDestination;
                        // $_SESSION['picture_status'] = "Profile picture updated.";
                        // $_SESSION['picture_error_color'] = "#1aaa1a";
                        header("Location: account_page.php");
                        exit();
                    } else {
                        mysqli_close($con);
                        header("Location: account_page.php");
                        exit();
                    }
                    
                } else {
                    header("Location: account_page.php");
                    exit();
                }
            } else {
                header("Location: account_page.php");
                exit();
            }
        } else {
            header("Location: account_page.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }

    // function setError($err){
    //     $_SESSION['picture_status'] = $err;
    //     $_SESSION['picture_error_color'] = "#ff2525";
    // }

    // // Check if image file is a actual image or fake image
    // if(isset($_POST["submit"])) {
    //     $file = $_FILES['file'];
        
    //     $fileName = $_FILES['file']['name'];
    //     $fileTmpName = $_FILES['file']['tmp_name'];
    //     $fileSize = $_FILES['file']['size'];
    //     $fileError = $_FILES['file']['error'];
    //     $fileType = $_FILES['file']['type'];

    //     $fileExt = explode('.', $fileName);
    //     $fileActualExt = strtolower(end($fileExt));

    //     $allowed = array('jpg', 'jpeg', 'png', 'gif');

    //     if(in_array($fileActualExt, $allowed)){
    //         if ($fileError === 0) {
    //             if ($fileSize < 1000000) {
    //                 $fileNameNew = uniqid('', true).".".$fileActualExt;
    //                 $fileDestination = 'images/'.$fileNameNew;
    //                 move_uploaded_file($fileTmpName, $fileDestination);

    //                 include_once('../db.php');
    //                 $setProfilePicture = "UPDATE users SET picture_path='$fileDestination' WHERE verify_token='$token' AND username='$username' LIMIT 1";
    //                 $setProfilePicture_run = mysqli_query($connection, $setProfilePicture);

    //                 if ($setProfilePicture_run) {
    //                     mysqli_close($connection);
    //                     $_SESSION['picture'] = $fileDestination;
    //                     $_SESSION['picture_status'] = "Profile picture updated.";
    //                     $_SESSION['picture_error_color'] = "#1aaa1a";
    //                     header("Location: AccountSettings.php");
    //                     exit();
    //                 }
    //                 mysqli_close($connection);
                    
    //             } else {
    //                 setError("Your file is too big.");
    //                 header("Location: AccountSettings.php");
    //                 exit();
    //             }
    //         } else {
    //             setError("There was an error.");
    //             header("Location: AccountSettings.php");
    //             exit();
    //         }
    //     } else {
    //         setError("You cannot upload files of this type.");
    //         header("Location: AccountSettings.php");
    //         exit();
    //     }
    // }
?>