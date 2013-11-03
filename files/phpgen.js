function expand(frameName, contentName, expandImageName, a)
{
    var nodeEl = document.getElementById(contentName);
    var expandImage = document.getElementById(expandImageName);

    if (nodeEl.className == 'hidden')
    {
        if (a && a.href != "javascript:;")
        {
            nodeEl.className = 'shown';
            nodeEl.innerHTML = 'Loading...';
            a.target = frameName;
            expandImage.src = 'images/collapse.gif';
        }
        else
        {
            nodeEl.className = 'shown';
            $('#' + contentName).slideDown();
            expandImage.src = 'images/collapse.gif';
        }

    }
    else
    {
        if (a)
            a.href = "javascript:;";
        $('#' + contentName).slideUp();
        nodeEl.className = 'hidden';
        expandImage.src = 'images/expand.gif';
    }
    return true;
}

function LoadDetail(node, content)
{
    contentControl = document.getElementById(node);
    contentControl.innerHTML = content.innerHTML;
    $('#' + node).hide();
    $('#' + node).slideDown();
    contentControl.className = 'shown';
}

function GetTextEditValue(formName, textEditName)
{
    var textEdit;
    if (formName)
        textEdit = document.forms[formName].elements[textEditName];
    else
        textEdit = document.getElementById(textEditName);
    return textEdit.value;
}


