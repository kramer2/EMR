<?php

require_once 'settings.php';
require_once 'components/page.php';
require_once 'components/security/security_info.php';
require_once 'components/security/datasource_security_info.php';
require_once 'components/security/tablebased_auth.php';
require_once 'components/security/user_grants_manager.php';

require_once 'database_engine/mysql_engine.php';

$grants = array('guest' => array(
        'crew' => new DataSourceSecurityInfo(true, false, false,false),
        'history' => new DataSourceSecurityInfo(true, false, false, false),
    )
    ,
    'defaultUser' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'admin' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'medic' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item01' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item02' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item03' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item04' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item05' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'Item06' => 
        array('crew' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'history' => new DataSourceSecurityInfo(false, false, false, false),
        'stock' => new DataSourceSecurityInfo(false, false, false, false),
        'historyDetailEdit0' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_expiry' => new DataSourceSecurityInfo(false, false, false, false),
        'stock_refresh' => new DataSourceSecurityInfo(false, false, false, false))
    );

$appGrants = array('guest' => new DataSourceSecurityInfo(false, false,false,false),
    'defaultUser' => new DataSourceSecurityInfo(false, false, false, false),
    'admin' => new AdminDataSourceSecurityInfo(),
    'medic' => new DataSourceSecurityInfo(true, true, true, true),
    'Item01' => new DataSourceSecurityInfo(false, false, false, false),
    'Item02' => new DataSourceSecurityInfo(false, false, false, false),
    'Item03' => new DataSourceSecurityInfo(false, false, false, false),
    'Item04' => new DataSourceSecurityInfo(false, false, false, false),
    'Item05' => new DataSourceSecurityInfo(false, false, false, false),
    'Item06' => new DataSourceSecurityInfo(false, false, false, false));

$dataSourceRecordPermissions = array();

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;
    $userAuthorizationStrategy = new TableBasedUserAuthorization(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'auth', 'login', 'user_id', new HardCodedUserGrantsManager($grants, $appGrants));
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
    new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}

function GetIdentityCheckStrategy()
{
    return new TableBasedIdentityCheckStrategy(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'auth', 'login', 'password', ENCRYPTION_MD5);
}

?>