<?php
class Chat{
    
  
    private $host  = 'localhost';
    private $user  = 'admin';
    private $password   = '52a6d848b3a02dec4792ba937d3a98f810a5b446af4da5d1';
    private $database  = "xogos";      
    private $chatTable = 'chat';
	private $chatUsersTable = 'users';
	private $chatLoginDetailsTable = 'chat_login_details';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($username, $password){
		$sqlQuery = "
			SELECT user_id, username 
			FROM ".$this->chatUsersTable." 
			WHERE username='".$username."' AND password='".$password."'";		
        return  $this->getData($sqlQuery);
	}		
	public function chatUsers($userid){
		$sqlQuery = "
			SELECT * FROM ".$this->chatUsersTable." 
			WHERE user_id = '$userid'";
	//	return  $this->getData($sqlQuery);
		$results= $this->getData($sqlQuery);
		
			foreach($results as $result){
			    
		if ($result["user_role"]=="teacher"){
		   //	$sqlQuery = "SELECT * FROM ".$this->chatUsersTable."WHERE t_student_id =". $result["teacher_id"]; 
		
			
			$sqlQuery = "SELECT * FROM classes WHERE class_teacher_id =" . $result["teacher_id"]; 
$tech_results = $this->getData($sqlQuery);

$class_ids = array();
foreach ($tech_results as $tech_result) {
    $class_ids[] = $tech_result["class_id"];
}

if (!empty($class_ids)) {
    $sqlQuery = "SELECT * FROM " . $this->chatUsersTable . " WHERE class_id IN (" . implode(',', $class_ids) . ")";
   // $class_mem = $this->getData($sqlQuery);
} else {
    // Handle case where no classes were found for the teacher
   // $class_mem = array();
   $sqlQuery = "SELECT * FROM ".$this->chatUsersTable."WHERE t_student_id =". $result["teacher_id"]; 
}


		}
			if ($result["user_role"]=="parent"){
		   	$sqlQuery = "
			SELECT * FROM ".$this->chatUsersTable." 
			WHERE student_id =". $result["parent_id"]; 
		}
		
			if ($result["user_role"]=="student"){
		   //	$sqlQuery = "SELECT * FROM ".$this->chatUsersTable." WHERE parent_id =". $result["student_id"]; 
		  if(!empty($result["class_id"])){
		   	$sqlQuery = "SELECT * FROM classes WHERE class_id =" . $result["class_id"]; 
$tech_results = $this->getData($sqlQuery);
$class_ids = array();

foreach ($tech_results as $tech_result) {
    $class_ids[] = $tech_result["class_teacher_id"];
}


		   	 	$sqlQuery = "SELECT * FROM ".$this->chatUsersTable." WHERE user_id !=". $result["user_id"]." AND class_id =". $result["class_id"]." OR parent_id =". $result["student_id"] ." OR teacher_id IN (" . implode(',', $class_ids) . ") "; 
		   	 	//echo $sqlQuery;
		   	 //	die();
		   	 //	$tech_results = $this->getData($sqlQuery);

}
else{
    	$sqlQuery = "SELECT * FROM ".$this->chatUsersTable." WHERE user_id !=". $result["user_id"]." AND parent_id =". $result["student_id"] ." OR teacher_id ='". $result["t_student_id"]."'"; 
    }
//echo $sqlQuery;
//die();
		   	
		}
			}
				return  $this->getData($sqlQuery);
		
	}
	public function getUserDetails($userid){
		$sqlQuery = "
			SELECT * FROM ".$this->chatUsersTable." 
			WHERE user_id = '$userid'";
		return  $this->getData($sqlQuery);
	}
	public function getUserAvatar($userid){
		$sqlQuery = "
			SELECT img 
			FROM ".$this->chatUsersTable." 
			WHERE user_id = '$userid'";
			
		$userResult = $this->getData($sqlQuery);
		
		$userAvatar = '';
		foreach ($userResult as $user) {
		    if($user['img']==""){
		        	$userAvatar = "user6.jpg";
		    }
		    else{
			$userAvatar = $user['img'];
		    }
		}	
		return $userAvatar;
	}	
	public function updateUserOnline($userId, $online) {		
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET online = '".$online."' 
			WHERE user_id = '".$userId."'";			
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
	}
	public function insertChat($reciever_userid, $user_id, $chat_message) {		
		$sqlInsert = "
			INSERT INTO ".$this->chatTable." 
			(reciever_userid, sender_userid, message, status) 
			VALUES ('".$reciever_userid."', '".$user_id."', '".$chat_message."', '1')";
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if(!$result){
			return ('Error in query: '. mysqli_error());
		} else {
			$conversation = $this->getUserChat($user_id, $reciever_userid);
			$data = array(
				"conversation" => $conversation			
			);
			echo json_encode($data);	
		}
	}
	public function getUserChat($from_user_id, $to_user_id) {
		$fromUserAvatar = $this->getUserAvatar($from_user_id);	
		$toUserAvatar = $this->getUserAvatar($to_user_id);			
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable." 
			WHERE (sender_userid = '".$from_user_id."' 
			AND reciever_userid = '".$to_user_id."') 
			OR (sender_userid = '".$to_user_id."' 
			AND reciever_userid = '".$from_user_id."') 
			ORDER BY timestamp ASC";
		$userChat = $this->getData($sqlQuery);	
		$conversation = '<ul>';
		foreach($userChat as $chat){
			$user_name = '';
			if($chat["sender_userid"] == $from_user_id) {
				$conversation .= '<li class="sent">';
				// $conversation .= '<img width="22px" height="22px" src="./assets/img/'.$fromUserAvatar.'" alt="" />';
			} else {
				$conversation .= '<li class="replies">';
				// $conversation .= '<img width="22px" height="22px" src="chat/userpics/'.$toUserAvatar.'" alt="" />';
			}			
			$conversation .= '<p>'.$chat["message"].'</p>';			
			$conversation .= '</li>';
		}		
		$conversation .= '</ul>';
		return $conversation;
	}
	public function showUserChat($from_user_id, $to_user_id) {		
		$userDetails = $this->getUserDetails($to_user_id);
		$toUserAvatar = '';
		foreach ($userDetails as $user) {
			$toUserAvatar = $user['avatar'];
			$userSection = '<img src="userpics/'.$user['avatar'].'" alt="" />
				<p>'.$user['username'].'</p>
				<div class="social-media">
					<i class="fa fa-facebook" aria-hidden="true"></i>
					<i class="fa fa-twitter" aria-hidden="true"></i>
					 <i class="fa fa-instagram" aria-hidden="true"></i>
				</div>';
		}		
		// get user conversation
		$conversation = $this->getUserChat($from_user_id, $to_user_id);	
		// update chat user read status		
		$sqlUpdate = "
			UPDATE ".$this->chatTable." 
			SET status = '0' 
			WHERE sender_userid = '".$to_user_id."' AND reciever_userid = '".$from_user_id."' AND status = '1'";
		mysqli_query($this->dbConnect, $sqlUpdate);		
		// update users current chat session
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET current_session = '".$to_user_id."' 
			WHERE userid = '".$from_user_id."'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
		$data = array(
			"userSection" => $userSection,
			"conversation" => $conversation			
		 );
		 echo json_encode($data);		
	}	
	public function getUnreadMessageCount($senderUserid, $recieverUserid) {
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable."  
			WHERE sender_userid = '$senderUserid' AND reciever_userid = '$recieverUserid' AND status = '1'";
		$numRows = $this->getNumRows($sqlQuery);
		$output = '';
		if($numRows > 0){
			$output = $numRows;
		}
		return $output;
	}	
	public function updateTypingStatus($is_type, $loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET is_typing = '".$is_type."' 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}		
	public function fetchIsTypeStatus($userId){
		$sqlQuery = "
		SELECT is_typing FROM ".$this->chatLoginDetailsTable." 
		WHERE user_id = '".$userId."' ORDER BY last_activity DESC LIMIT 1"; 
		$result =  $this->getData($sqlQuery);
		$output = '';
		foreach($result as $row) {
			if($row["is_typing"] == 'yes'){
				$output = ' - <small><em>Typing...</em></small>';
			}
		}
		return $output;
	}		
	public function insertUserLoginDetails($userId) {		
		$sqlInsert = "
			INSERT INTO ".$this->chatLoginDetailsTable."(user_id) 
			VALUES ('".$userId."')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
        return $lastInsertId;		
	}	
	public function updateLastActivity($loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET last_activity = now() 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}	
	public function getUserLastActivity($userId) {
		$sqlQuery = "
			SELECT last_activity FROM ".$this->chatLoginDetailsTable." 
			WHERE user_id = '$userId' ORDER BY last_activity DESC LIMIT 1";
		$result =  $this->getData($sqlQuery);
		foreach($result as $row) {
			return $row['last_activity'];
		}
	}	
}
?>