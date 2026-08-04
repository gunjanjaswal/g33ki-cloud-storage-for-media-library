=== G33ki Cloud Media Offload for S3, DigitalOcean Spaces & Google Cloud ===
Contributors: gunjanjaswal
Tags: offload media, cloud storage, s3, digitalocean spaces, cdn
Requires at least: 5.3
Tested up to: 7.0
Stable tag: 1.3.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://ko-fi.com/gunjanjaswal

Offload your WordPress media library to Amazon S3, DigitalOcean Spaces, or Google Cloud Storage and serve files over a CDN.

== Description ==

**G33ki Cloud Media Offload** copies your WordPress media library, including images, videos, and documents, to a cloud storage provider of your choice and rewrites the URLs so files are served from the cloud or your CDN. This can reduce load on your web server and take advantage of the provider's global delivery network.

It works with three providers: Amazon S3, DigitalOcean Spaces, and Google Cloud Storage (via HMAC keys). There is no SDK or Composer step to install; the plugin talks to each provider's REST API using WordPress's built-in HTTP functions with AWS Signature V4 request signing.

*This plugin is a third-party integration and is not affiliated with, endorsed by, or sponsored by Amazon, DigitalOcean, or Google. "Amazon S3", "DigitalOcean Spaces", and "Google Cloud Storage" are trademarks of their respective owners.*

= Key Features =

**Multi-Cloud Provider Support**

* **Amazon S3** — Object storage with global infrastructure
* **DigitalOcean Spaces** — S3-compatible storage with predictable, affordable pricing
* **Google Cloud Storage** — Enterprise-grade storage powered by Google's network (via HMAC keys)

**Automatic Media Synchronization**

* New uploads automatically copied to cloud storage in real-time
* All image sizes and thumbnails synced automatically
* Videos, PDFs, documents — all file types supported
* Zero manual intervention required

**Powerful Bulk Migration Tool**

* One-click migration for existing media libraries
* Real-time progress tracking with detailed statistics
* Batch processing for optimal performance
* Auto-retry on connection timeouts (handles Cloudflare 524 errors)
* Comprehensive error reporting

**CDN & Performance Optimization**

* Seamless CloudFront and custom CDN integration
* Full URL rewriting — post content, srcset, thumbnails, theme templates, headers, footers
* Output buffer rewrites all frontend HTML — catches even hardcoded theme URLs
* Smart re-link — detects files already in cloud, skips re-upload
* Global content delivery for faster load times
* Reduced server bandwidth and hosting costs

**Built-in Repair & Diagnostic Tools**

* **Fix Permissions** — Scans all offloaded files and detects 403 AccessDenied errors. One-click fix sets public-read ACL or re-uploads with correct permissions. Essential after bulk operations or bucket policy changes.
* **Fix Thumbnails** — Finds offloaded images where thumbnail sizes are missing from the cloud. Common after bulk offload interruptions or when WordPress generates new image sizes. Uploads missing thumbnails and stores their cloud URLs so all image sizes load correctly.
* **Fix URLs** — Detects when your CDN URL, bucket, or region settings changed but stored media URLs still point to the old location. Bulk-updates all stored URLs to match current settings without re-uploading. Essential after migrating between providers or changing CDN configuration.

Each repair tool follows a **Scan > Review > Fix** workflow with real-time progress tracking.

**Safety & Recovery**

* Restore local files — download cloud media back to server anytime
* Deactivation safety warning when local files are missing
* Secure credential storage
* Built-in connection testing before going live

**Zero Dependencies**

* No Composer required
* No external SDKs or libraries needed
* Works out of the box on any WordPress host
* Uses WordPress built-in HTTP API with secure request signing

= Admin Menu Pages =

* **Settings** — Configure provider, credentials, CDN, path prefix, local file removal
* **Bulk Offload** — Migrate entire media library to cloud with progress tracking and auto-retry
* **Restore Local** — Download cloud files back to server before deactivating
* **Fix Permissions** — Scan for 403/404 errors and set public-read ACL
* **Fix Thumbnails** — Find and upload missing thumbnail sizes to cloud
* **Fix URLs** — Update stale URLs after CDN/bucket/region config changes

= How It Works =

1. **Configure Your Provider** — Enter cloud storage credentials (access key, secret key, bucket, region)
2. **Test Connection** — Verify settings with built-in connection tester
3. **Automatic Sync** — All new uploads automatically copied to cloud storage
4. **Bulk Offload** — Migrate existing media files with one-click bulk tool
5. **Serve from Cloud** — Media URLs automatically rewritten to cloud/CDN URLs
6. **Diagnose & Fix** — Use repair tools if any issues arise

= Supported Cloud Providers =

