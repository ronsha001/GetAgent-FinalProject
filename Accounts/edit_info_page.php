<?php session_start();
    if (isset($_SESSION['verify_token'])){
        $email = $_SESSION['email'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $gender = $_SESSION['gender'];
        
        $value = '';
        $type = 'hidden';
        if (isset($_SESSION['status']) and !empty($_SESSION['status'])){
            $value = $_SESSION['status'];
            $type = 'text';
        } 
    } else {
        header("Location: ../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get real estate agent / agency">
    <meta name="keywords" content="Get Agent real estate agency buy sell rent">
    <meta name="author" content="Ron Sharabi">
    <link rel="icon" type="png" href="../images/title_icon.png">
    <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" type="text/css" href="../Nav.css">
    <link rel="stylesheet" type="text/css" href="../Footer.css">
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="edit_info_page_style.css">

    <title>גט אייג'נט עריכת חשבון</title>
</head>
<body>
    <!-- Navigation bar, Ty Dev Ed-->
    <nav>
        <div class="logo">
            <a href="../index.php">
            <img class="myLogo" src="../images/Logo.png" style="width: 60px;" alt="logo">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">בית</a></li>
            <li><a href="#">סוכנים</a></li>
            <li><a href="#">נכסים</a></li>
            <li><a href="account_page.php">חשבון</a></li>
            <li><a href="../About/about_page.php">עלינו</a></li>
            <li><a href='../loginSystem/logout.php' >התנתק</a></li>
        </ul>
        <div class="burger">
            <div class="lin1"></div>
            <div class="lin2"></div>
            <div class="lin3"></div>
        </div>        
    </nav>
    <script src="../Nav.js" type="text/javascript"></script>

    <div class="center">
        <div class="error">
            <input type="<?php echo $type ?>" value="<?php echo $value; unset($_SESSION['status']);; ?>" disabled>
        </div>

        <h1>עריכת מידע</h1>
    
        <form action="edit_info_code.php" method="POST">
            <div class="txt_field">
                <input type="text" name="first_name" value="<?php echo $first_name; ?>" required>
                <span></span>
                <label>שם</label>
            </div>
            <div class="txt_field">
                <input type="text" name="last_name" value="<?php echo $last_name; ?>" required>
                <span></span>
                <label>שם משפחה</label>
            </div>
        
            <div class="gender-details">
                <input type="radio" name="gender" id="dot-1" value="זכר" <?php if($gender == 'זכר'){echo 'checked';} ?> required>
                <input type="radio" name="gender" id="dot-2" value="נקבה" <?php if($gender == 'נקבה'){echo 'checked';} ?> required>
                <input type="radio" name="gender" id="dot-3" value="מעדיף שלא לומר" <?php if($gender == 'מעדיף שלא לומר'){echo 'checked';} ?> required>
                <span class="gender-title">מין</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">זכר</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">נקבה</span>
                    </label>
                    <label for="dot-3">
                        <span class="dot three"></span>
                        <span class="gender">מעדיף שלא לומר</span>
                    </label>
                </div>
            </div>

            <input type="submit" name="submit" value="שמור שינויים">
        </form>
    </div>
</body>
</html>