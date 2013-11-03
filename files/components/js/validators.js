function AbstractValidator(aMessage)
{
    var errorMessage = aMessage;

    this.GetErrorMessage = function() {
        return errorMessage;
    }
    
    this.SetErrorMessage = function(value) {
        errorMessage = value;
    }
}

function IntegerValidator(aMessage)
{
    this.parent = AbstractValidator;
    this.parent(aMessage);

    this.Validate = function(value)
    {
        return isInteger(value);
    }
}

function NotEmptyValidator(aMessage)
{
    this.parent = AbstractValidator;
    this.parent(aMessage);

    this.Validate = function(value)
    {
        return value != '';
    }
}

function UserDefinedValidator(aMessage)
{
    this.parent = AbstractValidator;
    this.parent(aMessage);

    this.DoValidate = function(value, errorInfo)
    {
    }
    
    this.Validate = function(value)
    {
        var result;
        var errorInfo = new ErrorInfo();
        result = this.DoValidate(value, errorInfo);
        if (!result)
            this.SetErrorMessage(errorInfo.GetMessage());
        return result;
    }
}
