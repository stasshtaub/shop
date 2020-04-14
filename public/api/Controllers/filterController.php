<?
require_once ROOT_DIR . "/Models/filterModel.php";
class filterController
{
    private $model;
    function __construct()
    {
        $this->model = new filterModel();
    }

    function GET()
    {
        try {
            $result['filters'] = $this->model->getFilters();
            $result['status'] = 'OK';
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
