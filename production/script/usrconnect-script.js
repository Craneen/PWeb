/* When the user clicks on the button,
   toggle between hiding and showing the dropdown content */
function DropDown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// this just show the connection form
function ShowForm() {
    document.getElementById("form-connexion").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
		openDropdown.classList.remove('show');
            }
        }
    }

    if (!(event.target.matches('.form-connect-div') || event.target.matches('.panda') || event.target.matches('.form_content'))
	&& document.getElementsByClassName("form-connect-div")[0].classList.contains("show") == true) {
        var dropdowns = document.getElementsByClassName("form-connect-div");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

// This sign in user account
function addSignIn (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=signInUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (this.responseText != "-1" && this.responseText != "-87" && this.responseText != "-89" && this.responseText != "-88")
		loadUserMenu();
            else if (this.responseText == -89)
		document.getElementById('error-display').innerHTML = "bop ton email existe déjà";
            else if (this.responseText == -87)
		document.getElementById('error-display').innerHTML = "bop ton email n'est pas valide";
            else if (this.responseText == -88)
		document.getElementById('error-display').innerHTML = "bop tes mots de passes ne correspondent pas";
            else
		document.getElementById('error-display').innerHTML =  "bop a eut une erreur serveur t'es pas aimé l'ami !";
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("sign-in-form")));
    return false;
}

// This add an user account
function signUp (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=signUpUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            //      alert(this.responseText);
            loadUserMenu();
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("sign-up-form")));
    return false;
}

//This load the sign in form for the menu
function GetSignIn()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=getSignInUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (document.body.contains(document.getElementById('form-sign-div')))
		document.getElementById('form-sign-div').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//This load the sign up form for the menu
function GetSignUp()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=getSignUpUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (document.body.contains(document.getElementById('form-sign-div')))
		document.getElementById('form-sign-div').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//This load the sign up form for the menu
function loadUserMenu()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=chargeMenu&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (document.body.contains(document.getElementById('user-menu')))
            {
                loadUserMenuDeroulant();
                document.getElementById('user-menu').innerHTML = this.responseText;
                GetSignUp();
                if(document.body.contains(document.getElementById('note-container')))
                    getAdvertissements();
            }

        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//This load the sign up form for the menu
function loadUserMenuDeroulant()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=chargeMenuDeroulant&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (document.body.contains(document.getElementById('user-menu')))
            {
                document.getElementById('myDropdown').innerHTML = this.responseText;
            }

        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}


//This disconnect the user
function disconnect()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=disconnect&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            loadUserMenu();
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}



// this just load advertissements must be placed in the offres.php
loadUserMenu();
