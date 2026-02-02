<?php
// helpers
function mediaUrl(string $path): string
{
    if (preg_match('#^https?://#i', $path))
        return $path;
    return "/Real-Estate-Project/public/" . ltrim($path, '/');
}
function subtitleLabel(?string $type): string
{
    return $type === 'house' ? 'Showing: Houses'
        : ($type === 'apartment' ? 'Showing: Apartments'
            : ($type === 'land' ? 'Showing: Lands' : 'Showing: All Properties'));
}

$title = 'Listings';
$bodyClass = 'listings-page';
require_once __DIR__ . '/layouts/header.php';
?>

<div class="container">
    <header class="listings-header">
        <div class="topbar">
            <div>
                <h1>Prime Properties</h1>
                <p class="subtitle" id="pageSubtitle"><?= htmlspecialchars(subtitleLabel($type)) ?></p>
            </div>
            <a class="back" href="/Real-Estate-Project/public/index.php">← Back</a>
        </div>

        <div class="filter-section">
            <a class="filter-btn <?= $type === null ? 'active' : '' ?>" href="/Real-Estate-Project/public/listings.php">
                <i class="fa-solid fa-table-cells"></i> All Properties
            </a>
            <a class="filter-btn <?= $type === 'house' ? 'active' : '' ?>"
                href="/Real-Estate-Project/public/listings.php?type=house">
                <i class="fa-solid fa-house"></i> Houses
            </a>
            <a class="filter-btn <?= $type === 'apartment' ? 'active' : '' ?>"
                href="/Real-Estate-Project/public/listings.php?type=apartment">
                <i class="fa-solid fa-building"></i> Apartments
            </a>
            <a class="filter-btn <?= $type === 'land' ? 'active' : '' ?>"
                href="/Real-Estate-Project/public/listings.php?type=land">
                <i class="fa-solid fa-mountain-sun"></i> Lands
            </a>
        </div>
    </header>

    <div class="no-properties" id="noProperties" style="<?= empty($properties) ? '' : 'display:none;' ?>">
        No properties found.
    </div>

    <div class="cards-container" id="cardsContainer">
        <?php foreach ($properties as $p): ?>
            <div class="card" data-type="<?= htmlspecialchars($p['type']) ?>">
                <div class="img-container">
                    <?php
                    $isFav = !empty($favSet[(int) $p['id']]);
                    ?>

                    <?php if (!$isLogged): ?>
                        <a class="fav-btn" href="/Real-Estate-Project/public/login.php" title="Login to save">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                    <?php else: ?>
                        <button class="fav-btn <?= $isFav ? 'is-fav' : '' ?>" type="button"
                            data-property-id="<?= (int) $p['id'] ?>" aria-label="Toggle favorite">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    <?php endif; ?>

                    <?php if (!empty($p['badge'])): ?>
                        <span class="card-badge"><?= htmlspecialchars($p['badge']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($p['primary_image'])): ?>
                        <img src="<?= htmlspecialchars(mediaUrl($p['primary_image'])) ?>"
                            alt="<?= htmlspecialchars($p['title']) ?>" class="card-img" />
                    <?php endif; ?>
                </div>

                <div class="card-content">
                    <h3 class="card-title"><?= htmlspecialchars($p['title']) ?></h3>
                    <p class="card-location">
                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($p['location']) ?>
                    </p>

                    <?php if (!empty($p['description'])): ?>
                        <p class="card-description"><?= htmlspecialchars($p['description']) ?></p>
                    <?php endif; ?>

                    <?php
                    $features = $p['features'] ?? [];
                    $features = array_slice($features, 0, 4);
                    ?>
                    <div class="card-features">
                        <?php foreach ($features as $f): ?>
                            <div class="feature">
                                <i class="fas <?= htmlspecialchars($f['icon']) ?>"></i>
                                <div class="feature-value"><?= htmlspecialchars($f['value']) ?></div>
                                <div class="feature-label"><?= htmlspecialchars($f['label']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="card-footer">
                        <div class="price">
                            $<?= number_format((float) $p['price']) ?>
                            <?php if (!empty($p['price_note'])): ?>
                                <span>/ <?= htmlspecialchars($p['price_note']) ?></span>
                            <?php endif; ?>
                        </div>

                        <a class="card-btn" href="/Real-Estate-Project/public/details.php?id=<?= (int) $p['id'] ?>">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>


<script>
    (() => {
        const btns = document.querySelectorAll('.fav-btn[data-property-id]');
        if (!btns.length) return;

        btns.forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const propertyId = Number(btn.dataset.propertyId);

                try {
                    const res = await fetch('/Real-Estate-Project/public/favorite.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'property_id=' + encodeURIComponent(propertyId)
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        if (data?.error === 'AUTH_REQUIRED') {
                            window.location.href = '/Real-Estate-Project/public/login.php';
                            return;
                        }
                        throw new Error(data?.error || 'Request failed');
                    }

                    btn.classList.toggle('is-fav', !!data.is_favorite);
                } catch (err) {
                    console.error(err);
                    alert('Favorite failed: ' + err.message);
                }
            });
        });
    })();
</script>


</body>

</html>
