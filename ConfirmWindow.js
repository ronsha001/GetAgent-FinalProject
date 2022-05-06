
const windowWrapper = document.querySelector('.window_wrapper');
const delBtn = document.querySelector('.delBtn');
const cancelBtn = document.querySelector('.cancel');
const body = document.body;
// open or close confirm window when clicking on the delete btn
delBtn.onclick = function() {
    windowWrapper.style.display = 'block';
    body.style.overflow = 'hidden';
}
cancelBtn.onclick = function() {
    windowWrapper.style.display = 'none';
    body.style.overflowY = 'scroll';
}
