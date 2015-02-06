<?php
include './main_social.php';
include '../Element/SyncObj.php';
include '../Database/validate.php';
include '../Sync/sync_interface.php';

/// check token
$userToken = getTokenHeader();
$userID = getUserID($userToken);

/// get the sync obj for that user and compare
///-----------------------------------------------
$sync = new SyncObj();
$sync = getSyncObj($userID);

$sync->display(); 
?>
