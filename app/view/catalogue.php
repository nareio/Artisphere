<main class="main-content">

    <!-- LEFT SIDEBAR -->
    <aside class="sidebar">

        <!-- search + filters (GET) -->
        <form class="search-form" method="get" action="/artisphere/">
        <input type="hidden" name="controller" value="catalogue">
        <input type="hidden" name="action" value="index">

        <input type="search" name="q" placeholder="Rechercher"
                value="<?= htmlspecialchars($filters['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="filter-block">
            <label class="filter-label">Prix min</label>
            <input type="number" step="0.01" name="min_price"
                value="<?= htmlspecialchars((string)($filters['min_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="filter-block">
    _  
            <label class="filter-label">Prix max</label>
            <input type="number" step="0.01" name="max_price"
                value="<?= htmlspecialchars((string)($filters['max_price'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <label class="filter-check">
            <input type="checkbox" name="in_stock" value="1" <?= !empty($filters['in_stock']) ? 'checked' : '' ?>>
            En stock uniquement
        </label>

        <button class="apply-btn" type="submit">Appliquer</button>

        <a class="reset-link" href="/artisphere/?controller=catalogue&action=index">Réinitialiser</a>
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

        <!-- Categories : pas besoin que ce soit des liens (tu as dit ok), mais le plus simple c'est liens GET -->
        <ul class="categories-list">
        <li>
            <a href="/artisphere/?controller=catalogue&action=index"
            class="<?= empty($filters['id_categorie']) ? 'active' : '' ?>">
            TOUS LES PRODUITS
            </a>
        </li>

        <?php foreach ($categories as $c): ?>
            <li>
            <a
                href="/artisphere/?controller=catalogue&action=index&cat=<?= (int)$c['id_categorie'] ?>
                <?= $filters['q'] ? '&q=' . urlencode($filters['q']) : '' ?>
                <?= ($filters['min_price'] !== '' ? '&min_price=' . urlencode($filters['min_price']) : '') ?>
                <?= ($filters['max_price'] !== '' ? '&max_price=' . urlencode($filters['max_price']) : '') ?>
                <?= (!empty($filters['in_stock']) ? '&in_stock=1' : '') ?>"
                class="<?= ((int)$filters['id_categorie'] === (int)$c['id_categorie']) ? 'active' : '' ?>"
            >
                <?= htmlspecialchars(strtoupper($c['nom']), ENT_QUOTES, 'UTF-8') ?>
            </a>
            </li>
        <?php endforeach; ?>
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
        <h1 class="products-title">CATALOGUE</h1>

        <?php if (!empty($produits)): ?>
        <div class="product-grid">
            <?php foreach ($produits as $p): ?>
            <?php
                $img = !empty($p['image'])
                ? 'images/produits/' . $p['image']
                : 'images/produit.png';
            ?>

            <a class="product-card"
                href="/artisphere/?controller=produit_show&action=show&id=<?= (int)$p['id_produit'] ?>">
                <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?>"
                    onerror="this.onerror=null; this.src='images/produit.png';">

                <div class="price-tag">
                <?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?>
                : <?= number_format((float)$p['prix'], 2, ',', ' ') ?>€
                </div>

                <?php if ((int)$p['quantite'] <= 0): ?>
                <div class="stock-badge out">Rupture</div>
                <?php else: ?>
                <div class="stock-badge in">Stock : <?= (int)$p['quantite'] ?></div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
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
        <?php else: ?>
        <p class="empty-state">Aucun produit ne correspond à vos filtres.</p>
        <?php endif; ?>

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
