<?php
session_start();

include "../login/connection.php";
include "head.php";
$bookIsbn = $_GET['isbn'] ?? '';
$todayDate = date("Y/m/d");
$state = $_GET['state'] ?? '';
$Extend = $_GET['extend'] ?? '';

switch($_GET['mode']){
    case 'Reserve':
        // 예약을 위해 회원의 예약 상태를 위해 reserve 테이블 접근
            $reserveQuery = 
            "SELECT * FROM RESERVE WHERE CNO
            LIKE '%' || :searchWord || '%' ORDER BY CNO";
            $reserveInfo = $conn -> prepare($reserveQuery);
            $reserveInfo -> execute(array($searchWord));
            $count=0;
            // reserve 테이블에서 회원 id와 일치하는 책에 대한 카운팅
                while($row = $reserveInfo -> fetch(PDO::FETCH_ASSOC)){
            if ($_SESSION['user_id']== $row['CNO']){
                $count++;
            }
        }
        // 예약 가능한 도서의 최대 개수를 넘은 경우
        if ($count > 2){
            echo "<script>alert('예약가능한 도서는 최대 3권 입니다.');";
        } else{
            // 쿼리문을 이용하여 reserve 테이블에 insert
            $ReserveQuery = "INSERT INTO RESERVE (ISBN,CNO,DATETIME)
            VALUES (:bookIsbn, :cno, :todayDate)";
            $ReserveInsert = $conn -> prepare($ReserveQuery);
            $ReserveInsert -> bindParam(':bookIsbn',$bookIsbn);
            $ReserveInsert -> bindParam(':cno',$_SESSION['user_id']);
            $ReserveInsert -> bindParam(':todayDate', $todayDate);
            try{
                $ReserveInsert -> execute();
            } catch (PDOException $e){  // 이미 예약한 경우 FK 충돌
                echo "<script>alert('이미 예약되어있습니다.');";
                echo "window.location.replace('AdminMain.php');</script>";
            }
            echo "<script>alert('예약이 완료되었습니다.');";
        }
        echo "window.location.replace('AdminReserve.php');</script>";
        break;
    case 'Rent':
        // 회원의 대출 권수에 대한 카운팅을 위한 Ebook 테이블 접근
        $RentQuery =
        "SELECT * FROM Ebook
        WHERE CNO LIKE '%' || :searchWord || '%' ORDER BY CNO";
        $RentInfo = $conn -> prepare($RentQuery);
        $RentInfo -> execute(array($searchWord));
        $count = 0;
        // 회원 id와 일치하는 책들을 counting
        while($row = $RentInfo -> fetch(PDO::FETCH_ASSOC)){
            if ($_SESSION['user_id'] == $row['CNO'])
                $count++;
        }
        // 대출중인 책의 경우
        if ($state == "대출 중"){
             ?>
            <script>
                // 대출중이라는 알림과 함께 예약 여부를 묻고, 예약할 경우 process.php를 호출
                if(confirm('이미 대출중인 도서입니다. 예약하시겠습니까?')) {
                    window.location.replace('process.php?mode=Reserve&isbn=<?=$bookIsbn?>&state=<?= $RentState?>&extend=<?= $Extend?>');
                }
                else{
                    window.location.replace('AdminMain.php');
                }
            </script>
            <?php
        // 대출중인 책의 권수가 3권 이상인 경우
        } else if ($count > 2){
            echo "<script>alert('대출가능한 도서는 최대 3권 입니다.');";
            echo "window.location.replace('AdminMain.php');</script>";
        } else {
            // ebook에 책에 대한 업데이트를 통해 책을 대출
            $RentQuery =
                "UPDATE EBOOK SET CNO = :cno, EXTTIMES = 0,
                DATERENTED = :extend, DATEDUE = :due WHERE ISBN = :isbn";
            $RentInsert = $conn -> prepare($RentQuery);
            $RentInsert -> bindParam(':cno', $_SESSION['user_id']);
            $RentInsert -> bindParam(':extend',$todayDate);
            $dueDate = date("Y/m/d",strtotime($todayDate.'+10 days'));
            $RentInsert -> bindParam(':due',$dueDate);
            $RentInsert -> bindParam(':isbn', $bookIsbn);
            try{
                $RentInsert -> execute();
            } catch (PDOException $e){  
                echo "<script>alert('잘못된 접근입니다.');";
                echo "window.location.replace('AdminMain.php');</script>";
            }
            echo "<script>alert('대출이 완료되었습니다.');";
            echo "window.location.replace('AdminRent.php');</script>";
        }
        break;
        
    case 'ReserveCancel':
        // 쿼리문을 사용하여 유저 id와 책 id에 해당하는 데이터를 삭제
        $ReserveCancelQuery =
        "DELETE FROM RESERVE
        WHERE CNO = :cno and ISBN = :isbn";
        $ReserveCancel = $conn -> prepare($ReserveCancelQuery);
        $ReserveCancel -> bindParam(':cno', $_SESSION['user_id']);
        $ReserveCancel -> bindParam(':isbn',$bookIsbn);
        $ReserveCancel -> execute();
        echo "<script>alert('예약 취소가 완료되었습니다.');";
        echo "window.location.replace('AdminReserve.php');</script>";
        break;

    case 'Extend':
        // 연장 횟수가 2회 이상인 경우
        if ($Extend > 1){
            echo "<script>alert('연장 횟수는 최대 2회 입니다.');";
            echo "window.location.replace('AdminMain.php');</script>";
        }
        // 쿼리문을 사용하여 datedue의 기간을 10일 연장
        else{
            $checkReQ = 
            "SELECT CNO
            FROM RESERVE
            WHERE CNO = :cno";
            $checkRe = $conn -> prepare($checkReQ);
            $checkRe -> bindParam(':cno', $_SESSION['user_id']);
            $checkRe -> execute();
            if ($checkRe -> fetch(PDO::FETCH_ASSOC)){
                echo "<script>alert('예약된 사람이 있어 연장이 불가능합니다.');";
                echo "window.location.replace('AdminMain.php');</script>";
                break;
            }
            $ExtendQuery =
                "UPDATE EBOOK SET EXTTIMES = :extend, DATEDUE = DATEDUE + (INTERVAL '10' DAY)
                WHERE CNO = :cno and ISBN = :isbn" ;
            $Extend++;
            $ExtendInsert = $conn -> prepare($ExtendQuery);
            $ExtendInsert -> bindParam(':extend', $Extend);
            $ExtendInsert -> bindParam(':cno', $_SESSION['user_id']);
            $ExtendInsert -> bindParam(':isbn', $bookIsbn);
            $ExtendInsert -> execute();
            echo "<script>alert('대출 연장이 완료되었습니다.');";
            echo "window.location.replace('AdminMain.php');</script>";
        }
        break;

    case 'Return':
        // 해당 책 id와 유저 id와 일치하는 정보들을 가져오기 위해 ebook에 접근
        $returnInsertPRQuery =
            "SELECT ISBN, DATERENTED, DATEDUE, CNO
            FROM EBOOK
            WHERE CNO = :cno and ISBN = :isbn";
        $returnInsertPR = $conn -> prepare($returnInsertPRQuery);
        $returnInsertPR -> bindParam(':cno', $_SESSION['user_id']);
        $returnInsertPR -> bindParam(':isbn', $bookIsbn);
        $returnInsertPR -> execute();

        // PreviousRental table에 넣기 위한 query
        $InsertPRQuery = 
            "INSERT INTO PREVIOUSRENTAL (ISBN, DATERENTED, DATERETURNED,CNO)
            VALUES (:isbn, :rented, :returned, :cno)";
        $InsertPR = $conn -> prepare($InsertPRQuery);
        if ($row = $returnInsertPR -> fetch(PDO::FETCH_ASSOC)){
            $InsertPR -> bindParam(':isbn', $row['ISBN']);
            $InsertPR -> bindParam(':rented', $row['DATERENTED']);
            $InsertPR -> bindParam(':returned', $todayDate);
            $InsertPR -> bindParam(':cno', $row['CNO']);
            $InsertPR -> execute();
        }
        // 반납하였기 때문에 쿼리문을 사용하여 ebook을 업데이트
        $returnQuery = 
        "UPDATE EBOOK SET CNO = null, EXTTIMES = null,
        DATERENTED = null, DATEDUE = null
        WHERE CNO = :cno and ISBN = :isbn";
        $return = $conn -> prepare($returnQuery);
        $return -> bindParam(':cno', $_SESSION['user_id']);
        $return -> bindParam(':isbn', $bookIsbn);
        $return -> execute();
        
        // 예약한 사람을 찾기 위해 reserve 테이블 접근
        $searchQ = 
        "SELECT count(isbn) RC
        FROM reserve
        WHERE isbn = :isbn
        group by isbn";
        $stmt = $conn -> prepare($searchQ);
        $stmt -> execute(array($bookIsbn));
        $countRP='';
        // 예약한 사람이 있을 경우 count
        if ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
            $countRP = $row['RC'];
        }
        if ($countRP){
            echo "<script>window.location.replace('process.php?mode=mail&isbn=$bookIsbn&count=$countRP');</script>";
        } else{
            echo "<script>alert('반납되었습니다.');";
            echo "window.location.replace('AdminRent.php');</script>";
        }
        break;

    case 'mail'://실제 메일링은 구현 x
        //  반납한 책이 누군가에게 예약 되어있는 경우에만 여기로 진입하게됨
        $ISBN = $_GET['isbn'];

        //  누가 예약했는지의 정보를 얻기 위해 reserve 테이블 접근
        $searchQ = 'SELECT CNO
                    FROM RESERVE
                    WHERE ISBN = :isbn
                    ORDER BY DATETIME ASC';
        $stmt = $conn->prepare($searchQ);
        $stmt->bindParam(':isbn', $bookIsbn);
        $stmt->execute();
        $reservedPerson = '';
        // 예약 날짜가 가장 오래된 사람을 fetch
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {    
            $reservedPerson = $row['CNO'];
        }

            //알린 후에 해당 예약 삭제처리
            $searchQuery = 'DELETE FROM RESERVE 
            WHERE ISBN = :isbn AND CNO = :cno';
            $stmt = $conn->prepare($searchQuery);
            $stmt->bindParam(':isbn', $bookIsbn);
            $stmt->bindParam(':cno', $reservedPerson);
            $stmt->execute();

            echo "<script>alert('도서가 반납되었으며 예약대기자에게 메일 전송이 완료되었습니다.');";
            echo "window.location.replace('AdminMain.php');</script>";

        break;
}
?>
