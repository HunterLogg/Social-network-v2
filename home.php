<?php
include 'db_connect.php';
$db_handle = new DBController(); 
$email = $_SESSION['login_email'];
$user_id = $_SESSION['login_id'];
?>
<style>
	.left-panel{
		width: calc(25%);
		height: calc(100% - 3rem);
		overflow: auto;
		position: fixed;
	}
	.center-panel{
		left: calc(25%);
		width: calc(50%);
		height: calc(100% - 3rem);
		overflow: auto;
		position: fixed;
	}
	.right-panel{
		right: calc(0%);
		width: calc(25%);
		height: calc(100% - 3rem);
		overflow: auto;
		position: fixed;
	}
	.side-nav:hover,.post-link:hover{
		background: #00000026
	}
	.wrapper-chat {
  height: 93vh;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-left: 72%;
}
.wrapper-add{
  height: 92vh;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-left: 60%;
}

.wrapper-email{
  height: 92vh;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-left: 60%;
}

.wrapper-group {
  height: 93vh;
  display: flex;
  justify-content: left;
  align-items: flex-end;
  margin-left: 70%;
}

.main-chat {
  background-color: #eee;
  width: 350px;
  position: relative;
  border-radius: 8px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  padding: 6px 0px 0px 0px
}

.scroll {
  overflow-y: scroll;
  scroll-behavior: smooth;
  height: 350px
}

.img1 {
  border-radius: 50%;
  background-color: #66BB6A
}

.name {
  font-size: 8px
}

.msg {
  background-color: #fff;
  font-size: 16px;
  padding: 5px;
  border-radius: 5px;
  font-weight: 500;
  color: #3e3c3c
}

.between {
  font-size: 8px;
  font-weight: 500;
  color: #a09e9e
}

.navbar {
  border-bottom-left-radius: 8px;
  border-bottom-right-radius: 8px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}

.icon1 {
  color: #7C4DFF !important;
  font-size: 18px !important;
  cursor: pointer
}

.icon2 {
  color: #512DA8 !important;
  font-size: 18px !important;
  position: relative;
  left: 8px;
  padding: 0px;
  cursor: pointer
}

.icondiv {
  border-radius: 50%;
  width: 15px;
  height: 15px;
  padding: 2px;
  position: relative;
  bottom: 1px
}

.form-control-message {
  font-size: 15px;
  font-weight: 400;
  width: 230px;
  height: 30px;
  border-radius: 12px;
  border: 1px solid #F0F0F0;
}
.cardmessage {
  width: 300px;
  border: none;
  border-radius: 15px
}

.adiv {
  background: #B2B1B9;
  border-radius: 15px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  font-size: 20px;
  height: 46px
}

