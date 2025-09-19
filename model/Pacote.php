<?php
class Pacote {
    private $id_pacote;
    private $nome_pacote;
    private $descricao;
    private $preco;
    private $duracao_dias;

    // Getters e Setters
    public function getIdPacote() {
        return $this->id_pacote;
    }

    public function setIdPacote($id_pacote) {
        $this->id_pacote = $id_pacote;
    }

    public function getNomePacote() {
        return $this->nome_pacote;
    }

    public function setNomePacote($nome_pacote) {
        $this->nome_pacote = $nome_pacote;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function getDuracaoDias() {
        return $this->duracao_dias;
    }

    public function setDuracaoDias($duracao_dias) {
        $this->duracao_dias = $duracao_dias;
    }
}
?>