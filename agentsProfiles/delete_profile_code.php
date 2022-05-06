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
                                    WHERE verify_token='$token' AND email='$email'
                                    LIMIT 1";
                    $get_account_run = mysqli_query($con, $get_account);
                    // check password match
                    $accountArr = mysqli_fetch_array($get_account_run);
                    
                    if($accountArr['pass'] == $pswd) {

                        // update account's $isAgent variable back to 0 in accounts table
                        $update_account = "UPDATE accounts
                                            SET isAgent=0
                                            WHERE verify_token='$token' AND email='$email'
                                            LIMIT 1";
                        $update_account_run = mysqli_query($con, $update_account);

                        // if account has a profile delete all his shows from db and storage
                        if($isAgent) {
                            // delete agent from agents table
                            $delete_agent = "DELETE FROM agents_info_table
                                            WHERE verify_token='$token' AND email='$email'
                                            LIMIT 1";
                            $delete_agent_run = mysqli_query($con, $delete_agent);

                            // delete all reviews that given to this agent profile
                            $delete_reviews = "DELETE FROM reviews_info_table
                                                WHERE to_email='$email'";
                            $delete_reviews_run = mysqli_query($con, $delete_reviews);
                            
                            // delete agent's files (assets directories and pictures)
                            deleteDirectory($_SESSION['folder_path']);
                            
                            // delete all agent's assets from assets table
                            $delete_assets = "DELETE FROM assets_info_table
                                                WHERE email='$email'";
                            $delete_assets_run = mysqli_query($con, $delete_assets);

                            // unset all session's variable that connected to agent profile
                            unset($_SESSION['folder_path']);
                            unset($_SESSION['logo_path']);
                            unset($_SESSION['agent_cities']);
                            unset($_SESSION['phone_number']);
                            unset($_SESSION['birth_date']);
                            unset($_SESSION['website_link']);
                            unset($_SESSION['office_address']);
                            unset($_SESSION['years_of_exp']);
                            unset($_SESSION['about_agent']);
                            unset($_SESSION['office_name']);
                            unset($_SESSION['license_year']);
                            unset($_SESSION['for_sale']);
                            unset($_SESSION['for_rent']);

                            // set session is_agent variable back to 0 since this account is not an agent anymore
                            $_SESSION['is_agent'] = 0;
                        }
                    }
                    mysqli_close($con);
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        header("Location: ../index.php");
        exit();
    }

?>