.chat {
  border: none;
  background: #E2FFE8;
  font-size: 10px;
  border-radius: 20px
}
</style>
<div class="d-flex w-100 h-100">
	<div class="left-panel mt-1">
		<a href="index.php?page=profile" class="d-flex py-2 px-1 text-dark side-nav rounded">
			 <?php if(isset($_SESSION['login_profile_pic']) && !empty($_SESSION['login_profile_pic'])): ?>
                <div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
                  <img src="assets/uploads/<?php echo $_SESSION['login_profile_pic'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                </div>
              <?php else: ?>
              <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
              <?php endif; ?>
              <span class="ml-3"><b><?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_lastname']) ?></b></span>
		</a>
		<span style="margin-left: 10px;">Người bạn có thể biết</span>
            <div id="user-know">
                <?php 
				$know = $db_handle->runQuery("SELECT * FROM users");
                foreach($know as $value){
					$some_one = $value['id'];
                    if($some_one == $user_id){
                        continue;
                    }
                    
                    $if_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $some_one and user_id = $user_id and confirm = 'accept' or user_id = $some_one and friend_id = $user_id and confirm = 'accept' ");
                    if(!empty($if_friend)){
                        continue;
                    }

                    
                ?>
                <a href="" class="d-flex py-2 px-1 text-dark side-nav rounded btn">
                <div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
                    <img src="assets/uploads/<?php echo  $value['profile_pic']; ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
                </div>
                <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                <span class="" style="margin-top: 7px;"><b><?php echo $value['firstname']. " " . $value['lastname']; ?></b></span>
                <!-- <button type="button" class="btn btn-secondary btn-addfriend" user-id-add="<?php echo $user_id;?>" user-friend-add="<?php echo $value['id'];?>" style="margin-left: 30px">Thêm bạn bè</button> </a>
                            <hr>-->
                <?php 
                $friend_delete_add = $db_handle->runQuery("SELECT * FROM relatives where user_id = $user_id and friend_id = $some_one and confirm = 'add' ");
                if(!empty($friend_delete_add)){
                    echo '<button type="button" class="btn btn-danger btn-delete-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Hủy lời mời</button> </a>
                    <hr>';
                }
                $friend_accept_add = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $user_id and user_id = $some_one and confirm = 'add' ");
                if(!empty($friend_accept_add)){
                    echo '<button type="button" class="btn btn-success btn-Accept-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Đồng ý</button> 
                    <button type="button" class="btn btn-danger btn-delete-add" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 5px">Từ chối</button> </a>
                    <hr>';
                }
                if(empty($friend_delete_add) && empty($friend_accept_add)){
                    echo '<button type="button" class="btn btn-light btn-addfriend" user-id-add="'.$user_id.'" user-friend-add="'. $value['id'].'" style="margin-left: 30px">Thêm bạn bè</button> </a>
                    <hr>';
                }
                
                } ?>
            </div>
		<hr>
	</div>
	<div class="center-panel py-3 px-2">
		<div class="container-fluid">
			<div class="col-md-12">
				<div class="card card-widget">
					<div class="card-body">
						<div class="container-fluid">
							<div class="d-flex w-100">
								<div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
					                  <img src="assets/uploads/<?php echo $_SESSION['login_profile_pic'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="max-width: calc(100%);height: calc(100%);">
				                </div>
				                <button class="btn btn-default ml-4 text-left" id="write_post" type="button" style="width:calc(80%);border-radius: 50px !important;"><span>What's on your mind, <?php echo ucwords($_SESSION['login_firstname']) ?>?</span></button>
							</div>
							<hr>
							<div class="d-flex w-100 justify-content-center">
								<a href="javascript:void(0)" id="upload_post" class="text-dark post-link px-3 py-1" style="border-radius: 50px !important;"><span class="fa fa-photo-video text-success"></span> Photo/Video</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 

			$posts = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as name,u.profile_pic from posts p inner join users u on u.id = p.user_id  where p.type = 0 order by unix_timestamp(p.date_created) desc");
			while($row=$posts->fetch_assoc()):
			$row['content'] = str_replace("\n","<br/>",$row['content']);
			$is_liked =  $conn->query("SELECT * FROM likes where user_id = {$_SESSION['login_id']} and post_id = {$row['id']} ")->num_rows ? "text-primary" : "";
			$liked =  $conn->query("SELECT * FROM likes where post_id = {$row['id']} ")->num_rows;
			$commented =  $conn->query("SELECT * FROM comments where post_id = {$row['id']} ")->num_rows;
			$post_user_id = $row['user_id'];
			$not_friend = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $post_user_id and user_id = $user_id and confirm = 'accept' 
            or user_id = $post_user_id and friend_id = $user_id and confirm = 'accept' ");
            if(empty($not_friend) && $user_id != $post_user_id){
                continue;
            }
			?>
			<div class="col-md-12">
				
			<div class="card card-widget post-card" data-id="<?php echo $row['id'] ?>">
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="assets/uploads/<?php echo $row['profile_pic'] ?>" alt="User Image">
                  <span class="username"><a href="#"><?php echo $row['name'] ?></a></span>
                  <span class="description">Posted - <?php echo date("M d,Y h:i a",strtotime($row['date_created'])) ?></span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                	<?php if($_SESSION['login_id'] == $row['user_id']): ?>
                	<div class="dropdown">
	                  <button type="button" class="btn btn-tool" data-toggle="dropdown" title="Manage">
	                    <i class="fa fa-ellipsis-v"></i>
	                  </button>
	                  <div class="dropdown-menu">
              			<a class="dropdown-item edit_post" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Edit</a>
              			<a class="dropdown-item delete_post" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
	                  </div>
	                  </div>
	              <?php endif; ?>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- post text -->
                <?php 
                $protocal = array("http://", "https://", "fpt://");
                $conf = 0 ;
                $content_post = $row['content'];
                foreach($protocal as $value) {
                    if(strlen(strstr($content_post, $value)) > 0) {
                        echo '<a class="content-field" style="margin-top: 20px" href="'.$content_post.'">'.$content_post.'</a> <br>';
                        $conf = 1 ;
                        break;
                    }
                }
                if($conf == 0 ){
                    echo '<p class="content-field" style="margin-top: 20px">'.$content_post.'</p>';
                }
                ?>

              	<a href="javascript:void(0)" class="d-none show-content" >Show More</a>
              	<?php if(is_dir('assets/uploads/'.$row['id'])): ?>
              	<div class="gallery mb-2">
              		<?php
              		$gal = scandir('assets/uploads/'.$row['id']);
					unset($gal[0]);
					unset($gal[1]);
					$count =count($gal);
					$i = 0;
					foreach($gal as $k => $v):
						$mime = mime_content_type('assets/uploads/'.$row['id'].'/'.$v);
						$i++;
						if($i > 4)
						break;
						$style = '';
						if($count == 1){
							$style = "grid-column-start: 1;grid-column-end: 3;grid-row-start: 1;grid-row-end: 3;";
						}elseif($count == 2){
							// if($i==1)
							$style = "grid-column-start: {$i};grid-column-end: ".($i + 1).";grid-row-start: 1;grid-row-end: 3;";
						}elseif ($count == 3) {
							if($i == 1)
							$style = "grid-column-start: {$i};grid-column-end: ".($i + 1).";grid-row-start: 1;grid-row-end: 3;";
						}
              		 ?>
              		 <figure class="gallery__item position-relative" style="<?php echo $style ?>">
					   <?php if($i == 4 && $count > 4): ?>
						<div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100" style="top:0;left:0;z-index:1" >
							<a href="javascript:void(0)" class="text-white view_more" data-id="<?php echo $row['id'] ?>"><h4 class="text-white text-center"><?php echo '+ '.($count-4) ?> More</h4></a>
						</div>
					    <?php endif; ?>
              		 	<?php if(strstr($mime,'image')): ?>
              		 		<a href="assets/uploads/<?php echo $row['id'].'/'.$v ?>" class="lightbox-items" data-toggle="lightbox<?php echo $row['id'] ?>" data-slide="<?php echo $k ?>" data-title="" data-gallery="gallery"  data-id="<?php echo $row['id'] ?>">
					    <img src="assets/uploads/<?php echo $row['id'].'/'.$v ?>" class="gallery__img" alt="Image 1">
					    </a>
					    <?php else: ?>
							<?php if($count > 1): ?>
								<a href="assets/uploads/<?php echo $row['id'].'/'.$v ?>" class="lightbox-items" data-toggle="lightbox<?php echo $row['id'] ?>" data-slide="<?php echo $k ?>" data-title="" data-gallery="gallery">
					    	<?php endif; ?>
					    	<video <?php echo $count == 1 ? "controls" : '' ?> class="gallery__img">
					    		 <source src="assets/uploads/<?php echo $row['id'].'/'.$v ?>" type="<?php echo $mime ?>">
					    	</video>
							<?php if($count > 1): ?>
							</a>
							<a href="javascript:void(0)" class="text-white view_more" data-id="<?php echo $row['id'] ?>" >
							<div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100" style="top:0;left:0;z-index:1" >
							<h3 class="text-white text-center rounded-circle "><i class="fa fa-play-circle "></i></h3>
							</div>
							</a>
					    	<?php endif; ?>

					    <?php endif; ?>
						
					  </figure>
              		<?php endforeach; ?>
              	</div>
              <?php endif; ?>

                <!-- Social sharing buttons -->
                <button type="button" class="btn btn-default btn-sm like <?php echo $is_liked ?>" data-id="<?php echo $row['id'] ?>"><i class="far fa-thumbs-up"></i> Like</button>
                <span class="float-right text-muted counts"><span class="like-count"><?php echo number_format($liked) ?></span> <?php echo $liked > 1 ? "likes" : "like" ?> - <span class="comment-count"><?php echo number_format($commented) ?></span> comments</span>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
				<?php 
					$comments = $conn->query("SELECT c.*,concat(u.firstname,' ',u.lastname) as name,u.profile_pic FROM comments c inner join users u on u.id = c.user_id where c.post_id = {$row['id']} order by unix_timestamp(c.date_created) asc ");
					while($crow = $comments->fetch_assoc()):
				?>
				<div class="card-comment">
					<!-- User image -->
					<img class="img-circle img-sm" src="assets/uploads/<?php echo $crow['profile_pic'] ?>" alt="User Image">

					<div class="comment-text">
					<span class="username">
						<span class="uname"><?php echo $crow['name'] ?></span>
						<span class="text-muted float-right timestamp"><?php echo date("M d,Y h:i A",strtotime($crow['date_created'])) ?></span>
					</span><!-- /.username -->
					<span class="comment">
					<?php echo str_replace("\n","<br/>",$crow['comment']) ?>
					</span>
					</div>
					<!-- /.comment-text -->
				</div>
				<?php endwhile; ?>
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="#" method="post">
                  <i class="img-fluid img-circle img-sm fa fa-comment"></i>
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <textarea cols="30" rows="1" class="form-control comment-textfield" style="resize:none" placeholder="Press enter to post comment" data-id="<?php echo $row['id'] ?>"></textarea>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
			</div>
		<?php endwhile; ?>
			
		</div>
	</div>
	<div class="right-panel">
            <hr>
            <span>Người liên hệ</span>
            <div class="card-body contacts_body">
				
                <?php 
                foreach($know as $friend){
                    $id_friend = $friend['id'];
                    $name_friend = $friend['firstname']. " " . $friend['lastname'];
                    $email_friend = $friend['email'];
                    $friends = $db_handle->runQuery("SELECT * FROM relatives where friend_id = $id_friend and user_id = $user_id and confirm = 'accept' or user_id = $id_friend and friend_id = $user_id and confirm = 'accept' ");
                    if(empty($friends)){
                        
                        continue;
                    }else {
                ?>
				
                    <a class="btn_message d-flex py-2 px-1 text-dark side-nav rounded btn" style="margin-bottom: 10px;" email_out="<?php echo $email_friend; ?>" incoming-msg-id="<?php echo $user_id; ?>" outgoing-msg-id="<?php echo $id_friend; ?>" 
                    outgoing-name="<?php echo $name_friend; ?>" >
					<div class="d-flex bd-highlight">
						<div class="img_cont">
							<img src="assets/uploads/<?php echo $friend['profile_pic'] ; ?>" style="width: 40px; height: 40px" class="rounded-circle user_img">
							<span class="online_icon offline"></span>
						</div>
						<div class="user_info">
							<span><?php echo $name_friend ; ?></span>
							<p><?php echo $friend['status'] == 1 ? "online": "offline"; ?></p>
						</div>
                        <button type="button" class="btn btn-danger btn-delete-add" user-id-add="<?php echo $user_id; ?>" user-friend-add="<?php echo $id_friend ?>" style="margin-left: 70px">Hủy kết bạn</button>
					</div>
                    </a>
                    
                <?php } } ?>
			</div>
            <hr>
            <center><span>Cuộc trò truyện nhóm <br></span>
            <button class="btn btn-primary btn-create-group">Tạo nhóm </button>
			<form action="" method="post" id="create-group" style ="display: none;">
				<span>Tên nhóm</span>
				<div class="form-group w-50">
				<input type="text" name="name_group" class="form-control" id="name_group">
				<input type="hidden" name="host_id" value="<?php echo $user_id; ?>">
				</div>
				<input type="submit" value="Xác nhận" class="btn btn-success btn-apt">
			</form>
            </center>
            <?php 
            $groups = $db_handle->runQuery("SELECT * FROM group_name");
			if(!empty($groups)){
            foreach($groups as $group){
                $groupid = $group['id'];
                $mems = $db_handle->runQuery("SELECT * FROM group_mem where id_mem = $user_id and group_id = $groupid");
                if(!empty($mems)){
                    $width = "100%";
                    if($user_id == $group['id_host']){
                        $width = "60%";
                    }
                    echo '<a href="#" class="btn_group d-flex py-2 px-1 text-dark side-nav rounded btn" style="width: '. $width.'  ;margin-bottom: 10px; float:left;" id_send="'.$user_id .'" 
                    group_id="'. $groupid .'" group-name="'. $group['group_name'] .'">
                    <div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left: -40px;">
                    </div>
                    <span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
                    <span class="ml-3" style="margin-top: 10px;"><b>'. $group['group_name'] .' </b></span>
                    </a>
                    ';
                }
                
                if($group['id_host'] == $user_id){
                    echo '<button type="button" class="btn btn-default p-2 btn-add-group" style="float:right; margin-top: 15px;" 
                    group_id_mem="'. $group['id'] .'" user_id="'.$user_id .'">Thêm Thành viên</button>
                    
                    
                    <input type="hidden" name="group_id" id="group_id" value="'. $group['id'] . '">
                    ';
                }
            }
			}
            ?>
    </div>
	<div class="wrapper-chat" style="display: none;">
    <div class="main-chat">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="chat_name pb-3">Live chat</span>
    <i class="fa fa-envelope btn-send-mail" data=""></i> <i class="fas fa-times close-msg"></i></div>
        <div class="px-2 scroll " id="get_message">
            
        </div>
        <div class="bg-white navbar-expand-sm d-flex justify-content-between">
            <span class="file_upload"></span>
            <img src="" alt="" class="img_msg">
        </div>
        <form action="" method="post" id="msg_form" class="navbar bg-white navbar-expand-sm d-flex justify-content-between" enctype="multipart/form-data">
            <input type="text" name="text-message" class="form-control-message text-message" placeholder="Type a message and enter to send...">
            <input type="hidden" name="incoming_msg" id="incoming_msg" >
            <input type="hidden" name="outgoing_msg" id="outgoing_msg">
            <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2">
            <input type="file" name="upload_file" id="upload_file">
            <label for="upload_file"><i class="fa fa-paperclip icon1" form="msg_form"></i></label></div>
            <i class="fa fa-arrow-circle-right icon2 send_chat"></i>
        </form>
            
	</div>
