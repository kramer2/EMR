<?php
require_once 'database_engine/engine.php';
require_once 'components/common_utils.php';
require_once 'components/utils/array_utils.php';

abstract class Field
{
    private $name;
    private $alias;
    private $sourceTable;
    private $isAutoincrement;
    protected $connectionFactory;

    private $readOnly;
    private $defaultValue;

    public function __construct($name, $alias = null, $sourceTable = null, $isAutoincrement = false)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->sourceTable = $sourceTable;

        $this->readOnly = false;
        $this->defaultValue = null;
        $this->isAutoincrement = $isAutoincrement;

    }

    public function SetReadOnly($readOnly, $defaultValue = null)
    {
        $this->readOnly = $readOnly;
        $this->defaultValue = $defaultValue;
    }

    public function GetIsAutoincrement()
    { return $this->isAutoincrement; }

    public function GetReadOnly()
    { return $this->readOnly; }

    public function GetDefaultValue()
    { return $this->defaultValue; }

    public function GetSourceTable()
    { return $this->sourceTable; }
    public function SetSourceTable($value)
    { $this->sourceTable = $value; }

    public function GetAlias()
    { return $this->alias; }

    public function GetName()
    { return $this->name; }

    public function GetNameInDataset()
    {
        return $this->GetAlias() == '' ? $this->GetName() : $this->GetAlias();
    }

    public function SetConnectionFactory($value)
    { $this->connectionFactory = $value; }

    public function DoGetDisplayValue($sqlValue)
    { return $sqlValue; }
    public function GetDisplayValue($sqlValue)
    {
        return !isset($sqlValue) ? null : $this->DoGetDisplayValue($sqlValue);
    }

    public function GetDisplayValueAsDateTime($sqlValue)
    {
        assert(false);
    }

    protected function DoGetValueForSql($value)
    { return $value; }
    public function GetValueForSql($value)
    {
        return $value == null ? $value : $this->DoGetValueForSql($value);
    }

    abstract function GetEngFieldType();
}

class BooleanField extends Field
{
    function GetEngFieldType()
    {
        return ftBoolean;
    }
}

class IntegerField extends Field
{
    function GetEngFieldType()
    {
        return ftNumber;
    }
}

class StringField extends Field
{
    function GetEngFieldType()
    {
        return ftString;
    }
}

class BlobField extends Field
{
    function GetEngFieldType()
    {
        return ftBlob;
    }

    public function GetDisplayValue($sqlValue)
    {
        return !isset($sqlValue) ? null : $this->DoGetDisplayValue($sqlValue);
    }
}

class DateField extends Field
{
    private $dateFormat;

    public function __construct($name, $dateFormat = 'Y-m-d', $alias = null, $sourceTable = null, $isAutoincrement = false)
    {
        parent::__construct($name, $alias, $sourceTable, $isAutoincrement);
        $this->dateFormat = $dateFormat;
    }

    public function DoGetDisplayValue($sqlValue)
    {
        if (empty($sqlValue))
            return null;
        else
            return $sqlValue->ToString($this->dateFormat);
    }

    public function GetDisplayValueAsDateTime($sqlValue)
    {
        return isset($sqlValue) ? $sqlValue : null;
    }

    protected function DoGetValueForSql($value)
    {
        return SMDateTime::Parse($value, $this->dateFormat);
    }

    function GetEngFieldType()
    {
        return ftDate;
    }
}

class TimeField extends Field
{
    private $timeFormat;

    public function __construct($name, $timeFormat = 'H:i:s', $alias = null, $sourceTable = null, $isAutoincrement = false)
    {
        parent::__construct($name, $alias, $sourceTable, $isAutoincrement);
        $this->timeFormat = $timeFormat;
    }

    public function DoGetDisplayValue($sqlValue)
    {
        if (empty($sqlValue))
            return null;
        else
        return $sqlValue->ToString($this->timeFormat);
    }

    public function GetDisplayValueAsDateTime($sqlValue)
    {
        return isset($sqlValue) ? $sqlValue : null;
    }

    protected function DoGetValueForSql($value)
    {
        return SMDateTime::Parse($value, $this->timeFormat);
    }

    function GetEngFieldType()
    {
        return ftTime;
    }
}

class DateTimeField extends Field
{
    private $dateTimeFormat;

