<?php

include_once(PATH_MODEL . 'Connection.php');
class ModelModerator
{
    public function insertModerator(Moderator $idModerator)
    {
        $pdo = Connection::getPdo();
        try {
            // Create prepared statement
            $sql = "INSERT INTO moderator (idModerator) VALUES (?)";

            $stmt = $pdo->prepare($sql);

            $values = [$idModerator->getidModerator()];
            // Execute the prepared statement
            $stmt->execute($values);

            echo "Records insert Moderator inserted successfully.";
        } catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    }
}
