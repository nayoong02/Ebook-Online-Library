# Ebook-Online-Library

## 🗒️ Summary
- 2022년도 1학기(5학기) 데이터베이스 과목 개인 텀프로젝트
- 가상 온라인 도서관 시스템 구현
- 회원 계정은 웹사이트를 통해 도서관의 Ebook 도서를 검색, 대출, 예약, 반납 기능 이용 가능
- 관리자 계정은 추가적으로 대출/예약 기록, 특정 날짜 이전 대출 기록, 출판사별/저자별 도서 목록, 인기 대여 순위 확인 가능 

## 🛠 Tech
- Oracle DBMS, SQL
- PHP
- IDE VSCode

## 📸 ScreenShots
### 👥 회원

- 로그인 화면
<br><img src="https://user-images.githubusercontent.com/76741411/178690998-61e27bb6-1ffc-428e-9891-8807981b0f0a.png" width="60%">

- 도서 목록
<br><img src="https://user-images.githubusercontent.com/76741411/178691351-c07c119c-6e8e-4909-b946-1cb821c49ef6.png" width="60%">

- 도서 상세 검색
<br><img src="https://user-images.githubusercontent.com/76741411/178691544-5d21368a-f8bd-42e9-9500-624736590b6e.png" width="60%">

- 도서 상세 정보
<br><img src="https://user-images.githubusercontent.com/76741411/178691966-7f0f9073-c523-4b8a-bc4b-8de42804c2ba.png" width="60%">

- 대출 현황
<br><img src="https://user-images.githubusercontent.com/76741411/178692203-0080cb98-c4c3-49c0-a092-40141b34b5c3.png" width="60%">

- 예약 현황 
<br><img src="https://user-images.githubusercontent.com/76741411/178692384-878ec53f-5a2f-4ac9-b5c4-c572fddb8d4e.png" width="60%">


### 🔑 관리자
- 관리자 메뉴
<br><img src="https://user-images.githubusercontent.com/76741411/178688937-1f585a35-e1f3-4a38-a5f8-c2068329413a.png" width="20%">

- 대출 기록
<br><img src="https://user-images.githubusercontent.com/76741411/178689163-34e67209-2edd-4313-858a-77746a54b6f5.png" width="60%">

- 예약 기록
<br><img src="https://user-images.githubusercontent.com/76741411/178689316-40738616-a510-490d-ad1d-405c41c4c706.png" width="60%">

- 날짜 이전 대출 기록
<br><img src="https://user-images.githubusercontent.com/76741411/178689420-a96e9878-ec01-4126-89ec-53c4e44d0574.png" width="60%">

- 출판사별, 저자별 도서 목록
<br><img src="https://user-images.githubusercontent.com/76741411/178689530-593253f2-7004-4ea7-9749-00e5166d25cd.png" width="60%">

- 인기 대여 순위
<br><img src="https://user-images.githubusercontent.com/76741411/178689665-6f94d46c-1ae4-47c4-8f6d-16b25fe09265.png" width="60%">


## 📌 Memo
- 예약 대기자들에게 메일 발송 구현 X, 보내진 전제 하에 알림창으로 메시지만 표시
- 상세 검색 시 버튼이 and, or, not으로 바뀌지 않음
