<?php session_start();

    if(!isset($_SESSION) or empty($_SESSION)){
        header("Location: ../loginSystem/login_page.php");
        exit();
    } else if (!isset($_SESSION['email']) or !isset($_SESSION['verify_token']) or empty($_SESSION['email']) or empty($_SESSION['verify_token'])){
        header("Location: ../loginSystem/logout.php");
        exit();
    } else if (!isset($_POST) or empty($_POST)){
        if (isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('Location: ../index.php');
            exit();
        }
    }

    $email = $_SESSION['email'];
    $type = "";
    $typeID = "";
    try{
        if(isset($_POST['type']) and isset($_POST['type_id'])){
            $type = $_POST['type'];
            $typeID = $_POST['type_id'];

            if($type == 'asset' or $type == 'agent'){
                $table = "";
                if($type == 'asset'){
                    $table = 'assets_info_table';
                } else {
                    $table = 'agents_info_table';
                }
                include_once('../loginSystem/db.php');
                $remove_like = "UPDATE $table SET email_likes=REPLACE(email_likes, '$email,', '') WHERE id='$typeID' LIMIT 1";
                mysqli_query($con, $remove_like);
                mysqli_close($con);
            }

        }
    } catch (Exception $e){
        echo $e->getMessage();
    } finally {
        
        if (isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('Location: ../index.php');
            exit();
        }
    }
    

?>