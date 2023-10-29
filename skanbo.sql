create database skanbo;

use skanbo;

create table usuarios (
    id int auto_increment primary key,
    username varchar(255) not null,
    password varchar(255) not null
);

create table if not exists cliente (
	id_cli int(4) auto_increment not null primary key,
	nome varchar(25) not null);

create table if not exists prestador (
	cnpj char(14) not null primary key,
	nomeFantasia varchar(25) not null,
	especialidade varchar(50) not null);

create table if not exists agendamento (
	id_agendamento int(6) auto_increment not null primary key,
	data datetime not null,
	id_cli int(4) not null,
	cnpj char(14) not null,
	categoria varchar(50) not null,
	foreign key (cnpj) references prestador(cnpj),
	foreign key (id_cli) references cliente(id_cli),
	unique key (data, cnpj));

create view vProxAgendamento as 
	select id_agendamento, date_format(data, "%e/%c/%Y") as data_c, 
	 date_format(data, "%k:%i") as hora, cliente.nome as cliente, 
	 prestador.nomeFantasia as prestador, categoria, timestampdiff(HOUR, curtime(), data) as dif 
	 from agendamento inner join cliente on agendamento.id_cli = cliente.id_cli
	 inner join prestador on agendamento.cnpj = prestador.cnpj 
	 where data > now() 
	 order by data, prestador;	 

create view vClientePorNome as
 select * from cliente order by nome;

create view vPrestadorPorNome as 
 select * from prestador order by nomeFantasia;

create view vCategorias as 
 select distinct categoria from agendamento order by categoria; 

delimiter $$

create procedure spConsultaPorId (IN id INT(6))
begin
    select cliente.nome as cliente, prestador.nomeFantasia as prestador 
    from agendamento inner join cliente on agendamento.id_cli = cliente.id_cli 
    inner join prestador on agendamento.cnpj = prestador.cnpj where id_agendamento = id;
end $$

create procedure spIncluiCliente (IN cli varchar(25), OUT id INT(4))
begin
    insert into cliente (nome) values (cli);
    select id_cli from cliente where nome = cli;
end $$

create procedure spIncluiPrestador (IN cnpj char(14), IN nomeFantasia varchar(25), IN especialidade varchar(50))
begin
    insert into prestador (cnpj, nomeFantasia, especialidade) values (cnpj, nomeFantasia, especialidade);
end $$

create procedure spIncluiAgendamento (IN data varchar(20), IN cliente int(4), 
    IN prestador char(14), IN categoria varchar(50))
begin
    insert into agendamento (data, id_cli, cnpj, categoria) 
    values (str_to_date(data, '%Y-%m-%d %H:%i'), cliente, prestador, categoria);
end $$

create procedure spCancelaAgendamento (IN id INT(6))
begin
    delete from agendamento where id_agendamento = id;
end $$ 

create procedure spAlteraAgendamento (IN id INT(6), IN data_c varchar(20))
begin
    update agendamento set data = str_to_date(data_c, '%Y-%m-%d %H:%i') where id_agendamento = id;
end $$

-- CREATE FUNCTION MinhaFuncao() RETURNS CHAR(11)
-- BEGIN
--     DECLARE cliente_cpf CHAR(11)    
--     RETURN cliente_cpf;
-- END$$ 

delimiter ;

-- Inserir 
-- ERROR: ao inserir. Erro no SQL DataBase começa aqui
-- ERRO resolved: como mudamos para cpf, precisava de inserções, então voltamos pro id_cli com AUTO_INCREMENT
call spIncluiCliente('Latussa Natividade', @id);
call spIncluiCliente('Guigliermo Vilas', @id);
call spIncluiCliente('Diorone Nolasco', @id);
call spIncluiCliente('Elvispresley Barreira', @id);
call spIncluiCliente('Cristhaldo Paranhos', @id);
call spIncluiCliente('Dhesiani Schultz', @id);
call spIncluiCliente('Julesio Calisto', @id);
call spIncluiCliente('Leotrice Paranhos', @id);
call spIncluiCliente('Inizele Filgueira', @id);
call spIncluiCliente('Loraidy do Amparo', @id);

-- Inserir Prestadores
call spIncluiPrestador('36037184000101', 'Mãos Divinas', 'Manicure&Pedicure');
call spIncluiPrestador('67255634000166', 'Haja Luz', 'Eletricista');
call spIncluiPrestador('19838746000105', 'Limpa e Brilha', 'Diarista');
call spIncluiPrestador('15622430000112', 'Desentope Alma', 'Desentupidor');
call spIncluiPrestador('29697258000170', 'MasterChef', 'Cozinheira');
call spIncluiPrestador('02051561000145', 'Perereirão Construção', 'Pedreiro');
call spIncluiPrestador('08433172000160', 'The Rock', 'Personal Trainer');
call spIncluiPrestador('13568611000182', 'Márcia Sensitiva', 'Psicóloga');

-- -- Inserir Agendamentos
call spIncluiAgendamento('2023-10-09 10:30', 3, '08433172000160', 'Em domicílio');
call spIncluiAgendamento('2023-10-16 08:20', 6, '13568611000182', 'Presencial no Estabelecimento');
call spIncluiAgendamento('2023-10-17 08:00', 1, '08433172000160', 'Escolha do Cliente');
call spIncluiAgendamento('2023-10-18 14:00', 1, '19838746000105', 'Em domicílio');
call spIncluiAgendamento('2023-10-19 09:00', 4, '08433172000160', 'Escolha do Cliente');
call spIncluiAgendamento('2023-10-20 09:20', 8, '13568611000182', 'Presencial no Estabelecimento');
call spIncluiAgendamento('2023-10-22 09:20', 9, '02051561000145', 'Em domicílio');
call spIncluiAgendamento('2023-10-23 09:40', 10, '13568611000182', 'Presencial no Estabelecimento');
call spIncluiAgendamento('2023-10-24 14:00', 5, '36037184000101', 'Em domicílio');
call spIncluiAgendamento('2023-10-26 14:20', 7, '67255634000166', 'Em domicílio');
call spIncluiAgendamento('2023-10-28 14:40', 2, '15622430000112', 'Escolha do Cliente');
call spIncluiAgendamento('2023-10-30 14:40', 3, '19838746000105', 'Em domicílio');

