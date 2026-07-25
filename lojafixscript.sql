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
	nome_forn varchar(200),
	email varchar(200) unique,
	endereco varchar(255)
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
	id_prod_venda  int auto_increment primary key,
	id_prod int,
	id_venda int,
	quant int check(quant >=0),
	valor_venda_prd decimal(10,2),
	
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

-- dados de teste
insert into usuario (nome_user, email) values
('Ana Silva', 'ana.silva@email.com'),
('Carlos Eduardo', 'carlos.edu@email.com'),
('Mariana Costa', 'mariana.costa@email.com'),
('Lucas Pereira', 'lucas.p@email.com');


insert into fornecedor (nome_forn, email, endereco) values
('Tech Distributor Brasil', 'contato@techdist.com.br', 'Av. Paulista, 1000 - São Paulo/SP'),
('EletroAtacado S.A.', 'vendas@eletroatacado.com', 'Rua das Indústrias, 500 - Porto Alegre/RS'),
('Moda & Cia Distribuidora', 'comercial@modaecia.com', 'Rua das Roupas, 120 - Brusque/SC');

insert into categoria (nome_cat, descricao) values
('Eletrônicos', 'Dispositivos eletrônicos e acessórios'),
('Periféricos', 'Teclados, mouses e monitores'),
('Vestuário', 'Roupas e calçados masculinos e femininos');


insert into endereco (id_user, cep, numero, cidade, estado) values
(1, '94910-000', 105, 'Cachoeirinha', 'RS'),
(2, '90010-000', 420, 'Porto Alegre', 'RS'),
(3, '01001-000', 12, 'São Paulo', 'SP'),
(4, '20040-000', 88, 'Rio de Janeiro', 'RJ');


insert into produto (id_forn, id_cat, nome_prod, preco, descricao, estoque) values
(1, 1, 'Smartphone Galaxy S23', 3499.90, '128GB, Tela 6.1, 8GB RAM', 15),
(1, 2, 'Teclado Mecânico RGB', 299.00, 'Switch Blue, Layout ABNT2', 30),
(2, 2, 'Mouse Sem Fio 1600 DPI', 79.90, 'Sensor óptico, conexão USB', 50),
(3, 3, 'Camiseta Algodão Premium', 59.90, '100% Algodão, Cor Preta, Tam G', 100),
(2, 1, 'Monitor 24" Full HD 75Hz', 699.00, 'Painel IPS com HDMI e VGA', 8);

insert into venda (id_user, valor_tot, data_ped) values
(1, 3798.90, '2026-07-20'),
(2, 119.80, '2026-07-22'),
(3, 778.90, '2026-07-24');


insert into prod_venda (id_prod, id_venda, quant, valor_venda_prd) values
(1, 1, 1, 3499.90),
(2, 1, 1, 299.00),
(4, 2, 2, 59.90),
(5, 3, 1, 699.00),
(3, 3, 1, 79.90);


insert into pagamento (id_venda, valor, metodo, status) values
(1, 3798.90, 'Cartão de Crédito', 'Aprovado'),
(2, 119.80, 'PIX', 'Aprovado'),
(3, 778.90, 'Boleto', 'Pendente');