// This add an advertissements using an ajax
function addCompagny (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/create-compagny-gestion.php?options=addCompagny&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            if (this.responseText > 0)
            window.location.replace("index.php?pages=compagny");
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("compagny-form")));
    return false;
}


// This load the form to add an advertisement and show all advertissement.
function getComagnyCreationForm (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/create-compagny-gestion.php?options=getCompagnyCreationForm&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('form-container').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}


getComagnyCreationForm();