</div>

<div class="wrapper-group"style="display: none;" >
    <div class="main-chat">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="group_name pb-3">Live chat</span> <i class="fas fa-times close-group"></i> </div>
        <div class="px-2 scroll " id="get_chat_msg">
            
        </div>
        <div class="bg-white navbar-expand-sm d-flex justify-content-between">
            <span class="file_upload_group"></span>
            <img src="" alt="" class="img_msg_group">
        </div>
        <form action="" method="post" id="msg_group_form" class="navbar bg-white navbar-expand-sm d-flex justify-content-between" enctype="multipart/form-data">
            <input type="text" name="text-message-group" class="form-control-message text-message-group" placeholder="Type a message and enter to send...">
            <input type="hidden" name="group_id" class="group_id" >
            <input type="hidden" name="id_send" id="id_send" >
            <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2">
            <input type="file" name="upload_file_group" id="upload_file_group">
            <label for="upload_file_group"><i class="fa fa-paperclip icon1" form="msg_group_form"></i></label></div>
            <i class="fa fa-arrow-circle-right icon2 send_chat_group"></i>
        </form>
    </div>
    </div>

<div class="wrapper-add" style="display: none; margin-left: 60%; ">
    <div class="main-chat">
        <div class="px-2 scroll " id="get_form">
				
        </div>
    </div>  
