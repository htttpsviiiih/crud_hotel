<?php

class ClienteService
{
    private $clienteDAO;


    public function __construct($clienteDAO)
    {
        $this->clienteDAO = $clienteDAO;
    }
    public function validarCliente($cliente)
    {
        $erros = array();

        if (!$cliente->getNome()) {
            array_push($erros, "Informe o nome do cliente!");
        }

        if (!$cliente->getTelefone()) {
            array_push($erros, "Informe o telefone do cliente!");
        } else if (!preg_match('/^\d{11}$/', $cliente->getTelefone())) {
            array_push($erros, "O telefone deve conter no máximo 11 dígitos numéricos.");
        }

        if (!$cliente->getEndereco()) {
            array_push($erros, "Informe o endereço do cliente!");
        }
        if (!$cliente->getCpf()) {
            array_push($erros, "Informe o CPF do cliente!");
        } else if (!preg_match('/^\d{11}$/', $cliente->getCpf())) {
            array_push($erros, "O CPF deve conter exatamente 11 dígitos numéricos.");
        }

        $cpfExistente = $this->clienteDAO->buscarPorCpf($cliente->getCpf());

        if ($cpfExistente && $cpfExistente->getIdCliente() != $cliente->getIdCliente()) {
            array_push($erros, "O CPF informado já está cadastrado para outro cliente!");
        }

        if (!$cliente->getPossuiAcompanhante() || !in_array($cliente->getPossuiAcompanhante(), ['S', 'N'])) {
            array_push($erros, "Informe se o cliente possui acompanhante (Sim ou Não)!");
        }

        if (!$cliente->getDataCadastro()) {
            array_push($erros, "Informe a data de cadastro do cliente!");
        } else {
            $dataAtual = date('Y-m-d');
            if ($cliente->getDataCadastro() > $dataAtual) {
                array_push($erros, "A data de cadastro não pode ser futura!");
            }
        }
        if (!$cliente->getFuncionario()) {
            array_push($erros, "Selecione um funcionário para o cliente!");
        }

        if (!$cliente->getPacote()) {
            array_push($erros, "Selecione um pacote para o cliente!");
        }

        return $erros;
    }
}
