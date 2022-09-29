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

function picture_adminregistration()
{
    var fileInput = document.getElementById("picture");
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if(!allowedExtensions.exec(filePath))
    {
        document.getElementById("imgerr").style.color = "red";
        document.getElementById("imgerr").innerHTML = "Please upload file having extensions .jpeg /.jpg/ .png only.";
        fileInput.value = '';
        return false;
    }
    else
    {
        document.getElementById("imgerr").style.color = "green";
        document.getElementById("imgerr").innerHTML = "Valid Image format";
        return true;
    }
}

function cv_adminregistration()
{
    var fileInput = document.getElementById("cv");
    var filePath = fileInput.value;
    var allowedExtensions = /(\.pdf)$/i;

    if(!allowedExtensions.exec(filePath))
    {
        document.getElementById("cverr").style.color = "red";
        document.getElementById("cverr").innerHTML = "Please upload file having extensions .pdf only.";
        fileInput.value = '';
        return false;
    }
    else
    {
        document.getElementById("cverr").style.color = "green";
        document.getElementById("cverr").innerHTML = "Valid CV format";
        return true;
    }
}

function email_AJAX()
{
    var email = document.getElementById("email").value;
    var emailxhttp = new XMLHttpRequest();
    emailxhttp.onreadystatechange = function()
    {
        if(emailxhttp.readyState == 4 && emailxhttp.status == 200)
        {
            document.getElementById("emailajaxresponse").style.color = "steelblue";
            document.getElementById("emailajaxresponse").innerHTML = emailxhttp.responseText;
        }
        else
        {

        }
    };
    emailxhttp.open("POST", "http://localhost/WT_Summer/Admin/Control/ajax.emailcheck.php", true);
    emailxhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emailxhttp.send("email="+email);
}

function registration_email_AJAX()
{
    var email = document.getElementById("email").value;
    var emailxhttp = new XMLHttpRequest();
    emailxhttp.onreadystatechange = function()
    {
        if(emailxhttp.readyState == 4 && emailxhttp.status == 200)
        {
            document.getElementById("emailajaxresponse").style.color = "steelblue";
            document.getElementById("emailajaxresponse").innerHTML = emailxhttp.responseText;
        }
        else
        {

        }
    };
    emailxhttp.open("POST", "http://localhost/WT_Summer/Admin/Control/ajax.emailcheck_registration.php", true);
    emailxhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emailxhttp.send("email="+email);
}

function registration_nid_AJAX()
{
    var nid = document.getElementById("nid").value;
    var nidxhttp = new XMLHttpRequest();
    nidxhttp.onreadystatechange = function()
    {
        if(nidxhttp.readyState == 4 && nidxhttp.status == 200)
        {
            document.getElementById("nidajaxresponse").style.color = "steelblue";
            document.getElementById("nidajaxresponse").innerHTML = nidxhttp.responseText;
        }
        else
        {

        }
    }
    nidxhttp.open("POST", "http://localhost/WT_Summer/Admin/Control/ajax.nidcheck_registration.php", true);
    nidxhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    nidxhttp.send("nid="+nid);
}

function registration_phone_AJAX()
{
    var phone = document.getElementById("phone").value;
    var phonexhttp = new XMLHttpRequest();
    phonexhttp.onreadystatechange = function()
    {
        if(phonexhttp.readyState == 4 && phonexhttp.status == 200)
        {
            document.getElementById("phoneajaxresponse").style.color = "steelblue";
            document.getElementById("phoneajaxresponse").innerHTML = phonexhttp.responseText;
        }
        else
        {

        }
    }
    phonexhttp.open("POST", "http://localhost/WT_Summer/Admin/Control/ajax.phonecheck_registration.php", true);
    phonexhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    phonexhttp.send("phone="+phone);
}

function form_check_adminregistration()
{
    if(fnamecheck_adminregistration() == true && lnamecheck_adminregistration() == true && usernamecheck_admin() == true &&     email_adminregistration() == true && nid_adminregistration()  == true && phone_adminregistration()  == true &password_adminregistration () == true && confirm_password_adminregistration() == true && picture_adminregistration() == true && cv_adminregistration() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}