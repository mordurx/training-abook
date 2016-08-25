create table Respuesta_pregunta
(
	id_pregunta int,
	FOREIGN KEY (id_pregunta) REFERENCES Pregunta(id_pregunta),
	nombre_usuario varchar(50),
	FOREIGN KEY (nombre_usuario) REFERENCES Pregunta(nombre),
	id_feedback  int,
	resp_user varchar(50),
	resultado int,
	estado int default 0,
	intento int,
	primary key (id_pregunta,nombre_usuario)
	
)
create table Cuento_por_Usuario
(
	id_usuario varchar(50),
	FOREIGN KEY (id_usuario) REFERENCES Pregunta(nombre),
	id_cuento int,
	FOREIGN KEY (id_cuento) REFERENCES Cuento(id_cuento),
	veces_leido int default 1,
	ind_pagina int default 1,
	primary key(id_usuario,id_cuento)
	

	
)
################## TRUNCATE TABLE #####################

TRUNCATE TABLE Cuento;
TRUNCATE TABLE Cuento_por_Usuario;
TRUNCATE TABLE Pagina;
TRUNCATE TABLE Pregunta;
TRUNCATE TABLE Respuesta_pregunta;
TRUNCATE TABLE Usuario;