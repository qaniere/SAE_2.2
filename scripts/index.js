let isPillVisible = false
const PILL = document.getElementById("account-pill"); 
const PILL_CONTENT = document.getElementById("pill-content");

PILL.addEventListener("click", () => {

    if(window.innerWidth < 1024) {
        if(isPillVisible) {
            isPillVisible = false;
            PILL_CONTENT.style.display = "none";
            PILL.style.width = "10vw";
            PILL.style.borderRadius = "100%";
    
        } else {
    
            isPillVisible = true;
            PILL.style.width = "auto";
            PILL.style.borderRadius = "30px";
            PILL_CONTENT.style.display = "flex";
    
        }
    }
});
