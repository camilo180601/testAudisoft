# Mis Sitios Favoritos — Prueba técnica Audisoft

Aplicativo web para administrar una lista de sitios web y sus categorías.
Permite **agregar** y **borrar** sitios (cada uno con su categoría), y
**gestionar categorías** (crear y eliminar, siempre que no estén en uso).

Construido con **Laravel 13**, **MySQL 8** y **Tailwind CSS v4** (vistas Blade).

---

## Funcionalidad

- **Pantalla principal (`/`)** — «Mis sitios favoritos»: tabla con nombre,
  dirección y categoría de cada sitio. Al hacer clic en la dirección, el sitio
  se abre en **una pestaña nueva**. Incluye formulario para agregar y botón
  para borrar cada sitio.
- **Pantalla de categorías (`/categorias`)** — «Mis categorías»: crear y borrar
  categorías. Una categoría **no puede borrarse si está en uso** por algún
  sitio (se muestra el conteo de sitios y el botón queda deshabilitado).
- Enlace **Regresar** de categorías a la página inicial.

### Extras incluidos (más allá del requisito)

- Validación de formularios en servidor (Form Requests) con mensajes en español.
- **Normalización de URL**: si escribes `www.zara.com` se guarda como
  `https://www.zara.com`.
- Nombres de categoría **únicos**.
- Doble protección al borrar categorías en uso: en el controlador **y** a nivel
  de base de datos (`FOREIGN KEY ... ON DELETE RESTRICT`).
- **Modal de confirmación** al borrar (JavaScript, sin librerías).
- **Buscador en vivo** de sitios (filtrado en cliente).
- Favicon de cada sitio, insignias de categoría, estados vacíos y mensajes flash.
- Diseño responsive con Tailwind.
- **Suite de pruebas** (12 tests de feature) que cubren alta, baja y validaciones.

---

## Requisitos

- PHP >= 8.2
- Composer
- MySQL 8.x (o MariaDB compatible)
- Node.js >= 18 y npm (para compilar los assets)

---

## Instalación

```bash
# 1. Dependencias
composer install
npm install

# 2. Variables de entorno
cp .env.example .env
php artisan key:generate
# Ajusta las credenciales DB_* en .env si es necesario
```

Configuración de base de datos por defecto (`.env`):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=audisoft_sitios
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Base de datos — elige **una** opción

**Opción A · Migraciones de Laravel (recomendada)**

```bash
php artisan migrate --seed
```

**Opción B · Script SQL puro (entregable)**

```bash
mysql -u root -p < database/sql/audisoft_sitios.sql
```

Ambas crean las tablas `categories` y `sites` con los mismos datos de ejemplo.

### 4. Compilar assets y levantar

```bash
npm run build         # o `npm run dev` para desarrollo con hot-reload
php artisan serve
```

Abre **http://127.0.0.1:8000**

---

## Pruebas

```bash
php artisan test
```

---

## Estructura relevante

```
app/
├── Http/Controllers/       SiteController, CategoryController
├── Http/Requests/          StoreSiteRequest, StoreCategoryRequest (validación)
└── Models/                 Site, Category (relación 1:N)
database/
├── migrations/             categories, sites (con FK RESTRICT)
├── seeders/                DatabaseSeeder (datos de ejemplo)
└── sql/audisoft_sitios.sql Script SQL de creación (entregable)
resources/
├── views/layouts/app       Layout base + modal de confirmación
├── views/sites/            Pantalla de sitios
├── views/categories/       Pantalla de categorías
├── js/app.js               Modal, buscador y auto-dismiss
└── css/app.css             Tailwind v4
tests/Feature/              SiteTest, CategoryTest
```

---

## Modelo de datos

```
categories                     sites
----------                     -----
id            PK               id            PK
name (unique)                  name
created_at                     url
updated_at                     category_id   FK -> categories.id (RESTRICT)
                               created_at
                               updated_at
```
