drop table players cascade constraints;
drop table locations cascade constraints;
drop table teams cascade constraints;
drop table playerteams cascade constraints;
drop table matches cascade constraints;
drop table matchstats cascade constraints;
drop table playerstats cascade constraints;
drop view GSWTemp;
drop view HOUTemp;
drop view BOSTemp;
drop view TORTemp;

create table players
  (pid varchar(5),
  pfname varchar(40),
  plname varchar(40),
  dob DATE,
  jno int,
  pos varchar(4),
  primary key (pid)
  );


create table locations
  (locid varchar(5),
  city varchar(20),
  stadium varchar(20),
  capacity int,
  primary key (locid)
);

create table teams
  (tid varchar(5),
  locid varchar(5),
  tname varchar(100),
  primary key (tid),
  foreign key (locid) references locations(locid) ON DELETE SET NULL
);

 create table playerteams(
  pid varchar(5),
  tid varchar(5),
  salary int CONSTRAINT salary_limit CHECK (salary BETWEEN 0 AND 40),
  primary key (pid, tid),
  foreign key (pid) references players(pid) ON DELETE CASCADE,
  foreign key (tid) references teams(tid)
  );


  create table matches
    (mid varchar(5),
    hid varchar(5),
    aid varchar(5),
    locid varchar(5),
    mdate DATE,
    mtime varchar(20),
    primary key (mid),
    foreign key (hid) references teams(tid),
    foreign key (aid) references teams(tid),
    foreign key (locid) references locations (locid) ON DELETE SET NULL
  );


  create table matchstats
    (mid varchar(5),
    tid varchar(5),
    opid varchar(5),
    tscore int,
    oscore int,
    winloss varchar(1),
    homeaway varchar(4),
    primary key (mid,tid,opid),
    foreign key (mid) references matches(mid),
    foreign key (tid) references teams(tid),
    foreign key (opid) references teams(tid)
    );


  create table playerstats
    (mid varchar(5),
    pid varchar(5),
    ps int,
    primary key (mid, pid),
    foreign key (mid) references matches(mid),
    foreign key (pid) references players(pid) ON DELETE CASCADE
    );


insert into locations values('oak','Oakland','Oracle Arena', '1500');
insert into locations values('tdg','Boston','TD Garden', '1500');
insert into locations values('toc','Houston','Toyota Centre', '1000');
insert into locations values('acc','Toronto','Air Canada Centre', '500');



insert into teams values('gsw','oak','Golden State Warriors');
insert into teams values('bos','tdg','Boston Celtics');
insert into teams values('hou','toc','Houston Rockets');
insert into teams values('tor','acc','Toronto Raptors');


insert into players values('sc30','Stephen','Curry','1988-03-14','30','pg');
insert into players values('kt11','Klay','Thompson','1990-02-08','11','sg');
insert into players values('kd35','Kevin','Durant','1988-09-29','35','sf');
insert into players values('dg23','Draymond','Green','1990-03-04','23','pf');
insert into players values('jm01','JaVale','McGee','1988-01-19','1','c');
insert into players values('ai09','Andre','Iguodala','1984-01-28','9','6th');

insert into players values('ki11','Kyrie','Irving','1992-03-23','11','pg');
insert into players values('gh20','Gordon','Hayward','1990-03-23','20','sg');
insert into players values('jb07','Jaylen','Brown','1996-10-24','7','sf');
insert into players values('jt00','Jason','Tatum','1998-03-03','0','pf');
insert into players values('ah42','Al','Horford','1986-06-03','42','c');
insert into players values('ms36','Marcus','Smart','1994-03-06','36','6th');

insert into players values('cp03','Chris','Paul','1985-05-06','3','pg');
insert into players values('jh13','James','Harden','1989-08-26','13','sg');
insert into players values('ta01','Trevor','Ariza','1985-06-30','1','sf');
insert into players values('ra33','Ryan','Anderson','1988-05-06','33','pf');
insert into players values('cc15','Clint','Capela','1994-05-18','15','c');
insert into players values('eg10','Eric','Gordon','1988-12-25','10','6th');

insert into players values('kl07','Kyle','Lowry','1986-03-25','7','pg');
insert into players values('dd10','DeMar','Derozen','1989-08-07','10','sg');
insert into players values('np24','Norman','Powell','1993-05-25','24','sf');
insert into players values('si09','Serge','Ibaka','1989-09-18','9','pf');
insert into players values('jv17','Jonas','Valanciunas','1992-05-06','17','c');
insert into players values('ps43','Pascal','Siakam','1994-04-02','43','6th');


insert into playerteams values('sc30','gsw','30');
insert into playerteams values('kt11','gsw','20');
insert into playerteams values('kd35','gsw','30');
insert into playerteams values('dg23','gsw','20');
insert into playerteams values('jm01','gsw','10');
insert into playerteams values('ai09','gsw','10');

