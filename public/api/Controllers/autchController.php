<?
require_once ROOT_DIR . "/Models/autchModel.php";
class autchController
{
    private $model;
    function __construct()
    {
        $this->model = new autchModel();
    }

    function POST($login, $password)
    {
        try {
            $result = $this->model->autch($login, $password);
            $result['status'] = "OK";
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
