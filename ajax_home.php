<?php 

include 'db_connect.php';
$db_handle = new DBController(); 
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$action = $_GET['action'];
$date = date('y-m-d H:i');
session_start();
if($action =="friend"){
	extract($_POST);
   if($actions == "add"){
	   $query = "SELECT * FROM relatives WHERE user_id = $user_id_add and friend_id = $user_friend_add";
	   $result = $db_handle->runQuery($query);
	   if(empty($result)){
		   $querys = "INSERT INTO relatives(user_id, friend_id, confirm) VALUES ($user_id_add , $user_friend_add , '$actions')";
		   $sql = $db_handle->insert($querys);
		   echo "success";
	   }
   } else if ($actions == "accept") {
	   $friend = $db_handle->runQuery("SELECT * FROM relatives WHERE user_id = $user_friend_add and friend_id =  $user_id_add");
	   if(!empty($friend)){
		   $relative_id = $friend[0]['id'];
	   }
	   $query1 = "UPDATE relatives SET confirm = '$actions' where id = '$relative_id' ";
	   $db_handle->update($query1);
	   echo "succes";
   } else if ($actions == "delete"){
	   $friend = $db_handle->runQuery("SELECT * FROM relatives WHERE user_id = $user_id_add and friend_id =  $user_friend_add");
	   if(!empty($friend)){
		   $relative_id = $friend[0]['id'];
		   $query1 = "DELETE FROM relatives where id = '$relative_id' ";
		   $db_handle->update($query1);
	   }
	   
	   echo "succes";
   }
}
if($action == "insert_chat"){
	$incoming_msg_id = $_POST['incoming_msg'];
	$outgoing_msg_id = $_POST['outgoing_msg'];
	$text_message = $_POST['text-message'];
	if($_FILES['upload_file']['name'] != "" ){
		$img_name = $_FILES['upload_file']['name'];
		$tmp_name = $_FILES['upload_file']['tmp_name'];

		$img_explode = explode('.',$img_name);
		$img_ext = end($img_explode);

		$extension = ['png','jpeg','jpg']; 
		if(in_array($img_ext,$extension) === true ){
			move_uploaded_file($tmp_name,"assets/uploads/".$img_name);
			$query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, date_send, img_name) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date', '$img_name')";
			$sql = $db_handle->insert($query);
		}
		else {
			$ext = pathinfo($img_name, PATHINFO_EXTENSION);
			//tạo mảng chứa các đuôi file
			$allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
			if(in_array($ext , $allowed)){
				move_uploaded_file($tmp_name,"assets/uploads/".$img_name);
				$query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg , date_send, file_name) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date', '$img_name')";
				$sql = $db_handle->insert($query);
			}
		}
	}else{
		if($text_message != ""){
			$query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, date_send) VALUES($incoming_msg_id, $outgoing_msg_id, '$text_message', '$date')";
			$sql = $db_handle->insert($query);  
		}
	}
}
if($action == "get_chat"){
	extract($_POST);
	$output = "";
	if(!empty($incoming_msg_id)){
		//echo $outgoing_msg_id;
		$query = "SELECT * FROM messages WHERE incoming_msg_id = '$incoming_msg_id' and outgoing_msg_id= '$outgoing_msg_id' 
		or incoming_msg_id = '$outgoing_msg_id' and outgoing_msg_id= '$incoming_msg_id' ORDER BY id ASC";
		$messages = $db_handle->runQuery($query);
		$incoming = $db_handle->runQuery("SELECT * FROM users WHERE id = '$incoming_msg_id'");
		$incoming_name = $incoming[0]['firstname'] . " " . $incoming[0]['lastname'];
		$incoming_img = $incoming[0]['profile_pic'];
		$out = $db_handle->runQuery("SELECT * FROM users WHERE id = '$outgoing_msg_id'");
		$out_id = $out[0]['id'];
		$out_name = $out[0]['firstname'] . " " . $out[0]['lastname'];
		$out_img = $out[0]['profile_pic'];
		if(!empty($messages)){
			foreach($messages as $message){
				$hide = "";
				$hidemsg = "";
				$hidefile = "";
				$msg_file = $message['file_name'];
				if(!$message['img_name']){
					$hide = "none";
				}
				if($message['msg']=="" ){
					$hidemsg = "none";
				}
				if($msg_file == ""){
					$hidefile = "none";
				}
			
				if($message['outgoing_msg_id'] == $out_id){
					
					$output .= '<div class="d-flex align-items-center text-right justify-content-end ">
								<div class="pr-2"><p class="name">'. $incoming_name .'</p>
									<p class="msg" style="display: '. $hidemsg .'">'. $message['msg'] .'</p>
									<img src="assets/uploads/'.$message['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
									<a class="btn btn-light text-primary" href="assets/uploads/'. $msg_file .'" download  style="display: '.$hidefile.';">'. $msg_file .'</a>
								<div class=""><span class="between">'. $message['date_send'] .'</span></div>
								</div>
								<div><img src="assets/uploads/'. $incoming_img .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
								</div>';
				}
				else {
					$output .= '<div class="d-flex align-items-center">
					<div class="text-left pr-1"><img src="assets/uploads/'. $out_img .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
					<div class="pr-2 pl-1"> <p class="name">'. $out_name .'</p>
						<p class="msg" style="display: '. $hidemsg .'">'. $message['msg'] .'</p>
						<img src="assets/uploads/'.$message['img_name'].'" alt="" style=" width: 120px; height: 120px; display: '.$hide.';">
						<a class="btn btn-light text-primary" href="assets/uploads/'. $msg_file .'" download  style="display: '.$hidefile.';">'. $msg_file .'</a>
						<div class=""><span class="between">'. $message['date_send'] .'</span></div>
					</div>
				</div>';
				}
			}
			echo $output;
		}
	}
}
if($action == "create_group"){
	$group_name = $_POST['name_group'];
    if($group_name == ""){
        $group_name = $_POST['host_id'];
    }
    $host_id = $_POST['host_id'];
    $query = "INSERT INTO group_name (group_name, id_host) VALUES('$group_name', $host_id)";
    $sql = $db_handle->insert($query);
	$group = $db_handle->runQuery("SELECT * FROM group_name WHERE group_name= '$group_name'");
	$group_id = $group[0]['id'];
	$query1 = "INSERT INTO group_mem(group_id, id_mem) VALUES ($group_id,$host_id)";
    $sql1 = $db_handle->insert($query1);
}
if($action == "btn-add-group"){
	extract($_POST);
	$user = $db_handle->runQuery("SELECT * FROM users");
	$out_put = '<form action="" method="post" id="add-mem-group">
	<input type="hidden" name="groupid" id="groupid" value="'.$group_id_mem.'">';
	foreach($user as $u){
		$id_user_group = $u['id'];
		$have_group = $db_handle->runQuery("SELECT * FROM group_mem WHERE group_id ='$group_id_mem' and id_mem = '$id_user_group'");
		$have_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $id_user_group and user_id = $user_id and confirm = 'accept'
		or user_id = $id_user_group and friend_id = $user_id and confirm = 'accept' ");
		if(empty($have_group) && !empty($have_friend)){
			$out_put .= '
			<div class="form-group">
				<label class="p-1 msg" for="'. $id_user_group .'"><span>'. $u['firstname'] . " " . $u['lastname'].'</span></label>
				<input type="checkbox" class="form-check-input p-1" name="'. $id_user_group .'" id="'. $id_user_group .'" style="margin-left: 70px">
			</div>
				';
		}
	}
	$out_put .= '<button type="button" class="btn btn-success btn-acp">xác nhận</button>
	</form>
	<script >
	const add_mem_group = document.querySelector("#add-mem-group");
	add_mem_group.onsubmit = (e) => {
		e.preventDefault();
	}
	$(".btn-acp").click(function (e){
		$(".wrapper-add").hide();
		let xhr = new XMLHttpRequest();// tạo sml object
			xhr.open("POST","ajax_home.php?action=add-mem-group",true),
			xhr.onload = () => {
				if(xhr.readyState === XMLHttpRequest.DONE){
					if(xhr.status === 200){
						let data = xhr.response;
						//console.log(data);
					}
				}
			}
		let formData = new FormData(add_mem_group);
		xhr.send(formData);
	});
	</script>'
	;
	echo $out_put;
}
if($action == "add-mem-group"){
	$query = "SELECT * FROM users";
	$users = $db_handle->runQuery($query);
	$group_id = $_POST['groupid'];
	foreach($users as $user){
		if(isset($_POST[''. $user['id'] .''])){
			$mem_id = $user['id'];
			$query3 = "INSERT INTO group_mem(group_id, id_mem) VALUES ($group_id,$mem_id)";
			$sql1 = $db_handle->insert($query3);
		}

	}
}
if($action == "insert_chat_group"){

	$id_group = $_POST['group_id'];
	$incoming_msg_id = $_POST['id_send'];
	$text_message = $_POST['text-message-group'];
	if($_FILES['upload_file_group']['name'] != ""){
		$img_name = $_FILES['upload_file_group']['name'];
		$tmp_name = $_FILES['upload_file_group']['tmp_name'];

		$img_explode = explode('.',$img_name);
		$img_ext = end($img_explode);

		$extension = ['png','jpeg','jpg']; 
		if(in_array($img_ext,$extension) === true ){
			move_uploaded_file($tmp_name,"assets/uploads/".$img_name);
			$query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg , img_name, date_send) VALUES($incoming_msg_id, $id_group, '$text_message', '$img_name', '$date')";
			$sql = $db_handle->insert($query);
		}
		else {
			$ext = pathinfo($img_name, PATHINFO_EXTENSION);
			//tạo mảng chứa các đuôi file
			$allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
			if(in_array($ext , $allowed)){
				move_uploaded_file($tmp_name,"assets/uploads/".$img_name);
				$query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg , date_send, file_name) VALUES($incoming_msg_id, $id_group, '$text_message', '$date', '$img_name')";
				$sql = $db_handle->insert($query);
			}
		}
	}else{
		if($text_message != ""){
			$query = "INSERT INTO group_chat (incoming_msg_id, group_id, msg, date_send) VALUES($incoming_msg_id, $id_group, '$text_message', '$date')";
			$sql = $db_handle->insert($query);
		}
	}
}
if($action == "get_chat_group"){
	extract($_POST);
	$output = "";
	if(!empty($id_send)){
		//echo $outgoing_msg_id;
		$query = "SELECT * FROM group_chat WHERE  group_id= '$group_id'";
		$group_msgs = $db_handle->runQuery($query);
		if(!empty($group_msgs)){
			foreach($group_msgs as $group_msg){
				$group_file =  $group_msg['file_name'];
				$hidemsg = "";
				$hidefile = "";
				$hide = "";
				if(!$group_msg['img_name'] ){
					$hide = "none";
				}
				if($group_msg['msg']=="" ){
					$hidemsg = "none";
				}
				if($group_file =="" ){
					$hidefile = "none";
				}
				
				if($group_msg['incoming_msg_id'] == $id_send){
					$user_send = $db_handle->runQuery("SELECT * FROM users WHERE id = '$id_send'");
					$user_send_name = $user_send[0]['firstname'] . " " . $user_send[0]['lastname'];
					$output .= '<div class="d-flex align-items-center text-right justify-content-end ">
								<div class="pr-2"> <p class="name">'. $user_send_name .'</p>
									<p class="msg" style="display: '. $hidemsg .'">'. $group_msg['msg'] .'</p>
									<img src="assets/uploads/'.$group_msg['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
									<a class="btn btn-light text-primary" href="../files/upload/'. $group_file .'" download  style="display: '.$hidefile.';">'. $group_file .'</a>
								<div class=""><span class="between">'. $group_msg['date_send'] .'</span></div>
								</div>
								<div><img src="assets/uploads/'. $user_send[0]['profile_pic'] .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
								</div>';
				}
				else {
					$in_msg = $group_msg['incoming_msg_id'];
					$user_send = $db_handle->runQuery("SELECT * FROM users WHERE id = '$in_msg'");
					$user_send_name = $user_send[0]['firstname'] . " " . $user_send[0]['lastname'];
					$output .= '<div class="d-flex align-items-center">
					<div class="text-left pr-1"><img src="assets/uploads/'. $user_send[0]['profile_pic'] .'" style="width: 40px; height: 40px" class="rounded-circle user_img" /></div>
					<div class="pr-2 pl-1"> <p class="name">'. $user_send_name .'</p>
						<p class="msg" style="display: '. $hidemsg .'">'. $group_msg['msg'] .'</p>
						<img src="assets/uploads/'.$group_msg['img_name'].'" alt="" style="width: 120px; height: 120px; display: '.$hide.';">
						<a class="btn btn-light text-primary" href="../files/upload/'. $group_file .'" download  style="display: '.$hidefile.';">'. $group_file .'</a>
						<div class=""><span class="between">'. $group_msg['date_send'] .'</span></div>
					</div>
				</div>';
				}
			}
			echo $output;
		}
	}
}
if($action == "edit-img"){
	$user_id = $_POST['user_id'];
	$type = $_POST['type'];
	if(isset($_FILES['edit_cover'])){
		$img_name = $_FILES['edit_cover']['name'];
		$tmp_name = $_FILES['edit_cover']['tmp_name'];
	
		$img_explode = explode('.',$img_name);
		$img_ext = end($img_explode);
	
		$extension = ['png','jpeg','jpg']; 
		if(in_array($img_ext,$extension) === true ){
			move_uploaded_file($tmp_name,"../img/avartar/".$img_name);
			if($type == "cover"){
				$query = "UPDATE users SET img_cover ='$img_name' where id = '$user_id' ";
				$sql = $db_handle->update($query);
			}
			else {
				$query = "UPDATE users SET img_user='$img_name' where id = '$user_id' ";
				$sql = $db_handle->update($query);
			}
			echo "success" ;
		}
		else {
			echo "Please select an Image file -png,jpeg,jpg!";
		}
	}
}else if($action == "send-email"){
$email_to = $_POST['email_to'];
$email = $_POST['email_user'];
$subject = $_POST['subject'];
$message = $_POST['msg_email'];

//Load composer's autoloader

$mail = new PHPMailer(true);                            
try {
	//Server settings
	$mail->isSMTP();                                     
	$mail->Host = 'smtp.gmail.com';                      
	$mail->SMTPAuth = true;                             
	$mail->Username = $email;     
	$mail->Password = 'Nintendo1212';             
	$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
	);                         
	$mail->SMTPSecure = 'ssl';                           
	$mail->Port = 465;                                   

	//Send Email
	$mail->setFrom($email);

	//Recipients
	$mail->addAddress($email_to);              
	$mail->addReplyTo($email);

	//Content
	$mail->isHTML(true);                                  
	$mail->Subject = $subject;
	$mail->Body    = $message;
	for ($i=0; $i < count($_FILES['file_email']['tmp_name']) ; $i++) { 
		# code...
		$img_name = $_FILES['file_email']['name'][$i];
		$tmp_name = $_FILES['file_email']['tmp_name'][$i];
		$img_explode = explode('.',$img_name);
		$img_ext = end($img_explode);
		$extension = ['png','jpeg','jpg','doc','docx','pdf','txt','gif','ppt','xlsx','zip','zar'];
		if(in_array($img_ext,$extension) === true ){
			$mail->addAttachment($tmp_name,$img_name);
		}

	}
	$mail->send();
	echo "success";
} catch (Exception $e) {
	echo "fail";
}

}

