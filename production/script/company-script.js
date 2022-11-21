//this remove an user from the company using an ajax
function remove_user_compagnie(id_user, id_company)
{
    form_data = new FormData();
    form_data.append("id_companies", id_company);
    form_data.append("id_user", id_user);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=delMember&");
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

//this add an user to the company using an ajax
function addMemberComp()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=addMember&");
    xhr.responseType = "text";
    xhr.onload = function() {
	if (this.status == 200)
	{
	    reload();
	}
    }
    xhr.onerror = function(){}
    xhr.send(new FormData(document.getElementById("add_member_company_form")));
    return false;
}

//this change role of an user from the company using an ajax
function changeRole (ngrade, id_user, id_company)
{
    form_data = new FormData();
    form_data.append("id_companies", id_company);
    form_data.append("id_user", id_user);
    form_data.append("grade", ngrade);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=changeGrade&");
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

//this load an company description
function chargeCompanyDesc()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=companyChargeDesc&");
    xhr.responseType = "text";
    xhr.onload = function() {
	if (this.status == 200)
	{
	    document.getElementById('company_info_div').innerHTML = this.responseText;
	}
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//this load userlist with ajax
function chargeListUser()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=chargePage&");
    xhr.responseType = "text";
    xhr.onload = function() {
	if (this.status == 200)
	{
	    document.getElementById('member_list_div').innerHTML = this.responseText;
	}
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//this load advertissements list with ajax
function chargeListAdvertissement()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=chargeAdvertissements&");
    xhr.responseType = "text";
    xhr.onload = function() {
	if (this.status == 200)
	{
	    document.getElementById('advertissement_list_div').innerHTML = this.responseText;
	}
    }
    xhr.onerror = function(){}
    xhr.send();
    return false;
}

//this change applicate
function changeApplicate(new_val, id_cand)
{

    form_data = new FormData();
    form_data.append("id", id_cand);
    form_data.append("applicate", new_val);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","function/gestion/company-gestion.php?options=changeApplicate&");
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


function reload()
{
    chargeListAdvertissement();
    chargeCompanyDesc();
    chargeListUser();
}

reload();
