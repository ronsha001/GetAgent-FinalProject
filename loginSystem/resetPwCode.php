<?php session_start();
    $token = "";
    $pw = "";
    $vpw = "";
    try{
        if(isset($_POST) and !empty($_POST)){
            if(isset($_POST['pw']) and !empty($_POST['pw']) and isset($_POST['vpw']) and !empty($_POST['vpw']) and isset($_POST['token']) and !empty($_POST['token'])) {
                $pw = $_POST['pw'];
                $vpw = $_POST['vpw'];
                $token = $_POST['token'];

                if($pw == $vpw) {
                    $newToken = md5(uniqid());
                    
                    include_once('db.php');

                    $update_account = "UPDATE accounts
                                        SET password='$vpw' , verify_token='$newToken'
                                        WHERE verify_token='$token' LIMIT 1";

                    $update_account_run = mysqli_query($con, $update_account);

                    $update_agent_table = "UPDATE agents_info_table
                                            SET verify_token='$newToken'
                                            WHERE verify_token='$token'";

                    $update_agent_table_run = mysqli_query($con, $update_agent_table);
                    
                    if(mysqli_affected_rows($con)){
                        $_SESSION['status'] = "סיסמה חדשה אושרה.";
                    } else {
                        $_SESSION['status'] = "משהו השתבש #1";
                    }

                    mysqli_close($con);

                } else {
                    $_SESSION['status'] = "סיסמה ואימות סיסמה אינם תואמים";
                }
            } else {
                $_SESSION['status'] = "משהו השתבש #2";
            }
        } else {
            $_SESSION['status'] = "משהו השתבש #3";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('Location: resetPwPage.php');
            exit();
        }
    }
?>