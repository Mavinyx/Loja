use lojafix;

drop table if exists pagamento;
drop table if exists prod_venda;
drop table if exists venda;
drop table if exists produto;
drop table if exists endereco;
drop table if exists categoria;
drop table if exists fornecedor;
drop table if exists usuario;

create table usuario(
	id_user int auto_increment primary key,
	nome_user varchar(200),
	email varchar(200) unique not null
);

create table fornecedor(
	id_forn int auto_increment primary key,
	nome_forn varchar(200)
);
create table categoria(
	id_cat int auto_increment primary key,
	nome_cat varchar(200),
	descricao varchar(200)
);

create table endereco(
	id_end int auto_increment primary key,
	id_user int not null,
	cep varchar(15),
	numero int,
	cidade varchar(50),
	estado varchar(50),
	foreign key(id_user) references usuario(id_user)
);

create table produto(
	id_prod int auto_increment primary key,
	id_forn int,
	id_cat int,
	nome_prod varchar(200),
	preco decimal(10,2),
	descricao varchar(300),
	estoque int check(estoque >=0), 
	
	foreign key(id_forn) references fornecedor(id_forn),
	foreign key(id_cat) references categoria(id_cat)
);
create table venda(
 	id_venda int auto_increment primary key,
 	id_user int,
 	valor_tot decimal(10,2),
 	data_ped date,
 	
 	foreign key(id_user) references usuario(id_user)
);

create table prod_venda(
	id_prod int,
	id_venda int,
	quant int check(quant >=0),
	valor_venda_prd decimal(10,2),
	
	primary key(id_prod, id_venda),
	foreign key(id_prod) references produto(id_prod),
	foreign key(id_venda) references venda(id_venda)
	
); 

create table pagamento(
	id_pag int auto_increment primary key,
	id_venda int not null,
	valor decimal(10,2),
	metodo varchar(50),
	status varchar(30),
	
	foreign key(id_venda) references venda(id_venda)
);


 
