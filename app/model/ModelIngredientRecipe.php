<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelIngredientRecipe
{

    public function readAllIngredientByRecipe($idRecipe)
    {
        $pdo = Connection::getPdo();

        $sql = "SELECT\n" . "    p.name AS nameIngredient, u.name AS nameUnit, ir.quantity\n" . "FROM\n"
            . "    ingredientrecipe ir\n"
            . "LEFT JOIN product p ON\n"
            . "    ir.idProduct = p.idProduct\n"
            . "LEFT JOIN unit u ON\n"
            . "    ir.idUnit = u.idUnit\n"
            . "    WHERE ir.idRecipe = :idRecipe";
        $result = $pdo->prepare($sql);
        // requete préparée grâce à bindParam (permet de préciser le paramètre à passer dans la requete, evite les injections sql)
        $result->bindParam("idRecipe", $idRecipe, PDO::PARAM_INT);
        $result->execute();

        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $array = [];
        }
        return $array;
    }

    /**requete insertion ingredient supplementaire
     */
    public function insertIngredientRecipe(int $idProduct, int $quantity, int $idUnit, int $idRecipe)
    {
        $pdo = Connection::getPdo();
        try {
            // Create prepared statement
            $sql = "INSERT INTO ingredientrecipe (idProduct, quantity, idUnit, idRecipe) VALUES (?,?,?,?)";

            $stmt = $pdo->prepare($sql);

            $values = [$idProduct, $quantity,$idUnit, $idRecipe];
            // Execute the prepared statement
            $success = $stmt->execute($values);

            echo "Records inserted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        return $success;
    }
}
