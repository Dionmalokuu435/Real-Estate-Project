<?php
function mediaUrl(string $path): string
{
    if (preg_match('#^https?://#i', $path))
        return $path;
    return "/REAL-ESTATE-PROJECT/public/" . ltrim($path, '/');
}
?>

<style>
    /* Latest carousel */
    .latest-section {
        margin-top: 18px;
        padding: 16px;
    }

    .latest-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .latest-controls {
        display: flex;
        gap: 10px;
    }

    .latest-btn {
        width: 42px;
        height: 42px;
        border: 1px solid #e5e7eb;
        background: #fff;
        border-radius: 12px;
        cursor: pointer;
        display: grid;
        place-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        color: black;
    }

    .latest-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .latest-viewport {
        position: relative;
    }

    .latest-track {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: calc((100% - 40px) / 3);
        gap: 20px;

        overflow: hidden;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;

        padding: 4px;
    }

    .latest-item {
        scroll-snap-align: start;
    }

    @media (max-width: 1024px) {
        .latest-track {
            grid-auto-columns: calc((100% - 20px) / 2);
        }
    }

    @media (max-width: 640px) {
        .latest-track {
            grid-auto-columns: 100%;
        }
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="/REAL-ESTATE-PROJECT/public/assets/css/style.css" />
    <!-- <link rel="stylesheet" href="/REAL-ESTATE-PROJECT/public/assets/css/listings-styling.css" /> -->
</head>

<body>

    <!-- HERO / HEADER (vendose këtu markup-un e slider-it nga index.html) -->
    <div class="textbox">

        <div class="slider">
            <div class="slide active"
                style="background-image:url('https://i.pinimg.com/564x/fd/e1/6b/fde16bb3d450d9da747eeb21c7360884.jpg')">
            </div>
            <div class="slide"
                style="background-image:url('https://i.pinimg.com/564x/29/c5/a1/29c5a1a2b501193ff0903ddcac802d2f.jpg')">
            </div>
            <div class="slide"
                style="background-image:url('https://i.pinimg.com/564x/00/f2/ca/00f2ca2703f98f7b8f96208d9ba49e17.jpg')">
            </div>

            <button class="slider-btn prev" type="button" aria-label="Previous Slide">‹</button>
            <button class="slider-btn next" type="button" aria-label="Next Slide">›</button>
        </div>

        <div class="hero-content">
            <h2>IF U WANT TO BE SAFE ,COME TO OUR PLACE</h2>
            <p>“Good buildings come from good people,and all problems are solved by good design.”</p>
            <button class="btn" id="workBtn" type="button">Come Work With Us</button>
        </div>

    </div>

    <!-- SECTION: Latest properties -->

    <?php if (empty($latest)): ?>
        <p>No properties found.</p>
    <?php endif; ?>

    <section class="latest-section">
        <div class="latest-head">
            <h2 style="margin:0;">Latest Properties</h2>

            <div class="latest-controls">
                <button class="latest-btn" id="latestPrev" type="button" aria-label="Previous">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="latest-btn" id="latestNext" type="button" aria-label="Next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <?php if (empty($latest)): ?>
            <p>No properties found.</p>
        <?php else: ?>
            <div class="latest-viewport">
                <div class="latest-track" id="latestTrack">
                    <?php foreach ($latest as $p): ?>
                        <div class="latest-item">
                            <div class="card">
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

                                    <?php $features = array_slice(($p['features'] ?? []), 0, 4); ?>
                                    <?php if (!empty($features)): ?>
                                        <div class="card-features">
                                            <?php foreach ($features as $f): ?>
                                                <div class="feature">
                                                    <i class="fas <?= htmlspecialchars($f['icon']) ?>"></i>
                                                    <div class="feature-value"><?= htmlspecialchars($f['value']) ?></div>
                                                    <div class="feature-label"><?= htmlspecialchars($f['label']) ?></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-footer">
                                        <div class="price">
                                            $<?= number_format((float) $p['price']) ?>
                                            <?php if (!empty($p['price_note'])): ?>
                                                <span>/ <?= htmlspecialchars($p['price_note']) ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <a class="card-btn"
                                            href="/REAL-ESTATE-PROJECT/public/details.php?id=<?= (int) $p['id'] ?>">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>


    <p style="margin: 20px 0; justify-self: anchor-center;">
        <a class="filter-btn" href="/REAL-ESTATE-PROJECT/public/listings.php">
            <i class="fa-solid fa-table-cells"></i> View All Properties
        </a>
    </p>
    </div>

    <!-- Nëse keni slider.js nga index.html, vendose këtu -->
    <script src="/REAL-ESTATE-PROJECT/public/assets/js/slider.js"></script>
    <script>
        (function () {
            const track = document.getElementById('latestTrack');
            const prev = document.getElementById('latestPrev');
            const next = document.getElementById('latestNext');
            if (!track || !prev || !next) return;

            function step() {
                const first = track.querySelector('.latest-item');
                if (!first) return 300;
                const cardWidth = first.getBoundingClientRect().width;
                return cardWidth + 20;
            }

            prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
            next.addEventListener('click', () => track.scrollBy({ left: step(), behavior: 'smooth' }));

            function update() {
                const max = track.scrollWidth - track.clientWidth - 1;
                prev.disabled = track.scrollLeft <= 0;
                next.disabled = track.scrollLeft >= max;
            }

            track.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
            update();
        })();
    </script>

</body>

</html>