</div>

<div class="wrapper-email" style="display: none ; margin-left: 60%; ">
    <div class="main-chat">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white"> <i class="fas fa-chevron-left"></i> <span class="pb-3">Send Email</span> <i class="ti-close btn close-email"></i> </div>
        <div class="px-2 scroll " >
        <form action="" method="post" id="send_email" enctype="multipart/form-data">
            <div class="form-group">
                <span>To: </span>
                <input type="hidden" name="email_user" value="<?php echo $email; ?>">
                <input type="text" class="form-control" name="email_to" id="email_to" value="" readonly>
            </div>
            <div class="form-group">
                <span>subject: </span>
                <input type="text" class="form-control" name="subject" id="subject" >
            </div>
            <div class="form-group">
                <span>Message: </span>
                <textarea class="form-control" name="msg_email" id="msg_email" cols="40" rows="4"></textarea>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" multiple="multiple" name="file_email[]" id="file_email" >
            </div>
            <input type="submit" class="btn btn-success submit_email" value="Send" style="float: right;">
        </form>
        </div>
    </div>  
</div>


<style>
	.gallery__img {
	    width: 100%;
	    height: 100%;
	    object-fit: cover;
	}
	.gallery {
	    display: grid;
	    grid-template-columns: repeat(2, 50%);
	    grid-template-rows: repeat(2, 30vh);
	    grid-gap: 3px;
	    grid-row-gap: 3px;
	}
	.gallery__item{
		margin: 0
	}
