<!-- 오라클 접속해 DB 연동  -->
<?php
    $tns = "(DESCRIPTION= (ADDRESS_LIST = (ADDRESS=(PROTOCOL=TCP) 
            (HOST=LOCALHOST)(PORT=1521)))
            (CONNECT_DATA= (SERVICE_NAME=XE)) )";
    $dsn = "oci:dbname=".$tns.";charset=utf8";
    $username = 'd202002463'; $password = '1234';
    $searchWord = $_GET['searchWord'] ?? '';
    try { //PDO 객체를 활용해 DB 접속
        $conn = new PDO($dsn, $username, $password); 
    } catch (PDOException $e){
        echo("에러 내용: ".$e -> getMessage());
    }
    
    //자주 쓰이는 변수 미리 정의
    $bookName = '';
    $author = '';
    $publisher = '';
    $year = '';
    $RentState = '';
?>