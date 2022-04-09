<?php session_start();
    if(!isset($_SESSION['verify_token'], $_POST['subject'], $_POST['body'], $_POST['id'], $_POST['type']) or empty($_SESSION['verify_token']) or empty($_POST['subject'] or empty($_POST['body']) or empty($_POST['id']) or empty($_POST['type']))){
        header("Location: ../index.php");
        exit();
    }
    $from_email = $_SESSION['email'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $type = $_POST['type'];
    $id = $_POST['id'];
    
    try{
        include_once('../loginSystem/db.php');
        $insert_new_report = "INSERT INTO reports_info_table 
                                (`type_id`, `from_email`, `type`, `subject`, `body`)
                                VALUES ('$id', '$from_email', '$type', '$subject', '$body')";
        $insert_new_report_run = mysqli_query($con, $insert_new_report);

    } catch (Exception $e) {
        echo $e;
    } finally {
        mysqli_close($con);
        
        if (isset($_SERVER['HTTP_REFERER'])){
            $_SESSION['status'] = "הדיווח נשלח בהצלחה, אנו נבדוק את הדיווח שלך בהקדם.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('Location: ../index.php');
            exit();
        }
    }
?>