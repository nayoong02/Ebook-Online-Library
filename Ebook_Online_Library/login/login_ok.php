<?php
    include "connection.php";
    // user의 id와 pw를 비교
    $UserInfo = $conn -> prepare(
        "SELECT CNO, NAME, PASSWD, EMAIL
        FROM CUSTOMER
        WHERE CNO
        LIKE '%' || :searchWord || '%' ORDER BY CNO"
    );
    $UserInfo -> execute(array($searchWord));

    // id와 pw가 전달되지 않은 상태에서 접근한 경우
    if (!isset($_POST['user_id']) || !isset($_POST['user_pw']) ) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 빠졌거나 잘못된 접근입니다.');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }

    //post 데이터를 변수에 저장
    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];

    // 연동한 DB의 CNO와 password를 비교
    while($userRow = $UserInfo -> fetch(PDO::FETCH_ASSOC)){
        //만약 CNO가 user_id와 같고 PASSWD가 user_pw와 일치한다면 성공이므로 세션 시작
        if( $userRow['CNO'] == $user_id && $userRow['PASSWD'] == $user_pw ) {
            session_start();
            // 세션에 cno와 이름을 저장
            $_SESSION['user_id'] = $user_id;
            $username = $_SESSION['user_name'] = $userRow['NAME'];
            if ($_SESSION['user_id'] == 110){ //CNO가 110인 사람을 관리자로 설정
                //관리자 환영 인사 메시지 표시 후 AdminMain page로 이동
                echo "<script>alert('관리자 $username 님 반갑습니다!');</script>";
                ?> <meta http-equiv = "refresh" content = "0; url=../Admin/AdminMain.php" /> <?php
            } else {
                //일반 회원 환영 인사 메시지 표시 후 Main page로 이동
                echo "<script>alert('$username 님 반갑습니다!');</script>";
                ?><meta http-equiv = "refresh" content = "0; url=../Main.php" /> <?php
            }
            break;
        }
    }
    // CNO와 passwd가 일치하지 않는 경우 false로 처리
    if ($userRow == false){
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }
?>
