CREATE TABLE userBase
(
  userid int NOT NULL PRIMARY KEY,
  username varchar2(255) NOT NULL,
  first_name varchar2(255) NOT NULL,
  last_name varchar2(255) NOT NULL,
  email varchar2(255) NOT NULL,
  password varchar2(255) NOT NULL
  
);

insert into userBase (userid, username, first_name, last_name, email, password)
VALUES (seq_newUser.nextval, 'dilinilams', 'Marc', 'Dilinila', 'dilinilams@vcu.edu', 'V00610105');

CREATE TABLE CHAMPTYPE
(
  ID int NOT NULL PRIMARY KEY,
  champType varchar2(255) NOT NULL
);

CREATE TABLE champCost
(
	ID int, --now a primary ket
	IP int,
	RP int
);


CREATE TABLE Champions
(
	ID int NOT NULL PRIMARY KEY,
	champName varchar2(255) NOT NULL,
  champType int references champtype(id) NOT NULL,
  champCost int references champCost(id) not null
);

-- drop one column
alter table
   Champions
drop column
   champType;  
   


ALTER TABLE CHAMPCOST
ADD PRIMARY KEY (ID);

ALTER TABLE champCOST 
MODIFY (ID INT CONSTRAINT not_empty NOT NULL); 

ALTER TABLE champCOST 
MODIFY (IP INT CONSTRAINT not_empty_IP NOT NULL);
ALTER TABLE champCOST 
MODIFY (RP INT CONSTRAINT not_empty_RP NOT NULL);

CREATE SEQUENCE seq_type
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE SEQUENCE seq_newUser
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE SEQUENCE seq_champid
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE OR REPLACE TRIGGER champTrig
BEFORE INSERT ON CHAMPIONS
FOR EACH ROW
 WHEN (new.ID IS NULL) 
BEGIN
  SELECT seq_champid.NEXTVAL 
  INTO :new.ID
  FROM dual;
END;
/

CREATE SEQUENCE seq_champcost
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

drop sequence seq_champcost;

INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Assassin');

--Mage, Marksman, Fighter, Tank, Support
INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Mage');

INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Marksman');

INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Fighter');
INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Tank');
INSERT INTO CHAMPTYPE (ID, Champtype)
VALUES (seq_type.nextval, 'Support');

SELECT ID, CHAMPNAME
FROM CHAMPIONS;
/*Delete from champtype
where id between 7 and 12;*/

--Types:
-- 1 Assassin
-- 2 Mage
-- 3 Marksman
-- 4 Fighter
-- 5 Tank
-- 6 Support


INSERT INTO CHAMPCOST (ID, RP, IP)
VALUES (seq_champcost.nextval, 260, 450);
INSERT INTO CHAMPCOST (ID, RP, IP)
VALUES (seq_champcost.nextval, 585, 1350);
INSERT INTO CHAMPCOST (ID, RP, IP)
VALUES (seq_champcost.nextval, 790, 3150);
INSERT INTO CHAMPCOST (ID, RP, IP)
VALUES (seq_champcost.nextval, 880, 4800);
INSERT INTO CHAMPCOST (ID, RP, IP)
VALUES (seq_champcost.nextval, 975, 6300);

delete  from champcost;


INSERT INTO CHAMPIONS (ID, champName, champType, champCost )
Values (seq_champid.nextval, 'Annie', 2, 1);

INSERT INTO CHAMPIONS (ID, champName, champType, champCost )
Values (seq_champid.nextval, 'Ryze', 2, 1);

INSERT INTO CHAMPIONS (ID, champName, champType, champCost )
Values (seq_champid.nextval, 'Jax', 4, 1);

INSERT INTO CHAMPIONS (ID, champName, champType, champCost )
Values (seq_champid.nextval, 'Soraka', 6, 1);

INSERT INTO CHAMPIONS (ID, champName, champType, champCost )
Values (seq_champid.nextval, 'Ashe', 3, 1);



SELECT ID,RP 
FROM CHAMPCOST;

SELECT *
FROM CHAMPIONS
ORDER BY CHAMPNAME;

ALTER TABLE Champcost
  RENAME COLUMN Influence TO IP;
  ALTER TABLE Champcost
  RENAME COLUMN Riot TO RP ;

UPDATE CHAMPIONS
    SET CHAMPCOST = 3, CHAMPTYPE = 3
    WHERE ID = 45;

SELECT c.champName as Champion, s.RP as RP, s.IP as IP, t.champType as Role 
FROM champions c, champCost s, champtype t
WHERE c.champCost = s.id AND c.champType = t.id;

/*AlTER TABLE CHAMPIONS
ADD CONSTAINT Fk_cost */ 

/*
ALTER TABLE Champions
ADD Constraint fk_IP
	foreign key (IP)
	references champCost(IP);
ALTER TABLE CHAMPIONS
ADD Constraint fk_RP
	foreign key (RP)
	references champCost(RP);
  */