//this remove an offer using an ajax
function delete_offres(id)
{
    form_data = new FormData();
    form_data.append("id", id);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=delAdv&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(form_data);
    return false;
}

//this remove an company using an ajax
function delete_company(id)
{
    form_data = new FormData();
    form_data.append("id", id);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=delCpn&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(form_data);
    return false;
}

//this remove an user using an ajax
function delete_user(id)
{
    form_data = new FormData();
    form_data.append("id", id);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=delUsr&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(form_data);
    return false;
}


//getAdvertisement
// This load the form to add an advertisement and show all advertisement.
function getAdvertisement (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getAdvertisement&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_advertisements_list').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//getCompanies
function getCompanies (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getCompanies&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_companies_list').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}


//getUser
function getUser (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_user_list').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//this add an company using an ajax
function addCompagny (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/create-compagny-gestion.php?options=addCompagny&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("compagny-form")));
    return false;
}

//this add an user using an ajax
function addSignIn (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/usrconnect-gestion.php?options=signInUser&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (this.responseText != "-1" && this.responseText != "-87" && this.responseText != "-89" && this.responseText != "-88")
            reload();
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

// This add an advertisements using an ajax
function addAdvertisements (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/offres-gestion.php?options=addAdv&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("advertisements-form")));
    return false;
}

//getAdvertisement
// This load the form to add an advertisement and show all advertisement.
function getAdvertisementF (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getAdvertisementF&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_advertisements_form').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//getCompanies
function getCompaniesF (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getCompaniesF&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_companies_form').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//getUser
function getUserF (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=getUserF&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('dashboard_user_form').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

function reload()
{
    getAdvertisementF();
    getCompaniesF();
    getUserF();
    getAdvertisement();
    getCompanies();
    getUser();
}

reload();
