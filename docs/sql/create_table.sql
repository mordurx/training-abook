create table Cuento_finalizado (

id_usuario varchar(20) not null,
FOREIGN KEY (id_usuario) REFERENCES Cuentos_por_Usuario(id_usuario),
id_cuento int not null,
FOREIGN KEY (id_cuento) REFERENCES Cuento(id_cuento),
fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
primary key(id_usuario,id_cuento,fecha)

)

ALTER TABLE Cuento_por_Usuario
ADD disponible boolean DEFAULT TRUE

