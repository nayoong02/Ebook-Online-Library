<?php
include "../login/connection.php";
session_start();
// 예약 횟수 count를 위한 데이터 연동
$user_id = $_SESSION['user_id'];
$count=0;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "head.php" ?>
        <title> E-book Library </title>
    </head>
    <body>
        <div class = "d-flex" id = "wrapper">
            <!-- Sidebar-->
            <?php include "AdminSidebar.php" ?>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <?php include "TopNavigation.php" ?>
                <br>
                <div class="container-fluid">
                    <table class="table table-bordered text-center">
                        <!-- 마이 페이지에서 유저 정보 테이블 -->
                        <tbody>
                            <tr>
                                <th> 이름 </th>
                                <td><?= $uname?></td>
                            </tr>
                            <tr>
                                <th> 예약 권수 </th>
                                <td>
                                <!-- 예약 권수를 나타내기 위한 DB 연동 -->
                                <?php
                                $reserveQuery = 
                                "SELECT * FROM RESERVE WHERE CNO
                                LIKE '%' || :searchWord || '%' ORDER BY CNO";
                                $reserveInfo = $conn -> prepare($reserveQuery);
                                $reserveInfo -> execute(array($searchWord));
                                while($row = $reserveInfo -> fetch(PDO::FETCH_ASSOC)){
                                    if ($user_id == $row['CNO']){
                                        $count++;
                                    }
                                }
                                 echo $count
                                ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br> <br>
                    <table class="table table-bordered text-center">
                        <!-- 책 세부사항 -->
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>책 세부사항</th>
                                <th>예약 취소</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=0;
                            if ($count >0){
                                // 예약 book 정보를 위한 데이터 연동
                                $findBookInfoQ =
                                "SELECT TITLE,PUBLISHER,YEAR,EXTTIMES,e.ISBN FROM RESERVE r, EBOOK e 
                                WHERE r.ISBN = e.ISBN and r.CNO = $user_id
                                and LOWER(TITLE) LIKE '%' || :searchWord || '%' ORDER BY TITLE";
                                $findBookInfo = $conn -> prepare($findBookInfoQ);
                                $findBookInfo -> execute(array($searchWord));
                                // extend가 null 인 경우 대출하지 않은 책
                                while ($row = $findBookInfo -> fetch(PDO::FETCH_ASSOC)){
                                    $Extend = $row['EXTTIMES'];
                                    if ($Extend == null){
                                        $RentState = '대출 가능';
                                    }else{
                                        $RentState = '대출 중';
                                    }
                            ?>
                                <tr>
                                    <!-- 예약한 책을 나타내는 테이블 -->
                                    <td><?=$i?></td>
                                    <td><a href = "AdminBookview.php?ISBN=<?=$row['ISBN']?>&RentState=<?= $RentState?>">
                                    <?= $row['TITLE']." / ".$row['PUBLISHER']." / ".$row['YEAR']?></td>
                                    <td>
                                        <!-- 예약 취소 버튼 -->
                                        <button type = "button" class = "btn btn-primary" data-bs-toggle = "modal" data-bs-target="#ReserveCancelConfirmModal">예약 취소</button>
                                        <?php
                                        $bookIsbn = $row['ISBN'];
                                        $bookName = $row['TITLE'];
                                        $_POST['button'] = "ReserveCancelConfirmModal";
                                        $_POST['option'] = "ReserveCancel";
                                        include "Amodal.php";
                                        ?>
                                    </td>
                                    <?php $i++;}} ?>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
                        
                    