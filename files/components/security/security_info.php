<?php

require_once 'components/page.php'; // TODO : remove
require_once 'base_user_auth.php';
require_once 'record_level_permissions.php';

#region Auth utils functions
// TODO : move to utils class

function GetCurrentUser()
{
    // TODO : use SuperGlobals
    if (isset($_COOKIE['scplu'])) {
        $uar= json_decode($_COOKIE['scplu']);
        return decryptIt($uar->u);
        //return $_COOKIE['username'];
    }
    else
        return 'guest';
}


function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

// TODO : remove this function
function GetUserGrantInfo($username, $tableName)
{
    global $userGrants;
    if (isset($userGrants[$username]))
        if (isset($userGrants[$username][$tableName]))
            return $userGrants[$username][$tableName];
}

function GetCurrentUserGrantForDataSource($dataSourceName)
{
    return GetApplication()->GetCurrentUserGrants($dataSourceName);
}

function GetCurrentUserRecordPermissionsForDataSource($dataSourceName)
{
    return GetApplication()->GetCurrentUserRecordPermissionsForDataSource($dataSourceName);
}

#endregion

?>
