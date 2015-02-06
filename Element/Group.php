<?php
include '../Element/Contact.php';

class Group{
	
	var $groupAuthor;
	var $groupID;
	var $groupName;
	var $groupSize;
	var $groupSyncDate;
	var $groupSyncTime;
	var $people;
	var $count;

	function _construct(){
		$groupID = "";
		$groupName = "";
		$groupSize = "";
		$groupSyncDate = "";
		$groupSyncTime = "";
		$people = array();
		$count = 0;
		$groupAuthor = "";
	}

	function fill($grpID, $grpName, $grpSize, $grpSyncD, $grpSyncT, $grpAuth){
		$this->groupID =$grpID;
		$this->groupName = $grpName;
		$this->groupSize = $grpSize;
		$this->groupSyncDate = $grpSyncD;
		$this->groupSyncTime = $grpSyncT;
		$this->groupAuthor = $grpAuth;
	}

	function addContact($grpID, $id, $googleid, $name, $email, $phone){
		
		$person = new Contact();
		$person->addPerson($grpID,$id,$googleid, $name,$email,$phone);
		$this->people[$this->count] = $person;
		$this->count = $this->count +1;
	}

	function getContact($pos){
		$person = new Contact();
		$person = $this->people[$pos];
		return $person;
	}

	function dispContacts(){
	/*	$contactArray = array();
		$counter = 0;
		foreach($this->people as $person){
			$contactArray[0] = $person->ID;
			$contactArray[1] = $person->Name;
			$contactArray[2] = $person->Email;
			$contactArray[3] = $person->Phone;
			$totalArr[$counter] = $contactArray;
			$ct++; 			 
		}  */
		//return $totalArr; 
	}	

	function dispContacts2(){
		$ct = 1;
		echo ", \n\"people\" : [ ";
		foreach($this->people as $person){
			if($ct != 1){
				echo ", \n";			
			}
			$person->send();
			$ct++;
		}
			echo " \n] } \n";
	}

	function send(){
		$totalArr = array();
		$contactArray = array();
		$ct = 0;
		foreach($this->people as $person){
			$contactArray['GroupID'] = $person->GroupID;
			$contactArray['GoogleID'] = $person->GoogleID;
			$contactArray['ID'] = $person->ID;
			$contactArray['Name'] = $person->Name;
			$contactArray['Email'] = $person->Email;
			$contactArray['Phone'] = $person->Phone;
			$totalArr[$ct] = $contactArray;	 
			$ct++;
		}  

		$groupDisplay = array ('groupID' => $this->groupID,
					'groupName' => $this->groupName,
					'groupSize' => $this->groupSize,
					'groupSyncDate' => $this->groupSyncDate,
					'groupSyncTime' => $this->groupSyncTime,
					'groupAuthor' => $this->groupAuthor,
					'people' => $totalArr);
		 echo json_encode($groupDisplay); 
	}

	function __destruct(){
	
	}
}



?>
