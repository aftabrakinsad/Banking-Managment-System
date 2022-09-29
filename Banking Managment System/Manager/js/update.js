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
    else
    {
        document.getElementById('unameerror').innerHTML="Username Pattern Valid";
        return true;
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



function checkfirstname()
{
    var namevalue = document.getElementById("fname").value;
    if(!namevalue)
    {
        document.getElementById("ferror").innerHTML="Firstname can't be a empty";
        return false;
    }
    if(!isNaN(namevalue))
    {
        document.getElementById("ferror").innerHTML="Firstname can't be a number";
        return false;
    }
    
    
    else
    {
        document.getElementById("ferror").innerHTML="Firstname is correct";
        return true;
    }
}

function checklastname()
{
    var namevalue = document.getElementById("lname").value;
    if(!namevalue)
    {
        document.getElementById("lerror").innerHTML="Lastname can't be a empty";
        return false;
    }
    if(!isNaN(namevalue))
    {
        document.getElementById("lerror").innerHTML="Lastname can't be a number";
        return false;
    }
    
    
    else
    {
        document.getElementById("lerror").innerHTML="Lastname is correct";
        return true;
    }
}

function checkfathername()
{
    var namevalue = document.getElementById("fathername").value;
    if(!namevalue)
    {
        document.getElementById("fathererror").innerHTML="Name can't be empty";
        return false;
    }
    if(!isNaN(namevalue))
    {
        document.getElementById("fathererror").innerHTML="Name can't be a number";
        return false;
    }
    
  
    
    else
    {
        document.getElementById("fathererror").innerHTML="Name is correct";
        return true;
    }
}

function checkmothername()
{
    var namevalue = document.getElementById("mothername").value;
    if(!namevalue)
    {
        document.getElementById("mothererror").innerHTML="Name can't be a Empty";
        return false;
    }
    if(!isNaN(namevalue))
    {
        document.getElementById("mothererror").innerHTML="Name can't be a number";
        return false;
    }
    
    else
    {
        document.getElementById("mothererror").innerHTML="Name is correct";
        return true;
    }
}



function checksalary()
{
    var salary = document.getElementById("salary").value;
    if(!salary)
    {
        document.getElementById("salerror").innerHTML="Salary can't be empty";
        return false;
    }
    if(isNaN(salary))
    {
        document.getElementById("salerror").innerHTML="Salary salary must be numaric";
        return false;
    }
    else if(salary<10000 || salary>50000)
    {
        document.getElementById("salerror").innerHTML="Manager Salary Must be in Range of 10k-50k";
        return false;
    }
    
    else
    {
        document.getElementById("salerror").innerHTML="Salary is correct";
        return true;
    }
}


function addresscheck()
{var join = document.getElementById("street").value;

if(!join)
{
    document.getElementById("adderror").innerHTML= "Address is empty";
        return false;
}
else{document.getElementById("adderror").innerHTML= "Address is Valid";
return true;}

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


function passcheck()
{ 
    var pvalue =document.getElementById("pass").value;
    if(!pvalue)
    {
        document.getElementById('passvalue').innerHTML="Pass is empty";
        return false;
    }
    if( pvalue.lengh>8)
    {
        document.getElementById('passvalue').innerHTML="Pass is Valid";
        return true;
    }
    if(pvalue.search(/[a-z]/i) < 0)
    {
        document.getElementById('passvalue').innerHTML="Pass is Invalid";
        return false;
    }
    if(pvalue.search(/[0-9]/) < 0 )
    {
        document.getElementById('passvalue').innerHTML="Pass is Invalid";
        return false;
    }
    if(pvalue.search(/[^\w]/) < 0 )
    {
        document.getElementById('passvalue').innerHTML="Pass is Invalid";
        return false;
    }
    else
    {
        document.getElementById('passvalue').innerHTML="Pass is valid";
        return true;
    }
}



function nidcheck()
{
    var nid = document.getElementById("nid").value;

    if(!nid)
    {
        
        document.getElementById("niderr").innerHTML = "Enter your Nid";
        return false;
    }
    else if(nid.length == 7 && !isNaN(nid))
    {
        
        document.getElementById("niderr").innerHTML = "NID formet is valid";
        return true;
    }
    else
    {
        
        document.getElementById("niderr").innerHTML = "NID must contain last 7 numaric value";
        return false;
    }
}


function phonecheck()
{
    var phone = document.getElementById("phone").value;
    var pattern = /^[0-9]{5}-[0-9]{6}$/;

    if(!phone)
    {
        
        document.getElementById("phoneerr").innerHTML = "Enter your phone number";
        return false;
    }
    if(phone.match(pattern))
    {
        
        document.getElementById("phoneerr").innerHTML = "Phone number formet is valid";
        return true;
    }
    else
    {
        
        document.getElementById("phoneerr").innerHTML = "Phone number pattern doesn't match(ex=01518-39144)";
        return false;
    }
}





function formcheck()
{
    if(checkfirstname()==true && checklastname()==true &&checkfathername()==true &&checkmothername()==true &&checksalary()==true
    &&checkusername()==true 
     &&validateemail()==true&&passcheck()==true&&nidcheck()==true&&phonecheck()==true
    )
    {
        return true;
    }
    else
    {
        return false;
    }

}