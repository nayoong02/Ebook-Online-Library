<!-- login.php에서 ID와 PW 입력 후 login_ok.php에서 처리 -->
<!-- http://parkjuwan.dothome.co.kr/wordpress/2017/07/11/php-session-login/ -->
<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <meta charset = "utf-8" />
        <title> E-Book Online Library </title>
        <link rel = "stylesheet" href = "../css/bootstrap.css">
        <script src = "https://code.jquery.com/jquery-3.5.1.min.js" type = "text/javascript"></script>
        <img src = "../img/logo.png" rel = "stylesheet" 
        style = "margin-left: auto; display: block;" width = "650px" height = "400px" alt = "Logo">
    </head>
    <link href = "../css/login.css" rel = "stylesheet">
    <body class = "text-center" >
        <main class = "form-signin">
            <h1 class = "h3 mb-3 fw-normal"> Please Log In </h1>
            <!--ID와 PW를 입력하지 않았을 때(!isset())-->
            <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
                <!--ID와 PW를 입력하면 login_ok.php에서 post로 보내서 처리-->
            <form method = "post" action = "login_ok.php">
                <!-- CNO 입력칸 -->
                <input type = "text" name = "user_id" class = "form-control" placeholder = "CNO" required autofocus> </p>
                <!-- PWD 입력칸 -->
                <input type = "password" name = "user_pw" class = "form-control" placeholder = "Password" required></p>
                <!-- 로그인 버튼 -->
                <input class = "w-100 btn btn-lg btn-primary" type = "submit" value = "Sign in" />
            </form>
            <?php } else { //Main page로 이동
                //user_id, user_name Session에 저장 
                $user_id = $_SESSION['user_id']; 
                $user_name = $_SESSION['user_name'];
                //만약 login된 상태에서 다시 login page로 간다면 Main page로 돌아가기 또는 logout
                echo "<p> <strong> $user_name </strong> 님은 이미 로그인 되어있습니다.</p>";
                echo "<p> <a href = \"../Main.php\"> [돌아가기] </a> ";
                echo "<a href = \"logout.php\"> [로그아웃] </a></p>";
            } ?>
        </main>
    </body>        
</html>