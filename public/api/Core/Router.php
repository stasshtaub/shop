<?
class Router
{
    static function start()
    {
        $url_arr = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($url_arr[2])) {
            $controllerName = $url_arr[2] . "Controller";
            $controllerPath = ROOT_DIR . "/Controllers/" . $controllerName . ".php";
            $action = $_SERVER["REQUEST_METHOD"];
            
            $params = !empty($_POST) ? $_POST : $_GET;
            if ($action == "PATCH") {
                parse_str(file_get_contents('php://input'), $params);
            }

            if (file_exists($controllerPath)) {
                require_once $controllerPath;
            } else {
                echo "Не найден файл контроллера: $controllerPath";
                exit();
            }

            if (class_exists($controllerName)) {
                $controller = new $controllerName;
            } else {
                echo "Класс '$controllerName' не существует";
                exit();
            }

            if (method_exists($controller, $action)) {
                try {
                    call_user_func_array(array($controller, $action), $params);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit();
                }
            } else {
                echo "Метод '$action' в классе '$controllerName' не существует";
                exit();
            }
        } else {
            echo "Не задан controller и/или action";
            exit();
        }
    }
}
