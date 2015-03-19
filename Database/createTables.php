<?php
/*
 * Copyright 2013 Grant Hutchinson
 */
include 'main_interface.php';

setupTables();

function setupTables(){
	
	$q = array();
	
    $q[1] = "create table Users (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), userToken varchar(100), ourToken varchar(50), userID varchar(50), username varchar(60), userEmail varchar(100), userPhone varchar(20), userProfile varchar(100), userProfileImg varchar(150), location varchar(50), appinstalled varchar(10), regdate DATE, regtime TIME, regIP varchar(20), logintime TIME, logindate DATE, loginIP varchar(20), MaxAlbums int, MaxImages int, MaxGroups int, MaxContacts int)";
    
    $q[2] = "create table Logs (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), Activity varchar(150), url varchar(250), userID varchar(50), time TIME, date DATE, IP varchar(20))";

    $q[3] = "create table Albums (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), AlbumID varchar(50), AuthorID varchar(50), AlbumName varchar(120), AlbumSize int, SyncDate DATE, SyncTime TIME)"; 

    $q[4] = "create table Images (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), imgID varchar(50), imguploadID varchar(50), imgName VARCHAR(100), username varchar(30), userID varchar(50), albumID varchar(100), title varchar(50), description varchar(1000), uploadtime TIME, uploaddate DATE, uploadIP varchar(20))";

    $q[5] = "create table Groups (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), UserID varchar(50), UserGroupID varchar(50), groupName varchar(100), groupSize int, syncDate DATE, syncTime varchar(25))"; 

    $q[6] = "create table Contacts (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), UserID varchar(50), GroupID varchar(100), ContactID varchar(50), GoogleID varchar(100), ContactName varchar(100), ContactEmail varchar(100), ContactPhone varchar (20), ContactImg varchar(100) )";

    $q[7] = "create table Sync (id int NULL AUTO_INCREMENT, PRIMARY KEY(id), UserID varchar(50),  syncToken varchar(20), syncProfDate DATE, syncProfTime TIME, syncAlbDate DATE, syncAlbTime TIME, syncAlbAmount int, syncImgAmount int, syncGrpDate DATE, syncGrpTime TIME, syncGrpAmount int, syncConAmount int, inviteToken varchar(50), inviteDate DATE, inviteTime TIME, inviteRecAmount int, inviteSntAmount int,
msgToken varchar(50), msgDate DATE, msgTime TIME, msgRecAmount int, msgSntAmount int)";

    $q[8] = "create table Invites (id int NULL AUTO_INCREMENT, PRIMARY KEY(id), InviteID varchar(50), InviteStatus varchar(20), InviteUserGID varchar(50), InviteUserName varchar(100), RecipientName varchar(100), RecipientUserGID varchar(50), RecipientUserEmail varchar(100), RecipientUserPhone varchar(20), inviteDate DATE, inviteTime TIME )";

$q[9] = "create table Messages (id int NULL AUTO_INCREMENT, PRIMARY KEY(id), MessageID varchar(50), UserID varchar(50), UserName varchar(100), Type varchar(25), Content varchar(250), RecipientID varchar(100), RecipientGrpID varchar(50), mDate DATE, mTime TIME, ip_address varchar(20) )";

 /*   
    $q[3] = "create table Pages (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), username VARCHAR(30), imageID varchar(20), title varchar(30), description varchar(150), 
    		viewcount int, votecount int, date varchar(20), time TIME, genKey varchar(20))";
    
    $q[4] = "create table Comments (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), username varchar(30), comment varchar(150), replyto varchar(30), date varchar(20), 
    		time varchar(20))";
    

    
    $q[6] = "create table Tags (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), imageID varchar(20), tagName varchar(20), username varchar(30), date varchar(20), 
    		time varchar(20))";
    
    $q[7] = "create table Votes (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), imageID varchar(20), commentID varchar(20), username varchar(30), vote int, date varchar(20),
    		 time varchar(20))";

    $q[8] = "create table Permissions (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), creator varchar(30), permissName varchar(30), DelImage int, DelUser int, Delcomment int, DelPage int, 
    		Banuser int, view_log int)";
    
    $q[9] = "create table Actions (id INT NULL AUTO_INCREMENT, PRIMARY KEY(id), admin varchar(30), action varchar(250), userEffected varchar(30), time varchar(20),
    		 date varchar(20), IP varchar(20))";*/
   
    $sqlCon = new dbConnect();
    
    for($i = 1; $i <=9; $i++){
    	$sqlCon->finQry($q[$i]);
    }
    $sqlCon->sqlClose();
}
?>
