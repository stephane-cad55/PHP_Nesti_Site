<?php

class StatisticsController extends BaseController
{

    public function initialize()
    {
        $loc    = filter_input(INPUT_GET, "loc", FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
        if ($action == '') {
            $this->dashboard();
        }
    }
    public  function dashboard()
    {
        $connexionByHour = [];
        $categories = [];
        $allLogs = ModelConnectionLog::readAll();
        foreach ($allLogs as $book) {
            $format = 'Y-m-d H:i:s';
            $logDate = DateTime::createFromFormat($format, $book->getDateConnection());
            $categories[$logDate->format('H')][] = $book;
        }
        foreach ($categories as $key => $logs) {
            $connexionByHour[] = (object) array("name" => $key, "data" => count($logs));
        }

        $TopTenUsers = ModelUsers::readAll();
        usort($TopTenUsers, function ($v1, $v2) {
            return count($v2->getConnectionLogs()) <=> count($v1->getConnectionLogs());
        });
        $TopTenUsers = array_slice($TopTenUsers, 0, 10);


        $TopTenChef = ModelChef::readAll();
        usort($TopTenChef, function ($v1, $v2) {
            return count($v2->getAllRecipeFromChef()) <=> count($v1->getAllRecipeFromChef());
        });
        $TopTenChef = array_slice($TopTenChef, 0, 10);


        $TopTenRecipe = ModelRecipes::readAll();
        usort($TopTenRecipe, function ($v1, $v2) {
            return count($v2->getRatting()) <=> count($v1->getRatting());
        });

        $TopTenRecipe = array_slice($TopTenRecipe, 0, 10);
        $largerOrders =  ModelOrderline::readAll();
        usort($largerOrders, function ($v1, $v2) {
        });

        $largerOrders = array_slice($largerOrders, 0, 3);

        $NbCount =  ModelArticles::readAll();
        usort($NbCount, function ($v1, $v2) {
        });
        $NbCount = $NbCount;

        $cost = [444, 457, 477, 479, 446, 476, 457, 472, 467, 455, 458, 458, 451];
        $vente = [466, 507, 472, 475, 485, 470, 500, 496, 487, 491, 490, 476, 489];
        $articleVente = [10, 20, 30, 20, 60, 100, 150];
        $costByArticle = [50, 10, 20, 10, 40, 150, 100];
        $this->data['arrayVars'] = [
            "cost" => $cost,
            "vente" => $vente,
            "connexionByHour" => $connexionByHour,
            "costByArticle" => $costByArticle,
            "articleVente" => $articleVente,
            "TopTenUsers" => $TopTenUsers,
            "TopTenChef" => $TopTenChef,
            "TopTenRecipe" => $TopTenRecipe,
            "largerOrders" => $largerOrders,
            "NbCount" => $NbCount,
        ];
    }
}