insert into playerteams values('ki11','bos','30');
insert into playerteams values('gh20','bos','30');
insert into playerteams values('jb07','bos','10');
insert into playerteams values('jt00','bos','10');
insert into playerteams values('ah42','bos','20');
insert into playerteams values('ms36','bos','10');

insert into playerteams values('cp03','hou','30');
insert into playerteams values('jh13','hou','30');
insert into playerteams values('ta01','hou','10');
insert into playerteams values('ra33','hou','10');
insert into playerteams values('cc15','hou','20');
insert into playerteams values('eg10','hou','10');

insert into playerteams values('kl07','tor','30');
insert into playerteams values('dd10','tor','30');
insert into playerteams values('np24','tor','10');
insert into playerteams values('si09','tor','10');
insert into playerteams values('jv17','tor','10');
insert into playerteams values('ps43','tor','10');

insert into matches values('bt','bos','tor','tdg','2017-03-01','Morning');

insert into matchstats values('bt','bos','tor','77','67','w','home');
insert into playerstats values('bt','ki11','32');
insert into playerstats values('bt','ms36','4');
insert into playerstats values('bt','jb07','14');
insert into playerstats values('bt','jt00','12');
insert into playerstats values('bt','ah42','15');
insert into matchstats values('bt','tor','bos','67','77','l','away');
insert into playerstats values('bt','kl07','20');
insert into playerstats values('bt','dd10','24');
insert into playerstats values('bt','np24','10');
insert into playerstats values('bt','si09','5');
insert into playerstats values('bt','jv17','8');

insert into matches values('bh','bos','hou','tdg','2017-03-02','Night');
insert into matchstats values('bh','bos','hou','62','77','l','home');
insert into playerstats values('bh','ki11','19');
insert into playerstats values('bh','ms36','14');
insert into playerstats values('bh','jb07','4');
insert into playerstats values('bh','jt00','13');
insert into playerstats values('bh','ah42','12');
insert into matchstats values('bh','hou','bos','77','62','w','away');
insert into playerstats values('bh','cp03','22');
insert into playerstats values('bh','jh13','34');
insert into playerstats values('bh','ta01','3');
insert into playerstats values('bh','ra33','6');
insert into playerstats values('bh','cc15','12');


insert into matches values('bg','bos','gsw','tdg','2017-03-03','Night');
insert into matchstats values('bg','bos','gsw','74','80','l','home');
insert into playerstats values('bg','ki11','22');
insert into playerstats values('bg','ms36','14');
insert into playerstats values('bg','jb07','4');
insert into playerstats values('bg','jt00','13');
insert into playerstats values('bg','ah42','21');
insert into matchstats values('bg','gsw','bos','80','74','w','away');
insert into playerstats values('bg','sc30','26');
insert into playerstats values('bg','kt11','20');
insert into playerstats values('bg','ai09','3');
insert into playerstats values('bg','kd35','24');
insert into playerstats values('bg','dg23','7');


insert into matches values('tb','tor','bos','acc','2017-03-04','Night');
insert into matchstats values('tb','tor','bos','40','70','l','home');
insert into playerstats values('tb','kl07','7');
insert into playerstats values('tb','dd10','12');
insert into playerstats values('tb','np24','5');
insert into playerstats values('tb','ps43','11');
insert into playerstats values('tb','jv17','5');
insert into matchstats values('tb','bos','tor','70','40','w','away');
insert into playerstats values('tb','ki11','40');
insert into playerstats values('tb','ms36','2');
insert into playerstats values('tb','jb07','4');
insert into playerstats values('tb','jt00','12');
insert into playerstats values('tb','ah42','12');

insert into matches values('th','tor','hou','acc','2017-03-05','Night');
insert into matchstats values('th','tor','hou','62','83','l','home');
insert into playerstats values('th','kl07','27');
insert into playerstats values('th','dd10','2');
insert into playerstats values('th','np24','15');
insert into playerstats values('th','ps43','1');
insert into playerstats values('th','jv17','17');
insert into matchstats values('th','hou','tor','83','62','w','away');
insert into playerstats values('th','cp03','12');
insert into playerstats values('th','jh13','54');
insert into playerstats values('th','ta01','3');
insert into playerstats values('th','ra33','6');
insert into playerstats values('th','cc15','8');


insert into matches values('tg','tor','gsw','acc','2017-03-06','Afternoon');
insert into matchstats values('tg','tor','gsw','64','80','l','home');
insert into playerstats values('tg','kl07','17');
insert into playerstats values('tg','dd10','22');
insert into playerstats values('tg','np24','5');
insert into playerstats values('tg','si09','11');
insert into playerstats values('tg','jv17','9');
insert into matchstats values('tg','gsw','tor','80','64','w','away');
insert into playerstats values('tg','sc30','16');
insert into playerstats values('tg','kt11','20');
insert into playerstats values('tg','ai09','2');
insert into playerstats values('tg','kd35','34');
insert into playerstats values('tg','dg23','8');

