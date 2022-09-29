function email_addsalary()
{
    var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var email = document.getElementById("email").value;

    if(!email)
    {
        document.getElementById("emailerr").style.color = "red";
        document.getElementById("emailerr").innerHTML = "Enter your email";
        return false;
    }
    else if(email.match(emailpattern))
    {
        document.getElementById("emailerr").style.color = "green";
        document.getElementById("emailerr").innerHTML = "Email Pattern Valid";
        return true;
    }
    else
    {
        document.getElementById("emailerr").style.color = "red";
        document.getElementById("emailerr").innerHTML = "Email Pattern invalid";
        return false;
    }
}

function nid_addsalary()
{
    var nid = document.getElementById("nid").value;

    if(!nid)
    {
        document.getElementById("niderr").style.color = "red";
        document.getElementById("niderr").innerHTML = "Enter your nid";
        return false;
    }
    else if(nid.length == 8 && !isNaN(nid))
    {
        document.getElementById("niderr").style.color = "green";
        document.getElementById("niderr").innerHTML = "NID formet is valid";
        return true;
    }
    else
    {
        document.getElementById("niderr").style.color = "red";
        document.getElementById("niderr").innerHTML = "NID must contain 8 numaric value";
        return false;
    }
}

function pin()
{
    var pin = document.getElementById("pin").value;

    if(!pin)
    {
        document.getElementById("pinerr").style.color = "red";
        document.getElementById("pinerr").innerHTML = "Enter your PIN";
        return false;
    }
    else if(pin.length == 4 && !isNaN(pin))
    {
        document.getElementById("pinerr").style.color = "green";
        document.getElementById("pinerr").innerHTML = "Account no. formet is valid";
        return true;
    }
    else
    {
        document.getElementById("pinerr").style.color = "red";
        document.getElementById("pinerr").innerHTML = "Account no. must contain 4 numaric value";
        return false;
    }
}

function addsalary_formcheck()
{
    if(email_addsalary() == true && nid_addsalary() == true &&pin() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}