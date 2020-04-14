<?
require_once ROOT_DIR . "/Core/DB.php";
require_once ROOT_DIR . "/Models/userModel.php";
require_once ROOT_DIR . "/Core/Token.php";
class registrationModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    /** Регистрирует пользователя
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     * @return array массив данных пользователя
     * @throws \Exception пользователь не найден
     */
    function register($login, $password, $name)
    {
        if ($this->checkLogin($login)) {
            $token = Token::generateToken();
            $query = "INSERT INTO user (login, password, name, cookie) VALUE (:login, :password, :name, :cookie)";
            $params = [
                "login" => $login,
                "password" => md5($password . 'web-progr'),
                "name" => $name,
                "cookie" => $token
            ];
            $this->DB->execute($query, $params);
            $user = new userModel();
            return [
                "profile" => $user->getData($token),
                "token" => $token
            ];
        } else {
            throw new \Exception("USER_ALREADY_EXIST");
        }
    }

    /** Проверяет, свободен ли логин
     * @param string $login логин пользователя
     * @return bool true если свободен, false если нет
     * @throws \Exception
     */
    function checkLogin($login)
    {
        $query = "SELECT id FROM user WHERE login='$login'";
        $user = ($this->DB->execute($query));
        return empty($user[0]['id']) ? true : false;
    }
}
