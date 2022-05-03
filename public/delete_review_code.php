<?php session_start();
    if(!isset($_SESSION['verify_token']) or empty($_SESSION['verify_token'])){
        header("Location: ../index.php");
        exit();
    }
    if(!isset($_POST) or empty($_POST)){
        header("Location: ../index.php");
        exit();
    }

    try{
        $review_id = $_POST['review_id'];
        $to_email = $_POST['to_email'];
        echo $review_id.'---------';
        echo $to_email;
        include_once('../loginSystem/db.php');

        $delete_review = "DELETE FROM reviews_info_table WHERE id='$review_id' AND from_email='$_SESSION[email]' AND to_email='$to_email' LIMIT 1";
        $delete_review_run = mysqli_query($con, $delete_review);
    } catch (Exception $e){
        echo $e;
    } finally {
        mysqli_close($con);
        
        if(isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit(); 
        } else {
            header("Location: ../index.php");
            exit();
        }
        
    }
?>