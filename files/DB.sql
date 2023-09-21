CREATE DATABASE learningAcademy;

USE learningAcademy;

-- Creacion de la tabla teacher
CREATE TABLE teacher(
    dniTeacher varchar(9) PRIMARY KEY,
    email varchar(40) UNIQUE,
    password varchar(200),
    name varchar(15),
    surname varchar(25),
    titulation varchar(50),
    photoPath varchar(100),
    active boolean
);

-- Creacion de la tabla student
CREATE TABLE student(
    dniStudent varchar(9) PRIMARY KEY,
    email varchar(40) UNIQUE,
    password varchar(200),
    name varchar(15),
    surname varchar(25),
    birthDate date,
    photoPath varchar(100)
);

-- Creacion de la tabla course
CREATE TABLE course(
    courseId int PRIMARY KEY AUTO_INCREMENT,
    name varchar(25),
    hours int,
    startDate date,
    endDate date,
    dniTeacher varchar(9),
    active boolean,
    photoPath varchar(100),
    desc varchar(200),
    FOREIGN KEY (dniTeacher) REFERENCES teacher(dniTeacher)
);

-- Relacion entre student y course (N a M) "matriculates" 

CREATE TABLE matriculates(
    dniStudent varchar(9),
    courseId int,
    task1 varchar(200),
    task2 varchar(200),
    task3 varchar(200),
    task4 varchar(200),
    score int,
    PRIMARY KEY (dniStudent, courseId),
    FOREIGN KEY (dniStudent) REFERENCES student(dniStudent),
    FOREIGN KEY (courseId) REFERENCES course(courseId)
);

-- Creacion de tabla para gestionar los usuarios

CREATE TABLE admin(
    email varchar(40) PRIMARY KEY,
    password varchar(200)
);

INSERT INTO admin (email, password)
VALUES ('super@admin.com', MD5('administrador'));
