<?php
use App\Security\CsrfTokenManager;
$csrf = CsrfTokenManager::getToken();
$contactInfo = array_merge([
    'phone' => '',
    'email' => '',
    'facebook' => '',
    'address' => '',
    'reservation_note' => '',
], $contactInfo ?? []);
$reservationSuccess = !empty($reservationSuccess);
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
        <h2>Kontakt &amp; rezervace</h2>
        <?php if ($reservationSuccess): ?>
            <div class="alert">
                <strong>Rezervace odeslána</strong>
                Děkujeme, ozveme se vám s potvrzením co nejdříve.
            </div>
        <?php endif; ?>
        <div class="contact-layout">
            <div class="contact-card card">
                <h3>Ozvěte se nám</h3>
                <?php $hasContactInfo = $contactInfo['phone'] || $contactInfo['email'] || $contactInfo['facebook'] || $contactInfo['address']; ?>
                <?php if ($hasContactInfo): ?>
                    <ul class="contact-list">
                        <?php if ($contactInfo['phone']): ?>
                            <?php $telLink = preg_replace('/[^0-9+]/', '', $contactInfo['phone']); ?>
                            <li>
                                <span class="label">Telefon</span>
                                <a href="tel:<?= htmlspecialchars($telLink) ?>"><?= htmlspecialchars($contactInfo['phone']) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($contactInfo['email']): ?>
                            <li>
                                <span class="label">E-mail</span>
                                <a href="mailto:<?= htmlspecialchars($contactInfo['email']) ?>"><?= htmlspecialchars($contactInfo['email']) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($contactInfo['facebook']): ?>
                            <li>
                                <span class="label">Facebook</span>
                                <a href="<?= htmlspecialchars($contactInfo['facebook']) ?>" target="_blank" rel="noreferrer noopener"><?= htmlspecialchars($contactInfo['facebook']) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($contactInfo['address']): ?>
                            <li>
                                <span class="label">Adresa</span>
                                <span><?= nl2br(htmlspecialchars($contactInfo['address'])) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php else: ?>
                    <p>Kontakt doplňte v administraci a zobrazí se zde.</p>
                <?php endif; ?>
            </div>
            <div class="reservation-card card">
                <h3>Rezervace akce v klubu</h3>
                <form method="post" action="/rezervace/odeslat">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>" />
                    <div class="form-row">
                        <label for="reservation-name">Jméno
                            <input type="text" id="reservation-name" name="name" required>
                        </label>
                        <label for="reservation-email">E-mail
                            <input type="email" id="reservation-email" name="email" required>
                        </label>
                    </div>
                    <div class="form-row">
                        <label for="reservation-phone">Telefon
                            <input type="tel" id="reservation-phone" name="phone" placeholder="+420 ...">
                        </label>
                        <label for="reservation-date">Preferovaný termín
                            <input type="date" id="reservation-date" name="event_date">
                        </label>
                    </div>
                    <label for="reservation-message">Detaily akce</label>
                    <textarea id="reservation-message" name="message" rows="4" placeholder="Kolik hostů čekáte a jaký typ programu preferujete?" required></textarea>
                    <button type="submit" class="btn-primary">Odeslat poptávku</button>
                    <?php if ($contactInfo['reservation_note']): ?>
                        <p class="reservation-note"><?= nl2br(htmlspecialchars($contactInfo['reservation_note'])) ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</section>
