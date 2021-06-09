var prepCounter = 1;

function dlImg() {

    let img = document.getElementById("img");
    let imgCtn = document.getElementById("imgCtn");
    let imgDl = document.getElementById("imgDl");

    if (imgDl.value != "") {
        img.src = imgDl.value;
        img.height = 275;
        img.width = 540;
        imgCtn.appendChild(img);
        imgDl.value = "";
    }
}

function addIngredient() {

    let ingName = document.getElementById("ingName");//on récupère le nom de l'ingrédient grâce à l'id
    let ingQty = document.getElementById("ingQty");//on récupère la quantité de l'ingrédient grâce à l'id
    let ingUnit = document.getElementById("ingUnit");//on récupère l'unité de l'ingrédient grâce à l'id
    let div = document.createElement("div");
    let divCtn = document.getElementById("ingCtn");
    let ing = ingName.value + " : " + ingQty.value + " " + ingUnit.value;
    let btn = document.getElementById('btnAddIng');
    let id_recipe = btn.getAttribute('data-id');

    if (!id_recipe) {// si la recette n'est pas connue, un message d'alerte indique que l'id de la recette est inconnue
        alert('Erreur id de recette inconnue');
    } else if (ingName.value == '') {//sinon il faut remplir les champs (nouvel ingrédient: nom , quantité et unité)
        alert('Veuillez remplir le champs nom');
    } else if (ingQty.value == '' || isNaN(ingQty.value)) {
        alert('Veuillez remplir une quantité numérique valide');
    } else if (ingUnit.value == '') {
        alert('Veuillez remplir le champs unité');

    } else {
        // il n'y pas d'erreur
        div.innerHTML = ing;
        divCtn.appendChild(div);
        //requete ajax (jquery)
        $.post("https://127.0.0.1/www/PHP_Nesti_Site/recipes/adding/" + id_recipe,
            { nameIng: ingName.value, qtyIng: ingQty.value, unitIng: ingUnit.value },
            function (data) {
                console.log(data.name, data.qty, data.unit); 

            }, "json");

        ingName.value = "";
        ingQty.value = "";
        ingUnit.value = "";
    }
}

function addTextArea() {

    let baseItem = document.getElementById("baseItem").innerHTML;
    let newItem = document.createElement("div");
    let prepCtn = document.getElementById("prepCtn");

    newItem.innerHTML = baseItem;
    newItem.className += "row mt-5 prepItem";
    prepCounter++;
    newItem.dataset.order = prepCounter;
    prepCtn.appendChild(newItem);

    actualize();
}

function actualize() {

    let items = document.querySelectorAll(".prepItem");
    console.log(items);

    items.forEach(item => {
        item.querySelector(".upText").style.visibility = "visible";
        item.querySelector(".downText").style.visibility = "visible";
    });

    let first = document.querySelector("[data-order='1']");
    first.querySelector(".upText").style.visibility = "hidden";

    let last = document.querySelector("[data-order='" + prepCounter + "']");
    last.querySelector(".downText").style.visibility = "hidden";
}

function upBtn(e) {
    let ctn = e.parentNode.parentNode;
    let txt = ctn.querySelector("div>textarea");
    let txt1 = ctn.previousElementSibling.querySelector("div>textarea");
    let value = txt.value;
    let value1 = txt1.value;

    txt.value = value1;
    txt1.value = value;
}

function downBtn(e) {
    let ctn = e.parentNode.parentNode;
    let txt = ctn.querySelector("div>textarea");
    let txt1 = ctn.nextElementSibling.querySelector("div>textarea");
    let value = txt.value;
    let value1 = txt1.value;

    txt.value = value1;
    txt1.value = value;
}

function deleteBtn(e) {
    let ctn = e.parentNode.parentNode;
    let prepCtn = document.querySelector("#prepCtn");

    if (prepCtn.childElementCount != 1) {
        ctn.remove();
    }
}

function onlyNumberKey(evt) {

    let ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

window.addEventListener("DOMContentLoaded", (event) => {
    actualize();
});