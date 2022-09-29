function password_change()
{
    var pass = document.getElementById("pass").value;

    if(!pass )
    {
        document.getElementById("passerr").style.color = "red";
        document.getElementById("passerr").innerHTML = "password required";
        return false;
    }
    else if(pass.length <= 8)
    {
        document.getElementById("passerr").style.color = "red";
        document.getElementById("passerr").innerHTML = "password must be greater than 8";
        return false;
    }
    else if(pass.search(/[A-Z]/) < 0)
    {
        document.getElementById("passerr").style.color = "red";
        document.getElementById("passerr").innerHTML = "password must contain atleast one uppercase letter";
        return false;
    }
    else if(pass.search(/[a-z]/) < 0)
    {
        document.getElementById("passerr").style.color = "red";
        document.getElementById("passerr").innerHTML = "password must contain atleast one lowercase letter";
        return false;
    }
    else if(pass.search(/[^\W]@/) < 0)
    {
        document.getElementById("passerr").style.color = "red";
        document.getElementById("passerr").innerHTML = "password must contain atleast one special character";
        return false;
    }
    else
    {
        document.getElementById("passerr").style.color = "green";
        document.getElementById("passerr").innerHTML = "password formet ok";
        return true;
    }
}

function confirm_password_change()
{
    var cpass = document.getElementById("cpass").value;
    var pass = document.getElementById("pass").value;

    if(!cpass )
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = "password required";
        return false;
    }
    else if(cpass.length <= 8)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = 
        "password must be greater than 8";
        return false;
    }
    else if(cpass.search(/[A-Z]/) < 0)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = 
        "password must contain atleast one uppercase letter";
        return false;
    }
    else if(cpass.search(/[a-z]/) < 0)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = 
        "password must contain atleast one lowercase letter";
        return false;
    }
    else if(cpass.search(/[^\W]@/) < 0)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = 
        "password must contain atleast one special character";
        return false;
    }
    else if(pass === cpass)
    {
        document.getElementById("cpasserr").style.color = "green";
        document.getElementById("cpasserr").innerHTML = "New password and confirm password is matched";
        return true;
    }
    else if(pass != cpass)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = "New password and confirm password not matched";
        return false;
    }
    else
    {
        document.getElementById("cpasserr").style.color = "green";
        document.getElementById("cpasserr").innerHTML = 
        "password formet ok";
        return true;
    }
}

function password_check()
{
    var pass = document.getElementById("pass").value;
    var cpass = document.getElementById("cpass").value;

    if(pass != cpass)
    {
        document.getElementById("matched").style.color = "red";
        document.getElementById("matched").innerHTML = "password not matched";
        return false;
    }
    else
    {
        document.getElementById("matched").style.color = "green";
        document.getElementById("matched").innerHTML = "password matched";
        return true;
    }
}

function change_password_formcheck()
{
    if(password_change() == true && confirm_password_change() == true && password_check() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}