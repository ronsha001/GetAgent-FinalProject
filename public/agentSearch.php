<?php session_start();
    $isRegistered = false;
    $agent_profile = '<i class="fa-solid fa-plus"></i> צור פרופיל סוכן';
    $agent_profile_footer = 'צור פרופיל סוכן';
    $agency_profile = 'צור פרופיל סוכנות';
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
        if ($_SESSION['is_agent'] == 1) {
            $agent_link = '../agentsProfiles/agent_profile_page.php'; // TODO create agent page
            $agent_profile = 'פרופיל הסוכן שלי';
            $agent_profile_footer = 'פרופיל הסוכן שלי';
        } 
        if ($_SESSION['is_agency'] == 1) {
            $agency_link = '#'; // TODO create agency page
            $agency_profile = 'פרופיל הסוכנות שלי';
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

    $max_cards = 4;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="description" content="Get real estate agent / agency">
		<meta name="keywords" content="Get Agent real estate agency buy sell rent">
		<meta name="author" content="Ron Sharabi">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0,' name='viewport' />
        <link rel="icon" type="png" href="../images/title_icon.png">
        <script src="https://kit.fontawesome.com/ca3d7aca66.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <link rel="stylesheet" type="text/css" href="../Nav.css">
        <link rel="stylesheet" type="text/css" href="../Footer.css">
        <link rel="stylesheet" type="text/css" href="../TopSection.css">
        <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
        <link rel="stylesheet" type="text/css" href="../AgentCards.css">
        <link rel="stylesheet" type="text/css" href="../PagerStyle.css">
        <link rel="stylesheet" type="text/css" href="agentSearchStyle.css">

        <title>גט אייג'נט - חיפוש סוכנים</title>

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
        <form action="agentSearch.php" method="GET" id="searchForm" class="myForm">
            <div class="search_container">
                <div class="title">
                    <h2>איזה סוכנים תרצו לחפש?</h2>
                </div>

                <div class="top_inputs">
                    
                    <div class="input">
                        <label for="city"><i class="fa-solid fa-tree-city"></i> חפש בעיר</label>
                        <input type="text" name="city" list="cities" id="city" placeholder="לדוגמא: תל אביב יפו">
                        <datalist id="cities">
                            
                        </datalist>
                    </div>

                    <div class="input">
                        <label for="office_name"><i class="fa-solid fa-copyright"></i> שם המשרד/חברה</label>
                        <input type="text" name="office_name" id="office_name" placeholder='לדוגמא: רון נכסיי נדל"ן'>
                    </div>

                    <div class="input">
                        <label for="agent_name"><i class="fa-solid fa-user-tie"></i> שם הסוכן</label>
                        <input type="text" name="agent_name" id="agent_name" placeholder="לדוגמא: רון שרעבי">
                    </div>

                    <div class="input">
                        <div class="submit_container">
                            <button id="advanced_btn" type="button"><i id="adv_icn" class="fa-solid fa-plus"></i> חיפוש מתקדם</button>
                        </div>
                    </div>
                    <div class="input">
                        <div class="submit_container">
                            <button id="submitBtn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> חיפוש</button>
                        </div>
                    </div>

                </div>

                <div id="advanced_search" class="advanced_search">
                    <div class="bottom_inputs">
                        <div class="bottom_container">
                            <div class="input">
                                <label for="office_address"><i class="fa-solid fa-map-location-dot"></i> כתובת משרד</label>
                                <input type="text" name="office_address" id="office_address" placeholder="לדוגמא: ארלוזורוב 15 רעננה">
                            </div>

                            <div class="input">
                                <label for="min_exp_years"><i class="fa-solid fa-business-time"></i> מינימום שנות ניסיון</label>
                                <input type="number" name="min_exp_years" id="min_exp_years" min=0 placeholder="לדוגמא: 3">
                            </div>

                            <div class="input">
                                <label for="min_rank"><i class="fa-solid fa-ranking-star"></i> מינימום ממוצע ביקורות(0-5)</label>
                                <input type="number" name="min_rank" id="min_rank" min=0 max=5 step="0.1" placeholder="לדוגמא: 4.5">
                            </div>

                            <div class="input">
                                <label for="min_rent"><i class="fa-solid fa-house-circle-check"></i> מינימום נכסים להשכרה</label>
                                <input type="number" name="min_rent" id="min_rent" min=0 placeholder="לדוגמא: 4">
                            </div>

                            <div class="input">
                                <label for="min_sale"><i class="fa-solid fa-house-circle-check"></i> מינימום נכסים למכירה</label>
                                <input type="number" name="min_sale" id="min_sale" min=0 placeholder="לדוגמא: 14">
                            </div>

                        </div>
                    </div>
                </div>
            </div>    
        </form>

        <!-- AGENTS SECTION -->
        <div class="agents_wrapper">
            <div class="agents_container">
                <?php 
                
                    include_once("../loginSystem/db.php");
                    if(!isset($_GET) or empty($_GET)){
                        $search_agents = "SELECT agents_info_table.office_name, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, agents_info_table.logo_path, AVG(reviews_info_table.stars) as min_rank
                                            FROM agents_info_table
                                            LEFT JOIN reviews_info_table on agents_info_table.email = reviews_info_table.to_email
                                            GROUP BY agents_info_table.email
                                            ORDER BY min_rank DESC";
                        $search_agents_run = mysqli_query($con, $search_agents);
                        $index = 1;
                        while($agent = mysqli_fetch_array($search_agents_run)) {
                            $picture_path = substr($agent['logo_path'], 3, strlen($agent['logo_path']));
                            $cities = str_replace(",", ", ", $agent['agent_cities']);

                            echo "
                                <div class='agent_card query'"; if($index > $max_cards){echo "style='display: none;'";} echo">
                                    <div class='agent_top_card'>
                                        <div class='agent_pic_container'>
                                            <img src=../$picture_path onclick='window.location.href=`AgentProfile.php?email=$agent[email]`' alt=agent_pic>
                                        </div>
                                        <div class='agent_top_details'>
                                            <a class='agent_title' href='AgentProfile.php?email=$agent[email]'>$agent[office_name]</a>
                                            <span class='agent_forsale'>נכסים למכירה: $agent[for_sale]</span>
                                            <span class='agent_forsale'>נכסים להשכרה: $agent[for_rent]</span>
                                            <span class='agent_forsale'>ממוצע דירוג לקוחות: $agent[min_rank]</span>
                                        </div>
                                    </div>
                                    <div class='agent_bottom_card'>
                                        <div class='agent_cities'>
                                            <div>
                                                <label>עריי פעילות:</label>
                                                <p class='title'>$cities</p>
                                            </div>
                                            <div>
                                                <label>צור קשר:</label>
                                                <p class='title'>$agent[phone_number]</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                            $index++;
                        }
                        echo "
                        <div class='pager_container'>
                            <div class='pagination'>
                                <ul id='queryPager'>
                                    
                                </ul>
                            </div>
                        </div>
                        ";

                    } else {
                        $keysArr = ['agent_cities', 'office_name', 'agent_name', 'office_address', 'years_of_exp', 'min_rank', 'for_rent', 'for_sale'];
                        $parameters = [];
                        $i = 0;
                        $addWhereQuery = false;
                        // set array of user's input parameters while arr's key is equal to db fields name
                        foreach($_GET as $key => $value) {
                            if(!empty($value)) {
                                if($key != 'min_rank' && $key != 'agent_name'){
                                    $addWhereQuery = true;
                                }
                                $parameters[$keysArr[$i]] = trim($value);
                            }
                            $i++;
                        }

                        

                        // build user's query
                        // TODO fix min_rank query
                        $calcReviewsAvg = false;
                        $queryContainsAgentName = false; $agentFullName = [];
                        if(array_key_exists('min_rank', $parameters) && array_key_exists('agent_name', $parameters)){
                            $userQ = "SELECT agents_info_table.office_name, agents_info_table.logo_path, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, AVG(reviews_info_table.stars) AS min_rank, accounts.first_name, accounts.last_name
                            FROM agents_info_table
                            LEFT JOIN reviews_info_table ON reviews_info_table.to_email = agents_info_table.email
                            LEFT JOIN accounts ON accounts.email = agents_info_table.email ";
                            $calcReviewsAvg = true;
                            $queryContainsAgentName = true;
                        } else if (array_key_exists('min_rank', $parameters)){
                            $userQ = "SELECT agents_info_table.office_name, agents_info_table.logo_path, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, AVG(reviews_info_table.stars) AS min_rank
                            FROM agents_info_table
                            LEFT JOIN reviews_info_table ON reviews_info_table.to_email = email ";
                            $calcReviewsAvg = true;
                        } else if(array_key_exists('agent_name', $parameters)){
                            $userQ = "SELECT agents_info_table.office_name, agents_info_table.logo_path, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, AVG(reviews_info_table.stars) AS min_rank, accounts.first_name, accounts.last_name
                            FROM agents_info_table
                            LEFT JOIN accounts ON accounts.email = agents_info_table.email
                            LEFT JOIN reviews_info_table ON reviews_info_table.to_email = agents_info_table.email ";
                            $queryContainsAgentName = true;
                        } else {
                            $userQ = "SELECT agents_info_table.office_name, agents_info_table.for_sale, agents_info_table.for_rent, agents_info_table.email, agents_info_table.agent_cities, agents_info_table.phone_number, agents_info_table.logo_path, AVG(reviews_info_table.stars) AS min_rank
                                        FROM agents_info_table
                                        LEFT JOIN reviews_info_table ON reviews_info_table.to_email = agents_info_table.email ";
                        }
                        if($addWhereQuery){
                            $userQ = $userQ . "WHERE ";
                        }

                        $paraLength = count($parameters);
                        $i = 1;
                        foreach($parameters as $key => $value) {
                            if($key == 'reviews_avg' or $key == 'min_rank'){
                                continue;
                            }
                            if($key == 'agent_name'){
                                $agentFullName = explode(' ', $value); // firstName lastName
                                continue;
                            }
                            if($key == 'for_sale' or $key == 'for_rent' || $key == 'years_of_exp'){
                                if($paraLength == $i){
                                    $userQ = $userQ . " $key >= $value ";
                                } else {
                                    $userQ = $userQ . " $key >= $value AND";
                                }
                                
                                continue;
                            }
                            if($paraLength == $i){
                                $userQ = $userQ . " $key LIKE '%$value%' ";
                            } else {
                                $userQ = $userQ . " $key LIKE '%$value%' AND";
                            }
                            $i++;
                        }

                        // if last word in userQ is AND or OR then remove it
                        if (substr($userQ, strlen($userQ) - 3, strlen($userQ)) == 'AND') {

                            $userQ = substr($userQ, 0, strlen($userQ) - 3);
                        
                        }

                        $userQ = $userQ . " GROUP BY agents_info_table.email ";
                        
                        // if user's query contains reviews avg then add the following string to the query
                        if($calcReviewsAvg) {
                            $userQ = $userQ . " HAVING $parameters[min_rank] <= min_rank ";
                            
                        }
                        if($queryContainsAgentName){
                            if($calcReviewsAvg) {
                                $userQ = $userQ . "AND ";
                            } else {
                                $userQ = $userQ . "HAVING ";
                            }
                            if(count($agentFullName) == 2){
                                $userQ = $userQ . "(first_name LIKE '%$agentFullName[0]%' AND last_name LIKE '%$agentFullName[1]%' OR last_name LIKE '%$agentFullName[0]%' AND first_name LIKE '%$agentFullName[1]%')";
                            } else if (count($agentFullName) == 1) {
                                $userQ = $userQ . "(first_name LIKE '%$agentFullName[0]%' OR last_name LIKE '%$agentFullName[0]%')";
                            }
                        }
                        $userQ = $userQ . " ORDER BY min_rank DESC";
                        
                        echo $userQ;

                        $userQ_run = mysqli_query($con, $userQ);
                        $index = 1;
                        while($agent = mysqli_fetch_array($userQ_run)) {
                            $picture_path = substr($agent['logo_path'], 3, strlen($agent['logo_path']));
                            $cities = str_replace(",", ", ", $agent['agent_cities']);

                            echo "
                                <div class='agent_card query'"; if($index > $max_cards){echo "style='display: none;'";} echo">
                                    <div class='agent_top_card'>
                                        <div class='agent_pic_container'>
                                            <img src=../$picture_path onclick='window.location.href=`AgentProfile.php?email=$agent[email]`' alt=agent_pic>
                                        </div>
                                        <div class='agent_top_details'>
                                            <a class='agent_title' href='AgentProfile.php?email=$agent[email]'>$agent[office_name]</a>
                                            <span class='agent_forsale'>נכסים למכירה: $agent[for_sale]</span>
                                            <span class='agent_forsale'>נכסים להשכרה: $agent[for_rent]</span>
                                            <span class='agent_forsale'>ממוצע דירוג לקוחות: $agent[min_rank]</span>
                                        </div>
                                    </div>
                                    <div class='agent_bottom_card'>
                                        <div class='agent_cities'>
                                            <div>
                                                <label>עריי פעילות:</label>
                                                <p class='title'>$cities</p>
                                            </div>
                                            <div>
                                                <label>צור קשר:</label>
                                                <p class='title'>$agent[phone_number]</p>
                                            </div>
                                        </div>
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
                        ";
                        
                    }
                    mysqli_close($con);
                ?>
            </div>
        </div>
        

        <!-- FOOTER SECTION -->
        <div class="footer-container">
            <section class="footer-subscription">
                <p class="footer-subscription-heading">
                    הצטרף לניוזלטר כדי לקבל את העדכונים החדשים שלנו
                </p>
                <p class="footer-subscription-text">
                    ניתן לבטל את המנוי בכל עת.
                </p>
                <div class="input-areas">
                    <form action="#" method="POST">
                        <input type="email" name="email" placeholder="אימייל" class="footer-input">
                        <input type="submit" class="subscribe-btn" value="הירשם">
                    </form>
                </div>
            </section>
            <div class="footer-links">
                <div class="footer-link-wrapper">
                    <div class="footer-link-items">
                        <h2>עלינו</h2>
                        <a href="../About/about_page.php">על גט אייג'נט</a>
                        <a href="#">איך זה עובד</a>
                    </div>
                    <div class="footer-link-items">
                        <h2>צור קשר</h2>
                        <a href="#">צור איתנו קשר</a>
                        <a href="#">תמיכה</a>
                        <a href="#">המלצות</a>
                    </div>
                    <div class="footer-link-items">
                        <h2>חשבון</h2>
                        <?php if(!$isRegistered){echo "<a href='../loginSystem/login_page.php'>התחבר</a>";}else{echo "<a href='../Accounts/account_page.php'>החשבון שלי</a>";} ?>
                        <a href="<?php echo $agent_link; ?>"> <?php echo $agent_profile_footer; ?> </a>
                        <a href="#"> <?php echo $agency_profile; ?> </a>
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
                        <a href="#" target="_blank"><i class="fa-brands fa-facebook-square"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
            </section>
        </div>
        <script type="text/javascript" src="../PagerScript.js"></script>

        <script>
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

            // submit function
            var submitBtn = document.getElementById('submitBtn');
            var cityInput = document.getElementById('city');
            submitBtn.onclick = function(e) {
                e.preventDefault();

                if(cityInput.value && !cities.includes(cityInput.value)){
                    alert('יש לבחור עיר קיימת ברשימה.')
                    return;
                }
                document.getElementById("searchForm").submit();
            }

            // pager
            const MAX_CARDS = <?php echo json_encode($max_cards) ?>;
            
            let numOfCards = document.querySelectorAll('.agent_card');
            let numOfPages = Math.ceil(numOfCards.length / MAX_CARDS);
                
            element("queryPager", numOfPages, 1, "query", MAX_CARDS);
            
        </script>
    </body>
</html>