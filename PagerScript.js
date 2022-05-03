// const ulTag = document.querySelector(".salePager");
// const ulTag2 = document.querySelector(".pager2");
// let totalPages = 20;

function element(ulClass, totalPages, page, cardType, MAX_CARDS) {
    
    const ulTag = document.getElementById(`${ulClass}`);
    let liTag = '';
    let activeLi;
    let beforePages = page - 1;
    let afterPage = page + 1;
    if(page > 1){ // if page value is greater than 1 then add new li which is previous button
        liTag += `<li class='btn prev' onclick='element("${ulClass}" ,${totalPages}, ${page - 1}, "${cardType}", ${MAX_CARDS})'><span>הקודם <i class='fas fa-angle-left'></i></span></li>`;
    }
    if(page > 2){ // if page value is greater than 2 add new li tag with 1 value
        liTag += `<li class='numb' onclick='element("${ulClass}" ,${totalPages}, 1, "${cardType}", ${MAX_CARDS})'><span>1</span></li>`;
        if(page > 3) { // if page value is greater than 3 then add new li tag with(...)
            liTag += `<li class='dots'><span>...</span></li>`;
        }
    }
    // how many pages or li show before the current li
    if(page == totalPages && page > 2 && totalPages > 4){ //if page value is equal to totalPages then substract by -2 to the beforePages value
        beforePages = beforePages - 2;
    } else if(page == totalPages - 1 && page > 1 && totalPages > 4){ // else if page value is equal to totalPages by -1 then substract by -1 to then beforePages value 
        beforePages = beforePages - 1;
    }
    // how many pages or li show after the current li
    if(page == 1 && totalPages > 4){ // if page value is equal to 1 then add by +2 to the afterPages value
        afterPage = afterPage + 2;
    } else if(page == 2 && totalPages > 4){ // else if page value is equal to 2 then add by +1 to the afterPage value
        afterPage = afterPage + 1;
    }

    for(let pageLength = beforePages; pageLength <= afterPage; pageLength++ ){
        if(pageLength == 0 || pageLength > totalPages){
            continue;
        }
        if(page == pageLength){ // if page value is equal to pageLength then assign the active string in the activeLi variable
            activeLi = "active";
        } else { // else leave empty to the activeLi variable
            activeLi = "";
        }
        liTag += `<li class='numb ${activeLi}' onclick='element("${ulClass}",${totalPages}, ${pageLength}, "${cardType}", ${MAX_CARDS})'><span>${pageLength}</span></li>`
    }

    if(page < totalPages - 1){ // if page value is less than totalPages by -1 then show the last li or page which is 20
        if(page < totalPages - 2) { // if page value is less than totalPages by -2 then show the last(...) before last page
            liTag += `<li class='dots'><span>...</span></li>`;
        }
        liTag += `<li class='numb' onclick='element("${ulClass}" ,${totalPages}, ${totalPages}, "${cardType}", ${MAX_CARDS})'><span>${totalPages}</span></li>`;
    }
    if(page < totalPages){ // if page value is less than totalPages value then add new li which is next button
        liTag += `<li class='btn next' onclick='element("${ulClass}" ,${totalPages}, ${page + 1}, "${cardType}", ${MAX_CARDS})'><span><i class='fas fa-angle-right'></i> הבא</span></li>`;
    }
    showElements(page, cardType, MAX_CARDS);
    ulTag.innerHTML = liTag;
}

function showElements(page, cardType, MAX_CARDS){
    const cardsArr = document.querySelectorAll("."+cardType); // specific card array to work on
    
    let cardToDelete = 0;
    for(let i = 0; i < (page * MAX_CARDS) - MAX_CARDS; i++){ // count how many cards to make invisible
        cardToDelete++;
    }
    if(page == 1) { // if user is on the first page
        for(let i = 0; i < cardsArr.length; i++){
            if(i >= MAX_CARDS){ // if card index is higher than MAX_CARDS then make this card invisible
                cardsArr[i].style.display = 'none';
            } else { // else make card visible
                cardsArr[i].style.display = 'block';
            }
        }
    } else { // else if user is not on the first page
        for(let i = 0; i < cardsArr.length; i++){
            if(i >= cardToDelete && i < (MAX_CARDS * page)) { // if card belong to this page then show page's specific cards only
                cardsArr[i].style.display = 'block';
            } else { // else make card visible
                cardsArr[i].style.display = 'none';
            }
        }
    }
        
}