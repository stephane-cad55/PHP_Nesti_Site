<?php

class Articles
{
        private $idArticle;
        private $unitQuantity;
        private $flag;
        private $dateCreation;
        private $dateModification;
        private $idImage;
        private $idUnit;
        private $idProduct;

        /**
         * Get the value of idArticle
         */
        public function getIdArticle()
        {
                return $this->idArticle;
        }

        /**
         * Set the value of idArticle
         */
        public function setIdArticle($idArticle): self
        {
                $this->idArticle = $idArticle;

                return $this;
        }

        /**
         * Get the value of unitQuantity
         */
        public function getUnitQuantity()
        {
                return $this->unitQuantity;
        }

        /**
         * Set the value of unitQuantity
         */
        public function setUnitQuantity($unitQuantity): self
        {
                $this->unitQuantity = $unitQuantity;

                return $this;
        }

        /**
         * Get the value of flag
         */
        public function getFlag()
        {
                return $this->flag;
        }

        /**
         * Set the value of flag
         */
        public function setFlag($flag): self
        {
                $this->flag = $flag;

                return $this;
        }

        /**
         * Get the value of dateCreation
         */
        public function getDateCreation()
        {
                return $this->dateCreation;
        }

        /**
         * Set the value of dateCreation
         */
        public function setDateCreation($dateCreation): self
        {
                $this->dateCreation = $dateCreation;

                return $this;
        }

        /**
         * Get the value of dateModification
         */
        public function getDateModification()
        {
                return $this->dateModification;
        }

        /**
         * Set the value of dateModification
         */
        public function setDateModification($dateModification): self
        {
                $this->dateModification = $dateModification;

                return $this;
        }

        /**
         * Get the value of idImage
         */
        public function getIdImage()
        {
                return $this->idImage;
        }

        /**
         * Set the value of idImage
         */
        public function setIdImage($idImage): self
        {
                $this->idImage = $idImage;

                return $this;
        }

        /**
         * Get the value of unit
         */

        public function getIdUnit()
        {
                if ($unit = "UNITE") {
                        $this->unit = "";
                }
                return $this->unit;
        }

        /**
         * Set the value of unit
         */
        public function setIdUnit($unit): self
        {
                $this->unit = $unit;

                return $this;
        }

        /**
         * Get the value of idProduct
         */
        public function getIdProduct()
        {
                return $this->idProduct;
        }

        /**
         * Set the value of idProduct
         */
        public function setIdProduct($idProduct): self
        {
                $this->idProduct = $idProduct;

                return $this;
        }

        public function getName()
        {
                $name = new ModelProduct();
                $name1 = $name->readOneBy("idProduct", $this->idProduct);

                return  $name1->getName();
        }

        public function getPrice()
        {
                $name = new ModelArticleprice();
                $name2 = $name->readAllBy("idArticle", $this->idArticle);

                foreach ($name2 as $price) {
                        $val = $price->getPrice();
                }

                return $val;
        }

        public function setArticleFromArray($recipe)
        {
                foreach ($recipe as $key => $value) {

                        $this->$key = $value;
                }
        }

        public function getLastimport()
        {
                $name = new ModelImportation();
                $name3 = $name->readOneBy("idArticle", $this->idArticle);

                return  $name3->getImportationDate();
        }

        public function getStock()
        {
                $name = new ModelLot();
                $name4 = $name->readOneBy("idArticle", $this->idArticle);

                return  $name4->getQuantity();
        }

        public function getUnitName()
        {
                $unit = new ModelUnit();
                $unit1 = $unit->readOneBy("idUnit", $this->idUnit);
                $unity = $unit1->getName();

                return  $unity;
        }

        public function getType()
        {
                $model = new ModelProduct();
                $data  = $model->findChildType("ingredient", "product", $this->getIdProduct());

                if ($data != Null) {
                        $type = "ingredient";
                } else {
                        $type = "";
                }

                return $type;
        }

        public function isIngredient(): bool
        {

                return $this->getType() != null;
        }

        public function getLots()
        {
                $lot = new ModelLot();
                $lot = $lot->readOneBy("idArticle", $this->getIdArticle());

                return $lot;
        }

        public function getFactoryName()
        {
                $article = new ModelArticles();
                $name = $article->readOneBy("idArticle", $this->getIdArticle());
                $factoryName = $name->getUnitQuantity() . " " . ($name->getUnitName() == 'UNITE' ? '' : $name->getUnitName()) . " " . $name->getName();

                return  $factoryName;
        }

        public function getArticleQuantIn()
        {
                return $this->getLots();
        }

        public function getNbBought()
        {
                $totalQuantity = 0;
                foreach ($this->getLots() as $lot) {
                        $totalQuantity += $this->getLots()->getQuantity();
                }

                return $totalQuantity;
        }

        public function getArticlePrices()
        {
                $model = new ModelArticleprice();

                $articlePrices = $model->readAllBy("idArticle", $this->getIdArticle());
                return $articlePrices;
        }

        public function getLastPriceAt(String $dateMax): String
        {
                $maxDate = 0;
                $arrayArticlePrice = $this->getArticlePrices();

                foreach ($arrayArticlePrice as $value) {
                        $date = strtotime($value->getDateStart());
                        if ($date <= $dateMax) {
                                if ($maxDate <  $date) {
                                        $maxDate =  $date;
                                        $price = $value->getPrice();
                                }
                        }
                }
                return $price;
        }
}
