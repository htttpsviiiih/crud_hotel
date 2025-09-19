<?php
require_once(__DIR__ . "/../dao/ClienteDao.php");
require_once(__DIR__ . "/../dao/PacoteDao.php");

class PacoteController{
    private PacoteDao $PacoteDao;

    public function __construct(){
        $this->PacoteDao = new PacoteDao();
    }
    public function listar(){
        $lista = $this->PacoteDao->listar();
        return $lista;
    }   
}