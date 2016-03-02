<?php   

require_once 'components/utils/system_utils.php';

function GetOrderTypeCaption($orderType)
{
    global $orderTypeCaptions;
    return $orderTypeCaptions[$orderType];
}

abstract class CustomViewColumn
{
    private $caption;
    private $fixedWidth;
    private $verticalLine;
    private $description;
    
    public $headerControl;
    protected $grid;
    public $editOperationColumn; // public?
    private $insertOperationColumn;
    private $wordWrap;

    public function __construct($caption)
    {
        $this->caption = $caption;
        $this->fixedWidth = null;
        $this->verticalLine = null;
        $this->insertOperationColumn = null;
        $this->wordWrap = true;
    }

    public function GetDescription()
    { return $this->description; }
    public function SetDescription($value)
    { $this->description = $value; }
    
    public function GetVerticalLine()
    {
        return $this->verticalLine;
    }
    public function SetVerticalLine($value)
    {
        $this->verticalLine = $value;
    }

    public function GetWordWrap()
    {
        return $this->wordWrap;
    }

    public function SetWordWrap($value)
    {
        $this->wordWrap = $value;
    }

    protected function CreateHeaderControl()
    {
        $result = new HintedTextBox('HeaderControl', $this->GetCaption());
        $result->SetHint($this->GetDescription());
        return $result;
    }

    public function GetName()
    { }

    public function GetCaption()
    { 
        return $this->caption;
    }

    public function SetGrid($value)
    {
        $this->grid = $value;
        $this->caption = $this->grid->GetPage()->RenderText($this->caption);
    }
    
    public function GetGrid()
    { 
        return $this->grid;
    }

    abstract public function GetValue();

    public function GetData()
    {
        return null;
    }

    public function Accept($renderer)
    {
        $renderer->RenderCustomViewColumn($this);
    }

    public function ProcessMessages()
    {
        if (GetOperation() == OPERATION_AJAX_REQUERT_INLINE_EDIT)
        {
            if (isset($this->editOperationColumn))
                $this->editOperationColumn->ProcessMessages();
        }
        elseif (GetOperation() == OPERATION_AJAX_REQUERT_INLINE_INSERT)
        {
            if (isset($this->insertOperationColumn))
                $this->insertOperationColumn->ProcessMessages();
        }
    }

    public function GetHeaderControl()
    {
        if (!isset($this->headerControl))
            $this->headerControl = $this->CreateHeaderControl();
        return $this->headerControl;
    }

    public function GetAfterRowControl()
    {
        return new NullComponent('');
    }

    public function SetFixedWidth($value)
    { 
        $this->fixedWidth = $value;
    }

    public function GetFixedWidth()
    { 
        return $this->fixedWidth;
    }
    
    public function UseFixedWidth()
    {
        $fixedWidth = $this->GetFixedWidth();
        return isset($fixedWidth);
    }

    public function IsDataColumn()
    { 
        return false;
    }

    public function GetAlign()
    {
        return null;
    }

    #region Edit operation
    public function SetEditOperationColumn(CustomEditColumn $value)
    {
        $this->editOperationColumn = $value;
    }

    public function GetEditOperationColumn()
    {
        return $this->editOperationColumn;
    }

    public function GetEditOperationEditor()
    {
        if (isset($this->editOperationColumn))
            return $this->editOperationColumn->GetEditControl();
        else
            return null;
    }
    #endregion

    #region Insert operation
    public function SetInsertOperationColumn(CustomEditColumn $value)
    {
        $this->insertOperationColumn = $value;
    }

    public function GetInsertOperationColumn()
    {
        return $this->insertOperationColumn;
    }

    public function GetInsertOperationEditor()
    {
        if (isset($this->insertOperationColumn))
            return $this->insertOperationColumn->GetEditControl();
        else
            return null;
    }
    #endregion
}

abstract class CustomDatasetFieldViewColumn extends CustomViewColumn
{
    private $fieldName;
    private $dataset;
    private $orderable;
    
    #region Events
    public $BeforeColumnRender;
    #endregion

    public function __construct($fieldName, $caption, $dataset, $orderable = true)
    {
        parent::__construct($caption);
        $this->BeforeColumnRender = new Event();
        //
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->orderable = $orderable;
    }

    public function SetOrderable($value)
    { $this->orderable = $value; }
    public function GetOrderable()
    { return $this->orderable; }

