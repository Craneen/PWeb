// this just get the form to modify something
function modify_form(formular, id) {
    if (document.getElementById("formular_div").getAttribute("class") == "hidden")
    {
        document.getElementById("formular_div").setAttribute("class", "formular-div show");
        form_data = new FormData();
        form_data.append("id", id);
        var xhr = new XMLHttpRequest();
        xhr.open("POST","function/gestion/dashboard-gestion.php?options=mod_"+formular);
        xhr.responseType = "text";
        xhr.onload = function() {
            if (this.status == 200)
            {
                reload();
                document.getElementById('formular_div').innerHTML = this.responseText;
            }
        }
        xhr.onerror = function(){}
        xhr.send(form_data);
        return false;
    }
    else
    document.getElementById("formular_div").setAttribute("class", "hidden");
}

// this send the modification form data to update them
function mod_db(formular) {
    form_data = new FormData(document.getElementById("mod_"+formular+"-form"));
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/dashboard-gestion.php?options=mod_db_"+formular);
    xhr.responseType = "text";
    xhr.onload = function() {
        if (this.status == 200)
        {
            reload();
        }
    }
    xhr.onerror = function(){}
    xhr.send(form_data);
    modify_form("", -1);
    return false;
}