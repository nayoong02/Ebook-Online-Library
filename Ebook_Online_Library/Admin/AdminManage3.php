<?php
include "../login/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "head.php" ?>
        <title> 관리 #3 </title>
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
                    <br>
                    <!-- 반납된 booklist를 나타내는 테이블 -->
                    <table class = "table table-bordered text-center">
                        <thead>
                            <tr>
                                <th> 책 ISBN </th>
                                <th> 도서명 </th>
                                <th> 대출 횟수 </th>
                                <th> 인기 대여 순위 </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // window 함수를 이용한 질의
                            $i = 0;
                            $BookInfo = $conn -> prepare (
                                "SELECT P.ISBN ISBN, TITLE, COUNT(P.ISBN) COUNT,
                                DENSE_RANK() OVER (ORDER BY COUNT(*) DESC) RANK
                                FROM EBOOK E, PREVIOUSRENTAL P
                                WHERE E.ISBN = P.ISBN
                                GROUP BY P.ISBN, E.TITLE"
                             );
                            $BookInfo -> execute();
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <!-- 책 ISBN  -->
                            <td><?= $row['ISBN']?></td>
                            <!-- 대출했던 날짜 -->
                            <td><?= $row['TITLE']?></td>
                            <!-- 도서명-->
                            <td><?= $row['COUNT']?></td>
                            <!-- 저자명 -->
                            <td><?= $row['RANK']?></td>
                        </tr>
                        <!-- row를 탐색하면서 전체 booklist를 출력 -->
                        <?php $i++;} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