</style>
<div class="d-none " id="comment-clone">
<div class="card-comment">
	<!-- User image -->
	<img class="img-circle img-sm" src="" alt="User Image">

	<div class="comment-text">
	<span class="username">
		<span class="uname">Maria Gonzales</span>
		<span class="text-muted float-right timestamp">8:03 PM Today</span>
	</span><!-- /.username -->
	<span class="comment">
	It is a long established fact that a reader will be distracted
	by the readable content of a page when looking at its layout.
	</span>
	</div>
	<!-- /.comment-text -->
</div>
</div>
<script>
	$('.comment-textfield').on('keypress', function (e) {
		if(e.which == 13 && e.shiftKey == false){
			if($('#preload2').length <= 0){
				start_load();
			}else{
				return false;
			}
			var post_id = $(this).attr('data-id')
			var comment = $(this).val()
			$(this).val('')
			$.ajax({
				url:'ajax.php?action=save_comment',
				method:'POST',
				data:{post_id:post_id,comment:comment},
				success:function(resp){
					if(resp){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							var cfield = $('#comment-clone .card-comment').clone()
							cfield.find('.img-circle').attr('src','assets/uploads/'+resp.data.profile_pic)
							cfield.find('.uname').text(resp.data.name)
							cfield.find('.comment').html(resp.data.comment)
							cfield.find('.timestamp').text(resp.data.timestamp)
						$('.post-card[data-id="'+post_id+'"]').find('.card-comments').append(cfield)
						var cc = $('.post-card[data-id="'+post_id+'"]').find('.comment-count').text();
							cc = cc.replace(/,/g,'');
							cc = parseInt(cc) + 1
						$('.post-card[data-id="'+post_id+'"]').find('.comment-count').text(cc)
						}else{
							alert_toast("An error occured","danger")
						}
						end_load()
					}
				}
			})
			return false;
		}
    })
	$('.comment-textfield').on('change keyup keydown paste cut', function (e) {
		if(this.scrollHeight <= 117)
        $(this).height(0).height(this.scrollHeight);
    })
	$('#write_post').click(function(){
		uni_modal("<center><b>Create Post</b></center></center>","create_post.php")
	})
	$('.edit_post').click(function(){
		uni_modal("<center><b>Edit Post</b></center></center>","create_post.php?id="+$(this).attr('data-id'))
	})
	$('.delete_post').click(function(){
	_conf("Are you sure to delete this post?","delete_post",[$(this).attr('data-id')])
	})
	function delete_post($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=delete_post',
				method:'POST',
				data:{id:$id},
				success:function(resp){
					if(resp==1){
						alert_toast("Data successfully deleted",'success')
						setTimeout(function(){
							location.reload()
						},1500)

					}
				}
			})
		}
	$('#upload_post').click(function(){
		uni_modal("<center><b>Create Post</b></center></center>","create_post.php?upload=1")
	})
	$('.content-field').each(function(){
		var dom = $(this)[0]
		var divHeight = dom.offsetHeight
		if(divHeight > 117){
			$(this).addClass('truncate-5')
			$(this).parent().children('.show-content').removeClass('d-none')
		}
	})
	$('.show-content').click(function(){
		var txt = $(this).text()
		if(txt == "Show More"){
			$(this).parent().children('.content-field').removeClass('truncate-5')
			$(this).text("Show Less")
		}else{
			$(this).parent().children('.content-field').addClass('truncate-5')
			$(this).text("Show More")
		}
	})
	$('.lightbox-items').click(function(e){
		e.preventDefault()
		uni_modal("","view_attach.php?id="+$(this).attr('data-id'),"large")
	})
	$('.view_more').click(function(e){
		e.preventDefault()
		uni_modal("","view_attach.php?id="+$(this).attr('data-id'),"large")
	})
	$('.like').click(function(){
		var _this = $(this)
		$.ajax({
			url:'ajax.php?action=like',
			method:'POST',
			data:{post_id:$(this).attr('data-id')},
			success:function(resp){
				if(resp == 1){
					_this.addClass('text-primary')
					var lc = _this.siblings('.counts').find('.like-count').text();
							lc = lc.replace(/,/g,'');
							lc = parseInt(lc) + 1
					_this.siblings('.counts').find('.like-count').text(lc)
				}else if(resp==0){
					_this.removeClass('text-primary')
					var lc = _this.siblings('.counts').find('.like-count').text();
							lc = lc.replace(/,/g,'');
							lc = parseInt(lc) - 1
					_this.siblings('.counts').find('.like-count').text(lc)
				}
			}
		})
	})
	$(".btn-addfriend").click(function (e){
    var user_id_add = $(this).attr('user-id-add');
    var user_friend_add = $(this).attr('user-friend-add');
    var actions = "add";
    console.log(user_id_add);
    $.ajax({
        url:'ajax_home.php?action=friend',
        method:'POST',
        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
        success:function(resp){
            if(resp){
                //console.log(resp);
                //location.href = "index.php";
            }
        }
    })
	});
	$(".btn-delete-add").click(function (e){
	    var user_id_add = $(this).attr('user-id-add');
	    var user_friend_add = $(this).attr('user-friend-add');
	    var actions = "delete";
	    //console.log(user_friend_add);
	    $.ajax({
	        url:'ajax_home.php?action=friend',
	        method:'POST',
	        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
	        success:function(resp){
	            if(resp){
	                //console.log(resp);
	                //location.href = "index.php";
	            }
	        }
	    })
	});
	$(".btn-Accept-add").click(function (e){
	    var user_id_add = $(this).attr('user-id-add');
	    var user_friend_add = $(this).attr('user-friend-add');
	    var actions = "accept";
	    //console.log(user_friend_add);
	    $.ajax({
	        url:'ajax_home.php?action=friend',
	        method:'POST',
	        data:{user_id_add:user_id_add,user_friend_add:user_friend_add,actions:actions},
	        success:function(resp){
	            if(resp){
	                //console.log(resp);
	                //location.href = "index.php";
	            }
	        }
	    })
	});
