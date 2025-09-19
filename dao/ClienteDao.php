<?php
require_once(__DIR__ . "/../util/Connection.php");

class ClienteDao {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();        
    }

    public function listar() {
        $sql = "SELECT * FROM cliente";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function inserir(Cliente $cliente) {
    try {
        $sql = "INSERT INTO cliente (id_cliente, cpf, telefone, nome, endereco, possui_acompanhante, data_cadastro, id_funcionario) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $idFuncionario = NULL;
            if ($cliente->getFuncionario() !== NULL) {
                $idFuncionario = $cliente->getFuncionario()->getIdFuncionario();
            }
        $stmt->execute([
            $cliente->getIdCliente(),
            $cliente->getCpf(),
            $cliente->getTelefone(),
            $cliente->getNome(),
            $cliente->getEndereco(),
            $cliente->getPossuiAcompanhante(),
            $cliente->getDataCadastro(),
            $idFuncionario()
        ]);
        return null;
    } catch (PDOException $e) {
        return "erro erro erro" .$e->getMessage;
    }
}

    public function buscarPorId(int $id) {
        $sql = "SELECT c.* FROM cliente c WHERE c.id_cliente = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientes = $this->map($result);

        if (count($clientes) > 0)
            return $clientes[0];
        else
            return null;
    }

    private function map(array $rows) {
        // Retorna os próprios arrays, adapte para objetos se necessário.
        return $rows;
    }
}