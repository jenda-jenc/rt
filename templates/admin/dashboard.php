<section class="admin-grid">
    <article class="admin-card">
        <h2>Program</h2>
        <form method="post" action="/admin/events/save" class="stacked">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
            <?php if (!empty($eventToEdit)): ?>
                <input type="hidden" name="id" value="<?= (int) $eventToEdit['id'] ?>">
            <?php endif; ?>
            <h3>Přidat / upravit akci</h3>
            <div class="form-row">
                <label>Název
                    <input type="text" name="title" value="<?= htmlspecialchars($eventToEdit['title'] ?? '') ?>" required>
                </label>
                <label>Datum
                    <input type="date" name="event_date" value="<?= htmlspecialchars($eventToEdit['event_date'] ?? '') ?>" required>
                </label>
                <label>Začátek
                    <input type="time" name="starts_at" value="<?= htmlspecialchars($eventToEdit['starts_at'] ?? '') ?>">
                </label>
                <label>Vstupné
                    <input type="text" name="price" value="<?= htmlspecialchars($eventToEdit['price'] ?? '') ?>" placeholder="Dobrovolné">
                </label>
            </div>
            <label>Popis
                <textarea name="description" rows="3"><?= htmlspecialchars($eventToEdit['description'] ?? '') ?></textarea>
            </label>
            <button class="btn-primary" type="submit">Uložit</button>
            <?php if (!empty($eventToEdit)): ?>
                <a class="btn-secondary" href="/admin">Zrušit úpravy</a>
            <?php endif; ?>
        </form>
        <?php if (!empty($events)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Název</th>
                        <th>Datum</th>
                        <th>Čas</th>
                        <th>Vstupné</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars($event['event_date']) ?></td>
                        <td><?= htmlspecialchars($event['starts_at'] ?? '') ?></td>
                        <td><?= htmlspecialchars($event['price'] ?? '') ?></td>
                        <td>
                            <a href="/admin?event=<?= (int) $event['id'] ?>">Upravit</a>
                            <form method="post" action="/admin/events/delete" class="inline">
                                <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                                <input type="hidden" name="id" value="<?= (int) $event['id'] ?>">
                                <button type="submit">Smazat</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </article>

    <article class="admin-card">
        <h2>Galerie</h2>
        <form method="post" action="/admin/gallery/save" class="stacked">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
            <?php if (!empty($galleryToEdit)): ?>
                <input type="hidden" name="id" value="<?= (int) $galleryToEdit['id'] ?>">
            <?php endif; ?>
            <div class="form-row">
                <label>Název
                    <input type="text" name="title" value="<?= htmlspecialchars($galleryToEdit['title'] ?? '') ?>">
                </label>
                <label>URL obrázku
                    <input type="url" name="image_path" value="<?= htmlspecialchars($galleryToEdit['image_path'] ?? '') ?>" required>
                </label>
                <label>Pozice
                    <input type="number" name="position" value="<?= htmlspecialchars((string) ($galleryToEdit['position'] ?? 0)) ?>">
                </label>
            </div>
            <label>Popis
                <textarea name="description" rows="2"><?= htmlspecialchars($galleryToEdit['description'] ?? '') ?></textarea>
            </label>
            <button class="btn-primary" type="submit">Uložit položku</button>
            <?php if (!empty($galleryToEdit)): ?>
                <a class="btn-secondary" href="/admin">Zrušit úpravy</a>
            <?php endif; ?>
        </form>
        <?php if (!empty($galleryItems)): ?>
            <ul class="simple-list">
                <?php foreach ($galleryItems as $item): ?>
                    <li>
                        <strong><?= htmlspecialchars($item['title'] ?? $item['image_path']) ?></strong>
                        <span><?= htmlspecialchars($item['image_path']) ?></span>
                        <a href="/admin?gallery=<?= (int) $item['id'] ?>">Upravit</a>
                        <form method="post" action="/admin/gallery/delete" class="inline">
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <button type="submit">Smazat</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>

    <article class="admin-card">
        <h2>Kontakt &amp; rezervace</h2>
        <form method="post" action="/admin/contact-info/save" class="stacked">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
            <div class="form-row">
                <label>Telefon
                    <input type="text" name="phone" value="<?= htmlspecialchars($contactInfo['phone'] ?? '') ?>" placeholder="+420 777 123 456">
                </label>
                <label>E-mail
                    <input type="email" name="email" value="<?= htmlspecialchars($contactInfo['email'] ?? '') ?>" placeholder="info@riko-klub.cz">
                </label>
                <label>Facebook
                    <input type="url" name="facebook" value="<?= htmlspecialchars($contactInfo['facebook'] ?? '') ?>" placeholder="https://facebook.com/rikomusicclub">
                </label>
            </div>
            <label>Adresa
                <textarea name="address" rows="2" placeholder="Dominikánská 12&#10;602 00 Brno"><?= htmlspecialchars($contactInfo['address'] ?? '') ?></textarea>
            </label>
            <label>Poznámka k rezervaci
                <textarea name="reservation_note" rows="3" placeholder="Např. požadavek na techniku, časový harmonogram..."><?= htmlspecialchars($contactInfo['reservation_note'] ?? '') ?></textarea>
            </label>
            <button class="btn-primary" type="submit">Uložit kontaktní údaje</button>
        </form>

        <h3>Rezervace</h3>
        <?php if (!empty($reservations)): ?>
            <ul class="simple-list">
                <?php foreach ($reservations as $reservation): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($reservation['name']) ?></strong>
                            <span><?= htmlspecialchars($reservation['email']) ?></span>
                            <?php if (!empty($reservation['phone'])): ?>
                                <span><?= htmlspecialchars($reservation['phone']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($reservation['event_date'])): ?>
                                <span>Termín: <?= htmlspecialchars($reservation['event_date']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($reservation['created_at'])): ?>
                                <span>Vytvořeno: <?= htmlspecialchars($reservation['created_at']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($reservation['message'])): ?>
                                <p><?= nl2br(htmlspecialchars($reservation['message'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <form method="post" action="/admin/reservations/delete" class="inline">
                            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                            <input type="hidden" name="id" value="<?= (int) $reservation['id'] ?>">
                            <button type="submit">Smazat</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Zatím žádné rezervace.</p>
        <?php endif; ?>
    </article>

    <article class="admin-card">
        <h2>Stránky</h2>
        <form method="post" action="/admin/pages/save" class="stacked">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
            <?php if (!empty($pageToEdit)): ?>
                <input type="hidden" name="id" value="<?= (int) $pageToEdit['id'] ?>">
            <?php endif; ?>
            <div class="form-row">
                <label>Slug
                    <input type="text" name="slug" value="<?= htmlspecialchars($pageToEdit['slug'] ?? '') ?>" placeholder="např. home" required>
                </label>
                <label>Název
                    <input type="text" name="title" value="<?= htmlspecialchars($pageToEdit['title'] ?? '') ?>" required>
                </label>
            </div>
            <label>Obsah
                <textarea name="content" rows="4"><?= htmlspecialchars($pageToEdit['content'] ?? '') ?></textarea>
            </label>
            <button class="btn-primary" type="submit">Uložit stránku</button>
            <?php if (!empty($pageToEdit)): ?>
                <a class="btn-secondary" href="/admin">Zrušit úpravy</a>
            <?php endif; ?>
        </form>
        <?php if (!empty($pages)): ?>
            <ul class="simple-list">
                <?php foreach ($pages as $pageItem): ?>
                    <li>
                        <div>
                            <strong><?= htmlspecialchars($pageItem['title']) ?></strong> <span>/<?= htmlspecialchars($pageItem['slug']) ?></span>
                        </div>
                        <a href="/admin?page=<?= htmlspecialchars($pageItem['slug']) ?>">Upravit</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>
</section>
