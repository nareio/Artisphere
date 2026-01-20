<!-- MAIN CONTENT -->
<main class="main-content">
    <!-- Sidebar toggle button (mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        ☰
    </button>

    <!-- LEFT SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <!-- search form -->
        <form class="search-form" onsubmit="return false;">
            <input type="search" id="productSearch" placeholder="Search products">
        </form>

        <div class="categories-title">CATEGORIES :</div>
        <ul class="categories-list">
            <?php
                // "All products" is active when no category filter
                $allActive = empty($currentCat) ? 'active' : '';

                // Base URL for clean routing (keeps category if selected)
                $baseUrl = "/artisphere/catalogue";
                if (!empty($currentCat)) {
                    $baseUrl .= "/category/" . (int)$currentCat;
                }
            ?>
            <li>
                <a class="<?= $allActive ?>"
                   href="/artisphere/catalogue">
                    TOUS LES PRODUITS
                </a>
            </li>

            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $c): ?>
                    <?php
                        $isActive = (!empty($currentCat) && (int)$currentCat === (int)$c['id_categorie']) ? 'active' : '';
                    ?>
                    <li>
                        <a class="<?= $isActive ?>"
                           href="/artisphere/catalogue/category/<?= (int)$c['id_categorie'] ?>">
                            <?= htmlspecialchars($c['nom'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

    </aside>

    <!-- RIGHT PRODUCTS AREA -->
    <section class="products">
        <h1 class="products-title">LES PRODUITS</h1>

        <div class="product-grid">
            <?php if (!empty($produits)): ?>
                <?php foreach ($produits as $p): ?>
                    <?php
                        // Build image path 
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

                            <!-- Keep this as-is for now (not part of catalogue rewriting) -->
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

        <!-- arrows at the end -->
        <?php if (!empty($pagesTotal) && $pagesTotal > 1): ?>
            <div class="page-swiper">

                <?php if ($page > 1): ?>
                    <a class="next-previous"
                       href="<?= $baseUrl ?>/page/<?= $page - 1 ?>">
                        ← Previous
                    </a>
                <?php endif; ?>

                <span class="catalogue-page-count">
                    Page <?= (int)$page ?> / <?= (int)$pagesTotal ?>
                </span>

                <?php if ($page < $pagesTotal): ?>
                    <a class="next-previous"
                       href="<?= $baseUrl ?>/page/<?= $page + 1 ?>">
                        Next →
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </section>
</main>
