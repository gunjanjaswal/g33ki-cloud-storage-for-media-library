<?php
/**
 * Main plugin class
 */

if (!defined('ABSPATH')) {
    exit;
}

class G33ki_Cloud_Storage_For_Media_Library {
    
    /**
     * Single instance of the class
     */
    protected static $_instance = null;
    
    /**
     * Settings instance
     */
    public $settings;
    
    /**
     * Uploader instance
     */
    public $uploader;
    
    /**
     * Main instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->includes();
        $this->init_hooks();
    }
    
    /**
     * Include required files
     */
    private function includes() {
        require_once G33KI_PLUGIN_DIR . 'includes/class-dependency-checker.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-settings.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-uploader.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-bulk-offload.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-bulk-restore.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-fix-permissions.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-fix-thumbnails.php';
        require_once G33KI_PLUGIN_DIR . 'includes/class-fix-urls.php';
        require_once G33KI_PLUGIN_DIR . 'includes/providers/class-provider-base.php';
        require_once G33KI_PLUGIN_DIR . 'includes/providers/class-s3-provider.php';
        require_once G33KI_PLUGIN_DIR . 'includes/providers/class-spaces-provider.php';
        require_once G33KI_PLUGIN_DIR . 'includes/providers/class-gcs-provider.php';
        
        $this->settings = new g33ki_settings();
        $this->uploader = new G33KI_Uploader();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_filter('wp_get_attachment_url', array($this, 'filter_attachment_url'), 10, 2);
        add_filter('wp_get_attachment_image_src', array($this, 'filter_attachment_image_src'), 10, 4);
        add_filter('wp_calculate_image_srcset', array($this, 'filter_image_srcset'), 10, 5);
        add_filter('the_content', array($this, 'filter_content_urls'), 99);
        add_filter('post_thumbnail_html', array($this, 'filter_content_urls'), 99);
        add_filter('widget_text', array($this, 'filter_content_urls'), 99);
        add_filter('get_custom_logo', array($this, 'filter_content_urls'), 99);
        add_filter('wp_get_attachment_image', array($this, 'filter_content_urls'), 99);
        add_filter('get_header_image_tag', array($this, 'filter_content_urls'), 99);
        add_filter('plugin_action_links_' . G33KI_PLUGIN_BASENAME, array($this, 'plugin_action_links'));
        add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);
        add_action('admin_notices', array($this, 'deactivation_warning_notice'));
        add_action('after_plugin_row_' . G33KI_PLUGIN_BASENAME, array($this, 'plugin_row_warning'), 10, 3);
        add_action('wp_ajax_g33ki_dismiss_deactivation_warning', array($this, 'dismiss_deactivation_warning'));

