<div class="container bg-white d-flex flex-column align-items-left" id="recettes">
    <div class="row mt-3">
        <form action="<?php echo (BASE_URL) ?>recipes/add" method="POST">
            <div class="col">
                <h1 class="mb-2 mt-4">Création d'une recette</h1>
                <p class="mt-4">Nom de la recette</p>
                <input type="text" class="w-100" name="recipeName">
                <p class="mt-3">Auteur de la recette : <?= print_r($_SESSION["firstname"] . " " . $_SESSION["lastname"]) ?></p>
                <div class="row">
                    <div class="col d-flex justify-content-between flex-column">
                        <p class="mt-4 mb-2">Difficulté (note sur 5)</p>
                        <p class="mt-4 mb-2">Nombre de personnes</p>
                        <p class="mt-4 mb-2">Temps de préparation en minutes</p>
                    </div>
                    <div class="col">
                        <div class="col d-flex justify-content-between flex-column p-0">
                            <div class="d-flex justify-content-end"><input type="number" onkeypress="return onlyNumberKey(event)" name="recipedifficult" class="w-50 mt-4 mb-2"></div>
                            <div class="d-flex justify-content-end"><input type="number" onkeypress="return onlyNumberKey(event)" name="recipePortion" class="w-50 mt-4 mb-2"></div>
                            <div class="d-flex justify-content-end"><input type="text" onkeypress="return onlyNumberKey(event)" name="recipeTimePrepare" class="w-50 mt-4 mb-2"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center p-2">
                    <button type="submit" class="btn m-5 valid w-25">Valider</button>
                    <button type="submit" class="btn m-5 cancel w-25">Annuler</button>
                </div>
            </div>
        </form>
        <div class="col">
            <form enctype="multipart/form-data" action="<?= BASE_URL ?>recipes/addImage" method="post">
                <div class="mt-2 h-75 w-100 d-flex justify-content-center align-items-center" id="imgCtn" ;">
                    <img src="" alt="" id="img" width="550px" height="375px">
                </div>
                <div class="row">
                    <div class="mb-5">
                        <label for="formFile" class="form-label"></label>
                        <input class="form-control ml-5" type="file" id="formFile" name="pictures">
                    </div>
                    <div class="col-sm-2 ml-5 mt-4"><button type="submit" class="btn valid w-100" onclick="dlImg()">Ok</button></div>
                </div>
            </form>
        </div>
    </div>
</div>