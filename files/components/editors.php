<?php

require_once 'component.php';
require_once 'utils/file_utils.php';
require_once 'utils/string_utils.php';

class CustomEditor extends Component
{
    private $customAttributes;
    private $readOnly;
    private $superGlobals;

    public function __construct($name, $customAttributes = null)
    {
        parent::__construct($name);
        $this->customAttributes = $customAttributes;
        $this->readOnly = false;
        $this->superGlobals = GetApplication()->GetSuperGlobals();
    }

    protected function GetSuperGlobals()
    {
        return $this->superGlobals;
    }

    public function Accept($Renderer)
    {
        assert(false);
    }

    public function ExtractsValueFromPost(&$valueChanged)
    {
        $valueChanged = false;
        return '';
    }

    public function GetReadOnly() { return $this->readOnly; }
    public function SetReadOnly($value) { $this->readOnly = $value; }

    public function SetCustomAttributes($value) { $this->customAttributes = $value; }
    public function GetCustomAttributes() { return $this->customAttributes; }
}

class TextAreaEdit extends CustomEditor
{
    private $value;
    private $columnCount;
    private $rowCount;
    private $allowHtmlCharacters = true;
    
    public function __construct($name, $columnCount = null, $rowCount = null, $customAttributes = null)
    {
        parent::__construct($name, $customAttributes);
        $this->columnCount = $columnCount;
        $this->rowCount = $rowCount;
        $customAttributes = $customAttributes;
    }
    
    public function GetValue() { return $this->value; }
    public function SetValue($value) { $this->value = $value; }
    
    #region Editor options

    public function SetColumnCount($value) { $this->columnCount = $value; }
    public function GetColumnCount() { return $this->columnCount; }
    
    public function SetRowCount($value) { $this->rowCount = $value; }
    public function GetRowCount() { return $this->rowCount; }
    
    public function GetAllowHtmlCharacters() { return $this->allowHtmlCharacters; }
    public function SetAllowHtmlCharacters($value) { $this->allowHtmlCharacters = $value; }

    #endregion

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            $value = GetApplication()->GetPOSTValue($this->GetName());
            if (isset($value) && !$this->allowHtmlCharacters)
                $value = htmlspecialchars($value, ENT_QUOTES);
            return $value;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }
    
    public function Accept($renderer)
    {
        $renderer->RenderTextAreaEdit($this);
    }

    public function GetValueClientFunction()
    {
        return 'GetTextEditValue(null, ' . $this->GetName() . ')';
    }

    protected function GetJSControlAdapterClass()
    {
        return 'TextEditAdapter';
    }
}

class TextEdit extends CustomEditor
{
    private $value;
    private $size = null;
    private $maxLength = null;
    private $allowHtmlCharacters = true;
    private $passwordMode;

    public function __construct($name, $size = null, $maxLength = null, $customAttributes = null)
    {
        parent::__construct($name, $customAttributes);
        $this->size = $size;
        $this->maxLength = $maxLength;
        $this->passwordMode = false;
    }

    public function SetSize($value) { $this->size = $value; }
    public function GetSize() { return $this->size; }

    public function SetMaxLength($value) { $this->maxLength = $value; }
    public function GetMaxLength() { return $this->maxLength; }

    public function GetValue() { return $this->value; }
    public function SetValue($value) { $this->value = $value; }

    public function GetPasswordMode() { return $this->passwordMode; }
    public function SetPasswordMode($value) { $this->passwordMode = $value; }

    public function GetHTMLValue() { return str_replace('"', '&quot;', $this->value); }

    public function GetAllowHtmlCharacters() { return $this->allowHtmlCharacters; }
    public function SetAllowHtmlCharacters($value) { $this->allowHtmlCharacters = $value; }

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            $value = GetApplication()->GetPOSTValue($this->GetName());
            if (isset($value) && !$this->allowHtmlCharacters)
                $value = htmlspecialchars($value, ENT_QUOTES);
            return $value;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }
    
    public function Accept($Renderer)
    {
        $Renderer->RenderTextEdit($this);
    }

    public function GetValueClientFunction()
    {
        return 'GetTextEditValue(null, ' . $this->GetName() . ')';
    }

    protected function GetJSControlAdapterClass()
    {
        return 'TextEditAdapter';
    }
}

class SpinEdit extends CustomEditor
{
    private $value;
    private $useConstraints = false;
    private $minValue;
    private $maxValue;

    public function GetMaxValue() { return $this->maxValue; }
    public function SetMaxValue($value) { $this->maxValue = $value; }