if($action == "forgot"){
	$type = $_GET['type'];
	if($type == "check"){
		$forgot = $_POST['forgot_email'];
		$query = "SELECT * FROM users WHERE email = '$forgot' or contact = '$forgot'";
		$result = $db_handle->runQuery($query);
		if(!empty($result)){
			$random_code = rand(time(), 10000000);
			$_SESSION['random_code']= $random_code;
			$msg = "Mã xác thực của bạn là: " . $random_code;
			$subject = "Code confirm.";
			$sender = "From: hltkhai.learning.3@gmail.com";
			$mail = new PHPMailer(true);   
			$email_to = $result[0]['email'];
			$email = "hltkhai.learning.3@gmail.com";
			$_SESSION['email'] = $email_to;
			try {
				//Server settings
				$mail->isSMTP();                                     
				$mail->Host = 'smtp.gmail.com';                      
				$mail->SMTPAuth = true;                             
				$mail->Username = $email;     
				$mail->Password = 'Nintendo1212';             
				$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				);                         
				$mail->SMTPSecure = 'ssl';                           
				$mail->Port = 465;                                   
			
				//Send Email
				$mail->setFrom($email);
			
				//Recipients
				$mail->addAddress($email_to);              
				$mail->addReplyTo($email);
			
				//Content
				$mail->isHTML(true);                                  
				$mail->Subject = $subject;
				$mail->Body    = $msg;
				
				$mail->send();
				echo "success";
			} catch (Exception $e) {
				echo "fail";
			}
			//echo $random_code;
		}else {
			echo "Email hoặc số điện thoại không đúng vui lòng nhập lại.";
		}
	}
	else if($type == "confirm"){
        $code = $_SESSION['random_code'];
        $code_confirm = $_POST['code'];
        if($code == $code_confirm){
            echo "success";
        }else {
            echo "Vui lòng nhập lại mã.";
        }

    }
	else if($type == "change_pass"){
        $pass = $_POST['password'];
        $c_pass = $_POST['c-password'];
        $email = $_SESSION['email'];
        if(!empty($pass) || !empty($c_pass)){
            if($pass == $c_pass){
                if(preg_match('/^[a-zA-Z0-9._-]{6,15}$/',$pass)){
					$passs = md5($pass);
                    $query = "UPDATE users SET password = '$passs' where email = '$email' ";
                    $db_handle->update($query);
					unset($_SESSION['email']);
                    echo "success";
                }
                else {
                    echo "Please try again your pass!";
                }
            }
            else {
                echo "Vui lòng xác thực lại mật khẩu ";
            }
        }
        else {
            echo "Vui lòng nhập mật khẩu và xác thực lại. ";
        }
    }
}

?>