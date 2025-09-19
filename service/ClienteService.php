<?php

class ClienteService {
    private $clienteDAO;

    public function __construct($clienteDAO) {
        $this->clienteDAO = $clienteDAO;
    }

    public function validarCliente($cliente) {
        $erros = array();

        if (!$cliente->getNome()) {
            array_push($erros, "Informe o nome do cliente!");
        }

        if (!$cliente->getEmail()) {
            array_push($erros, "Informe o email do cliente!");
        }

        if (!$cliente->getTelefone()) {
            array_push($erros, "Informe o telefone do cliente!");
        }

        if (!$cliente->getEndereco()) {
            array_push($erros, "Informe o endereço do cliente!");
        }

        return $erros;
    }
}