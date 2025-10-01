<section class="gallery-page">
    <div class="container">
        <h1><?= htmlspecialchars($page['title'] ?? 'Galerie') ?></h1>
        <p><?= nl2br(htmlspecialchars($page['content'] ?? 'Atmosféra klubu v obrazech.')) ?></p>
        <?php if (!empty($items)): ?>
            <div class="gallery-grid large">
                <?php foreach ($items as $item): ?>
                    <figure>
                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Galerie') ?>">
                        <?php if (!empty($item['title'])): ?>
                            <figcaption><?= htmlspecialchars($item['title']) ?></figcaption>
                        <?php endif; ?>
                        <?php if (!empty($item['description'])): ?>
                            <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                        <?php endif; ?>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>V galerii zatím nejsou žádné fotografie.</p>
        <?php endif; ?>
    </div>
</section>
