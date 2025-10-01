-- MySQL compatible schema for Riko Klub CMS
CREATE TABLE IF NOT EXISTS pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug VARCHAR(120) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL,
    starts_at TIME,
    price VARCHAR(120),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    description TEXT,
    position INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT OR IGNORE INTO pages (id, slug, title, content) VALUES
    (1, 'home', 'Riko Klub', 'Hudební klub Riko vás vítá. Sledujte aktuální program a užijte si večer v našem baru.'),
    (2, 'gallery', 'Galerie', 'Nahlédněte do našich akcí a atmosféry.');

INSERT OR IGNORE INTO events (id, title, description, event_date, starts_at, price) VALUES
    (1, 'Bluesový večer', 'Živá hudba s domácí kapelou a hosty.', '2024-12-05', '20:00', '150 Kč'),
    (2, 'Open Mic', 'Přijďte si zahrát nebo zazpívat.', '2024-12-12', '19:30', 'Dobrovolné');

INSERT OR IGNORE INTO gallery_items (id, title, image_path, description, position) VALUES
    (1, 'Bar', 'https://picsum.photos/seed/riko1/800/600', 'Atmosféra našeho baru.', 1),
    (2, 'Koncert', 'https://picsum.photos/seed/riko2/800/600', 'Momentka z koncertu.', 2),
    (3, 'Hosté', 'https://picsum.photos/seed/riko3/800/600', 'Pohodová nálada.', 3);

INSERT OR IGNORE INTO admin_users (id, username, password_hash) VALUES
    (1, 'admin', '$2y$10$mmRSu1cWmvMRGsiE9zMDFuFXl8vLwTkx2UY8ailqXFz3vGN9VOGBe');
