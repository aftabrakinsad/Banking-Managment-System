function usernamecheck()
{
    var username = document.getElementById("username").value;

    if(!username)
    {

        document.getElementById("usererr").innerHTML = "Username is Empty";
        return false;
    }
    else if(!isNaN(username))
    {

        document.getElementById("usererr").innerHTML = "Username Formet Doesn't Match";
        return false;
    }
    else if(username.length > 8)
    {

        document.getElementById("usererr").innerHTML = "Username Formet Doesn't Match";
        return false;
    }
    else
    {

        document.getElementById("usererr").innerHTML = "Username formet ok";
        return true;
    }
}

function passwordcheck()
{
var Password =document.getElementById("Password").value;
if(!Password )
{
    document.getElementById("passerr").innerHTML = "password required";
    return false;
}
if( Password.lengh>8)
{
    document.getElementById('passerr').innerHTML="Password Formet Doesn't Match";
    return true;
}
if(Password.search(/[A-Z]/i) < 0)
{
    document.getElementById('passerr').innerHTML="Password Formet Doesn't Match";
    return false;
}

if(Password.search(/[0-9]/) < 0)
{
    document.getElementById('passerr').innerHTML="Password Formet Doesn't Match";
    return false;
}
if(Password.search(/[ @#$%^&*]/) < 0)
{
    document.getElementById('passerr').innerHTML="Password Formet Doesn't Match";
    return false;
}

else
{
    document.getElementById('passerr').innerHTML="Password Formet is Matched";
    return true;
}
}

function uname_AJAX()
{
    var username = document.getElementById("username").value;
    var unamexhttp = new XMLHttpRequest();
    unamexhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("unameajaxresponse").style.color = "steelblue";
            document.getElementById("unameajaxresponse").innerHTML = this.responseText;
        }
    };
    unamexhttp.open("POST", "http://localhost/Bankin%20Managment%20System/Employee/control/ajax.unamecheck.php", true);
    unamexhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    unamexhttp.send("username="+username);
}

function validlogin()
{
    if(usernamecheck() == true && passwordcheck() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}