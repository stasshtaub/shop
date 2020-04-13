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
        if (!empty($headers["Authorization"])) {
            $token = $headers["Authorization"];
            try {
                $result['status'] = "OK";
                $result['profile'] = $this->model->getData($token);
                echo json_encode($result, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $result['status'] = $e->getMessage();
                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        } else {
            http_response_code(401);
            $result['status'] = "NOT_FOUND_TOKEN";
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
