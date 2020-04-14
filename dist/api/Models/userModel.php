<?
require_once ROOT_DIR . "/Core/DB.php";
class userModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    function getData($token)
    {
        $query = "SELECT user.id, user.name, user.login, replace(user.avatar,'''','') avatar FROM user WHERE cookie='$token'";
        $result = $this->DB->execute($query);
        if (!empty($result)) {
            return $result[0];
        } else {
            throw new \Exception("BAD_TOKEN");
        }
    }
}
