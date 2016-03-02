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
    
    class stock_refreshPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`stock_refresh`');
            $field = new IntegerField('sid');
            $this->dataset->AddField($field, true);
            $field = new StringField('page');
            $this->dataset->AddField($field, false);
            $field = new StringField('category');
            $this->dataset->AddField($field, false);
            $field = new StringField('generic_name');
            $this->dataset->AddField($field, false);
            $field = new StringField('description');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('min_stock');
            $this->dataset->AddField($field, false);
            $field = new StringField('remarks');
            $this->dataset->AddField($field, false);
            $field = new StringField('packing');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock1');
            $this->dataset->AddField($field, false);
            $field = new DateField('expiry1');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock2');
            $this->dataset->AddField($field, false);
            $field = new DateField('expiry2');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock3');
            $this->dataset->AddField($field, false);
            $field = new DateField('expiry3');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock4');
            $this->dataset->AddField($field, false);
            $field = new DateField('expiry4');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock5');
            $this->dataset->AddField($field, false);
            $field = new DateField('expiry5');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('stock');
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
            $grid->SearchControl = new SimpleSearch('stock_refreshssearch', $this->dataset,
                array('sid', 'page', 'category', 'generic_name', 'description', 'min_stock', 'remarks', 'packing', 'stock1', 'expiry1', 'stock2', 'expiry2', 'stock3', 'expiry3', 'stock4', 'expiry4', 'stock5', 'expiry5', 'stock'),
                array($this->RenderText('Sid'), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Page')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Category')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Generic_Name')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Description')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Min_Stock')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Remarks')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Packing')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock1')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry1')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock2')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry2')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock3')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry3')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock4')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry4')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock5')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry5')), $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock'))),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('stock_refreshasearch', $this->dataset, $this->GetLocalizerCaptions());
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('sid', $this->RenderText('Sid')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('page', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Page'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('category', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Category'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('generic_name', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Generic_Name'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('description', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Description'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('min_stock', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Min_Stock'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('remarks', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Remarks'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('packing', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Packing'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock1', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock1'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('expiry1', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry1'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock2', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock2'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('expiry2', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry2'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock3', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock3'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('expiry3', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry3'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock4', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock4'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('expiry4', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry4'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock5', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock5'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('expiry5', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Expiry5'))));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('stock', $this->GetLocalizerCaptions()->GetMessageString($this->RenderText('Stock'))));
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
            // View column for sid field
            //
            $column = new TextViewColumn('sid', 'Sid', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for sid field
            //
            $editor = new TextEdit('sid_edit');
            $editColumn = new CustomEditColumn('Sid', 'sid', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sid'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for sid field
            //
            $editor = new TextEdit('sid_edit');
            $editColumn = new CustomEditColumn('Sid', 'sid', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sid'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for page field
            //
            $column = new TextViewColumn('page', $this->GetLocalizerCaptions()->GetMessageString('Page'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for page field
            //
            $editor = new TextEdit('page_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Page', 'page', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Page'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for page field
            //
            $editor = new TextEdit('page_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Page', 'page', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Page'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for category field
            //
            $column = new TextViewColumn('category', $this->GetLocalizerCaptions()->GetMessageString('Category'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for category field
            //
            $editor = new TextEdit('category_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Category', 'category', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Category'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for category field
            //
            $editor = new TextEdit('category_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Category', 'category', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Category'));
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
            $column = new TextViewColumn('generic_name', $this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for generic_name field
            //
            $editor = new TextEdit('generic_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Generic Name', 'generic_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Generic Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for generic_name field
            //
            $editor = new TextEdit('generic_name_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Generic Name', 'generic_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Generic Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', $this->GetLocalizerCaptions()->GetMessageString('Description'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for description field
            //
            $editor = new TextEdit('description_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Description', 'description', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Description'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for description field
            //
            $editor = new TextEdit('description_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Description', 'description', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Description'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for min_stock field
            //
            $column = new TextViewColumn('min_stock', $this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for min_stock field
            //
            $editor = new TextEdit('min_stock_edit');
            $editColumn = new CustomEditColumn('Min Stock', 'min_stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Min Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for min_stock field
            //
            $editor = new TextEdit('min_stock_edit');
            $editColumn = new CustomEditColumn('Min Stock', 'min_stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Min Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for remarks field
            //
            $column = new TextViewColumn('remarks', $this->GetLocalizerCaptions()->GetMessageString('Remarks'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for remarks field
            //
            $editor = new TextEdit('remarks_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Remarks', 'remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for remarks field
            //
            $editor = new TextEdit('remarks_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Remarks', 'remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for packing field
            //
            $column = new TextViewColumn('packing', $this->GetLocalizerCaptions()->GetMessageString('Packing'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for packing field
            //
            $editor = new TextEdit('packing_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Packing', 'packing', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for packing field
            //
            $editor = new TextEdit('packing_edit');
            $editor->SetSize(45);
            $editColumn = new CustomEditColumn('Packing', 'packing', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock1 field
            //
            $column = new TextViewColumn('stock1', $this->GetLocalizerCaptions()->GetMessageString('Stock1'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock1 field
            //
            $editor = new TextEdit('stock1_edit');
            $editColumn = new CustomEditColumn('Stock1', 'stock1', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock1'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock1 field
            //
            $editor = new TextEdit('stock1_edit');
            $editColumn = new CustomEditColumn('Stock1', 'stock1', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock1'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for expiry1 field
            //
            $column = new DateTimeViewColumn('expiry1', $this->GetLocalizerCaptions()->GetMessageString('Expiry1'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for expiry1 field
            //
            $editor = new DateTimeEdit('expiry1_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry1', 'expiry1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for expiry1 field
            //
            $editor = new DateTimeEdit('expiry1_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry1', 'expiry1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock2 field
            //
            $column = new TextViewColumn('stock2', $this->GetLocalizerCaptions()->GetMessageString('Stock2'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock2 field
            //
            $editor = new TextEdit('stock2_edit');
            $editColumn = new CustomEditColumn('Stock2', 'stock2', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock2'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock2 field
            //
            $editor = new TextEdit('stock2_edit');
            $editColumn = new CustomEditColumn('Stock2', 'stock2', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock2'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for expiry2 field
            //
            $column = new DateTimeViewColumn('expiry2', $this->GetLocalizerCaptions()->GetMessageString('Expiry2'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for expiry2 field
            //
            $editor = new DateTimeEdit('expiry2_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry2', 'expiry2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for expiry2 field
            //
            $editor = new DateTimeEdit('expiry2_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry2', 'expiry2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock3 field
            //
            $column = new TextViewColumn('stock3', $this->GetLocalizerCaptions()->GetMessageString('Stock3'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock3 field
            //
            $editor = new TextEdit('stock3_edit');
            $editColumn = new CustomEditColumn('Stock3', 'stock3', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock3'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock3 field
            //
            $editor = new TextEdit('stock3_edit');
            $editColumn = new CustomEditColumn('Stock3', 'stock3', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock3'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for expiry3 field
            //
            $column = new DateTimeViewColumn('expiry3', $this->GetLocalizerCaptions()->GetMessageString('Expiry3'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for expiry3 field
            //
            $editor = new DateTimeEdit('expiry3_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry3', 'expiry3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for expiry3 field
            //
            $editor = new DateTimeEdit('expiry3_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry3', 'expiry3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock4 field
            //
            $column = new TextViewColumn('stock4', $this->GetLocalizerCaptions()->GetMessageString('Stock4'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock4 field
            //
            $editor = new TextEdit('stock4_edit');
            $editColumn = new CustomEditColumn('Stock4', 'stock4', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock4'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock4 field
            //
            $editor = new TextEdit('stock4_edit');
            $editColumn = new CustomEditColumn('Stock4', 'stock4', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock4'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for expiry4 field
            //
            $column = new DateTimeViewColumn('expiry4', $this->GetLocalizerCaptions()->GetMessageString('Expiry4'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for expiry4 field
            //
            $editor = new DateTimeEdit('expiry4_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry4', 'expiry4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for expiry4 field
            //
            $editor = new DateTimeEdit('expiry4_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry4', 'expiry4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock5 field
            //
            $column = new TextViewColumn('stock5', $this->GetLocalizerCaptions()->GetMessageString('Stock5'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock5 field
            //
            $editor = new TextEdit('stock5_edit');
            $editColumn = new CustomEditColumn('Stock5', 'stock5', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock5'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock5 field
            //
            $editor = new TextEdit('stock5_edit');
            $editColumn = new CustomEditColumn('Stock5', 'stock5', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock5'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for expiry5 field
            //
            $column = new DateTimeViewColumn('expiry5', $this->GetLocalizerCaptions()->GetMessageString('Expiry5'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for expiry5 field
            //
            $editor = new DateTimeEdit('expiry5_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry5', 'expiry5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for expiry5 field
            //
            $editor = new DateTimeEdit('expiry5_edit', true, 'Y-m-d H:i:s', 0);
            $editColumn = new CustomEditColumn('Expiry5', 'expiry5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for stock field
            //
            $column = new TextViewColumn('stock', $this->GetLocalizerCaptions()->GetMessageString('Stock'), $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for stock field
            //
            $editor = new TextEdit('stock_edit');
            $editColumn = new CustomEditColumn('Stock', 'stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for stock field
            //
            $editor = new TextEdit('stock_edit');
            $editColumn = new CustomEditColumn('Stock', 'stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock'));
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
            // View column for sid field
            //
            $column = new TextViewColumn('sid', 'Sid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for page field
            //
            $column = new TextViewColumn('page', $this->GetLocalizerCaptions()->GetMessageString('Page'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for category field
            //
            $column = new TextViewColumn('category', $this->GetLocalizerCaptions()->GetMessageString('Category'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('generic_name', $this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', $this->GetLocalizerCaptions()->GetMessageString('Description'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for min_stock field
            //
            $column = new TextViewColumn('min_stock', $this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for remarks field
            //
            $column = new TextViewColumn('remarks', $this->GetLocalizerCaptions()->GetMessageString('Remarks'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for packing field
            //
            $column = new TextViewColumn('packing', $this->GetLocalizerCaptions()->GetMessageString('Packing'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock1 field
            //
            $column = new TextViewColumn('stock1', $this->GetLocalizerCaptions()->GetMessageString('Stock1'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expiry1 field
            //
            $column = new DateTimeViewColumn('expiry1', $this->GetLocalizerCaptions()->GetMessageString('Expiry1'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock2 field
            //
            $column = new TextViewColumn('stock2', $this->GetLocalizerCaptions()->GetMessageString('Stock2'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expiry2 field
            //
            $column = new DateTimeViewColumn('expiry2', $this->GetLocalizerCaptions()->GetMessageString('Expiry2'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock3 field
            //
            $column = new TextViewColumn('stock3', $this->GetLocalizerCaptions()->GetMessageString('Stock3'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expiry3 field
            //
            $column = new DateTimeViewColumn('expiry3', $this->GetLocalizerCaptions()->GetMessageString('Expiry3'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock4 field
            //
            $column = new TextViewColumn('stock4', $this->GetLocalizerCaptions()->GetMessageString('Stock4'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expiry4 field
            //
            $column = new DateTimeViewColumn('expiry4', $this->GetLocalizerCaptions()->GetMessageString('Expiry4'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock5 field
            //
            $column = new TextViewColumn('stock5', $this->GetLocalizerCaptions()->GetMessageString('Stock5'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for expiry5 field
            //
            $column = new DateTimeViewColumn('expiry5', $this->GetLocalizerCaptions()->GetMessageString('Expiry5'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for stock field
            //
            $column = new TextViewColumn('stock', $this->GetLocalizerCaptions()->GetMessageString('Stock'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns($grid)
        {
            //
            // Edit column for sid field
            //
            $editor = new TextEdit('sid_edit');
            $editColumn = new CustomEditColumn('Sid', 'sid', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sid'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for page field
            //
            $editor = new TextEdit('page_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Page'), 'page', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Page'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for category field
            //
            $editor = new TextEdit('category_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Category'), 'category', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Category'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for generic_name field
            //
            $editor = new TextEdit('generic_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), 'generic_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Generic Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for description field
            //
            $editor = new TextEdit('description_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Description'), 'description', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Description'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for min_stock field
            //
            $editor = new TextEdit('min_stock_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), 'min_stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Min Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for remarks field
            //
            $editor = new TextEdit('remarks_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Remarks'), 'remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for packing field
            //
            $editor = new TextEdit('packing_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Packing'), 'packing', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock1 field
            //
            $editor = new TextEdit('stock1_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock1'), 'stock1', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock1'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expiry1 field
            //
            $editor = new DateTimeEdit('expiry1_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry1'), 'expiry1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock2 field
            //
            $editor = new TextEdit('stock2_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock2'), 'stock2', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock2'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expiry2 field
            //
            $editor = new DateTimeEdit('expiry2_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry2'), 'expiry2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock3 field
            //
            $editor = new TextEdit('stock3_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock3'), 'stock3', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock3'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expiry3 field
            //
            $editor = new DateTimeEdit('expiry3_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry3'), 'expiry3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock4 field
            //
            $editor = new TextEdit('stock4_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock4'), 'stock4', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock4'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expiry4 field
            //
            $editor = new DateTimeEdit('expiry4_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry4'), 'expiry4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock5 field
            //
            $editor = new TextEdit('stock5_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock5'), 'stock5', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock5'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for expiry5 field
            //
            $editor = new DateTimeEdit('expiry5_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry5'), 'expiry5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for stock field
            //
            $editor = new TextEdit('stock_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock'), 'stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns($grid)
        {
            //
            // Edit column for sid field
            //
            $editor = new TextEdit('sid_edit');
            $editColumn = new CustomEditColumn('Sid', 'sid', $editor, $this->dataset);
            $editColumn->SetAllowSetToDefault(true);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Sid'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for page field
            //
            $editor = new TextEdit('page_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Page'), 'page', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Page'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for category field
            //
            $editor = new TextEdit('category_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Category'), 'category', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Category'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for generic_name field
            //
            $editor = new TextEdit('generic_name_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), 'generic_name', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Generic Name'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for description field
            //
            $editor = new TextEdit('description_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Description'), 'description', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Description'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for min_stock field
            //
            $editor = new TextEdit('min_stock_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), 'min_stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Min Stock'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for remarks field
            //
            $editor = new TextEdit('remarks_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Remarks'), 'remarks', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for packing field
            //
            $editor = new TextEdit('packing_edit');
            //$editor->SetSize(45);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Packing'), 'packing', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock1 field
            //
            $editor = new TextEdit('stock1_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock1'), 'stock1', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock1'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expiry1 field
            //
            $editor = new DateTimeEdit('expiry1_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry1'), 'expiry1', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock2 field
            //
            $editor = new TextEdit('stock2_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock2'), 'stock2', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock2'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expiry2 field
            //
            $editor = new DateTimeEdit('expiry2_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry2'), 'expiry2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock3 field
            //
            $editor = new TextEdit('stock3_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock3'), 'stock3', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock3'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expiry3 field
            //
            $editor = new DateTimeEdit('expiry3_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry3'), 'expiry3', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock4 field
            //
            $editor = new TextEdit('stock4_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock4'), 'stock4', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock4'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expiry4 field
            //
            $editor = new DateTimeEdit('expiry4_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry4'), 'expiry4', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock5 field
            //
            $editor = new TextEdit('stock5_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock5'), 'stock5', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock5'));
            $editColumn->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for expiry5 field
            //
            $editor = new DateTimeEdit('expiry5_edit', true, 'Y-m-d', 0);
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Expiry5'), 'expiry5', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for stock field
            //
            $editor = new TextEdit('stock_edit');
            $editColumn = new CustomEditColumn($this->GetLocalizerCaptions()->GetMessageString('Stock'), 'stock', $editor, $this->dataset);
            $validator = new NotEmptyValidator(sprintf($this->GetLocalizerCaptions()->GetMessageString('FieldValueRequiredErrorMsg'), 'Stock'));
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
            // View column for sid field
            //
            $column = new TextViewColumn('sid', 'Sid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for page field
            //
            $column = new TextViewColumn('page', $this->GetLocalizerCaptions()->GetMessageString('Page'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for category field
            //
            $column = new TextViewColumn('category', $this->GetLocalizerCaptions()->GetMessageString('Category'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('generic_name', $this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', $this->GetLocalizerCaptions()->GetMessageString('Description'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for min_stock field
            //
            $column = new TextViewColumn('min_stock', $this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for remarks field
            //
            $column = new TextViewColumn('remarks', $this->GetLocalizerCaptions()->GetMessageString('Remarks'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for packing field
            //
            $column = new TextViewColumn('packing', $this->GetLocalizerCaptions()->GetMessageString('Packing'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock1 field
            //
            $column = new TextViewColumn('stock1', $this->GetLocalizerCaptions()->GetMessageString('Stock1'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for expiry1 field
            //
            $column = new DateTimeViewColumn('expiry1', $this->GetLocalizerCaptions()->GetMessageString('Expiry1'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock2 field
            //
            $column = new TextViewColumn('stock2', $this->GetLocalizerCaptions()->GetMessageString('Stock2'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for expiry2 field
            //
            $column = new DateTimeViewColumn('expiry2', $this->GetLocalizerCaptions()->GetMessageString('Expiry2'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock3 field
            //
            $column = new TextViewColumn('stock3', $this->GetLocalizerCaptions()->GetMessageString('Stock3'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for expiry3 field
            //
            $column = new DateTimeViewColumn('expiry3', $this->GetLocalizerCaptions()->GetMessageString('Expiry3'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock4 field
            //
            $column = new TextViewColumn('stock4', $this->GetLocalizerCaptions()->GetMessageString('Stock4'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for expiry4 field
            //
            $column = new DateTimeViewColumn('expiry4', $this->GetLocalizerCaptions()->GetMessageString('Expiry4'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock5 field
            //
            $column = new TextViewColumn('stock5', $this->GetLocalizerCaptions()->GetMessageString('Stock5'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for expiry5 field
            //
            $column = new DateTimeViewColumn('expiry5', $this->GetLocalizerCaptions()->GetMessageString('Expiry5'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for stock field
            //
            $column = new TextViewColumn('stock', $this->GetLocalizerCaptions()->GetMessageString('Stock'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns($grid)
        {
            //
            // View column for sid field
            //
            $column = new TextViewColumn('sid', 'Sid', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for page field
            //
            $column = new TextViewColumn('page', $this->GetLocalizerCaptions()->GetMessageString('Page'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for category field
            //
            $column = new TextViewColumn('category', $this->GetLocalizerCaptions()->GetMessageString('Category'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for generic_name field
            //
            $column = new TextViewColumn('generic_name', $this->GetLocalizerCaptions()->GetMessageString('Generic_Name'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for description field
            //
            $column = new TextViewColumn('description', $this->GetLocalizerCaptions()->GetMessageString('Description'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for min_stock field
            //
            $column = new TextViewColumn('min_stock', $this->GetLocalizerCaptions()->GetMessageString('Min_Stock'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for remarks field
            //
            $column = new TextViewColumn('remarks', $this->GetLocalizerCaptions()->GetMessageString('Remarks'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for packing field
            //
            $column = new TextViewColumn('packing', $this->GetLocalizerCaptions()->GetMessageString('Packing'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock1 field
            //
            $column = new TextViewColumn('stock1', $this->GetLocalizerCaptions()->GetMessageString('Stock1'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for expiry1 field
            //
            $column = new DateTimeViewColumn('expiry1', $this->GetLocalizerCaptions()->GetMessageString('Expiry1'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock2 field
            //
            $column = new TextViewColumn('stock2', $this->GetLocalizerCaptions()->GetMessageString('Stock2'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for expiry2 field
            //
            $column = new DateTimeViewColumn('expiry2', $this->GetLocalizerCaptions()->GetMessageString('Expiry2'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock3 field
            //
            $column = new TextViewColumn('stock3', $this->GetLocalizerCaptions()->GetMessageString('Stock3'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for expiry3 field
            //
            $column = new DateTimeViewColumn('expiry3', $this->GetLocalizerCaptions()->GetMessageString('Expiry3'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock4 field
            //
            $column = new TextViewColumn('stock4', $this->GetLocalizerCaptions()->GetMessageString('Stock4'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for expiry4 field
            //
            $column = new DateTimeViewColumn('expiry4', $this->GetLocalizerCaptions()->GetMessageString('Expiry4'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock5 field
            //
            $column = new TextViewColumn('stock5', $this->GetLocalizerCaptions()->GetMessageString('Stock5'), $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for expiry5 field
            //
            $column = new DateTimeViewColumn('expiry5', $this->GetLocalizerCaptions()->GetMessageString('Expiry5'), $this->dataset);
            $column->SetDateTimeFormat('Y-m-d');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for stock field
            //
            $column = new TextViewColumn('stock', $this->GetLocalizerCaptions()->GetMessageString('Stock'), $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'stock_refreshGrid');
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
        $Page = new stock_refreshPage("stock_refresh.php", "stock_refresh", GetCurrentUserGrantForDataSource("stock_refresh"), 'UTF-8');
        $Page->SetShortCaption($Page->GetLocalizerCaptions()->GetMessageString('Stock_Refresh'));
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption($Page->GetLocalizerCaptions()->GetMessageString('Stock_Refresh'));
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("stock_refresh"));

        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }

?>
