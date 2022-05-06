<?php session_start();

    function deleteDirectory($dir) {
        if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") {
                    deleteDirectory($dir."/".$object); 
                } else {
                    unlink($dir."/".$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
        }
    }

    try{
        if(isset($_SESSION) and !empty($_SESSION)){
            if(isset($_SESSION['email']) and !empty($_SESSION['email']) and isset($_SESSION['verify_token']) and !empty($_SESSION['verify_token'])) {
                if(isset($_POST) and isset($_POST['submit']) and isset($_POST['password']) and !empty($_POST['password'])) {
                    $token = $_SESSION['verify_token'];
                    $email = $_SESSION['email'];
                    $isAgent = $_SESSION['is_agent'];
                    $pswd = $_POST['password'];

                    include_once('../loginSystem/db.php');

                    // get account
                    $get_account = "SELECT password as pass
                                    FROM accounts
                                    WHERE verify_token='$token' AND email='$email'";
                    $get_account_run = mysqli_query($con, $get_account);
                    // check password match
                    $accountArr = mysqli_fetch_array($get_account_run);
                    
                    if($accountArr['pass'] == $pswd) {

                        // delete account from accounts table
                        $delete_account = "DELETE FROM accounts
                        WHERE verify_token='$token' AND email='$email'
                        LIMIT 1";
                        $delete_account_run = mysqli_query($con, $delete_account);

                        // delete account's likes from assets table
                        $remove_account_asset_likes = "UPDATE assets_info_table
                                                        SET email_likes=REPLACE(email_likes, '$email,', '')
                                                        WHERE email_likes LIKE '%$email,%'";
                        $remove_account_asset_likes_run = mysqli_query($con, $remove_account_asset_likes);

                        // delete account's likes from agents table
                        $remove_account_agent_likes = "UPDATE agents_info_table
                                                        SET email_likes=REPLACE(email_likes, '$email,', '')
                                                        WHERE email_likes LIKE '%$email,%'";
                        $remove_account_agent_likes_run = mysqli_query($con, $remove_account_agent_likes);


                        // delete account's profile picture if exists
                        if ($_SESSION['picture_path'] != $male_default_picture and $_SESSION['picture_path'] != $female_default_picture and $_SESSION['picture_path'] != $none_gender_default_picture){
                            $file_pointer = $_SESSION['picture_path'];
                            if (file_exists($file_pointer)){
                                unlink($file_pointer);
                            }
                        }

                        // delete account's reviews from reviews table
                        $delete_reviews = "DELETE FROM reviews_info_table
                                            WHERE from_email='$email' OR to_email='$email'";
                        $delete_reviews_run = mysqli_query($con, $delete_reviews);

                        // if account has a profile delete all his shows from db and storage
                        if($isAgent) {
                            // delete agent from agents table
                            $delete_agent = "DELETE FROM agents_info_table
                                            WHERE verify_token='$token' AND email='$email'
                                            LIMIT 1";
                            $delete_agent_run = mysqli_query($con, $delete_agent);
                            
                            // delete agent's files (assets directories and pictures)
                            deleteDirectory($_SESSION['folder_path']);
                            
                            // delete all agent's assets from assets table
                            $delete_assets = "DELETE FROM assets_info_table
                                                WHERE email='$email'";
                            $delete_assets_run = mysqli_query($con, $delete_assets);

                        }
                    }
                    
                    

                    mysqli_close($con);
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        header("Location: ../loginSystem/logout.php");
        exit();
    }

?>