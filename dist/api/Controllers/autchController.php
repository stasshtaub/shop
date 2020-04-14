<?
require_once ROOT_DIR . "/Models/autchModel.php";
require_once ROOT_DIR . "/Core/Captcha.php";
class autchController
{
    private $model;
    function __construct()
    {
        $this->model = new autchModel();
    }

    function POST($login, $password, $grecaptcha)
    {
        $validateError = $this->validateAutchData($login, $password, $grecaptcha);
        if (empty($validateError)) {
            try {
                $result = $this->model->autch($login, $password);
                $result['status'] = "OK";
                echo json_encode($result, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $result['status'] = $e->getMessage();
                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        } else {
            $result["status"] = "VALIDATE_ERROR";
            $result["errors"] = $validateError;
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }


    function validateAutchData($login, $password, $grecaptcha)
    {
        $errors = [];
        if (strlen($login) == 0) {
            $errors["login"] = "Введите логин";
        }
        if (strlen($password) == 0) {
            $errors["password"] = "Введите пароль";
        }
        if (!Captcha::check($grecaptcha)) {
            $errors["captcha"] = "Неверная каптча";
        }
        return $errors;
    }
}
