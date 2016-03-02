<?php

require_once 'utils/string_utils.php';
require_once 'superglobal_wrapper.php';
require_once 'renderers/renderer.php';
require_once 'editors.php';

abstract class SearchColumn
{
    private $fieldName;
    private $editorControl;
    private $secondEditorControl;
    private $caption;
    private $superGlobals;
    
    private $applyNotOperator;
    private $filterIndex;
    private $firstValue;
    private $secondValue;

    protected $localizerCaptions;

    protected function GetApplyNotOperator()
    {
        return $this->applyNotOperator;
    }

    protected function SetApplyNotOperator($value)
    {
        $this->applyNotOperator = $value;
    }

    protected function GetFilterIndex()
    {
        return $this->filterIndex;
    }
    
    protected function SetFilterIndex($value)
    {
        $this->filterIndex = $value;
    }

    public function __construct($fieldName, $caption, $stringLocalizer, SuperGlobals $superGlobals)
    {
        $this->fieldName = $fieldName;
        $this->editorControl = $this->CreateEditorControl();
        $this->secondEditorControl = $this->CreateSecondEditorControl();
        $this->caption = $caption;
        $this->localizerCaptions = $stringLocalizer;
        $this->superGlobals = $superGlobals;
    }

    public function GetCaption()
    {
        return $this->caption;
    }
    
    public function SetCaption($value)
    {
        $this->caption = $value;
    }

    protected abstract function CreateEditorControl();
    protected abstract function CreateSecondEditorControl();

    protected abstract function SetEditorControlValue($value);
    protected abstract function SetSecondEditorControlValue($value);

    public function GetFieldName()
    {
        return $this->fieldName;
    }

    public function GetAvailableFilterTypes()
    {
        return array();
    }

    public function GetActiveFilterType()
    {
        return '';
    }

    public function GetEditorControl()
    {
        return $this->editorControl;
    }

    public function GetSecondEditorControl()
    {
        return $this->secondEditorControl;
    }

    public function ExtractSearchValuesFromSession()
    {
        if ($this->superGlobals->IsSessionVariableSet('not_' . $this->GetFieldName()))
        {
            $this->applyNotOperator = $this->superGlobals->GetSessionVariable('not_' . $this->GetFieldName());
            $this->filterIndex = $this->superGlobals->GetSessionVariable('filtertype_' . $this->GetFieldName());
            $this->firstValue = $this->superGlobals->GetSessionVariable($this->GetEditorControl()->GetName());
            $this->secondValue = $this->superGlobals->GetSessionVariable($this->GetSecondEditorControl()->GetName());

            $this->SetEditorControlValue($this->firstValue);
            $this->SetSecondEditorControlValue($this->secondValue);
        }
    }

    private function SaveSearchValuesToSession()
    {
        $this->superGlobals->SetSessionVariable('not_' . $this->GetFieldName(), $this->applyNotOperator);
        $this->superGlobals->SetSessionVariable('filtertype_' . $this->GetFieldName(), $this->filterIndex);
        $this->superGlobals->SetSessionVariable($this->GetEditorControl()->GetName(), $this->firstValue);
        $this->superGlobals->SetSessionVariable($this->GetSecondEditorControl()->GetName(), $this->secondValue);
    }

    private function ResetSessionValues()
    {
        $this->superGlobals->UnSetSessionVariable('not_' . $this->GetFieldName());
        $this->superGlobals->UnSetSessionVariable('filtertype_' . $this->GetFieldName());
        $this->superGlobals->UnSetSessionVariable($this->GetEditorControl()->GetName());
        $this->superGlobals->UnSetSessionVariable($this->GetSecondEditorControl()->GetName());
    }

