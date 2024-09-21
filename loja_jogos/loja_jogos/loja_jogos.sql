CREATE DATABASE IF NOT EXISTS loja_jogos;
USE loja_jogos;

-- Tabela de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefone VARCHAR(15)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Fornecedores
CREATE TABLE fornecedores (
    id_fornecedor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Jogos
CREATE TABLE jogos (
    id_jogo INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) DEFAULT NULL,
    plataforma VARCHAR(50) DEFAULT NULL,
    preco DECIMAL(10,2) DEFAULT NULL,
    quantidade_estoque INT(11) DEFAULT NULL,
    id_fornecedor INT(11) DEFAULT NULL,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id_fornecedor) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Vendas
CREATE TABLE vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT(11) DEFAULT NULL,
    id_jogo INT(11) DEFAULT NULL,
    quantidade INT(11) DEFAULT NULL,
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
    preco_total DECIMAL(10,2) DEFAULT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_jogo) REFERENCES jogos(id_jogo) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de Relatórios
CREATE TABLE relatorios (
    id_relatorio INT AUTO_INCREMENT PRIMARY KEY,
    tipo_relatorio ENUM('vendas', 'jogos') NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    dados TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