    public function GetMinValue() { return $this->minValue; }
    public function SetMinValue($value) { $this->minValue = $value; }

    public function GetValue() { return $this->value; }
    public function SetValue($value) { $this->value = $value; }

    public function SetUseConstraints($value)
    {
        $this->useConstraints = $value;
    }

    public function GetUseConstraints()
    {
        return $this->useConstraints;
    }

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            return GetApplication()->GetPOSTValue($this->GetName());
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function Accept($Renderer)
    {
        $Renderer->RenderSpinEdit($this);
    }

    protected function GetJSControlAdapterClass()
    {
        return 'SpinEditAdapter';
    }
}

class CheckBox extends CustomEditor
{     
    private $value;
    
    public function GetValue() { return $this->value; }
    public function SetValue($value) { $this->value = $value; }
    
    public function ExtractsValueFromPost(&$valueChanged)
    {
        if ($this->GetReadOnly())
        {
            $valueChanged = false;
            return null;
        }
        else
        {
            $valueChanged = true;
            return GetApplication()->IsPOSTValueSet($this->GetName()) ? '1' : '0';
        }
    }

    public function Accept($renderer)
    {
        $renderer->RenderCheckBox($this);
    }
    
    public function Checked()
    {
        return (isset($this->value) && !empty($this->value));
    }
    
    protected function GetJSControlAdapterClass()
    {
        return 'CheckBoxEditAdapter';
    }        
}

class DateTimeEdit extends CustomEditor
{
    private $value;
    private $showsTime;
    private $format;
    private $firstDayOfWeek;

    public function __construct($name, $showsTime = false, $format = null, $firstDayOfWeek = 0)
    {
        parent::__construct($name);
        $this->showsTime = $showsTime;
        
        if (!isset($format))
            $this->format = $this->showsTime ? 'Y-m-d H:i:s' : 'Y-m-d';
        else
            $this->format = $format;
        $this->firstDayOfWeek = $firstDayOfWeek;
    }

    public function GetFirstDayOfWeek() 
    { 
        return $this->firstDayOfWeek; 
    }

    public function GetValue() 
    {
        if (isset($this->value))
            return $this->value->ToString($this->format); 
        else
            return '';
    }
    
    //TODO change parameter type to SMDateTime 
    public function SetValue($value) 
    { 
        if (!StringUtils::IsNullOrEmpty($value))
            $this->value = SMDateTime::Parse($value, $this->showsTime ? 'Y-m-d H:i:s' : 'Y-m-d'); 
        else
            $this->value = null;
    }

    public function GetFormat() { return DateFormatToOSFormat($this->format); }
    public function SetFormat($value) { $this->format = $value; }
    
    public function GetShowsTime() { return $this->showsTime; }
    public function SetShowsTime($value) { $this->showsTime = $value; }
    
    public function Accept($renderer)
    {
        $renderer->RenderDateTimeEdit($this);
    }
    
    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            $value = GetApplication()->GetPOSTValue($this->GetName());
            if ($value == '')
                return null;
            else
                return $value;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    /* public function ExtractsValueFromPost()
    {
        return GetApplication()->IsPOSTValueSet($this->GetName()) ? GetApplication()->GetPOSTValue($this->GetName()) : null;;
    } */

    public function GetValueClientFunction()
    {
        return 'GetTextEditValue(null, ' . $this->GetName() . ')';
    }

    protected function GetJSControlAdapterClass()
    {
        return 'TextEditAdapter';
    }
}    

class ComboBox extends CustomEditor
{
    private $values;
    private $selectedValue;
    private $emptyValue;
    //
    private $mfuValues;
    private $preparedMfuValues;
    private $displayValues;

    public function __construct($name, $emptyValue = '')
    {
        parent::__construct($name);
        $this->values = array();
        $this->selectedValue = null;
        $this->emptyValue = $emptyValue;
        $this->values[''] = $emptyValue;
        $this->displayValues = array();
        $this->mfuValues = array();
        $this->preparedMfuValues = null;
    }

    public function GetSelectedValue() { return $this->selectedValue; }
    public function SetSelectedValue($selectedValue) { $this->selectedValue = $selectedValue; }

    public function AddValue($value, $name) 
    {
        $this->values[$value] = $name;
        $this->displayValues[$value] = $name; 
    }
    
    public function GetValues() 
    { 
        return $this->values; 
    }

    public function GetDisplayValues()
    {
        return $this->displayValues;
    }

