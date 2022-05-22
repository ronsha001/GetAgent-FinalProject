<?php session_start();
    $isRegistered = false;
    $email = '';
    $agent_profile = '<i class="fa-solid fa-plus"></i> צור פרופיל סוכן';
    $agent_profile_footer = 'צור פרופיל סוכן';
    $agent_link = '../loginSystem/login_page.php';
    $first_name = '';
    $login_or_logout = '';
    $loginLink_or_logoutLink = '';
    if (!isset($_SESSION['email']) or empty($_SESSION['email'])){
        $first_name = "אורח";
        $login_or_logout = "התחבר";
        $loginLink_or_logoutLink = "../loginSystem/login_page.php";
    } else {
        $first_name = $_SESSION['first_name'];
        $login_or_logout = "התנתק";
        $loginLink_or_logoutLink = "../loginSystem/logout.php";
        $isRegistered = true;
        $agent_link = '../createProfiles/create_agent_page.php';
        $email = $_SESSION['email'];
        if ($_SESSION['is_agent'] == 1) {
            $agent_link = '../agentsProfiles/agent_profile_page.php'; // TODO create agent page
            $agent_profile = 'פרופיל הסוכן שלי';
            $agent_profile_footer = 'פרופיל הסוכן שלי';
        } 
        
    }

    // READ CITIES.TXT FILE
    $filename = "../cities.txt";
    $file = fopen( $filename, "r" );
    
    if( $file == false ) {
        echo ( "Error in opening file" );
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

    $max_cards = 5;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="description" content="Get real estate agent / agency">
		<meta name="keywords" content="Get Agent real estate agency buy sell rent">
		<meta name="author" content="Ron Sharabi">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <link rel="icon" type="png" href="../images/title_icon.png">
        <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" type="text/css" href="../Nav.css">
        <link rel="stylesheet" type="text/css" href="../Footer.css">
        <link rel="stylesheet" type="text/css" href="../TopSection.css">
        <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
        <link rel="stylesheet" type="text/css" href="../AgentCards.css">
        <link rel="stylesheet" type="text/css" href="../AssetsCards.css">
        <link rel="stylesheet" type="text/css" href="../PagerStyle.css">
        <link rel="stylesheet" type="text/css" href="assetSearchStyle.css">

        <title>גט אייג'נט - חיפוש נכסים</title>

        <style>
            body, html {
                margin: 0px;
                padding: 0px;
                overflow-x: hidden;
                direction: rtl;
            }    
        </style>

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
                <li><a href="agentSearch.php">סוכנים</a></li>
                <li><a href="assetSearch.php">נכסים</a></li>
                <li><a href='<?php if($isRegistered){echo "../Accounts/account_page.php";}else{echo "../loginSystem/login_page.php";} ?>'>חשבון</a></li>
                <li><a href="../About/about_page.php">עלינו</a></li>
                <li><a href=<?php echo $loginLink_or_logoutLink ?> > <?php echo $login_or_logout ?></a></li>
            </ul>
            <div class="burger">
                <div class="lin1"></div>
                <div class="lin2"></div>
                <div class="lin3"></div>
            </div>        
        </nav>
        <script src="../Nav.js" type="text/javascript"></script>
        
        <!-- SEARCH FILTER FORM -->
        <form action="assetSearch.php" method="GET" id="searchForm" class="myForm">
            <div class="search_container">
                <div class="title">
                    <h2>איזה נכס תרצו לחפש?</h2>
                </div>
                <div class="asset_status">
                    <label for="sale_or_rent"> למכירה או השכרה?</label>
                    <select name="sale_or_rent" id="sale_or_rent">
                        <option value="" selected="true" disabled="disabled">בחר סטטוס</option>
                        <option value="sale">מכירה</option>
                        <option value="rent">השכרה</option>
                    </select>
                </div>
                

                <div class="top_inputs">
                    <!-- city input -->
                    <div class="input">
                        <label for="city"><i class="fa-solid fa-tree-city"></i> חפש עיר</label>
                        <input type="text" name="city" list="cities" id="city" placeholder="לדוגמא: תל אביב יפו">
                        <datalist id="cities">
                            
                        </datalist>
                    </div>
                    <!-- type input -->
                    <div class="input">
                        <label><i class="fa-solid fa-house-circle-check"></i> סוג נכס</label>
                        <div id="list1" class="dropdown-check-list" tabindex="100">
                            <span class="anchor">בחרו את סוג הנכס</span>
                            <ul class="items" id="asset_type">
                                <!-- <li><input type="checkbox" />Apple </li>
                                <li><input type="checkbox" />Orange</li>
                                <li><input type="checkbox" />Grapes </li>
                                <li><input type="checkbox" />Berry </li>
                                <li><input type="checkbox" />Mango </li>
                                <li><input type="checkbox" />Banana </li>
                                <li><input type="checkbox" />Tomato</li> -->
                            </ul>

                            <input type="hidden" name="asset_type" id="typeStr">
                        </div>
                    </div>
                    <!-- room input -->
                    <div style="display: flex; flex-direction: row;">
                        <div class="input">
                            <label for="min_rooms"><i class="fa-solid fa-bed"></i> חדרים</label>
                            <input type="number" id="min_rooms" name="min_rooms" min=0 max=12 step="0.5" placeholder="מ-">
                        </div>
                        <div class="input">
                            <input type="number" id="max_rooms" name="max_rooms" min=0 max=12 step="0.5" placeholder="עד-" style="transform: translateY(52%);">
                        </div>
                    </div>
                    <!-- price input -->
                    <div style="display: flex; flex-direction: row;">
                        <div class="input">
                            <label for="min_price"><i class="fa-solid fa-hand-holding-dollar"></i> מחיר</label>
                            <input type="text" id="min_price" name="min_price" placeholder="מ-">
                        </div>
                        <div class="input">
                            <input type="text" id="max_price" name="max_price" placeholder="עד-" style="transform: translateY(52%);">
                        </div>
                    </div>
                    <div class="input">
                        <div class="submit_container">
                            <button id="advanced_btn" type="button"><i id="adv_icn" class="fa-solid fa-plus"></i> חיפוש מתקדם</button>
                        </div>
                    </div>
                    <div class="input">
                        <div class="submit_container">
                            <button name="submitBtn" id="submitBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> חיפוש</button>
                        </div>
                    </div>
                </div>

                <div id="advanced_search" class="advanced_search">
                    <h4>מאפייני נכס</h4>
                    <div class="mid_inputs">

                        <div class="checkboxes" id="checkboxesParent">

                            <div class="check_box">
                                <input type="checkbox" value="חניה" id="parking" onclick="insertCheckbox()">
                                <label for="parking">חניה</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="מעלית" id="elevator" onclick="insertCheckbox()">
                                <label for="elevator">מעלית</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="מיזוג" id="ac" onclick="insertCheckbox()">
                                <label for="ac">מיזוג</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="מרפסת" id="balcony" onclick="insertCheckbox()">
                                <label for="balcony">מרפסת</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="מיזוג" id="safe_room" onclick="insertCheckbox()">
                                <label for="safe_room">ממ"ד</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="סורגים" id="bars" onclick="insertCheckbox()">
                                <label for="bars">סורגים</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="מחסן" id="storage" onclick="insertCheckbox()">
                                <label for="storage">מחסן</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="גישה לנכים" id="access_for_disabled" onclick="insertCheckbox()">
                                <label for="access_for_disabled">גישה לנכים</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="משופצת id="renovated" onclick="insertCheckbox()">
                                <label for="renovated">משופצת</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="ריהוט" id="furniture" onclick="insertCheckbox()">
                                <label for="furniture">מרוהטת</label>
                            </div>
                            <div class="check_box">
                                <input type="checkbox" value="משופצת" id="cosher_kitchen" onclick="insertCheckbox()">
                                <label for="cosher_kitchen">מטבח כשר</label>
                            </div>
                            
                            <input type="hidden" name="check_boxes" id="checkboxesStr">
                        </div>

                        <div class="bottom_inputs">

                            <div class="bottom_container">
                                <!-- floor input -->
                                <div style="display: flex; flex-direction: row;">
                                    <div class="input">
                                        <label for="min_floor"><i class="fa-solid fa-stairs"></i> קומה</label>
                                        <input type="number" id="min_floor" name="min_floor"  placeholder="מ-">
                                    </div>
                                    <div class="input">
                                        <input type="number" id="max_floor" name="max_floor" placeholder="עד-" style="transform: translateY(52%);">
                                    </div>
                                </div>
                                <!-- size input -->
                                <div style="display: flex; flex-direction: row;">
                                    <div class="input">
                                        <label for="min_size"><i class="fa-solid fa-maximize"></i> גודל (במ"ר)</label>
                                        <input type="number" id="min_size" name="min_size"  placeholder="מ-">
                                    </div>
                                    <div class="input">
                                        <input type="number" id="max_size" name="max_size" placeholder="עד-" style="transform: translateY(52%);">
                                    </div>
                                </div>
                                <!-- date entrance input -->
                                <div class="input">
                                    <label for="entrance_date"><i class="fa-solid fa-calendar-check"></i> תאריך כניסה</label>
                                    <input type="date" id="entrance_date" name="entrance_date" >
                                </div>
                                <div class="input">
                                    <div class="submit_container">
                                        <button id="submitBtn2" name="submitBtn2" type="submit"><i class="fa-solid fa-magnifying-glass"></i> חיפוש</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div> 
                </div>
                
            </div>
        </form>

        <?php 
            include_once('../loginSystem/db.php');
            $queryExists = false;
            try{
                if(!isset($_GET) or empty($_GET)){
                    $assets_for_sale = "SELECT assets_info_table.*
                                        FROM assets_info_table
                                        WHERE sale_or_rent='sale'";
                    $assets_for_sale_run = mysqli_query($con, $assets_for_sale);
                    $index = 1;
                    echo "
                        <div class='assets_wrapper'>
                            <div class='for_sale_title'>
                                <h1>למכירה</h1>
                            </div>
                    ";
                    while($card = mysqli_fetch_array($assets_for_sale_run)){
                        if($card['sale_or_rent'] == 'sale'){
                            $background_path = '../images/title_icon.png';
                            for($i = 1; $i < 9; $i++){
                                if($card['file'.$i.'_path']){
                                    $background_path = $card['file'.$i.'_path'];
                                    break;
                                }
                            }
                            $price = "";
                            $symbol = "";
                            if($card['price'] > "" and $card['currency'] == 'shekel'){
                                $price = "מחיר: $card[price] ₪";
                                $symbol = "₪";
                            } elseif ($card['price'] > "" and $card['currency'] == 'dollar'){
                                $price = "מחיר: $card[price] $";
                                $symbol = "$";
                            }
                            echo "
                            <div class='asset_card sale' id=$card[id] onclick='window.location.href=`AssetPage.php?id=$card[id]`' style='background-image: url($background_path);"; if($index > $max_cards){echo "display: none;";} echo "'>
                                ";
                                if($isRegistered and strpos($card['email_likes'], $email)) { // TODO edit and add new like to email_likes column
                                    echo "<form class='unlikeForm' action='UnlikeCode.php' method='POST'> 
                                            <button class='unlikeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                } else {
                                    echo "<form class='likeForm' action='LikeCode.php' method='POST'>
                                            <button class='likeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                }
                                echo "
                                <div class='description'>
                                    <h4>$card[street] $card[house_number], $card[city]</h4>
                                    <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                                    <span>$price</span>
                                </div>
                            </div>             
                            ";
                            $index++;
                        }
                    }
                    echo "  <div class='pager_container'>
                                <div class='pagination'>
                                    <ul id='salePager'>

                                    </ul>
                                </div>
                            </div>

                    </div>";

                    $assets_for_rent = "SELECT assets_info_table.*
                                        FROM assets_info_table
                                        WHERE sale_or_rent='rent'";
                    $assets_for_rent_run = mysqli_query($con, $assets_for_rent);
                    $index = 1;
                    echo "
                        <div class='assets_wrapper'>
                            <div class='for_sale_title'>
                                <h1>להשכרה</h1>
                            </div>
                    ";
                    while($card = mysqli_fetch_array($assets_for_rent_run)) {
                        if($card['sale_or_rent'] == 'rent'){
                            $background_path = '../images/title_icon.png';
                            for($i = 1; $i < 9; $i++){
                                if($card['file'.$i.'_path']){
                                    $background_path = $card['file'.$i.'_path'];
                                    break;
                                }
                            }
                            $price = "";
                            $symbol = "";
                            if($card['price'] > "" and $card['currency'] == 'shekel'){
                                $price = "מחיר: $card[price] ₪";
                                $symbol = "₪";
                            } elseif ($card['price'] > "" and $card['currency'] == 'dollar'){
                                $price = "מחיר: $card[price] $";
                                $symbol = "$";
                            }
                            echo "
                            <div class='asset_card rent' id=$card[id] onclick='window.location.href=`AssetPage.php?id=$card[id]`' style='background-image: url($background_path);"; if($index > $max_cards){echo "display: none;";} echo "'>
                                ";
                                if($isRegistered and strpos($card['email_likes'], $email)) {
                                    echo "<form class='unlikeForm' action='UnlikeCode.php' method='POST'>
                                            <button class='unlikeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                } else {
                                    echo "<form class='likeForm' action='LikeCode.php' method='POST'>
                                            <button class='likeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                }
                                echo "<div class='description'>
                                    <h4>$card[street] $card[house_number], $card[city]</h4>
                                    <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                                    <span>$price</span>
                                </div>
                            </div>              
                            ";
                            $index++;
                        }
                    }
                    echo "
                        <div class='pager_container'>
                            <div class='pagination'>
                                <ul id='rentPager'>
                                    
                                </ul>
                            </div>
                        </div>

                    </div>";
                } else {
                    $queryExists = true;
                    $keysArr = ['sale_or_rent', 'city', 'asset_type', 'min_rooms', 'max_rooms', 'min_price', 'max_price', 'check_boxes', 'floor', 'max_floor', 'min_size', 'max_size', 'entrance_date'];
                    $checkboxes = [];
                    $assetTypes = [];
                    $parameters = [];
                    $i = 0;
                    $parking_station = false;

                    // set array of user's input parameters while arr's key is equal to db fields name
                    foreach($_GET as $key => $value) {
                        if(!empty($value)) {
                            
                            if($key == "check_boxes") {
                                $checkboxes = explode(",", $value);
                                unset($checkboxes[count($checkboxes) - 1]);
                                $parking_station = in_array("חניה", $checkboxes);
                            } else if($key == "asset_type") {
                                $assetTypes = explode(",", $value);
                                unset($assetTypes[count($assetTypes) - 1]);
                            } else {

                                $parameters[$keysArr[$i]]= trim($value);
                            }
                        }
                        $i++;
                    }
                    // $checkboxes = explode(",", $parameters);
                //   print_r($parameters);
                //   print_r($checkboxes);

                    /* BUILD SPECIFIC USER QUERY */

                    $asset_status_hebrew = "";
                    $actual_asset_status = "";
                    if(!isset($parameters['sale_or_rent']) or empty($parameters['sale_or_rent'])){
                        echo "השתבש";
                    }
                    if($parameters['sale_or_rent'] == 'sale') {
                        $asset_status_hebrew = "למכירה";
                        $actual_asset_status = "sale";
                    } else if ($parameters['sale_or_rent'] == 'rent') {
                        $asset_status_hebrew = "להשכרה";
                        $actual_asset_status = "rent";
                    }

                    
                    $userQ = "SELECT assets_info_table.*
                                FROM assets_info_table
                                WHERE ";
                    foreach($parameters as $key => $value) {
                        if ($key == 'min_price') {
                            $min_price = str_replace(',', '', $value);
                            $userQ = $userQ . " REPLACE(price, ',', '') >= $min_price  AND";
                            continue;
                        } else if ($key == 'max_price') {
                            $max_price = str_replace(',', '', $value);
                            $userQ = $userQ . " REPLACE(price, ',', '') <=  $max_price AND";
                            continue;
                        } else if ($key == 'min_rooms') {
                            $userQ = $userQ . " num_of_rooms >= $value AND";
                            continue;
                        } else if ($key == 'max_rooms') {
                            $userQ = $userQ . " num_of_rooms <= $value AND";
                            continue;
                        } else if ($key == 'floor') {
                            $userQ = $userQ . " floor >= $value AND";
                            continue;
                        } else if ($key == 'max_floor') {
                            $userQ = $userQ . " floor <= $value AND";
                            continue;
                        } else if ($key == 'min_size') {
                            $userQ = $userQ . " size_in_sm >= $value AND";
                            continue;
                        } else if ($key == 'max_size') {
                            $userQ = $userQ . " size_in_sm <= $value AND";
                            continue;
                        } else if ($key == 'entrance_date') {
                            $userQ = $userQ . " DATE(entrance_date) >= $value AND";
                            continue;
                        }
                        $userQ = $userQ . " $key LIKE '%$value%' AND";
                    }
                    if($parking_station){
                        $userQ = $userQ . " parking_station NOT LIKE '%ללא%' AND";
                    }
                    foreach($checkboxes as $key => $value) {
                        if($value == 'חניה'){
                            continue;
                        }
                        $userQ = $userQ . " check_boxes LIKE '%$value%' AND";
                    }
                    if(!empty($assetTypes)){
                        $userQ = $userQ . "(";
                    }
                    foreach($assetTypes as $key => $value) {
                        $userQ = $userQ . " asset_type LIKE '%$value%' OR";
                    }
                    // if last word in userQ is AND or OR then remove it
                    if (substr($userQ, strlen($userQ) - 3, strlen($userQ)) == 'AND') {

                        $userQ = substr($userQ, 0, strlen($userQ) - 3);
                    
                    } else if (substr($userQ, strlen($userQ) - 2, strlen($userQ)) == 'OR') {
                        
                        $userQ = substr($userQ, 0, strlen($userQ) - 2);
                        $userQ = $userQ . ")";
                        
                    }

                    
                    echo $userQ;

                    
                    if($_GET['sale_or_rent'] == $actual_asset_status){
                        $userQ_run = mysqli_query($con, $userQ);
                        $index = 1;
                        echo "
                        <div class='assets_wrapper'>
                            <div class='for_sale_title'>
                                <h1>$asset_status_hebrew</h1>
                            </div>
                        ";
                        while($card = mysqli_fetch_array($userQ_run)){
                            $background_path = '../images/title_icon.png';
                            for($i = 1; $i < 9; $i++){
                                if($card['file'.$i.'_path']){
                                    $background_path = $card['file'.$i.'_path'];
                                    break;
                                }
                            }
                            $price = "";
                            $symbol = "";
                            if($card['price'] > "" and $card['currency'] == 'shekel'){
                                $price = "מחיר: $card[price] ₪";
                                $symbol = "₪";
                            } elseif ($card['price'] > "" and $card['currency'] == 'dollar'){
                                $price = "מחיר: $card[price] $";
                                $symbol = "$";
                            }
                            echo "
                            <div class='asset_card query' id=$card[id] onclick='window.location.href=`AssetPage.php?id=$card[id]`' style='background-image: url($background_path);"; if($index > $max_cards){echo "display: none;";} echo "'>
                                ";
                                if($isRegistered and strpos($card['email_likes'], $email)) {
                                    echo "<form class='unlikeForm' action='UnlikeCode.php' method='POST'>
                                            <button class='unlikeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                } else {
                                    echo "<form class='likeForm' action='LikeCode.php' method='POST'>
                                            <button class='likeBtn' type='submit'><i class='fa-regular fa-heart'></i></button>
                                            <input type='hidden' name='type' value='asset'>
                                            <input type='hidden' name='type_id' value=$card[id]>
                                        </form>";
                                }
                                echo "<div class='description'>
                                    <h4>$card[street] $card[house_number], $card[city]</h4>
                                    <span>$card[asset_type], $card[num_of_rooms] חדרים, $card[size_in_sm] מ\"ר, קומה $card[floor] מתוך $card[max_floor].</span>
                                    <span>$price</span>
                                </div>
                            </div>             
                            ";

                            $index++;
                        }
                        if(mysqli_num_rows($userQ_run) < 1) {
                            echo "<h3>לא נמצאו תוצאות.</h3>";
                        }
                        echo "
                            <div class='pager_container'>
                                <div class='pagination'>
                                    <ul id='queryPager'>
                                        
                                    </ul>
                                </div>
                            </div>
                            
                        </div>";

                        

                    } else {
                        echo "השתבש 2";
                    }
                }

        } catch (Exception $e){
            echo $e->getMessage();
        } finally {
            mysqli_close($con);
        }
        ?>
        

        <!-- FOOTER SECTION -->
        <div class="footer-container">
            
            <div class="footer-links">
                <div class="footer-link-wrapper">
                    <div class="footer-link-items">
                        <h2>עלינו</h2>
                        <a href="../About/about_page.php">על גט אייג'נט</a>
                    </div>
                    
                    <div class="footer-link-items">
                        <h2>חשבון</h2>
                        <?php if(!$isRegistered){echo "<a href='../loginSystem/login_page.php'>התחבר</a>";}else{echo "<a href='../Accounts/account_page.php'>החשבון שלי</a>";} ?>
                        <a href="<?php echo $agent_link; ?>"> <?php echo $agent_profile_footer; ?> </a>
                    </div>
                    <div class="footer-link-items">
                        <h2>חיפושים</h2>
                        <a href="agentSearch.php">חיפוש סוכנים</a>
                        <a href="assetSearch.php">חיפוש נכסים</a>
                    </div>
                </div>
            </div>
            <section class="social-media">
                <div class="social-media-wrap">
                    <div class="footer-logo">
                        <a href="../index.php"><img src="../images/Logo.png" style="width: 60px;"></img></a>
                    </div>
                    <small class="website-rights">גט אייג'נט © 2022</small>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/Ronsh0111/" target="_blank"><i class="fa-brands fa-facebook-square"></i></a>
                        <a href="https://www.instagram.com/ronsharabii/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/ron-sharabi/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
            </section>
        </div>
        
        <script type="text/javascript" src="../PagerScript.js"></script>
        <script>



            var min_rooms = document.getElementById('min_rooms'),
                max_rooms = document.getElementById('max_rooms'),
                min_price = document.getElementById('min_price'),
                max_price = document.getElementById('max_price');

            // min_price.addEventListener('input', priceHandler(min_price));
            // max_price.addEventListener('input', priceHandler(max_price));

            function priceHandler(price_input){
                const LENGTH = price_input.target.value.length;
                var value = price_input.target.value;
                var str_num = "";

                if (LENGTH > 0){
                    for(var i = 0; i < LENGTH; i++){
                        if (value[i] == '0' || value[i] == '1' || value[i] == '2' || value[i] == '3' || value[i] == '4' || value[i] == '5' || value[i] == '6' || value[i] == '7' || value[i] == '8' || value[i] == '9'){
                            str_num += value[i];
                        }
                    }
                    var x = parseInt(str_num);
                    if(!x){
                        x = "";
                    }
                    var str = x.toLocaleString("en-US");
    
                    return [x, str];
                }
            }
            // sync between min rooms to max rooms (min rooms cant be higher then max rooms)
            min_rooms.onchange = function(e){
                if(max_rooms.value){
                    max_rooms.value = e.target.value;
                }
                max_rooms.setAttribute('min', e.target.value);
            }
            // sync between min price to max price (min price cant be higher then max price)
            min_price.addEventListener('input', function(e){
                var ORIGIN_VALUE = priceHandler(e);
                e.target.value = ORIGIN_VALUE[1];
            });
            max_price.addEventListener('input', function(e){
                var ORIGIN_VALUE = priceHandler(e);
                max_price.value = ORIGIN_VALUE[1];
            });
            
            // asset types drop down boxes
            var checkList = document.getElementById('list1');
            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
                if (checkList.classList.contains('visible'))
                    checkList.classList.remove('visible');
                else
                    checkList.classList.add('visible');
            }
            var option, input, div;

            
            var cityInput = document.getElementById('city');

            // ENCODE PHP READ FILE (CITIES.TXT)
            var cities = <?php echo json_encode($filetext); ?>;
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
            });

            // ENCODE PHP READ FILE (ASSET_TYPES.TXT)
            var asset_types = <?php echo json_encode($asset_types_text); ?>;
            asset_types = asset_types.split("\n");
            // REMOVE UNWANTED CHARACTERS
            for ( var i = 0; i < asset_types.length - 1; i++ ) {
                asset_types[i] = asset_types[i].substr(0, asset_types[i].length-1);
            }

            // PUSH OPTIONS FROM asset_types array TO SELECT ASSET TYPE
            var types_list = document.getElementById('asset_type');
            asset_types.forEach( function(item){
                div = document.createElement('div');
                div.style.display = 'flex';
                div.style.flexDirection = 'row';
                div.style.alignItems = 'center';
                // div.style.direction = 'ltr';
                // div.style.textAlign = 'right';
                
                input = document.createElement('input');
                input.type = 'checkbox';
                input.id = item;
                input.onclick = insertTypes;
                option = document.createElement('label');
                option.value = item;
                option.innerHTML = item;
                option.setAttribute('for', item);
                types_list.appendChild(div);
                div.appendChild(input);
                div.appendChild(option);
            });

            // display and !display  function
            var advanced_search = document.getElementById('advanced_search');
            var adv_icn = document.getElementById('adv_icn');
            document.getElementById('advanced_btn').onclick = function(){
                if(advanced_search.style.display == 'block'){
                    advanced_search.style.display = 'none';
                    adv_icn.style.transform = 'rotate(90deg)';
                } else {
                    advanced_search.style.display = 'block';
                    adv_icn.style.transform = 'rotate(45deg)';
                }
            };

            // insert checkboxes
            var checkboxesParent = document.getElementById('checkboxesParent');
            var checkboxesStr = document.getElementById('checkboxesStr');
            function insertCheckbox(){
                checkboxesStr.value = "";

                var elements = checkboxesParent.getElementsByTagName('input');
                
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].type === 'checkbox' && elements[i].checked){
                        checkboxesStr.value += elements[i].value+",";
                    }
                }

                // console.log(checkboxesStr);
            }

            // insert types
            var typeStr = document.getElementById('typeStr');
            function insertTypes(){
                var elements = types_list.getElementsByTagName('input');
                typeStr.value = "";

                for(var i = 0; i < elements.length; i++){
                    if(elements[i].type === 'checkbox' && elements[i].checked){
                        typeStr.value += elements[i].id+",";
                    }
                }

                // console.log(typeStr);
            }
            
            

            var submitBtn = document.getElementById('submitBtn');
            submitBtn.onclick = function(e) {
                e.preventDefault();
                var status = document.getElementById('sale_or_rent');

                if(cityInput.value && !cities.includes(cityInput.value)){
                    alert('יש לבחור עיר קיימת ברשימה.')
                    return;
                } else if (status.value.length == 0) {
                    alert('יש לבחור סטטוס נכס.');
                    return;
                }
                document.getElementById("searchForm").submit();
            }

            var submitBtn2 = document.getElementById('submitBtn2');
            submitBtn2.onclick = function(e) {
                e.preventDefault();
                var status = document.getElementById('sale_or_rent');

                if(cityInput.value && !cities.includes(cityInput.value)){
                    alert('יש לבחור עיר קיימת ברשימה.')
                    return;
                } else if (status.value.length == 0) {
                    alert('יש לבחור סטטוס נכס.');
                    return;
                }
                
                document.getElementById("searchForm").submit();
            }

            // auto fill and check inputs from user's last inputs query
            var queryExists = <?php echo json_encode($queryExists); ?>;
            if(queryExists){
                var get = <?php print_r(json_encode($_GET)); ?>;
                console.log(get);
            }

            // pager
            const MAX_CARDS = <?php echo json_encode($max_cards) ?>;
            if(document.getElementById('salePager')){
                let numOfCards = document.querySelectorAll('.sale');
                let numOfPages = Math.ceil(numOfCards.length / MAX_CARDS);
                
                element("salePager", numOfPages, 1, "sale", MAX_CARDS);
            }
            if(document.getElementById('rentPager')){
                let numOfCards = document.querySelectorAll('.rent');
                let numOfPages = Math.ceil(numOfCards.length / MAX_CARDS);
                
                element("rentPager", numOfPages, 1, "rent", MAX_CARDS);
            }
            if(document.getElementById('queryPager')){
                let numOfCards = document.querySelectorAll('.query');
                let numOfPages = Math.ceil(numOfCards.length / MAX_CARDS);
                
                element("queryPager", numOfPages, 1, "query", MAX_CARDS);
            }

            // like form function
            var isRegistered = <?php echo json_encode($isRegistered); ?>;
            var likeBtn = document.querySelectorAll('.likeBtn');
            for(var i = 0; i < likeBtn.length; i++){
                likeBtn[i].onclick = function(e){likeFunction(e);};
            }
            function likeFunction(e){ 
                
                if(!isRegistered){
                    alert("על מנת לעשות פעולה זאת עליך להתחבר.");
                    e.preventDefault();
                    e.stopPropagation();
                }
                
            }
        </script>
    </body>
</html>