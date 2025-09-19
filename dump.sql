CREATE TABLE cliente (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    possui_acompanhante CHAR(1) NOT NULL CHECK (possui_acompanhante IN ('S', 'N')),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela Funcionario (dados fixos)
CREATE TABLE funcionario (
    id_funcionario INT PRIMARY KEY AUTO_INCREMENT,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(50) NOT NULL,
    departamento VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    data_admissao DATE NOT NULL
);

-- Tabela Pacote (dados fixos)
CREATE TABLE pacote (
    id_pacote INT PRIMARY KEY AUTO_INCREMENT,
    nome_pacote VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    duracao_dias INT NOT NULL
);
-- Inserir funcionários fixos
INSERT INTO funcionario (matricula, nome, cargo, departamento, email, telefone, data_admissao) VALUES
('FUNC001', 'Daniel Domenico', 'Consultor de Viagens', 'Vendas', 'daniel.domenico@empresa.com', '11987654321', '2023-01-15'),
('FUNC002', 'Ana Carolina Silva', 'Gerente de Vendas', 'Vendas', 'ana.silva@empresa.com', '11912345678', '2022-03-10'),
('FUNC003', 'Carlos Eduardo Santos', 'Atendente', 'Atendimento', 'carlos.santos@empresa.com', '11923456789', '2023-05-20'),
('FUNC004', 'Mariana Oliveira', 'Coordenadora de Pacotes', 'Operações', 'mariana.oliveira@empresa.com', '11934567890', '2021-11-08'),
('FUNC005', 'Ricardo Almeida', 'Consultor Sênior', 'Vendas', 'ricardo.almeida@empresa.com', '11945678901', '2022-08-12'),
('FUNC006', 'Juliana Costa', 'Supervisora de Atendimento', 'Atendimento', 'juliana.costa@empresa.com', '11956789012', '2023-02-28');

-- Inserir pacotes fixos
INSERT INTO pacote (nome_pacote, descricao, preco, duracao_dias) VALUES
('Pacote Praia Premium', 'Inclui hospedagem 5 estrelas com all inclusive', 2500.00, 7),
('Pacote Aventura', 'Trilhas, rapel e atividades radicais', 1800.00, 5),
('Pacote Romântico', 'Para casais, com jantar a luz de velas', 2200.00, 4),
('Pacote Cultural', 'Visitas a museus e pontos históricos', 1500.00, 6),
('Pacote Família', 'Atividades para todas as idades', 1900.00, 5),
('Pacote Luxo', 'Experiência premium com serviços exclusivos', 3500.00, 6);

ALTER TABLE cliente ADD COLUMN id_funcionario INT;

ALTER TABLE cliente 
ADD CONSTRAINT fk_cliente_funcionario 
FOREIGN KEY (id_funcionario) 
REFERENCES funcionario(id_funcionario);