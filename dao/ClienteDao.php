<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/Cliente.php");
require_once(__DIR__ . "/../model/Funcionario.php");
require_once(__DIR__ . "/../model/Pacote.php");


class ClienteDao
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Connection::getConnection();
    }

    public function listar()
    {
        $sql = "SELECT c.*, f.nome AS nome_funcionario, p.descricao AS descricao_pacote
            FROM cliente c
            LEFT JOIN funcionario f ON c.id_funcionario = f.id_funcionario
            LEFT JOIN pacote p ON c.id_pacote = p.id_pacote";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($result);
    }


    public function inserir(Cliente $cliente)
    {
        $sql = "INSERT INTO cliente (cpf, telefone, nome, endereco, possui_acompanhante, data_cadastro, id_funcionario, id_pacote)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->conexao->prepare($sql);
            $idFuncionario = $cliente->getFuncionario() ? $cliente->getFuncionario()->getIdFuncionario() : NULL;

            $idPacote = $cliente->getPacote() ? $cliente->getPacote()->getIdPacote() : NULL;

            $valores = [
                $cliente->getCpf(),
                $cliente->getTelefone(),
                $cliente->getNome(),
                $cliente->getEndereco(),
                $cliente->getPossuiAcompanhante(),
                $cliente->getDataCadastro(),
                $idFuncionario,
                $idPacote
            ];
            $stmt->execute($valores);
            return NULL;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }



    public function buscarPorId(int $id)
    {
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

    private function map(array $rows)
    {
        $clientes = [];
        foreach ($rows as $row) {
            $cliente = new Cliente();
            $cliente->setIdCliente($row['id_cliente']);
            $cliente->setCpf($row['cpf']);
            $cliente->setTelefone($row['telefone']);
            $cliente->setNome($row['nome']);
            $cliente->setEndereco($row['endereco']);
            $cliente->setPossuiAcompanhante($row['possui_acompanhante']);
            $cliente->setDataCadastro($row['data_cadastro']);

            // funcionário
            if (!empty($row['id_funcionario'])) {
                $func = new Funcionario();
                $func->setIdFuncionario($row['id_funcionario']);
                $func->setNome($row['nome_funcionario']);
                $cliente->setFuncionario($func);
            } else {
                $cliente->setFuncionario(null);
            }

            // pacote
            if (!empty($row['id_pacote'])) {
                $pacote = new Pacote();
                $pacote->setIdPacote($row['id_pacote']);
                $pacote->setDescricao($row['descricao_pacote']); 
                $cliente->setPacote($pacote);
            } else {
                $cliente->setPacote(null);
            }

            $clientes[] = $cliente;
        }
        return $clientes;
    }
}
