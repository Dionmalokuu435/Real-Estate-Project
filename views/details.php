<?php
function mediaUrl(string $path): string
{
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    return "/Real-Estate-Project/public/" . ltrim($path, '/');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/Repositories/FavoriteRepository.php';

$isLogged = !empty($_SESSION['user']);
$isFavorite = false;

if ($isLogged && !empty($property)) {
    $favRepo = new FavoriteRepository();
    $isFavorite = $favRepo->isFavorite(
        (int) $_SESSION['user']['id'],
        (int) $property['id']
    );
}

$title = $property['title'] ?? 'Property Details';
$bodyClass = 'details-page';
require_once __DIR__ . '/layouts/header.php';
?>

<div class="container">
    <?php if (empty($property)): ?>
        <div class="card" style="padding:18px;">Property not found.</div>
    <?php else: ?>
        <div class="card">
            <?php
            $img = null;
            foreach (($media ?? []) as $m) {
                if (($m['file_type'] ?? '') === 'image') {
                    $img = $m['file_path'] ?? null;
                    break;
                }
            }
            ?>
            <?php if ($img): ?>
                <img src="<?= htmlspecialchars(mediaUrl($img)) ?>" alt="" />
            <?php endif; ?>

            <div class="content">
                <h1><?= htmlspecialchars($property['title']) ?></h1>

                <div class="loc">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?= htmlspecialchars($property['location']) ?></span>
                </div>

                <div class="price">
                    $<?= number_format((float) $property['price']) ?>
                    <?php if (!empty($property['price_note'])): ?>
                        <span class="muted">/ <?= htmlspecialchars($property['price_note']) ?></span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($property['description'])): ?>
                    <p><?= nl2br(htmlspecialchars($property['description'])) ?></p>
                <?php endif; ?>

                <div class="features">
                    <?php foreach (($details ?? []) as $d): ?>
                        <div class="feat">
                            <?php if (!empty($d['icon'])): ?>
                                <i class="fas <?= htmlspecialchars($d['icon']) ?>"></i>
                            <?php endif; ?>
                            <div style="font-weight:800; margin-top:6px;">
                                <?= htmlspecialchars($d['value']) ?>
                            </div>
                            <div class="muted"><?= htmlspecialchars($d['label']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!$isLogged): ?>
                    <a href="/Real-Estate-Project/public/login.php" class="card-btn" style="margin-left:10px;">
                        Login to save
                    </a>
                <?php else: ?>
                    <button id="favBtn" class="card-btn" data-id="<?= (int) $property['id'] ?>"
                        style="margin-left:10px; background:<?= $isFavorite ? '#dc2626' : '#374151' ?>;">
                        <?= $isFavorite ? 'Saved' : 'Save' ?>
                    </button>
                <?php endif; ?>

                <p class="muted" id="meta">
                    Type: <?= htmlspecialchars($property['type']) ?> &bull; Status:
                    <?= htmlspecialchars($property['status']) ?>
                </p>

                <?php
                $pdf = null;
                foreach (($media ?? []) as $m) {
                    if (($m['file_type'] ?? '') === 'pdf') {
                        $pdf = $m['file_path'] ?? null;
                        break;
                    }
                }
                ?>
                <?php if ($pdf): ?>
                    <p><a href="<?= htmlspecialchars(mediaUrl($pdf)) ?>" target="_blank" rel="noopener">Open PDF</a></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    (() => {
        const favBtn = document.getElementById('favBtn');
        if (!favBtn) return;

        favBtn.addEventListener('click', async () => {
            const id = favBtn.dataset.id;

            try {
                const res = await fetch('/Real-Estate-Project/public/favorite.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'property_id=' + encodeURIComponent(id)
                });

                const data = await res.json();

                if (!res.ok) {
                    if (data && data.error === 'AUTH_REQUIRED') {
                        window.location.href = '/Real-Estate-Project/public/login.php';
                        return;
                    }
                    throw new Error(data && data.error ? data.error : 'Request failed');
                }

                const isFav = typeof data.is_favorite !== 'undefined'
                    ? !!data.is_favorite
                    : !!data.favorited;
                favBtn.textContent = isFav ? 'Saved' : 'Save';
                favBtn.style.background = isFav ? '#dc2626' : '#374151';
            } catch (err) {
                console.error(err);
                alert('Favorite failed: ' + err.message);
            }
        });
    })();
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
