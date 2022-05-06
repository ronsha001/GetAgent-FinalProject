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
            if(isset($_SESSION['email']) and !empty($_SESSION['email']) and isset($_SESSION['verify_token']) and !empty($_SESSION['verify_token'])) { // asset_directory
                if(isset($_POST) and isset($_POST['submit']) and isset($_POST['password']) and !empty($_POST['password']) and isset($_POST['id']) and !empty($_POST['id']) and isset($_POST['asset_directory']) and !empty($_POST['asset_directory'])) {
                    $token = $_SESSION['verify_token'];
                    $email = $_SESSION['email'];
                    $isAgent = $_SESSION['is_agent'];
                    $pswd = $_POST['password'];
                    $id = $_POST['id'];
                    $asset_directory = $_POST['asset_directory'];

                    include_once('../loginSystem/db.php');

                    // get account
                    $get_account = "SELECT password as pass
                                    FROM accounts
                                    WHERE verify_token='$token' AND email='$email'
                                    LIMIT 1";
                    $get_account_run = mysqli_query($con, $get_account);
                    // check password match
                    $accountArr = mysqli_fetch_array($get_account_run);
                    
                    if($accountArr['pass'] == $pswd) {

                        // if account has a profile
                        if($isAgent and $id and $asset_directory) {
                            
                            // delete all agent's assets from assets table
                            $delete_asset = "DELETE FROM assets_info_table
                                                WHERE email='$email' AND id='$id'
                                                LIMIT 1";
                            $delete_asset_run = mysqli_query($con, $delete_asset);

                            if(mysqli_affected_rows($con)){
                                // delete agent's files (assets directories and pictures)
                                deleteDirectory($asset_directory);
                            }
                        }
                    }
                    mysqli_close($con);
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        header("Location: agent_profile_page.php");
        exit();
    }

?>