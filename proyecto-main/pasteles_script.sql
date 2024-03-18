DROP DATABASE  IF EXISTS PastelesDB;
CREATE DATABASE PastelesDB;
USE PastelesDB;

CREATE TABLE Pastel (
    id_Pastel INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
	descripcion TEXT,
    preparado_por VARCHAR(50),
    fecha_creacion DATE,
    fecha_vencimiento DATE
);

CREATE TABLE Ingrediente (
    id_Ingrediente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    fecha_ingreso DATE,
    fecha_vencimiento DATE
);

CREATE TABLE Pastel_ingredientes(
    id_pastel_ingrediente INT AUTO_INCREMENT PRIMARY KEY,
    id_Pastel INT NOT NULL,
    id_Ingrediente INT NOT NULL,
    FOREIGN KEY(id_Pastel) REFERENCES Pastel(id_Pastel),
    FOREIGN KEY(id_Ingrediente) REFERENCES Ingrediente(id_Ingrediente)
);
