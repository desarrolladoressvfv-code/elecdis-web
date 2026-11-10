# ELECDIS – Sitio Web Corporativo

Prototipo funcional desarrollado en **Astro + HTML/CSS/JS vanilla**. Salida estática lista para cualquier hosting compartido con PHP.

---

## Requisitos

- Node.js ≥ 18 (recomendado v20)
- npm ≥ 9

---

## Correr en local

```bash
# 1. Instalar dependencias (solo la primera vez)
npm install

# 2. Levantar servidor de desarrollo
npm run dev
# → Abre http://localhost:4321

# 3. Compilar para producción
npm run build
# → Genera la carpeta dist/

# 4. Previsualizar el build (opcional)
npm run preview
```

> **Formulario en local:** el formulario de contacto detecta automáticamente `localhost` y simula el envío mostrando un mensaje de éxito, sin llamar al PHP.

---

## Estructura de archivos editables

```
src/data/
├── site.json          ← Nombre, eslogan, contacto, stats
├── services.json      ← Servicios (título, ícono, descripción, features)
├── projects.json      ← Proyectos (todos los campos)
├── certifications.json← Certificaciones
└── sectors.json       ← Sectores
```

### Cómo editar cada JSON

#### `site.json`
Contiene los datos globales de la empresa. Campos editables:
- `fullName` – nombre legal que aparece en la portada
- `slogan` – frase principal del hero
- `description` – descripción corta
- `contact.address/email/phone/whatsapp` – datos de contacto reales
- `contact.whatsappMessage` – texto predefinido al abrir WhatsApp
- `stats[]` – indicadores animados: `value` (número), `suffix` (ej. `+`), `label`

#### `services.json`
Array de 3 objetos. Para cada servicio:
- `title` – nombre del servicio
- `icon` – emoji del ícono
- `description` – párrafo descriptivo
- `features[]` – lista de puntos (máximo 3)

#### `projects.json`
Array de proyectos. Para cada uno:
- `slug` – URL del proyecto (ej. `tablero-planta-sur`), sin espacios ni acentos
- `title` – nombre del proyecto
- `client`, `location`, `year`, `sector`, `sectorId` – metadatos
- `sectorId` – debe coincidir con un `id` en `sectors.json`
- `summary` – texto corto para las tarjetas de grilla
- `description` – texto largo para la página de detalle
- `coverAlt` – texto alternativo de la imagen principal
- `images[]` – array de objetos `{ "alt": "..." }` (1 principal + 2 secundarias mínimo)

> Para agregar imágenes reales: sube los archivos a `public/proyectos/[slug]/` y reemplaza los bloques placeholder con etiquetas `<img>` en los componentes correspondientes.

#### `certifications.json`
Array de 4 objetos. Para cada certificación:
- `title` – nombre de la certificación
- `entity` – entidad emisora
- `number` – número de certificación
- `validity` – vigencia
- `imageAlt` – texto alternativo de la imagen del certificado

#### `sectors.json`
Array de 3 sectores. Para cada uno:
- `id` – identificador (ej. `mineria`, `industrial`)
- `title` – nombre visible
- `description` – párrafo descriptivo

---

## Configurar el formulario de contacto en hosting

### 1. Editar credenciales SMTP
Abre `public/api/smtp-config.php` y reemplaza los valores:

```php
define('SMTP_HOST',     'mail.tuhosting.cl');
define('SMTP_PORT',      587);
define('SMTP_USER',     'contacto@elecdis.cl');
define('SMTP_PASS',     'TU_CONTRASEÑA_SMTP');
define('SMTP_FROM',     'contacto@elecdis.cl');
define('SMTP_FROM_NAME','ELECDIS Web');
define('MAIL_TO',       'elecdis.spa@gmail.com');
```

> El hosting compartido más común (cPanel) usa `mail()` nativo y el `SMTP_HOST` suele ser `localhost` o `mail.dominio.cl`. Verificar en el panel del hosting.

### 2. Para PHPMailer (recomendado)
Si el hosting requiere autenticación SMTP externa (Gmail, Sendinblue, etc.), instala PHPMailer:

```bash
composer require phpmailer/phpmailer
```

Luego adapta `public/api/contacto.php` usando `PHPMailer\PHPMailer\PHPMailer` en lugar de `mail()`.

---

## Subir a hosting compartido

```
1. Compilar: npm run build
2. Subir TODO el contenido de dist/ a public_html/ (o httpdocs/) del hosting
3. Subir public/api/contacto.php y public/api/smtp-config.php a public_html/api/
4. Verificar que el servidor tiene PHP activo (el .html es estático, solo el PHP necesita el servidor)
5. Probar el formulario con un envío real
```

> Los archivos `.html` son estáticos y no necesitan PHP ni Node en el servidor.

---

## Paleta de colores

| Token CSS | Valor | Uso |
|---|---|---|
| `--color-primary` | `#0B1F4B` | Azul marino oscuro – fondo hero, header |
| `--color-primary-mid` | `#1A3A6B` | Azul marino medio – footer |
| `--color-accent` | `#F5A623` | Ámbar – botones, acentos |
| `--color-accent-dark` | `#D4891A` | Ámbar oscuro – hover de botones |
| `--color-bg-alt` | `#F4F6F9` | Gris claro – secciones alternadas |

Para cambiar la paleta, edita únicamente `src/styles/tokens.css` → `public/styles/tokens.css`.

---

## Reemplazar logo

1. Recibe el logo vectorial en SVG o PNG de alta resolución
2. Colócalo en `public/logo.svg`
3. Edita `src/components/Header.astro` y `src/components/Footer.astro`: reemplaza el bloque `.logo__placeholder` por `<img src="/logo.svg" alt="ELECDIS" width="140" height="40" />`
4. Recompila: `npm run build`

---

Desarrollado por **BiKloud** · Noviembre 2026
