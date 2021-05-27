<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelParagraph
{
    public function readAll()
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM recipe";
        $result = $pdo->query($sql);
        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Recipes');
        } else {
            $array = [];
        }
        return $array;
    }

    public function readOneBy($parameter, $value)
    {
        //requete
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM paragraph where $parameter = '$value'";

        $result = $pdo->query($sql);

        if ($result) {
            $data = $result->fetch();
        } else {
            $data = [];
        }

        $recipe = new Paragraph();
        $recipe->setParagraphFromArray($data);

        return $recipe;
    }

    public function readAllBy($parameter, $value)
    {
        $pdo = Connection::getPdo();

        $sql = "SELECT * FROM paragraph where $parameter = '$value'";
        $result = $pdo->query($sql);

        if ($result) {
            $array = $result->fetchAll(PDO::FETCH_CLASS, 'Paragraph');
        } else {
            $array = [];
        }
        return $array;
    }

    public function addPreparation(Paragraph &$recipe)
    {
        $pdo = Connection::getPdo();
        try {

            $sql = "INSERT INTO paragraph (content,paragraphPosition,dateCreation,idRecipe) VALUES (?,?,?,?,?)";

            $stmt = $pdo->prepare($sql);

            $values = [$recipe->getContent(), $recipe->getParagraphPosition(), $recipe->getDateCreation(), $recipe->getIdRecipe()];
            // Execute the prepared statement
            $stmt->execute($values);
            $recipe = $this->readOneBy("idRecipe", $recipe->getIdRecipe());
            echo "Records deleted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
        unset($pdo);
        return $recipe;
    }
}
