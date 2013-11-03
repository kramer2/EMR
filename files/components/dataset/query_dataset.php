<?php

class QueryDataset extends Dataset
{
    private $sql;
    private $insertSql;
    private $updateSql;

    function __construct($ConnectionFactory, $ConnectionParams, $sql, $insertSql, $updateSql, $deleteSql)
    {
        $this->sql = $sql;
        $this->insertSql = $insertSql;
        $this->updateSql = $updateSql;
        $this->deleteSql = $deleteSql;
        Dataset::__construct($ConnectionFactory, $ConnectionParams);
    }

    #region Commands

    function CreateSelectCommand()
    {
        return $this->GetConnectionFactory()->CreateCustomSelectCommand($this->sql);
    }

    protected function DoCreateUpdateCommand()
    {
        $result = $this->GetConnectionFactory()->CreateCustomUpdateCommand($this->updateSql);
        foreach($this->GetFields() as $field)
            $result->AddField($field->GetName(), $field->GetEngFieldType(), $this->IsFieldPrimaryKey($field->GetName()));
        return $result;
    }

    protected function DoCreateInsertCommand()
    {
        $result = $this->GetConnectionFactory()->CreateCustomInsertCommand($this->insertSql);
        foreach($this->GetFields() as $field)
            $result->AddField($field->GetName(), $field->GetEngFieldType());
        return $result;
    }

    protected function DoCreateDeleteCommand()
    {
        $result = $this->GetConnectionFactory()->CreateCustomDeleteCommand($this->deleteSql);
        foreach($this->GetFields() as $field)
            if ($this->IsFieldPrimaryKey($field->GetName()))
                $result->AddField($field->GetName(), $field->GetEngFieldType());
        return $result;
    }

    #endregion

    protected function DoAddField($field)
    {
        $this->GetSelectCommand()->AddField(
            $field->GetSourceTable(), $field->GetName(), 
            $field->GetEngFieldType(), $field->GetAlias()
            );
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

?>