        // Output buffer to catch theme-hardcoded upload URLs (header, footer, etc.)
        if (!is_admin()) {
            add_filter('wp_template_enhancement_output_buffer', array($this, 'filter_output_buffer'));
        }
    }
    
    /**
     * Add admin menu
     */
    public function admin_menu() {
        add_menu_page(
            __('OffloadForge', 'g33ki-cloud-storage-for-media-library'),
            __('OffloadForge', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-cloud-storage-for-media-library',
            array($this->settings, 'render_settings_page'),
            'dashicons-cloud-upload',
            80
        );
        
        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Settings', 'g33ki-cloud-storage-for-media-library'),
            __('Settings', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-cloud-storage-for-media-library',
            array($this->settings, 'render_settings_page')
        );
        
        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Bulk Offload', 'g33ki-cloud-storage-for-media-library'),
            __('Bulk Offload', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-bulk-offload',
            array($this, 'render_bulk_offload_page')
        );

        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Restore Local', 'g33ki-cloud-storage-for-media-library'),
            __('Restore Local', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-bulk-restore',
            array($this, 'render_bulk_restore_page')
        );

        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Fix Permissions', 'g33ki-cloud-storage-for-media-library'),
            __('Fix Permissions', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-fix-permissions',
            array($this, 'render_fix_permissions_page')
        );

        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Fix Thumbnails', 'g33ki-cloud-storage-for-media-library'),
            __('Fix Thumbnails', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-fix-thumbnails',
            array($this, 'render_fix_thumbnails_page')
        );

        add_submenu_page(
            'g33ki-cloud-storage-for-media-library',
            __('Fix URLs', 'g33ki-cloud-storage-for-media-library'),
            __('Fix URLs', 'g33ki-cloud-storage-for-media-library'),
            'manage_options',
            'g33ki-fix-urls',
            array($this, 'render_fix_urls_page')
        );
    }
    
    /**
     * Enqueue admin scripts
     */
    public function admin_scripts($hook) {
        if (strpos($hook, 'g33ki') === false) {
            return;
        }
        
        wp_enqueue_style('g33ki-admin', G33KI_PLUGIN_URL . 'assets/css/admin.css', array(), G33KI_VERSION . '.2');
        wp_enqueue_script('g33ki-admin', G33KI_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), G33KI_VERSION . '.2', true);
        
        wp_localize_script('g33ki-admin', 'g33ki_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('g33ki_ajax_nonce'),
            'i18n' => array(
                'scanned' => __('Scanned', 'g33ki-cloud-storage-for-media-library'),
                'file_mismatched_found' => __('file(s) with mismatched URLs found.', 'g33ki-cloud-storage-for-media-library'),
                'ajax_failed' => __('AJAX request failed', 'g33ki-cloud-storage-for-media-library'),
                'fixed' => __('Fixed', 'g33ki-cloud-storage-for-media-library'),
                'file_updated' => __('file(s) updated successfully.', 'g33ki-cloud-storage-for-media-library'),
                'attachment' => __('Attachment', 'g33ki-cloud-storage-for-media-library'),
            )
        ));
    }
    
    /**
     * Filter attachment URL
     */
    public function filter_attachment_url($url, $post_id) {
        $remote_url = get_post_meta($post_id, 'g33ki_remote_url', true);
        if (!$remote_url) {
            $remote_url = get_post_meta($post_id, 'omtc_remote_url', true);
        }
        if ($remote_url) {
            return $remote_url;
        }
        return $url;
    }
    
    /**
     * Filter attachment image src
     */
    public function filter_attachment_image_src($image, $attachment_id, $size, $icon) {
        if ($image && isset($image[0])) {
            $remote_url = '';
            // $size is usually a registered size name (string), but WordPress can
            // also pass an array of [width, height]. Only named sizes map to our
            // per-size meta keys, so guard the concatenation — passing an array
            // here raised "Array to string conversion" warnings.
            if (is_string($size) && $size !== '') {
                $remote_url = get_post_meta($attachment_id, 'g33ki_remote_url_' . $size, true);
                if (!$remote_url) {
                    $remote_url = get_post_meta($attachment_id, 'omtc_remote_url_' . $size, true);
                }
            }
            if (!$remote_url) {
                $remote_url = get_post_meta($attachment_id, 'g33ki_remote_url', true);
            }
            if (!$remote_url) {
                $remote_url = get_post_meta($attachment_id, 'omtc_remote_url', true);
            }
            if ($remote_url) {
                $image[0] = $remote_url;
            }
        }
        return $image;
    }
    
    /**
     * Filter srcset URLs to use cloud storage
     */
    public function filter_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
        if (!is_array($sources)) {
            return $sources;
        }

        $remote_url = get_post_meta($attachment_id, 'g33ki_remote_url', true);
        if (!$remote_url) {
            $remote_url = get_post_meta($attachment_id, 'omtc_remote_url', true);
        }
        
        if (!$remote_url) {
            return $sources;
        }

        $upload_dir = wp_upload_dir();
        $base_url = $upload_dir['baseurl'];
        $settings = get_option('g33ki_settings', array());
        $cloud_base = $this->get_cloud_base_url($settings);

        foreach ($sources as $width => $source) {
            if (strpos($source['url'], $base_url) !== false) {
                $relative = str_replace($base_url . '/', '', $source['url']);
                $prefix = !empty($settings['path_prefix']) ? trailingslashit($settings['path_prefix']) : '';
                $sources[$width]['url'] = $cloud_base . $prefix . $relative;
            }
        }

        return $sources;
    }

    /**
     * Replace local upload URLs in post content with cloud URLs
     */
    public function filter_content_urls($content) {
        if (empty($content)) {
            return $content;
        }

        $settings = get_option('g33ki_settings', array());
        if (empty($settings['provider']) || empty($settings['bucket'])) {
            return $content;
        }

        $upload_dir = wp_upload_dir();
        $base_url = $upload_dir['baseurl'];
        $cloud_base = $this->get_cloud_base_url($settings);
        $prefix = !empty($settings['path_prefix']) ? trailingslashit($settings['path_prefix']) : '';
        $cloud_url = esc_url($cloud_base . $prefix);

        // Replace full URL (https)
        $content = str_replace($base_url . '/', $cloud_url, $content);

        // Replace http version if site uses https
        if (strpos($base_url, 'https://') === 0) {
            $http_base = str_replace('https://', 'http://', $base_url);
            $content = str_replace($http_base . '/', $cloud_url, $content);
        }

        // Replace relative /wp-content/uploads/ paths in src attributes
        $relative_path = wp_parse_url($base_url, PHP_URL_PATH);
        if ($relative_path) {
            $content = str_replace('"' . $relative_path . '/', '"' . $cloud_url, $content);
            $content = str_replace("'" . $relative_path . "/", "'" . $cloud_url, $content);
        }

        return $content;
    }

    /**
     * Filter the entire page output to replace upload URLs
     */
    public function filter_output_buffer($html) {
        if (empty($html)) {
            return $html;
        }
        return $this->filter_content_urls($html);
    }

    /**
     * Get cloud base URL (CDN or origin)
     */
    private function get_cloud_base_url($settings) {
        if (!empty($settings['cdn_url'])) {
            return trailingslashit($settings['cdn_url']);
        }

        $bucket = $settings['bucket'];
        $region = isset($settings['region']) ? $settings['region'] : '';
        $provider = isset($settings['provider']) ? $settings['provider'] : '';

        if ($provider === 'spaces') {
            return "https://{$bucket}.{$region}.digitaloceanspaces.com/";
        } elseif ($provider === 'gcs') {
            return "https://storage.googleapis.com/{$bucket}/";
        } else {
            if ($region === 'us-east-1') {
                return "https://{$bucket}.s3.amazonaws.com/";
            }
            return "https://{$bucket}.s3.{$region}.amazonaws.com/";
        }
    }

    /**
     * Render bulk offload page
     */
    public function render_bulk_offload_page() {
        require_once G33KI_PLUGIN_DIR . 'includes/views/bulk-offload.php';
    }

    /**
     * Render bulk restore page
     */
    public function render_bulk_restore_page() {
        require_once G33KI_PLUGIN_DIR . 'includes/views/bulk-restore.php';
    }
    
    /**
     * Render fix permissions page
     */
    public function render_fix_permissions_page() {
        require_once G33KI_PLUGIN_DIR . 'includes/views/fix-permissions.php';
    }

    /**
     * Render fix thumbnails page
     */
    public function render_fix_thumbnails_page() {
        require_once G33KI_PLUGIN_DIR . 'includes/views/fix-thumbnails.php';
    }

    /**
     * Render fix URLs page
     */
    public function render_fix_urls_page() {
        require_once G33KI_PLUGIN_DIR . 'includes/views/fix-urls.php';
    }

    /**
     * Add action links on Plugins page
     */
    public function plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=g33ki-cloud-storage-for-media-library') . '">' . __('Settings', 'g33ki-cloud-storage-for-media-library') . '</a>';
        $kofi_link = '<a href="https://ko-fi.com/gunjanjaswal" target="_blank" style="color:#0073aa; font-weight:bold;">' . __('Support on Ko-fi', 'g33ki-cloud-storage-for-media-library') . '</a>';
        array_unshift($links, $settings_link, $kofi_link);
        return $links;
    }

    /**
     * Add meta links on Plugins page (row meta)
     */
    public function plugin_row_meta($links, $file) {
        if ($file === G33KI_PLUGIN_BASENAME) {
            $links[] = '<a href="https://wordpress.org/support/plugin/g33ki-cloud-storage-for-media-library/" target="_blank">' . __('Plugin Support', 'g33ki-cloud-storage-for-media-library') . '</a>';
            $links[] = '<a href="mailto:hello@gunjanjaswal.me">' . __('Contact Developer', 'g33ki-cloud-storage-for-media-library') . '</a>';
        }
        return $links;
    }

    /**
     * Whether any offloaded attachment is missing its local copy.
     *
     * This is the "danger" state: media lives only in the cloud, so
     * deactivating the plugin would break those URLs. The result is cached in
     * a transient because the notice is shown on every admin screen, and the
     * cache is cleared whenever a bulk offload or restore runs.
     *
     * @return bool
     */
    public function local_files_missing() {
        $cached = get_transient('g33ki_local_files_missing');
        if ($cached !== false) {
            return $cached === 'yes';
        }

        // Sample a bounded set of offloaded attachments rather than the whole
        // library, so this stays cheap enough to run on any admin page.
        $args = array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 50,
            'fields'         => 'ids',
            'no_found_rows'  => true,
            // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Needed to track offload state via meta
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'g33ki_remote_url',
                    'compare' => 'EXISTS',
                ),
                array(
                    'key'     => 'omtc_remote_url',
                    'compare' => 'EXISTS',
                ),
            ),
        );

        $query   = new WP_Query($args);
        $missing = false;
        foreach ($query->posts as $id) {
            if (!file_exists(get_attached_file($id))) {
                $missing = true;
                break;
            }
        }

        set_transient('g33ki_local_files_missing', $missing ? 'yes' : 'no', 6 * HOUR_IN_SECONDS);
        return $missing;
    }

    /**
     * Clear the cached "local files missing" state.
     *
     * Called after bulk offload/restore so the warning reflects reality on the
     * next admin page load.
     */
    public static function clear_local_files_cache() {
        delete_transient('g33ki_local_files_missing');
    }

    /**
     * The warning text shown to admins.
     *
     * @return string
     */
    private function warning_message() {
        return __('Some media files exist only in cloud storage. If you deactivate this plugin, those media URLs will break.', 'g33ki-cloud-storage-for-media-library');
    }

    /**
     * Persistent, dismissible warning shown on every admin page (including this
     * plugin's own screens) while media lives only in the cloud.
     */
    public function deactivation_warning_notice() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Respect a per-user dismissal.
        if (get_user_meta(get_current_user_id(), 'g33ki_hide_deactivation_warning', true)) {
            return;
        }

        if (!$this->local_files_missing()) {
            return;
        }

        $restore_url = admin_url('admin.php?page=g33ki-bulk-restore');
        $nonce       = wp_create_nonce('g33ki_dismiss_warning');

        echo '<div class="notice notice-warning is-dismissible g33ki-deactivation-warning" data-nonce="' . esc_attr($nonce) . '">';
        echo '<p><strong>' . esc_html__('OffloadForge', 'g33ki-cloud-storage-for-media-library') . ':</strong> ';
        echo esc_html($this->warning_message()) . ' ';
        echo '<a href="' . esc_url($restore_url) . '"><strong>' . esc_html__('Restore local files first', 'g33ki-cloud-storage-for-media-library') . '</strong></a>';
        echo '</p></div>';

        // Persist the dismissal when the user clicks the X. `ajaxurl` is always
        // defined in wp-admin; jQuery ships with core. Core injects the
        // .notice-dismiss button after DOM ready, so we delegate off document.
        ?>
        <script>
        (function ($) {
            $(document).on('click', '.g33ki-deactivation-warning .notice-dismiss', function () {
                $.post(ajaxurl, {
                    action: 'g33ki_dismiss_deactivation_warning',
                    nonce: $(this).closest('.g33ki-deactivation-warning').data('nonce')
                });
            });
        })(jQuery);
        </script>
        <?php
    }

    /**
     * Store the per-user dismissal of the deactivation warning.
     */
    public function dismiss_deactivation_warning() {
        check_ajax_referer('g33ki_dismiss_warning', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error();
        }

        update_user_meta(get_current_user_id(), 'g33ki_hide_deactivation_warning', 1);
        wp_send_json_success();
    }

    /**
     * Permanent highlighted row directly under the plugin on plugins.php.
     *
     * Unlike the dismissible notice, this stays put as long as media lives only
     * in the cloud, keeping the risk visible right where deactivation happens.
     *
     * @param string $plugin_file Plugin file (unused; hook is name-scoped).
     * @param array  $plugin_data Plugin data (unused).
     * @param string $status      Plugin status (unused).
     */
    public function plugin_row_warning($plugin_file, $plugin_data, $status) {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (!$this->local_files_missing()) {
            return;
        }

        // Match the plugin list table's column count so the highlighted row
        // spans the full width like a core update notice.
        $columns = 4;
        if (function_exists('_get_list_table')) {
            $table = _get_list_table('WP_Plugins_List_Table');
            if (is_object($table) && method_exists($table, 'get_column_count')) {
                $columns = $table->get_column_count();
            }
        }

        $restore_url = admin_url('admin.php?page=g33ki-bulk-restore');

        echo '<tr class="plugin-update-tr active g33ki-plugin-row-warning">';
        echo '<td colspan="' . esc_attr($columns) . '" class="plugin-update colspanchange">';
        echo '<div class="notice inline notice-warning notice-alt"><p>';
        echo '<strong>' . esc_html__('Important:', 'g33ki-cloud-storage-for-media-library') . '</strong> ';
        echo esc_html($this->warning_message()) . ' ';
        echo '<a href="' . esc_url($restore_url) . '"><strong>' . esc_html__('Restore local files first', 'g33ki-cloud-storage-for-media-library') . '</strong></a>';
        echo '</p></div>';
        echo '</td></tr>';
    }

    /**
     * Activation hook
     */
    public static function activate() {
        // Create options table if needed
        add_option('g33ki_settings', array());
        flush_rewrite_rules();
    }
    
    /**
     * Deactivation hook
     */
    public static function deactivate() {
        flush_rewrite_rules();
    }
}