var incoming_msg_id ;
var outgoing_msg_id;
var id_send;
var group_id;
$(document).ready(function(){
    $(function() {
        $("#upload_file").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                var filename = file.name;
                const myArr = filename.split(".");
                var allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(jQuery.inArray(myArr[1], allowed) != -1){
                    $(".img_msg").hide();
                    $(".file_upload").show();
                    $('.file_upload').css("margin-left", "20px");
                    $(".file_upload").text(filename);
                }
            }
            else
            {
                $(".img_msg").show();
                $(".file_upload").hide();
                $('.img_msg').css("margin-left", "20px");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
        $("#upload_file_group").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                var filename = file.name;
                const myArr = filename.split(".");
                var allowed = ['pdf','txt','doc','docx','gif','zar','zip'];
                if(jQuery.inArray(myArr[1], allowed) != -1){ 
                    $(".img_msg_group").hide();
                    $(".file_upload_group").show();
                    $('.file_upload_group').css("margin-left", "20px");
                    $(".file_upload_group").text(filename);
                }
            }
            else
            {
                $(".img_msg_group").show();
                $(".file_upload_group").hide();
                var reader = new FileReader();
                reader.onload = imageIsLoadedGroup;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    function imageIsLoadedGroup(e) {
        $('.img_msg_group').css("display", "block");
        $('.img_msg_group').attr('src', e.target.result);
        $('.img_msg_group').attr('width', '50px');
        $('.img_msg_group').attr('height', '50px');
    };
    function imageIsLoaded(e) {
        $('.img_msg').css("display", "block");
        $('.img_msg').attr('src', e.target.result);
        $('.img_msg').attr('width', '50px');
        $('.img_msg').attr('height', '50px');
    };
	$(".btn_message").click(function (e){
        $(".wrapper-chat").show();
        $("#get_message").html('');
        incoming_msg_id =  $(this).attr('incoming-msg-id');
        outgoing_msg_id = $(this).attr('outgoing-msg-id');
        $("#incoming_msg").val(incoming_msg_id);
        $("#outgoing_msg").val(outgoing_msg_id);
        $(".btn-send-mail").attr('data', $(this).attr('email_out'));
        $(".chat_name").text($(this).attr('outgoing-name'));
	});
	$(".close-msg").click(function (e){
        $(".wrapper-chat").hide();

	});
	$(".btn-create-group").click(function (e){
        $("#create-group").show();

	});
	$(".btn_group").click(function (e){
        $(".wrapper-group").show();
        $("#get_chat_msg").html('');
        group_id =  $(this).attr('group_id');
        id_send = $(this).attr('id_send');
        $(".group_name").text($(this).attr('group-name'));
        $(".group_id").val(group_id);
        $("#id_send").val($(this).attr('id_send'));
        document.getElementById('get_chat_msg').scrollTop = document.getElementById('get_chat_msg').scrollHeight;

	});
	$(".close-group").click(function (e){
        $(".wrapper-group").hide();
	});

	
	// click vào để send chat 
	$(".send_chat").click(function (e){
		console.log("hello")
	    let xhr = new XMLHttpRequest();// tạo sml object
	            xhr.open("POST","ajax_home.php?action=insert_chat",true),
	            xhr.onload = () => {
	                if(xhr.readyState === XMLHttpRequest.DONE){
	                    if(xhr.status === 200){
	                        let data = xhr.response;
	                        //console.log(data);  
						
	                    }
	                }
	            }
	    let formData = new FormData(msg_form);
	    xhr.send(formData);
	    $("#upload_file").val('');
	    $('.img_msg').attr('src', "");
	    $('.img_msg').hide();
		$('.text-message').val('');
	    $(".file_upload").text('');
	    $(".file_upload").hide();

	});

	// click vào để send chat group
	$(".send_chat_group").click(function (e){
	    let xhr = new XMLHttpRequest();// tạo sml object
	            xhr.open("POST","ajax_home.php?action=insert_chat_group",true),
	            xhr.onload = () => {
	                if(xhr.readyState === XMLHttpRequest.DONE){
	                    if(xhr.status === 200){
	                        let data = xhr.response;
	                        //console.log(data);  
	                    }
	                }
	            }
	    let formData = new FormData(group_form);
	    xhr.send(formData);
	    $("#upload_file_group").val('');
	    $('.img_msg_group').attr('src', "");
	    $('.img_msg_group').hide();
		$('.text-message-group').val('');
	    $(".file_upload_group").text('');
	    $(".file_upload_group").hide();
			
	});
	
	//send email
	$(".btn-send-mail").click(function (e){
        $(".wrapper-chat").hide();
        $(".wrapper-email").show();
        $("#email_to").val($(this).attr('data'));
	});
});
// Tạo group
$('#create-group').submit(function(e){
    //$("#create-group").show();
	e.preventDefault();
	$.ajax({
		url:'ajax_home.php?action=create_group',
		method:'POST',
		data:$(this).serialize(),
		success:function(resp){
			console.log(resp);
		}
	})
});
// Thêm thành viên vào group
$(".btn-add-group").click(function (e){
    $(".wrapper-add").show();
    $("#get_form").empty();
    var user_id = $(this).attr('user_id');
    var group_id_mem = $(this).attr('group_id_mem');
    $.ajax({
	url:'ajax_home.php?action=btn-add-group',
	method:'POST',
	data:{user_id:user_id,group_id_mem:group_id_mem},
	success:function(resp){
		if(resp){
            
			//console.log(document.getElementById('get_message'));
            $("#get_form").html(resp);
		}
	}
    })
    
});

// send chat friend
const msg_form = document.querySelector("#msg_form");
msg_form.onsubmit = (e) => {
    e.preventDefault();
}
// khi enter message ;
$('.text-message').on('keypress',function(e){
    if(e.which == 13 && e.shiftKey == false){
        let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax_home.php?action=insert_chat",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                    }
                }
            }
        let formData = new FormData(msg_form);
        xhr.send(formData);
        $("#upload_file").val('');
        $('.img_msg').attr('src', "");
        $('.img_msg').hide();
		$(this).val('');
        $(".file_upload").text('');
        $(".file_upload").hide();
		return false;
    }
});

