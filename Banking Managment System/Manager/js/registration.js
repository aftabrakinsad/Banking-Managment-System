
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






















function agecheck()
{
    var birthday = document.getElementById("dateofbirth").value;
    var dob = new Date(birthday); 
    var month_diff = Date.now() - dob.getTime();  
      
    //convert the calculated difference in date format  
    var age_dt = new Date(month_diff);   
      
    //extract year from date      
    var year = age_dt.getUTCFullYear();  
      
    //now calculate the age of the user  
    var age = Math.abs(year - 1970); 
    if(!age)
    {
        document.getElementById("ageerror").innerHTML="Age is empty";
        return false;
    }
    if(age>18)
    {
        document.getElementById("ageerror").innerHTML="Age is Ok";
        return true;
    }
    else
    {
        document.getElementById("ageerror").innerHTML= "Age is must be greater than 18";
        return false;
    }
}



function joiningcheck()
{var join = document.getElementById("doj").value;

if(!join)
{
    document.getElementById("joinerror").innerHTML= "Date of Joining is empty";
        return false;
}
else{document.getElementById("joinerror").innerHTML= "Date of Joining is Valid";
return true;}

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

function getradiovalue()
{
    if(document.getElementById("male").checked==true)
    {
        document.getElementById("radiovalue").innerHTML="You have selected Male";
        return true;
    }
    else if(document.getElementById("female").checked==true)
    {
        document.getElementById("radiovalue").innerHTML="You have selected Female";
        return true;
    }
    else if(document.getElementById("others").checked==true)
    {
        document.getElementById("radiovalue").innerHTML="You have selected others";
        return true;
    }
    else
    {
        document.getElementById("radiovalue").innerHTML="Please select a radio button";
       
        return false;

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

/*
function passcheck()
{/^[A-Za-z]\w{7,14}$/
    var pvalue =document.getElementById("pass").value;
    if(pvalue.length>8 && pvalue.length>1)
    {
        document.getElementById('passvalue').innerHTML="Pass is Invalid";
    }
    else
    {
        document.getElementById('passvalue').innerHTML="Pass is valid";
    }
}
*/

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

function confirmpasscheck()
{   var pvalue =document.getElementById("pass").value;
    var cvalue =document.getElementById("cpass").value;
    if(!cvalue)
    {
        document.getElementById('cpassvalue').innerHTML="Confrim pass is empty";
        return false;
    }

    if( cvalue.lengh>8)
    {
        document.getElementById('cpassvalue').innerHTML="Confrim pass is Valid";
        return true;
    }
    if(cvalue.search(/[a-z]/i) < 0)
    {
        document.getElementById('cpassvalue').innerHTML="Confirm Pass is Invalid";
        return false;
    }
    if(cvalue.search(/[0-9]/) < 0 )
    {
        document.getElementById('cpassvalue').innerHTML="Confirm Pass is Invalid";
        return false;
    }
    if(cvalue.search(/[^\w]/) < 0 )
    {
        document.getElementById('cpassvalue').innerHTML="Confirm Pass is Invalid";
        return false;
    }
    if(cvalue===pvalue)
    {
        document.getElementById('cpassvalue').innerHTML="Pass and Confirm pass match";
        return true;
    }
    if(cvalue!=pvalue)
    {
        document.getElementById('cpassvalue').innerHTML="Pass and Confirm pass does't match";
        return false;
    }
    else
    {
        document.getElementById('cpassvalue').innerHTML="Confirm Pass is valid";
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




function fileValidation() {
    var fileInput =
        document.getElementById('cv');
     
    var filePath = fileInput.value;
 
    // Allowing file type
    var allowedExtensions =
/(\.pdf)$/i;
     
    if (!allowedExtensions.exec(filePath)) {
        document.getElementById("fileerr").innerHTML = "Invalid file format(Only PDF Supported)";
        fileInput.value = '';
        return false;
    }
    else{
        document.getElementById("fileerr").innerHTML = "Valid file format";
        return true;
    }
}




function imgValidation() {
    var fileInput =
        document.getElementById('img');
     
    var filePath = fileInput.value;
 
    // Allowing file type
    var allowedExtensions =
    /(\.png|\.jpg|\.jpeg)$/i;
     
    if (!allowedExtensions.exec(filePath)) {
        document.getElementById("imgerr").innerHTML = "Invalid Image format(Only PNG, JPG, JPEG Supported)";
        fileInput.value = '';
        return false;
    }
    else{
        document.getElementById("imgerr").innerHTML = "Valid Image format";
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


function existnid()
{
    var nid =document.getElementById("nid").value;
    var myxhttp = new XMLHttpRequest();

    myxhttp.onreadystatechange = function(){
if(this.readyState==4 && this.status ==200)

{
    document.getElementById("ajaxnid").innerHTML=this.responseText;
}
    };
    myxhttp.open("POST","http://localhost/test/project/control/nidcheck.php",true);
    myxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    myxhttp.send("nid="+nid);
}



function formcheck()
{
    if(checkfirstname()==true && checklastname()==true &&checkfathername()==true &&checkmothername()==true &&checksalary()==true&&checkusername()==true && agecheck()==true
    && getradiovalue()==true &&validateemail()==true&&passcheck()==true&&confirmpasscheck()==true&&nidcheck()==true&&phonecheck()==true&&fileValidation()==true
    &&imgValidation()==true)
    {
        return true;
    }
    else
    {
        return false;
    }

}