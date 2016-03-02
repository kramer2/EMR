<?php

// define('SHOW_VARIABLES', 1);
// define('DEBUG_LEVEL', 1);

// error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors', 'On');
if ( ! defined('ACCESS_ACEPTED')) exit('No direct script access allowed');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


require_once 'components/utils/system_utils.php';

SystemUtils::DisableMagicQuotesRuntime();


function GetGlobalConnectionOptions()
{
    return array(
  'server' => 'localhost',
  'port' => '3306',
  'username' => 'local',
  'password' => '00',
  'database' => 'emr'
);
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Crew', 'short_caption' => 'Crew', 'filename' => 'crew.php', 'name' => 'crew');
    $result[] = array('caption' => 'History', 'short_caption' => 'History', 'filename' => 'history.php', 'name' => 'history');
    $result[] = array('caption' => 'Stock', 'short_caption' => 'Stock', 'filename' => 'stock.php', 'name' => 'stock');
    $result[] = array('caption' => 'Stock Expiry', 'short_caption' => 'Stock Expiry', 'filename' => 'stock_expiry.php', 'name' => 'stock_expiry');
    $result[] = array('caption' => 'Stock Refresh', 'short_caption' => 'Stock Refresh', 'filename' => 'stock_refresh.php', 'name' => 'stock_refresh');
    return $result;
}

function GetPagesHeader()
{
    return
    '<p>OnixSoftware EMR</p>';
}

function GetPagesFooter()
{
    return
        '<p align="right"><a href="http://www.onix-software.com/" target="_blank">Onix Software</a></p>'; 
    }

function ApplyCommonPageSettings($page, $grid)
{
    $page->SetShowUserAuthBar(true);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_BeforeUpdateHandler($rowData, &$cancel, &$message)
{

}

function Global_BeforeDeleteHandler($rowData, &$cancel, &$message)
{

}

function Global_BeforeInsertHandler($rowData, &$cancel, &$message)
{

}

?>
