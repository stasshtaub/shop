<?
require_once ROOT_DIR . "/Core/DB.php";
class cartModel
{
    private $DB;
    private $uid;

    function __construct($uid)
    {
        $this->DB = new DB();
        $this->uid = $uid;
    }

    function add($pid)
    {
        if ($this->checkInCart($pid)) {
            throw new \Exception("ALLREADY_IN_CART");
        } else {
            $query = "INSERT INTO cart (user, product) VALUE (:user, :product)";
            $params = [
                "user" => $this->uid,
                "product" => $pid
            ];
            $this->DB->execute($query, $params);
            $query = "SELECT product.id pid, product.name, product.price, product.count count_product, cart.count quantity, picture.img FROM cart JOIN product ON cart.product=product.id JOIN picture ON product.main_picture=picture.id WHERE cart.user=$this->uid AND cart.product=$pid";
            return $this->DB->execute($query)[0];
            // $new_cart_item_id = $this->DB->insert("cart", ["user" => $this->uid, "product" => $pid]);
            // $query = "SELECT product.id pid, product.name, product.price, product.count count_product, cart.count quantity, picture.img FROM cart JOIN product ON cart.product=product.id JOIN picture ON product.main_picture=picture.id WHERE cart.id=$new_cart_item_id";
            // return $this->DB->select($query)[0];
        }
    }

    function remove($pid)
    {
        if ($this->checkInCart($pid)) {
            $query = "DELETE FROM cart WHERE product=:pid AND user=:uid";
            $params = [
                "pid" => $pid,
                "uid" => $this->uid
            ];
            return $this->DB->execute($query, $params);
            // return $this->DB->remove("cart", "product=$pid AND user=$this->uid");
        } else {
            throw new \Exception("NOT_FOUND_IN_CART");
        }
    }

    function changeCount($pid, $newCount)
    {
        $foundProduct = $this->checkInCart($pid);
        if ($foundProduct) {
            if (1 <= $newCount && $newCount <= $foundProduct["count_product"]) {
                $query = "UPDATE cart SET count=:newCount WHERE user=:uid AND product=:pid";
                $params = [
                    "newCount" => $newCount,
                    "uid" => $this->uid,
                    "pid" => $pid
                ];
                return $this->DB->execute($query, $params);
                // return $this->DB->update("cart", ["count" => $newCount], "user=$this->uid AND product=$pid");
            } else {
                throw new \Exception("NOT_VALID_COUNT");
            }
        } else {
            throw new \Exception("NOT_FOUND_IN_CART");
        }
    }

    function getCart()
    {
        $query = "SELECT cart.id cart_id, product.id pid, product.name, product.price, product.count count_product, cart.count quantity, picture.img FROM cart JOIN product ON cart.product=product.id JOIN picture ON product.main_picture=picture.id WHERE cart.user=$this->uid ORDER BY cart_id";
        return $this->DB->execute($query);
        // return $this->DB->select("SELECT cart.id cart_id, product.id pid, product.name, product.price, product.count count_product, cart.count quantity, picture.img FROM cart JOIN product ON cart.product=product.id JOIN picture ON product.main_picture=picture.id WHERE cart.user=$this->uid ORDER BY cart_id");
    }

    /** Проверяет есть ли в корзине товар
     * @param int $pid id товара
     * @return array|false если найден - массив с данными товара, иначе - false
     */
    function checkInCart($pid)
    {
        $query = "SELECT product.id pid, product.name, product.price, product.count count_product, cart.count count_in_cart, picture.img FROM cart JOIN product ON cart.product=product.id JOIN picture ON product.main_picture=picture.id WHERE product.id=$pid AND cart.user=$this->uid";
        $result = $this->DB->execute($query);
        if (!empty($result)) {
            return $result[0];
        }

        // $result = $this->DB->select($query);
        // if (!empty($result)) {
        //     return $result[0];
        // }
        // return false;
    }
}
