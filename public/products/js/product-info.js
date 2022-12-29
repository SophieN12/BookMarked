const productInfoBtn =document.getElementById("info-btn");
const descBtn =document.getElementById("desc-btn");
const infoBoxes = document.getElementsByClassName("info-box");

descBtn.onclick = function() {
    infoBoxes[0].classList.add("show-box");
    infoBoxes[1].classList.remove("show-box");
    if (descBtn.className != "active-link"){
        descBtn.classList.add("active-link");
        productInfoBtn.classList.remove("active-link");
    }
}  
productInfoBtn.onclick = function() {
    infoBoxes[1].classList.add("show-box");
    infoBoxes[0].classList.remove("show-box");
    if (productInfoBtn.className != "active-link"){
        productInfoBtn.classList.add("active-link");
        descBtn.classList.remove("active-link");
    }
}

const writeReviewBtn=document.getElementById("write-review-btn");
const writeReviewDiv=document.getElementsByClassName("write-review-div");

let inputFields = document.querySelectorAll("#review-form input");
const messageDiv = document.getElementById("message");

const submitBtn = document.querySelector(".modal-footer .btn-primary");
submitBtn.addEventListener("click", function(e){
    if (inputFields[2].value == "" || inputFields[3].value == ""){
        e.preventDefault();
        messageDiv.innerHTML += '<div class="alert alert-danger" role="alert"> Please fill in all the necessary fields!</div>';
    }
})


