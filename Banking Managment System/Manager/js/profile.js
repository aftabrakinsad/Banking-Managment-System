
function checkusername()
{
    var username = document.getElementById("uname").value;
    
    // if(empty(username))
    // {
    //     document.getElementById("unameerror").innerHTML="Username can't be empty";
    //     return false;
    // }
    // else 
    if(!username)
    {
        document.getElementById('unameerror').innerHTML="Username can't be empty";
        return false;
    }
    if(!isNaN(username))
    {
        document.getElementById('unameerror').innerHTML="First letter can't be a number";
        return false;
    }
    else if( username.lengh>8)
    {
        document.getElementById('unameerror').innerHTML="Username length less than 8";
        return false;
    }
    else if(username.search(/[a-z]/i) < 0)
    {
        document.getElementById('unameerror').innerHTML="Username must have small letters ";
        return false;
    }

    else if(username.search(/[0-9]/) < 0 )
    {
        document.getElementById('unameerror').innerHTML="Username must have numbers";
        return false;
    }
    else
    {
        document.getElementById('unameerror').innerHTML="Username Pattern Valid";
        return true;
    }

}



function validateemail()
{
    var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var email =document.getElementById("email").value;
    if(!email)
    {
        document.getElementById("emailvalue").innerHTML="Enter an Email";
        return false;
    }
    if(email.match(emailpattern))
    {
        document.getElementById("emailvalue").innerHTML="Email Pattern Valid";
        return true;
    }
    else
    {
        document.getElementById("emailvalue").innerHTML="Email Pattern invalid(ex:goru@anymail.com)";
        return false;
    }
}




function existuser()
{
    var username =document.getElementById("uname").value;
    var myxhttp = new XMLHttpRequest();

    myxhttp.onreadystatechange = function(){
if(this.readyState==4 && this.status ==200)

{
    document.getElementById("ajaxresponse").innerHTML=this.responseText;
}
    };
    myxhttp.open("POST","http://localhost/test/project/control/usernamecheck.php",true);
    myxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    myxhttp.send("username="+username);
}



function existemail()
{
    var email =document.getElementById("email").value;
    var myxhttp = new XMLHttpRequest();

    myxhttp.onreadystatechange = function(){
if(this.readyState==4 && this.status ==200)

{
    document.getElementById("ajaxemail").innerHTML=this.responseText;
}
    };
    myxhttp.open("POST","http://localhost/test/project/control/emailcheck.php",true);
    myxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    myxhttp.send("email="+email);
}

function formcheck()
{
    if(checkusername()==true && validateemail()==true)
    {
        return true;
    }
    else
    {
        return false;
    }

}