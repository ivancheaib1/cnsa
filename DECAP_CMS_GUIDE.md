# 🎯 Decap CMS — Guía de Uso

## Acceder al Admin Panel

1. **Inicia el servidor local:**
   ```bash
   npm run dev
   ```

2. **Abre en navegador:**
   ```
   http://localhost:4321/admin
   ```

3. **Login con GitHub:**
   - Click "Login with GitHub"
   - Autoriza la aplicación
   - ¡Listo!

---

## Crear Contenido

### 1️⃣ Blog Post

1. Click en **"Blog Posts"** (sidebar izquierdo)
2. Click **"New Blog Post"**
3. Rellena:
   - **Title:** "Mi Primer Artículo"
   - **Slug:** auto-generado (puedes editar)
   - **Excerpt:** Resumen corto
   - **Category:** Selecciona una
   - **Author:** Tu nombre
   - **Featured Image:** Sube imagen
   - **Read Time:** "5 min"
   - **Published Date:** Hoy
   - **Content:** Escribe el artículo en Markdown

4. Click **"Publish"**

**Resultado:** Se crea archivo en `src/content/blog/mi-primer-articulo.md`

### 2️⃣ Project

Igual que Blog Posts, pero en **"Projects"** collection.

### 3️⃣ Product

Igual que Blog Posts, pero en **"Products"** collection.

---

## Integrar con Astro

### Blog Posts

Edita: `src/pages/blog.astro`

**Antes:**
```ts
const articles = [
  { title: 'Article 1', ... },
];
```

**Después:**
```ts
import { getBlogPosts, getImageUrl } from '@/lib/decap';

const blogData = getBlogPosts();
const articles = blogData.map((post: any) => ({
  title: post.title,
  excerpt: post.excerpt,
  author: post.author,
  date: post.publishedAt,
  category: post.category,
  image: getImageUrl(post.image),
  readTime: post.readTime,
  slug: post.slug,
}));
```

---

### Products

Edita: `src/pages/products.astro`

```ts
import { getProducts, getImageUrl } from '@/lib/decap';

export async function getStaticPaths() {
  const products = getProducts();
  return products.map(product => ({
    params: { slug: product.slug },
    props: { product },
  }));
}

const allProducts = getProducts();
```

---

### Projects

Edita: `src/pages/projects.astro`

```ts
import { getProjects, getImageUrl } from '@/lib/decap';

const projectsData = getProjects();
const projects = projectsData.map((proj: any) => ({
  title: proj.title,
  location: proj.location,
  year: proj.year,
  category: proj.category,
  description: proj.description,
  image: getImageUrl(proj.image),
  featured: proj.featured,
}));
```

---

## ¿Cómo funciona?

```
1. Editas contenido en http://localhost:4321/admin
2. Click "Publish" → se guarda en src/content/blog/*.md
3. Astro lee los archivos .md
4. Astro genera HTML estático
5. Cambios = nuevo commit en GitHub
```

---

## Markdown Tips

En el editor de Decap CMS, puedes usar Markdown:

```markdown
# Heading 1
## Heading 2

**Bold text**
*Italic text*

- Lista item 1
- Lista item 2

[Link](https://example.com)

![Image alt](image.jpg)

> Blockquote

\`\`\`code
código aquí
\`\`\`
```

---

## Imágenes

- Las imágenes se suben a: `public/uploads/`
- Se referencian como: `/uploads/mi-imagen.jpg`
- En el HTML generado aparecen correctamente

---

## Borrar Contenido

1. Click en el artículo/proyecto/producto
2. Click en el icono **"Delete"** (arriba a la derecha)
3. Confirma

El archivo `.md` se borra de GitHub automáticamente.

---

## Editar Contenido Existente

1. Click en el artículo que quieres editar
2. Cambia los campos
3. Click **"Update"** o **"Publish"**
4. Se hace commit automático a GitHub

---

## Deploy a Producción

Una vez tengas todo listo:

```bash
git push origin main  # Sube los cambios
npm run build         # Genera HTML estático
# Sube dist/ a cPanel
```

---

## ¡Listo! 🎉

Ahora tienes:
- ✅ CMS visual y hermoso
- ✅ Contenido en Markdown (versionado en GitHub)
- ✅ Astro genera HTML estático
- ✅ Sin servidor Node.js en producción
- ✅ Sin base de datos
- ✅ Gratis forever

**Próximos pasos:**
1. Integra las 3 colecciones en las páginas Astro (arriba)
2. Test local: `npm run dev`
3. Crea contenido de prueba desde el CMS
4. Verifica que aparece en el sitio
5. ¡Deploy a producción!
