<?
class DB
{
    public $pdo;
    private $host = "localhost",
        $user = "root",
        $password = "root",
        $db_name = "magazin",
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=UTF8";
        $this->pdo = new PDO($dsn, $this->user, $this->password, $this->opt);
    }

    public function execute($query, array $params = null)
    {
        if (is_null($params)) {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll();
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll() || $stmt;
    }
}
