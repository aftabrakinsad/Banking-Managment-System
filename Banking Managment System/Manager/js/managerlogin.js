function loginpassCheck()
{ 
    var pvalue = document.getElementById("password").value;
   
    if(!pvalue)
    {   document.getElementById("passvalue").style.color = "red";
        document.getElementById('passvalue').innerHTML="Password is Empty";
        return false;
    }
    else if(pvalue.lengh<8)
    {  document.getElementById("passvalue").style.color = "green";
        document.getElementById('passvalue').innerHTML="Pass is Valid";
        return true;
    }
    else
    {document.getElementById("passvalue").style.color = "green";
        document.getElementById('passvalue').innerHTML="Pass is valid";
        return true;
    }
}

function checkusername()
{
    var namevalue = document.getElementById("username").value;
    if(!namevalue)
    { document.getElementById("nameerror").style.color = "red";
        document.getElementById("nameerror").innerHTML="Username Empty";
        return false;
    }
    else  if(!isNaN(namevalue))
    {document.getElementById("nameerror").style.color = "red";
        document.getElementById("nameerror").innerHTML="Username can't be a number";
        return false;
    }
     
    else   if( namevalue.length>10)
    {   document.getElementById("nameerror").style.color = "red";
        document.getElementById("nameerror").innerHTML="Enter Username Correctly";
        return false;
    }
    
    else
    {   document.getElementById("nameerror").style.color = "green";
        document.getElementById("nameerror").innerHTML="Username is Valid";
        return true;
    }
}

function formcheck()
{
    if(checkusername()==true && loginpassCheck()==true )
    {
        return true;
    }
    else
    {
        return false;
    }

}

function myAJAX()
{
    var accountno =document.getElementById("username").value;
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