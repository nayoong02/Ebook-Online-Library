<?php
include "../login/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "head.php" ?>
        <title> 대출 기록</title>
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
                    <!-- 검색어 입력 공간 -->
                    <form class = "row">
                        <div class = "col-10">
                            <input type = "text" class = "form-control" id = "searchWord" 
                            name = "searchWord" placeholder = "검색어 입력" value = "<?= $searchWord ?>">
                        </div>
                        <!-- 검색 버튼 -->
                        <div class = "col-auto text-end">
                            <button type = "submit" class = "btn btn-primary mb-3"> 검색 </button>
                        </div>
                    </form>
                    <!-- 반납된 booklist를 나타내는 테이블 -->
                    <table class = "table table-bordered text-center">
                        <thead>
                            <tr>
                                <th> 책 ISBN </th>
                                <th> 대여 날짜 </th>
                                <th> 반납 날짜 </th>
                                <th> 빌린 회원 ID </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // 반납된 도서를 가져오기 위한 db 접근
                            $i = 0;
                            $BookInfo = $conn -> prepare(
                                "SELECT *
                                FROM PREVIOUSRENTAL
                                WHERE ISBN 
                                LIKE '%' || :searchWord || '%' ORDER BY ISBN"
                            );
                            $BookInfo -> execute(array($searchWord));
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <!-- 책 id  -->
                            <td><?= $row['ISBN']?></td>
                            <!-- 대출했던 날짜 -->
                            <td><?= $row['DATERENTED']?></td>
                            <!-- 반납했던 날짜 -->
                            <td><?= $row['DATERETURNED']?></td>
                            <!-- 대출한 회원 id -->
                            <td><?= $row['CNO']?></td>
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
