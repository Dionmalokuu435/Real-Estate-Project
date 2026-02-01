<?php
// helpers
function mediaUrl(string $path): string
{
    if (preg_match('#^https?://#i', $path))
        return $path;
    return "/Real-Estate/public/" . ltrim($path, '/');
}
function subtitleLabel(?string $type): string
{
    return $type === 'house' ? 'Showing: Houses'
        : ($type === 'apartment' ? 'Showing: Apartments'
            : ($type === 'land' ? 'Showing: Lands' : 'Showing: All Properties'));
}

$type = $_GET['type'] ?? null; // all | house | apartment | land
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listings</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="/Real-Estate/public/assets/css/listings-styling.css" />
</head>

<body>
    <div class="container">
        <header>
            <div class="topbar">
                <div>
                    <h1>Prime Properties</h1>
                    <p class="subtitle" id="pageSubtitle"><?= htmlspecialchars(subtitleLabel($type)) ?></p>
                </div>
                <a class="back" href="/Real-Estate/public/index.php">← Back</a>
            </div>

            <div class="filter-section">
                <a class="filter-btn <?= $type === null ? 'active' : '' ?>"
                    href="/Real-Estate/public/listings.php">
                    <i class="fa-solid fa-table-cells"></i> All Properties
                </a>
                <a class="filter-btn <?= $type === 'house' ? 'active' : '' ?>"
                    href="/Real-Estate/public/listings.php?type=house">
                    <i class="fa-solid fa-house"></i> Houses
                </a>
                <a class="filter-btn <?= $type === 'apartment' ? 'active' : '' ?>"
                    href="/Real-Estate/public/listings.php?type=apartment">
                    <i class="fa-solid fa-building"></i> Apartments
                </a>
                <a class="filter-btn <?= $type === 'land' ? 'active' : '' ?>"
                    href="/Real-Estate/public/listings.php?type=land">
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

                            <a class="card-btn" href="/Real-Estate/public/details.php?id=<?= (int) $p['id'] ?>">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</body>

</html>