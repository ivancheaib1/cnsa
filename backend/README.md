# Backend PHP API — CNSA Paraguay

## Requisitos

- PHP 7.4+ con extensión PDO MySQL
- MySQL 5.7+ (ya tienes corriendo)
- Servidor web (Apache, Nginx)

---

## Instalación Local

### 1. Copiar archivos al servidor

Copia la carpeta `backend-php/` a tu servidor PHP:
- **cPanel:** `/home/usuario/public_html/api/`
- **Local:** `C:\xampp\htdocs\cnsa-backend\` (si usas XAMPP)

### 2. Configurar .env

Edita `.env` con tus credenciales MySQL:
```
DB_HOST=localhost
DB_PORT=3306
DB_USER=cnsa
DB_PASS=123cnsa123
DB_NAME=cnsa
JWT_SECRET=tu-clave-super-segura-cambiar-en-produccion
ADMIN_EMAIL=admin@cnsa.com
ADMIN_PASSWORD=admin123
```

### 3. Verificar permisos

Las carpetas deben ser accesibles por el servidor PHP:
```bash
chmod 755 /home/usuario/public_html/api/
chmod 644 /home/usuario/public_html/api/.env
```

---

## Usar en Docker

Si quieres correr el backend en Docker junto a MySQL:

### docker-compose.yml

```yaml
version: '3.8'

services:
  mysql:
    image: mysql:8.0
    container_name: cnsa-mysql
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: rootpass123
      MYSQL_DATABASE: cnsa
      MYSQL_USER: cnsa
      MYSQL_PASSWORD: 123cnsa123
    volumes:
      - mysql-data:/var/lib/mysql

  php-api:
    image: php:8.1-apache
    container_name: cnsa-api
    ports:
      - "8000:80"
    volumes:
      - ./backend-php:/var/www/html
    depends_on:
      - mysql
    environment:
      - DB_HOST=mysql
      - DB_USER=cnsa
      - DB_PASS=123cnsa123
      - DB_NAME=cnsa

volumes:
  mysql-data:
```

Levantar:
```bash
docker-compose up -d
```

API disponible en: `http://localhost:8000/`

---

## Endpoints API

### 1. Login

**POST** `/api/login`

Request:
```json
{
  "email": "admin@cnsa.com",
  "password": "admin123"
}
```

Response:
```json
{
  "success": true,
  "token": "eyJhbGc...",
  "user": {
    "email": "admin@cnsa.com",
    "role": "admin"
  }
}
```

### 2. Blog Posts

**GET** `/api/blog-posts`
- Listar todos los posts

**GET** `/api/blog-posts?slug=mi-post`
- Obtener post por slug

**POST** `/api/blog-posts` (requiere token)
```json
{
  "title": "Mi Post",
  "slug": "mi-post",
  "excerpt": "Resumen",
  "content": "Contenido...",
  "category": "Tecnología",
  "author": "Juan",
  "image": "/uploads/image.jpg",
  "readTime": "5 min",
  "publishedAt": "2026-01-06"
}
```

**PUT** `/api/blog-posts?id=1` (requiere token)
- Actualizar post

**DELETE** `/api/blog-posts?id=1` (requiere token)
- Borrar post

### 3. Projects

**GET** `/api/projects`
**POST** `/api/projects` (requiere token)
**PUT** `/api/projects?id=1` (requiere token)
**DELETE** `/api/projects?id=1` (requiere token)

Misma estructura que blog posts, con campos:
- title, slug, location, year, category, description, content, image, featured

### 4. Products

**GET** `/api/products`
**POST** `/api/products` (requiere token)
**PUT** `/api/products?id=1` (requiere token)
**DELETE** `/api/products?id=1` (requiere token)

Misma estructura, con campos:
- title, slug, subtitle, description, icon, image, order

---

## Headers requeridos

Para POST, PUT, DELETE, incluye:

```
Authorization: Bearer <token>
Content-Type: application/json
```

---

## Test API con curl

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@cnsa.com","password":"admin123"}'

# Get posts
curl http://localhost:8000/api/blog-posts

# Create post (reemplaza TOKEN)
curl -X POST http://localhost:8000/api/blog-posts \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer TOKEN" \
  -d '{
    "title":"Mi Post",
    "slug":"mi-post",
    "excerpt":"Resumen",
    "content":"Contenido",
    "category":"Tecnología",
    "author":"Juan",
    "publishedAt":"2026-01-06"
  }'
```

---

## En Producción (cPanel)

1. Copia carpeta `backend-php/` a `/home/usuario/public_html/api/`
2. Actualiza `.env` con credenciales producción
3. API disponible en: `https://tudominio.com/api/`
4. Decap CMS apunta a: `https://tudominio.com/api/`

---

## Seguridad

- ⚠️ Cambiar `JWT_SECRET` en producción
- ⚠️ Cambiar `ADMIN_PASSWORD` en producción
- ✅ Los tokens expiran en 30 días
- ✅ Todas las modificaciones requieren token JWT

---

## ¿Problemas?

**"Database connection failed"**
- Verifica credenciales en `.env`
- Verifica que MySQL está corriendo
- Verifica DB_HOST es correcto

**"CORS error"**
- Headers CORS ya están configurados
- Si persiste, verifica que el servidor permite CORS

**"Token expired"**
- Hacer login nuevamente para obtener nuevo token
