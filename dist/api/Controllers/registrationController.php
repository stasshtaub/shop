<?
require_once ROOT_DIR . "/Models/registrationModel.php";
require_once ROOT_DIR . "/Core/Captcha.php";
class registrationController
{
    private $model;
    function __construct()
    {
        $this->model = new registrationModel();
    }

    function POST($login, $password, $confirmPassword, $name, $grecaptcha)
    {
        $validateError = $this->validateRegData($login, $password, $confirmPassword, $name, $grecaptcha);
        if (empty($validateError)) {
            try {
                $result = $this->model->register($login, $password, $name);
                $result["status"] = "OK";
                echo json_encode($result, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $result["status"] = $e->getMessage();
                echo json_encode($result, JSON_PRETTY_PRINT);
            }
        } else {
            $result["status"] = "VALIDATE_ERROR";
            $result["errors"] = $validateError;
            echo json_encode($result, JSON_PRETTY_PRINT);
        }
    }

    function validateRegData($login, $password, $confirmPassword, $name, $grecaptcha)
    {
        $errors = [];
        if (strlen($login) < 6) {
            $errors["login"] = "Не меньше 6 символов";
        }
        if (strlen($password) < 6) {
            $errors["password"] = "Не меньше 6 символов";
        } else if ($password != $confirmPassword) {
            $errors["confirmPassword"] = "Пароли не совпадают";
        }
        if (!strlen($name)) {
            $errors["name"] = "Введите имя";
        }
        if (!Captcha::check($grecaptcha)) {
            $errors["captcha"] = "Неверная каптча";
        }
        return $errors;
    }
}
