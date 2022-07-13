<?php
    session_start(); //세션 불러온 후 
    session_destroy(); //정보 완전히 삭제 후 Main page로 돌아감
    echo "<script>alert('로그아웃 되었습니다.')</script>";
?>
<meta http-equiv="refresh" content="0;url=../Main.php" />