    public function ShowEmptyValue()
    {
        return true;
    }

    public function GetEmptyValue()
    {
        return $this->emptyValue;
    }

    public function AddMFUValue($value)
    {
        $this->mfuValues[] = $value;
    }

    private function PrepareMFUValues()
    {
        $this->preparedMfuValues = array();
        foreach($this->mfuValues as $mfuValue)
        {
            if (array_key_exists($mfuValue, $this->values))
                $this->preparedMfuValues[$mfuValue] = $this->values[$mfuValue];
            elseif (in_array($mfuValue, $this->values))
            {
                $key = array_search($mfuValue, $this->values);
                $this->preparedMfuValues[$key] = $mfuValue;
            }
        }
    }

    public function HasMFUValues()
    {
        return count($this->mfuValues) > 0;
    }

    public function GetMFUValues()
    {
        if ($this->HasMFUValues())
        {
            if (!isset($this->preparedMfuValues))
                $this->PrepareMFUValues();
            return $this->preparedMfuValues;
        }
        else
            return array();
    }

    public function GetValue() { return $this->selectedValue; }
    public function SetValue($value) { $this->selectedValue = $value; }

    protected function DoSetAllowNullValue($value)
    { 
        if ($value)
        {
            $this->values[''] = $this->emptyValue;
        }
        else
        {
            if (isset($this->values['']))
                unset($this->values['']);
        }
    }
    
    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            $value = GetApplication()->GetPOSTValue($this->GetName());
            if ($value == '')
                return null;
            else
                return $value;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function CanSetupNullValues()
    { return false; }

    public function Accept($Renderer)
    {
        $Renderer->RenderComboBox($this);
    }

    protected function GetJSControlAdapterClass()
    {
        return 'ComboBoxAdapter';
    }
}

class AutocomleteComboBox extends CustomEditor
{
    private $displayValue;
    private $handlerName;
    private $size;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->size = '260px';
    }

    public function GetDisplayValue() { return $this->displayValue; }
    public function SetDisplayValue($value) { $this->displayValue = $value; }

    public function GetValue() { return $this->selectedValue; }
    public function SetValue($value) { $this->selectedValue = $value; }

    #region Options

    public function GetSize()
    {
        return $this->size;
    }

    public function SetSize($value)
    {
        $this->size = $value;
    }

    #endregion

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if ($this->GetSuperGlobals()->IsPostValueSet($this->GetName()))
        {
            $valueChanged = true;
            return $this->GetSuperGlobals()->GetPostValue($this->GetName());
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function SetHandlerName($value)
    { 
        $this->handlerName = $value; 
    }

    public function GetHandlerName()
    { 
        return $this->handlerName; 
    }

    public function Accept($Renderer)
    {
        $Renderer->RenderAutocompleteComboBox($this);
    }

    protected function GetJSControlAdapterClass()
    {
        return 'AutocompleteComboBoxAdapter';
    }

    public function CanSetupNullValues()
    { 
        return true; 
    }

    public function GetSetToNullFromPost()
    { 
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
            return GetApplication()->GetPOSTValue($this->GetName()) == '';
        return true;
    }
}

class RadioEdit extends CustomEditor
{
    private $values;
    private $selectedValue;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->values = array();
        $this->selectedValue = null;
    }

    public function GetSelectedValue() { return $this->selectedValue; }
    public function SetSelectedValue($selectedValue) { $this->selectedValue = $selectedValue; }

    public function AddValue($value, $name) { $this->values[$value] = $name; }
    public function GetValues() { return $this->values; }

    public function GetValue() { return $this->selectedValue; }
    public function SetValue($value) { $this->selectedValue = $value; }

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            return GetApplication()->GetPOSTValue($this->GetName());
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function Accept($Renderer)
    {
        $Renderer->RenderRadioEdit($this);
    }

    protected function GetJSControlAdapterClass()
    {
        return 'ComboBoxAdapter';
    }
}

class CheckBoxGroup extends CustomEditor
{
    private $values;
    private $selectedValues;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->values = array();
        $this->selectedValues = array();
    }

    public function IsValueSelected($value) 
    {
        return in_array($value, $this->selectedValues); 
    }
    
    public function AddValue($value, $name) { $this->values[$value] = $name; }
    public function GetValues() { return $this->values; }
    
    public function GetValue()  
    { 
        $result = '';
        foreach($this->selectedValues as $selectedValue)
            AddStr($result, $selectedValue, ',');
        return $result;
    }
    
    public function SetValue($value) 
    { 
        $this->selectedValues = explode(',', $value); 
    }


    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            $valuesArray = GetApplication()->GetPOSTValue($this->GetName());
            $result = '';
            foreach($valuesArray as $value)
                AddStr($result, $value, ',');
            return $result;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }
    

    public function Accept($Renderer)
    {
        $Renderer->RenderCheckBoxGroup($this);
    }

    protected function GetJSControlAdapterClass()
    {
        return 'CheckBoxGroup';
    }     
}

