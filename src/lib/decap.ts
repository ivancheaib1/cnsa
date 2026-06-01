import fs from 'fs';
import path from 'path';
import matter from 'gray-matter';

const contentDir = path.join(process.cwd(), 'src/content');

function getAllMarkdownFiles(dir: string): string[] {
  if (!fs.existsSync(dir)) return [];

  const files: string[] = [];
  const items = fs.readdirSync(dir);

  items.forEach(item => {
    const fullPath = path.join(dir, item);
    const stat = fs.statSync(fullPath);
    if (stat.isFile() && item.endsWith('.md')) {
      files.push(fullPath);
    }
  });

  return files;
}

function parseMarkdownFile(filePath: string) {
  const fileContent = fs.readFileSync(filePath, 'utf-8');
  const { data, content } = matter(fileContent);
  return {
    ...data,
    body: content,
    slug: (data as any).slug || path.basename(filePath, '.md')
  };
}

export function getBlogPosts() {
  const blogDir = path.join(contentDir, 'blog');
  const files = getAllMarkdownFiles(blogDir);

  return files
    .map(file => parseMarkdownFile(file))
    .sort((a: any, b: any) => {
      const dateA = new Date(a.publishedAt).getTime();
      const dateB = new Date(b.publishedAt).getTime();
      return dateB - dateA;
    });
}

export function getProjects() {
  const projectsDir = path.join(contentDir, 'projects');
  const files = getAllMarkdownFiles(projectsDir);

  return files
    .map(file => parseMarkdownFile(file))
    .sort((a: any, b: any) => (b.year || 0) - (a.year || 0));
}

export function getProducts() {
  const productsDir = path.join(contentDir, 'products');
  const files = getAllMarkdownFiles(productsDir);

  return files
    .map(file => parseMarkdownFile(file))
    .sort((a: any, b: any) => (a.order || 0) - (b.order || 0));
}

export function getBySlug(
  collection: 'blog' | 'projects' | 'products',
  slug: string
) {
  const dir = path.join(contentDir, collection);
  const files = getAllMarkdownFiles(dir);

  for (const file of files) {
    const data = parseMarkdownFile(file);
    if (data.slug === slug) return data;
  }

  return null;
}

export function getImageUrl(image: string | null | undefined): string {
  if (!image) return '';
  if (image.startsWith('http')) return image;
  if (image.startsWith('/')) return image;
  return `/${image}`;
}
