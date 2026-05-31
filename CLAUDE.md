# CNSA Paraguay Website - Project Guidelines

## Project Overview

Premium industrial website for CNSA Paraguay, a company specializing in:
- Road marking paints
- Thermoplastic road marking materials
- Glass beads
- Road safety products
- Traffic infrastructure solutions

Built with **Astro 5**, **TailwindCSS 4**, and **TypeScript**.

## Technology Stack

- **Framework**: Astro 5 (Static Site Generation)
- **Styling**: TailwindCSS 4
- **Language**: TypeScript
- **Animations**: Motion One
- **Carousels**: SwiperJS
- **Image Optimization**: Sharp
- **Languages**: Spanish (default), English, Portuguese

## Project Structure

```
src/
├── components/
│   ├── ui/              # Base components (Button, Card, Container, Section)
│   ├── layout/          # Header, Footer, Navigation
│   └── sections/        # Complete sections (HeroVideo, Stats, etc)
├── layouts/
│   ├── BaseLayout.astro # Main layout with header/footer
│   └── PageLayout.astro # Page wrapper layout
├── pages/
│   ├── index.astro      # Homepage
│   ├── about.astro      # About page
│   ├── products.astro   # Products listing
│   ├── projects.astro   # Projects gallery
│   ├── blog.astro       # Blog listing
│   └── contact.astro    # Contact form
├── content/
│   ├── blog/            # Blog articles
│   ├── projects/        # Project case studies
│   └── products/        # Product details
├── i18n/                # Language-specific content
├── styles/              # Global CSS
└── data/                # JSON data files
```

## Design System

### Colors
- **Primary**: #F4B400 (Golden yellow)
- **Dark**: #0F172A
- **Dark Secondary**: #1E293B
- **White**: #FFFFFF
- **Neutral Gray**: #94A3B8

### Typography
- **Headings**: Space Grotesk
- **Body**: Inter

### Spacing & Sizing
- Large breathing room
- Minimal border radius
- Subtle premium shadows

## Current Status

✅ **Completed**
- Project structure and configuration
- Base layout with header/footer
- Core UI components (Button, Card, Container, Section)
- Homepage with hero, stats, products overview
- About page
- Contact page (form structure)
- Products page
- Projects page
- Blog page

## Next Steps (Priority Order)

### Phase 1: Content & Pages
1. **Create language-specific pages**
   - `/en/` and `/pt/` versions of all pages
   - Implement proper i18n routing
   - Add language switcher functionality

2. **Product detail pages**
   - `/products/[slug].astro` individual product pages
   - Technical specifications
   - Downloads section
   - FAQ section
   - CTA to contact/quote

3. **Project detail pages**
   - `/projects/[id].astro` case study pages
   - Challenge → Solution → Results structure
   - Image gallery
   - Client testimonial
   - Statistics/metrics

### Phase 2: Content System
1. **Blog implementation**
   - MDX support for rich content
   - Article listings with pagination
   - Category filtering
   - Search functionality
   - Reading time calculation
   - Related articles

2. **Create sample content**
   - 5-10 blog articles (ES, EN, PT)
   - 3-5 project case studies
   - Product specifications

### Phase 3: Advanced Features
1. **SEO optimization**
   - Schema markup for all content types
   - Dynamic meta tags
   - XML sitemaps (auto-generated)
   - Image sitemaps
   - Breadcrumbs
   - Internal linking strategy

2. **Performance optimization**
   - Image optimization with Sharp
   - AVIF/WebP format support
   - Lazy loading implementation
   - Code splitting
   - CSS optimization

3. **Admin system**
   - Decap CMS integration (recommended)
   - Or lightweight custom admin panel
   - Content management for blog/projects

### Phase 4: Deployment
1. **Production build**
   - `npm run build` generates static files
   - Test on various devices/browsers
   - Lighthouse audit (target 100 across all metrics)

2. **Deployment preparation**
   - Setup for shared hosting (cPanel/Apache)
   - Environment configuration
   - Sitemap and robots.txt
   - Analytics integration

## Important Rules

### Development
- Create pages without asking for confirmation
- Use TypeScript strictly (configured in tsconfig.json)
- Follow the component structure exactly
- Use TailwindCSS utilities only
- No external UI frameworks beyond what's specified

### Performance
- Keep JS bundles under 50kb
- Lazy load all images
- No unnecessary animations
- Use CSS utilities for styling, not custom CSS
- Preload critical resources

### Multilingual
- Every page must exist in ES, EN, PT
- Use proper hreflang tags
- Language switcher in header
- URL structure: `/es/`, `/en/`, `/pt/` (ES is root)
- Store content in separate language folders

### Content
- Use Markdown/MDX for blog and projects
- Keep content AI-friendly (structured, semantic)
- Include schema markup for all content types
- Follow SEO best practices
- Use copyright-free images from Pexels/Unsplash

### Code Style
- Use descriptive component/file names
- No default exports
- Type all props with interfaces
- Keep components focused and small
- Reuse UI components

## Deployment Notes

- Output: Static HTML only
- Compatible with: Apache, Nginx, cPanel
- No database required
- No server runtime required
- Build output: `dist/` folder

## Git Strategy

- Create commits after each logical feature
- Use conventional commit messages
- Don't ask for git confirmation once setup is done
- Push to main branch directly

## Questions?

If stuck:
1. Check the PRD files in `/prd/`
2. Refer to the design system specifications
3. Review Astro documentation: https://docs.astro.build
4. Check TailwindCSS docs: https://tailwindcss.com/docs

---

**Last Updated**: 2026-05-31
**Status**: Ready for Phase 1
