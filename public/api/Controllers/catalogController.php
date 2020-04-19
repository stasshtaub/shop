<?
require_once ROOT_DIR . "/Models/catalogModel.php";
class catalogController
{
    private $model;
    function __construct()
    {
        $this->model = new catalogModel();
    }

    function GET($filters = null, $searchQuery = null)
    {
        $filters = $filters ? json_decode($filters, true) : $filters;
        try {
            if ($searchQuery) {
                $result['data'] = $this->model->search($searchQuery);
            } else {
                $result['data'] = $this->model->getProducts($filters);
            }
            $result['status'] = 'OK';
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
