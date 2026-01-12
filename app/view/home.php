<section class="home-hero">
  <?php
    // --- Auth / CTA (logique page 1) ---
    $isLogged = !empty($_SESSION['user']);
    $role = $_SESSION['user']['role'] ?? null;

    $ctaHref = '/artisphere/?controller=connexion&action=index';
    if ($isLogged) {
      if ($role === 'artisan' || $role === 'admin') {
        $ctaHref = '/artisphere/?controller=mes_creations&action=index';
      } else {
        $ctaHref = '/artisphere/?controller=catalogue&action=index';
      }
    }

    // --- Langue (structure propre : $currentLang + $t) ---
    // Exemple: ?lang=fr ou ?lang=en
    $currentLang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'fr');
    $currentLang = in_array($currentLang, ['fr','en'], true) ? $currentLang : 'fr';
    $_SESSION['lang'] = $currentLang;

    $t = [
      'fr' => [
        'h1' => "Découvrez l'artisanat d'exception",
        'intro' => "Chaque pièce raconte une histoire. Chaque artisan partage son savoir-faire.",
        'cta_title' => "Prêt à vendre ou acheter ?",
        'cta_button' => "Commencer",
        'trending' => "LES PRODUITS TENDANCES",
        'events' => "LES EVENEMENTS A LA UNE",
        'see' => "Voir",
        'from' => "DU",
        'to' => "AU",
      ],
      'en' => [
        'h1' => "Discover exceptional craftsmanship",
        'intro' => "Every piece tells a story. Every artisan shares their expertise.",
        'cta_title' => "Ready to sell or buy?",
        'cta_button' => "Get started",
        'trending' => "TRENDING PRODUCTS",
        'events' => "FEATURED EVENTS",
        'see' => "See",
        'from' => "FROM",
        'to' => "TO",
      ],
    ];
    $L = $t[$currentLang];

    // --- Helper pour garder la pagination et ajouter la langue aux liens ---
    $baseUrl = '/artisphere/?controller=index&action=index';
    $qsLang = '&lang=' . urlencode($currentLang);
  ?>

  <div class="home-hero__left">
    <h1 class="reveal"><?= htmlspecialchars($L['h1'], ENT_QUOTES, 'UTF-8') ?></h1>

    <p class="home-hero__text reveal">
      <?= nl2br(htmlspecialchars($L['intro'], ENT_QUOTES, 'UTF-8')) ?>
    </p>

    <!-- PRODUITS -->
    <div class="home-pill reveal"><?= htmlspecialchars($L['trending'], ENT_QUOTES, 'UTF-8') ?></div>

    <div class="carousel-row reveal">
      <a class="arrow <?= ($pProd <= 1 ? 'disabled' : '') ?>"
         href="<?= $baseUrl . '&p_prod=' . max(1, $pProd-1) . '&p_evt=' . (int)$pEvt . $qsLang ?>">←</a>

      <div class="home-products">
        <?php foreach ($produits as $p): ?>
          <?php
            $img = !empty($p['image'])
              ? "images/produits/" . $p['image']
              : "/artisphere/images/produit.png";
          ?>
          <article class="product-card">
            <img
              src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
              alt="<?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?>"
              onerror="this.onerror=null; this.src='/artisphere/images/produit.png';"
            >
            <h3 class="product-name"><?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?></h3>
            <div class="product-price"><?= number_format((float)$p['prix'], 2, ',', ' ') ?> €</div>
            <a class="card-link"
               href="/artisphere/?controller=produit_show&action=show&id=<?= (int)$p['id_produit'] ?><?= $qsLang ?>">
              <?= htmlspecialchars($L['see'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </article>
        <?php endforeach; ?>
      </div>

      <a class="arrow <?= ($pProd >= $pagesProd ? 'disabled' : '') ?>"
         href="<?= $baseUrl . '&p_prod=' . min($pagesProd, $pProd+1) . '&p_evt=' . (int)$pEvt . $qsLang ?>">→</a>
    </div>

    <!-- EVENEMENTS -->
    <div class="home-pill reveal"><?= htmlspecialchars($L['events'], ENT_QUOTES, 'UTF-8') ?></div>

    <div class="carousel-row reveal">
      <a class="arrow <?= ($pEvt <= 1 ? 'disabled' : '') ?>"
         href="<?= $baseUrl . '&p_evt=' . max(1, $pEvt-1) . '&p_prod=' . (int)$pProd . $qsLang ?>">←</a>

      <div class="home-events">
        <?php foreach ($evenements as $e): ?>
          <?php
            $imgEvt = !empty($e['image'])
              ? "images/evenements/" . $e['image']
              : "images/image-photo.jpg";
          ?>
          <article class="event-card">
            <img
              src="<?= htmlspecialchars($imgEvt, ENT_QUOTES, 'UTF-8') ?>"
              alt="<?= htmlspecialchars($e['nom'], ENT_QUOTES, 'UTF-8') ?>"
              onerror="this.onerror=null; this.src='images/image-photo.jpg';"
            >

            <div class="event-title"><?= htmlspecialchars($e['nom'], ENT_QUOTES, 'UTF-8') ?></div>

            <div class="event-meta">
              <?= htmlspecialchars($e['lieu'] ?? '', ENT_QUOTES, 'UTF-8') ?>
              <?= !empty($e['type']) ? ' · ' . htmlspecialchars($e['type'], ENT_QUOTES, 'UTF-8') : '' ?>
            </div>

            <div class="event-date">
              <?= htmlspecialchars($L['from'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($e['date_debut'], ENT_QUOTES, 'UTF-8') ?>
              <?= htmlspecialchars($L['to'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($e['date_fin'], ENT_QUOTES, 'UTF-8') ?>
            </div>

            <a class="card-link"
               href="/artisphere/?controller=evenement_show&action=show&id=<?= (int)$e['id_event'] ?><?= $qsLang ?>">
              <?= htmlspecialchars($L['see'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </article>
        <?php endforeach; ?>
      </div>

      <a class="arrow <?= ($pEvt >= $pagesEvt ? 'disabled' : '') ?>"
         href="<?= $baseUrl . '&p_evt=' . min($pagesEvt, $pEvt+1) . '&p_prod=' . (int)$pProd . $qsLang ?>">→</a>
    </div>
  </div>

  <!-- CTA à droite (forme page 2 + logique page 1) -->
  <aside class="home-cta">
    <div class="cta-card reveal">
      <h2 class="cta-title"><?= htmlspecialchars($L['cta_title'], ENT_QUOTES, 'UTF-8') ?></h2>

      <!-- mini switch langue (optionnel, mais pratique) -->
      <div class="lang-switch" style="margin:10px 0;">
        <a href="<?= $baseUrl . '&p_prod='.(int)$pProd.'&p_evt='.(int)$pEvt.'&lang=fr' ?>">FR</a>
        <span> | </span>
        <a href="<?= $baseUrl . '&p_prod='.(int)$pProd.'&p_evt='.(int)$pEvt.'&lang=en' ?>">EN</a>
      </div>

      <a class="cta-button" href="<?= htmlspecialchars($ctaHref, ENT_QUOTES, 'UTF-8') ?>">
        <?= htmlspecialchars($L['cta_button'], ENT_QUOTES, 'UTF-8') ?>
      </a>
    </div>
  </aside>
</section>