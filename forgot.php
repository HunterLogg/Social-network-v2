<?php include 'header.php' ;
if(isset($_GET['forgot'])){
    $forgot = $_GET['forgot'];
}
?>
<body class="bg-light">
<div class="position-absolute top-50 start-50 translate-middle border shadow" style="width: 50%; padding: 20px; background-color: #fff;">
    <?php 
    if($forgot == "find"){
        echo '<form action="" method="POST" class="forgot">
        <h3>Tìm tài khoản của bạn</h3>
        <hr>
        <h4>Vui lòng nhập email hoặc số điện thoại di động để tìm kiếm tài khoản của bạn.</h4>
        <input type="text" name="forgot_email" id="forgot_email" class="form-control">
        <span class="error-forgot text-danger"></span>
        <hr>
        <div class="float-right">
        <a href="index.php" class="btn btn-light">Hủy</a>
        <button class="btn btn-primary btn-find">Tìm Kiếm</button>
        </div>
    </form><script>const forgot = document.querySelector(".forgot");
    forgot.onsubmit = (e) => {
        e.preventDefault();
    }
    // forgot password
    // find user
    $(".btn-find").click(function (e){
        let xhr = new XMLHttpRequest();// tạo sml object
                xhr.open("POST","ajax_home.php?action=forgot&type=check",true),
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);  
                            if(data == "success"){
                                location.href = "forgot.php?forgot=check_code";
                            }
                            else {
                                $(".error-forgot").text(data);
                                $("#forgot_email").addClass("is-invalid");
                            }
                        }
                    }
                }
        let formData = new FormData(forgot);
        xhr.send(formData);
    });</script>';
    }else if($forgot == "check_code"){
        echo '<form action="" method="POST" class="confirm-code">
        <h3>Xác thực mã</h3>
        <hr>
        <h4>Vui lòng nhập mã được gửi qua email của bạn.</h4>
        <input type="text" name="code" id="code" class="form-control">
        <span class="error-forgot text-danger"></span>
        <hr>
        <div class="float-right">
        <button class="btn btn-primary btn-confirm">Xác thực</button>
        </div>
    </form><script>// Check code
    const confirm_code = document.querySelector(".confirm-code");
    console.log(confirm_code)
    confirm_code.onsubmit = (e) => {
        e.preventDefault();
    }
    $(".btn-confirm").click(function (e){
        
        let xhr = new XMLHttpRequest();// tạo sml object
                xhr.open("POST","ajax_home.php?action=forgot&type=confirm",true),
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);  
                            if(data == "success"){
                                location.href = "forgot.php?forgot=change_pass";
                            }
                            else {
                                $(".error-forgot").text(data);
                                $("#code").addClass("is-invalid");
                            }
                        }
                    }
                }
        let formData = new FormData(confirm_code);
        xhr.send(formData);
    });</script>';
    }else if($forgot == "change_pass"){
        echo '<form action="" method="POST" class="change-pass">
        <h3>Thay đổi password</h3>
        <hr>
        <h4>Vui lòng nhập mật khẩu và xác thực mật khẩu.</h4>
        <div class="form-group">
            <span>Vui lòng nhập mật khẩu mới.</span>
            <input type="password" name="password" id="change-password" class="form-control col mx-1" placeholder="Password">
        </div>
        <div class="form-group">
            <span>Vui lòng xác thực mật khẩu mới.</span>
            <input type="password" name="c-password" id="confirm-password" class="form-control col mx-1" placeholder="Confirm-Password">
        </div>
        <span class="error-forgot text-danger"></span>
        <hr>
        <div class="float-right">
        <button class="btn btn-success btn-change">Confirm</button>
        </div>
        </form>
        <script>
    // change pass
    const changepass = document.querySelector(".change-pass");
    changepass.onsubmit = (e) => {
        e.preventDefault();
    }
    $(".btn-change").click(function (e){
        let xhr = new XMLHttpRequest();// tạo sml object
                xhr.open("POST","ajax_home.php?action=forgot&type=change_pass",true),
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);  
                            if(data == "success"){
                                location.href = "index.php";
                            }
                            else {
                                $(".error-forgot").text(data);
                                $("#code").addClass("is-invalid");
                            }
                        }
                    }
                }
        let formData = new FormData(changepass);
        xhr.send(formData);
    });
    </script>';
    }
    ?>
    
</div>

</body>