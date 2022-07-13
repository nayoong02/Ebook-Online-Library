<!--https://startbootstrap.com/template/simple-sidebar-->
<?php
include "../login/connection.php";
session_start();
$title = $_GET['title'] ?? '';
$author = $_GET['author'] ?? '';
$publisher = $_GET['publisher'] ?? '';
$year = $_GET['year'] ?? '';
$startdate = $_GET['startdate'] ?? '';
$enddate = $_GET['enddate'] ?? '';
$Tstate = $_GET['TS'] ?? '';
$Astate = $_GET['AS'] ?? '';
$Pstate = $_GET['PS'] ?? '';
$Ystate = $_GET['YS'] ?? '';
$i = 0;
?>
<!DOCTYPE html>
<html lang = "ko">
    <head> 
        <!-- head.php -->
        <?php include "head.php" ?>
        <title> 도서 검색하기 </title>  
    </head>
    <body>
    <div class = "d-flex" id = "wrapper">
        <!-- sidebar.php -->
        <?php include "AdminSidebar.php" ?>
        <!-- Page content wrapper-->
        <div id = "page-content-wrapper">
           <!-- Top navigation-->
           <?php include "TopNavigation.php" ?> 
           <!-- Page content-->
                <div class = "container-fluid">  
                    <!--검색 표(실습자료 참고)-->
                    <form class = "row">
                        <div class = "col-10">
                            <label for = "searchWord" class = "visually-hidden"> Search Word </label>
                            <table class = "type10">
                                <thead>
                                    <tr>
                                        <p><th colspan = "3" span> 상세 검색 </th></p>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope = "row"> 도서명 </th>
                                        <td> <!--도서명 검색 입력칸-->
                                            <input type = "text" class = "form-control" id = "title"
                                            name = "title" placeholder = "검색어 입력" value = "<?= $title ?>">
                                        </td>
                                        <td> 
                                            <p> <select name = "TS">
                                                    <option value = "AND" checked> and </option>
                                                    <option value = "OR" checked> or </option>
                                                    <option value = "AND NOT" checked> not </option>
                                                </select>
                                            </p> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope = "row"> 저자 </th>
                                        <td> <!--저자 검색 입력칸-->
                                            <input type = "text" class = "form-control" id = "author"
                                            name = "author" placeholder = "검색어 입력" value = "<?= $author ?>">
                                        </td>
                                        <td><select name = "AS">
                                                <option value = "AND" checked> and </option>
                                                <option value = "OR" checked> or </option>
                                                <option value = "AND NOT" checked> not </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope = "row"> 출판사 </th>
                                        <td> <!--출판사 검색 입력칸-->
                                            <input type = "text" class = "form-control" id = "publisher"
                                            name = "publisher" placeholder = "검색어 입력" value = "<?= $publisher ?>">
                                        </td>
                                        <td><select name = "PS">
                                                <option value = "AND" checked> and </option>
                                                <option value = "OR" checked> or </option>
                                                <option value = "AND NOT" checked> not </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope = "row"> 발행년도 </th>
                                        <td>  
                                            <!-- <input type = "text" class = "form-control" id = "year"
                                            name = "year" placeholder = "검색어 입력" value = "<?= $year ?>"> -->
                                            <input type = "text" class = "form-text" id = "startdate"
                                            name = "startdate" placeholder = "ex) 21/01/01" value = "<?= $startdate ?>"> 
                                            ~
                                            <input type = "text" class = "form-text" id = "enddate"
                                            name = "enddate" placeholder = "ex) 22/06/06" value = "<?= $enddate ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                        <!-- 검색 버튼 -->
                        <div class = "col-auto text-end ">
                            <br>
                            <button type = "submit" class = "btn btn-primary mb-3" > 검색 </button>
                        </div>
                    </form > 
                    <br>
                    <table class = "table table-bordered text-center">
                        <thead>
                            <tr>
                              <th> 책 ISBN </th>
                              <th> 도서명 </th>
                              <th> 저자 </th>
                              <th> 출판사 </th>
                              <th> 발행년도 </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($title==null && $author==null && $publisher==null && $startdate==null && $enddate==null) 
                            { //처음에 아무것도 검색하지 않았을 때 도서 리스트 전체 출력
                                 $BookQuery = "SELECT E.ISBN, E.TITLE, E.PUBLISHER, E.YEAR, E.EXTTIMES, A.AUTHOR
                                 FROM EBOOK E, AUTHORS A WHERE E.ISBN = A.ISBN 
                                 AND LOWER(TITLE) LIKE '%' || :title || '%' AND
                                 LOWER(AUTHOR) LIKE '%' || :author || '%' AND
                                 LOWER(PUBLISHER) LIKE '%' || :publisher || '%' AND
                                 YEAR LIKE '%' || :startdate || :enddate || '%' ORDER BY TITLE";
                            }
                            
                            else { //하나라도 입력됐을 때 조건에 맞게 출력
                                 $BookQuery  = "SELECT E.ISBN, E.TITLE, E.PUBLISHER, E.YEAR, E.EXTTIMES, A.AUTHOR
                                 FROM EBOOK E, AUTHORS A WHERE E.ISBN = A.ISBN AND
                                 (LOWER(TITLE) LIKE '%' || :title || '%' ".$Tstate.
                                 " LOWER(AUTHOR) LIKE '%' || :author || '%' ".$Astate.
                                 " LOWER(PUBLISHER) LIKE '%' || :publisher || '%' ".$Pstate.
                                 " (YEAR BETWEEN :startdate AND :enddate)) ORDER BY TITLE";
                            }
                            
                            $BookInfo = $conn -> prepare ($BookQuery);
                            $BookInfo -> bindParam(':title', $title);
                            $BookInfo -> bindParam(':author', $author);
                            $BookInfo -> bindParam(':publisher', $publisher);
                            $BookInfo -> bindParam(':startdate', $startdate);
                            $BookInfo -> bindParam(':enddate', $enddate);
                            $BookInfo -> execute();

                            //fetch()를 통해 조회된 데이터를 row에 담음 
                            while ($row = $BookInfo -> fetch(PDO::FETCH_ASSOC) ) {
                                $Extend = $row['EXTTIMES'];
                                $CbookName = $row['TITLE'];
                                $CbookIsbn = $row['ISBN'];
                                $CbookAuthor = $row['AUTHOR'];
                                $CbookPublisher = $row['PUBLISHER'];
                                $CbookYear = $row['YEAR'];
                                
                                if ($Extend == null){ 
                                    $RentState = '대출 가능';
                                } else {
                                    $RentState = '대출 중';
                                }
                            ?>
                                <tr>
                                    <!-- 책 isbn -->
                                    <td> <?= $CbookIsbn ?> </td>
                                    <!-- 책의 제목 누르면 속성 보여지게 url-->
                                    <td><a href = "AdminBookview.php?ISBN=<?=$CbookIsbn?>&RentState=<?= $RentState?>&extend=<?= $Extend?>">
                                    <?=$CbookName?></td>                         
                                    <td> <?php //여러명의 저자일 때 ,로 연결해 출력
                                        if ( $i < $BookInfo -> rowCount() && ($CbookIsbn ==$BookInfo -> fetchAll()[$i + 1]['ISBN'])){
                                            echo $CbookAuthor.",".$BookInfo -> fetchAll()[$i + 1]['AUTHOR'];
                                            $BookInfo -> fetch(PDO::FETCH_ASSOC);
                                            $i++;
                                        } else { echo $CbookAuthor; }?> </td>
                                    <!--출판사-->
                                    <td> <?= $CbookPublisher?> </td> 
                                    <!--발행년도-->
                                    <td> <?= $CbookYear?> </td>
                                </tr>
                                    <!-- row 탐색하며 전체 booklist 출력 -->
                                <?php 
                                    $i++; } ?>
                        </tbody>
                    </table>    
                </div>        
            </div>
        </div>
    </body>
</html>