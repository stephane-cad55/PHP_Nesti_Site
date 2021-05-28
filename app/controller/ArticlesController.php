<?php

class ArticlesController extends BaseController
{
    public function initialize()
    {
        $loc    = filter_input(INPUT_GET, "loc", FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
        if ($action == '') {
            $model = new ModelArticles();
            $this->data['arrayArticles'] = $model->readAll();
            $model1 = new ModelOrders();
            $ingredient = new ModelIngredient();
            $unit = new ModelUnit();
            $import = new ModelImportation();
        }
        if ($action == "editing") {
            $this->editArticle($id);
        }
        if ($action == "deleted") {
            $this->deleteArticle($id);
        }
        if ($action == "orders") {
            $model = new ModelOrders();
            $this->data['arrayOrders'] = $model->readAll();
        }
    }

    public function editArticle($idArticles)
    {
        $model = new ModelArticles();
        $article = $model->readOneBy("idArticle", $idArticles);
        $this->data['article'] = $article;
        if (isset($_POST["nameArticle"])) {
            $article->setNameArticle(filter_input(INPUT_POST, "nameArticle"));

            $model->updateArticleName($idArticles, $article);

            header('Location:' . BASE_URL . "articles/editing/" . $idArticles);
        }
    }

    public function deleteArticle($idArticles)
    {
        $model = new ModelArticles();
        $article = $model->readOneBy("idArticle", $idArticles);
        $deletedArticle = $model->deletedArticle($article);
        header('Location:' . BASE_URL . "articles");
    }
}