    protected function GetFieldName()
    {
        return $this->fieldName;
    }

    public function GetName()
    { 
        return $this->fieldName; 
    }

    public function GetDataset()
    { 
        return $this->dataset; 
    }

    public function GetData()
    { 
        return $this->GetDataset()->GetFieldValueByName($this->GetFieldName()); 
    }

    protected abstract function DoGetValue();

    public function GetValue()
    {
        $result = $this->GetData();
        return isset($result) ? $this->DoGetValue() :  null;
    }

    public function Accept($renderer)
    {
        $renderer->RenderCustomDatasetFieldViewColumn($this);
    }

    protected function CreateHeaderControl()
    {
        if ($this->orderable)
        {
            $result = new HintedTextBox('HeaderControl', $this->GetCaption());
            $result->SetHint($this->GetDescription());
            return $result;
        }
        else
            return parent::CreateHeaderControl();
    }

    private function GetOrderByLink($currentOrderType = null)
    {
        $linkBuilder = $this->GetGrid()->CreateLinkBuilder();

        switch($currentOrderType)
        {
            case otAscending:
                $linkBuilder->AddParameter('order', GetOrderTypeCaption(otDescending) . $this->fieldName);
                break;
            case otDescending:
                $linkBuilder->AddParameter(OPERATION_PARAMNAME, 'resetorder');
                break;
            case null:
                $linkBuilder->AddParameter('order', GetOrderTypeCaption(otAscending) . $this->fieldName);
                break;
        }

        return $linkBuilder->GetLink();
    }

    private function GetSortCaption($currentOrderType = null)
    {
        switch($currentOrderType)
        {
            case otAscending:
                //return ' <img src="images/sort_up.gif" style="border: 0;">';
                return '<i class="glyphicon glyphicon-sort-by-attributes"></i>';
                break;
            case otDescending:
                return '<i class="glyphicon glyphicon-sort-by-attributes-alt"></i>';
                //return ' <img src="images/sort_down.gif" style="border: 0;">';
                break;
            default:
                //return ' <img src="images/sort_none.gif" style="border: 0;">';
                return '<i class="glyphicon glyphicon-sort"></i>';
                break;
        }
    }

    public function ProcessMessages()
    {
        parent::ProcessMessages();
        if ($this->orderable)
        {
            $orderColumn = $this->GetGrid()->GetOrderColumnFieldName();
            if ($orderColumn == $this->fieldName)
            {
                $this->GetHeaderControl()->SetAfterLinkText(
                    ' <a href="'.$this->GetOrderByLink($this->GetGrid()->GetOrderType()).'">'.
                    $this->GetSortCaption($this->GetGrid()->GetOrderType()).
                    '</a>'
                );
            }
            else
            {
                $this->GetHeaderControl()->SetAfterLinkText(
                    ' <a href="' . $this->GetOrderByLink()  .'">'.$this->GetSortCaption(null).'</a>');
            }
        }
    }

    public function IsDataColumn()
    { 
        return true; 
    }
}

class TextViewColumn extends CustomDatasetFieldViewColumn
{
    private $maxLength;
    private $replaceLFByBR;
    private $escapeHTMLSpecialChars;
    private $fullTextWindowHandlerName;

    public function __construct($fieldName, $caption, $dataset, $orderable = true)
    {
        parent::__construct($fieldName, $caption, $dataset, $orderable);
        $this->maxLength = null;
        $this->replaceLFByBR = false;
        $this->escapeHTMLSpecialChars = false;
        $this->fullTextWindowHandlerName = null;
    }

    public function GetMoreLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        if ($this->GetFullTextWindowHandlerName() != null)
            $result->AddParameter('hname', $this->GetFullTextWindowHandlerName());
        else
            $result->AddParameter('hname', $this->GetFieldName() . '_handler');

