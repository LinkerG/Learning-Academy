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
    codigocourse int PRIMARY KEY AUTO_INCREMENT,
    name varchar(25),
    hours int,
    startDate date,
    endDate date,
    dniTeacher varchar(9),
    active boolean,
    FOREIGN KEY (dniTeacher) REFERENCES teacher(dniTeacher)
);

-- Relacion entre student y course (N a M) "matriculates" 

CREATE TABLE matriculates(
    dniStudent varchar(9),
    codigocourse int,
    PRIMARY KEY (dniStudent, codigocourse),
    FOREIGN KEY (dniStudent) REFERENCES student(dniStudent),
    FOREIGN KEY (codigocourse) REFERENCES course(codigocourse)
);

-- Creacion de tabla para gestionar los usuarios

CREATE TABLE admin(
    email varchar(40) PRIMARY KEY,
    password varchar(200)
);

INSERT INTO admin (email, password)
VALUES ('super@admin.com', MD5('administrador'));
