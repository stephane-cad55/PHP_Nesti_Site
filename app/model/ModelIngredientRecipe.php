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

    // public function insertIngredientRecipe(Recipes &$recipe)
    // {
    //     $pdo = Connection::getPdo();
    //     try {
    //         // Create prepared statement
    //         $sql = "INSERT INTO ingredientrecipe (name, difficulty,portions,flag,preparationTime,idChef) VALUES (?,?,?,?,?,?)";

    //         $stmt = $pdo->prepare($sql);

    //         $values = [$recipe->getName(), $recipe->getDifficulty(), $recipe->getPortions(), $recipe->getFlag(), $recipe->getPreparationTime(), $recipe->getIdChef()];
    //         // Execute the prepared statement
    //         $stmt->execute($values);
    //         $newRecipe = $this->readOneBy("idRecipe", $pdo->lastInsertId());
    //         echo "Records inserted successfully.";
    //     } catch (PDOException $e) {
    //         die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    //     }
    //     unset($pdo);
    //     return $newRecipe;
    // }
}
