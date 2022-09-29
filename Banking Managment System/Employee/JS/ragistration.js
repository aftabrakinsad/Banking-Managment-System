function checkfname()
{
    var fname = document.getElementById("fname").value;

    if(!fname)
    {
        document.getElementById("nameerror").innerHTML="Enter your firstname";
        return false;
    }
    else if(!isNaN(fname))
    {
        document.getElementById("nameerror").innerHTML = "Firstname can't be a number";
        return false;
    }
    else if(fname.length < 5)
    {
        document.getElementById("nameerror").innerHTML = "Firstname must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
        document.getElementById("nameerror").innerHTML = "Firstname formet ok";
        return true;
    }
}


function checklname()
{
    var lname = document.getElementById("lname").value;

    if(!lname)
    {
        document.getElementById("lnameerror").innerHTML="Enter your firstname";
        return false;
    }
    else if(!isNaN(lname))
    {
        document.getElementById("lnameerror").innerHTML = "Firstname can't be a number";
        return false;
    }
    else if(lname.length < 5)
    {
        document.getElementById("lnameerror").innerHTML = "Firstname must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
        document.getElementById("lnameerror").innerHTML = "Firstname formet ok";
        return true;
    }
}


function checkuname()
{
    var Username = document.getElementById("Username").value;

    if(!Username)
    {

        document.getElementById("usernameerr").innerHTML = "Enter your username";
        return false;
    }
    else if(!isNaN(Username))
    {
       
        document.getElementById("usernameerr").innerHTML = "username can't be a number";
        return false;
    }

    if(Username.search(/[A-Z]/g) < 0)
    {
        document.getElementById('usernameerr').innerHTML="usernameerr must be all upercse  ";
        return false;
    }
    else if(Username.length < 5)
    {
       
        document.getElementById("usernameerr").innerHTML = "username must be atleast lessthan equal to 5";
        return false;
    }
    else
    {
      
        document.getElementById("usernameerr").innerHTML = "username formet ok";
        return true;
    }
}


function validateemail()
{
    var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var Email =document.getElementById("Email").value;
    if(Email.match(emailpattern))
    {
        document.getElementById("emailvalue").innerHTML="Email Pattern Valid";
        return true;
    }
    else
    {
        document.getElementById("emailvalue").innerHTML="Email Pattern invalid";
        return false;
    }
}

function checknid()
{
    var NID = document.getElementById("NID").value;

    if(!NID)
    {

        document.getElementById("niderr").innerHTML = "Enter your nid";
        return false;
    }
    else if(NID.length == 10 && !isNaN(NID))
    {

        document.getElementById("NIDerr").innerHTML = "NID formet is valid";
        return true;
    }
    else
    {
        document.getElementById("niderr").innerHTML = "NID must contain 8 numaric value";
        return false;
    }
}

function checkphone()
{
    var phonepatter = /^\+?(88)?0?1[3456789][0-9]{8}\b/;
    var Phone = document.getElementById("phone").value;

    if(!Phone)
    {
        document.getElementById("phoneerrjs").innerHTML = "Enter your phone number";
        return false;
    }
    else if(Phone.length != 14)
    {
        document.getElementById("phoneerrjs").innerHTML = "Phone invalid";
        return false;
    }
    else if(isNaN(Phone))
    {
        document.getElementById("phoneerrjs").innerHTML = "Invalid";
        return false;
    }
    else if(Phone.match(phonepatter))
    {
        document.getElementById("phoneerrjs").innerHTML = "Valid OK";
        return true;
    }
}

