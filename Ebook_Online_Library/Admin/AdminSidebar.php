<!-- Sidebar-->
<div class = "border-end bg-white" id = "sidebar-wrapper"> 
    <div class = "list-group list-group-flush">
        <!--logo-->
        <img class = "list-group-item list-group-item-action list-group-item-light p-1" src = "../img/logo.png" rel = "stylesheet" height = "130px">
        <!--도서 상세 검색 page를 main page로 -->
        <a class = "list-group-item list-group-item-action list-group-item-light p-3" href = "AdminMain.php"> 도서 상세 검색 </a>
        <div class = "list-group-item list-group-item-action list-group-item-light p-3">
            <div class = "dropdown"> 
                <a href = "" style = "color:gray" class = "dropdown-toggle" data-toggle = "dropdown"> 마이 페이지 </a>
                <!--로그인 돼있는 상태에서만 마이페이지 안에 서브 메뉴 확인 가능-->
                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){?>
                    <ul class = "dropdown-menu">
                        <!-- 마이페이지를 누를 경우 대출현황과 예약 현황 페이지를 나타내는 링크 나타내기-->
                        <li><a class = "dropdown-item" href = "AdminRent.php"> 대출 현황 </a></li>
                        <li><a class = "dropdown-item" href = "AdminReserve.php"> 예약 현황 </a></li>
                    </ul>
                <?php }?>

            </div>
        </div>
        <!-- <a class = "list-group-item list-group-item-action list-group-item-light p-3" href = "Main.php"> 도서 대출 기록 </a> -->
        <div class = "list-group-item list-group-item-action list-group-item-light p-3">
            <div class = "dropdown"> 
                <a href = "" style = "color:gray" class = "dropdown-toggle" data-toggle = "dropdown"> 관리 </a>
                <!--로그인 돼있는 상태에서만 마이페이지 안에 서브 메뉴 확인 가능-->
                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){?>
                    <ul class = "dropdown-menu">
                        <!-- 마이페이지를 누를 경우 대출현황과 예약 현황 페이지를 나타내는 링크 나타내기-->
                        <li><a class = "dropdown-item" href = "AdminPreRental.php"> 대출 기록 </a></li>
                        <li><a class = "dropdown-item" href = "AdminPreReserve.php"> 예약 기록 </a></li>
                        <li><a class = "dropdown-item" href = "AdminManage1.php"> 날짜 이전 대출 기록 </a></li>
                        <li><a class = "dropdown-item" href = "AdminManage2.php"> 출판사별, 작가별 도서 </a></li>
                        <li><a class = "dropdown-item" href = "AdminManage3.php"> 인기 대여 순위 </a></li>
                    </ul>
                <?php }?>

            </div>
        </div>
    </div>
</div>