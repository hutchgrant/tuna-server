<?php
include '../Element/Album.php';

class LifeAlbum{
	
	var $albums;
	var $count;

	function _construct(){
		$albums = array();
		$count = 0;
	}

	function addAlbum($alb){
		$this->albums[$this->count] = $alb;
		$this->count = $this->count +1;
	}

	function displayLife(){
			$ct = 1;
			echo "{ \"life\" : ";
			echo "{ \"albums\" : [ ";
		foreach($this->albums as $album){
			if($ct != 1){
				echo ",\n";			
			}
			$album->displayAlbum("na");

			//$group->dispContacts2();			
			$ct++;
		}
			echo " \n] \n } \n }";
	} 

	function display(){
		echo json_encode($albums);
	}
}
?>
	
