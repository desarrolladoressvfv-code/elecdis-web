import projects from '../data/projects.json';

export async function GET() {
  const baseUrl = 'https://www.elecdis.cl';
  const staticUrls = ['/', '/proyectos/'];
  const projectUrls = projects.map(p => `/proyectos/${p.slug}/`);
  const allUrls = [...staticUrls, ...projectUrls];

  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${allUrls.map(url => `  <url>
    <loc>${baseUrl}${url}</loc>
    <changefreq>${url === '/' ? 'weekly' : 'monthly'}</changefreq>
    <priority>${url === '/' ? '1.0' : '0.8'}</priority>
  </url>`).join('\n')}
</urlset>`;

  return new Response(xml, {
    headers: { 'Content-Type': 'application/xml; charset=utf-8' }
  });
}
