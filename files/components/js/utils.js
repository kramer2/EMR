$.fn.sm_hoverclass = function(hoverClass)
{
    var _this = this;

    function construct()
    {
        _this.each(function()
        {
            $(this).mouseover(function()
            {
                $(this).addClass(hoverClass);
            })
            .mouseout(function()
            {
                $(this).removeClass(hoverClass);
            });
        });
        return _this;
    }

    return construct();
}

function ErrorInfo(message)
{
    var _message = message;

    this.GetMessage = function() {
        return _message;
    }

    this.SetMessage = function(value) {
        _message = value;
    }
}

Object.extend = function(destination, source)
{
    for (var property in source)
        destination[property] = source[property];
    return destination;
};