<?php session_start();

    use PHPMailer\PHPMailer\PHPMailer;

    function sendContactMail($agent_email, $office_name, $name, $phone, $pw) {
        $h2 = "לקוח השאיר פרטים וביקש שתחזרו אליו.";
        if($name) {
            $h2 = "$name השאיר פרטים וביקש שתחזרו אליו.";
        }
        $body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewpoint' content='width=device-width, initial-scale=1.0'>
                <title>פרטיי לקוח</title>

                <style>
                    body{
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                    }
                    #customer_details{
                        width:450px;
                        height:fit-content;
                        text-align: center;
                        font-family:sans-serif;
                        background-color:#2691d9;
                        border-radius:10px;
                    }
                </style>
            </head>
            <body>
                <div id='customer_details'>
                    <h1>שלום $office_name</h1>
                    <h2>$h2</h2>
                    <h2>פלאפון הלקוח: $phone</h2>
                </div>
            </body>
            </html>
        ";

        require_once "../loginSystem/PHPMailer/PHPMailer.php";
        require_once "../loginSystem/PHPMailer/SMTP.php";
        require_once "../loginSystem/PHPMailer/Exception.php";

        $mail = new PHPMailer();

        //smtp settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "getagent0111@gmail.com";
        $mail->Password = "$pw";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";

        //email settings
        $mail->isHTML(true);
        $mail->setFrom("getagent0111@gmail.com", "GetAgent");
        $mail->addAddress($agent_email);
        $mail->Subject = "GetAgent - Customer Details";
        $mail->Body = $body;

        if($mail->send()){
            return true;
        } else {
            echo $mail->ErrorInfo;
            return false;
        }
    }

    try{
        if(isset($_POST) and !empty($_POST)){
            $name = "";
            $phone = "";
            $agent_email = "";
            if(isset($_POST['name']) and !empty($_POST['name'])) {
                $name = $_POST['name'];
            }
            if(isset($_POST['phone']) and !empty($_POST['phone'])) {
                $phone = $_POST['phone'];
            }
            if(isset($_POST['agent_email']) and !empty($_POST['agent_email'])) {
                $agent_email = $_POST['agent_email'];
            }
            if($agent_email and ($phone or $name)) {
                include_once('../loginSystem/db.php');

                // check if agent_email is exist in db (agents_info_table)
                $isAgent = "SELECT office_name, email
                            FROM agents_info_table
                            WHERE email='$agent_email'";
                $isAgent_run = mysqli_query($con, $isAgent);
                if(mysqli_num_rows($isAgent_run)) {
                    $agent_details = mysqli_fetch_array($isAgent_run);
                    
                    $mailSent = sendContactMail($agent_email, $agent_details['office_name'], $name, $phone, $pw);

                    if($mailSent) {
                        $_SESSION['status'] = "מייל עם הפרטים שלך נשלח אל הסוכן.";
                    }
                }

                mysqli_close($con);
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header('Location: ../index.php');
            exit();
        }
    }

?>