setInterval(()=>{
    $.ajax({
		url:'ajax_home.php?action=get_chat',
		method:'POST',
		data:{incoming_msg_id:incoming_msg_id,outgoing_msg_id:outgoing_msg_id},
		success:function(resp){
			if(resp){
				//console.log(document.getElementById('get_message'));
                $("#get_message").html(resp);
                document.getElementById('get_message').scrollTop = document.getElementById('get_message').scrollHeight;
			}
		}
	})

},1000);

// send chat group
const group_form = document.querySelector("#msg_group_form");
group_form.onsubmit = (e) => {
    e.preventDefault();
}
// khi enter message group ;
$('.text-message-group').on('keypress',function(e){
    if(e.which == 13 && e.shiftKey == false){
        
        let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax_home.php?action=insert_chat_group",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        //console.log(data);  
                    }
                }
            }
        let formData = new FormData(group_form);
        xhr.send(formData);
        $("#upload_file_group").val('');
        $('.img_msg_group').attr('src', "");
        $('.img_msg_group').hide();
        $(".file_upload_group").hide();
        $(".file_upload_group").text('');
		$(this).val('');
		return false;
    }
});


setInterval(()=>{
    $.ajax({
		url:'ajax_home.php?action=get_chat_group',
		method:'POST',
		data:{id_send:id_send,group_id:group_id},
		success:function(resp){
			if(resp){
				//console.log(document.getElementById('get_chat_msg'));
                //console.log(resp);
                $("#get_chat_msg").html(resp);
                document.getElementById('get_chat_msg').scrollTop = document.getElementById('get_chat_msg').scrollHeight;
			}
		}
	})

},1000);

//send email 
const emailform = document.querySelector("#send_email");
emailform.onsubmit = (e) => {
    e.preventDefault();
}
$(".submit_email").click(function (e){
    $(".wrapper-email").hide();
    let xhr = new XMLHttpRequest();// tạo sml object
            xhr.open("POST","ajax_home.php?action=send-email",true),
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);  
                        if(data=="success"){
                            alert("Email was send.");
                        }
                    }
                }
            }
        let emailformdata = new FormData(emailform);
        xhr.send(emailformdata);
});


</script>