function AbstractValidator(aMessage)
{
    var errorMessage = aMessage;

    this.GetErrorMessage = function() {
        return errorMessage;
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

function CreateListByArray(valuesList)
{
    result = '';
    for(var i = 0; i < valuesList.length; i++)
        result = result + valuesList[i] + '<br/>'
    return result;
}
    
function SetCookie(name, stages)
{ 
    var time = new Date();
    time.setTime(time.getTime() + 30 * 24 * 60 * 60 * 1000);
    document.cookie = name + '=' + stages + '; expires=' + time.toGMTString() +'; path=/';
}
function GetCookie(name)
{
    var prefix = name + '=';
    var indexBeg = document.cookie.indexOf(prefix);
    if (indexBeg == -1)
        return false;
    var indexEnd = document.cookie.indexOf(';', indexBeg + prefix.length);
    if (indexEnd == -1)
        indexEnd = document.cookie.length;
    return unescape(document.cookie.substring(indexBeg + prefix.length, indexEnd));
}    
    
inputControlFocuced = false;
        
$(document).ready(function()
{    
    $('input').blur(function() {
        inputControlFocuced = false;
    });
    $('input').focus(function() {
        inputControlFocuced = true;
    });
});
            
function navigate_to(link)
{
    window.location.href = link;
}
    
function BindPageDecrementShortCut(prevPageLink)
{
    $(document).ready(function()
    {
        $(document).bind('keydown', 'Ctrl+left', function()
        {
            if (!inputControlFocuced)
                navigate_to(prevPageLink);
        });
    });
}
    
function BindPageIncrementShortCut(nextPageLink)
{
    $(document).ready(function()
    {
        $(document).bind('keydown', 'Ctrl+right', function()
        {
            if (!inputControlFocuced)
                navigate_to(nextPageLink);
        });
    });
}
    
function EnableHighlightRowAtHover(gridSelector)
{
    $(document).ready(function()
    {
        $(".grid tr.even").mouseover(function()
        {
            $(this).addClass("highlited");
        });
        $(".grid tr.odd").mouseover(function()
        {
            $(this).addClass("highlited");
        });
        $(".grid tr.odd").mouseout(function()
        {
            $(this).removeClass("highlited");
        });
        $(".grid tr.even").mouseout(function()
        {
            $(this).removeClass("highlited");
        });
    });
}

var highlightFunctions = new Array();
    
function HighlightTextInGrid(gridSelector, fieldName, text, opt, a_hint)
{
    var hint_text = '';
    if (a_hint)
        hint_text = a_hint;
        
    // highlightFunctions.push(function ()
    // {
    $(gridSelector + " tr td.even[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
        hint: hint_text
    });
    $(gridSelector + " tr td.odd[char=data][data-column-name='"+fieldName+"']").highlight(text, opt, {
        hint: hint_text
    });
// });
}
    
function ShowHighligthAllSearches()
{
    for(i = 0; i < highlightFunctions.length - 1; i++)
        highlightFunctions[i]();
}
    
function HideHighligthAllSearches()
{
    $('.grid td').removeHighlight();
}
    
function ToggleHighligthAllSearches(highlightAllLink)
{
    if (highlightAllLink.hasClass('pressed'))
    {
        HideHighligthAllSearches();
        highlightAllLink.removeClass('pressed');
    }
    else
    {
        ShowHighligthAllSearches();
        highlightAllLink.addClass('pressed');
    }
}



function SetupAutocomplete(inputName, handlerName)
{
    selectorId = "#" + inputName + "_selector";
    $(selectorId).autocomplete(
    {
        // TODO doesn't work when loaded from /demos/#autocomplete|remote
        source: "?hname=" + handlerName,
        minLength: 0,
        select:
        function(event, ui)
        {
            if (ui.item)
            {
                //alert('Select: ' + ui.item.id);
                $('#' + inputName).val(ui.item.id);
            }
            else
            {
                //alert('Select: (null)');
                $('#' + inputName).val('');
            }
        },
        change: function(event, ui)
        {
            if (ui.item)
            {
                //alert('change: ' + ui.item.id);
                $('#' + inputName).val(ui.item.id);
            }
            else
            {
                //alert('change: ' + '(null)');
                $('Close: #' + inputName).val('');
            }

        },
        open: function(event, ui)
        {
            var widget = $(selectorId).autocomplete("widget");
            widget.css('left', widget.offset().left - 3);
            widget.css('top', widget.offset().top - 2)
            widget.css('width', '260px');

        }

    });


    $("#" + inputName + "_container table td.dropdown_button_column")
    .attr('original-color', $("#" + inputName + "_container table td.dropdown_button_column").css('backgroundColor'));

    $("#" + inputName + "_container table td.dropdown_button_column").mouseover(
        function(){
            $(this).animate( {
                backgroundColor: '#aaa'
            }, 10);
        }
        ).mouseout(
        function(){
            $(this).animate( {
                backgroundColor: $(this).attr('original-color')
            }, 200);
        }
        ).click(
        function(){
            var input = $('#'+inputName+'_selector');

            if (input.autocomplete("widget").is(":visible"))
            {
                input.autocomplete("close");
                return;
            }

            input.autocomplete("search");
            input.focus();
        }
        );

}

$(function()
{
    $('.page_list').sm_navbar_section({collapsed: true});
});

$().ready(function()
{
    SetupAutocomplete('test_input_1', '')
});

function ApplyPageSize(container, link) {

    var value = container.find('input:checked').val();
    if (value == 'custom')
        value = container.find('.pgui-custom-page-size').val();
    window.location = jQuery.query.set("recperpage", value);

}

function GetPageCountForPageSize(pageSize, rowCount) {
    if (pageSize > 0)
        return Math.floor(rowCount / pageSize) +
            ((Math.floor(rowCount / pageSize) == (rowCount / pageSize)) ? 0 : 1);
    else 
        return 1;
}

function ShowOkDialog(title, text) 
{
    var dialogContent = $('<div>');
    dialogContent.css('display', 'none');
    dialogContent.addClass('pgui-ok-dialog-content');
    dialogContent.attr('title', title);

    var dialogText = $('<p>');
    dialogText.append('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>');
    dialogText.append(text);

    dialogContent.append(dialogText);

    $('body').append(dialogContent);


    dialogContent.dialog(
        {
            modal: true,
            buttons:
            {
                OK: function () {
                    $(this).dialog('close');
                }
            }
        }
    );
 }

function ShowYesNoDialog(title, text, yesAction, noAction) 
{
    var dialogContent = $('<div>');
    dialogContent.css('display', 'none');
    dialogContent.addClass('pgui-ok-dialog-content');
    dialogContent.attr('title', title);

    var dialogText = $('<p>');
    dialogText.append(text);

    dialogContent.append(dialogText);

    $('body').append(dialogContent);

    dialogContent.dialog(
        {
            modal: true,
            buttons:
            {
                No: function () {
                    $(this).dialog('close');
                    noAction();
                },
                Yes: function () {
                    $(this).dialog('close');
                    yesAction();
                }
            }
        }
    );
}