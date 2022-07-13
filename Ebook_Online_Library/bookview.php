<?php
include "login/connection.php";
$bookIsbn = $_GET['ISBN'];
$RentState = $_GET['RentState'];
$Extend = $_GET['extend'];
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "sub/head.php" ?>
        <title> 도서 상세정보 </title>
    </head>
    <body>
        <div class = "d-flex" id = "wrapper">
            <!-- Sidebar-->
            <?php include "sub/sidebar.php" ?>
            <!-- Page content wrapper-->
            <div id = "page-content-wrapper">
                <!-- Top navigation-->
                <?php
                include "sub/TopNavigation.php";
                // 선택된 책의 isbn에 대해서 상세정보를 가져오기 위한 DB 접근
                $BookInfoView = $conn -> prepare(
                    "SELECT *
                    FROM EBOOK
                    WHERE ISBN = ?");
                $BookInfoView -> execute(array($bookIsbn));
                // DB에서 가져온 도서명, 출판사, 발행년도를 변수에 저장
                if ($row = $BookInfoView -> fetch(PDO::FETCH_ASSOC)){
                    $bookName = $row['TITLE'];
                    $publisher = $row['PUBLISHER'];
                    $year = $row['YEAR'];
                ?>
                <div class = "container-fluid">
                    <h2 class = "display-6"> 도서 상세 정보 </h2>
                    <table class = "table table-bordered text-center">
                        <!-- 책 정보를 나타내는 테이블 -->
                        <tbody>
                            <tr>
                                <th> 도서명 </th>
                                <td><?= $bookName ?></td>
                            </tr>
                            <tr>
                                <th> 책 ISBN </th>
                                <td><?= $bookIsbn ?></td>
                            </tr>
                            <tr>
                                <th> 저자 </th>
                                <td><?php
                                // 여러명의 저자를 나태내기 위해 DB 접근
                                    $AuthorInfo = $conn -> prepare(
                                        "SELECT AUTHOR
                                        FROM AUTHORS A
                                        WHERE A.ISBN = ?");
                                    $AuthorInfo -> execute(array($bookIsbn));
                                    if ($row = $AuthorInfo -> fetch(PDO::FETCH_ASSOC))
                                        echo($row['AUTHOR']);
                                    while ($row = $AuthorInfo -> fetch(PDO::FETCH_ASSOC)){
                                        echo(", ");
                                        echo($row['AUTHOR']);
                                    }
                                ?></td>
                            </tr>
                            <tr>
                                <th> 출판사 </th>
                                <td><?= $publisher ?></td>
                            </tr>            
                            <tr>
                                <th> 발행년도 </th>
                                <td><?= $year ?></td>
                            </tr>
                            <tr>
                                <th> 대출 상태 </th>
                                <td><?= $RentState?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
        <div>
            <div class = "d-grid gap-2 d-md-flex justify-content-md-end mr-3 m-3" >
                <!-- 목록으로 돌아가는 링크 -->
                <a href = "Main.php" class = "btn btn-success"> 목록 </a>
                <!-- 대출을 위한 버튼 -->
                <button type = "button" class = "btn btn-primary" data-bs-toggle="modal" 
                data-bs-target = "#RentConfirmModal"> 대출 </button>
                <!-- 예약을 위한 버튼 -->
                <button type = "button" class = "btn btn-warning" data-bs-toggle="modal" 
                data-bs-target = "#ReserveConfirmModal"> 예약 </button>
            </div>
        </div>
        <?php
        // 버튼을 누를 경우 대출할것인지 묻는 알람
        $_POST['button'] = "RentConfirmModal";
        $_POST['option'] = "Rent";
        include "modal.php";
        // 버튼을 누를 경우 예약할것인지 묻는 알람
        $_POST['button'] = "ReserveConfirmModal";
        $_POST['option'] = "Reserve";
        include "modal.php";
        ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-
    gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>
