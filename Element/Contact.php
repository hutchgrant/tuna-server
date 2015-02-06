<?php


class Contact{

	var $ID;
	var $GroupID;
	var $GoogleID;
	var $Name;
	var $Email;
	var $Phone;

	function _construct(){
		$ID = "";
		$GroupID = "";
		$GoogleID = "";		
		$Name = "";
		$Email = "";
		$Phone = "";
	}

	function addPerson($groupID, $id, $googleID, $name, $email, $phone){
		$this->ID = $id;
		$this->GroupID = $groupID;
		$this->GoogleID = $googleID;
		$this->Name = $name;
		$this->Email = $email;
		$this->Phone = $phone;
	}

	function send(){
		$contactDisplay = array ('GroupID' => $this->GroupID,
					'ID' => $this->ID,
					'GoogleID' => $this->GoogleID,
					'Name' => $this->Name,
					'Email' => $this->Email,
					'Phone' => $this->Phone);
		echo json_encode($contactDisplay);
	}

	function display(){
		echo $this->Name;
	}

	function __destruct(){
	
	}
}



?>
