<?php
// Traitements : récupérer les category
$categoryModel = new CategoryModel();
$categories = $categoryModel->getAllCategories();


$template = 'home';

include '../templates/base.phtml';


