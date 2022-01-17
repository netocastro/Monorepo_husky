DROP TABLE IF EXISTS deliveries;
DROP TABLE IF EXISTS store;
DROP TABLE IF EXISTS motoboys;
DROP TABLE IF EXISTS status;
DROP TABLE IF EXISTS users;

CREATE TABLE `users`(
    `id` INTEGER AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `address` VARCHAR(200) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into users (name, address) VALUES 
('Joao da silva','Rua Apolinario Vianna'),
('Maria da silva','Rua Jose Peixoto'),
('Pedro da Souza','Rua Apolinario Vianna'),
('Eduarda Costa','av Governado Antono');

CREATE TABLE `status`(
    `id` INTEGER AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status`(id, name) VALUES('1', 'Novo'),('2', 'Entregando'),('3', 'Finalizado'),('4', 'Cancelado');

CREATE TABLE `motoboys`(
    `id` INTEGER AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into motoboys (name) VALUES 
('motoqueiro1'),
('Joaquim menezes'),
('Paulo Luiz'),
('Antonio Gustavo');

CREATE TABLE `deliveries`(
    `id` INTEGER AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `motoboy_id` INTEGER DEFAULT NULL,
    `status` INTEGER NOT NULL,  -- trocar aqui por status_id
    `collection_address` VARCHAR(200) NOT NULL,
    `destination_address` VARCHAR(200) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY(id) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `deliveries` ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `deliveries` ADD FOREIGN KEY(motoboy_id) REFERENCES motoboys(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `deliveries` ADD FOREIGN KEY(status) REFERENCES status(id) ON UPDATE CASCADE ON DELETE CASCADE;

INSERT INTO `deliveries` (`id`, `user_id`, `motoboy_id`, `status`, `collection_address`, `destination_address`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'loja1', 'casa do cliente2', '2022-01-13 07:21:42', '2022-01-15 05:10:44'),
(2, 2, NULL, 3, 'loja2', 'sdfsdfsdfsdf, n° 50, feitosa, Maceió-AL', '2022-01-13 07:21:52', '2022-01-15 08:22:14'),
(3, 1, 1, 1, 'loja3', 'rua jao da silva, n° 50, feitosa, Maceió-AL', '2022-01-15 08:08:18', '2022-01-15 04:08:18'),
(4, 2, NULL, 1, 'loja4', 'casa cliente', '2022-01-15 17:57:26', '2022-01-15 13:57:26'),
(5, 3, 3, 4, 'loja4', 'casa cliente', '2022-01-15 17:57:26', '2022-01-15 13:57:26');

-- falta colocar na entrega o usuario que fez o pedido, alem do endereço.
-- falta criar loja, colocar o id da loja que foi feito o pedido.