**Amazon S3**
Object storage service with global reach, a broad feature set, and CloudFront CDN integration.

**DigitalOcean Spaces**
S3-compatible storage with simple, predictable pricing and a built-in CDN.

**Google Cloud Storage**
Powerful storage infrastructure from Google with multi-regional redundancy and edge caching capabilities. Uses HMAC keys for authentication.

= Common Use Cases =

* High-traffic websites that want to move media bandwidth off the web server
* Photography and portfolio sites with large image libraries
* Stores that keep a lot of product images
* News and magazine sites with large media archives
* Multisite networks that want media stored in cloud buckets

= Performance Notes =

Serving media from a cloud provider or CDN moves that traffic off your web server and can deliver files from a location closer to the visitor. Actual results depend on your host, your provider, your CDN configuration, and your theme, so this plugin does not promise any specific speed, SEO, or ranking outcome.

== External services ==

This plugin is a cloud-storage offloading service: it connects to the cloud provider **you** choose, using **your own** account credentials, and uploads your media there so the files can be served from that provider or your CDN. It connects only to the bucket and region you configure on the settings screen. No media or credentials are ever sent to the plugin author or any other party. Depending on your configuration, it relies on one of the following third-party services:

**Amazon S3**
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to Amazon S3 whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [AWS Service Terms](https://aws.amazon.com/service-terms/)
- **Privacy Policy:** [AWS Privacy Notice](https://aws.amazon.com/privacy/)

**DigitalOcean Spaces**
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to DigitalOcean whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [DigitalOcean Terms of Service](https://www.digitalocean.com/legal/terms-of-service-agreement)
- **Privacy Policy:** [DigitalOcean Privacy Policy](https://www.digitalocean.com/legal/privacy-policy)

**Google Cloud Storage**
Used to store and serve your media files globally.
- **Data sent:** Your media files (images, videos, documents), filenames, and MIME types are sent securely to Google Cloud Storage whenever you upload a new file or use the bulk offload tool.
- **Terms of Use:** [Google Cloud Terms](https://cloud.google.com/terms)
- **Privacy Policy:** [Google Cloud Privacy Notice](https://cloud.google.com/terms/cloud-privacy-notice)

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Navigate to Plugins > Add New
3. Search for "G33ki Cloud Media Offload"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Navigate to Plugins > Add New > Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin

No additional setup steps, libraries, or Composer required. The plugin works immediately after activation.

= Configuration =

1. Navigate to **Cloud Media Offload > Settings** in your WordPress admin
2. Select your storage provider (Amazon S3, DigitalOcean Spaces, or Google Cloud Storage)
3. Enter your credentials:
   * Access Key / Access Key ID
   * Secret Key / Secret Access Key
   * Bucket Name
   * Region
4. (Optional) Configure CDN URL and path prefix
5. Click "Test Connection" to verify your settings
6. Click "Save Settings"

= Google Cloud Storage Setup =

For GCS, you need HMAC keys instead of a service account JSON file:

1. Go to Google Cloud Console > Cloud Storage > Settings
2. Click the "Interoperability" tab
3. Create an HMAC key for your service account
4. Use the Access Key and Secret as your credentials in the plugin

== Frequently Asked Questions ==

= Does this plugin require Composer or external libraries? =

No! The plugin works completely standalone. It uses WordPress's built-in HTTP API with AWS Signature V4 request signing. Just install, activate, and configure.

= Does this plugin upload files directly to cloud storage? =

Files are first uploaded to your WordPress server, then automatically copied to your cloud storage. The process is seamless and happens in the background.

= What happens to my existing media files? =

Existing media files are not automatically migrated. Use the **Bulk Offload** tool under Cloud Media Offload > Bulk Offload to migrate existing files with one click.

= Can I remove local files after uploading to cloud storage? =

Yes! Enable the "Remove Local Files" option in settings. Files will be automatically deleted from your server after successful upload to cloud storage.

= Will this work with my CDN (CloudFront, etc.)? =

Absolutely! Enter your CDN URL (CloudFront, KeyCDN, BunnyCDN, etc.) in the "CDN URL" field, and all media will be served through your CDN.

= What if I deactivate the plugin? =

Before deactivating, go to **Cloud Media Offload > Restore Local** to download all cloud-stored files back to your server. A warning notice on the Plugins page reminds you if local files are missing. After restoring, WordPress will serve media from your server as normal.

= Some images show 403 AccessDenied errors after bulk offload. How do I fix this? =

Go to **Cloud Media Offload > Fix Permissions**. This tool scans all offloaded files and detects which ones are returning errors. Click "Fix All Broken Files" to set the correct public-read ACL on each file.

= Some image sizes (thumbnails) are not loading from the cloud. How do I fix this? =

Go to **Cloud Media Offload > Fix Thumbnails**. This tool scans all offloaded attachments and finds which thumbnail sizes are missing from the cloud. Click "Fix Missing Thumbnails" to upload them.

= I changed my CDN URL / bucket / region and now images are broken. How do I fix this? =

Go to **Cloud Media Offload > Fix URLs**. This tool detects when stored URLs don't match your current settings. Click "Fix All Mismatched URLs" to update them — no re-uploading needed.

= The bulk offload stops or times out midway. What do I do? =

The plugin has built-in auto-retry (up to 5 attempts per batch). If it still fails, just click "Start Bulk Offload" again — it picks up where it left off since already-offloaded files are automatically skipped.

= Does this support video and document files? =

Yes! The plugin supports all file types that WordPress allows in the media library, including images, videos, documents, audio files, and archives.

= Is this compatible with page builders? =

Yes, the plugin works seamlessly with Elementor, Beaver Builder, Divi, WPBakery, Gutenberg, Oxygen, and more.

= Can I use this with WooCommerce? =

Yes. The plugin works with WooCommerce product images, galleries, and downloadable products.

= Does this work with WordPress Multisite? =

Yes, the plugin is multisite compatible. You can configure different cloud storage settings for each site in your network.

= How much does cloud storage cost? =

Cloud storage is very affordable:

* **Amazon S3**: ~$0.023/GB/month + data transfer
* **DigitalOcean Spaces**: $5/month for 250GB + 1TB transfer
* **Google Cloud Storage**: ~$0.020/GB/month + data transfer

Most small to medium websites pay less than $5-10/month.

= Can I migrate between cloud providers? =

Yes, you can change providers at any time. Update your settings, use **Fix URLs** to update stored URLs, and use the bulk offload tool to re-upload media to the new provider.

= Is my data secure? =

Yes! All credentials are stored securely in your WordPress database. Data is transmitted over HTTPS. AWS Signature V4 request signing ensures credentials are never sent in plain text. All admin actions require `manage_options` capability.

= How do I get support? =

* Visit the WordPress.org support forum
* Contact the developer: hello@gunjanjaswal.me
* Report bugs on [GitHub](https://github.com/gunjanjaswal/g33ki-cloud-storage-for-media-library)

== Screenshots ==

1. Settings page — configure your cloud storage provider and credentials
2. Bulk offload tool — migrate existing media with real-time progress tracking
3. Restore local files — download cloud media back to server before deactivating
4. Fix permissions — scan and repair 403 AccessDenied cloud files
5. Fix thumbnails — find and upload missing thumbnail sizes
6. Fix URLs — update stale URLs after config changes
7. Connection test — verify your settings before going live
8. Plugin action links — quick access to settings and support

== Changelog ==

= 1.3.2 =
* Renamed the plugin to "G33ki Cloud Media Offload for S3, DigitalOcean Spaces & Google Cloud" so the title leads with the distinctive g33ki brand and places the provider names after "for". The slug (`g33ki-cloud-storage-for-media-library`), the `g33ki_settings` option, and all stored data are unchanged, so this updates in place with no reconfiguration.
* Added a clear statement that the plugin is an independent integration and is not affiliated with Amazon, DigitalOcean, or Google.
* Rewrote the description to drop comparative and promotional wording and to remove SEO/ranking claims the plugin cannot guarantee.
* Expanded the External Services section to state that the plugin connects only to the provider, bucket, and region you configure with your own credentials, and sends nothing to the author.
* Security hardening: provider classes are now resolved through an explicit allowlist (`G33KI_Provider_Base::class_for()`) instead of being built from the stored provider value, so a class name can never be constructed from request-supplied data.
* Fixed the internal `G33KI_VERSION` constant, which still read 1.3.0.

= 1.3.1 =
* Fix: corrected the declared minimum WordPress version. The plugin calls `wp_create_image_subsizes()` when regenerating a missing thumbnail, which needs WordPress 5.3, while the headers claimed support back to 5.0. The call was already wrapped in a `function_exists()` guard so nothing ever fatalled — on 5.0-5.2 the regeneration simply, and silently, did nothing. The headers now state 5.3 so the requirement is honest and the official Plugin Check passes cleanly.

= 1.3.0 =
* Renamed the plugin display title to "Cloud Storage For Media Library — S3, DigitalOcean Spaces & Google Cloud" for clarity in search and listings. The plugin slug, settings (`g33ki_settings`), and all stored data are unchanged — this is a display-only rebrand and updates safely with no reconfiguration required.
* Cleaned up provider labels on the admin screen (removed the redundant brand suffix).

= 1.2.4 =
* WordPress 7.0 Connectors API integration: registers Amazon S3, DigitalOcean Spaces, and Google Cloud Storage as `cloud_storage` connectors on the `wp_connectors_init` action. Each connector links to this plugin's settings page for credential management.
* The plugin's settings array (`g33ki_settings`) stores multiple credentials per provider (access_key, secret_key, bucket, region). The Connectors API's `api_key` method handles a single setting value, so connectors are registered with `method: none` and the credentials_url points back to this plugin's settings screen. Full multi-field central management will land once core supports it (or after a future option refactor).
* Added `g33ki_register_connectors` action so third-party code can register richer connectors against the same providers.

= 1.2.3 =
* Updated "Tested up to" to WordPress 7.0.
* Bumped minimum PHP requirement to 7.4 (WordPress 7.0 dropped support for PHP 7.2 and 7.3).
* Added "Support on Ko-fi" (https://ko-fi.com/gunjanjaswal) and "Contact Developer" links to plugin row meta on the Plugins screen.
* Added `Requires at least`, `Tested up to`, and `Requires PHP` headers to the main plugin file.

= 1.2.2 =
* Rebranding: Renamed to G33ki Cloud Storage For Media Library
* SEO: Improved description for better search visibility on "offload media library" and "move media to cloud" keywords
* Cleanup: Removed Buy Me a Coffee links

= 1.2.1 =
* Fix: Removed inline script tag from fix-urls.php template to adhere to WP enqueuing guidelines
* Fix: Replaced ob_start() full-page buffering with wp_template_enhancement_output_buffer
* Docs: Added External Services declaration block to document S3/DO/GCS usage

= 1.2.0 =
* New: Full-page output buffer URL rewriting — catches theme-hardcoded image URLs in headers, footers, and templates
* New: Handles http/https URL variations and relative /wp-content/uploads/ paths
* New: Filters for post_thumbnail_html, widget_text, custom_logo, wp_get_attachment_image, header_image_tag
* Fix: Images in theme templates not rewriting for non-logged-in users

= 1.1.0 =
* New: Fix Permissions tool — scan and repair 403 AccessDenied cloud files
* New: Fix Thumbnails tool — find and upload missing thumbnail sizes to cloud
* New: Fix URLs tool — bulk-update stale URLs after CDN/bucket/region changes
* New: Auto-retry on connection timeouts (up to 5 retries per batch)
* New: Smart re-link — detects existing cloud files and skips re-upload
* New: Set public-read ACL when re-linking existing cloud files
* Fix: Bulk offload offset logic causing premature "completed" status
* Fix: Batch size reduced to avoid Cloudflare 524 timeout errors
* Fix: Success message no longer persists after page reload

= 1.0.0 =
* Initial release
* Support for Amazon S3, DigitalOcean Spaces, and Google Cloud Storage
* No external SDK dependencies — uses built-in HTTP API with request signing
* Automatic upload synchronization for new media
* Bulk offload tool for existing media with batch processing
* CDN integration support (CloudFront, custom domains)
* Built-in connection testing
* Optional local file removal after cloud upload
* Restore local files tool — download cloud media back to server
* Deactivation safety warning when local files are missing
* Custom path prefix support

== Upgrade Notice ==

= 1.3.2 =
Plugin renamed to "G33ki Cloud Media Offload" and description cleaned up for the WordPress.org guidelines. The slug and your settings are unchanged, so this is a safe in-place update with no reconfiguration. Also adds an allowlist for provider resolution.

= 1.3.1 =
Corrects the declared minimum WordPress version from 5.0 to 5.3, which is what the thumbnail regeneration already required. No functional change.

= 1.3.0 =
Display name changed to "Cloud Storage For Media Library". The slug and your settings are unchanged — safe to update, no reconfiguration needed.

= 1.2.4 =
WordPress 7.0 Connectors API forward-compat: cloud-storage credentials registered with the central Connections screen when available. No breaking changes; graceful fallback on older WP.

= 1.2.3 =
Compatibility with WordPress 7.0; Ko-fi support + Contact Developer row meta added.

= 1.1.0 =
New repair tools: Fix Permissions, Fix Thumbnails, and Fix URLs. Auto-retry on connection drops. Recommended update for all users.

= 1.0.0 =
Initial release. Install and activate — no additional setup required.

== Privacy Policy ==

This plugin does not collect or store any personal data. All cloud storage credentials are stored in your WordPress database and are only used to communicate with your chosen cloud storage provider. No data is sent to third parties except your selected cloud provider.

== Credits ==

Developed by [Gunjan Jaswal](https://gunjanjaswal.me)

If you find this plugin helpful, please consider rating this plugin on WordPress.org or sharing with other WordPress users.
