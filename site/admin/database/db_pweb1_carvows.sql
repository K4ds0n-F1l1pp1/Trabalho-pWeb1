CREATE DATABASE IF NOT EXISTS db_pweb1_carvows;
USE db_pweb1_carvows;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL DEFAULT 'Vendedor'
);

INSERT INTO usuario (nome, telefone, email, login, senha, tipo) VALUES 
('Administrador Padrão', '(49) 99999-9999', 'admin@carvows.com', 'admin', '$2y$10$i7Bq2CgO0E3D1z9pG7hJ1eKzXG9wY6V8Q8Y0U6M5R4E3W2Q1Z.TaS', 'Administrador');

CREATE TABLE loja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_unidade VARCHAR(100) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

CREATE TABLE veiculo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(50) NOT NULL,
    marca VARCHAR(30) NOT NULL,
    ano_fabricacao INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    cor VARCHAR(20) NOT NULL,
    foto VARCHAR(255) DEFAULT 'sem-foto.jpg'
);

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    cidade VARCHAR(50) NOT NULL,
    celular VARCHAR(20) NOT NULL
);

CREATE TABLE venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_venda DATE NOT NULL,
    valor_final DECIMAL(10,2) NOT NULL,
    comissao_vendedor DECIMAL(10,2) NOT NULL,
    usuario_id INT NOT NULL,
    cliente_id INT NOT NULL,
    veiculo_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (veiculo_id) REFERENCES veiculo(id)
)