    public function __construct($name, $dateTimeFormat = 'Y-m-d H:i:s', $alias = null, $sourceTable = null, $isAutoincrement = false)
    {
        parent::__construct($name, $alias, $sourceTable, $isAutoincrement);
        $this->dateTimeFormat = $dateTimeFormat;
    }

    public function DoGetDisplayValue($sqlValue)
    {
        if (empty($sqlValue))
            return null;
        else
        return $sqlValue->ToString($this->dateTimeFormat);
    }

    protected function DoGetValueForSql($value)
    {
        return SMDateTime::Parse($value, $this->dateTimeFormat);
    }

    public function GetDisplayValueAsDateTime($sqlValue)
    {
        return isset($sqlValue) ? $sqlValue : null;
    }

    function GetEngFieldType()
    {
        return ftDateTime;
    }
}

abstract class Dataset
{
    private $connectionFactory;
    private $engDataset;
    private $connection;
    //
    private $selectCommand;
    //
    private $fields;
    private $fieldMap;
    private $primaryKeyFields;
    protected $fieldFilters;
    //
    private $editFieldValues;
    private $editFieldSetToDefault;
    //
    private $insertFieldValues;
    private $insertFieldSetToDefault;
    private $clientEncoding;

    #region Events 
    public $OnNextRecord;
    public $OnAfterConnect;
    #endregion

    private $commandImp;

    function __construct($ConnectionFactory, $ConnectionParams)
    {
        $this->OnAfterConnect = new Event();
        $this->connectionFactory = $ConnectionFactory;
        $this->connectionParams = $ConnectionParams;
        $this->selectCommand = $this->CreateSelectCommand();

        $this->fields = array();
        $this->fieldMap = array();
        $this->primaryKeyFields = array();
        $this->fieldFilters = array();
        $this->editFieldSetToDefault = array();
        $this->insertFieldSetToDefault = array();
        $this->defaultFieldValues = array();
        $this->clientEncoding = null;

        $this->editFieldValues = array();
        $this->editFieldSetToDefault = array();
        $this->OnNextRecord = new Event();
    }

    private function DoOnNextRecord()
    {
        $this->OnNextRecord->Fire(array($this));
    }

    public function SetClientEncoding($value)
    { $this->clientEncoding = $value; }
    public function GetPrimaryKeyFields()
    { return $this->primaryKeyFields; }

    // <commands>
    protected abstract function CreateSelectCommand();

    protected function GetSelectCommand()
    { return $this->selectCommand; }

    protected abstract function DoCreateUpdateCommand();
    protected abstract function DoCreateInsertCommand();
    protected abstract function DoCreateDeleteCommand();

    private function CreateUpdateCommand()
    {
        $result = $this->DoCreateUpdateCommand();
        return $result;
    }

    private function CreateInsertCommand()
    {
        $result = $this->DoCreateInsertCommand();
        return $result;
    }

    private function CreateDeleteCommand()
    {
        $result = $this->DoCreateDeleteCommand();
        return $result;
    }
    // </commands>

    function GetConnectionFactory()
    { return $this->connectionFactory; }
    function GetConnectionParams()
    { return $this->connectionParams; }
    function GetConnection()
    { return $this->connection; }

    protected function GetCommandImp()
    {
        if (!isset($this->commandImp))
            $this->commandImp = $this->connectionFactory->CreateEngCommandImp();
        return $this->commandImp;
    }

    function Connect()
    {
        if (!isset($this->connection))
        {
            $this->connection = $this->connectionFactory->CreateConnection($this->connectionParams);
            $this->connection->OnAfterConnect->AddListener('AfterConnectHandler', $this);
            $this->connection->Connect();
        }
    }

    function AfterConnectHandler($connection)
    {
        $this->OnAfterConnect->Fire(array(&$connection));
    }

    function Open()
    {
        $this->Connect();
        if (defined('DEBUG_LEVEL') && DEBUG_LEVEL == 1)
            echo $this->selectCommand->GetSQL() . '<br>';
        $this->engDataset = $this->selectCommand->Execute($this->GetConnection());
        $this->rowIndex = 0;
        $this->insertedMode = false;
    }

    function Next()
    {
        $this->rowIndex++;
        $result = $this->engDataset->Next();
        $this->DoOnNextRecord();
        return $result;
    }

    function GetCurrentRowIndex()
    { return $this->rowIndex; }

