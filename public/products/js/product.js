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

let inputFields = document.querySelectorAll("#review-form input");
const reviewMessageDiv = document.getElementById("reviewMessages");

const submitBtn = document.querySelector(".modal-footer .btn-primary");
submitBtn.addEventListener("click", function(e){
    if (inputFields[1].value == "") {
        e.preventDefault();
        reviewMessageDiv.innerHTML = '<div class="alert alert-danger" role="alert"> Du måste vara inloggad för att skriva en recension.</div>';
    }
    else if (inputFields[2].value == "" || inputFields[3].value == ""){
        e.preventDefault();
        reviewMessageDiv.innerHTML = '<div class="alert alert-danger" role="alert"> Please fill in all the necessary fields!</div>';
    } 
})

const ratingStars = [...document.getElementsByClassName("fa-star")];

function executeRating(stars) {
  const starClassActive = "fa-solid fa-star checked fa-lg";
  const starClassInactive = "fa-regular fa-star fa-lg";
  const starsLength = stars.length;

  let i;

  stars.map((star) => {
    star.onclick = () => {
      i = stars.indexOf(star);

      let value = parseInt(star.getAttribute("data-star"));
      document.getElementById("rating-input").value = value;

      if (star.className===starClassInactive) {
        for (i; i >= 0; --i) stars[i].className = starClassActive;
      } else {
        for (i; i < starsLength; ++i) stars[i].className = starClassInactive;
      }
    };
  });
}
executeRating(ratingStars);