        AddPrimaryKeyParameters($result, $this->GetDataset()->GetPrimaryKeyValues());
        return $result->GetLink();
    }

    protected function DoGetValue()
    {
        return $this->GetData();
    }

    public function IsNull()
    {
        $value = $this->GetData();
        return !isset($value);
    }

    public function Accept($renderer)
    {
        $renderer->RenderTextViewColumn($this);
    }

    #region Column options

    public function SetMaxLength($value)
    { 
        $this->maxLength = $value; 
    }

    public function GetMaxLength()
    { 
        return $this->maxLength; 
    }

    public function SetReplaceLFByBR($value)
    { 
        $this->replaceLFByBR = $value; 
    }

    public function GetReplaceLFByBR()
    { 
        return $this->replaceLFByBR; 
    }

    public function SetEscapeHTMLSpecialChars($value)
    { 
        $this->escapeHTMLSpecialChars = $value; 
    }

    public function GetEscapeHTMLSpecialChars()
    { 
        return $this->escapeHTMLSpecialChars; 
    }

    public function SetFullTextWindowHandlerName($value)
    { 
        $this->fullTextWindowHandlerName = $value; 
    }

    public function GetFullTextWindowHandlerName()
    { 
        return $this->fullTextWindowHandlerName; 
    }

    #endregion
}

class DateTimeViewColumn extends CustomDatasetFieldViewColumn
{
    private $dateTimeFormat;

    public function __construct($fieldName, $caption, $dataset, $orderable = true)
    {
        parent::__construct($fieldName, $caption, $dataset, $orderable);
        $this->dateTimeFormat = 'Y-m-d';
    }

    public function SetDateTimeFormat($value)
    { 
        $this->dateTimeFormat = $value; 
    }

    public function GetDateTimeFormat()
    { 
        return $this->dateTimeFormat; 
    }

    protected function DoGetValue()
    {
        $value = $this->GetDataset()->GetFieldValueByNameAsDateTime($this->GetName());

        $stringValue = isset($value) ? $value->ToString($this->dateTimeFormat) : null;
        $dataset = $this->GetDataset();
        $this->BeforeColumnRender->Fire(array(&$stringValue, &$dataset));

        return isset($stringValue) ? $stringValue : 'NULL';
    }
}

abstract class CustomFormatValueViewColumnDecorator extends CustomViewColumn
{
    private $innerField;

    public function __construct($innerField)
    {
        parent::__construct('');
        $this->innerField = $innerField;
        $this->Bold = null;
        
    }

    public function GetDescription()
    { return $this->innerField->GetDescription(); }
    public function SetDescription($value)
    { $this->innerField->SetDescription($value); }

    public function GetName()
    { return $this->innerField->GetName(); }
    public function GetData()
    { return $this->innerField->GetData(); }

    protected function GetInnerFieldValue()
    {
        return $this->innerField->GetValue();
    }

    protected function IsNull()
    {
        return $this->innerField->IsNull();
    }

    public function GetInnerField()
    {
        return $this->innerField;
    }

    public function GetCaption()
    { return $this->innerField->GetCaption(); }

    public function SetGrid($value)
    { $this->innerField->SetGrid($value); }

    public function GetAfterRowControl()
    { return $this->innerField->GetAfterRowControl(); }

    public function GetHeaderControl()
    { return $this->innerField->GetHeaderControl(); }

    public function ProcessMessages()
    {
        $this->innerField->ProcessMessages();
    }

    public function SetFixedWidth($value)
    {
        $this->innerField->SetFixedWidth($value);
    }

    public function GetFixedWidth()
    {
        return $this->innerField->GetFixedWidth();
    }

    public function IsDataColumn()
    { return $this->innerField->IsDataColumn(); }

    #region Edit operation
    public function SetEditOperationColumn(CustomEditColumn $value)
    {
        $this->innerField->SetEditOperationColumn($value);
    }

    public function GetEditOperationColumn()
    {
        return $this->innerField->GetEditOperationColumn();
    }

    public function GetEditOperationEditor()
    {
        return $this->innerField->GetEditOperationEditor();
    }
    #endregion

    #region Insert operation
    public function SetInsertOperationColumn(CustomEditColumn $value)
    {
        $this->innerField->SetInsertOperationColumn($value);
    }

    public function GetInsertOperationColumn()
    {
        return $this->innerField->GetInsertOperationColumn();
    }

    public function GetInsertOperationEditor()
    {
        return $this->innerField->GetInsertOperationEditor();
    }
    #endregion
}

class DivTagViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    public $Bold;
    public $Italic;
    public $CustomAttributes;
    public $Align;

    public function __construct($innerField)
    {
        parent::__construct($innerField);
        $this->Bold = null;
        $this->Italic = null;
        $this->CustomAttributes = null;
        $this->innerField = $innerField;
    }

    //TODO: remove
    public function GetValue()
    {
        return $this->GetInnerField()->GetValue();
    }

    public function Accept($renderer)
    {
        $renderer->RenderDivTagViewColumnDecorator($this);
    }

    public function GetAlign()
    {
        return $this->Align;
    }
}

class CheckBoxFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $trueValue;
    private $falseValue;

    public function GetValue()
    {
        $value = $this->GetInnerField()->GetDataset()->GetFieldValueByName($this->GetName());
        if (!isset($value))
            return $this->GetInnerFieldValue();
        else if (empty($value))
                return '<input type="checkbox" onclick="return false;">';
            else
                return '<input type="checkbox" checked="checked" onclick="return false;">';
    }

    public function SetDisplayValues($trueValue, $falseValue)
    {
        $this->trueValue = $trueValue;
        $this->falseValue = $falseValue;
    }

    public function GetTrueValue()
    { return $this->trueValue; }
    public function GetFalseValue()
    { return $this->falseValue; }

    public function Accept($renderer)
    {
        $renderer->RenderCheckBoxViewColumn($this);
    }

    public function IsDataColumn()
    { return false; }
}

class NumberFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $numberAfterDecimal;
    private $thousandsSeparator;
    private $decimalSeparator;

    public function __construct($innerField, $numberAfterDecimal, $thousandsSeparator, $decimalSeparator)
    {
        parent::__construct($innerField);
        $this->numberAfterDecimal = $numberAfterDecimal;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->decimalSeparator = $decimalSeparator;
    }

    protected function GetNumberAfterDecimal()
    { return $this->numberAfterDecimal; }

    public function GetValue()
    {
        if (!$this->IsNull())
            return number_format($this->GetInnerFieldValue(), $this->numberAfterDecimal, $this->decimalSeparator, $this->thousandsSeparator);
        else
            return $this->GetInnerFieldValue();
    }
}

class CurrencyFormatValueViewColumnDecorator extends NumberFormatValueViewColumnDecorator
{
    private $currencySign;

    public function __construct($innerField, $numberAfterDecimal, $thousandsSeparator, $decimalSeparator, $currencySign = '$')
    {
        parent::__construct($innerField, $numberAfterDecimal, $thousandsSeparator, $decimalSeparator);
        $this->currencySign = $currencySign;
    }

    public function GetValue()
    {
        if (!$this->IsNull())
            return $this->currencySign . parent::GetValue();
        else
            return $this->GetInnerFieldValue();
    }
}

class StringFormatValueViewColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $stringTransaformFunction;

    private function TransformString($string)
    {
        if (function_exists($this->stringTransaformFunction))
            return call_user_func($this->stringTransaformFunction, $string);
        else
            return $string;
    }

    public function __construct($innerField, $stringTransaformFunction)
    {
        parent::__construct($innerField);
        $this->stringTransaformFunction = $stringTransaformFunction;
    }

    public function GetValue()
    {
        return $this->TransformString($this->GetInnerFieldValue());
    }
}

class PercentFormatValueViewColumnDecorator extends NumberFormatValueViewColumnDecorator
{
    public function GetValue()
    {
        return parent::GetValue() . '%';
    }
}   

class ExtendedHyperLinkColumnDecorator extends CustomFormatValueViewColumnDecorator
{
    private $template;
    private $target;
    private $dataset;
    
    public function __construct($innerField, $dataset, $template, $target = '_blank')
    {
        parent::__construct($innerField);
        $this->template = $template;
        $this->target = $target;
        $this->dataset = $dataset;
    }

    public function GetLink()
    {
        return FormatDatasetFieldsTemplate($this->dataset, $this->template);
    }

    public function GetTarget()
    {
        return $this->target;
    }

    // TODO: delete
    public function GetValue()
    {
        return sprintf('<a href="%s" target="%s">%s</a>',
            $this->GetLink(),
            $this->target,
            $this->GetInnerFieldValue()
        );
    }

    public function Accept($renderer)
    {
        $renderer->RenderExtendedHyperLinkColumnDecorator($this);
    }
}

class DownloadDataColumn extends CustomViewColumn
{
    private $dataset;
    private $fieldName;
    private $linkInnerHtml;

