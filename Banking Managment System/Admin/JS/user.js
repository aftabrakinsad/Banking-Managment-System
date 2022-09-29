function fnamecheck_adminregistration()
{
    var fname = document.getElementById("fname").value;

    if(!fname)
    {
        document.getElementById("fnameerr").style.color = "red";
        document.getElementById("fnameerr").innerHTML = "Enter your firstname";
        return false;
    }
    else if(!isNaN(fname))
    {
        document.getElementById("fnameerr").style.color = "red";
        document.getElementById("fnameerr").innerHTML = "Firstname can't be a number";
        return false;
    }
    else if(fname.length < 5)
    {
        document.getElementById("fnameerr").style.color = "red";
        document.getElementById("fnameerr").innerHTML = "Firstname must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
        document.getElementById("fnameerr").style.color = "green";
        document.getElementById("fnameerr").innerHTML = "Firstname formet ok";
        return true;
    }
}

function lnamecheck_adminregistration()
{
    var lname = document.getElementById("lname").value;

    if(!lname)
    {
        document.getElementById("lnameerr").style.color = "red";
        document.getElementById("lnameerr").innerHTML = "Enter your lastname";
        return false;
    }
    else if(!isNaN(lname))
    {
        document.getElementById("lnameerr").style.color = "red";
        document.getElementById("lnameerr").innerHTML = "Lastname can't be a number";
        return false;
    }
    else if(lname.length <  5)
    {
        document.getElementById("lnameerr").style.color = "red";
        document.getElementById("lnameerr").innerHTML = "Lastname must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
        document.getElementById("lnameerr").style.color = "green";
        document.getElementById("lnameerr").innerHTML = 
        "Lastname formet ok";
        return true;
    }
}

function usernamecheck_admin()
{
    var uname = document.getElementById("uname").value;

    if(!uname)
    {
        document.getElementById("nameerr").style.color = "red";
        document.getElementById("nameerr").innerHTML = "Enter your username";
        return false;
    }
    else if(!isNaN(uname))
    {
        document.getElementById("nameerr").style.color = "red";
        document.getElementById("nameerr").innerHTML = "username can't be a number";
        return false;
    }
    else if(uname.length < 5)
    {
        document.getElementById("nameerr").style.color = "red";
        document.getElementById("nameerr").innerHTML = "username must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
        document.getElementById("nameerr").style.color = "green";
        document.getElementById("nameerr").innerHTML = "username formet ok";
        return true;
    }
}

function email_adminregistration()
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

function nid_adminregistration()
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

function phone_adminregistration()
{
    var phonepatter = /^\+?(88)?0?1[3456789][0-9]{8}\b/;
    var phone = document.getElementById("phone").value;

    if(!phone)
    {
        document.getElementById("phoneerr").style.color = "red";
        document.getElementById("phoneerr").innerHTML = "Enter your phone number";
        return false;
    }
    else if(phone.length != 14)
    {
        document.getElementById("phoneerr").style.color = "red";
        document.getElementById("phoneerr").innerHTML = "Phone invalid";
        return false;
    }
    else if(isNaN(phone))
    {
        document.getElementById("phoneerr").style.color = "red";
        document.getElementById("phoneerr").innerHTML = "Invalid";
        return false;
    }
    else if(phone.match(phonepatter))
    {
        document.getElementById("phoneerr").style.color = "green";
        document.getElementById("phoneerr").innerHTML = "Valid OK";
        return true;
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

function pin_xd()
{
    var pin = document.getElementById("pin").value;
    if(!pin)
    {
        document.getElementById("pinerr").style.color = "red";
        document.getElementById("pinerr").innerHTML = "Enter your pin";
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

function password_adminregistration()
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

function confirm_password_adminregistration()
{
    var pass = document.getElementById("pass").value;
    var cpass = document.getElementById("cpass").value;

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
        document.getElementById("cpasserr").innerHTML = "password and confirm password is matched";
        return true;
    }
    else if(pass != cpass)
    {
        document.getElementById("cpasserr").style.color = "red";
        document.getElementById("cpasserr").innerHTML = "password and confirm password not matched";
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

function adduser_formcheck()
{
    if(fnamecheck_adminregistration() == true && lnamecheck_adminregistration() == true && usernamecheck_admin() == true &&     
    email_adminregistration() == true && nid_adminregistration()  == true && phone_adminregistration()  == true && accountno_addacc() == true && pin() == true && password_adminregistration() == true && confirm_password_adminregistration() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}