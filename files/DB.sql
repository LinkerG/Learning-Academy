CREATE DATABASE learningAcademy;

USE learningAcademy;

-- Creacion de la tabla teacher
CREATE TABLE teacher(
    dniTeacher varchar(9) PRIMARY KEY,
    name varchar(15),
    surname varchar(25),
    titulation varchar(50),
    photoPath varchar(100),
    active boolean
);

-- Creacion de la tabla student
CREATE TABLE student(
    dniStudent varchar(9) PRIMARY KEY,
    name varchar(15),
    surname varchar(25),
    age int,
    photoPath varchar(100)
);

-- Creacion de la tabla course
CREATE TABLE course(
    codigocourse int PRIMARY KEY,
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

CREATE TABLE users(
    email varchar(40) PRIMARY KEY,
    password varchar(200),
    role CHAR(1) CHECK (role IN ('T','S','A'))
);

INSERT INTO users (email, password, role)
VALUES ('super@admin.com', MD5('administrador'), 'A');

-- Modificar la restricción CHECK para permitir NULL en el campo "dni" para usuarios administradores
ALTER TABLE users
MODIFY COLUMN dni varchar(9) DEFAULT NULL;

-- Definir restricción FOREIGN KEY para referenciar a la tabla "student" si el rol es 'S'
ALTER TABLE users
ADD CONSTRAINT fk_student_dni
FOREIGN KEY (dni)
REFERENCES student(dniStudent)
ON DELETE CASCADE
ON UPDATE CASCADE
CHECK (role = 'S' OR (role = 'A' AND dni IS NULL));

-- Definir restricción FOREIGN KEY para referenciar a la tabla "teacher" si el rol es 'T'
ALTER TABLE users
ADD CONSTRAINT fk_teacher_dni
FOREIGN KEY (dni)
REFERENCES teacher(dniTeacher)
ON DELETE CASCADE
ON UPDATE CASCADE
CHECK (role = 'T' OR (role = 'A' AND dni IS NULL));