    public function __construct($fieldName, $caption, $dataset, $linkInnerHtml = 'download')
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->linkInnerHtml = $linkInnerHtml;
    }

    public function GetName()
    { return $this->fieldName; }
    public function GetDataset()
    { return $this->dataset; }
    public function GetData()
    { return $this->GetDataset()->GetFieldValueByName($this->fieldName); }
    public function GetValue()
    { return $this->GetData(); }
    public function GetLinkInnerHtml()
    { return $this->linkInnerHtml; }

    public function GetDownloadLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        $result->AddParameter('hname', $this->fieldName . '_handler');
        AddPrimaryKeyParameters($result, $this->GetDataset()->GetPrimaryKeyValues());
        return $result->GetLink();
    }

    public function Accept($renderer)
    {
        $renderer->RenderDownloadDataColumn($this);
    }

    public function IsDataColumn()
    { return false; }
}

class DownloadExternalDataColumn extends  CustomViewColumn
{
    private $fieldName;
    private $dataset;
    private $downloadTextTemplate;
    private $downloadLinkHintTemplate;

    private $sourcePrefix;
    private $sourceSuffix;


    public function __construct($fieldName, $caption, $dataset, $downloadTextTemplate, $downloadLinkHintTemplate = '')
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->downloadTextTemplate = $downloadTextTemplate;
        $this->downloadLinkHintTemplate = $downloadLinkHintTemplate;
    }

    public function GetName()
    { return $this->fieldName; }
    public function GetDataset()
    { return $this->dataset; }
    public function GetData()
    { return $this->GetDataset()->GetFieldValueByName($this->fieldName); }

    public function SetSourcePrefix($value)
    { $this->sourcePrefix = $value; }
    public function GetSourcePrefix()
    { return $this->sourcePrefix; }

    public function SetSourceSuffix($value)
    { $this->sourceSuffix = $value; }
    public function GetSourceSuffix()
    { return $this->sourceSuffix; }

    public function GetValue()
    {
        $fieldValue = $this->GetDataset()->GetFieldValueByName($this->fieldName);
        if ($fieldValue == null)
            return '<i><font color="#AAAAAA">NULL</font></i>';
        else
            return '<a target="_blank" title="'. FormatDatasetFieldsTemplate($this->dataset, $this->downloadLinkHintTemplate) .'" href="' . $this->sourcePrefix . $fieldValue . $this->sourceSuffix . '">' .
                FormatDatasetFieldsTemplate($this->dataset, $this->downloadTextTemplate) . '</a>';
    }
}

class ExternalImageColumn extends  CustomViewColumn
{
    private $fieldName;
    private $dataset;
    private $hintTemplate;
    private $sourcePrefix;
    private $sourceSuffix;

    public function __construct($fieldName, $caption, $dataset, $hintTemplate)
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->hintTemplate = $hintTemplate;
        $this->sourcePrefix = '';
        $this->sourceSuffix = '';
    }

    public function SetSourcePrefix($value)
    { $this->sourcePrefix = $value; }
    public function GetSourcePrefix()
    { return $this->sourcePrefix; }

    public function SetSourceSuffix($value)
    { $this->sourceSuffix = $value; }
    public function GetSourceSuffix()
    { return $this->sourceSuffix; }

    public function GetName()
    { return $this->fieldName; }
    public function GetDataset()
    { return $this->dataset; }
    public function GetData()
    { return $this->GetDataset()->GetFieldValueByName($this->fieldName); }

    public function GetValue()
    {
        $fieldValue = $this->GetDataset()->GetFieldValueByName($this->fieldName);
        if ($fieldValue == null)
            return '<i><font color="#AAAAAA">NULL</font></i>';
        else
            return '<img alt="'. FormatDatasetFieldsTemplate($this->dataset, $this->hintTemplate) .
                '" src="' . $this->sourcePrefix . $fieldValue . $this->sourceSuffix . '">';
    }
}

class ImageViewColumn extends CustomViewColumn
{
    private $dataset;
    private $fieldName;
    private $imageHintTemplate;
    private $enablePictureZoom;
    private $handlerName;

    public function __construct($fieldName, $caption, $dataset, $enablePictureZoom = true, $handlerName)
    {
        parent::__construct($caption);
        $this->fieldName = $fieldName;
        $this->dataset = $dataset;
        $this->imageHintTemplate = null;
        $this->enablePictureZoom = $enablePictureZoom;
        $this->handlerName = $handlerName;
    }

    public function GetName()
    { return $this->fieldName; }
    public function GetDataset()
    { return $this->dataset; }
    public function GetData()
    { return $this->GetDataset()->GetFieldValueByName($this->fieldName); }
    public function GetValue()
    { return $this->GetData(); }