    public function GetFiterTypeInputName()
    {
        return 'filtertype_' . 
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName());
    }

    public function GetNotMarkInputName()
    {
        return 'not_' . 
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName());
    }

    public function ExtractSearchValuesFromPost()
    {
        $valueChanged = true;
        $this->applyNotOperator = GetApplication()->GetSuperGlobals()->IsPostValueSet($this->GetNotMarkInputName());
        $this->filterIndex = GetApplication()->GetSuperGlobals()->GetPostValue($this->GetFiterTypeInputName());
        $this->firstValue = $this->GetEditorControl()->ExtractsValueFromPost($valueChanged);
        $this->secondValue = $this->GetSecondEditorControl()->ExtractsValueFromPost($valueChanged);

        $this->SaveSearchValuesToSession();

        $this->SetEditorControlValue($this->firstValue);
        $this->SetSecondEditorControlValue($this->secondValue);
    }

    public function ResetFilter()
    {
        $this->applyNotOperator = null;
        $this->filterIndex = null;
        $this->firstValue = null;
        $this->secondValue = null;

        $this->ResetSessionValues();
    }

    public function GetFilterForField()
    {
        $result = null;
        $filter = null;
        if ($this->DoGetFilterForField($filter))
            $result = $filter;
        if (!isset($result) && isset($this->firstValue) && $this->firstValue != '')
        {
            if ($this->filterIndex == 'between')
                $result = new BetweenFieldFilter($this->firstValue, $this->secondValue);
            elseif ($this->filterIndex == 'STARTS')
                $result = new FieldFilter($this->firstValue.'%', 'ILIKE');
            elseif ($this->filterIndex == 'ENDS')
                $result = new FieldFilter('%'.$this->firstValue, 'ILIKE');
            elseif ($this->filterIndex == 'CONTAINS')
                $result = new FieldFilter('%'.$this->firstValue.'%', 'ILIKE');
            else
                $result = new FieldFilter($this->firstValue, $this->filterIndex);
        }
        if (isset($result) && $this->applyNotOperator)
            $result = new NotPredicateFilter($result);
        return $result;
    }

    protected function DoGetFilterForField(&$filter)
    {
        $filter = null;
        return false;
    }

    public function GetUserFriendlyCondition()
    {
        $result = '';
        $filterTypes = $this->GetAvailableFilterTypes();
        if (isset($this->firstValue) && $this->firstValue != '')
        {
            if ($this->filterIndex == 'between')
                $result = sprintf('between %s and %s', '<b>'.$this->firstValue.'</b>',  '<b>'.$this->secondValue.'</b>');
            else
                $result = $filterTypes[$this->filterIndex] . ' ' . '<b>'.$this->firstValue.'</b>';
            if ($this->applyNotOperator)
                $result = $this->localizerCaptions->GetMessageString('Not') . ' (' . $result . ')';
        }
        return $result;
    }

    public function IsFilterActive()
    {
        $result = false;
        if (isset($this->filterIndex))
        {
            $result = isset($this->firstValue) && $this->firstValue != '';
            if ($this->filterIndex == 'between')
                $result = $result && isset($this->secondValue) && $this->secondValue != '';
        }
        return $result;
    }

    public function GetActiveFilterIndex()
    {
        return $this->filterIndex;
    }

    public function GetFilterValue()
    {
        return $this->firstValue;
    }

    public function IsApplyNotOperator()
    {
        return $this->applyNotOperator;
    }
}

class BlobSearchColumn extends SearchColumn
{
    protected function CreateEditorControl()
    {
        return new NullComponent($this->GetFieldName() . '_value');
    }

    protected function CreateSecondEditorControl()
    {
        return new NullComponent($this->GetFieldName() . '_secondvalue');
    }

    protected function SetEditorControlValue($value)
    {

    }
    protected function SetSecondEditorControlValue($value)
    {
    }

    public function GetAvailableFilterTypes()
    {
        return array(
            '' => '',
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank'),
            'IS NOT NULL' => $this->localizerCaptions->GetMessageString('isNotBlank')
            );
    }

    public function IsFilterActive()
    {
        return $this->GetFilterIndex() != '';
    }

    public function GetFilterForField()
    {
        $result = null;
        if ($this->GetFilterIndex() != '')
        {
            if ($this->GetFilterIndex() == 'IS NULL')
                $result = new IsNullFieldFilter();
            elseif ($this->GetFilterIndex() == 'IS NOT NULL')
                $result = new NotPredicateFilter(new IsNullFieldFilter());
            if ($this->GetApplyNotOperator())
                $result = new NotPredicateFilter($result);
        }
        return $result;
    }

}

