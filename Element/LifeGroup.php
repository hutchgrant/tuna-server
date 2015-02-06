<?php
include_once '../Element/Group.php';

class LifeGroup{
	
	var $groups;
	var $count;

	function _construct(){
		$groups = array();
		$count = 0;
	}

	function addGroup($grp){
		$this->groups[$this->count] = $grp;
		$this->count = $this->count +1;
	}

	function displayLife(){
			$ct = 1;
			echo "{ \"life\" : ";
			echo "{ \"groups\" : [ ";
		foreach($this->groups as $group){
			if($ct != 1){
				echo ",\n";			
			}
			$group->send();

			//$group->dispContacts2();			
			$ct++;
		}
			echo " \n] \n } \n }";
	}

	function display(){
		echo json_encode($groups);
	}
}
?>
	
