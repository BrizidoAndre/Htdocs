create table containers
(
    codigo varchar(255) not null
        primary key,
    id_os  varchar(13)  not null
);

create table porto
(
    name      varchar(255) null,
    id        int auto_increment
        primary key,
    status    varchar(50)  not null,
    pais      varchar(255) not null,
    latitude  varchar(20)  not null,
    longitude varchar(20)  not null
);

create table products
(
    nota         varchar(44)  not null
        primary key,
    id_container varchar(255) not null,
    constraint products_containers_codigo_fk
        foreign key (id_container) references containers (codigo)
);

create table users
(
    id             int auto_increment
        primary key,
    name           varchar(255) not null,
    razao          varchar(255) not null,
    cnpj           varchar(255) not null,
    data_criacao   date         not null,
    token          varchar(522) null,
    transportadora tinyint(1)   null,
    senha          varchar(255) not null
);

create table os
(
    codigo       varchar(13)  not null
        primary key,
    id_usuario   int          not null,
    id_porto     int          not null,
    status       varchar(255) not null,
    data_criacao date         not null,
    constraint os_porto_id_fk
        foreign key (id_porto) references porto (id),
    constraint os_users_id_fk
        foreign key (id_usuario) references users (id)
);

create table viagens
(
    id                int auto_increment
        primary key,
    id_os             varchar(13)  not null,
    portoOrigem       int          not null,
    portoDestino      int          not null,
    status            varchar(255) not null,
    dataEmissao       datetime     not null,
    ultimaAtualizacao datetime     null,
    constraint viagens_os_codigo_fk
        foreign key (id_os) references os (codigo),
    constraint viagens_porto_id_fk
        foreign key (portoDestino) references porto (id),
    constraint viagens_porto_id_fk_2
        foreign key (portoOrigem) references porto (id)
);