function checkpassword()
{
    var Password =document.getElementById("Password").value;
    if(!Password )
    {
        document.getElementById("passworderr").innerHTML = "password required";
        return false;
    }
    if( Password.lengh>8)
    {
        document.getElementById('passworderr').innerHTML="Pass leanth mustbe more then 8 ";
        return true;
    }
    if(Password.search(/[A-Z]/g) < 0)
    {
        document.getElementById('passworderr').innerHTML="Pass must be all upercse and have spetiacal ";
        return false;
    }

    if(Password.search(/[0-9]/g) < 0)
    {
        document.getElementById('passworderr').innerHTML="Pass leanth mustbe more then 8";
        return false;
    }
    if(Password.search(/[ @#$%^&*]/) < 0)
    {
        document.getElementById('passworderr').innerHTML="Pass must be all upercse and have spetiacal";
        return false;
    }

    else
    {
        document.getElementById('passworderr').innerHTML="Pass is valid";
        return true;
    }
}


function checkconfirmpassword()
{
    var CPassword =document.getElementById("CPassword").value;
    if(!CPassword )
    {
        document.getElementById("Cpassworderr").innerHTML = "password required";
        return false;
    }
    if( CPassword.lengh>6)
    {
        document.getElementById('Cpassworderr').innerHTML="Pass is Valid";
        return true;
    }
    // if(CPassword.search(/[a-z]/i) < 0)
    // {
    //     document.getElementById('Cpassworderr').innerHTML="Pass is Invalid";
    //     return false;
    // }


    if(CPassword.search(/[0-9]/) < 0)
    {
        document.getElementById('Cpassworderr').innerHTML="CPass is Invalid";
        return false;
    }

    if(CPassword.search(/[ @#$%^&*]/) < 0)
    {
        document.getElementById('Cpassworderr').innerHTML="CPass must be all upercse and have spetiacal";
        return false;
    }


    else
    {
        document.getElementById('Cpassworderr').innerHTML="Pass is valid";
        return true;
    }
}

// function formcheck()
// {
//     if(checkfname()==true && checklname()==true && checkuname()==true &&validateemail()==true &&checknid()==true&&validateemail()==true && checkphone()==true  && checkpassword()==true  && checkconfirmpassword()==true)
//     {
//         return true;
//     }
//     else
//     {
//         return false;
//     }

// }

function uname_AJAX()
{
    var Username = document.getElementById("Username").value;
    var unamexhttp = new XMLHttpRequest();
    unamexhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("unameajaxresponse").style.color = "steelblue";
            document.getElementById("unameajaxresponse").innerHTML = this.responseText;
        }
    };
    unamexhttp.open("POST", "http://localhost/Bankin%20Managment%20System/Employee/control/ajax.unamecheckreg.php", true);
    unamexhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    unamexhttp.send("Username="+Username);
}


function Email_AJAX()
{
    var Email = document.getElementById("Email").value;
    var Emailxhttp = new XMLHttpRequest();
    Emailxhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("Emailajaxresponse").style.color = "steelblue";
            document.getElementById("Emailajaxresponse").innerHTML = this.responseText;
        }
    };
    Emailxhttp.open("POST", "http://localhost/Bankin%20Managment%20System/Employee/control/ajax.Emailcheckreg.php", true);
    Emailxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    Emailxhttp.send("Email="+Email);
}

function Phone_AJAX()
{
    var Phone = document.getElementById("Phone").value;
    var Phonexhttp = new XMLHttpRequest();
    Phonexhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("Phoneajaxresponse").style.color = "steelblue";
            document.getElementById("Phoneajaxresponse").innerHTML = this.responseText;
        }
    };
    Phonexhttp.open("POST", "http://localhost/Bankin%20Managment%20System/Employee/control/ajax.Phonecheckreg.php", true);
    Phonexhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    Phonexhttp.send("Phone="+Phone);
}

function NID_Ajex()
{
    var NID = document.getElementById("NID").value;
    var NIDxhttp = new XMLHttpRequest();
    Phonexhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("NIDajaxresponse").style.color = "steelblue";
            document.getElementById("NIDajaxresponse").innerHTML = this.responseText;
        }
    };
    NIDxhttp.open("POST","http://localhost/Bankin%20Managment%20System/Employee/control/ajax.NIDcheckreg.php", true);
    NIDxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    NIDxhttp.send("NID="+NID);
}