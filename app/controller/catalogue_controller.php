<?php

// Load the product model so we can query the database
require_once __DIR__ . '/../model/produit_model.php';

class catalogue_controller extends BaseController
{
    public function index(): void
    {
        // 1) Get ALL products from the database via the model
        //    You can switch to pagination later if needed.
        $produits = ProduitModel::getAll();

        // 2) Render the catalogue view and pass the products to it
        //    Inside catalogue.php you will be able to use $produits.
        $this->render('catalogue.php', [
            'title'    => 'Artisphere – Catalogue',
            'pageCss'  => 'catalogue-style.css',
            'produits' => $produits,
        ]);
    }
}
