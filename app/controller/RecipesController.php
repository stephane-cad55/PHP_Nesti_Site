<?php

class RecipesController extends BaseController
{
  public function initialize()
  {
    $model = new ModelRecipes();
    $loc    = filter_input(INPUT_GET, "loc", FILTER_SANITIZE_STRING);
    $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

    switch ($action) {
      case "add":
        $this->create();
        break;
      case "editing":
        $this->editRecipe($id);
        break;
      case "deleted":
        $this->delete($id);
        break;
      case "addimage":
        $this->addImage($id);
        break;
      case "adding":
        $this->addIng($id);
        break;
      default:
        $this->data['arrayRecipes'] = $model->readAll();
        break;
    }
  }

  public function create()
  {
    $model = new ModelRecipes();
    $recipe = new Recipes();
    $recipe->setName(filter_input(INPUT_POST, "recipeName"));
    $recipe->setDifficulty(filter_input(INPUT_POST, "recipedifficult"));
    $recipe->setPortions(filter_input(INPUT_POST, "recipePortion"));
    $recipe->setPreparationTime(filter_input(INPUT_POST, "recipeTimePrepare"));
    $recipe->setFlag("a");
    $recipe->setIdChef($_SESSION['idUser']);

    //verif IS valid?
    $insertedRecipe = $model->insertRecipe($recipe);
    header('Location:' . BASE_URL . "recipes/editing/" . $insertedRecipe->getIdRecipe());
  }

  public function delete($id)
  {
    $model = new ModelRecipes();
    $recipe = $model->readOneBy("idRecipe", $id);
    $deletedRecipe = $model->deleteRecipe($recipe);
    header('Location:' . BASE_URL . "recipes");
  }

  public function addImage($id)
  {
    $modelRecipe = new ModelRecipes();
    $recipe = $modelRecipe->readOneBy("idRecipe", $id);

    $target_dir = "public/img/recipes/";
    $target_file = $target_dir . basename($_FILES["pictures"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["pictures"]["tmp_name"]);
      if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["pictures"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["pictures"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["pictures"]["name"])) . " has been uploaded.";

        $model = new ModelImages();
        $images = new Images();

        $name = explode(".", $_FILES["pictures"]["name"]);
        $images->setName($name[0]);
        $images->setFileExtension($name[1]);

        //verif IS valid?
        $insertedImages = $model->insertImages($images);
        $recipe->setIdImage($insertedImages->getIdImage());
        $modelRecipe->updateRecipes($recipe);
        header('Location:' . BASE_URL . "recipes/editing/" . $id);
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }

  public function addIng($id)
  {
    $name = filter_input(INPUT_POST, "nameIng");
    $qty = filter_input(INPUT_POST, "qtyIng");
    $unit = filter_input(INPUT_POST, "unitIng");

    // Validatation 

    $model = new ModelIngredientRecipe();
    $modelProduct = new ModelProduct();
    // s'il existe (SELECT) on r??cupere son id
    // Sinon on cr??e un nouveau ingr??dient 
    // last inseert id = id_product
    $product = $modelProduct->readOneBy("name", $name) ;
  
    if($product){
      $id_product = $product->getIdProduct();
    }else{
      // Sinon creation : insertion dans la product  + insertion dans la table ing 
      $newProduct = $modelProduct->createProduct($name); 
      $id_product = $newProduct->getIdProduct();

      $modelIngredient = new ModelIngredient();
      $newIngredient = $modelIngredient->createIngredient($id_product); 
    }
 
    $modelUnit = new ModelUnit();
    $myUnit = $modelUnit->readOneBy('name', $unit); // V??rifi??
 
    if($myUnit){
      $id_unit = $myUnit->getIdUnit();
    }else{
      $newUnit = $modelUnit->createUnit($unit);
      $id_unit = $newUnit->getIdUnit();
    }

    $success = $model->insertIngredientRecipe($id_product, $qty, $id_unit, $id );

    header('Content-Type: application/json');
    echo json_encode([
      'success' => $success,
      'id_recipe' => $id,
      'name' => $name,
      'qty' => $qty,
      'unit' => $unit
    ]);
    die;
  }

  public function addPreparation($id)
  {
    $model = new ModelParagraph();
    $recipe = $model->readOneBy("idRecipe", $id);
    $addPreparation = $model->addPreparation($recipe);
  }

  public function editRecipe($idRecipe)
  {
    $model = new ModelRecipes();
    $recipe = $model->readOneBy("idRecipe", $idRecipe);
    $this->data['recipe'] = $recipe;

    $ingredientRecipeModel = new ModelIngredientRecipe();
    $ingredientRecipe = $ingredientRecipeModel->readAllIngredientByRecipe($idRecipe);
    $this->data['ingredientrecipe'] = $ingredientRecipe;

    if (isset($_POST["recipeName"])) {
      $recipe->setName(filter_input(INPUT_POST, "recipeName"));
      $recipe->setDifficulty(filter_input(INPUT_POST, "recipedifficult"));
      $recipe->setPortions(filter_input(INPUT_POST, "recipePortion"));
      $recipe->setPreparationTime(filter_input(INPUT_POST, "recipeTimePrepare"));

      $model->updateRecipes($recipe);
      header('Location:' . BASE_URL . "recipes/editing/" . $idRecipe);
    }
  }
}
