<?php

include_once(PATH_MODEL.'Connection.php');
class ModelIngredient {

    public function insertChef(Ingredient &$idProduct){

        $pdo= Connection::getPdo();
        try{
            // Create prepared statement
            $sql = "INSERT INTO chef (idProduct) VALUES (?)";
            
            $stmt = $pdo->prepare($sql);
      
            $values= [$idProduct->getIdProduct()];  

            // Execute the prepared statement
            $stmt->execute($values);
      
            echo "Records insert Chef inserted successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        unset($pdo);
    }
}