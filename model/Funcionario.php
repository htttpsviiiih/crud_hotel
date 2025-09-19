<?php
class Funcionario {
    private $id_funcionario;
    private $matricula;
    private $nome;
    private $cargo;
    private $departamento;
    private $email;
    private $telefone;
    private $data_admissao;

    public function __toString() {
        return $this->nome;
    }

    public function getIdFuncionario() {
        return $this->id_funcionario;
    }

    public function setIdFuncionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getDataAdmissao() {
        return $this->data_admissao;
    }

    public function setDataAdmissao($data_admissao) {
        $this->data_admissao = $data_admissao;
    }

}
?>