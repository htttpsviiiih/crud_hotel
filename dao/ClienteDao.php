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
        $sql = "SELECT c.*, f.nome AS nome_funcionario, p.nome_pacote AS nome_pacote
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


        $sql = "INSERT INTO cliente 
            (cpf, telefone, nome, endereco, possui_acompanhante, id_funcionario, id_pacote, data_cadastro)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->conexao->prepare($sql);

            $idFuncionario = $cliente->getFuncionario() ? $cliente->getFuncionario()->getIdFuncionario() : null;
            $idPacote = $cliente->getPacote() ? $cliente->getPacote()->getIdPacote() : null;

            // Se não houver data_cadastro, usar NOW()
            $dataCadastro = $cliente->getDataCadastro() ?: date('Y-m-d');

            $valores = [
                $cliente->getCpf(),
                $cliente->getTelefone(),
                $cliente->getNome(),
                $cliente->getEndereco(),
                $cliente->getPossuiAcompanhante(),
                $idFuncionario,
                $idPacote,
                $dataCadastro
            ];
            $stmt->execute($valores);
        } catch (PDOException $e) {
            return "Erro ao inserir cliente: " . $e->getMessage();
        }
    }

    public function alterar(Cliente $cliente)
    {

        $sql = "UPDATE cliente SET cpf = ?, nome = ?, telefone = ?,
                        endereco = ?, possui_acompanhante = ?,
                        id_funcionario = ?, id_pacote = ?,
                        data_cadastro = ?
                    WHERE id_cliente = ?";

        try {
            $stmt = $this->conexao->prepare($sql);

            $idFuncionario = $cliente->getFuncionario() ? $cliente->getFuncionario()->getIdFuncionario() : null;
            $idPacote = $cliente->getPacote() ? $cliente->getPacote()->getIdPacote() : null;


            $dataCadastro = $cliente->getDataCadastro() ?: date('Y-m-d');

            $valores = [
                $cliente->getCpf(),
                $cliente->getNome(),
                $cliente->getTelefone(),
                $cliente->getEndereco(),
                $cliente->getPossuiAcompanhante(),
                $idFuncionario,
                $idPacote,
                $dataCadastro,
                $cliente->getIdCliente()
            ];
            if ($stmt->execute($valores)) {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erro ao inserir cliente: " . $e->getMessage();
            return false;
        }
    }


    public function buscarPorId($id)
    {
        $sql = "SELECT c.*, f.nome AS nome_funcionario, p.nome_pacote AS nome_pacote, p.descricao AS descricao_pacote, p.preco AS preco_pacote
        FROM cliente c
        LEFT JOIN funcionario f ON c.id_funcionario = f.id_funcionario
        LEFT JOIN pacote p ON c.id_pacote = p.id_pacote
        WHERE c.id_cliente = :id_cliente";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id_cliente', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientes = $this->map($result);

        if (count($clientes) > 0)
            return $clientes[0];
        else
            return null;
    }
    public function buscarPorCpf($cpf): ?Cliente
    {
        $sql = "SELECT * FROM cliente WHERE cpf = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$cpf]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->map([$row])[0];
        }
        return null;
    }
    public function excluir(int $id)
    {
        $sql = "DELETE FROM cliente WHERE id_cliente = :id_cliente";
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":id_cliente", $id);
            $stmt->execute();
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function map(array $rows)
    {
        $clientes = [];
        foreach ($rows as $row) {

            $date = new DateTime($row['data_cadastro']);
            $date = $date->format('Y-m-d');


            $cliente = new Cliente();
            $cliente->setIdCliente((int)$row['id_cliente']);
            $cliente->setCpf($row['cpf']);
            $cliente->setTelefone($row['telefone']);
            $cliente->setNome($row['nome']);
            $cliente->setEndereco($row['endereco']);
            $cliente->setPossuiAcompanhante($row['possui_acompanhante']);


            $cliente->setDataCadastro($date);

            // funcionário
            $func = new Funcionario();
            $func->setIdFuncionario($row['id_funcionario']);
            $func->setNome($row['nome']);
            $cliente->setFuncionario($func);

            // pacote
            $pacote = new Pacote();
            $pacote->setIdPacote($row['id_pacote']);
            $pacote->setNomePacote($row['nome_pacote']);
            if (isset($row['descricao_pacote'])) {
                $pacote->setDescricao($row['descricao_pacote']);
            }
            if (isset($row['preco_pacote'])) {
                $pacote->setPreco($row['preco_pacote']);
            }
            $cliente->setPacote($pacote);

            $clientes[] = $cliente;
        }
        return $clientes;
    }
}
