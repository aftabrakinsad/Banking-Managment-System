function account_no()
{
    var accountno = document.getElementById("accountno").value;
    if(!accountno)
    {
        document.getElementById("account_no_error").innerHTML = "Please Enter account number";
        return false;
    }
    else if(isNaN(accountno))
    {
        document.getElementById("account_no_error").innerHTML = "Account No. must be Number value";
        return false;
    }
    else if(accountno.length != 7)
    {
        document.getElementById("account_no_error").innerHTML = "Account No. must be equal to 7 digits";
        return false;
    }
    else
    {
        document.getElementById("account_no_error").innerHTML = "Account No. is valid";
        return true;
    }
}

function transfer_amount()
{
    var fund = document.getElementById("fund").value;
    if(!fund)
    {
        document.getElementById("transfer_amount_error").innerHTML = "Please enter amount";
        return false;
    }
    else if(isNaN(fund))
    {
        document.getElementById("transfer_amount_error").innerHTML = "Amount must be integer value";
        return false;
    }
    else if(fund > 100000)
    {
        document.getElementById("transfer_amount_error").innerHTML = "Your sufficient balance is  100000 BDT";
        return false;
    }
    else
    {
        document.getElementById("transfer_amount_error").innerHTML = "Can Transfer";
        return true;
    }
}

function tranfer_pin()
{
    var pin = document.getElementById("pin").value;
    if(!pin)
    {

        document.getElementById("tranfer_pin_error").innerHTML = "Please enter your pin";
        return false;
    }
    else if(isNaN(pin))
    {
 
        document.getElementById("tranfer_pin_error").innerHTML = "Pin must be integer value";
        return false;
    }
    else if(pin.length != 4)
    {

        document.getElementById("tranfer_pin_error").innerHTML = "Pin must be equal to 4 digits";
        return false;
    }
    else
    {
        document.getElementById("tranfer_pin_error").innerHTML = "Pin formet is ok";
        return true;
    }
}

function formcheck_transfer()
{
    if(account_no() == true && transfer_amount() == true && tranfer_pin() == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}
