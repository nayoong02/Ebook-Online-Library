CREATE TABLE Customer (
    cno NUMBER(3) NOT NULL, 
    name VARCHAR2(10),
    passwd VARCHAR2(15),
    email VARCHAR2(20),
    CONSTRAINT Customer_PK PRIMARY KEY (cno),
    CONSTRAINT Customer_UQ UNIQUE (email),
    CONSTRAINT CHK_cno CHECK (cno >= 0)
);

--10명의 회원정보
INSERT INTO Customer VALUES(110, '김나영', 'skdud123', 'skdud@naver.com');
INSERT INTO Customer VALUES(111, '이주희', 'wngml123', 'wngml@naver.com');
INSERT INTO Customer VALUES(112, '박소현', 'thgus123', 'thgus@gmail.com');
INSERT INTO Customer VALUES(113, '한서영', 'tjdud123', 'tjdud@naver.com');
INSERT INTO Customer VALUES(114, '노수진', 'tnwls123', 'tnwls@daum.net');
INSERT INTO Customer VALUES(115, '안효진', 'gywls123', 'gywls@naver.com');
INSERT INTO Customer VALUES(116, '조현지', 'guswl123', 'guswl@gmail.com');
INSERT INTO Customer VALUES(117, '노채은', 'codms123', 'codms@naver.com');
INSERT INTO Customer VALUES(118, '정유진', 'dbwls123', 'dbwks@daum.net');
INSERT INTO Customer VALUES(119, '김수빈', 'tnqls123', 'tnqls@naver.com');

        
CREATE TABLE Ebook (
    isbn NUMBER(5) NOT NULL,
    title VARCHAR2(20),
    publisher VARCHAR2(20),
    year DATE,
    cno NUMBER(3),
    extTimes NUMBER(1) CHECK (extTimes >=0 AND extTimes <= 2),
    dateRented DATE,
    dateDue DATE,        
    CONSTRAINT Ebook_PK PRIMARY KEY (isbn),
    CONSTRAINT Ebook_FK FOREIGN KEY (cno) REFERENCES Customer(cno)
);
ALTER TABLE EBook MODIFY (title VARCHAR2(100));

