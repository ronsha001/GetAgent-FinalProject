<?php session_start();

    if(!isset($_SESSION['verify_token']) or !isset($_SESSION['email'])) {
        header("Location: ../loginSystem/login_page.php");
        exit();
    } elseif (!isset($_SESSION['is_agent']) or $_SESSION['is_agent'] != '1'){
        header("Location: ../createProfiles/create_agent_page.php");
        exit();
    } elseif (!isset($_POST['asset_data']) or empty($_POST['asset_data'])){
        if(isset($_SERVER['HTTP_REFERER'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header("Location: ../index.php");
            exit();
        }
    }

    // ASSET DETAILS DELIVERED IN A FORM AS ARRAY
    $data = unserialize($_POST['asset_data']);

    // EDIT STATUS
    $value = '';
    $type = 'hidden';
    if (isset($_SESSION['status']) and !empty($_SESSION['status'])){
        $value = $_SESSION['status'];
        $type = 'text';
    }

    //  READ CITIES.TXT FILE
    $filename = "../cities.txt";
    $file = fopen( $filename, "r" );
    
    if( $file == false ) {
        echo ( "Error in opening cities file" );
        exit();
    }
    $filesize = filesize( $filename );
    $filetext = fread( $file, $filesize );

    // READ ASSET_TYPES.TXT FILE
    $asset_types = "../asset_types.txt";
    $asset_types_file = fopen($asset_types, "r");

    if( $asset_types_file == false ) {
        echo ( "Error in opening asset_types file" );
        exit();
    }
    $asset_types_file_size = filesize( $asset_types );
    $asset_types_text = fread( $asset_types_file, $asset_types_file_size );

    // READ ASSET_CONDITIONS.TXT FILE
    $asset_conditions = "../asset_conditions.txt";
    $asset_conditions_file = fopen($asset_conditions, "r");

    if( $asset_conditions_file == false ) {
        echo ( "Error in opening asset_types file" );
        exit();
    }
    $asset_conditions_file_size = filesize( $asset_conditions );
    $asset_conditions_text = fread( $asset_conditions_file, $asset_conditions_file_size );

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
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="upload_new_asset_page_style.css">
    <title>עריכת פרטיי נכס</title>
</head>

    <style>
        body{
            direction: rtl;
            margin: 0;
            padding: 0;
        }
    </style>

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
            <li><a href="../public/agentSearch.php">סוכנים</a></li>
            <li><a href="../public/assetSearch.php">נכסים</a></li>
            <li><a href='../Accounts/account_page.php'>חשבון</a></li>
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
    
    <!-- TOP CONTAINER ~ IMAGE -->
    <!-- <div class="top_container">
        <img src="../images/create_agent_background.jpg">
    </div> -->

    <div class="main_container">
        <div class="main_wrapper">

            <div class="error">
                <input type="<?php echo $type ?>" value="<?php echo $value; unset($_SESSION['status']);; ?>" disabled>
            </div>

            <div class="title_wrapper">
                <h1>פרסום נכס</h1>
            </div>

            <form action="edit_asset_code.php" method="POST" id="myForm" onsubmit="return isValidForm()" onkeydown="return event.key != 'Enter';" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <input type="hidden" name="asset_directory_path" value="<?php echo $data['asset_directory_path']; ?>">
                <div class="info_section">

                    <div class="select_info_section">

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="sale_or_rent">סטטוס הנכס:</label>
                            </div>
                            <select name="sale_or_rent" id="sale_or_rent" required>
                                <?php 
                                    if($data['sale_or_rent'] == 'sale'){
                                        echo "<option value='sale' selected='true'>מכירה</option>
                                            <option value='rent'>השכרה</option>
                                        ";
                                    } elseif($data['sale_or_rent'] == 'rent'){
                                        echo "<option value='rent' selected='true'>השכרה</option>
                                            <option value='sale'>מכירה</option>
                                        ";
                                    } 
                                ?>
                            </select>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="asset_type">סוג הנכס:</label>
                            </div>
                            <select name="asset_type" id="asset_type" required>
                                
                            </select>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="asset_condition">מצב הנכס:</label>
                            </div>
                            <select name="asset_condition" id="asset_condition" required>
                                    
                            </select>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="city">ישוב:</label>
                            </div>
                            <input type="text" list="cities" name="city" id="city" autocomplete="off" placeholder="בחר ישוב" required>
                                <datalist id="cities">
                            
                                </datalist>
                                
                            </input>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="street">רחוב:</label>
                            </div>
                            <input type="text" name="street" id="street" value="<?php echo $data['street']; ?>" required>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label for="house_number">מס' בית:</label>
                            </div>
                            <input type="number" name="house_number" value="<?php if($data['house_number']){echo $data['house_number'];} ?>" id="house_number" min="1">
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="floor">קומה:</label>
                            </div>
                            <input type="number" name="floor" value="<?php echo $data['floor']; ?>" id="floor" placeholder="עבור קומת קרקע יש להזין 0" required>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="max_floor">מתוך קומות:</label>
                            </div>
                            <input type="number" value="<?php echo $data['max_floor']; ?>" name="max_floor" id="max_floor" required>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="num_of_rooms">מס' חדרים:</label>
                            </div>
                            <input type="number" value="<?php echo $data['num_of_rooms']; ?>" name="num_of_rooms" id="num_of_rooms" min="1" step="0.5" required>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label for="balcony">מרפסת:</label>
                            </div>
                            <select name="balcony" id="balcony">
                                <script>
                                    var balcony = document.getElementById('balcony');
                                    var real_balcony = "<?php if($data['balcony']){echo $data['balcony'];} ?>";

                                    for (var i = 0; i < 4; i++){

                                        var option = document.createElement('option');
                                        option.value = i == 0 ? "ללא" : i;
                                        option.innerHTML = i == 0 ? "ללא" : i;
                                        balcony.appendChild(option);

                                        if(real_balcony && real_balcony == option.value){
                                            option.selected = true;
                                        }

                                    }
                                </script>
                            </select>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label class="required_label">*</label>
                                <label for="size_in_sm">גודל במ"ר:</label>
                            </div>
                            <input type="number" value="<?php echo $data['size_in_sm']; ?>" name="size_in_sm" id="size_in_sm" min="1" required>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                                <label for="parking_station">חניה:</label>
                            </div>
                            <select name="parking_station" id="parking_station">
                                <script>
                                    var parking = document.getElementById('parking_station');
                                    var real_parking = "<?php if($data['parking_station']){echo $data['parking_station'];} ?>";

                                    for (var i = 0; i < 4; i++){

                                        var option = document.createElement('option');
                                        option.value = i == 0 ? "ללא" : i;
                                        option.innerHTML = i == 0 ? "ללא" : i;
                                        parking.appendChild(option);

                                        if(real_parking && real_parking == option.value){
                                            option.selected = true;
                                        }

                                    }
                                </script>
                            </select>
                        </div>

                        <div class="select_info">
                            <div class="labels">
                            <label class="required_label">*</label>
                            <label for="entrance_date">תאריך כניסה:</label>
                            </div>
                            <input type="date" value="<?php echo $data['entrance_date']; ?>" name="entrance_date" id="entrance_date" required>

                        </div>
                    </div>

                    <hr class="horiz">

                    <div class="select_info_section">

                        <div class="checkboxes_wrapper">
                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "מיזוג")){echo "checked";} ?> name="air_condition" id="air_condition">
                                <div class="labels">
                                    <label for="air_condition">מיזוג</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "סורגים")){echo "checked";} ?> name="bars" id="bars">
                                <div class="labels">
                                    <label for="bars">סורגים</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "מעלית")){echo "checked";} ?> name="elevator" id="elevator">
                                <div class="labels">
                                    <label for="elevator">מעלית</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "מטבח כשר")){echo "checked";} ?> name="cosher_kitchen" id="cosher_kitchen">
                                <div class="labels">
                                    <label for="cosher_kitchen">מטבח כשר</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "גישה לנכים")){echo "checked";} ?> name="access_for_disabled" id="access_for_disabled">
                                <div class="labels">
                                    <label for="access_for_disabled">גישה לנכים</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "ממ\"ד")){echo "checked";} ?> name="protected_space" id="protected_space">
                                <div class="labels">
                                    <label for="protected_space">ממ"ד</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "משופצת")){echo "checked";} ?> name="renovated" id="renovated">
                                <div class="labels">
                                    <label for="renovated">משופצת</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "מחסן")){echo "checked";} ?> name="storage" id="storage">
                                <div class="labels">
                                    <label for="storage">מחסן</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "מזגן תדיראן")){echo "checked";} ?> name="tadiran_ac" id="tadiran_ac">
                                <div class="labels">
                                    <label for="tadiran_ac">מזגן תדיראן</label>
                                </div>
                            </div>

                            <div class="checkbox">
                                <input type="checkbox" <?php if(strpos($data['check_boxes'], "ריהוט")){echo "checked";} ?> name="furniture" id="furniture">
                                <div class="labels">
                                    <label for="furniture">ריהוט</label>
                                </div>
                            </div>

                        </div>

                        <div class="price_container">
                            <div class="price_wrapper">

                                <div class="labels">
                                    <label for="price">מחיר:</label>
                                </div>
                                <div class="price">
                                    <input type="text" value="<?php if($data['price']){echo $data['price'];} ?>" name="price" id="price"/>
                                    <select name="currency">
                                        <option selected value="shekel">₪</option>
                                        <option <?php if($data['currency'] == "dollar"){echo "selected";} ?> value="dollar">$</option>
                                    </select>
                                </div>

                            </div>
                            <div class="price_wrapper">

                                <div class="labels">
                                    <label for="tax">ארנונה:</label>
                                </div>
                                <div class="price">
                                    <input type="text" value="<?php if($data['tax']){echo $data['tax'];} ?>" name="tax" id="tax"/>
                                </div>

                            </div>
                        </div>


                    </div>
                    <hr class="horiz">

                    <div class="select_info_section">

                        <div class="text_area">
                            <div class="labels">
                                <label>תיאור ופרטים נוספים (עד 400 תווים):</label>
                            </div>
                            <textarea name="asset_description" id="asset_description" maxlength="400" cols="25" rows="10"><?php if($data['asset_description']){echo $data['asset_description'];} ?></textarea>
                        </div>

                        
                    </div>
                </div>

                <!-- ******IMAGES******** -->
                <div class="main_images_wrapper">
                    <div class="main_images_container">
                        <div class="container">
                            <div class="wrapper1">
                                <div class="image">
                                    <img src="<?php if($data['file1_path']){echo $data['file1_path']; $file1IsSet = true;} else {$file1IsSet = false;} ?>" alt="" id="img1">
                                    <input type="hidden" id="hiddenImg1" name="img1" value="<?php if($data['file1_path']){echo $data['file1_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn1"><i class="fas fa-times"></i></div>
                                <div class="file-name1">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file1" id="default-btn1" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive1()" id="custom-btn1">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper2">
                                <div class="image">
                                    <img src="<?php if($data['file2_path']){echo $data['file2_path']; $file2IsSet = true;} else {$file2IsSet = false;} ?>" alt="" id="img2">
                                    <input type="hidden" id="hiddenImg2" name="img2" value="<?php if($data['file2_path']){echo $data['file2_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn2"><i class="fas fa-times"></i></div>
                                <div class="file-name2">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file2" id="default-btn2" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive2()" id="custom-btn2">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper3">
                                <div class="image">
                                    <img src="<?php if($data['file3_path']){echo $data['file3_path']; $file3IsSet = true;} else {$file3IsSet = false;} ?>" alt="" id="img3">
                                    <input type="hidden" id="hiddenImg3" name="img3" value="<?php if($data['file3_path']){echo $data['file3_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn3"><i class="fas fa-times"></i></div>
                                <div class="file-name3">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file3" id="default-btn3" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive3()" id="custom-btn3">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper4">
                                <div class="image">
                                    <img src="<?php if($data['file4_path']){echo $data['file4_path']; $file4IsSet = true;} else {$file4IsSet = false;} ?>" alt="" id="img4">
                                    <input type="hidden" id="hiddenImg4" name="img4" value="<?php if($data['file4_path']){echo $data['file4_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn4"><i class="fas fa-times"></i></div>
                                <div class="file-name4">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file4" id="default-btn4" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive4()" id="custom-btn4">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper5">
                                <div class="image">
                                    <img src="<?php if($data['file5_path']){echo $data['file5_path']; $file5IsSet = true;} else {$file5IsSet = false;} ?>" alt="" id="img5">
                                    <input type="hidden" id="hiddenImg5" name="img5" value="<?php if($data['file5_path']){echo $data['file5_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn5"><i class="fas fa-times"></i></div>
                                <div class="file-name5">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file5" id="default-btn5" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive5()" id="custom-btn5">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper6">
                                <div class="image">
                                    <img src="<?php if($data['file6_path']){echo $data['file6_path']; $file6IsSet = true;} else {$file6IsSet = false;} ?>" alt="" id="img6">
                                    <input type="hidden" id="hiddenImg6" name="img6" value="<?php if($data['file6_path']){echo $data['file6_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn6"><i class="fas fa-times"></i></div>
                                <div class="file-name6">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file6" id="default-btn6" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive6()" id="custom-btn6">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper7">
                                <div class="image">
                                    <img src="<?php if($data['file7_path']){echo $data['file7_path']; $file7IsSet = true;} else {$file7IsSet = false;} ?>" alt="" id="img7">
                                    <input type="hidden" id="hiddenImg7" name="img7" value="<?php if($data['file7_path']){echo $data['file7_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn7"><i class="fas fa-times"></i></div>
                                <div class="file-name7">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file7" id="default-btn7" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive7()" id="custom-btn7">בחר תמונה</button>
                        </div>

                        <div class="container">
                            <div class="wrapper8">
                                <div class="image">
                                    <img src="<?php if($data['file8_path']){echo $data['file8_path']; $file8IsSet = true;} else {$file8IsSet = false;} ?>" alt="" id="img8">
                                    <input type="hidden" id="hiddenImg8" name="img8" value="<?php if($data['file8_path']){echo $data['file8_path'];}?>">
                                </div>
                                <div class="content">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="text">לא נבחרה תמונה</div>
                                </div>
                                <div id="cancel-btn8"><i class="fas fa-times"></i></div>
                                <div class="file-name8">שם תמונה</i></div>
                            </div>
                            <input type="file" name="file8" id="default-btn8" accept="image/png, image/gif, image/jpeg, image/jpg" hidden>
                            <button type="button" onclick="defaultBtnActive8()" id="custom-btn8">בחר תמונה</button>
                        </div>

                    </div>
                </div>
                <!-- ************** -->

                <div class="submit_wrapper">
                    <input type="submit" name="submit" id="submit" value="עדכן פרטיי נכס">
                </div>
            </form>

        </div>
    </div>

    <!-- <script src="Date.js" type="text/javascript"></script> -->
    <!-- <script src="Cities.js" type="text/javascript"></script> -->
    <script src="PriceSeparator.js" type="text/javascript"></script>
    <script>

        var submitBtn = document.getElementById('submit');
        var cityInput = document.getElementById('city');
        
        // ENCODE PHP READ FILE (CITIES.TXT)
        var cities = <?php echo json_encode($filetext); ?>;
        var real_asset_city = <?php echo json_encode($data['city']) ?>;
        cities = cities.split("\n");
        // REMOVE UNWANTED CHARACTERS
        for(var i = 0; i < cities.length - 1; i++){
            cities[i] = cities[i].substr(0, cities[i].length-1);
        }
        // PUSH OPTIONS FROM cities array TO SELECT CITY
        var list = document.getElementById('cities');
        var option;
        cities.forEach(function(item){
            option = document.createElement('option');
            option.value = item;
            list.appendChild(option);
            if ( real_asset_city == option.value ) {
                document.getElementById('city').value = option.value;
            }
        });

        // ENCODE PHP READ FILE (ASSET_TYPES.TXT)
        var asset_types = <?php echo json_encode($asset_types_text); ?>;
        var asset_real_type = <?php echo json_encode($data['asset_type']); ?>;
        asset_types = asset_types.split("\n");
        // REMOVE UNWANTED CHARACTERS
        for ( var i = 0; i < asset_types.length - 1; i++ ) {
            asset_types[i] = asset_types[i].substr(0, asset_types[i].length-1);
        }
        // PUSH OPTIONS FROM asset_types array TO SELECT ASSET TYPE
        var types_list = document.getElementById('asset_type');
        asset_types.forEach( function(item){
            option = document.createElement('option');
            option.value = item;
            option.innerHTML = item;
            types_list.appendChild(option);
            if ( asset_real_type == option.value ) {
                option.selected = true;
            }
        });

        // ENCODE PHP READ FILE (ASSET_CONDITIONS.TXT)
        var asset_conditions = <?php echo json_encode($asset_conditions_text); ?>;
        var real_asset_condition = <?php echo json_encode($data['asset_condition']); ?>;
        asset_conditions = asset_conditions.split("\n");
        // REMOVE UNWANTED CHARACTERS
        for ( var i = 0; i < asset_conditions.length - 1; i++ ) {
            asset_conditions[i] = asset_conditions[i].substr(0, asset_conditions[i].length - 1);
        }
        // PUSH OPTIONS FROM asset_conditions array TO SELECT ASSET CONDITION
        var condition_list = document.getElementById('asset_condition');
        asset_conditions.forEach( function(item){
            option = document.createElement('option');
            option.value = item;
            option.innerHTML = item;
            condition_list.appendChild(option);
            if( real_asset_condition == option.value ) {
                option.selected = true;
            }
        });


        document.getElementById('myForm').onsubmit = function() {
            return isValidForm();
        }
        

        function isValidForm() {
            if(cities.includes(cityInput.value)){
                return true;
            } else {
                alert("בחר עיר מהרשימה.");
                return false;
            }
        }


        const wrapper1 = document.querySelector(".wrapper1");
        const fileName1 = document.querySelector(".file-name1");
        const cancelBtn1 = document.querySelector("#cancel-btn1");
        const defaultBtn1 = document.querySelector("#default-btn1");
        const customBtn1 = document.querySelector("#custom-btn1");
        const img1 = document.querySelector("#img1");

        const wrapper2 = document.querySelector(".wrapper2");
        const fileName2 = document.querySelector(".file-name2");
        const cancelBtn2 = document.querySelector("#cancel-btn2");
        const defaultBtn2 = document.querySelector("#default-btn2");
        const customBtn2 = document.querySelector("#custom-btn2");
        const img2 = document.querySelector("#img2");

        const wrapper3 = document.querySelector(".wrapper3");
        const fileName3 = document.querySelector(".file-name3");
        const cancelBtn3 = document.querySelector("#cancel-btn3");
        const defaultBtn3 = document.querySelector("#default-btn3");
        const customBtn3 = document.querySelector("#custom-btn3");
        const img3 = document.querySelector("#img3");

        const wrapper4 = document.querySelector(".wrapper4");
        const fileName4 = document.querySelector(".file-name4");
        const cancelBtn4 = document.querySelector("#cancel-btn4");
        const defaultBtn4 = document.querySelector("#default-btn4");
        const customBtn4 = document.querySelector("#custom-btn4");
        const img4 = document.querySelector("#img4");

        const wrapper5 = document.querySelector(".wrapper5");
        const fileName5 = document.querySelector(".file-name5");
        const cancelBtn5 = document.querySelector("#cancel-btn5");
        const defaultBtn5 = document.querySelector("#default-btn5");
        const customBtn5 = document.querySelector("#custom-btn5");
        const img5 = document.querySelector("#img5");

        const wrapper6 = document.querySelector(".wrapper6");
        const fileName6 = document.querySelector(".file-name6");
        const cancelBtn6 = document.querySelector("#cancel-btn6");
        const defaultBtn6 = document.querySelector("#default-btn6");
        const customBtn6 = document.querySelector("#custom-btn6");
        const img6 = document.querySelector("#img6");

        const wrapper7 = document.querySelector(".wrapper7");
        const fileName7 = document.querySelector(".file-name7");
        const cancelBtn7 = document.querySelector("#cancel-btn7");
        const defaultBtn7 = document.querySelector("#default-btn7");
        const customBtn7 = document.querySelector("#custom-btn7");
        const img7 = document.querySelector("#img7");

        const wrapper8 = document.querySelector(".wrapper8");
        const fileName8 = document.querySelector(".file-name8");
        const cancelBtn8 = document.querySelector("#cancel-btn8");
        const defaultBtn8 = document.querySelector("#default-btn8");
        const customBtn8 = document.querySelector("#custom-btn8");
        const img8 = document.querySelector("#img8");
        var regExp = /[0-9a-z-A-Z\^\%\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

        var file1IsSet = "<?php echo $file1IsSet; ?>";
        var file2IsSet = "<?php echo $file2IsSet; ?>";
        var file3IsSet = "<?php echo $file3IsSet; ?>";
        var file4IsSet = "<?php echo $file4IsSet; ?>";
        var file5IsSet = "<?php echo $file5IsSet; ?>";
        var file6IsSet = "<?php echo $file6IsSet; ?>";
        var file7IsSet = "<?php echo $file7IsSet; ?>";
        var file8IsSet = "<?php echo $file8IsSet; ?>";


        function defaultBtnActive1(){
            defaultBtn1.click();
        }
        if(file1IsSet){
            wrapper1.classList.add("active");
            cancelBtn1.addEventListener("click", function(){
                img1.src = "";
                wrapper1.classList.remove("active");
                document.getElementById('hiddenImg1').value += "*deleteMe*";
            });
        }
        defaultBtn1.addEventListener("change", function(){
            const file1 = this.files[0];
            if(file1){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img1.src = result;
                    wrapper1.classList.add("active");
                    document.getElementById('hiddenImg1').value += "*deleteMe*";
                }
                cancelBtn1.addEventListener("click", function(){
                    img1.src = "";
                    wrapper1.classList.remove("active");
                });
                reader.readAsDataURL(file1);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName1.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive2(){
            defaultBtn2.click();
        }
        if(file2IsSet){
            wrapper2.classList.add("active");
            cancelBtn2.addEventListener("click", function(){
                img2.src = "";
                wrapper2.classList.remove("active");
                document.getElementById('hiddenImg2').value += "*deleteMe*";
            });
        }
        defaultBtn2.addEventListener("change", function(){
            const file2 = this.files[0];
            if(file2){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img2.src = result;
                    wrapper2.classList.add("active");
                    document.getElementById('hiddenImg2').value += "*deleteMe*";
                }
                cancelBtn2.addEventListener("click", function(){
                    img2.src = "";
                    wrapper2.classList.remove("active");
                });
                reader.readAsDataURL(file2);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName2.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive3(){
            defaultBtn3.click();
        }
        if(file3IsSet){
            wrapper3.classList.add("active");
            cancelBtn3.addEventListener("click", function(){
                img3.src = "";
                wrapper3.classList.remove("active");
                document.getElementById('hiddenImg3').value += "*deleteMe*";
            });
        }
        defaultBtn3.addEventListener("change", function(){
            const file3 = this.files[0];
            if(file3){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img3.src = result;
                    wrapper3.classList.add("active");
                    document.getElementById('hiddenImg3').value += "*deleteMe*";
                }
                cancelBtn3.addEventListener("click", function(){
                    img3.src = "";
                    wrapper3.classList.remove("active");
                });
                reader.readAsDataURL(file3);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName3.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive4(){
            defaultBtn4.click();
        }
        if(file4IsSet){
            wrapper4.classList.add("active");
            cancelBtn4.addEventListener("click", function(){
                img4.src = "";
                wrapper4.classList.remove("active");
                document.getElementById('hiddenImg4').value += "*deleteMe*";
            });
        }
        defaultBtn4.addEventListener("change", function(){
            const file4 = this.files[0];
            if(file4){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img4.src = result;
                    wrapper4.classList.add("active");
                    document.getElementById('hiddenImg4').value += "*deleteMe*";
                }
                cancelBtn4.addEventListener("click", function(){
                    img4.src = "";
                    wrapper4.classList.remove("active");
                });
                reader.readAsDataURL(file4);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName4.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive5(){
            defaultBtn5.click();
        }
        if(file5IsSet){
            wrapper5.classList.add("active");
            cancelBtn5.addEventListener("click", function(){
                img5.src = "";
                wrapper5.classList.remove("active");
                document.getElementById('hiddenImg5').value += "*deleteMe*";
            });
        }
        defaultBtn5.addEventListener("change", function(){
            const file5 = this.files[0];
            if(file5){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img5.src = result;
                    wrapper5.classList.add("active");
                    document.getElementById('hiddenImg5').value += "*deleteMe*";
                }
                cancelBtn5.addEventListener("click", function(){
                    img5.src = "";
                    wrapper5.classList.remove("active");
                });
                reader.readAsDataURL(file5);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName5.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive6(){
            defaultBtn6.click();
        }
        if(file6IsSet){
            wrapper6.classList.add("active");
            cancelBtn6.addEventListener("click", function(){
                img6.src = "";
                wrapper6.classList.remove("active");
                document.getElementById('hiddenImg6').value += "*deleteMe*";
            });
        }
        defaultBtn6.addEventListener("change", function(){
            const file6 = this.files[0];
            if(file6){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img6.src = result;
                    wrapper6.classList.add("active");
                    document.getElementById('hiddenImg6').value += "*deleteMe*";
                }
                cancelBtn6.addEventListener("click", function(){
                    img6.src = "";
                    wrapper6.classList.remove("active");
                });
                reader.readAsDataURL(file6);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName6.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive7(){
            defaultBtn7.click();
        }
        if(file7IsSet){
            wrapper7.classList.add("active");
            cancelBtn7.addEventListener("click", function(){
                img7.src = "";
                wrapper4.classList.remove("active");
                document.getElementById('hiddenImg7').value += "*deleteMe*";
            });
        }
        defaultBtn7.addEventListener("change", function(){
            const file7 = this.files[0];
            if(file7){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img7.src = result;
                    wrapper7.classList.add("active");
                    document.getElementById('hiddenImg7').value += "*deleteMe*";
                }
                cancelBtn7.addEventListener("click", function(){
                    img7.src = "";
                    wrapper7.classList.remove("active");
                });
                reader.readAsDataURL(file7);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName7.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });

        function defaultBtnActive8(){
            defaultBtn8.click();
        }
        if(file8IsSet){
            wrapper8.classList.add("active");
            cancelBtn8.addEventListener("click", function(){
                img8.src = "";
                wrapper8.classList.remove("active");
                document.getElementById('hiddenImg8').value += "*deleteMe*";
            });
        }
        defaultBtn8.addEventListener("change", function(){
            const file8 = this.files[0];
            if(file8){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img8.src = result;
                    wrapper8.classList.add("active");
                    document.getElementById('hiddenImg8').value += "*deleteMe*";
                }
                cancelBtn8.addEventListener("click", function(){
                    img8.src = "";
                    wrapper8.classList.remove("active");
                });
                reader.readAsDataURL(file8);
            }
            if(this.value){
                var valueStore = this.value.match(regExp);
                fileName8.textContent = valueStore;
                // fileName.style.display = "block";
            }
        });
    </script>
</body>
</html>