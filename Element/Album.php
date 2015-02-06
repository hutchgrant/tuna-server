<?php
include '../Element/Photo.php';

class Album{
	var $id;
	var $user;	
	var $title;
	var $photos;
	var $size;
	var $syncDate;
	var $syncTime;
	var $count;

	function _construct(){
		$photos = array();
		$count = 0;
	}

	function fill($ID, $AUTHORID, $NAME, $SIZE, $SYNCDATE, $SYNCTIME){
		$this->id = $ID;
		$this->user = $AUTHORID;
		$this->title = $NAME;
		$this->size = $SIZE;
		$this->syncDate = $SYNCDATE;
		$this->syncTime = $SYNCTIME;
	}

	function addImage($id, $type, $name, $username, $userid, $albid, $title, $description, $update, $uptime, $uptoken){
		
		$phto = new Photo();
		$phto->fill($id, $type, $name, $username, $userid, $albid, $title, $description, $uptime, $update, $uptoken);
		$this->photos[$this->count] = $phto;
		$this->count = $this->count +1;
	}

	function addPhoto($photo){
		$this->photos[$this->size] = $photo;
		$this->size = $this->size +1;
	}

	function displayAlbum(){

		$totalArr = array();
		$ImgFinalArr = array();
		$ct = 0;
		
		// echo "{ \"album\" : ";

		foreach($this->photos as $phto){
			$ImgFinalArr['ID'] = $phto->ID;
			$ImgFinalArr['Type'] = $phto->Type;
			$ImgFinalArr['Name'] = $phto->Name;
			$ImgFinalArr['username'] = $phto->username;
			$ImgFinalArr['userID'] = $phto->userID;
			$ImgFinalArr['AlbumID'] = $phto->albumID;
			$ImgFinalArr['Title'] = $phto->Title;
			$ImgFinalArr['Description'] = $phto->Description;
			$ImgFinalArr['UploadTime'] = $phto->UploadTime;
			$ImgFinalArr['UploadDate'] = $phto->UploadDate;
			$ImgFinalArr['UploadToken'] = $phto->UploadToken;
			$totalArr[$ct] = $ImgFinalArr;	 
			$ct++;
		}
		$albumDisplay = array('ID' => $this->id,
				'UserName' => $this->user,
				'Title' => $this->title,
				'Size' => $this->size,
				'SyncDate' => $this->syncDate,
				'SyncTime' => $this->syncTime,
				'images' => $totalArr);
		
			echo json_encode($albumDisplay);
		//	echo " \n }";
	}
}

?>
