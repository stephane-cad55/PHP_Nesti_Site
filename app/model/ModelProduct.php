<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelProduct
{
    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM product ";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Product');
        } else {
            $array = [];
        }

        return $array;
    }

    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM product where $parameter = '$value'";

        $result = $pdo->query($sql);

        $data = $result->fetch(PDO::FETCH_ASSOC);

        if ($data) {

            $product = new Product();
            $product->setProductFromArray($data);
        } else {
            $product = [];
        }
        return $product;
    }

    public function findChildType($table, $type, $value)
    {
        $pdo = Connection::getPdo();
        $sql = "SELECT * FROM $table WHERE id" . ucfirst($type) . "= $value";

        $result = $pdo->query($sql);
        $data = $result->fetch();
        return $data;
    }

    /**requete insertion id et nom ingredient supplementaire
     */
    public function createProduct($name)
    {
        $pdo = Connection::getPdo();
        try {
            // Create prepared statement
            $sql = "INSERT INTO product (name) VALUES (?)";

            $stmt = $pdo->prepare($sql);

            $values = [$name];
            // Execute the prepared statement
            $success = $stmt->execute($values);
            $newProduct = $this->readOneBy("idProduct", $pdo->lastInsertId());
            echo "Records inserted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        return $newProduct;
    }
}
