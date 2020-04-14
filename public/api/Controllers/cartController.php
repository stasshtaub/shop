<?
require_once ROOT_DIR . "/Models/cartModel.php";
require_once ROOT_DIR . "/Models/autchModel.php";
class cartController
{
    private $model;
    function __construct()
    {
        $headers = getallheaders();
        if (!empty($headers["authorization"]) || !empty($headers["Authorization"])) {
            $token = !empty($headers["authorization"]) ? $headers["authorization"] : $headers["Authorization"];
            require_once ROOT_DIR . "/Models/userModel.php";
            $autch = new autchModel();
            if ($uid = $autch->check(null, null, $token)) {
                $this->model = new cartModel($uid);
            } else {
                http_response_code(401);
                throw new \Exception("NOT_FOUND_USER_WITH_TOKEN ($token)");
            }
        } else {
            http_response_code(401);
            throw new \Exception("NOT_FOUND_TOKEN");
        }
    }

    function POST($pid)
    {
        try {
            $result['item'] = $this->model->add($pid);
            $result['status'] = 'OK';
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }

    function DELETE($pid)
    {
        try {
            $res = $this->model->remove($pid);
            if ($res) {
                $result['status'] = 'OK';
            }
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }

    function PATCH($pid, $newCount)
    {
        try {
            http_response_code(201);
            $this->model->changeCount($pid, $newCount);
            $result['status'] = 'OK';
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }

    function GET()
    {
        try {
            $result['status'] = 'OK';
            $result['items'] = $this->model->getCart();
            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $result['status'] = $e->getMessage();
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }
}
