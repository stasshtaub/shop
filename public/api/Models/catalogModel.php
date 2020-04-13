<?
require_once ROOT_DIR . "/Core/DB.php";
class catalogModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    /**
     * Возвращает все товары из БД
     * @return array массив товаров
     */
    function getAllProduct()
    {
        $query = "SELECT product.id pid, product.name, product.price, picture.img FROM product JOIN picture ON product.main_picture=picture.id WHERE count>0 ORDER BY pid";
        return $this->DB->execute($query);
    }

    function search($search_query)
    {
        $query = "SELECT name, img FROM product JOIN picture ON product.main_picture=picture.id WHERE count>0 AND name LIKE '%$search_query%'";
        return $this->DB->execute($query);
    }
}
