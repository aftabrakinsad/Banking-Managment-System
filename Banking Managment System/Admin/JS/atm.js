function accountno_atm()
{
    var accountno = document.getElementById("accountno").value;
    if(!accountno)
    {
        document.getElementById("accountno_error").style.color = "red";
        document.getElementById("accountno_error").innerHTML = "Please enter account number";
        return false;
    }
    else if(isNaN(accountno))
    {
        document.getElementById("accountno_error").style.color = "red";
        document.getElementById("accountno_error").innerHTML = "Account No. must be integer value";
        return false;
    }
    else if(accountno.length != 7)
    {
        document.getElementById("accountno_error").style.color = "red";
        document.getElementById("accountno_error").innerHTML = "Account No. must be equal to 7 digits";
        return false;
    }
    else
    {
        document.getElementById("accountno_error").style.color = "green";
        document.getElementById("accountno_error").innerHTML = "Account No. is valid";
        return true;
    }
}

function amount_atm()
{
    var atm = document.getElementById("atm").value;
    if(!atm)
    {
        document.getElementById("amount_error").style.color = "red";
        document.getElementById("amount_error").innerHTML = "Please enter amount";
        return false;
    }
    else if(isNaN(atm))
    {
        document.getElementById("amount_error").style.color = "red";
        document.getElementById("amount_error").innerHTML = "Amount must be integer value";
        return false;
    }
    else if(atm > 20000)
    {
        document.getElementById("amount_error").style.color = "red";
        document.getElementById("amount_error").innerHTML = "You can't debit or credit more than 20000 BDT";
        return false;
    }
    else
    {
        document.getElementById("amount_error").style.color = "green";
        document.getElementById("amount_error").innerHTML = "Amount is ok to debit or credit";
        return true;
    }
}

function pin_atm()
{
    var pin = document.getElementById("pin").value;
    if(!pin)
    {
        document.getElementById("pin_error").style.color = "red";
        document.getElementById("pin_error").innerHTML = "Please enter your pin";
        return false;
    }
    else if(isNaN(pin))
    {
        document.getElementById("pin_error").style.color = "red";
        document.getElementById("pin_error").innerHTML = "Pin must be integer value";
        return false;
    }
    else if(pin.length != 4)
    {
        document.getElementById("pin_error").style.color = "red";
        document.getElementById("pin_error").innerHTML = "Pin must be equal to 4 digits";
        return false;
    }
    else
    {
        document.getElementById("pin_error").style.color = "green";
        document.getElementById("pin_error").innerHTML = "Pin formet is ok";
        return true;
    }
}

function formcheck_atm()
{
    if(accountno_atm() == true && amount_atm() == true && pin_atm() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}
