<?php
include "../login/connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "head.php" ?>
        <title> 관리 #1 </title>
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
                            <!-- 검색어 날짜(월) 입력 -->
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
                                <th> 도서명 </th>
                                <th> 저자 </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // join을 이용한 질의
                            $i = 0;
                            $BookInfo = $conn -> prepare(
                                "SELECT P.ISBN, P.DATERENTED, E.TITLE, A.AUTHOR, E.PUBLISHER
                                FROM PREVIOUSRENTAL P JOIN EBOOK E 
                                ON P.ISBN = E.ISBN JOIN AUTHORS A 
                                ON E.ISBN = A.ISBN
                                WHERE EXTRACT(MONTH FROM P.DATERENTED) < :searchword
                                ORDER BY P.DATERENTED DESC"
                             );
                            $BookInfo -> execute(array($searchWord));
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <!-- 책 ISBN  -->
                            <td><?= $row['ISBN']?></td>
                            <!-- 대출했던 날짜 -->
                            <td><?= $row['DATERENTED']?></td>
                            <!-- 도서명-->
                            <td><?= $row['TITLE']?></td>
                            <!-- 저자명 -->
                            <td><?= $row['AUTHOR']?></td>
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
