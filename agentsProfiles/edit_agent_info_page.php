<?php session_start();
    if (isset($_SESSION['verify_token']) and !empty($_SESSION['verify_token'])){
        $email = $_SESSION['email'];
        $token = $_SESSION['verify_token'];
        $picture_path = $_SESSION['picture_path'];
        $logo = $_SESSION['logo_path'];
        $agent_cities = $_SESSION['agent_cities'];
        $phone_number = $_SESSION['phone_number'];
        $birth_date = $_SESSION['birth_date'];
        $website_link = $_SESSION['website_link'];
        $office_address = $_SESSION['office_address'];
        $years_of_exp = $_SESSION['years_of_exp'];
        $about_agent = $_SESSION['about_agent'];
        $office_name = $_SESSION['office_name'];
        $license_year = $_SESSION['license_year'];
        $value = '';
        $type = 'hidden';
        if (isset($_SESSION['status']) and !empty($_SESSION['status'])){
            $value = $_SESSION['status'];
            $type = 'text';
        }
        $cities_arr = explode(",", $agent_cities); 
    } else {
        header("Location: ../loginSystem/login.php");
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
    <link rel="stylesheet" type="text/css" href="../ScrollBar.css">
    <link rel="stylesheet" type="text/css" href="edit_agent_info_page_style.css">

    <!--  Unicons CDN Link for Icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">

    

    <title>גט אייג'נט עריכת פרופיל סוכן</title>
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

    <!-- TOP SECTION - IMAGE -->
    <div class="top_container">
        <img src="../images/create_agent_background.jpg" visibility='hidden'>
    </div>
    <!-- INFO SECTION -->
    <div class="center">
        <div class="error">
            <input type="<?php echo $type ?>" value="<?php echo $value; unset($_SESSION['status']);; ?>" disabled>
        </div>

        <h1>עריכת פרופיל סוכן</h1>

        <form action="edit_agent_info_code.php" onkeydown="return event.key != 'Enter';" method="POST" enctype="multipart/form-data">
            <div class="logo_field">
                <div class="input_container">
                    
                    <div class="image_preview" id="image_preview_container">
                        <img src="" alt="Image Preview" class="image_preview__image">
                        <span class="image_preview__default_text">תצוגה מקדימה של לוגו</span>
                    </div>

                    <div class="file_container">
                        <label class="custom_file_upload">
                            <input type="file" name="my_logo" id="my_logo" class="my_logo" accept="image/png, image/gif, image/jpeg, image/jpg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80.5 95.3" height="52" width="44" id='my_svg'><path d="M4.1 0L2.8.6l-.6.4-.7.3-.4.6-.4.5-.4.9-.3.6V91.5l.3.6.4.8.4.6.4.6.7.3.6.4c0 .5-1.2.5 37.2.5 36.9 0 37 0 37.5-.4l.7-.4c.4-.1 1.4-1.2 1.4-1.5l.4-.5c.5-.6.5.9.5-44.9 0-45.7 0-44.2-.5-44.8l-.4-.6c0-.2-1-1.3-1.4-1.4a2 2 0 0 1-.6-.3 2 2 0 0 0-.7-.4C76.5.1 5 0 4.1.1m73 3.1c.3.4.7.7.7.9v87.1c0 .2-.4.5-.8.8l-.7.6h-72a3 3 0 0 1-1.6-1.4l-.2-.5V4.6l.2-.5c.3-.5 1-1.2 1.5-1.4h72.2l.6.5m-65.4 6l-.7.4a2 2 0 0 1-.6.4c-.2 0-.4.3-.5.6l-.4.6c-.3.3-.3 2.3-.3 28.2 0 26.5 0 27.7.3 28.1l.4.7.5.5.6.4.3.3h59.5c.7 0 2-1.3 2.3-2v-56c-.2-.7-1.7-2-2.4-2.1h-59M70.2 12c.5.5.5-.2.4 27.6 0 25 0 26.3-.2 26.6-.4.6 1.6.6-29 .6-32 0-29.1.1-29.6-.8l-.2-.5V39.5c0-27.5 0-26.8.5-27.2.4-.5 0-.5 29.3-.4h28.5l.3.2m-31.4 8.3l-.9.4-.7.2c-.4 0-1.1.4-1.4.7l-.5.3-1 .8a182.9 182.9 0 0 1-1.5 2l-.5.8-.4 1.1c0 .5-.3 1.2-.4 1.5-.2.5-.2.9-.2 2 0 1 0 1.4.2 2l.4 1.4c.2 1 .2 1 .7 1.5l.4.8c0 .2.2.4.3.5l.5.5c.1.2.3.5.5.5l.4.4c0 .2.3.4.6.5l.6.5.8.4c.4 0 1 .3 1.3.5 1.1.5 3.5.5 4.4 0a7 7 0 0 1 1.2-.5l1-.4.4-.4c.3-.1.9-.6 1.3-1.2a28.5 28.5 0 0 1 1-1.2l.4-.5c.3-.4.6-1 .6-1.4l.4-1 .4-.8v-2.1c0-2.1 0-2.1-.3-2.7l-.5-1.4c-.2-.7-.4-1-.6-1.2l-.3-.5a9.3 9.3 0 0 0-2.8-2.7c-.2-.3-.5-.4-1-.6-.4 0-1-.3-1.3-.5-.6-.3-2.7-.4-3.5-.2m2.8 3l1.4.4a113.6 113.6 0 0 0 1.8 1.6l.5.8c.2.1.4.5.5.8l.5 1c.3.5.3.5.3 2.2v1.7l-.4.6c-.1.3-.4.7-.4 1l-.4.5a3 3 0 0 0-.5.8c-.2.4-1 1.2-1.5 1.3l-.2.2c0 .8-5.2.9-6 0l-.6-.4-.4-.3-.4-.5-.5-.7c0-.2-.2-.4-.4-.5-.2-.1-.3-.4-.5-1 0-.4-.3-1-.4-1.2-.3-.6-.3-2.5 0-3.1l.4-1.2.5-1c.2 0 .4-.3.4-.5.2-.4 1-1.3 1.5-1.6l.6-.4c.6-.5 2.6-.7 4.2-.4m4.8 19a2 2 0 0 0-1 .3 4 4 0 0 1-1 .4l-.9.4c-1 .7-3.4.7-4.8 0l-1.2-.5-.6-.3c-.7-.6-2-.5-2.7 0l-.7.4c-.2 0-.4.2-.6.4l-.6.5a16 16 0 0 0-4.3 4.7l-.6 1-.5.9a3 3 0 0 0-.4 1l-.4.8c-.2.2-.4.7-.6 1.5 0 .5-.3 1-.4 1.3-.2.3-.3.8-.5 1.8l-.4 2-.3 1.2v.7l.5.6c.7.7 1.3.7 1.7 0 .6-1.2.8-2 1-3.6a5 5 0 0 1 .5-1.7l.4-1.4c0-.4.2-.9.5-1.3.2-.3.4-.8.4-1.1l.5-1c.2-.1.4-.5.4-.7l.5-.8.4-.7.6-.8a41 41 0 0 1 2.3-2.3c1-.8 2.3-1.3 2.6-.9l.8.4c.3 0 .7.2 1 .4 1 .7 5.2.7 6.3 0l1-.5.6-.2c.5-.4 1.8 0 2.5.7l.6.5c.2 0 .4.3.5.5l.4.3.5.6c.1.2.3.5.5.5l.4.6.5.6.5 1.1.4.4c.2.2.3.6.4 1l.5 1 .4.7.5 1.7c.2.3.4.7.5 1.9l.4 1.7.4 1.3c.2 1.5 1.1 2 2 1.2.7-.7.7-2.1.1-3.6l-.4-1.7-.3-1.4a5 5 0 0 1-.7-1.7c0-.5-.2-.8-.4-1l-.5-1a4 4 0 0 0-.5-1.1l-.4-.8a3 3 0 0 0-.5-.8l-.4-.5-.5-.8-.7-.8a1 1 0 0 0-.3-.4c-.2 0-.3-.3-.5-.5 0-.2-.2-.4-.3-.4l-.5-.4-.9-.6-.8-.6c-.1-.2-.4-.4-.6-.4l-.6-.3c-.4-.4-1-.6-1.7-.5M21.6 77.3c-.4 0-.5.1-.8.5l-.4.4c-.3.2-.2 1.2.2 1.5l.4.6.2.3h18.1c21 0 19.7 0 20.4-.6 1-1 .4-2.5-1-2.7H21.7" fill-rule="evenodd"></path></svg>
                            <span>הוסף לוגו</span>
                        </label> 
                    </div>
                    <div class="help_container">
                        <small>גודל מקסימלי: 2MB</small>
                        <small>סוגי קבצים מותרים: png gid jpg jpeg</small>
                    </div>
                </div>
            </div>

            <!-- **************** -->
            <div class="elements_container">
                <div class="wrapper">
                    <div class="title">
                        <img src="../createProfiles/tags-solid.svg" alt="tag-icon">
                        <h2>עריי פעילות</h2>
                    </div>
                    <div class="content">
                        <p>הכנס לפחות עיר אחת</p>
                        <ul id="ul">
                            <input type="text" list="cities" id="input" autocomplete="off">
                            <datalist id="cities" class="cities">

                            </datalist>
                        </ul>
                    </div>
                    <div class="details">
                        <p>נותרו <span id="countTag">10</span> ערים</p>
                        <button type="button" id="insert_btn">הוסף עיר</button>
                    </div>
                </div>
                <input type="hidden" name="agent_cities" id="agent_cities">
            </div>
            <!-- ***************** -->
            <div class="new_btn_container">
                <div class="form">
                    <input type="text" name="office_name" value='<?php echo $office_name; ?>' class="form__input" autocomplete="off" required>
                    <label class="form__label">* שם המשרד</label>
                </div>
            </div>
            <div class="new_btn_container">
                <div class="form">
                    <input type="tel" name="phone_number" value="<?php echo $phone_number; ?>" class="form__input" minlength="9" autocomplete="off" required>
                    <label class="form__label">* טלפון</label>
                </div>
            </div>
            <div class="new_btn_container">
                <div class="form">
                    <input type="month" id="license_year" value="<?php echo $license_year; ?>" name="license_year" class="form__input" autocomplete="off" required>
                    <label class="form__label">* תאריך הוצאת הרישיון</label>
                </div>
            </div>
            <div class="new_btn_container">
                <div class="form">
                    <input type="date" id="birth_date" value="<?php echo $birth_date; ?>" name="birth_date" class="form__input" min='1900-01-01' autocomplete="off" required>
                    <label class="form__label">* תאריך לידה</label>
                </div>
            </div>

            <div class="new_btn_container">
                <div class="form">
                    <input type="url" name="website_link" value="<?php echo $website_link; ?>" class="form__input" autocomplete="off">
                    <label class="form__label">לינק לאתר</label>
                </div>
            </div>

            <div class="new_btn_container">
                <div class="form">
                    <input type="text" name="office_address" value="<?php echo $office_address; ?>" class="form__input" autocomplete="off">
                    <label class="form__label">כתובת משרד (רחוב מספר, עיר)</label>
                </div>
            </div>

            <div class="new_btn_container">
                <div class="form">
                    <input type="number" name="years_of_exp" value="<?php echo $years_of_exp; ?>" class="form__input" autocomplete="off" required>
                    <label class="form__label">* שנות ניסיון</label>
                </div>
            </div>
            
            <!-- <div class="description">
                <textarea name="about_agent" id="about_agent"  class="about_agent" placeholder="תיאור כללי, מומלץ להסביר באופן חופשי את המומחיות שלך, הניסיון שלך, שיטת מכירה וכו...">df</textarea>
            </div> -->

            <!-- The toolbar will be rendered in this container. -->
            <div id="toolbar-container"></div>

            <!-- This container will become the editable. -->
            <div id="description">
                <p id="about_agent_p"></p>
            </div>
            <input type="hidden" name="about_agent" id="about_agent">

            <input type="submit" name="submit" id="submit" value="ערוך פרופיל">
        </form>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/decoupled-document/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script> -->
    <script src="../createProfiles/city_tags.js" type="text/javascript"></script>
    <script src="../createProfiles/MaxDate.js" type="text/javascript"></script>
    <script>

        // ClassicEditor
        //     .create( document.querySelector( '#about_agent' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );

        
        
        
        const ul2 = document.getElementById("ul"),
        input2 = document.getElementById("input"),
        countTags2 = document.getElementById("countTag"),
        agent_cities2 = document.getElementById("agent_cities"),
        submitBtn2 = document.getElementById("submit"),
        about_agent_p = document.getElementById("about_agent_p"),
        description = document.getElementById("description"),
        about_agent = document.getElementById("about_agent");

        var cities_arr = <?php echo json_encode($cities_arr); ?>;
        about_agent_p.innerHTML = <?php echo json_encode($about_agent); ?>;
        

        DecoupledEditor
            .create( document.querySelector( '#description' ) )
            .then( editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                editor.model.document.on('change:data', (evt, data) => {
                    about_agent.value = editor.getData();
                });
            } )
            .catch( error => {
                console.error( error );
            } );

        
        function push_chosen_cities(already_chosen_cities){
            for(var city = 0; city < already_chosen_cities.length; city++){    
                if(cities.length < 10) { // if tags length is less than 10 then only add city
                    //city.split(',').forEach(city => { // splitting each city from comma (,)
                    if(options.includes(already_chosen_cities[city])){
                        cities.push(already_chosen_cities[city]); // adding each city inside array
                        agent_cities2.value = cities;
                        submitBtn2.disabled = false;
                        ul2.style.border = '2px solid #ff9001';
                        createTag();
                    }    
                    
                    //});
                }
                countTag();
            }
        }
        function countTag(){
            input2.focus();
            countTags2.innerText = maxTags - cities.length; // subtracting max value with tags length
        }
        function createTag(){
            // removing all li tags before adding so there will be no duplicates tags
            ul2.querySelectorAll("li").forEach(li => li.remove());

            cities.slice().reverse().forEach(city => {
                var liCity = `<li id="li"><i class="uit uit-multiply" onclick="remove(this, '${city}')"></i> ${city}</li>`;
                ul2.insertAdjacentHTML("afterbegin", liCity); // inserting or adding li inside ul tag
            })
        }

        push_chosen_cities(cities_arr);


        const my_logo = document.getElementById("my_logo"),
        image_preview_container = document.getElementById("image_preview_container"),
        image_preview__image = image_preview_container.querySelector(".image_preview__image"),
        previewDefaultText = image_preview_container.querySelector(".image_preview__default_text");
    
        my_logo.addEventListener("change", function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                previewDefaultText.style.display = "none";
                image_preview__image.style.display = "block";

                reader.addEventListener("load", function() {
                    image_preview__image.setAttribute("src", this.result);
                });

                reader.readAsDataURL(file);

            } else {
                previewDefaultText.style.display = null;
                image_preview__image.style.display = null;
                image_preview__image.setAttribute("src", "");
            }
        });
    </script>
</body>
</html>