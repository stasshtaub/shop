<?
require_once ROOT_DIR . "/Core/DB.php";
require_once ROOT_DIR . "/Models/userModel.php";
require_once ROOT_DIR . "/Core/Token.php";
class autchModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    /** Авторизирует пользователя
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     * @return array массив данных пользователя
     * @throws \Exception пользователь не найден
     */
    function autch($login, $password)
    {
        if ($user_id = $this->check($login, $password)) {
            $token = Token::generateToken();
            $query = "UPDATE user SET cookie=:token WHERE id=:id";
            $params = [
                "token" => $token,
                "id" => $user_id
            ];
            $this->DB->execute($query, $params);

            $user = new userModel();
            return [
                "token" => $token,
                "profile" => $user->getData($token)
            ];
        } else {
            throw new \Exception("USER_NOT_FOUND");
        }
    }

    /** Проверяет, есть ли пользователь в БД
     * @param string $login логин пользователя
     * @param string $password пароль пользователя
     * @param string $token ключ из куки
     * @return int|null если пользователь найден - id, иначе - null
     * @throws \Exception
     */
    function check($login = null, $password = null, $token = null)
    {
        if ($login && $password || $token) {
            if ($password) {
                $md5salt = md5($password . 'web-progr');
            }
            $query = "SELECT id FROM user WHERE " . ($login && $password ? "login='$login' AND password='$md5salt'" : "cookie='$token'");
            $user = ($this->DB->execute($query));
            return !empty($user) ? $user[0]['id'] : null;
        } else {
            throw new Exception("INVALID_USERNAME_AND_PASSWORD_OR_TOKEN");
        }
    }

    function generateToken($input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $strength = 8)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }
}
