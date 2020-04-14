<?
require_once ROOT_DIR . "/Models/userModel.php";
class userController
{
    private $model;
    function __construct()
    {
        $this->model = new userModel();
    }

    function GET()
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            try {
                $result['status'] = "OK";
                $result['profile'] = $this->model->getData($token);
                echo json_encode($result, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $result['status'] = $e->getMessage();
                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        } else {
            $result['status'] = "NOT_FOUND_TOKEN";
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
