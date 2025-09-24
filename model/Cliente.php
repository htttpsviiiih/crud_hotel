<?php
class Cliente {
    private $id_cliente;
    private $cpf;
    private $telefone;
    private $nome;
    private $endereco;
    private $possui_acompanhante;
    private $data_cadastro;
    private ?Pacote $pacote;
    private ?Funcionario $funcionario;

    // Getters e Setters
    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function getPossuiAcompanhante() {
        return $this->possui_acompanhante;
    }

    public function setPossuiAcompanhante($possui_acompanhante) {
        $this->possui_acompanhante = $possui_acompanhante;
    }

    public function getDataCadastro() {
        return $this->data_cadastro;
    }

    public function setDataCadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }
    /**
     * Get the value of pacote
     */
    public function getPacote(): ?Pacote
    {
        return $this->pacote;
    }

    /**
     * Set the value of pacote
     */
    public function setPacote(?Pacote $pacote): self
    {
        $this->pacote = $pacote;

        return $this;
    }

    /**
     * Get the value of funcionario
     */
    public function getFuncionario(): ?Funcionario
    {
        return $this->funcionario;
    }

    /**
     * Set the value of funcionario
     */
    public function setFuncionario(?Funcionario $funcionario): self
    {
        $this->funcionario = $funcionario;

        return $this;
    }
}

   
