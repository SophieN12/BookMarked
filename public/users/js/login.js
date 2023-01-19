const loginButton = document.getElementById("loginBtn");
const fields = document.querySelectorAll("#login-form input");
const loginMessages = document.getElementById("loginMessages");

loginButton.addEventListener("click", function(e){
    if (fields[0].value.length === 0 || fields[1].value.length === 0){
        e.preventDefault();
        loginMessages.innerHTML = '<div class="alert alert-danger" role="alert"> Var god och fyll i alla fält!</div>';
    }
})

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const registerBtn = document.getElementById("createAccountBtn");
const registerFields = document.querySelectorAll("#create-account-form input");
const registerMessages = document.getElementById("registerMessages");
let registerErrorMessage = urlParams.get('message');

if(queryString.length > 0){
    if (queryString === "?emailDontExists"){
        $('#loginModal').modal('toggle')
        loginMessages.innerHTML = '<div class="alert alert-danger" role="alert"> E-postadressen du angav finns inte registrerad. Vänligen registrera dig. </div>';
    } if(queryString === "?wrongPassword"){
        $('#loginModal').modal('toggle')
        loginMessages.innerHTML = '<div class="alert alert-danger" role="alert"> Fel lösenord. Vänligen försök igen. </div>';
    } 
}

if (queryString.includes('?error')) {
    $('#registerModal').modal('toggle')
    registerMessages.innerHTML = '<div class="alert alert-danger" role="alert">' +registerErrorMessage + '</div>';
}

$('#loginModal').on('hide.bs.modal', resetParams)
$('#registerModal').on('hide.bs.modal', resetParams)

function resetParams() {
    let currentUrl = window.location.href;
    window.history.replaceState({}, "", currentUrl.split("?")[0]);
    loginMessages.innerHTML = '';
    registerMessages.innerHTML = '';
}

let closeAlertButton = document.getElementsByClassName('alert-close-btn');
closeAlertButton[0].addEventListener("click", resetParams);