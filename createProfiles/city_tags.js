const ul = document.getElementById("ul"),
input = document.getElementById("input"),
countTags = document.getElementById("countTag"),
agent_cities = document.getElementById("agent_cities"),
submitBtn = document.getElementById("submit");

submitBtn.disabled = true;

const maxTags = 10;
var cities = [];

var cities_options = document.getElementById('cities');
var options = ["אופקים", "אור יהודה", "אור עקיבא", "אילת", "אלעד", "אריאל"
                , "אשדוד", "אשקלון", "באר שבע", "בית שאן", "בית שמש", "ביתר עילית", "בני ברק", "בת ים",
                "גבעת שמואל", "גבעתיים", "דימונה", "הוד השרון", "הרצליה", "זכרון יעקב", "חדרה", "חולון", "חיפה",
                "טבריה", "טירת כרמל", "יבנה", "יהוד-מונוסון", "יפו", "יקנעם", "ירושלים", "כפר סבא", "כרמיאל", "לוד",
                "מגדל העמק", "מודיעין-מכבים-רעות", "מודיעין עילית", "מטולה", "מעלה אדומים", "מעלות-תרשיחא",
                "נהריה", "נס ציונה", "נצרת עילית", "נשר", "נתיבות", "נתניה", "עכו", "עפולה", "ערד", "פתח תקווה", "צפת",
                "קריית אונו", "קריית ארבע", "קריית אתא", "קריית ביאליק", "קריית גת", "קריית טבעון", "קריית ים", "קריית מלאכי",
                "קריית מוצקין", "קריית שמונה", "ראש העין", "ראש פינה", "ראשון לציון", "רחובות",
                "רמלה", "רמת גן", "רמת השרון", "רעננה", "שדרות", "תל אביב-יפו"
];
var clicked = false;

function countTag(){
    input.focus();
    countTags.innerText = maxTags - cities.length; // subtracting max value with tags length
}

function createTag(){
    // removing all li tags before adding so there will be no duplicates tags
    ul.querySelectorAll("li").forEach(li => li.remove());

    cities.slice().reverse().forEach(city => {
        var liCity = `<li id="li"><i class="uit uit-multiply" onclick="remove(this, '${city}')"></i> ${city}</li>`;
        ul.insertAdjacentHTML("afterbegin", liCity); // inserting or adding li inside ul tag
    })
}

function remove(element, tag){
    var index = cities.indexOf(tag); // getting removing tag index
    cities = [...cities.slice(0, index), ...cities.slice(index + 1)]; // removing or excluding selected tag from an array
    element.parentElement.remove(); // removing li of removed tag
    agent_cities.value = cities;
    if (agent_cities.value.length < 1){
        submitBtn.disabled = true;
        ul.style.border = '2px solid #ff3030';
    } else {
        submitBtn.disabled = false;
        ul.style.border = '2px solid #ff9001';
    }
    
    countTag();
}

function addTag(e){
    if(e.key == "Enter"){
        var city = e.target.value.replace(/\s+/g, ' ').trim(); // removing unwanted spaces from user city
        if(city.length > 1 && !cities.includes(city)){ // if city length is greater than 1 and the city isn't exist already
            if(cities.length < 10) { // if tags length is less than 10 then only add city
                //city.split(',').forEach(city => { // splitting each city from comma (,)
                if(options.includes(city)){
                    cities.push(city); // adding each city inside array
                    agent_cities.value = cities;
                    submitBtn.disabled = false;
                    ul.style.border = '2px solid #ff9001';
                    createTag();
                }    
                
                //});
            }
        }
        countTag();
        e.target.value = "";
    }
}

input.addEventListener("keyup", addTag);

const insertBtn = document.getElementById("insert_btn");
insertBtn.addEventListener("click", () => {
    // cities.length = 0; // making array empty
    // agent_cities.value = cities;
    // ul.querySelectorAll("li").forEach(li => li.remove()); // removing all li tags
    // countTag();
    var city = input.value.replace(/\s+/g, ' ').trim(); // removing unwanted spaces from user city
    if(city.length > 1 && !cities.includes(city)){ // if city length is greater than 1 and the city isn't exist already
        if(cities.length < 10) { // if tags length is less than 10 then only add city
            //city.split(',').forEach(city => { // splitting each city from comma (,)
            if(options.includes(city)){
                cities.push(city); // adding each city inside array
                agent_cities.value = cities;
                submitBtn.disabled = false;
                ul.style.border = '2px solid #ff9001';
                createTag();
            }    
                
            //});
        }
    }
    countTag();
    input.value = "";
});



options.forEach(function(item){ // for each variable in options array
    var option = document.createElement('option'); // create new option element
    option.value = item; // assign to the new element the variable from options array
    cities_options.appendChild(option); // append new option in cities (datalist)
});

function push_chosen_cities(already_chosen_cities){
    already_chosen_cities.forEach(city => function(){
        if(cities.length < 10) { // if tags length is less than 10 then only add city
            //city.split(',').forEach(city => { // splitting each city from comma (,)
            if(options.includes(city)){
                cities.push(city); // adding each city inside array
                agent_cities.value = cities;
                submitBtn.disabled = false;
                ul.style.border = '2px solid #ff9001';
                createTag();
            }    
            
            //});
        }
        countTag();
        e.target.value = "";
    });
    
}
