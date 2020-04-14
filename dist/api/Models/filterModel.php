<?
require_once ROOT_DIR . "/Core/DB.php";
class filterModel
{
    private $DB;
    function __construct()
    {
        $this->DB = new DB();
    }

    /**
     * Возвращает список фильтров из БД
     * @return array массив товаров
     */
    function getFilters()
    {
        $query_category = "SELECT * FROM category";
        $categories = $this->DB->execute($query_category);
        $query_color = "SELECT * FROM color";
        $colors = $this->DB->execute($query_color);
        return [
            "category" => [
                "name" => "Категория",
                "values" => $categories
            ],
            "color" => [
                "name" => "Цвет",
                "values" => $colors
            ],
        ];
    }

    function search($search_query)
    {
        $query = "SELECT name, img FROM product JOIN picture ON product.main_picture=picture.id WHERE count>0 AND name LIKE '%$search_query%'";
        return $this->DB->execute($query);
    }
}
