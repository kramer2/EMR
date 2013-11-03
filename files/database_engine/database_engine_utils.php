<?php

/* Exception utils */
function RaiseNotSupportedException()
{
    echo "Not supported";
}

function CreateConnectionOptionsArray($host, $database, $login, $password, $port = null)
{
    $result = array();
    if (isset($host))
        $result['server'] = $host;
    if (isset($database))
        $result['database'] = $database;
    if (isset($login))
        $result['username'] = $login;
    if (isset($password))
        $result['password'] = $password;
    if (isset($port))
        $result['port'] = $port;
    return $result;
}

?>
