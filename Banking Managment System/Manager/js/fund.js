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


function checkaccountno()
{
    var accountno = document.getElementById("accountno").value;
    if(!accountno)
    {
        document.getElementById("account").innerHTML="Enter a valid account no";
        return false;
    }
    if(isNaN(accountno))
    {
        document.getElementById("account").innerHTML="Account Number can't be a Alphabet";
        return false;
    }
    
    
    else
    {
        document.getElementById("account").innerHTML="Account Number is correct";
        return true;
    }
}



function checkamount()
{
    var amount = document.getElementById("amount").value;
    if(!amount)
    {
        document.getElementById("amounter").innerHTML="Enter a valid Amount";
        return false;
    }
    if(isNaN(amount))
    {
        document.getElementById("amounter").innerHTML="Amount can't be a Alphabet";
        return false;
    }
    
    
    else
    {
        document.getElementById("amounter").innerHTML="Amount is correct";
        return true;
    }
}

function accountcheck()
{
    var accountno =document.getElementById("accountno").value;
    var myxhttp = new XMLHttpRequest();

    myxhttp.onreadystatechange = function(){
if(this.readyState==4 && this.status ==200)

{
    document.getElementById("accountcheck").innerHTML=this.responseText;
}
    };
    myxhttp.open("POST","http://localhost/Bankin%20Managment%20System/Manager/control/checkaccount.php",true);
    myxhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    myxhttp.send("accountno="+accountno);
}


function formcheck()
{
    if(checkamount()==true&& checkaccountno()==true &&passcheck()==true)
    {
        return true;
    }
    else
    {
        return false;
    }

}