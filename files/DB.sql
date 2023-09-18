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

-- Modificar la columna "dni" para permitir NULL
ALTER TABLE users
MODIFY COLUMN dni varchar(9) DEFAULT NULL;

-- Establecer el valor predeterminado del campo "dni" para usuarios no administradores ('S' o 'T')
UPDATE users
SET dni = ''
WHERE role IN ('S', 'T');

-- Agregar una restricción para garantizar que "dni" sea NULL solo para usuarios administradores
ALTER TABLE users
ADD CONSTRAINT chk_admin_dni
CHECK ((role = 'A' AND dni IS NULL) OR (role IN ('S', 'T') AND dni IS NOT NULL));

-- Agregar clave foránea para usuarios estudiantes ('S')
ALTER TABLE users
ADD CONSTRAINT fk_student_dni
FOREIGN KEY (dni)
REFERENCES student(dniStudent)
ON DELETE CASCADE
ON UPDATE CASCADE
WHERE role = 'S';

-- Agregar clave foránea para usuarios profesores ('T')
ALTER TABLE users
ADD CONSTRAINT fk_teacher_dni
FOREIGN KEY (dni)
REFERENCES teacher(dniTeacher)
ON DELETE CASCADE
ON UPDATE CASCADE
WHERE role = 'T';