class StringSearchColumn extends SearchColumn
{
    protected function CreateEditorControl()
    {
        return new TextEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) . // TODO move this logic to editors
            '_value', 15);
    }

    protected function CreateSecondEditorControl()
    {
        return new TextEdit(
            StringUtils::ReplaceIllegalPostVariableNameChars($this->GetFieldName()) . // TODO move this logic to editors 
            '_secondvalue');
    }

    public function IsFilterActive()
    {
        if ($this->GetFilterIndex() == 'IS NULL')
            return true;
        else
            return parent::IsFilterActive();
    }

    protected function SetEditorControlValue($value)
    {
        $this->GetEditorControl()->SetValue($value);
    }

    protected function SetSecondEditorControlValue($value)
    {
        $this->GetSecondEditorControl()->SetValue($value);
    }

    protected function DoGetFilterForField(&$filter)
    {
        if ($this->GetFilterIndex() == 'IS NULL')
        {
            $filter = new IsNullFieldFilter();		
            return true;
        }
        $filter = null;
        return false;
    }

    public function GetUserFriendlyCondition()
    {
        if ($this->GetFilterIndex() == 'IS NULL')
        {
            $result = sprintf('is blank');
            if ($this->GetApplyNotOperator())
                $result = $this->localizerCaptions->GetMessageString('Not') . ' (' . $result . ')';
            return $result;
        }
        else
            return parent::GetUserFriendlyCondition();
    }

    public function GetAvailableFilterTypes()
    {
        return array(
            'LIKE' => $this->localizerCaptions->GetMessageString('Like'),
            'STARTS' => $this->localizerCaptions->GetMessageString('StartsWith'),
            'ENDS' => $this->localizerCaptions->GetMessageString('EndsWith'),
            'CONTAINS' => $this->localizerCaptions->GetMessageString('Contains'),
            'IS NULL' => $this->localizerCaptions->GetMessageString('isBlank'),
            'between' => $this->localizerCaptions->GetMessageString('between'),
            '='  => $this->localizerCaptions->GetMessageString('equals'),
            '<>' => $this->localizerCaptions->GetMessageString('doesNotEquals'),
            '>'  => $this->localizerCaptions->GetMessageString('isGreaterThan'),
            '>=' => $this->localizerCaptions->GetMessageString('isGreaterThanOrEqualsTo'),
            '<'  => $this->localizerCaptions->GetMessageString('isLessThan'),
            '<=' => $this->localizerCaptions->GetMessageString('isLessThanOrEqualsTo')
            );
    }
}

class AdvancedSearchControl
{
    private $name;
    private $dataset;
    private $columns;
    private $applyAndOperator;
    private $target;
    private $hidden;
    private $allowOpenInNewWindow;
    private $stringLocalizer;
    
    public function __construct($name, $dataset, $stringLocalizer)
    {
        $this->name = $name;
        $this->dataset = $dataset;
        $this->stringLocalizer = $stringLocalizer;
        //
        $this->columns = array();
        $this->applyAndOperator = null;
        $this->isActive = false;
        $this->hidden = true;
        $this->target = '';
        $this->allowOpenInNewWindow = true;
    }

    #region Factory methods

    public function CreateStringSearchInput($fieldName, $caption)
    {
        return new StringSearchColumn($fieldName, $caption, $this->stringLocalizer, 
            new SuperGlobals($this->name)
        );
    }

    public function CreateBlobSearchInput($fieldName, $caption)
    {
        return new BlobSearchColumn($fieldName, $caption, $this->stringLocalizer,
            new SuperGlobals($this->name)
        );
    }

    #endregion

    #region Options

    public function GetTarget()
    {
        return $this->target;
    }

    public function SetTarget($value)
    {
        $this->target = $value;
    }

    public function SetAllowOpenInNewWindow($value)
    {
        $this->allowOpenInNewWindow = $value;
    }

    public function GetAllowOpenInNewWindow()
    {
        return $this->allowOpenInNewWindow;
    }

    public function GetOpenInNewWindowLink()
    {
        return $this->openInNewWindowLink;
    }

    public function SetOpenInNewWindowLink($value)
    {
        $this->openInNewWindowLink = $value;
    }

    public function SetHidden($value)
    {
        $this->hidden = $value;
    }

    public function GetHidden()
    {
        return $this->hidden;
    }

    #endregion

    public function Accept($renderer)
    {
        $renderer->RenderAdvancedSearchControl($this);
    }

    public function AddSearchColumn($column)
    {
        $this->columns[] = $column;
    }

    public function GetSearchColumns()
    {
        return $this->columns;
    }
    
    public function GetIsApplyAndOperator()
    {
        return $this->applyAndOperator;
    }

    private function ResetFilter()
    {
        foreach($this->columns as $column)
            $column->ResetFilter();
        $this->applyAndOperator = null;
        GetApplication()->UnSetSessionVariable($this->name . 'SearchType');
    }

    private function ExtractValuesFromSession()
    {
        foreach($this->columns as $column)
            $column->ExtractSearchValuesFromSession();
        $this->applyAndOperator = GetApplication()->GetSessionVariable($this->name . 'SearchType');
    }

    private function ExtractValuesFromPost()
    {
        foreach($this->columns as $column)
            $column->ExtractSearchValuesFromPost();
        $this->applyAndOperator = GetApplication()->GetPOSTValue('SearchType') == 'and';
        GetApplication()->SetSessionVariable($this->name . 'SearchType', $this->applyAndOperator);
    }