    function Close()
    {
        $this->SetAllRecordsState();
        $this->rowIndex = 0;
        $this->engDataset->Close();
        $this->DoAfterClose();
    }

    protected function DoAfterClose()
    { }

    // <editing>
    private $editMode;
    private $insertMode;
    private $insertedMode = false;

    function Edit()
    {
        $this->editMode = true;
    }

    function Insert()
    {
        $this->insertedMode = false;
        $this->insertMode = true;
    }

    function Delete()
    {
        $deleteCommand = $this->CreateDeleteCommand();
        $primaryKeyValues = $this->GetPrimaryKeyValuesMap();

        foreach($primaryKeyValues as $keyFieldName => $value)
        {
            $deleteCommand->SetKeyFieldValue($keyFieldName, $value);
        }

        if (defined('DEBUG_LEVEL') && DEBUG_LEVEL == 1)
            echo $deleteCommand->GetSQL() . '<br>';
        $deleteCommand->Execute($this->GetConnection());
    }

    function Post()
    {
        if ($this->editMode)
        {
            if (count($this->editFieldValues) > 0 || count($this->editFieldSetToDefault) > 0)
            {
                $updateCommand = $this->CreateUpdateCommand();

                $primaryKeyValues = $this->GetOldPrimaryKeyValuesMap();

                foreach($primaryKeyValues as $keyFieldName => $value)
                    $updateCommand->SetKeyFieldValue($keyFieldName, $value);

                foreach($this->editFieldValues as $fieldName => $value)
                {
                    if (in_array($fieldName, $this->editFieldSetToDefault))
                        $updateCommand->SetParameterValue($fieldName, null, true);
                    else
                        $updateCommand->SetParameterValue($fieldName, $value);
                }

                foreach($this->GetFields() as $field)
                    if ($field->GetReadOnly())
                        $updateCommand->SetParameterValue($field->GetNameInDataset(), $field->GetDefaultValue());

                if (defined('DEBUG_LEVEL') && DEBUG_LEVEL >= 1)
                    echo $updateCommand->GetSQL() . '<br>';

                $updateCommand->Execute($this->GetConnection());
            }
            $this->editMode = false;
        }
        elseif ($this->insertMode)
        {
            $hasValuesForAutoIncrement = false;
            $insertCommand = $this->CreateInsertCommand() or RaiseError('Could not create InsertCommand');

            $this->Connect();

            foreach($this->masterFieldValue as $fieldName => $value)
                $insertCommand->SetParameterValue($fieldName, $value);

            foreach($this->insertFieldValues as $fieldName => $value)
            {
                if (in_array($fieldName, $this->insertFieldSetToDefault))
                {
                    if (!$this->GetFieldByName($fieldName)->GetIsAutoincrement())
                        $insertCommand->SetParameterValue($fieldName, null, true);
                }
                else
                {
                    if ($this->GetFieldByName($fieldName)->GetIsAutoincrement())
                        $hasValuesForAutoIncrement = true;
                    $insertCommand->SetParameterValue($fieldName, $value);
                }
            }

            foreach($this->GetFields() as $field)
                if ($field->GetReadOnly())
                    $insertCommand->SetParameterValue($field->GetNameInDataset(), $field->GetDefaultValue());

            foreach($this->defaultFieldValues as $fieldName => $value)
                $insertCommand->SetParameterValue($fieldName, $value);

            $insertCommand->SetAutoincrementInsertion($hasValuesForAutoIncrement);

            if (defined('DEBUG_LEVEL') && DEBUG_LEVEL == 1)
                echo $insertCommand->GetSQL() . '<br>';
            $insertCommand->Execute($this->GetConnection());
            $this->UpdatePrimaryKeyAfterInserting();
            $this->insertMode = false;
            $this->insertedMode = true;
        }
    }
    private function UpdatePrimaryKeyAfterInserting()
    {
        $primaryKeyColumns = $this->GetPrimaryKeyFieldNames();
        if (count($primaryKeyColumns) == 1)
        {
            if ($this->GetConnection()->SupportsLastInsertId())
                $this->insertFieldValues[$primaryKeyColumns[0]] = $this->GetConnection()->GetLastInsertId();
        }
    }

    // </editing>

    function GetFieldValueAsSQLByNameForInsert($fieldName, $value)
    {
        return $this->GetFieldByName($fieldName)->GetValueForSql($value);
    }

