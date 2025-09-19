<?php
require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/Funcionario.php");

class FuncionarioDao
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Connection::getConnection();
    }

    public function listar()
    {
        $sql = "SELECT * FROM funcionario ORDER BY nome";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $funcionarios = $this->map($resultado);
        return $funcionarios;
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM funcionario WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function map($resultado)
    {
        $funcionarios = array();
        foreach ($resultado as $r) {
            $funcionario = new Funcionario();
            $funcionario->setIdFuncionario($r['id_funcionario']);
            $funcionario->setMatricula($r['matricula']);
            $funcionario->setNome($r['nome']);
            $funcionario->setCargo($r['cargo']);
            $funcionario->setDepartamento($r['departamento']);
            $funcionario->setEmail($r['email']);
            $funcionario->setTelefone($r['telefone']);
            $funcionario->setDataAdmissao($r['data_admissao']);

            array_push($funcionarios, $funcionario);
        }

        return $funcionarios;
    }
}
