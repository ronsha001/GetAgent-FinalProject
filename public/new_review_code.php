<?php session_start();
    if(!isset($_SESSION['verify_token']) or empty($_SESSION['verify_token'])){
        header("Location: ../index.php");
        exit();
    }
    if(!isset($_POST) or empty($_POST)){
        header("Location: ../Accounts/account_page.php");
        exit();
    }
    $from_email = $_SESSION['email'];
    $to_email = $_POST['agent_email'];
    $account_name = $_SESSION['first_name'].' '.$_SESSION['last_name'];
    $account_pic = $_SESSION['picture_path'];
    $agent_name = $_POST['agent_name'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $stars = $subject;
    if($subject == 1){
        $subject = "לא אהבתי בכלל, לא ממליץ!";
    } elseif ($subject == 2){
        $subject = "לא אהבתי";
    } elseif ($subject == 3){
        $subject = "נחמד מאוד";
    } elseif ($subject == 4){
        $subject = "אהבתי";
    } elseif ($subject == 5){
        $subject = "אהבתי מאוד, ממליץ!";
    }

    if($_POST['new_review_submit']){
        try{
            include_once("../loginSystem/db.php");
            
            $insert_review = "INSERT INTO reviews_info_table (`from_email`, `to_email`, `account_name`, `account_picture`, `agent_name`, `subject`, `stars`, `body`)
                            VALUES ('$from_email', '$to_email', '$account_name', '$account_pic', '$agent_name', '$subject', '$stars', '$body')";
            try{
            $insert_review_run = mysqli_query($con, $insert_review);
            }catch (Exception $e){
                echo $e;
            }
            if($insert_review_run){
                mysqli_close($con);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } catch (Exception $e) {
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
    } else {
        header("Location: ../index.php");
        exit();
    }
?>