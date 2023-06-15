<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
<link href="chat/css/style.css" rel="stylesheet" id="bootstrap-css">
<script src="chat/js/chat.js"></script>
<style>
.modal-dialog {
    width: 400px;
    margin: 30px auto;	
}
</style>
<?php //include('chat/container.php');?>
<style>
      iframe {
        width: 100%;
        height: 100%;
        border: none;
      }
    </style>
<div class="content">
<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title">Chat</h4>
               
              </div>
              <div class="card-body">
    

<div class="content">		
		
	<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']) { ?> 	
		<div class="chat">	
			<div id="frame">		
				<div id="sidepanel">
					<div id="profile">
					<?php
					include ('chat/Chat.php');
					$chat = new Chat();
					$loggedUser = $chat->getUserDetails($_SESSION['user_id']);
					echo '<div class="wrap">';
					$currentSession = '';
					foreach ($loggedUser as $user) {
						$currentSession = $user['current_session'];
						if($user['img']==""){
						    $avtar="user6.jpg";
						}
						else{
						   $avtar= $user['img'];
						}
						echo '<img id="profile-img" src="assets/img/avatars/'.$_SESSION['img'].'" class="online" alt="" />';
						echo  '<p>'.$user['username'].'</p>';
							echo '<div id="status-options">';
							echo '<ul>';
								echo '<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>';
								echo '<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>';
								echo '<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>';
								echo '<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>';
							echo '</ul>';
							echo '</div>';
							echo '<div id="expanded">';			
							echo '<a href="logout.php">Logout</a>';
							echo '</div>';
					}
					echo '</div>';
					?>
					</div>
					<div id="search">
						<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
						<input type="text" placeholder="Search contacts..." />					
					</div>
					<div id="contacts">	
					<?php
					echo '<ul style="padding-top:20px;">';
					$chatUsers = $chat->chatUsers($_SESSION['user_id']);
					foreach ($chatUsers as $user) {
						$status = 'offline';						
						if($user['online']) {
							$status = 'online';
						}
						if($user['img']==""){
						    $img="default-avatar.png";
						}
						else{
						   $img= $user['img'];
						}
						$activeUser = '';
						if($user['user_id'] == $currentSession) {
							$activeUser = "active";
						}
						echo '<li id="'.$user['user_id'].'" class="contact '.$activeUser.'" data-touserid="'.$user['user_id'].'" data-tousername="'.$user['username'].'">';
						echo '<div class="wrap">';
						echo '<span id="status_'.$user['user_id'].'" class="contact-status '.$status.'"></span>';
						echo '<img src="assets/img/avatars/'.$img.'" alt="" />';
						echo '<div class="meta">';
						echo '<p class="name">'.$user['username'].'<span id="unread_'.$user['user_id'].'" class="unread">'.$chat->getUnreadMessageCount($user['user_id'], $_SESSION['user_id']).'</span></p>';
						echo '<p class="preview"><span id="isTyping_'.$user['user_id'].'" class="isTyping"></span></p>';
						echo '</div>';
						echo '</div>';
						echo '</li>'; 
					}
					echo '</ul>';
					?>
					</div>
				<!--	<div id="bottom-bar">	
						<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
						<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>					
					</div>-->
				</div>			
				<div class="content" id="content"> 
					<div class="contact-profile" id="userSection">	
					<?php
					$userDetails = $chat->getUserDetails($currentSession);
					foreach ($userDetails as $user) {										
						echo '<img src="chat/userpics/'.$user['avatar'].'" alt="" />';
							echo '<p>'.$user['username'].'</p>';
					}	
					?>						
					</div>
					<div class="messages" id="conversation">		
					<?php
					echo $chat->getUserChat($_SESSION['user_id'], $currentSession);						
					?>
					</div>
					<div class="message-input" id="replySection">				
						<div class="message-input" id="replyContainer">
							<div class="wrap">
								<input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Write your message..." />
								<button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>	
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<br>
		<br>
		<strong><a href="login.php"><h3>Login To Access Chat System</h3></a></strong>		
	<?php } ?>
	<br>
	<br>	

</div>	

              </div>
            </div>
          </div>
</div>

<?php include "includes/footer.php" ?>