--20개의 도서 정보
INSERT INTO EBook VALUES(14225, '작별인사', '복복서가', TO_DATE('2022-05-02','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(71188, '불편한 편의점', '나무옆의자', TO_DATE('2021-04-20','YYYY-MM-DD'), 111, 2, TO_DATE('2022-03-01', 'YYYY-MM-DD'), TO_DATE('2022-03-31','YYYY-MM-DD'));
INSERT INTO EBook VALUES(11685, '흔한남매 10', '미래엔아이', TO_DATE('2022-04-28','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(73610, '컬러애 물들다', '리드리드출판', TO_DATE('2021-05-11','YYYY-MM-DD'), 112, 0, TO_DATE('2022-04-20','YYYY-MM-DD'), TO_DATE('2021-04-30','YYYY-MM-DD'));
INSERT INTO EBook VALUES(91072, '나에게 고맙다', '북로망스', TO_DATE('2022-02-18','YYYY-MM-DD'), 114, 1, TO_DATE('2022-04-10','YYYY-MM-DD'), TO_DATE('2022-04-30','YYYY-MM-DD'));
INSERT INTO EBook VALUES(64243, '이상한 과자 가게 전천당 14', '길벗스쿨', TO_DATE('2022-04-25','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(10584, '면접바이블', '얼라이브북스', TO_DATE('2022-04-12','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(59703, '나의 투자', '리더스북', TO_DATE('2022-04-15','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(47604, '당신의 행복', '하이스트', TO_DATE('2021-11-25','YYYY-MM-DD'), 115, 0, TO_DATE('2022-03-15','YYYY-MM-DD'), TO_DATE('2022-03-25','YYYY-MM-DD'));
INSERT INTO EBook VALUES(47685, '마음의 법칙', '포레스트북스', TO_DATE('2022-02-10','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(59307, '부동산 투자 수업 기초편', '리더스북', TO_DATE('2022-03-22','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(77154, '게으른 뇌에 행동 스위치를 켜라', '밀리언서재', TO_DATE('2022-04-10','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(77158, '긴긴밤', '문학동네', TO_DATE('2021-02-03','YYYY-MM-DD'), 117, 0, TO_DATE('2022-04-01','YYYY-MM-DD'), TO_DATE('2022-04-11','YYYY-MM-DD'));
INSERT INTO EBook VALUES(85887, '제13회 젊은작가상 수상작품집', '문학동네', TO_DATE('2022-04-08','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(62188, '둥실이네 떡집', '비룡소', TO_DATE('2022-04-22','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(20523, '이어령의 마지막 수업', '열림원', TO_DATE('2021-10-28','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(41488, '심리학이 불안에 답하다', '미디어숲', TO_DATE('2022-05-10','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(86665, '저주토끼', '아작', TO_DATE('2022-04-01','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(85825, '여학교의 별 2', '문학동네', TO_DATE('2022-05-05','YYYY-MM-DD'), '', '', '', '');
INSERT INTO EBook VALUES(27156, '물고기는 존재하지 않는다', '곰출판', TO_DATE('2021-12-17','YYYY-MM-DD'), '', '', '', '');


CREATE TABLE Authors (
    isbn NUMBER(5) NOT NULL,
    author VARCHAR(20) NOT NULL,
    CONSTRAINT Authors_PK PRIMARY KEY (isbn, author),
    CONSTRAINT Authors_FK FOREIGN KEY (isbn) REFERENCES Ebook(isbn)
);
ALTER TABLE Authors MODIFY (author VARCHAR2(100));

--20개의 도서 저자 정보
INSERT INTO Authors VALUES(14225, '김영하');
INSERT INTO Authors VALUES(71188, '김호연');
INSERT INTO Authors VALUES(11685, '흔한남매, 백난도');
INSERT INTO Authors VALUES(73610, '밥 햄블리');
INSERT INTO Authors VALUES(91072, '전승환');
INSERT INTO Authors VALUES(64243, '히로시마 레이코');
INSERT INTO Authors VALUES(10584, '면접왕 이형');
INSERT INTO Authors VALUES(59703, '유목민');
INSERT INTO Authors VALUES(47604, '박찬위');
INSERT INTO Authors VALUES(47685, '폴커 키츠, 마누엘 투쉬');
INSERT INTO Authors VALUES(59307, '부읽남');
INSERT INTO Authors VALUES(77154, '오히라 노부타카');
INSERT INTO Authors VALUES(77158, '루리');
INSERT INTO Authors VALUES(85887, '임솔아, 김멜라');
INSERT INTO Authors VALUES(62188, '김리리');
INSERT INTO Authors VALUES(20523, '이어령');
INSERT INTO Authors VALUES(41488, '황양밍, 장린린');
INSERT INTO Authors VALUES(86665, '정보라');
INSERT INTO Authors VALUES(85825, '와야마 야마');
INSERT INTO Authors VALUES(27156, '룰루 밀러');


CREATE TABLE Reserve (
    isbn NUMBER(5) NOT NULL,
    cno NUMBER(3) NOT NULL,
    dateTime DATE,
    CONSTRAINT Reserve_PK PRIMARY KEY (isbn, cno),
    CONSTRAINT Reserve_FK1 FOREIGN KEY (isbn) REFERENCES Ebook(isbn),
    CONSTRAINT Reserve_FK2 FOREIGN KEY (cno) REFERENCES Customer(cno)
);

--특정 2권에 대한 3건씩의 예약 정보
INSERT INTO Reserve VALUES(71188, 110, TO_DATE('2022-03-03','YYYY-MM-DD'));
INSERT INTO Reserve VALUES(71188, 112, TO_DATE('2022-03-10','YYYY-MM-DD'));
INSERT INTO Reserve VALUES(71188, 114, TO_DATE('2022-03-17','YYYY-MM-DD'));
INSERT INTO Reserve VALUES(91072, 117, TO_DATE('2022-04-15','YYYY-MM-DD'));
INSERT INTO Reserve VALUES(91072, 118, TO_DATE('2022-04-20','YYYY-MM-DD'));
INSERT INTO Reserve VALUES(91072, 119, TO_DATE('2022-04-25','YYYY-MM-DD'));


CREATE TABLE PreviousRental (
    isbn NUMBER(5) NOT NULL,
    dateRented DATE NOT NULL,
    dateReturned DATE NOT NULL,
    cno NUMBER(3) NOT NULL,
    CONSTRAINT PrevR_PK PRIMARY KEY (isbn, dateRented),
    CONSTRAINT PrevR_FK1 FOREIGN KEY (isbn) REFERENCES Ebook(isbn),
    CONSTRAINT PrevR_FK2 FOREIGN KEY (cno) REFERENCES Customer(cno)
);

--대출기록 5건 이상
INSERT INTO PreviousRental VALUES(85887, TO_DATE('2022-04-09','YYYY-MM-DD'), TO_DATE('2022-04-15','YYYY-MM-DD'), 114);
INSERT INTO PreviousRental VALUES(85887, TO_DATE('2022-04-20','YYYY-MM-DD'), TO_DATE('2022-04-27','YYYY-MM-DD'), 110);
INSERT INTO PreviousRental VALUES(20523, TO_DATE('2022-02-16','YYYY-MM-DD'), TO_DATE('2022-02-19','YYYY-MM-DD'), 114);
INSERT INTO PreviousRental VALUES(27156, TO_DATE('2022-01-09','YYYY-MM-DD'), TO_DATE('2022-01-15','YYYY-MM-DD'), 116);
INSERT INTO PreviousRental VALUES(11685, TO_DATE('2022-05-01','YYYY-MM-DD'), TO_DATE('2022-05-06','YYYY-MM-DD'), 119);


--JOIN 
SELECT P.isbn 고유번호, P.dateRented 대출날짜, E.title 제목, A.author 작가, E.publisher 출판사
FROM PreviousRental P JOIN Ebook E 
ON P.isbn = E.isbn JOIN Authors A 
ON E.isbn = A.isbn
WHERE EXTRACT(MONTH FROM P.dateRented) < 5
ORDER BY P.dateRented DESC;


--GROUPING FUNCTION
SELECT title,
    CASE GROUPING(PUBLISHER)
        WHEN 1 THEN 'All Publishers'
        ELSE PUBLISHER END AS 출판사,
    CASE GROUPING(author)
        WHEN 1 THEN 'All Authors'
        ELSE author END AS 작가,
    COUNT(*) "도서 권수"
FROM Ebook E, Authors A
WHERE E.isbn = A.isbn 
GROUP BY ROLLUP(publisher, author);


SELECT DECODE(GROUPING(publisher), 1, 'All Publishers', publisher) AS 출판사,
DECODE(GROUPING(author), 1, 'All Authors', author) AS 작가,
COUNT(*) 도서수
FROM Ebook E, Authors A
WHERE E.isbn = A.isbn 
GROUP BY GROUPING SETS(publisher, author)
ORDER BY publisher, author;


--WINDOW FUNCTION
SELECT P.isbn 고유번호, title 제목, COUNT(P.isbn) "대출 횟수",
    DENSE_RANK() OVER (ORDER BY COUNT(*) DESC) "인기 대여 순위"
FROM Ebook E, PreviousRental P
WHERE E.isbn = P.isbn
GROUP BY P.isbn, E.title;


