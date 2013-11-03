<?php

define('KEEP_IMAGE_ACTION', 'Keep');
define('REMOVE_IMAGE_ACTION', 'Remove');
define('REPLACE_IMAGE_ACTION', 'Replace');

class TableDataset extends Dataset
{
    private $tableName;

    function __construct($ConnectionFactory, $ConnectionParams, $TableName)
    {
        parent::__construct($ConnectionFactory, $ConnectionParams);
        $this->SetTableName($TableName);
    }

    #region Commands

    protected function CreateSelectCommand()
    {
        return $this->GetConnectionFactory()->CreateSelectCommand();
    }

    protected function DoCreateUpdateCommand()
    {
        $result = $this->GetConnectionFactory()->CreateUpdateCommand();;
        $result->SetTableName($this->tableName);
        foreach($this->GetFields() as $field)
            $result->AddField($field->GetName(), $field->GetEngFieldType(), in_array($field->GetName(), $this->GetPrimaryKeyFields()));
        return $result;
    }

    protected function DoCreateInsertCommand()
    {
        $result = $this->GetConnectionFactory()->CreateInsertCommand();
        $result->SetTableName($this->tableName);
        foreach($this->GetFields() as $field)
            $result->AddField($field->GetName(), $field->GetEngFieldType());
        return $result;
    }

    protected function DoCreateDeleteCommand()
    {
        $result = $this->GetConnectionFactory()->CreateDeleteCommand();
        $result->SetTableName($this->tableName);
        foreach($this->GetFields() as $field)
            if ($this->IsFieldPrimaryKey($field->GetName()))
                $result->AddField($field->GetName(), $field->GetEngFieldType());
        return $result;
    }

    #endregion

    public function SetTableName($tableName)
    {
        $this->tableName = $tableName;
        $this->GetSelectCommand()->SetSourceTableName($tableName, null);
    }
    
    protected function DoAddField($field)
    {
        $sourceTable = $field->GetSourceTable();
        if (!isset($sourceTable) || $sourceTable == '')
            $sourceTable = $this->tableName;
        $this->GetSelectCommand()->AddField(
            $sourceTable, $field->GetName(), 
            $field->GetEngFieldType(), $field->GetAlias());
    }

    public function AddLookupField($fieldName, $lookUpTable, $lookUpLinkField, $lookupDisplayField, $lookUpTableAlias )
    {
        parent::AddLookupField($fieldName, $lookUpTable, $lookUpLinkField, $lookupDisplayField, $lookUpTableAlias);

        $sourceTable = $lookupDisplayField->GetSourceTable();
        if (!isset($sourceTable) || $sourceTable == '')
            $sourceTable = $this->tableName;
        else
            $sourceTable = $this->GetCommandImp()->QuoteIndetifier($sourceTable);
        $lookupDisplayField->SetSourceTable($sourceTable);
        
        $this->AddField($lookupDisplayField);

        $this->GetSelectCommand()->AddJoin(jkLeftOuter,
            $lookUpTable,
            $fieldName,
            $lookUpLinkField->GetName(),
            $lookUpTableAlias
        );
    }
}    