    function GetFieldValueAsSQLByNameForUpdate($fieldName, $value, $setToDefault = false)
    {
        return $this->GetFieldByName($fieldName)->GetValueForSql($value);
    }

    function GetCurrentFieldValues()
    {
        if ($this->editMode)
            return $this->GetEditFieldValues();
        elseif ($this->insertMode || $this->insertedMode)
            return $this->GetInsertFieldValues();
        else
            return $this->GetFieldValues();
    }

    private function GetEditFieldValues()
    {
        return $this->editFieldValues;
    }

    private function GetInsertFieldValues()
    {
        return $this->insertFieldValues;
    }

    function SetFieldValueByName($fieldName, $value, $setToDefault = false)
    {
        if ($this->editMode)
        {
            $valueForSql = $this->GetFieldValueAsSQLByNameForUpdate($fieldName, $value);
            $this->editFieldValues[$fieldName] = $valueForSql;

            if ($setToDefault)
            {
                $this->editFieldValues[$fieldName] = null;
                $this->editFieldSetToDefault[] = $fieldName;
            }
        }
        else if ($this->insertMode || $this->insertedMode)
            {
                $valueForSql = $this->GetFieldValueAsSQLByNameForInsert($fieldName, $value);
                $this->insertFieldValues[$fieldName] = $valueForSql;
                if ($setToDefault)
                {
                    $this->insertFieldValues[$fieldName] = null;
                    $this->insertFieldSetToDefault[] = $fieldName;
                }
            }
    }

    private $defaultFieldValues;

    public function AddDefaultFieldValue($fieldName, $value)
    {
        $this->defaultFieldValues[$fieldName] = $value;
    }

    function GetFieldValueByName($fieldName)
    {
        if ($this->insertMode || $this->insertedMode)
        {
            if (array_key_exists($fieldName, $this->insertFieldValues))
                return $this->GetFieldByName($fieldName)->GetDisplayValue($this->insertFieldValues[$fieldName]);
            else
                return '';
        }
        else if ($this->editMode)
        {
            if (array_key_exists($fieldName, $this->editFieldValues))
                return $this->GetFieldByName($fieldName)->GetDisplayValue($this->editFieldValues[$fieldName]);
            else if (in_array($fieldName, $this->defaultFieldValues))
                return $this->defaultFieldValues[$fieldName];
            else
            {
                return $this->GetFieldByName($fieldName)->GetDisplayValue($this->engDataset->GetFieldValueByName($fieldName));
            }

        }
        else
        {
            if (in_array($fieldName, $this->defaultFieldValues))
                return $this->defaultFieldValues[$fieldName];
            else
            {
                return $this->GetFieldByName($fieldName)->GetDisplayValue($this->engDataset->GetFieldValueByName($fieldName));
            }
        }
    }

    function GetFieldValueByNameAsDateTime($fieldName)
    {
        if ($this->insertMode || $this->insertedMode)
        {
            if (array_key_exists($fieldName, $this->insertFieldValues))
                return $this->GetFieldByName($fieldName)->GetDisplayValueAsDateTime($this->insertFieldValues[$fieldName]);
            else
                return null;
        }
        else
        {
            if (in_array($fieldName, $this->defaultFieldValues))
                return $this->defaultFieldValues[$fieldName];
            else
            {
                return $this->GetFieldByName($fieldName)->GetDisplayValueAsDateTime($this->engDataset->GetFieldValueByName($fieldName));
            }
        }
        
    }

    public function GetFieldValues()
    {
        $result = array();
        foreach ($this->GetFields() as $field)
            $result[$field->GetNameInDataset()] = $field->GetDisplayValue($this->engDataset->GetFieldValueByName($field->GetNameInDataset()));
        return $result;
    }

    #region Fields
    public function GetFields()
    { return $this->fields; }

    public function GetFieldByName($fieldName)
    {
        if (isset($this->fieldMap[$fieldName]))
            return $this->fieldMap[$fieldName];
        else
            return null;
    }

    protected function DoAddField($field)
    {
        $this->selectCommand->AddField($field->GetSourceTable(), $field->GetName(), $field->GetEngFieldType(), $field->GetAlias());
    }

