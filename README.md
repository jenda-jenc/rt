# Riko Klub CMS

Modernizovaná ukázková aplikace pro klub Riko postavená na PHP 8.4 se šablonovacím systémem, jednoduchým routerem a administračním rozhraním.

## Požadavky

- PHP 8.4+
- Rozšíření PDO (výchozí je SQLite, ale struktura je kompatibilní s MySQL)
- Composer

## Instalace

```bash
composer install
php -S localhost:8000 -t public
```

Při prvním spuštění se automaticky vytvoří soubor `var/database.sqlite` a naplní se ukázkovými daty. Přihlášení do administrace je dostupné na `/admin` s údaji `admin` / `admin123` (doporučujeme změnit heslo).

### MySQL konfigurace

Nastavte proměnné prostředí `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` a `DB_PASSWORD` (volitelně `DB_PORT` a `DB_CHARSET`), aby se aplikace připojila k MySQL. Pokud nejsou tyto proměnné definované, použije se lokální SQLite databáze ve složce `var/`.

## Struktura projektu

- `public/` – veřejné vstupní body `index.php` a `admin/index.php` + statická aktiva
- `src/` – kontrolery, router, repozitáře a helpery
- `templates/` – šablony pro frontend i administraci
- `database/schema.sql` – datový model a ukázková data

## Vývoj

Obsah programu, galerie a kontakty se spravují v administračním rozhraní. Frontend šablony se automaticky naplňují daty z databáze, včetně CSRF ochrany formulářů.
