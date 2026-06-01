# Backend PHP + MySQL — CNSA Paraguay

## 🎯 Arquitectura Final (SIN Node.js)

```
MySQL 5.7+ (Docker)
  ├── blog_posts (tabla)
  ├── projects (tabla)
  └── products (tabla)
  └── Acceso: localhost:3306 (user: cnsa / pass: 123cnsa123)

Backend PHP API (localhost:8000)
  ├── /api/login (POST) → JWT token
  ├── /api/blog-posts (GET/POST/PUT/DELETE)
  ├── /api/projects (GET/POST/PUT/DELETE)
  └── /api/products (GET/POST/PUT/DELETE)
  └── Ubicación: /backend/

Frontend Astro (localhost:4324)
  ├── npm run dev → desarrollo local
  ├── npm run build → genera HTML estático
  └── Consume: Backend API PHP

Admin Panel (localhost:4324/admin)
  └── Decap CMS apunta a Backend PHP
```

---

## 📋 Setup Backend PHP

### Opción 1: XAMPP (Local)

1. **Copiar carpeta backend al htdocs:**
   ```
   C:\xampp\htdocs\cnsa-api\backend\
   ```

2. **Editar .env:**
   ```
   DB_HOST=localhost
   DB_USER=cnsa
   DB_PASS=123cnsa123
   DB_NAME=cnsa
   JWT_SECRET=tu-clave-segura
   ADMIN_EMAIL=admin@cnsa.com
   ADMIN_PASSWORD=admin123
   ```

3. **Acceso:**
   ```
   http://localhost/cnsa-api/
   ```

---

### Opción 2: Docker

1. **Crea docker-compose.yml en la raíz:**

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
      - ./cnsa/backend:/var/www/html
    depends_on:
      - mysql
    environment:
      - DB_HOST=mysql

volumes:
  mysql-data:
```

2. **Levantar:**
   ```bash
   docker-compose up -d
   ```

3. **Acceso:**
   ```
   http://localhost:8000/
   ```

---

## ✅ Verificar Backend Funciona

### Test Login

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@cnsa.com","password":"admin123"}'
```

**Respuesta esperada:**
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

### Test API Blog

```bash
# Listar todos los posts
curl http://localhost:8000/api/blog-posts

# Crear post (reemplaza TOKEN)
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

## 🌐 Admin Panel (Próximamente)

Una vez el backend funcione, vamos a:
1. Configurar Decap CMS para usar tu Backend PHP
2. Login local (usuario/contraseña)
3. Crear/editar contenido en la base de datos MySQL

---

## 📦 En Producción (cPanel)

1. **Copiar carpeta backend a cPanel:**
   ```
   /home/usuario/public_html/api/backend/
   ```

2. **Editar .env con credenciales producción**

3. **Acceso:**
   ```
   https://tudominio.com/api/
   ```

4. **Decap CMS apunta a:**
   ```
   https://tudominio.com/api/
   ```

---

## 📝 Endpoints API

### Login
```
POST /api/login
{
  "email": "admin@cnsa.com",
  "password": "admin123"
}
```

### Blog Posts
```
GET    /api/blog-posts           (listar todos)
GET    /api/blog-posts?slug=x    (por slug)
POST   /api/blog-posts           (crear) - requiere token
PUT    /api/blog-posts?id=1      (actualizar) - requiere token
DELETE /api/blog-posts?id=1      (borrar) - requiere token
```

### Projects
```
GET    /api/projects
GET    /api/projects?slug=x
POST   /api/projects        - requiere token
PUT    /api/projects?id=1   - requiere token
DELETE /api/projects?id=1   - requiere token
```

### Products
```
GET    /api/products
GET    /api/products?slug=x
POST   /api/products        - requiere token
PUT    /api/products?id=1   - requiere token
DELETE /api/products?id=1   - requiere token
```

---

## 🔐 Seguridad

- ✅ JWT tokens (30 días expiration)
- ✅ CORS configurado
- ✅ Todas las modificaciones requieren token
- ⚠️ Cambiar `JWT_SECRET` en producción
- ⚠️ Cambiar `ADMIN_PASSWORD` en producción

---

## ❓ Troubleshooting

**"Database connection failed"**
- Verifica MySQL está corriendo
- Verifica credenciales en .env
- Verifica que la base de datos "cnsa" existe

**"Unauthorized"**
- Necesitas incluir header: `Authorization: Bearer TOKEN`
- El token debe venir del endpoint /api/login

**"CORS error"**
- Headers CORS ya están configurados
- Verifica que el backend PHP está accesible

---

## 🚀 Próximo Paso

Una vez el backend está funcionando:
→ Configuramos Decap CMS para usar tu Backend PHP
→ Configuramos Astro para consumir la API

¿Tienes el backend levantado? 👈
