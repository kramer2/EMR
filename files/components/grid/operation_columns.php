<?php

require_once 'components/grid/columns.php';

class RowOperationByLinkColumn extends CustomViewColumn
{
    private $operationName;
    private $imagePath;
    
    #region Events
    public $OnShow;
    #endregion

    function __construct($caption, $operationName, $dataset, $imagePath = null)
    {
        parent::__construct($caption);
        $this->operationName = $operationName;
        $this->dataset = $dataset;
        //
        $this->OnShow = new Event();
        $this->imagePath = $imagePath;
    }

    public function GetName()
    { return $this->operationName; }
    public function GetData()
    { return $this->operationName; }

    public function GetImagePath()
    { return $this->imagePath; }
    public function SetImagePath($value)
    { $this->imagePath = $value; }

    private function GetLinkParametersForPrimaryKey()
    {
        $result = array();
        $keyValues = $this->dataset->GetPrimaryKeyValues();
        for($i = 0; $i < count($keyValues); $i++)
            $result["pk$i"] = $keyValues[$i];
        return $result;
    }

    public function SetGrid($value)
    {
        $this->grid = $value;
    }

    public function GetLink()
    {
        $result = $this->GetGrid()->CreateLinkBuilder();
        $result->AddParameter(OPERATION_PARAMNAME, $this->operationName);
        $result->AddParameters($this->GetLinkParametersForPrimaryKey());
        return $result->GetLink();
    }

    protected function CreateHeaderControl()
    {
        if ($this->GetImagePath() != null)
        {
            return new CustomHtmlControl('<img src="'.$this->GetImagePath().'" alt="' . $this->GetCaption() . '">');
        }
        else
        {
            return parent::CreateHeaderControl();
        }
    }

    public function GetValue()
    {
        $showButton = true;
        $this->OnShow->Fire(array(&$showButton));

        if ($showButton)
        {
            if ($this->GetImagePath() != null)
            {
                return '<span style="white-space: nowrap;"><a style="margin-left: 4px; margin-right: 4px;" href="' . $this->GetLink() . '" title="' . $this->GetCaption() . '" >' . '<img src="'.$this->GetImagePath().'" alt="' . $this->GetCaption() . '">' . '</a></span>';
            }
            else
            {
                return '<span><a href="' . $this->GetLink() . '">' . $this->GetCaption() . '</a></span>';
            }
        }
        else
            return '';
    }
}

class InlineEditRowColumn extends CustomViewColumn
{
    private $dataset;
    private $cancelButtonText;
    private $commitButtonText;
    private $editButtonText;
    private $useImages;
    public $OnShow;

    function __construct($caption, $dataset, $editButtonText, $cancelButtonText, $commitButtonText, $useImages = true)
    {
        parent::__construct($caption);
        $this->dataset = $dataset;
        $this->editButtonText = $editButtonText;
        $this->cancelButtonText = $cancelButtonText;
        $this->commitButtonText = $commitButtonText;
        $this->useImages = $useImages;
        $this->OnShow = new Event();
    }

    public function GetName()
    { 
        return 'InlineEdit';
    }
    
    public function GetData()
    { 
        return 'InlineEdit';
    }

    public function SetGrid($value)
    {
        $this->grid = $value;
    }

    public function GetValue()
    {
        $showButton = true;
        $this->OnShow->Fire(array(&$showButton));

        if ($showButton)
        {
            AddStr($result, '<span style="white-space: nowrap;">');
            if ($this->useImages)
            {
                AddStr($result, '<a href="#" class="inline_edit_init" title="' . $this->editButtonText . '">' . '<img src="images/inline_edit.png" title="' . $this->editButtonText . '">' . '</a>');        
                AddStr($result, '<a href="#" class="inline_edit_cancel" title="' . $this->cancelButtonText . '">' . '<img src="images/cancel.png" title="' . $this->cancelButtonText . '">' . '</a>');
                AddStr($result, '<a href="#" class="inline_edit_commit" title="' . $this->commitButtonText . '">' . '<img src="images/ok.png" title="' . $this->commitButtonText . '">' . '</a>');
            }
            else
            {
                AddStr($result, '<a href="#" class="inline_edit_init" title="' . $this->editButtonText . '">'  . $this->editButtonText . '</a>');        
                AddStr($result, '<a style="margin-right: 5px;" href="#" class="inline_edit_cancel" title="' . $this->cancelButtonText . '">' . $this->cancelButtonText . '</a>');
                AddStr($result, '<a href="#" class="inline_edit_commit" title="' . $this->commitButtonText . '">' . $this->commitButtonText . '</a>');
            }
            AddStr($result, '</span>');
            
            $keyValues = $this->dataset->GetPrimaryKeyValues();
            for($i = 0; $i < count($keyValues); $i++)
                AddStr($result, sprintf('<input type="hidden" name="pk%d" value="%s"></input>', $i, $keyValues[$i]));
            
            return $result;
        }
        else
            return '';
    }
}

?>