    private function ApplyFilterToDataset()
    {
        $fieldNames = array();
        $fieldFilters = array();

        foreach($this->columns as $column)
            if ($column->IsFilterActive())
            {
                $fieldNames[] = $column->GetFieldName();
                $fieldFilters[] = $column->GetFilterForField();
            }

        if (count($fieldFilters) > 0)
            $this->dataset->AddCompositeFieldFilter(
                $this->applyAndOperator ? 'AND' : 'OR',
                $fieldNames,
                $fieldFilters);
        $this->isActive = (count($fieldFilters) > 0);
    }

    public function GetUserFriendlySearchConditions()
    {
        $result = array();

        foreach($this->columns as $column)
            if ($column->IsFilterActive())
            {
                $result[] = array(
                    'Caption' => $column->GetCaption(),
                    'Condition' => $column->GetUserFriendlyCondition()
                    );
            }
        return $result;
    }

    public function IsActive()
    {
        return $this->isActive;
    }

    public function HasCondition()
    {
        if ((GetApplication()->IsPOSTValueSet('ResetFilter') && GetApplication()->GetPOSTValue('ResetFilter') == '1') || (GetApplication()->IsPOSTValueSet('operation') && GetApplication()->GetPOSTValue('operation') == 'ssearch'))
            return false;
        else
        {
            return 
                GetApplication()->IsPOSTValueSet('SearchType') ||
                GetApplication()->IsSessionVariableSet($this->name . 'SearchType');
        }
    }

    public function ProcessMessages()
    {
        if ((GetApplication()->IsPOSTValueSet('ResetFilter') && GetApplication()->GetPOSTValue('ResetFilter') == '1') || (GetApplication()->IsPOSTValueSet('operation') && GetApplication()->GetPOSTValue('operation') == 'ssearch'))
        {
            $this->ResetFilter();
        }
        else
        {
            if (GetApplication()->IsSessionVariableSet($this->name . 'SearchType'))
                $this->ExtractValuesFromSession();

            if (GetApplication()->IsPOSTValueSet('SearchType'))
                $this->ExtractValuesFromPost();

            if (isset($this->applyAndOperator))
                $this->ApplyFilterToDataset();
        }
    }

    #region Client Highlighting
    private function IsFilterTypeAllowsHighlighting($filterType)
    {
        in_array($filterType,
            array('LIKE', '=', 'STARTS', 'ENDS', 'CONTAINS')
            );
    }

    public function GetHighlightedFields()
    {
        $result = array();
        foreach($this->columns as $column)
            if (
                $column->IsFilterActive() &&
                    $this->IsFilterTypeAllowsHighlighting($column->GetActiveFilterIndex())
                )
                $result[] = $column->GetFieldName();
        return $result;
    }

    public function GetHighlightedFieldText()
    {
        $result = array();
        foreach($this->columns as $column)
            if ($column->IsFilterActive() && (
                ($column->GetActiveFilterIndex() == 'LIKE') ||
                ($column->GetActiveFilterIndex() == '=') ||
                ($column->GetActiveFilterIndex() == 'STARTS') ||
                ($column->GetActiveFilterIndex() == 'ENDS') ||
                ($column->GetActiveFilterIndex() == 'CONTAINS')
                ))
                $result[] = str_replace('%', '', $column->GetFilterValue());
        return $result;
    }

    public function GetHighlightedFieldOptions()
    {
        $result = array();
        foreach($this->columns as $column)
            if ($column->IsFilterActive() && (
                ($column->GetActiveFilterIndex() == 'LIKE') ||
                ($column->GetActiveFilterIndex() == '=')  ||
                ($column->GetActiveFilterIndex() == 'STARTS') ||
                ($column->GetActiveFilterIndex() == 'ENDS') ||
                ($column->GetActiveFilterIndex() == 'CONTAINS')
                ))
            {
                $trimmed = trim($column->GetFilterValue());
                if ($column->GetActiveFilterIndex() == 'LIKE')
                {
                    if ($trimmed[0] == '%' && $trimmed[strlen($trimmed) - 1] == '%')
                        $result[] =  'ALL';
                    elseif ($trimmed[0] == '%')
                        $result[] =  'END';
                    elseif ($trimmed[strlen($trimmed) - 1] == '%')
                        $result[] =  'START';
                }
                elseif ($column->GetActiveFilterIndex() == 'STARTS')
                    $result[] = 'START';
                elseif ($column->GetActiveFilterIndex() == 'ENDS')
                    $result[] = 'END';
                elseif ($column->GetActiveFilterIndex() == 'CONTAINS')
                    $result[] = 'ALL';
                else
                    $result[] =  'ALL';
            }
        return $result;
    }

    #endregion
}
?>
