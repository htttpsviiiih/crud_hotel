    <?php
    require_once(__DIR__ . "/../dao/ClienteDao.php");
    require_once(__DIR__ . "/../dao/FuncionarioDao.php");

    class FuncionarioController{
        private FuncionarioDao $funcionarioDao;
        //private FuncionarioService $clienteService;

        public function __construct(){
            $this->funcionarioDao = new FuncionarioDao();
        }
        public function listar(){
            $lista = $this->funcionarioDao->listar();
            return $lista;
        }
    }