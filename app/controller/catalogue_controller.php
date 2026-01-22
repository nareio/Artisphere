<?php

// Load the product model so we can query the database
require_once __DIR__ . '/../model/produit_model.php';
require_once __DIR__ . '/../model/categorie_model.php';

class catalogue_controller extends BaseController
{
    public function index(): void
    {
        $limit = 8;
        // Current page number from URL
        $page = max(1, (int)($_GET['page'] ?? 1));

        // SQL offset
        $offset = ($page - 1) * $limit;

        // Read selected category from URL: ?cat=1, ?cat=2 ...
        $currentCat = isset($_GET['cat']) && $_GET['cat'] !== '' ? (int)$_GET['cat'] : null;

        // Categories for the sidebar
        $categories = CategorieModel::all();


        if ($currentCat) {
            // Fetch only 8 products for this page, with cat
            $produits = ProduitModel::listByCategory($currentCat, $limit, $offset);
            $totalProduits = ProduitModel::countByCategory($currentCat);
        } else {
            // Fetch only 8 products for this page without filters
            $produits = ProduitModel::listHome($limit, $offset);
            $totalProduits = ProduitModel::countAll();
        }



        // Total pages
        $pagesTotal = max(1, (int)ceil($totalProduits / $limit));




        //    Render the catalogue view and pass the products to it
        //    Inside catalogue.php we will be able to use $produits.
        $this->render('catalogue.php', [
            'title'    => 'Artisphere – Catalogue',
            'pageCss'  => 'catalogue-style.css',
            'pageJs'  => 'catalogue.js',
            'produits' => $produits,
            'page'       => $page,
            'pagesTotal' => $pagesTotal,
            'categories' => $categories,
            'currentCat' => $currentCat,
        ]);
    }
}
