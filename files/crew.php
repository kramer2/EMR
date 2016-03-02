<?php

    require_once 'database_engine/mysql_engine.php';
    require_once 'components/page.php';
    require_once 'settings.php';
    require_once 'authorization.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthorizationStrategy()->ApplyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    ?><?php
    
    ?><?php
    
    class historyDetailView0Page extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`history`');
            $field = new IntegerField('hid', null, null, true);
            $this->dataset->AddField($field, true);
            $field = new DateField('date');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('pid');
            $this->dataset->AddField($field, false);
            $field = new StringField('complaint');
            $this->dataset->AddField($field, false);
            $field = new StringField('examination');
            $this->dataset->AddField($field, false);
            $field = new StringField('diagnose');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('sid');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('qty');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('pid', 'crew', new IntegerField('pid', null, null, true), new StringField('last_name', 'pid_last_name', 'pid_last_name_crew'), 'pid_last_name_crew');
            $this->dataset->AddLookupField('sid', 'stock', new IntegerField('sid', null, null, true), new StringField('generic_name', 'sid_generic_name', 'sid_generic_name_stock'), 'sid_generic_name_stock');
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', $this->GetLocalizerCaptions()->GetMessageString('Date'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString('patient'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'patient', 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'patient', 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for complaint field
            //
            $column = new TextViewColumn('complaint', $this->GetLocalizerCaptions()->GetMessageString('Complaint'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Complaint', 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Complaint', 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for examination field
            //
            $column = new TextViewColumn('examination', $this->GetLocalizerCaptions()->GetMessageString('Examination'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Examination', 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Examination', 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diagnose field
            //
            $column = new TextViewColumn('diagnose', $this->GetLocalizerCaptions()->GetMessageString('Diagnose'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Diagnose', 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Diagnose', 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString('medicine'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'medicine', 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'medicine', 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qty field
            //
            $column = new TextViewColumn('qty', $this->GetLocalizerCaptions()->GetMessageString('Qty'), $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties($column)
        {
            $column->SetShowSetToNullCheckBox(true);
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'historyDetailViewGrid0');
            $result->SetAllowDeleteSelected(false);
            
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
    
            return $result;
        }
    }
    
    
    
    ?><?php
    
    ?><?php
    
    class historyDetailEdit0Page extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`history`');
            $field = new IntegerField('hid', null, null, true);
            $this->dataset->AddField($field, true);
            $field = new DateField('date');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('pid');
            $this->dataset->AddField($field, false);
            $field = new StringField('complaint');
            $this->dataset->AddField($field, false);
            $field = new StringField('examination');
            $this->dataset->AddField($field, false);
            $field = new StringField('diagnose');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('sid');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('qty');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('pid', 'crew', new IntegerField('pid', null, null, true), new StringField('last_name', 'pid_last_name', 'pid_last_name_crew'), 'pid_last_name_crew');
            $this->dataset->AddLookupField('sid', 'stock', new IntegerField('sid', null, null, true), new StringField('generic_name', 'sid_generic_name', 'sid_generic_name_stock'), 'sid_generic_name_stock');
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('historyDetailEdit0ssearch', $this->dataset,
                array('date', 'pid_last_name', 'complaint', 'examination', 'diagnose', 'sid_generic_name', 'qty'),
                array($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Date')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('patient')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Complaint')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Examination')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Diagnose')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('medicine')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Qty'))),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl($grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('historyDetailEdit0asearch', $this->dataset, $this->GetLocalizerCaptions());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('date', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Date'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('patient'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('complaint', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Complaint'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('examination', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Examination'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('diagnose', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Diagnose'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('medicine'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('qty', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Qty'))));
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function AddOperationsColumns($grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/delete_action.png');
                $column->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', $this->GetLocalizerCaptions()->GetMessageString('Date'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Date', 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString('patient'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'patient', 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'patient', 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for complaint field
            //
            $column = new TextViewColumn('complaint', $this->GetLocalizerCaptions()->GetMessageString('Complaint'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Complaint', 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Complaint', 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for examination field
            //
            $column = new TextViewColumn('examination', $this->GetLocalizerCaptions()->GetMessageString('Examination'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Examination', 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Examination', 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diagnose field
            //
            $column = new TextViewColumn('diagnose', $this->GetLocalizerCaptions()->GetMessageString('Diagnose'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Diagnose', 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Diagnose', 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString('medicine'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'medicine', 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'medicine', 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for qty field
            //
            $column = new TextViewColumn('qty', $this->GetLocalizerCaptions()->GetMessageString('Qty'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn('Qty', 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', $this->GetLocalizerCaptions()->GetMessageString('Date'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString('patient'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for complaint field
            //
            $column = new TextViewColumn('complaint', $this->GetLocalizerCaptions()->GetMessageString('Complaint'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for examination field
            //
            $column = new TextViewColumn('examination', $this->GetLocalizerCaptions()->GetMessageString('Examination'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diagnose field
            //
            $column = new TextViewColumn('diagnose', $this->GetLocalizerCaptions()->GetMessageString('Diagnose'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString('medicine'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qty field
            //
            $column = new TextViewColumn('qty', $this->GetLocalizerCaptions()->GetMessageString('Qty'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Date'), 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                $this->GetLocalizerCaptions()->GetMessageString('patient'), 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Complaint'), 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Examination'), 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Diagnose'), 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                $this->GetLocalizerCaptions()->GetMessageString('medicine'), 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Qty'), 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns($grid)
        {
            //
            // Edit column for date field
            //
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Date'), 'date', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Date'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pid field
            //
            $editor = new ComboBox('pid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('last_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('last_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                $this->GetLocalizerCaptions()->GetMessageString('patient'), 
                'pid', 
                $editor, 
                $this->dataset, 'pid', 'last_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'patient'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for complaint field
            //
            $editor = new TextEdit('complaint_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Complaint'), 'complaint', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Complaint'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for examination field
            //
            $editor = new TextEdit('examination_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Examination'), 'examination', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Examination'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diagnose field
            //
            $editor = new TextEdit('diagnose_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Diagnose'), 'diagnose', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Diagnose'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sid field
            //
            $editor = new ComboBox('sid_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock`');
            $field = new IntegerField('sid', null, null, true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('generic_name');
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('generic_name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                $this->GetLocalizerCaptions()->GetMessageString('medicine'), 
                'sid', 
                $editor, 
                $this->dataset, 'sid', 'generic_name', $lookupDataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'medicine'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qty field
            //
            $editor = new TextEdit('qty_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Qty'), 'qty', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Qty'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns($grid)
        {
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', $this->GetLocalizerCaptions()->GetMessageString('Date'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString('patient'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for complaint field
            //
            $column = new TextViewColumn('complaint', $this->GetLocalizerCaptions()->GetMessageString('Complaint'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for examination field
            //
            $column = new TextViewColumn('examination', $this->GetLocalizerCaptions()->GetMessageString('Examination'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for diagnose field
            //
            $column = new TextViewColumn('diagnose', $this->GetLocalizerCaptions()->GetMessageString('Diagnose'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString('medicine'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for qty field
            //
            $column = new TextViewColumn('qty', $this->GetLocalizerCaptions()->GetMessageString('Qty'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for hid field
            //
            $column = new TextViewColumn('hid', 'Hid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for date field
            //
            $column = new DateTimeViewColumn('date', $this->GetLocalizerCaptions()->GetMessageString('Date'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString('patient'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for complaint field
            //
            $column = new TextViewColumn('complaint', $this->GetLocalizerCaptions()->GetMessageString('Complaint'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for examination field
            //
            $column = new TextViewColumn('examination', $this->GetLocalizerCaptions()->GetMessageString('Examination'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for diagnose field
            //
            $column = new TextViewColumn('diagnose', $this->GetLocalizerCaptions()->GetMessageString('Diagnose'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString('medicine'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for qty field
            //
            $column = new TextViewColumn('qty', $this->GetLocalizerCaptions()->GetMessageString('Qty'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties($column)
        {
            $column->SetShowSetToNullCheckBox(true);
    	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function ShowEditButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'historyDetailEditGrid0');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
                $result->SetAllowDeleteSelected(true);
            else
                $result->SetAllowDeleteSelected(false);
            ApplyCommonPageSettings($this, $result);
            $result->SetUseImagesForActions(true);
            
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
    
            return $result;
        }
        
        protected function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }    
    }
    ?><?php
    
    ?><?php
    
    class crewPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`crew`');
            $field = new IntegerField('pid', null, null, true);
            $this->dataset->AddField($field, true);
            $field = new StringField('first_name');
            $this->dataset->AddField($field, false);
            $field = new StringField('middle_name');
            $this->dataset->AddField($field, false);
            $field = new StringField('last_name');
            $this->dataset->AddField($field, false);
            $field = new DateField('dob');
            $this->dataset->AddField($field, false);
            $field = new StringField('rank');
            $this->dataset->AddField($field, false);
            $field = new StringField('sex');
            $this->dataset->AddField($field, false);
            $field = new StringField('company');
            $this->dataset->AddField($field, false);
            $field = new StringField('alcohol');
            $this->dataset->AddField($field, false);
            $field = new StringField('smoking');
            $this->dataset->AddField($field, false);
            $field = new StringField('allergies');
            $this->dataset->AddField($field, false);
            $field = new StringField('medication');
            $this->dataset->AddField($field, false);
            $field = new StringField('immunization');
            $this->dataset->AddField($field, false);
            $field = new StringField('info');
            $this->dataset->AddField($field, false);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList();
            if (GetCurrentUserGrantForDataSource('crew')->HasViewGrant())
                $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Crew')), 'crew.php', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Crew')), $currentPageCaption == $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Crew'))));
            if (GetCurrentUserGrantForDataSource('history')->HasViewGrant())
                $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('History')), 'history.php', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('History')), $currentPageCaption == $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('History'))));
            if (GetCurrentUserGrantForDataSource('stock')->HasViewGrant())
                $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock')), 'stock.php', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock')), $currentPageCaption == $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock'))));
            if (GetCurrentUserGrantForDataSource('stock_expiry')->HasViewGrant())
                $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Expiry')), 'stock_expiry.php', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Expiry')), $currentPageCaption == $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Expiry'))));
            if (GetCurrentUserGrantForDataSource('stock_refresh')->HasViewGrant())
                $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Refresh')), 'stock_refresh.php', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Refresh')), $currentPageCaption == $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock_Refresh'))));
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl($grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('crewssearch', $this->dataset,
                array('first_name', 'middle_name', 'last_name', 'dob', 'rank', 'company'),
                array($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('First_Name')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Middle_Name')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Last_Name')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Dob')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Rank')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Company'))),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl($grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('crewasearch', $this->dataset, $this->GetLocalizerCaptions());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('first_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('First_Name'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('middle_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Middle_Name'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('last_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Last_Name'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('dob', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Dob'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('rank', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Rank'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('sex', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Sex'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('company', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Company'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('alcohol', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Alcohol'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('smoking', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Smoking'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('allergies', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Allergies'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('medication', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Medication'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('immunization', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Immunization'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('info', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Info'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Pid'))));
        }
    
        protected function AddOperationsColumns($grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/delete_action.png');
                $column->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = $grid->AddViewColumn(new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset), $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns($grid)
        {
            if (GetCurrentUserGrantForDataSource('historyDetailView0')->HasViewGrant())
            {
              //
            // View column for historyDetailView0 detail
            //
            $column = new DetailColumn(array('pid'), 'detail0', 'historyDetailEdit0_handler', 'historyDetailView0_handler', $this->dataset, $this->GetLocalizerCaptions()->GetMessageString('History'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', $this->GetLocalizerCaptions()->GetMessageString('First_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for middle_name field
            //
            $column = new TextViewColumn('middle_name', $this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Middle Name', 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Middle Name', 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', $this->GetLocalizerCaptions()->GetMessageString('Last_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for dob field
            //
            $column = new DateTimeViewColumn('dob', $this->GetLocalizerCaptions()->GetMessageString('Dob'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn('Dob', 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn('Dob', 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rank field
            //
            $column = new TextViewColumn('rank', $this->GetLocalizerCaptions()->GetMessageString('Rank'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Rank', 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Rank', 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for sex field
            //
            $column = new TextViewColumn('sex', $this->GetLocalizerCaptions()->GetMessageString('Sex'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn('Sex', 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn('Sex', 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for company field
            //
            $column = new TextViewColumn('company', $this->GetLocalizerCaptions()->GetMessageString('Company'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Company', 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Company', 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for alcohol field
            //
            $column = new TextViewColumn('alcohol', $this->GetLocalizerCaptions()->GetMessageString('Alcohol'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Alcohol', 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Alcohol', 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for smoking field
            //
            $column = new TextViewColumn('smoking', $this->GetLocalizerCaptions()->GetMessageString('Smoking'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->RenderText('N'));
            $editor->AddValue('Y', $this->RenderText('Y'));
            $editColumn = new CustomEditColumn('Smoking', 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->RenderText('N'));
            $editor->AddValue('Y', $this->RenderText('Y'));
            $editColumn = new CustomEditColumn('Smoking', 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for allergies field
            //
            $column = new TextViewColumn('allergies', $this->GetLocalizerCaptions()->GetMessageString('Allergies'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Allergies', 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Allergies', 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for medication field
            //
            $column = new TextViewColumn('medication', $this->GetLocalizerCaptions()->GetMessageString('Medication'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Medication', 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Medication', 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for immunization field
            //
            $column = new TextViewColumn('immunization', $this->GetLocalizerCaptions()->GetMessageString('Immunization'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Immunization', 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Immunization', 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for info field
            //
            $column = new TextViewColumn('info', $this->GetLocalizerCaptions()->GetMessageString('Info'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Info', 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn('Info', 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns($grid)
        {
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', $this->GetLocalizerCaptions()->GetMessageString('First_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for middle_name field
            //
            $column = new TextViewColumn('middle_name', $this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', $this->GetLocalizerCaptions()->GetMessageString('Last_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dob field
            //
            $column = new DateTimeViewColumn('dob', $this->GetLocalizerCaptions()->GetMessageString('Dob'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rank field
            //
            $column = new TextViewColumn('rank', $this->GetLocalizerCaptions()->GetMessageString('Rank'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for sex field
            //
            $column = new TextViewColumn('sex', $this->GetLocalizerCaptions()->GetMessageString('Sex'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for company field
            //
            $column = new TextViewColumn('company', $this->GetLocalizerCaptions()->GetMessageString('Company'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for alcohol field
            //
            $column = new TextViewColumn('alcohol', $this->GetLocalizerCaptions()->GetMessageString('Alcohol'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for smoking field
            //
            $column = new TextViewColumn('smoking', $this->GetLocalizerCaptions()->GetMessageString('Smoking'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for allergies field
            //
            $column = new TextViewColumn('allergies', $this->GetLocalizerCaptions()->GetMessageString('Allergies'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for medication field
            //
            $column = new TextViewColumn('medication', $this->GetLocalizerCaptions()->GetMessageString('Medication'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for immunization field
            //
            $column = new TextViewColumn('immunization', $this->GetLocalizerCaptions()->GetMessageString('Immunization'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for info field
            //
            $column = new TextViewColumn('info', $this->GetLocalizerCaptions()->GetMessageString('Info'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('First_Name'), 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Last_Name'), 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Dob'), 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Rank'), 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Sex'), 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Company'), 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Alcohol'), 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Smoking'), 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Allergies'), 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Medication'), 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Immunization'), 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Info'), 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns($grid)
        {
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('First_Name'), 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Last_Name'), 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Dob'), 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Rank'), 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Sex'), 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Company'), 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Alcohol'), 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Smoking'), 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Allergies'), 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Medication'), 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Immunization'), 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Info'), 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns($grid)
        {
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', $this->GetLocalizerCaptions()->GetMessageString('First_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for middle_name field
            //
            $column = new TextViewColumn('middle_name', $this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', $this->GetLocalizerCaptions()->GetMessageString('Last_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dob field
            //
            $column = new DateTimeViewColumn('dob', $this->GetLocalizerCaptions()->GetMessageString('Dob'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for rank field
            //
            $column = new TextViewColumn('rank', $this->GetLocalizerCaptions()->GetMessageString('Rank'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for sex field
            //
            $column = new TextViewColumn('sex', $this->GetLocalizerCaptions()->GetMessageString('Sex'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for company field
            //
            $column = new TextViewColumn('company', $this->GetLocalizerCaptions()->GetMessageString('Company'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for alcohol field
            //
            $column = new TextViewColumn('alcohol', $this->GetLocalizerCaptions()->GetMessageString('Alcohol'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for smoking field
            //
            $column = new TextViewColumn('smoking', $this->GetLocalizerCaptions()->GetMessageString('Smoking'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for allergies field
            //
            $column = new TextViewColumn('allergies', $this->GetLocalizerCaptions()->GetMessageString('Allergies'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for medication field
            //
            $column = new TextViewColumn('medication', $this->GetLocalizerCaptions()->GetMessageString('Medication'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for immunization field
            //
            $column = new TextViewColumn('immunization', $this->GetLocalizerCaptions()->GetMessageString('Immunization'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for info field
            //
            $column = new TextViewColumn('info', $this->GetLocalizerCaptions()->GetMessageString('Info'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for pid field
            //
            $column = new TextViewColumn('pid', 'Pid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', $this->GetLocalizerCaptions()->GetMessageString('First_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for middle_name field
            //
            $column = new TextViewColumn('middle_name', $this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', $this->GetLocalizerCaptions()->GetMessageString('Last_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dob field
            //
            $column = new DateTimeViewColumn('dob', $this->GetLocalizerCaptions()->GetMessageString('Dob'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for rank field
            //
            $column = new TextViewColumn('rank', $this->GetLocalizerCaptions()->GetMessageString('Rank'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for sex field
            //
            $column = new TextViewColumn('sex', $this->GetLocalizerCaptions()->GetMessageString('Sex'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for company field
            //
            $column = new TextViewColumn('company', $this->GetLocalizerCaptions()->GetMessageString('Company'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for alcohol field
            //
            $column = new TextViewColumn('alcohol', $this->GetLocalizerCaptions()->GetMessageString('Alcohol'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for smoking field
            //
            $column = new TextViewColumn('smoking', $this->GetLocalizerCaptions()->GetMessageString('Smoking'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for allergies field
            //
            $column = new TextViewColumn('allergies', $this->GetLocalizerCaptions()->GetMessageString('Allergies'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for medication field
            //
            $column = new TextViewColumn('medication', $this->GetLocalizerCaptions()->GetMessageString('Medication'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for immunization field
            //
            $column = new TextViewColumn('immunization', $this->GetLocalizerCaptions()->GetMessageString('Immunization'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for info field
            //
            $column = new TextViewColumn('info', $this->GetLocalizerCaptions()->GetMessageString('Info'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties($column)
        {
            $column->SetShowSetToNullCheckBox(true);
    	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGridForhistoryDetailEdit0Grid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForhistoryDetailEdit0');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for first_name field
            //
            $column = new TextViewColumn('first_name', $this->GetLocalizerCaptions()->GetMessageString('First_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for first_name field
            //
            $editor = new TextEdit('first_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('First Name', 'first_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'First Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for middle_name field
            //
            $column = new TextViewColumn('middle_name', $this->GetLocalizerCaptions()->GetMessageString('Middle_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Middle Name', 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for middle_name field
            //
            $editor = new TextEdit('middle_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Middle Name', 'middle_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Middle Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for last_name field
            //
            $column = new TextViewColumn('last_name', $this->GetLocalizerCaptions()->GetMessageString('Last_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for last_name field
            //
            $editor = new TextEdit('last_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Last Name', 'last_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Last Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for dob field
            //
            $column = new DateTimeViewColumn('dob', $this->GetLocalizerCaptions()->GetMessageString('Dob'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn('Dob', 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for dob field
            //
            $editor = new DateTimeEdit('dob_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn('Dob', 'dob', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Dob'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for rank field
            //
            $column = new TextViewColumn('rank', $this->GetLocalizerCaptions()->GetMessageString('Rank'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Rank', 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for rank field
            //
            $editor = new TextEdit('rank_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Rank', 'rank', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Rank'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for sex field
            //
            $column = new TextViewColumn('sex', $this->GetLocalizerCaptions()->GetMessageString('Sex'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn('Sex', 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for sex field
            //
            $editor = new CheckBoxGroup('sex_edit');
            $editor->AddValue('M', $this->RenderText('M'));
            $editor->AddValue('F', $this->RenderText('F'));
            $editColumn = new CustomEditColumn('Sex', 'sex', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sex'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for company field
            //
            $column = new TextViewColumn('company', $this->GetLocalizerCaptions()->GetMessageString('Company'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Company', 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for company field
            //
            $editor = new TextEdit('company_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Company', 'company', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Company'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for alcohol field
            //
            $column = new TextViewColumn('alcohol', $this->GetLocalizerCaptions()->GetMessageString('Alcohol'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Alcohol', 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for alcohol field
            //
            $editor = new CheckBoxGroup('alcohol_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Alcohol', 'alcohol', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for smoking field
            //
            $column = new TextViewColumn('smoking', $this->GetLocalizerCaptions()->GetMessageString('Smoking'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Smoking', 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for smoking field
            //
            $editor = new CheckBoxGroup('smoking_edit');
            $editor->AddValue('N', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('N')));
            $editor->AddValue('Y', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Y')));
            $editColumn = new CustomEditColumn('Smoking', 'smoking', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for allergies field
            //
            $column = new TextViewColumn('allergies', $this->GetLocalizerCaptions()->GetMessageString('Allergies'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Allergies', 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for allergies field
            //
            $editor = new TextEdit('allergies_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Allergies', 'allergies', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for medication field
            //
            $column = new TextViewColumn('medication', $this->GetLocalizerCaptions()->GetMessageString('Medication'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Medication', 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for medication field
            //
            $editor = new TextEdit('medication_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Medication', 'medication', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for immunization field
            //
            $column = new TextViewColumn('immunization', $this->GetLocalizerCaptions()->GetMessageString('Immunization'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Immunization', 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for immunization field
            //
            $editor = new TextEdit('immunization_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Immunization', 'immunization', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for info field
            //
            $column = new TextViewColumn('info', $this->GetLocalizerCaptions()->GetMessageString('Info'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Info', 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for info field
            //
            $editor = new TextEdit('info_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Info', 'info', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function ShowEditButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
        public function ShowDeleteButtonHandler($show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasDeleteGrant($this->GetDataset());
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'crewGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->SetShowPageList(true);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $handler = new PageHTTPHandler('historyDetailView0_handler', new historyDetailView0Page($this->GetLocalizerCaptions()->GetMessageString('History'), $this->GetLocalizerCaptions()->GetMessageString('History'), array('pid'), GetCurrentUserGrantForDataSource('historyDetailView0'), 'UTF-8', 20, 'historyDetailEdit0_handler'));
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new historyDetailEdit0Page($this, array('pid'), array('pid'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForhistoryDetailEdit0Grid(), $this->dataset, GetCurrentUserGrantForDataSource('historyDetailEdit0'), 'UTF-8');
            $pageEdit->SetShortCaption($pageEdit->GetLocalizerCaptions()->GetMessageString('History'));
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption($pageEdit->GetLocalizerCaptions()->GetMessageString('History'));
            $pageEdit->SetHttpHandlerName('historyDetailEdit0_handler');
            $handler = new PageHTTPHandler('historyDetailEdit0_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        protected function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }
    }

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new crewPage("crew.php", "crew", GetCurrentUserGrantForDataSource("crew"), 'UTF-8');
        $Page->SetShortCaption($Page->GetLocalizerCaptions()->GetMessageString('Crew'));
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption($Page->GetLocalizerCaptions()->GetMessageString('Crew'));
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("crew"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
