
/*数据库的创建*/
/*
create database school;
use `school`;

drop table if exists `score`;
create table `score`
(
       stuname varchar(32) not null,
       stunum int(11) unsigned primary key auto_increment,
       scores int(4) null,
       coursenum int(10) not null
 
);

drop table if exists `student`;
create table `student`
(
       stunum int(10) unsigned primary key auto_increment,
       stuname varchar(32) not null,
       class varchar(32) not null,
       stu_sex varchar(8) null,
       age int(4) null,
       email varchar(32) null
);
drop table if exists `course`;
create table `course`
(
       coursenum int(10) unsigned primary key auto_increment,
       coursename varchar(32) not null,
       teachernum int(10) not null
);
drop table if exists `teacher`;
create table `teacher`
(
       teachernum int(10) unsigned primary key auto_increment,
       teachername varchar(32) not null,
       department varchar(32) null,
       phonenum int(16) not null,
       job varchar(32) null,
       birthday date null
);
*/

/*插入数据*/
/*
use `school`;
insert into score(stuname,stunum,scores,coursenum) values('王紫娟','111','59','101'),('王梦玲','112','59','101');
insert into student(stunum,stuname,class,stu_sex,age) values('111','王紫娟','1','男','3'),('112','王梦玲','1','男','80');
insert into course(coursenum,coursename,teachernum) values('101','数据库应用A','20'),('102','C语音程序设计','21');
insert into teacher(teachernum,teachername,department,phonenum,job,birthday) values('20','王二','计算机系','15166668898','教师','20010210'),('21','张三','电信分院','18166888866','兼职','20010208');

*/

/*查询数据*/
/*
use `school`;
select scores from score where stuname='王紫娟';
select stuname,coursename,scores from score join course on score.coursenum=course.coursenum 
*/
/*添加字段*/
/*
use `school`;
alter table student add tel int(16) null;
alter table teacher add sex varchar(8) null;
insert into teacher(teachernum,teachername,department,phonenum,job,birthday,sex) values('22','李四','电信分院','15177778898','教师','20010210','男');

*/
/*创建视图*/
/*（1）查询某个班级的学生信息*/
/*
create view stuclassdata as
select *
from student
where class='1';
*/
/*(2)查看每门课程的平均成绩*/
/*
create view score_avg as
select coursename,avg(scores)
from score join course on score.coursenum=course.coursenum
group by coursename
*/
/*(3)查看选修数据库课程的学生信息*/
/*
create view course_computer as
select student.stunum,student.stuname,class,stu_sex,age,scores,coursename
from score inner join student on score.stuname=student.stuname and score.stunum=student.stunum inner join course on score.coursenum=course.coursenum
where coursename='数据库应用A'
*/
/*(4)查看所有男教师和所有男学生的信息*/
/*
create view man_data as
select *
from student,teacher
where student.stu_sex='男' and teacher.sex='男';
*/ 
/*创建存储过程*/
/*
create procedure proc_stu 
as
    select score.stuname,score.stunum,score.scores,score.coursenum  
    from  course inner join teacher on course.teachernum=teacher.teachernum inner join score on score.coursenum=course.coursenum
    where teacher.sex='男' and teacher.department='计算机系'   
   
*/
/*创建触发器*/
/*create trigger score_adds
on score
for insert
as
update score set scores=scors*1.2 where score.stunum is not null ;
*/










