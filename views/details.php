<?php
function mediaUrl(string $path): string
{
    if (preg_match('#^https?://#i', $path))
        return $path;
    return "/Real-Estate/public/" . ltrim($path, '/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Property Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="/Real-Estate/public/assets/css/details-styling.css" />
</head>

<body>
    <div class="container">
        <p><a href="/Real-Estate/public/listings.php">← Back to listings</a></p>

        <?php if (empty($property)): ?>
            <div class="card" style="padding:18px;">Property not found.</div>
        <?php else: ?>
            <div class="card">
                <?php
                $img = null;
                foreach ($media as $m) {
                    if ($m['file_type'] === 'image') {
                        $img = $m['file_path'];
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

                    <p class="muted" id="meta">
                        Type: <?= htmlspecialchars($property['type']) ?> • Status:
                        <?= htmlspecialchars($property['status']) ?>
                    </p>

                    <?php
                    $pdf = null;
                    foreach ($media as $m) {
                        if ($m['file_type'] === 'pdf') {
                            $pdf = $m['file_path'];
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
</body>

</html>