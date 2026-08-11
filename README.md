<div align="center">

# ☁️ OffloadForge - Cloud Media Offload for S3, DigitalOcean Spaces & Google Cloud

### Offload your WordPress media library to Amazon S3, DigitalOcean Spaces, or Google Cloud Storage and serve it over a CDN.

[![WordPress](https://img.shields.io/badge/WordPress-5.3%2B-21759B?style=for-the-badge&logo=wordpress&logoColor=white)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-GPLv2-E74C3C?style=for-the-badge)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.3.5-2ECC71?style=for-the-badge)](https://github.com/gunjanjaswal/OffloadForge-Cloud-Media-Offload/releases)
[![Support on Ko-fi](https://img.shields.io/badge/Ko--fi-Support-FF5E5B?style=for-the-badge&logo=ko-fi&logoColor=white)](https://ko-fi.com/gunjanjaswal)

<br>

[![Amazon S3](https://img.shields.io/badge/Amazon%20S3-FF9900?style=flat-square&logo=amazons3&logoColor=white)](#-amazon-s3)
[![DigitalOcean](https://img.shields.io/badge/DigitalOcean%20Spaces-0080FF?style=flat-square&logo=digitalocean&logoColor=white)](#-digitalocean-spaces)
[![Google Cloud](https://img.shields.io/badge/Google%20Cloud%20Storage-4285F4?style=flat-square&logo=googlecloud&logoColor=white)](#-google-cloud-storage)

<br>

---

</div>

## ✨ Features

**OffloadForge** copies your WordPress media library to Amazon S3, DigitalOcean Spaces, or Google Cloud Storage and rewrites the URLs so files are served from the cloud or your CDN. This moves media traffic off your web server and can deliver files from a location closer to the visitor.

*This is an independent integration and is not affiliated with, endorsed by, or sponsored by Amazon, DigitalOcean, or Google.*

<table>
<tr>
<td width="50%">

### 🚀 Core
- **Auto Sync** — New uploads instantly copied to cloud
- **Bulk Migration** — One-click offload with progress tracking
- **Smart Re-link** — Detects existing cloud files, skips re-upload
- **Full URL Rewriting** — Post content, srcset, thumbnails, theme templates — all covered
- **Auto-Retry** — Resumes on connection drops (up to 5 retries)

</td>
<td width="50%">

### ☁️ Providers
- **Amazon S3** — Industry-standard object storage
- **DigitalOcean Spaces** — S3-compatible, predictable pricing
- **Google Cloud Storage** — Google infrastructure via HMAC keys

</td>
</tr>
<tr>
<td>

### 🛡️ Safety & Recovery
- **Restore Local Files** — Download cloud files back to server
- **Deactivation Warning** — Alert on Plugins page if files are cloud-only
- **Connection Testing** — Verify credentials before going live
- **Local File Removal** — Optional auto-delete after upload

</td>
<td>

### ⚡ Performance
- **CDN Support** — CloudFront, DO CDN, custom domains
- **Zero Dependencies** — No Composer, no vendor folder, no SDKs
- **Lightweight** — Uses WordPress built-in HTTP API
- **AWS Sig V4** — Secure request signing, no keys in transit

</td>
</tr>
</table>

---

## 🔧 Repair & Diagnostic Tools

> **Built-in tools to diagnose and fix common cloud storage issues — no manual database edits needed.**

<table>
<tr>
<td width="33%" align="center">

### 🔐 Fix Permissions
Scans all offloaded files via HEAD requests. Files returning **403 AccessDenied** or other errors are listed with a one-click fix that sets `public-read` ACL or re-uploads with correct permissions.

**OffloadForge > Fix Permissions**

</td>
<td width="33%" align="center">

### 🖼️ Fix Thumbnails
Finds offloaded images where **thumbnail sizes are missing** from the cloud. Common after bulk offload interruptions or when WordPress generates new image sizes. Uploads missing thumbnails and stores their cloud URLs.

**OffloadForge > Fix Thumbnails**

</td>
<td width="33%" align="center">

### 🔗 Fix URLs
Detects when your **CDN URL, bucket, or region** settings changed but stored media URLs still point to the old location. Bulk-updates all URLs to match current settings — **no re-uploading needed**.

**OffloadForge > Fix URLs**

</td>
</tr>
</table>

---

## 🌐 External Services

This plugin connects to external cloud storage providers to automatically offload and serve your media files. Depending on your configuration, it relies on one of the following third-party services:

### <img src="https://img.shields.io/badge/-Amazon%20S3-FF9900?style=flat-square&logo=amazons3&logoColor=white" alt="S3">
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to Amazon S3 whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [AWS Service Terms](https://aws.amazon.com/service-terms/)
- **Privacy Policy:** [AWS Privacy Notice](https://aws.amazon.com/privacy/)

### <img src="https://img.shields.io/badge/-DigitalOcean%20Spaces-0080FF?style=flat-square&logo=digitalocean&logoColor=white" alt="DO">
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to DigitalOcean whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [DigitalOcean Terms of Service](https://www.digitalocean.com/legal/terms-of-service-agreement)
- **Privacy Policy:** [DigitalOcean Privacy Policy](https://www.digitalocean.com/legal/privacy-policy)

### <img src="https://img.shields.io/badge/-Google%20Cloud%20Storage-4285F4?style=flat-square&logo=googlecloud&logoColor=white" alt="GCS">
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to Google Cloud Storage whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [Google Cloud Terms](https://cloud.google.com/terms)
- **Privacy Policy:** [Google Cloud Privacy Notice](https://cloud.google.com/terms/cloud-privacy-notice)

---

## 📋 Requirements

| Requirement | Minimum |
|------------|---------|
| WordPress | 5.3+ |
| PHP | 7.4+ |
| Cloud Account | S3, Spaces, or GCS |

---

## 🔧 Installation

```bash
# Clone the repo
git clone https://github.com/gunjanjaswal/OffloadForge-Cloud-Media-Offload.git

# Copy to your WordPress plugins directory
cp -r g33ki-cloud-storage-for-media-library /path/to/wp-content/plugins/
```

**Or via WordPress admin:**
1. **Plugins > Add New > Upload Plugin**
2. Upload the ZIP file
3. Activate
4. Go to **OffloadForge > Settings**

---

## ⚙️ Configuration

### <img src="https://img.shields.io/badge/-Amazon%20S3-FF9900?style=flat-square&logo=amazons3&logoColor=white" alt="S3">

| Field | Example |
|-------|---------|
| Access Key ID | `AKIAIOSFODNN7EXAMPLE` |
| Secret Access Key | `wJalrXUtnFEMI/K7MDENG/...` |
| Bucket Name | `my-media-bucket` |
| Region | `us-east-1` |

### <img src="https://img.shields.io/badge/-DigitalOcean%20Spaces-0080FF?style=flat-square&logo=digitalocean&logoColor=white" alt="DO">

| Field | Example |
|-------|---------|
| Access Key | `DO00XXXXXXXXXXXXXXXXXX` |
| Secret Key | `your-secret-key` |
| Space Name | `my-space` |
| Region | `nyc3`, `sfo3`, `sgp1` |

### <img src="https://img.shields.io/badge/-Google%20Cloud%20Storage-4285F4?style=flat-square&logo=googlecloud&logoColor=white" alt="GCS">

| Field | Example |
|-------|---------|
| HMAC Access Key | `GOOGXXXXXXXXXXXXXXXXX` |
| HMAC Secret Key | `your-hmac-secret` |
| Bucket Name | `my-gcs-bucket` |

---

## 🔄 How It Works

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   WordPress   │     │    Plugin     │     │    Cloud     │
│   Upload      │────▶│   Auto Sync   │────▶│   Storage    │
│               │     │               │     │  (S3/DO/GCS) │
└──────────────┘     └──────────────┘     └──────────────┘
                            │
                            ▼
                     ┌──────────────┐
                     │  URL Rewrite  │
                     │  ─────────── │
                     │  Post Content │
                     │  Srcset URLs  │
                     │  Thumbnails   │
                     │  Theme/Header │
                     │  CDN Delivery │
                     └──────────────┘
```

1. **Upload** — Media uploaded to WordPress as usual
2. **Sync** — Plugin automatically copies to cloud storage
3. **Rewrite** — All URLs rewritten to cloud/CDN endpoints
4. **Serve** — Images delivered from cloud, not your server
5. *(Optional)* **Cleanup** — Local files removed to save disk space

---

## 📦 Admin Menu Pages

| Page | Description |
|------|-------------|
| **Settings** | Configure provider, credentials, CDN, path prefix, local file removal |
| **Bulk Offload** | Migrate entire media library to cloud with progress tracking & auto-retry |
| **Restore Local** | Download cloud files back to server before deactivating |
| **Fix Permissions** | Scan for 403/404 errors and set public-read ACL |
| **Fix Thumbnails** | Find & upload missing thumbnail sizes to cloud |
| **Fix URLs** | Update stale URLs after CDN/bucket/region config changes |

---

## 🏗️ Architecture

```
g33ki-cloud-storage-for-media-library/
│
├── 📄 g33ki-cloud-storage-for-media-library.php    ← Plugin entry point
│
├── 📁 includes/
│   ├── 🔧 class-g33ki-cloud-storage-for-media-library.php  ← Core orchestrator
│   ├── ⚙️ class-settings.php                               ← Settings & AJAX handlers
│   ├── ☁️ class-uploader.php                               ← Auto-sync new uploads
│   ├── 📦 class-bulk-offload.php                           ← Bulk migration
│   ├── ⬇️ class-bulk-restore.php                           ← Bulk restore
│   ├── 🔐 class-fix-permissions.php                        ← Scan & fix ACL
│   ├── 🖼️ class-fix-thumbnails.php                         ← Fix missing thumbs
│   ├── 🔗 class-fix-urls.php                               ← Fix URL mismatches
│   ├── 🔏 class-s3-signing.php                             ← AWS Sig V4 signing
│   ├── ✅ class-dependency-checker.php                      ← PHP requirements
│   │
│   ├── 📁 providers/
│   │   ├── 🏗️ class-provider-base.php                      ← Abstract base
│   │   ├── 🟠 class-s3-provider.php                        ← Amazon S3
│   │   ├── 🔵 class-spaces-provider.php                    ← DigitalOcean Spaces
│   │   └── 🔴 class-gcs-provider.php                       ← Google Cloud Storage
│   │
│   └── 📁 views/
│       ├── 🖥️ settings.php                                 ← Settings page UI
│       ├── 📦 bulk-offload.php                             ← Bulk offload UI
│       ├── ⬇️ bulk-restore.php                             ← Bulk restore UI
│       ├── 🔐 fix-permissions.php                          ← Fix permissions UI
│       ├── 🖼️ fix-thumbnails.php                           ← Fix thumbnails UI
│       └── 🔗 fix-urls.php                                 ← Fix URLs UI
│
├── 📁 assets/
│   ├── 🎨 css/admin.css                                    ← Modern admin styles
│   └── ⚡ js/admin.js                                      ← Admin functionality
│
├── 📄 readme.txt                                           ← WordPress.org readme
└── 📄 README.md                                            ← You are here
```

---

## 📝 Changelog

### 1.3.5
- Fixed a PHP "Array to string conversion" warning that fired when an image was requested by explicit width/height dimensions (an array size) instead of a named size. The attachment image-src filter now guards the per-size lookup, so array sizes fall back to the full-size cloud URL. No change for named sizes.
- Removed the lightning emoji from the admin menu label so the sidebar shows a single cloud icon.

### 1.3.4
- Housekeeping: updated the plugin's GitHub links (Plugin URI, bug-report and clone links) to the current repository. No functional change.

### 1.3.3
- Renamed to **OffloadForge - Cloud Media Offload for S3, DigitalOcean Spaces & Google Cloud**. The title now leads with the distinctive OffloadForge brand. The slug (`g33ki-cloud-storage-for-media-library`) and your `g33ki_settings` option are unchanged, so it updates in place with no reconfiguration. Admin menu, settings heading, and docs follow the new name.

### 1.3.2
- Renamed to **G33ki Cloud Media Offload for S3, DigitalOcean Spaces & Google Cloud**. The title now leads with the g33ki brand and puts the provider names after "for". The slug (`g33ki-cloud-storage-for-media-library`) and your `g33ki_settings` option are unchanged, so it updates in place with no reconfiguration.
- Added a clear note that this is an independent integration and is not affiliated with Amazon, DigitalOcean, or Google.
- Reworked the description to drop comparative and promotional wording and remove SEO/ranking claims the plugin can't promise.
- Expanded the External Services section: the plugin connects only to the provider, bucket, and region you configure, using your own credentials, and sends nothing to the author.
- Security: provider classes now resolve through an explicit allowlist (`G33KI_Provider_Base::class_for()`) instead of being built from the stored provider value.
- Fixed the `G33KI_VERSION` constant, which still read 1.3.0.

### 1.3.1
- **Fix: the declared minimum WordPress version was wrong.** `class-fix-thumbnails.php` calls `wp_create_image_subsizes()` when a thumbnail is missing locally, which requires WordPress 5.3, while the headers claimed support back to 5.0. Nothing ever fatalled, since the call is already wrapped in a `function_exists()` guard, so on 5.0–5.2 the regeneration simply did nothing. But the declared floor was dishonest, and the official Plugin Check flags it as an error because it compares APIs against the declared minimum rather than following the guard. Headers now state 5.3.
- Docs: the requirements table above also still claimed PHP 7.2, which was superseded by 7.4 back in 1.2.3. Corrected.

### 1.3.0
- Renamed the plugin display title to **Cloud Storage For Media Library — S3, DigitalOcean Spaces & Google Cloud** for clarity in search and listings. The slug, settings, and stored data are unchanged — display-only rebrand, safe to update.
- Cleaned up admin provider labels (removed the redundant brand suffix).

### 1.2.4
- **WordPress 7.0 Connectors API integration:** registers Amazon S3, DigitalOcean Spaces, and Google Cloud Storage as `cloud_storage` connectors on the `wp_connectors_init` action.
- Each provider's connector links back to this plugin's settings page for credential management (`credentials_url`).
- The plugin stores multiple credentials per provider (`access_key`, `secret_key`, `bucket`, `region`) inside one option `g33ki_settings`. The Connectors API's `api_key` auth method only handles a single setting value, so connectors are registered with `method: none` to act as informational/navigation entries. Full multi-field central management will land once core supports it (or after a future option refactor).
- Added `g33ki_register_connectors` action hook so third-party code can register richer connectors against the same providers.

### 1.2.3
- Updated "Tested up to" to WordPress 7.0.
- Bumped minimum PHP requirement to 7.4 (WordPress 7.0 dropped support for PHP 7.2 and 7.3).
- Added "Support on Ko-fi" (https://ko-fi.com/gunjanjaswal) and "Contact Developer" links to plugin row meta on the Plugins screen.
- Added `Requires at least`, `Tested up to`, and `Requires PHP` headers to the main plugin file.

### 1.2.2
- Rebranding: Renamed to G33ki Cloud Storage For Media Library.
- SEO: Improved description for better search visibility on "offload media library" and "move media to cloud" keywords.

### 1.2.1
- Fix: Removed inline script tag from fix-urls.php template.
- Fix: Replaced `ob_start()` full-page buffering with `wp_template_enhancement_output_buffer`.
- Docs: Added External Services declaration block to document S3/DO/GCS usage.

### 1.2.0
- New: Full-page output buffer URL rewriting — catches theme-hardcoded image URLs.
- New: Handles http/https URL variations and relative `/wp-content/uploads/` paths.
- New: Filters for `post_thumbnail_html`, `widget_text`, `custom_logo`, `wp_get_attachment_image`, `header_image_tag`.

### 1.1.0
- New: Fix Permissions, Fix Thumbnails, Fix URLs repair tools.
- New: Auto-retry on connection timeouts (up to 5 retries per batch).
- New: Smart re-link — detects existing cloud files and skips re-upload.

### 1.0.0
- Initial release with Amazon S3, DigitalOcean Spaces, and Google Cloud Storage support.

---

## 📄 License

This project is licensed under the **GPLv2 or later** — see the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.

---

<div align="center">

### 👨‍💻 Developer

**Gunjan Jaswal**

[![Website](https://img.shields.io/badge/Website-gunjanjaswal.me-667eea?style=for-the-badge&logo=google-chrome&logoColor=white)](https://gunjanjaswal.me)
[![Email](https://img.shields.io/badge/Email-hello%40gunjanjaswal.me-EA4335?style=for-the-badge&logo=gmail&logoColor=white)](mailto:hello@gunjanjaswal.me)
[![GitHub](https://img.shields.io/badge/GitHub-gunjanjaswal-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/gunjanjaswal)

---

⭐ **Star this repo** if you find it useful!

</div>
