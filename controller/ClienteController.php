    <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once(__DIR__ . "/../dao/ClienteDao.php");
    require_once(__DIR__ . "/../service/ClienteService.php");

    class ClienteController{
        private ClienteDao $clienteDAO;
        private ClienteService $clienteService;

        public function __construct(){
            $this->clienteDAO = new ClienteDAO();
            $this->clienteService = new ClienteService($this->clienteDAO);
        }
        public function buscarPorId(int $id){
            return $this->clienteDAO->buscarPorId($id);
        }
        public function listarClientes(){
            $lista = $this->clienteDAO->listar();
            return $lista;
        }
        public function inserir(Cliente $cliente){
            $erros = $this->clienteService->validarCliente($cliente);
            if (count($erros)>0) {
                return $erros;
            }
            $erro = $this->clienteDAO->inserir($cliente);
            if ($erro) {
                array_push($erros,"Erro ao salvar Cliente");
            }
            return $erros;
        }
    }