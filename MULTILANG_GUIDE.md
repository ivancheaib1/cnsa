# Guía de Páginas Multilingües

## Estructura Actual

El sitio soporta 3 idiomas:
- **ES** (Español) - Default, sin prefijo: `/`
- **EN** (English) - Con prefijo: `/en/`
- **PT** (Português) - Con prefijo: `/pt/`

## Crear una Nueva Página

### Opción 1: Página Simple en 3 Idiomas

Para una página simple (como `servicios`), crea archivos por idioma:

**Para la página en español** (`/servicios`):
```
src/pages/servicios.astro
```

**Para la página en inglés** (`/en/servicios`):
```
src/pages/en/servicios.astro
```

**Para la página en portugués** (`/pt/servicios`):
```
src/pages/pt/servicios.astro
```

### Ejemplo de Estructura

```astro
---
import BaseLayout from '@/layouts/BaseLayout.astro';
import Section from '@/components/ui/Section.astro';

const lang = 'es';  // Cambiar a 'en' o 'pt' según corresponda
---

<BaseLayout
  lang={lang}
  title="Servicios | CNSA Paraguay"
  description="Conoce todos nuestros servicios..."
>
  <!-- Contenido aquí -->
</BaseLayout>
```

## Rutas Automáticas

Astro genera automáticamente las rutas según la ubicación:

```
src/pages/servicios.astro          → /servicios
src/pages/en/servicios.astro       → /en/servicios
src/pages/pt/servicios.astro       → /pt/servicios
```

## Navegar entre Idiomas

### En el código HTML:
```html
<!-- Link a versión en inglés -->
<a href="/en/servicios">English</a>

<!-- Link a versión en portugués -->
<a href="/pt/servicios">Português</a>

<!-- Link a versión en español -->
<a href="/servicios">Español</a>
```

### En componentes Astro:
```astro
{lang === 'es' && <a href="/contact">Contacto</a>}
{lang === 'en' && <a href="/en/contact">Contact</a>}
{lang === 'pt' && <a href="/pt/contact">Contato</a>}
```

### O usando una función helper:
```astro
{const getUrl = (path: string) => lang === 'es' ? path : `/${lang}${path}`}
<a href={getUrl('/contact')}>Contacto</a>
```

## Contenido Multilingüe

Para contenido como blog o proyectos, usa archivos separados por idioma:

### Blog
```
src/content/blog/articulo.es.md
src/content/blog/articulo.en.md
src/content/blog/articulo.pt.md
```

### Proyectos
```
src/content/projects/proyecto.es.md
src/content/projects/proyecto.en.md
src/content/projects/proyecto.pt.md
```

## SEO para Multilingüe

### En BaseLayout.astro
```astro
<link rel="alternate" hreflang="es" href="https://cnsaparaguay.com/" />
<link rel="alternate" hreflang="en" href="https://cnsaparaguay.com/en/" />
<link rel="alternate" hreflang="pt" href="https://cnsaparaguay.com/pt/" />
<link rel="alternate" hreflang="x-default" href="https://cnsaparaguay.com/" />
```

### Language Switcher en Header

El header ya incluye un language switcher que genera URLs correctas automáticamente.

## Convenciones

1. **Nombres de archivo**: 
   - Español: `page.astro`
   - Inglés: `en/page.astro`
   - Portugués: `pt/page.astro`

2. **Props `lang`**:
   - Siempre pasar `lang` al `BaseLayout`
   - Valores: `'es'`, `'en'`, `'pt'`

3. **Traducciones en el componente**:
```astro
const content = {
  es: { title: "Título", description: "..." },
  en: { title: "Title", description: "..." },
  pt: { title: "Título", description: "..." },
};

const text = content[lang];
```

## Testing

Para verificar que las páginas están correctas:

1. Accede a `/` (español)
2. Accede a `/en/` (inglés)
3. Accede a `/pt/` (portugués)
4. Verifica que el language switcher funciona
5. Verifica hreflang tags en source HTML

## Ejemplos

### Ejemplo Completo: Página "Servicios"

**src/pages/servicios.astro**
```astro
---
import BaseLayout from '@/layouts/BaseLayout.astro';
import Section from '@/components/ui/Section.astro';

const lang = 'es';

const content = {
  title: 'Nuestros Servicios',
  subtitle: 'Soluciones completas de marcaje vial',
};
---

<BaseLayout lang={lang} title={`${content.title} | CNSA Paraguay`}>
  <Section title={content.title} subtitle={content.subtitle}>
    <!-- Contenido -->
  </Section>
</BaseLayout>
```

**src/pages/en/servicios.astro**
```astro
---
import BaseLayout from '@/layouts/BaseLayout.astro';
import Section from '@/components/ui/Section.astro';

const lang = 'en';

const content = {
  title: 'Our Services',
  subtitle: 'Complete road marking solutions',
};
---

<BaseLayout lang={lang} title={`${content.title} | CNSA Paraguay`}>
  <Section title={content.title} subtitle={content.subtitle}>
    <!-- Content -->
  </Section>
</BaseLayout>
```

**src/pages/pt/servicios.astro**
```astro
---
import BaseLayout from '@/layouts/BaseLayout.astro';
import Section from '@/components/ui/Section.astro';

const lang = 'pt';

const content = {
  title: 'Nossos Serviços',
  subtitle: 'Soluções completas de marcação viária',
};
---

<BaseLayout lang={lang} title={`${content.title} | CNSA Paraguay`}>
  <Section title={content.title} subtitle={content.subtitle}>
    <!-- Conteúdo -->
  </Section>
</BaseLayout>
```

## Atajos

Para acelerar el proceso, copia y adapta cualquier página existente:

1. Abre `/pages/about.astro`
2. Copia y modifica el contenido
3. Crea versiones en `/pages/en/` y `/pages/pt/`
4. Actualiza `lang` prop y traducciones

---

Para más ayuda, consulta la documentación de Astro:
https://docs.astro.build/es/guides/internationalization/
