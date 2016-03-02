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
    
    class historyPage extends Page
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
            $grid->SearchControl = new SimpleSearch('historyssearch', $this->dataset,
                array('date', 'complaint', 'examination'),
                array($this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Date')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Complaint')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Examination'))),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('historyasearch', $this->dataset, $this->GetLocalizerCaptions());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('date', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Date'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('pid_last_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('patient'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('complaint', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Complaint'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('examination', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Examination'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('diagnose', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Diagnose'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('sid_generic_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('medicine'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('qty', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Qty'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('hid', $this->RenderText('Hid')));
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
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d', 0);
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
            $editor = new DateTimeEdit('date_edit', true, 'Y-m-d', 0);
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
    
        public function GetPageDirection()
        {
            return null;
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
            $result = new Grid($this, $this->dataset, 'historyGrid');
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

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new historyPage("history.php", "history", GetCurrentUserGrantForDataSource("history"), 'UTF-8');
        $Page->SetShortCaption($Page->GetLocalizerCaptions()->GetMessageString('History'));
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption($Page->GetLocalizerCaptions()->GetMessageString('History'));
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("history"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
