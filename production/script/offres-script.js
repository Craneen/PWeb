// This add an advertissements using an ajax
function addAdvertissements (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/offres-gestion.php?options=addAdv&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            getAdvertissements();
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("advertissements-form")));
    return false;
}

// This load the form to add an advertisement and show all advertissement.
function getAdvertissements (){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/offres-gestion.php?options=getAdv&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('note-container').innerHTML = this.responseText;
        }
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}


// this just scale up the element
function seeMore(needle_id) {
    if (document.getElementById(needle_id).getAttribute("class") == "note-div")
    {
        document.getElementById(needle_id).setAttribute("class", "test-animation");
        document.getElementById(needle_id+'_under').setAttribute("class", "test-animation_under");
    }
    else
    {
        document.getElementById(needle_id).setAttribute("class", "note-div");        
        document.getElementById(needle_id+'_under').setAttribute("class", "note-div-t");
    }
    
}

// this just permit an user to see the form to candidate
function postuler(form_id, off_id) {
    form_data = new FormData();
    form_data.append("number", form_id);
    form_data.append("offre", off_id);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/offres-gestion.php?options=showFormularCandidate&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            document.getElementById("tutut").innerHTML = this.responseText;
            document.getElementById("tutut").setAttribute("class", "show");        
        }
    }
    xhr.onerror = function(){}
    xhr.send(form_data);
    return false;
    
}

function clear_tutut()
{
    document.getElementById("tutut").innerHTML = "";
    document.getElementById("tutut").setAttribute("class", "hidden");        
}

// this just send the candidature
function addCandidature (form_id){
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=addCandidature&");
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            clear_tutut();
            getAdvertissements();
        }
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById(form_id)));
    return false;
}

getAdvertissements();
