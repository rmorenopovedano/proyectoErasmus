create table relparticipantespaises(
	id int primary key auto_increment,
        idPais int not null,
        idParticipante int not null,
        constraint fk_pais foreign key (idPais) references paises(codigo) on delete cascade,
        constraint fk_participante foreign key (idParticipante) references participantes(id) on delete cascade,
        unique (idPais,idParticipante)
)

create table documentos(
  id int PRIMARY key auto_increment,
  nombre varchar(255) not null,
  tipo varchar (50) not null,
  idParticipante int not null,
  constraint fk_participante_documento foreign key (idParticipante) references participantes(id) on delete cascade
)
--   tipo ENUM ('cv', 'carta', 'dni' ,'pasaporte'),