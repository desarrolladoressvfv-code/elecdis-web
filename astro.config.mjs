import { defineConfig } from 'astro/config';

export default defineConfig({
  output: 'static',
  build: {
    assets: '_assets'
  },
  site: 'https://www.elecdis.cl'
});
