function checkusername()
{
    var username = document.getElementById("username").value;
    if(!username)
    {
        document.getElementById("usernameerr").style.color = "red";
        document.getElementById("usernameerr").innerHTML = "Enter username to search";
        return false;
    }
    else if(username.length < 5)
    {
        document.getElementById("usernameerr").style.color = "red";
        document.getElementById("usernameerr").innerHTML = "Username must be more than 5 characters!";
        return false;
    }
    else
    {
        document.getElementById("usernameerr").style.color = "green";
        document.getElementById("usernameerr").innerHTML = "Username OK";
        return true;
    }
}

function firstname_admin_manage()
{
    var fname = document.getElementById("fname").value;
    
    if(!fname)
    {
        document.getElementById("fnameerr").style.color = "red";
        document.getElementById("fnameerr").innerHTML = "Enter firstname to update";
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
 function lastname_admin_manage()
 {
     var lname = document.getElementById("lname").value;
     if(!lname)
    {
        document.getElementById("lnameerr").style.color = "red";
        document.getElementById("lnameerr").innerHTML = "Enter lastname to update";
        return false;
    }
     if(!isNaN(lname))
     {
         document.getElementById("lnameerr").style.color = "red";
         document.getElementById("lnameerr").innerHTML = "Lastname can't be a number";
         return false;
     }
     else if(lname.length < 5)
     {
         document.getElementById("lnameerr").style.color = "red";
         document.getElementById("lnameerr").innerHTML = "Lastname must be atleast lessthan equal to 5";
         return false;
     }
     else
     {
         document.getElementById("lnameerr").style.color = "green";
         document.getElementById("lnameerr").innerHTML = "Lastname formet ok";
         return true;
     }
 }

function email_admin_manage()
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

function phone_admin_manage()
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
        document.getElementById("phoneerr").innerHTML = " Phone number must be 14 digits in total";
        return false;
    }
    else if(isNaN(phone))
    {
        document.getElementById("phoneerr").style.color = "red";
        document.getElementById("phoneerr").innerHTML = "Invalid Phone Number Pattern";
        return false;
    }
    else if(phone.match(phonepatter))
    {
        document.getElementById("phoneerr").style.color = "green";
        document.getElementById("phoneerr").innerHTML = "Valid Phone Number Format";
        return true;
    }
}

function salary_admin_manage()
{
    var salary = document.getElementById("salary").value;
    if(!salary)
    {
        document.getElementById("salaryerr").style.color = "red";
        document.getElementById("salaryerr").innerHTML = "Enter salary to update";
        return false;
    }
    else if(isNaN(salary))
    {
        document.getElementById("salaryerr").style.color = "red";
        document.getElementById("salaryerr").innerHTML = "Salary can't be a string";
        return false;
    }
    else if(salary < 500)
    {
        document.getElementById("salaryerr").style.color = "red";
        document.getElementById("salaryerr").innerHTML = "Starting salary can't be less than 500";
        return false;
    }
    else if(salary == 0)
    {
        document.getElementById("salaryerr").style.color = "red";
        document.getElementById("salaryerr").innerHTML = "Salary can't be 0";
        return false;
    }
    else if(salary.length > 7)
    {
        document.getElementById("salaryerr").style.color = "red";
        document.getElementById("salaryerr").innerHTML = "Salary Can't be more than 7 digits (1000000)";
        return false;
    }
    else
    {
        document.getElementById("salaryerr").style.color = "green";
        document.getElementById("salaryerr").innerHTML = "Salary formet OK";
        return true;
    }
}

function form_check_admin_manage()
{
    if(firstname_admin_manage() == true && lastname_admin_manage() == true && email_admin_manage() == true && phone_admin_manage() == true && salary_admin_manage() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}