<!-- 도서별로 예약 목록 보기 -->
<?php
include "../login/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang = "en">
    <head>
        <?php include "head.php" ?>
        <title> 예약 기록 </title>
    </head>
    <body>
        <div class = "d-flex" id = "wrapper">
            <!-- Sidebar-->
            <?php include "AdminSidebar.php" ?>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <?php include "TopNavigation.php" ?>
                <!-- book list -->
                <div class="container-fluid">
                    <h1 class="display-6"> 예약 목록 </h1> <br>
                    <table class = "table table-bordered text-center">
                        <thead>
                            <tr>
                                <th> 책 ISBN </th>
                                <th> 도서명 </th>
                                <th> 예약한 회원 ID </th>
                                <th> 예약한 날짜 </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        //도서별로 예약된 책의 ISBN, 제목, 회원의 CNO, 예약 날짜 출력
                            $i = 0;
                            $BookInfo = $conn -> prepare(
                                "SELECT R.ISBN, E.TITLE, (SELECT R.CNO FROM EBOOK E WHERE E.ISBN = R.ISBN) CNO, R.DATETIME
                                FROM RESERVE R, EBOOK E
                                WHERE E.ISBN = R.ISBN 
                                ORDER BY R.ISBN"
                            );
                            $BookInfo -> execute();
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <!-- 예약한 책 ISBN  -->
                            <td><?= $row['ISBN']?></td>
                            <!-- 예약한 도서명 -->
                            <td><?= $row['TITLE']?></td>
                            <!-- 예약한 회원 CNO -->
                            <td><?= $row['CNO']?></td>
                            <!-- 예약했던 날짜 -->
                            <td><?= $row['DATETIME']?></td>
                        </tr>
                        <!-- row 탐색하며 전체 booklist 출력 -->
                        <?php $i++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
