<!-- MAIN CONTENT -->
<main class="main-content">
    <!-- LEFT SIDEBAR -->
    <aside class="sidebar">
        <!-- search form -->
        <form class="search-form">
            <input type="search" placeholder="Rechercher">
        </form>

        <div class="categories-title">CATEGORIES :</div>
        <ul class="categories-list">
            <li><a href="#" class="active">TOUS LES PRODUITS</a></li>
            <li><a href="#">TABLEAUX</a></li>
            <li><a href="#">ARTISANAT</a></li>
        </ul>
    </aside>

    <!-- RIGHT PRODUCTS AREA -->
    <section class="products">
        <h1 class="products-title">TOUS LES PRODUITS</h1>

        <div class="product-grid">
            <?php if (!empty($produits)): ?>
                <?php foreach ($produits as $p): ?>
                    <?php
                        // Build image path (same logic as on the home page)
                        $imgPath = !empty($p['image'])
                            ? "images/produits/" . $p['image']
                            : "/artisphere/images/produit.png";

                        // Format the price safely
                        $price = number_format((float)($p['prix'] ?? 0), 2, ',', ' ');

                        // Product name fallback
                        $productName = $p['nom'] ?? 'Produit';
                    ?>
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img
                                src="<?= htmlspecialchars($imgPath, ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?>"
                                onerror="this.onerror=null; this.src='/artisphere/images/produit.png';"
                            >
                        </div>

                        <div class="product-info">
                            <div class="product-name">
                                <?= htmlspecialchars($productName, ENT_QUOTES, 'UTF-8') ?>
                            </div>

                            <div class="product-price">
                                <?= $price ?> €
                            </div>

                            <a class="product-link"
                               href="/artisphere/?controller=produit_show&action=show&id=<?= (int)$p['id_produit'] ?>">
                                Voir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>

        <!-- arrow on the right -->
        <button class="arrow-next">&#8250;</button>
    </section>
</main>

