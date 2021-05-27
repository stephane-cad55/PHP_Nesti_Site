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

    public function editArticle($id)
    {
        $model = new ModelArticles();
        $article = $model->readOneBy("idArticle", $id);
        $this->data['article'] = $article;
    }

    public function deleteArticle($id)
    {
    }
}
