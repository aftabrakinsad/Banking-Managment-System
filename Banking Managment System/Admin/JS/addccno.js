function email_addacc()
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

function nid_addacc()
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

function accountno_addacc()
{
    var accountno = document.getElementById("accountno").value;

    if(!accountno)
    {
        document.getElementById("accountnoerr").style.color = "red";
        document.getElementById("accountnoerr").innerHTML = "Enter your account no.";
        return false;
    }
    else if(accountno.length == 7 && !isNaN(accountno))
    {
        document.getElementById("accountnoerr").style.color = "green";
        document.getElementById("accountnoerr").innerHTML = "Account no. formet is valid";
        return true;
    }
    else
    {
        document.getElementById("accountnoerr").style.color = "red";
        document.getElementById("accountnoerr").innerHTML = "Account no. must contain 7 numaric value";
        return false;
    }
}

function addacc_formcheck()
{
    if(email_addacc() == true && nid_addacc() == true && accountno_addaccount() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}