    public function AddField($field, $isPrimaryKeyField = false)
    {
        $field->SetConnectionFactory($this->connectionFactory);
        $this->fields[] = $field;
        $this->fieldMap[$field->GetNameInDataset()] = $field;
        $this->DoAddField($field);
        if ($isPrimaryKeyField)
            $this->primaryKeyFields[] = $field->GetName();
    }

    public function IsFieldPrimaryKey($fieldName)
    {
        return in_array($fieldName, $this->primaryKeyFields);
    }

    public function GetPrimaryKeyFieldNames()
    { return $this->primaryKeyFields; }

    public function GetPrimaryKeyValues()
    {
        $result = array();
        foreach($this->primaryKeyFields as $primaryKeyField)
            $result[] = $this->GetFieldValueByName($primaryKeyField);
        return $result;
    }

    public function GetOldPrimaryKeyValuesMap()
    {
        $this->editMode = false;
        $result = array();
        foreach($this->primaryKeyFields as $primaryKeyField)
            $result[$primaryKeyField] = $this->GetFieldValueByName($primaryKeyField);
        $this->editMode = true;
        return $result;
    }

    public function GetPrimaryKeyValuesMap()
    {
        $result = array();
        foreach($this->primaryKeyFields as $primaryKeyField)
            $result[$primaryKeyField] = $this->GetFieldValueByName($primaryKeyField);
        return $result;
    }
    #endregion

    #region Data navigation
    private $singleRecordFilters = array();

    function SetSingleRecordState($primaryKeyValues)
    {
        $primaryKeyValuesMap = array();
        $primaryKeyFields = $this->GetPrimaryKeyFieldNames();
        for($i = 0; $i < count($primaryKeyFields); $i++)
        {
            $filter = new FieldFilter($primaryKeyValues[$i], '=');
            $this->singleRecordFilters[$primaryKeyFields[$i]] = $filter;

            $this->GetSelectCommand()->AddFieldFilter(
                $primaryKeyFields[$i],
                $filter);
        }
    }

    function SetAllRecordsState()
    {
        foreach($this->singleRecordFilters as $keyFieldName => $filter)
            $this->GetSelectCommand()->RemoveFieldFilter($keyFieldName, $filter);
    }

    public function SetUpLimit($upLimit)
    {
        $this->GetSelectCommand()->SetUpLimit($upLimit);
    }

    public function SetLimit($limit)
    {
        $this->GetSelectCommand()->SetLimitCount($limit);
    }

    protected function CheckConnect()
    {
        $this->Connect();
    }

    function GetTotalRowCount()
    {
        $this->CheckConnect();
        $result = $this->GetSelectCommand()->GetSelectRecordCountSQL();
        return $this->GetConnection()->ExecScalarSQL($result);
    }

    public function AddFieldFilter($fieldName, $fieldFilter)
    {
        $this->GetSelectCommand()->AddFieldFilter($fieldName, $fieldFilter);
    }

    public function ClearFieldFilters()
    {
        $this->GetSelectCommand()->ClearFieldFilters();
    }

    public function AddCompositeFieldFilter($filterLinkType, $fieldNames, $fieldFilters)
    {
        $this->GetSelectCommand()->AddCompositeFieldFilter(
            $filterLinkType, $fieldNames, $fieldFilters);
    }

    public function AddCustomCondition($condition)
    {
        $this->GetSelectCommand()->AddCustomCondition($condition);
    }

    public function SetOrderBy($fieldName, $orderType)
    {
        $this->GetSelectCommand()->SetOrderBy($fieldName, $orderType);
    }
    #endregion

    private $masterFieldValue = array();

    function SetMasterFieldValue($fieldName, $value)
    { $this->masterFieldValue[$fieldName] = $value; }

    function GetMasterFieldValueByName($fieldName)
    {
        return ArrayUtils::GetArrayValueDef($this->masterFieldValue, $fieldName);
    }

    private $lookupFields = array();

    public function AddLookupField($fieldName, $lookUpTable, $lookUpLinkField, $lookupDisplayField, $lookUpTableAlias)
    {
        $this->lookupFields[$lookupDisplayField->GetAlias()] = $fieldName;
    }

    public function IsLookupField($fieldName)
    {
        return array_key_exists($fieldName, $this->lookupFields);
    }

    public function IsLookupFieldNameByDisplayFieldName($displayFieldName)
    {
        return $this->lookupFields[$displayFieldName];
    }

}

?>