insert into matches values('gb','gsw','bos','oak','2017-03-07','Afternoon');
insert into matchstats values('gb','gsw','bos','86','71','w','home');
insert into playerstats values('gb','sc30','61');
insert into playerstats values('gb','kt11','10');
insert into playerstats values('gb','kd35','12');
insert into playerstats values('gb','dg23','2');
insert into playerstats values('gb','jm01','1');
insert into matchstats values('gb','bos','gsw','71','86','l','away');
insert into playerstats values('gb','ki11','38');
insert into playerstats values('gb','ms36','2');
insert into playerstats values('gb','jb07','4');
insert into playerstats values('gb','jt00','12');
insert into playerstats values('gb','ah42','15');


insert into matches values('gt','gsw','tor','oak','2017-03-08','Morning');
insert into matchstats values('gt','gsw','tor','90','65','w','home');
insert into playerstats values('gt','sc30','12');
insert into playerstats values('gt','kt11','56');
insert into playerstats values('gt','kd35','12');
insert into playerstats values('gt','dg23','2');
insert into playerstats values('gt','jm01','8');
insert into matchstats values('gt','tor','gsw','65','90','l','away');
insert into playerstats values('gt','kl07','37');
insert into playerstats values('gt','dd10','12');
insert into playerstats values('gt','np24','5');
insert into playerstats values('gt','si09','1');
insert into playerstats values('gt','jv17','10');


insert into matches values('gh','gsw','hou','oak','2017-03-09','Afternoon');
insert into matchstats values('gh','gsw','hou','56','65','l','home');
insert into playerstats values('gh','sc30','26');
insert into playerstats values('gh','kt11','15');
insert into playerstats values('gh','kd35','12');
insert into playerstats values('gh','dg23','2');
insert into playerstats values('gh','jm01','1');
insert into matchstats values('gh','hou','gsw','65','56','w','away');
insert into playerstats values('gh','cp03','15');
insert into playerstats values('gh','jh13','30');
insert into playerstats values('gh','ta01','2');
insert into playerstats values('gh','ra33','6');
insert into playerstats values('gh','cc15','12');


insert into matches values('hg','hou','gsw','toc','2017-03-10','Noon');
insert into matchstats values('hg','hou','gsw','75','82','l','home');
insert into playerstats values('hg','cp03','25');
insert into playerstats values('hg','jh13','30');
insert into playerstats values('hg','ta01','2');
insert into playerstats values('hg','ra33','6');
insert into playerstats values('hg','cc15','12');
insert into matchstats values('hg','gsw','hou','82','75','w','away');
insert into playerstats values('hg','sc30','30');
insert into playerstats values('hg','kt11','12');
insert into playerstats values('hg','ai09','3');
insert into playerstats values('hg','kd35','34');
insert into playerstats values('hg','dg23','3');



insert into matches values('ht','hou','tor','toc','2017-03-11','Night');
insert into matchstats values('ht','hou','tor','68','64','w','home');
insert into playerstats values('ht','cp03','22');
insert into playerstats values('ht','eg10','3');
insert into playerstats values('ht','jh13','32');
insert into playerstats values('ht','ta01','1');
insert into playerstats values('ht','cc15','10');
insert into matchstats values('ht','tor','hou','64','68','l','away');
insert into playerstats values('ht','kl07','7');
insert into playerstats values('ht','dd10','42');
insert into playerstats values('ht','np24','5');
insert into playerstats values('ht','si09','1');
insert into playerstats values('ht','jv17','9');



insert into matches values('hb','hou','bos','toc','2017-03-12','Night');
insert into matchstats values('hb','hou','bos','80','71','w','home');
insert into playerstats values('hb','cp03','12');
insert into playerstats values('hb','eg10','10');
insert into playerstats values('hb','jh13','43');
insert into playerstats values('hb','ra33','5');
insert into playerstats values('hb','cc15','10');
insert into matchstats values('hb','bos','hou','71','80','l','away');
insert into playerstats values('hb','ki11','20');
insert into playerstats values('hb','ms36','6');
insert into playerstats values('hb','jb07','13');
insert into playerstats values('hb','jt00','10');
insert into playerstats values('hb','ah42','22');



CREATE VIEW GSWTemp (pid, pfname, plname) as select p.pid, p.pfname, p.plname from players p, playerteams pt where p.pid = pt.pid and pt.tid = 'gsw';
CREATE VIEW BOSTemp (pid, pfname, plname) as select p.pid, p.pfname, p.plname from players p, playerteams pt where p.pid = pt.pid and pt.tid = 'bos';
CREATE VIEW TORTemp (pid, pfname, plname) as select p.pid, p.pfname, p.plname from players p, playerteams pt where p.pid = pt.pid and pt.tid = 'tor';
CREATE VIEW HOUTemp (pid, pfname, plname) as select p.pid, p.pfname, p.plname from players p, playerteams pt where p.pid = pt.pid and pt.tid = 'hou';
