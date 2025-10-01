<?php
use App\Security\CsrfTokenManager;
$csrf = CsrfTokenManager::getToken();
?>
<section class="hero">
    <div class="container">
        <div class="hero-card">
            <h1><?= htmlspecialchars($page['title'] ?? 'Riko Klub') ?></h1>
            <p><?= nl2br(htmlspecialchars($page['content'] ?? '')) ?></p>
            <div class="cta-row">
                <a class="btn-primary" href="#program">Program</a>
                <a class="btn-secondary" href="/galerie">Galerie</a>
            </div>
        </div>
    </div>
</section>

<section id="program">
    <div class="container">
        <h2>Nadcházející program</h2>
        <?php if (!empty($events)): ?>
            <ul class="events">
                <?php foreach ($events as $event): ?>
                    <li class="event">
                        <div class="date">
                            <strong><?= htmlspecialchars(date('j. n.', strtotime($event['event_date']))) ?></strong>
                            <span><?= htmlspecialchars(date('Y', strtotime($event['event_date']))) ?></span>
                        </div>
                        <div class="title"><?= htmlspecialchars($event['title']) ?></div>
                        <div class="meta">
                            <?php if (!empty($event['starts_at'])): ?>
                                <span><?= htmlspecialchars(substr($event['starts_at'], 0, 5)) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['price'])): ?>
                                <span><?= htmlspecialchars($event['price']) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($event['description'])): ?>
                            <p class="description"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Program bude brzy doplněn.</p>
        <?php endif; ?>
    </div>
</section>

<section id="galerie" class="alt">
    <div class="container">
        <h2>Galerie</h2>
        <?php if (!empty($gallery)): ?>
            <div class="gallery-grid">
                <?php foreach ($gallery as $item): ?>
                    <figure>
                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title'] ?? 'Galerie') ?>">
                        <?php if (!empty($item['title'])): ?>
                            <figcaption><?= htmlspecialchars($item['title']) ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endforeach; ?>
            </div>
            <p><a href="/galerie">Celá galerie &rarr;</a></p>
        <?php else: ?>
            <p>Zatím nemáme nahrané fotografie.</p>
        <?php endif; ?>
    </div>
</section>

<section id="kontakt">
    <div class="container">
        <h2>Kontaktujte nás</h2>
        <form method="post" action="/kontakt/odeslat" class="card">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>" />
            <div class="form-group">
                <label for="name">Jméno</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Zpráva</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Odeslat zprávu</button>
        </form>
    </div>
</section>
