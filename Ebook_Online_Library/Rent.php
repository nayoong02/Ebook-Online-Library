<?php
include "login/connection.php";
session_start(); 
// 대출 counting
$user_id = $_SESSION['user_id'];
$RentQuery =
    "SELECT * FROM Ebook
    WHERE CNO LIKE '%' || :searchWord || '%' ORDER BY CNO";
$RentInfo = $conn -> prepare($RentQuery);
$RentInfo -> execute(array($searchWord));
$count = 0;
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php include "sub/head.php" ?>
        <title> 도서 대출 목록 </title>
    </head>
    <body>
        <div class = "d-flex" id = "wrapper">
            <!-- Sidebar-->
            <?php include "sub/sidebar.php" ?>
            <!-- Page content wrapper-->
            <div id = "page-content-wrapper">
                <!-- Top navigation-->
                <?php include "sub/TopNavigation.php" ?>
                <br>
                <div class="container-fluid">
                    <table class="table table-bordered text-center">
                        
                        <tbody>
                            <!-- 마이페이지의 사용자 정보 -->
                            <tr>
                                <th> 이름 </th>
                                <td><?= $uname?></td>
                            </tr>
                            <tr>
                                <th> 대출 권수 </th>
                                <td>
                                    <!-- 대출 권수를 위한 DB연동 -->
                                    <?php
                                while($row = $RentInfo -> fetch(PDO::FETCH_ASSOC)){
                                    if ($user_id == $row['CNO'])
                                        $count++;
                                } 
                                echo $count
                                ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br> <br>
                    <table class = "table table-bordered text-center">
                        <!-- 대출한 책의 세부사항 -->
                        <thead>
                            <tr>
                                <th> 번호 </th>
                                <th> 도서 상세정보 </th>
                                <th> 대출 일자 </th>
                                <th> 반납 일자 </th>
                                <th> 연장 횟수 </th>
                                <th> 연장 여부 </th>
                                <th> 반납 여부 </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($count > 0){
                                // 대출 도서 정보를 위한 데이터 연동
                                $RentInfo -> execute(array($searchWord));
                                while ($row = $RentInfo -> fetch(PDO::FETCH_ASSOC)){
                                    if ($user_id == $row['CNO']){
                                        $bookIsbn = $row['ISBN'];
                                        $bookName = $row['TITLE'];
                                        $RentState = "대출 중";
                                        $Extend = $row['EXTTIMES'];
                            ?>
                                <tr>
                                    <!-- 저장한 변수를 이용하여 나타냄 -->
                                    <td><?=$i?></td>
                                    <td><?= $bookName." / ".$row['PUBLISHER']." / ".$row['YEAR']?></td>
                                    <td><?= $row['DATERENTED']?></td>
                                    <td><?= $row['DATEDUE']?></td>
                                    <td><?= $Extend?></td>
                                    <!-- 연장 버튼 -->
                                    <script>
                                    function show() {
                                        
                                    }
                                    </script>
                                    <!-- 연장 -->
                                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" 
                                    data-bs-target="#ExtendConfirmModal" onclick="show();"> 연장 </button>
                                    <?php
                                    $_POST['button'] = "ExtendConfirmModal";
                                    $_POST['option'] = "Extend";
                                    include "modal.php";
                                    ?>
                                    </td>
                                    <!-- 반납 버튼 -->
                                    <td><button type = "button" class = "btn btn-primary" data-bs-toggle = "modal" 
                                    data-bs-target = "#ReturnConfirmModal"> 반납 </button>
                                    <?php
                                    $_POST['button'] = "ReturnConfirmModal";
                                    $_POST['option'] = "Return";
                                    include "modal.php";
                                    ?>
                                    </td>
                                </tr>
                                <?php $i++;}}} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>