# CNSA Paraguay - Website

Sitio web corporativo premium para CNSA Paraguay, especialista en soluciones de marcaje vial y seguridad en carreteras.

## Tecnología

- **Astro 5** - Static Site Generation (SSG)
- **TailwindCSS 4** - Utility-first CSS framework
- **TypeScript** - Type-safe development
- **Motion One** - Smooth animations
- **SwiperJS** - Touch slider library
- **Sharp** - Image optimization

## Características

- ✅ Multilingüe (ES, EN, PT)
- ✅ SEO optimizado (Schema markup, Open Graph, hreflang)
- ✅ Totalmente estático (compatible con shared hosting)
- ✅ Performance optimizado (Lighthouse 100)
- ✅ Dark modern industrial aesthetic
- ✅ Responsive design
- ✅ CMS-ready (estructura para Decap CMS)

## Estructura del Proyecto

```
src/
├── components/          # Componentes Astro reutilizables
│   ├── ui/             # Componentes base (Button, Card, etc)
│   ├── layout/         # Header, Footer
│   └── sections/       # Secciones completas
├── layouts/            # Layouts principales
├── pages/              # Páginas del sitio
├── content/            # Contenido (blog, projects, products)
├── styles/             # CSS global
├── i18n/               # Traducciones por idioma
└── data/               # Datos JSON (navegación, etc)

public/
├── images/
├── videos/
└── fonts/
```

## Desarrollo

```bash
# Instalar dependencias
npm install

# Iniciar servidor de desarrollo
npm run dev

# Build para producción
npm run build

# Vista previa de build
npm run preview
```

## Colores

- **Primario**: #F4B400 (Golden yellow)
- **Oscuro**: #0F172A (Deep dark)
- **Oscuro Secundario**: #1E293B
- **Blanco**: #FFFFFF
- **Gris Neutral**: #94A3B8

## Tipografía

- **Headings**: Space Grotesk
- **Body**: Inter

## Deployment

1. `npm run build`
2. Subir contenido de `dist/` a servidor web
3. Compatible con Apache, Nginx y cPanel

## Roadmap

- [ ] Sistema completo de productos
- [ ] Galería de proyectos
- [ ] Blog con MDX
- [ ] Decap CMS integration
- [ ] Formularios con backend
- [ ] Analytics tracking
- [ ] Sitemap dinámico
- [ ] Google Search Console setup

## Contribución

Este proyecto está en desarrollo activo. Para cambios mayores, favor consultar con el equipo.

## Licencia

Todos los derechos reservados CNSA Paraguay 2024-2026
