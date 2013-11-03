
function AbstractAdapder(fieldName)
{
    var _this = this;
    var _fieldName = fieldName;

    this.GetFieldName = function()
    {
        return _fieldName;
    }

    this.IsSetToDefault = function()
    {
        var name = _fieldName + '_def';
        var defCheckBox = document.getElementById(name);

        if (defCheckBox)
        {
            return defCheckBox.checked;
        }
        else
            return false;
    }

    this.IsSetToNull = function()
    {
        var name = _fieldName + '_null';
        var nullCheckBox = document.getElementById(name);
        if (nullCheckBox)
        {
            return nullCheckBox.checked;
        }
        else
            return false;
    }
}


function ComboBoxAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);
    var _this = this;

    var comboBoxInput = $('#' + name);
    var oldColor = comboBoxInput.css('backgroundColor');

    this.SetBackgroundColor = function(color)
    {
        comboBoxInput.css('backgroundColor', color);
    }

    this.ResetBackgroundColor = function()
    {
        comboBoxInput.css('backgroundColor', oldColor);
    }

    this.GetValue = function()
    {
        return comboBoxInput.val();
    }
}

function AutocompleteComboBoxAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);
    var _this = this;

    var selectorInput = $('#' + name + '_selector');
    var dropdown_button = selectorInput.parent('td').parent('tr').children('td:nth-child(2)');
    var oldColor = selectorInput.css('background-color');

    this.SetBackgroundColor = function(color)
    {
        selectorInput.css('background-color', color);
        dropdown_button.css('background-color', color);
        dropdown_button.attr('original-color', color);
    }

    this.ResetBackgroundColor = function()
    {
        selectorInput.css('background-color', oldColor);
        dropdown_button.css('background-color', oldColor);
        dropdown_button.attr('original-color', oldColor);
    }

    this.GetValue = function()
    {
        return selectorInput.val();
    }
}


function CheckBoxGroup(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);
    var _this = this;

    this.SetBackgroundColor = function(color)
    {
    }

    this.ResetBackgroundColor = function()
    {
    }

    this.GetValue = function()
    {
        return 'dummy';
    }
}

function ImageEditorAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);

    this.SetBackgroundColor = function(color)
    {
    //editInput.style.backgroundColor = color;
    }

    this.ResetBackgroundColor = function()
    {

    }

    this.GetValue = function()
    {
        return 'dummy';
    }
}

function TextEditAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);
    var _this = this;
    var editInput = document.getElementById(name);
    if (editInput)
        var oldColor = editInput.style.backgroundColor;

    this.SetBackgroundColor = function(color)
    {
        if (editInput)
            editInput.style.backgroundColor = color;
    }

    this.ResetBackgroundColor = function()
    {
        if (editInput)
            editInput.style.backgroundColor = oldColor;
    }

    this.GetValue = function()
    {
        if (editInput)
            return editInput.value;
    }

}

function SpinEditAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);
    var _this = this;
    var spinEditInput = document.getElementById(name + '_Input');
    if (spinEditInput)
        var oldColor = spinEditInput.style.backgroundColor;

    this.SetBackgroundColor = function(color)
    {
        if (spinEditInput)
            spinEditInput.style.backgroundColor = color;
    }

    this.ResetBackgroundColor = function()
    {
        if (spinEditInput)
            spinEditInput.style.backgroundColor = oldColor;
    }

    this.GetValue = function()
    {
        if (spinEditInput)
            return spinEditInput.value;
    }
}

function CheckBoxEditAdapter(name, fieldName)
{
    this.parent = AbstractAdapder;
    this.parent(fieldName);

    this.SetBackgroundColor = function(color)
    {
    }

    this.ResetBackgroundColor = function()
    {
    }

    this.GetValue = function()
    {
        return 'dummy';
    }
}
