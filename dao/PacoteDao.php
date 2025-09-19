<?php
require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/Pacote.php");

class PacoteDao {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();        
    }
    public function listar()
    {
        $sql = "SELECT * FROM pacote ORDER BY nome_pacote";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $pacotes = $this->map($resultado);  
        return $pacotes;
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM pacote WHERE id_pacote = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function map($resultado)
    {
        $pacotes = array();
        foreach ($resultado as $r) {
            $pacote = new Pacote();
            $pacote->setIdPacote($r['id_pacote']);
            $pacote->setNomePacote($r['nome_pacote']);
            $pacote->setDescricao($r['descricao']);
            $pacote->setPreco($r['preco']);
            $pacote->setDuracaoDias($r['duracao_dias']);

            array_push($pacotes, $pacote);
        }
        return $pacotes;
    }
}