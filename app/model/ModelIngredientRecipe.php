<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelIngredientRecipe
{

    public function readAllIngredientByRecipe($idRecipe)
    {
        $pdo = Connection::getPdo();

        $sql = "SELECT\n" . "    p.name AS nameIngredient, u.name AS nameUnit, ir.quantity\n" . "FROM\n"
            . "    `ingredientrecipe` ir\n"
            . "LEFT JOIN product p ON\n"
            . "    ir.idProduct = p.idProduct\n"
            . "LEFT JOIN unit u ON\n"
            . "    ir.idUnit = u.idUnit\n"
            . "    WHERE ir.idRecipe = ?";
        $result = $pdo->prepare($sql);
        $result->execute(array($idRecipe));
       
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Recipes');
        } else {
            $array = [];
        }
        return $array;
    }
}