    public function GetEnablePictureZoom()
    { return $this->enablePictureZoom; }
    public function SetEnablePictureZoom($value)
    { $this->enablePictureZoom = $value; }
    public function SetImageHintTemplate($value)
    { $this->imageHintTemplate = $value; }
    public function GetImageHintTemplate()
    { return $this->imageHintTemplate; }

    public function GetImageLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        $result->AddParameter('hname', $this->handlerName);
        AddPrimaryKeyParameters($result, $this->GetDataset()->GetPrimaryKeyValues());
        return $result->GetLink();
    }

    public function GetFullImageLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        $result->AddParameter('hname', $this->handlerName);
        $result->AddParameter('large', '1');
        AddPrimaryKeyParameters($result, $this->GetDataset()->GetPrimaryKeyValues());
        return $result->GetLink();
    }

    public function GetImageHint()
    {
        if (isset($this->imageHintTemplate))
            return FormatDatasetFieldsTemplate($this->dataset, $this->imageHintTemplate);
        else
            return $this->GetCaption();
    }

    public function Accept($renderer)
    {
        $renderer->RenderImageViewColumn($this);
    }

    public function IsDataColumn()
    { return false; }
}

class DetailColumn extends CustomViewColumn
{
    private $masterKeyFields;
    private $separatePageHandlerName;
    private $inlinePageHandlerName;
    private $dataset;
    private $name;
    private $frameRandomNumber;

    public function __construct($masterKeyFields, $name, $separatePageHandlerName, $inlinePageHandlerName, Dataset $dataset, $caption)
    {
        parent::__construct($caption);
        $this->masterKeyFields = $masterKeyFields;
        $this->name = $name;
        $this->separatePageHandlerName = $separatePageHandlerName;
        $this->inlinePageHandlerName = $inlinePageHandlerName;
        $this->dataset = $dataset;
        $this->frameRandomNumber = Random::GetIntRandom();
        $this->dataset->OnNextRecord->AddListener('NextRecordHandler', $this);
    }

    public function NextRecordHandler($sender)
    {
        $this->frameRandomNumber = Random::GetIntRandom();
    }

    public function GetName()
    { return ''; }
    public function GetDataset()
    { return $this->dataset; }
    public function GetData()
    { return null; }

    private function GetDetailsControlSuffix()
    {
        //return $this->GetDataset()->GetCurrentRowIndex();
        return $this->frameRandomNumber;
    }

    public function GetLink()
    {
        $linkBuilder = $this->GetGrid()->CreateLinkBuilder();
        $linkBuilder->AddParameter('detailrow', 'DetailContent_' . $this->name . '_' . $this->GetDetailsControlSuffix());
        $linkBuilder->AddParameter('hname', $this->inlinePageHandlerName);
        for($i = 0; $i < count($this->masterKeyFields); $i++)
            $linkBuilder->AddParameter('fk' . $i, $this->GetDataset()->GetFieldValueByName($this->masterKeyFields[$i]));
        return $linkBuilder->GetLink();
    }

    public function GetSeparateViewLink()
    {
        $linkBuilder = $this->GetGrid()->CreateLinkBuilder();
        $linkBuilder->AddParameter('hname', $this->separatePageHandlerName);
        for($i = 0; $i < count($this->masterKeyFields); $i++)
            $linkBuilder->AddParameter('fk' . $i, $this->GetDataset()->GetFieldValueByName($this->masterKeyFields[$i]));
        return $linkBuilder->GetLink();
    }

    public function GetAfterRowControl()
    {
        return new CustomHtmlControl(
        '<iframe class="hidden"' .
            ' id="DetailFrame_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '"' .
            ' name="DetailFrame_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '"' .
            ' style="width:100%"></iframe>' .
            '<div class="hidden" id="DetailContent_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '"></div>'
        );
    }

    public function GetValue()
    {
        return
        '<a class="page_link" onclick="expand(' .
            '\'DetailFrame_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '\', ' .
            '\'DetailContent_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '\', ' .
            '\'ExpandImage_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '\', ' .
            'this);" href="' . $this->GetLink() . '">'.
            '<img id="ExpandImage_' . $this->name . '_' . $this->GetDetailsControlSuffix() . '" src="images/expand.gif" class="collapsed">' .
            '</a>&nbsp;' .
            '<a class="page_link" href="' . $this->GetSeparateViewLink() . '">' . $this->GetCaption() . '</a>';
    }
}

?>