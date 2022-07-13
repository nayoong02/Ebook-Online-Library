<?php
include "../login/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "head.php" ?>
        <title> 관리 #2 </title>
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
                                <th> 출판사 </th>
                                <th> 저자 </th>
                                <th> 도서 수 </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // 그룹 함수를 이용한 질의
                            $i = 0;
                            $BookInfo = $conn -> prepare(
                                "SELECT DECODE(GROUPING(PUBLISHER), 1, 'All Publishers', PUBLISHER) G1,
                                DECODE(GROUPING(AUTHOR), 1, 'All Authors', AUTHOR) G2,
                                COUNT(*) AS COUNT
                                FROM EBOOK E, AUTHORS A
                                WHERE E.ISBN = A.ISBN 
                                GROUP BY GROUPING SETS(PUBLISHER, AUTHOR)
                                ORDER BY PUBLISHER, AUTHOR"
                             );
                            $BookInfo -> execute();
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <!--GROUPING(PUBLISHER) -->
                            <td><?= $row['G1']?></td>
                            <!-- GROUPING(AUTHOR) -->
                            <td><?= $row['G2']?></td>
                            <!--count-->
                            <td><?= $row['COUNT']?></td>
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
