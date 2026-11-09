# Symfony Test API

Een CRUD testproject gebouwd met **Symfony 7.4**.

## Vereisten

- **PHP** >= 8.2
- **Composer** (voor het beheren van afhankelijkheden)
- **SQLite** (standaard database) of een ander ondersteund databasesysteem

## Installatie

### 1. Afhankelijkheden installeren
```bash
composer install
```

### 2. Omgevingsvariabelen configureren
Kopieer het .env bestand naar .env.local en configureer indien nodig:
```bash
cp .env .env.local
```

De volgende variabelen zijn beschikbaar:

APP_ENV: Applicatieomgeving (dev, prod, test)
APP_SECRET: Veiligheidscode voor de applicatie
DATABASE_URL: Databaseverbindingsstring
DEFAULT_URI: Standaard URI voor URL-generatie

### 3. Database initialiseren
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Gebruik

Applicatie starten
```bash
symfony server:start
```

Migraties uitvoeren
```bash
php bin/console doctrine:migrations:migrate
```

Nieuwe migratie creëren:
```bash
php bin/console make:migration
```

Entity genereren
```bash
php bin/console make:entity
```

Controller creëren
```bash
php bin/console make:controller
```

### 4. CRUD Endpoints
GET	/api/products	index()	findAll()	Alle producten ophalen
GET	/api/products/{id}	show()	getProduct($id)	Specifiek product ophalen
POST	/api/products	create()	createProduct()	Nieuw product aanmaken
PUT	/api/products/{id}	update()	updateProduct()	Product bijwerken
DELETE	/api/products/{id}	delete()	deleteProduct()	Product verwijderen
