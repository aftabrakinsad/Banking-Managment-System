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
        document.getElementById("nameerr").innerHTML = "username's formet ok";
        return true;
    }
}

function passwordcheck_admin()
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

function uname_AJAX()
{
    var uname = document.getElementById("uname").value;
    var unamexhttp = new XMLHttpRequest();
    unamexhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("unameajaxresponse").style.color = "steelblue";
            document.getElementById("unameajaxresponse").innerHTML = this.responseText;
        }
    };
    unamexhttp.open("POST", "http://localhost/WT_Summer/Admin/Control/ajax.unamecheck.php", true);
    unamexhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    unamexhttp.send("uname="+uname);
}

function form_check_admin()
{
    if(usernamecheck_admin() == true && passwordcheck_admin() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}