class ImageUploader extends CustomEditor
{
    private $showImage;
    private $imageLink;
    
    public function __construct($name)
    {
        parent::__construct($name);
        $this->showImage = false;
    }

    public function GetShowImage() { return $this->showImage; }
    public function SetShowImage($value) { $this->showImage = $value; }

    public function GetLink() { return $this->imageLink; }
    public function SetLink($value) { $this->imageLink = $value; }

    public function ExtractImageActionFromPost()
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName() . "_action"))
            return GetApplication()->GetPOSTValue($this->GetName() . "_action");
        else
            return KEEP_IMAGE_ACTION;
    }

    public function ExtractsValueFromPost(&$valueChanged)
    {
        $action = $this->ExtractImageActionFromPost();

        if ($action == REMOVE_IMAGE_ACTION)
        {
            $valueChanged = true;
            return null;
        }
        elseif ($action == REPLACE_IMAGE_ACTION)
        {
            $filename = $_FILES[$this->GetName() . "_filename"]["tmp_name"];
            $valueChanged = true;
            return $filename;
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function ExtractFileTypeFromPost()
    {
        $action = $this->ExtractImageActionFromPost();
        
        if ($action == REMOVE_IMAGE_ACTION)
            return null;
        elseif ($action == REPLACE_IMAGE_ACTION)
        {
            $clientFileName = $_FILES[$this->GetName() . "_filename"]["name"];
            return Path::GetFileExtension($clientFileName);
        }
        else
            return null;
    }

    public function ExtractFileNameFromPost()
    {
        $action = $this->ExtractImageActionFromPost();

        if ($action == REMOVE_IMAGE_ACTION)
            return null;
        elseif ($action == REPLACE_IMAGE_ACTION)
        {
            $clientFileName = $_FILES[$this->GetName() . "_filename"]["name"];
            return Path::GetFileTitle($clientFileName);
        }
        else
            return null;
    }

    public function ExtractFileSizeFromPost()
    {
        $action =GetApplication()->GetPOSTValue($this->GetName() . "_action");
        $fileSize = $_FILES[$this->GetName() . "_filename"]["size"];
        
        if ($action == REMOVE_IMAGE_ACTION)
            return null;
        elseif ($action == REPLACE_IMAGE_ACTION)
            return $fileSize;
        else
            return null;
    }

    protected function GetJSControlAdapterClass()
    {
        return 'ImageEditorAdapter';
    }

    public function Accept($renderer)
    {
        $renderer->RenderImageUploader($this);
    }
}

class HtmlWysiwygEditor extends CustomEditor
{
    private $value;
    private $allowColorControls;

    public function __construct($name, $customAttributes = null)
    {
        parent::__construct($name, $customAttributes);
        $this->allowColorControls = false;
    }

    public function GetValue() { return $this->value; }
    public function SetValue($value) { $this->value = $value; }

    public function SetColumnCount($value) { $this->columnCount = $value; }
    public function GetColumnCount() { return $this->columnCount; }

    public function SetRowCount($value) { $this->rowCount = $value; }
    public function GetRowCount() { return $this->rowCount; }

    #region WYSIWYG Editor Options

    public function GetAllowColorControls()
    {
        return $this->allowColorControls;
    }

    public function SetAllowColorControls($value)
    {
        $this->allowColorControls = $value;
    }

    #endregion

    public function ExtractsValueFromPost(&$valueChanged)
    {
        if (GetApplication()->IsPOSTValueSet($this->GetName()))
        {
            $valueChanged = true;
            return GetApplication()->GetPOSTValue($this->GetName());
        }
        else
        {
            $valueChanged = false;
            return null;
        }
    }

    public function Accept($renderer)
    {
        $renderer->RenderHtmlWysiwygEditor($this);
    }

    public function GetValueClientFunction()
    {
        return 'GetTextEditValue(null, ' . $this->GetName() . ')';
    }

    protected function GetJSControlAdapterClass()
    {
        return 'TextEditAdapter';
    }
}

?>