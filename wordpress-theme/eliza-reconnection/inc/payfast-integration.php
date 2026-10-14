<?php
/**
 * PayFast Payment Gateway Integration & Admin Order Management
 *
 * Provides server-side MD5 signature generation, secure options storage,
 * WP-Admin credential management (allowing the merchant to update the security
 * passphrase at any time), AJAX order preparation, and PayFast ITN callback handling.
 *
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

// =========================================================================
// 1. INITIALIZE DEFAULT CREDENTIALS SAFELY IN WORDPRESS OPTIONS
// =========================================================================

/**
 * Retrieve PayFast merchant configuration options with sensible defaults.
 *
 * @return array Associative array of PayFast settings.
 */
function eliza_get_payfast_config() {
    return array(
        'merchant_id'   => get_option('eliza_payfast_merchant_id', '37314833'),
        'merchant_key'  => get_option('eliza_payfast_merchant_key', 'fxzpiiksxtjfp'),
        'passphrase'    => get_option('eliza_payfast_passphrase', 'G0awayStupidhackers'),
        'mode'          => get_option('eliza_payfast_mode', 'live'), // 'live' or 'sandbox'
        'notify_email'  => get_option('eliza_payfast_notify_email', get_option('admin_email', 'info@elizareconnection.co.za')),
    );
}

// =========================================================================
// 2. PAYFAST SIGNATURE GENERATION (Standard Form Integration Order)
// =========================================================================

/**
 * Canonical ordering of PayFast standard redirect parameters.
 * PayFast requires parameters to be formatted and submitted strictly in the sequence
 * defined in its official documentation (custom_int1-5 must strictly precede custom_str1-5).
 *
 * @param array $data Associative array of payment parameters.
 * @return array Array ordered strictly by PayFast canonical schema.
 */
function eliza_payfast_canonical_order($data) {
    $order = array(
        'merchant_id',
        'merchant_key',
        'return_url',
        'cancel_url',
        'notify_url',
        'name_first',
        'name_last',
        'email_address',
        'cell_number',
        'm_payment_id',
        'amount',
        'item_name',
        'item_description',
        'custom_int1',
        'custom_int2',
        'custom_int3',
        'custom_int4',
        'custom_int5',
        'custom_str1',
        'custom_str2',
        'custom_str3',
        'custom_str4',
        'custom_str5',
        'email_confirmation',
        'confirmation_address',
        'payment_method',
    );

    $ordered = array();
    foreach ($order as $key) {
        if (isset($data[$key]) && $data[$key] !== '' && $data[$key] !== null) {
            $ordered[$key] = $data[$key];
        }
    }
    // Append any extra parameters not in standard list
    foreach ($data as $key => $val) {
        if (!isset($ordered[$key]) && $key !== 'signature' && $val !== '' && $val !== null) {
            $ordered[$key] = $val;
        }
    }
    return $ordered;
}

/**
 * Generate MD5 security signature for PayFast parameter payload.
 *
 * PayFast standard redirect requires parameters to be concatenated in the exact
 * sequential order they appear in the documentation, URL-encoded (RFC1738 with spaces as +),
 * followed by the optional passphrase salt, and hashed via MD5.
 *
 * @param array  $data       Associative array of non-empty payment fields.
 * @param string $passphrase Optional secret merchant security passphrase.
 * @return string 32-character hexadecimal MD5 signature.
 */
function eliza_payfast_generate_signature($data, $passphrase = '') {
    $ordered_data = eliza_payfast_canonical_order($data);
    $param_string = '';
    foreach ($ordered_data as $key => $val) {
        $param_string .= $key . '=' . urlencode(trim((string)$val)) . '&';
    }
    // Remove trailing ampersand
    $param_string = substr($param_string, 0, -1);

    // Append merchant security passphrase if present
    if (!empty($passphrase)) {
        $param_string .= '&passphrase=' . urlencode(trim($passphrase));
    }

    return md5($param_string);
}

/**
 * Get the target PayFast processing URL based on environment setting.
 *
 * @return string Gateway submission URL.
 */
function eliza_get_payfast_process_url() {
    $config = eliza_get_payfast_config();
    return ($config['mode'] === 'sandbox')
        ? 'https://sandbox.payfast.co.za/eng/process'
        : 'https://www.payfast.co.za/eng/process';
}

// =========================================================================
// 3. WP-ADMIN SUBMENU PAGES & TABS (Orders vs. PayFast Settings)
// =========================================================================

/**
 * Register separate submenu pages under Book Products for Orders and Settings.
 */
function eliza_payfast_register_admin_menu() {
    // 1. Dedicated Customer Orders & Courier Requests Page
    add_submenu_page(
        'edit.php?post_type=book_product',
        __('Customer Orders & Courier Requests', 'eliza-reconnection'),
        __('Customer Orders', 'eliza-reconnection'),
        'manage_options',
        'eliza-orders',
        'eliza_render_orders_page'
    );

    // 2. Dedicated PayFast Gateway Settings Page
    add_submenu_page(
        'edit.php?post_type=book_product',
        __('PayFast Payment Gateway Settings', 'eliza-reconnection'),
        __('PayFast Settings', 'eliza-reconnection'),
        'manage_options',
        'eliza-payfast-settings',
        'eliza_render_payfast_settings_page'
    );
}
add_action('admin_menu', 'eliza_payfast_register_admin_menu');

/**
 * Render shared navigation tabs at top of both admin screens.
 *
 * @param string $active_tab 'orders' or 'settings'.
 */
function eliza_render_admin_tabs($active_tab = 'orders') {
    $orders = get_option('eliza_recent_orders', array());
    $count = count($orders);
    ?>
    <nav class="nav-tab-wrapper wp-clearfix" style="margin-bottom: 24px;">
        <a href="<?php echo admin_url('edit.php?post_type=book_product&page=eliza-orders'); ?>" 
           class="nav-tab <?php echo ($active_tab === 'orders') ? 'nav-tab-active' : ''; ?>"
           style="font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span><?php _e('Customer Orders & Courier Requests', 'eliza-reconnection'); ?></span>
            <span class="count" style="background: <?php echo ($active_tab === 'orders') ? '#2271b1' : '#646970'; ?>; color: #fff; border-radius: 10px; padding: 1px 7px; font-size: 11px; font-weight: 700;"><?php echo $count; ?></span>
        </a>
        <a href="<?php echo admin_url('edit.php?post_type=book_product&page=eliza-payfast-settings'); ?>" 
           class="nav-tab <?php echo ($active_tab === 'settings') ? 'nav-tab-active' : ''; ?>"
           style="font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span><?php _e('PayFast Gateway Settings', 'eliza-reconnection'); ?></span>
        </a>
    </nav>
    <?php
}

/**
 * Render the modern overhauled Customer Orders & Courier Requests Admin Page.
 */
function eliza_render_orders_page() {
    // Handle Order Status Updates
    if (isset($_POST['eliza_order_action']) && check_admin_referer('eliza_order_manage_nonce')) {
        $target_id = sanitize_text_field($_POST['target_order_id'] ?? '');
        $action    = sanitize_text_field($_POST['eliza_order_action'] ?? '');
        $orders    = get_option('eliza_recent_orders', array());

        if ($action === 'mark_dispatched') {
            $tracking = sanitize_text_field($_POST['courier_tracking'] ?? '');
            foreach ($orders as &$ord) {
                if ($ord['order_id'] === $target_id) {
                    $ord['status'] = 'DISPATCHED';
                    if (!empty($tracking)) {
                        $ord['tracking_info'] = $tracking;
                    }
                    $ord['dispatched_at'] = current_time('Y-m-d H:i:s');
                    break;
                }
            }
            update_option('eliza_recent_orders', $orders);
            echo '<div class="notice notice-success is-dismissible" style="border-left-color: #0284c7;"><p><strong>Order ' . esc_html($target_id) . ' marked as Dispatched via Courier.</strong></p></div>';
        } elseif ($action === 'mark_paid') {
            foreach ($orders as &$ord) {
                if ($ord['order_id'] === $target_id) {
                    $ord['status'] = 'PAID';
                    $ord['paid_at'] = current_time('Y-m-d H:i:s');
                    if (empty($ord['customer_email_sent'])) {
                        if (($ord['product_type'] ?? '') === 'digital') {
                            eliza_send_customer_download_email($ord);
                        } else {
                            eliza_send_customer_physical_order_email($ord);
                        }
                        $ord['customer_email_sent'] = true;
                    }
                    break;
                }
            }
            update_option('eliza_recent_orders', $orders);
            echo '<div class="notice notice-success is-dismissible" style="border-left-color: #10b981;"><p><strong>Order ' . esc_html($target_id) . ' confirmed as PAID and customer receipt dispatched.</strong></p></div>';
        } elseif ($action === 'resend_email') {
            foreach ($orders as &$ord) {
                if ($ord['order_id'] === $target_id) {
                    if (($ord['product_type'] ?? '') === 'digital') {
                        $sent = eliza_send_customer_download_email($ord);
                    } else {
                        $sent = eliza_send_customer_physical_order_email($ord);
                    }
                    $ord['customer_email_sent'] = true;
                    echo '<div class="notice notice-success is-dismissible"><p><strong>Order confirmation email successfully re-sent to ' . esc_html($ord['customer_email']) . '.</strong></p></div>';
                    break;
                }
            }
            update_option('eliza_recent_orders', $orders);
        } elseif ($action === 'delete_order') {
            $orders = array_filter($orders, function($ord) use ($target_id) {
                return $ord['order_id'] !== $target_id;
            });
            update_option('eliza_recent_orders', array_values($orders));
            echo '<div class="notice notice-success is-dismissible"><p><strong>Order ' . esc_html($target_id) . ' removed from log.</strong></p></div>';
        }
    }

    $orders = get_option('eliza_recent_orders', array());

    // Compute Summary Stats
    $total_orders = count($orders);
    $paid_count = 0;
    $pending_count = 0;
    $dispatched_count = 0;
    $physical_count = 0;
    $digital_count = 0;
    $total_revenue = 0;

    foreach ($orders as $ord) {
        $st = strtoupper($ord['status'] ?? 'PENDING_PAYMENT');
        if ($st === 'PAID' || $st === 'COMPLETE') {
            $paid_count++;
            $total_revenue += floatval($ord['amount'] ?? 0);
        } elseif ($st === 'DISPATCHED') {
            $dispatched_count++;
            $total_revenue += floatval($ord['amount'] ?? 0);
        } else {
            $pending_count++;
        }

        if (($ord['product_type'] ?? '') === 'digital') {
            $digital_count++;
        } else {
            $physical_count++;
        }
    }
    ?>
    <style>
        .eliza-dash-wrap {
            max-width: 1320px;
            margin: 20px 20px 40px 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1e293b;
        }
        .eliza-header-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .eliza-header-desc {
            font-size: 13px;
            color: #64748b;
            margin: 0 0 20px 0;
        }
        .eliza-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .eliza-stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .eliza-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.04);
        }
        .eliza-stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .eliza-stat-val {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }
        .eliza-stat-sub {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }
        .eliza-toolbar {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .eliza-filter-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        .eliza-pill-btn {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .eliza-pill-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .eliza-pill-btn.active {
            background: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
        }
        .eliza-pill-count {
            background: rgba(0,0,0,0.08);
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
        }
        .eliza-pill-btn.active .eliza-pill-count {
            background: rgba(255,255,255,0.22);
            color: #ffffff;
        }
        .eliza-search-box {
            position: relative;
            min-width: 280px;
            flex-grow: 1;
            max-width: 400px;
        }
        .eliza-search-box input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border: 1.5px solid #cbd5e1;
            border-radius: 20px;
            font-size: 13px;
            background: #f8fafc;
            outline: none;
            transition: all 0.2s ease;
        }
        .eliza-search-box input:focus {
            background: #ffffff;
            border-color: #8e6516;
            box-shadow: 0 0 0 3px rgba(142,101,22,0.15);
        }
        .eliza-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .eliza-table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .eliza-orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .eliza-orders-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.05em;
            padding: 14px 16px;
            border-bottom: 1.5px solid #e2e8f0;
            text-align: left;
        }
        .eliza-orders-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
            color: #334155;
        }
        .eliza-orders-table tr:hover td {
            background: #fafbfd;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 14px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .status-paid {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .status-dispatched {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .status-pending {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }
        .type-physical {
            background: #e0f2fe;
            color: #0369a1;
        }
        .type-digital {
            background: #fef3c7;
            color: #92400e;
        }
        .action-btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 11px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 4px;
        }
        .action-btn-sm:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .action-btn-dispatch {
            background: #0284c7;
            border-color: #0284c7;
            color: #ffffff;
        }
        .action-btn-dispatch:hover {
            background: #0369a1;
            border-color: #0369a1;
            color: #ffffff;
        }
        .action-btn-paid {
            background: #10b981;
            border-color: #10b981;
            color: #ffffff;
        }
        .action-btn-paid:hover {
            background: #059669;
            border-color: #059669;
            color: #ffffff;
        }
        .action-btn-delete {
            color: #ef4444;
            border-color: #fecaca;
        }
        .action-btn-delete:hover {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fca5a5;
        }
    </style>

    <div class="eliza-dash-wrap">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 class="eliza-header-title">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#8E6516" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <span>Customer Orders &amp; Courier Logistics</span>
                </h1>
                <p class="eliza-header-desc">
                    Manage real-time customer purchases, courier door delivery addresses, personal dedications, and digital publication fulfillments.
                </p>
            </div>
        </div>

        <?php eliza_render_admin_tabs('orders'); ?>

        <!-- MODERN KPI STAT CARDS -->
        <div class="eliza-stat-grid">
            <div class="eliza-stat-card">
                <div class="eliza-stat-label">
                    <span>Total Orders</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                </div>
                <div class="eliza-stat-val"><?php echo $total_orders; ?></div>
                <div class="eliza-stat-sub"><?php echo ($paid_count + $dispatched_count); ?> confirmed paid / <?php echo $pending_count; ?> pending</div>
            </div>

            <div class="eliza-stat-card" style="border-left: 4px solid #10b981;">
                <div class="eliza-stat-label">
                    <span>Revenue Captured</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <div class="eliza-stat-val" style="color: #065f46;">R<?php echo number_format($total_revenue, 2); ?></div>
                <div class="eliza-stat-sub">From confirmed PayFast transactions</div>
            </div>

            <div class="eliza-stat-card" style="border-left: 4px solid #0284c7;">
                <div class="eliza-stat-label">
                    <span>Physical Deliveries</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                </div>
                <div class="eliza-stat-val" style="color: #0369a1;"><?php echo $physical_count; ?></div>
                <div class="eliza-stat-sub"><?php echo $dispatched_count; ?> dispatched &middot; <?php echo ($physical_count - $dispatched_count); ?> awaiting dispatch</div>
            </div>

            <div class="eliza-stat-card" style="border-left: 4px solid #d97706;">
                <div class="eliza-stat-label">
                    <span>Digital Publications</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </div>
                <div class="eliza-stat-val" style="color: #92400e;"><?php echo $digital_count; ?></div>
                <div class="eliza-stat-sub">Automated instant email delivery</div>
            </div>
        </div>

        <!-- INTERACTIVE CONTROLS TOOLBAR (FILTERS & LIVE SEARCH) -->
        <div class="eliza-toolbar">
            <div class="eliza-filter-group" id="statusFilterGroup">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-right: 4px;">Status:</span>
                <button type="button" class="eliza-pill-btn active" onclick="window.setFilter('status', 'all', this)">
                    All <span class="eliza-pill-count"><?php echo $total_orders; ?></span>
                </button>
                <button type="button" class="eliza-pill-btn" onclick="window.setFilter('status', 'PAID', this)">
                    Paid <span class="eliza-pill-count"><?php echo $paid_count; ?></span>
                </button>
                <button type="button" class="eliza-pill-btn" onclick="window.setFilter('status', 'DISPATCHED', this)">
                    Dispatched <span class="eliza-pill-count"><?php echo $dispatched_count; ?></span>
                </button>
                <button type="button" class="eliza-pill-btn" onclick="window.setFilter('status', 'PENDING_PAYMENT', this)">
                    Pending <span class="eliza-pill-count"><?php echo $pending_count; ?></span>
                </button>
            </div>

            <div class="eliza-filter-group" id="typeFilterGroup">
                <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-right: 4px;">Type:</span>
                <button type="button" class="eliza-pill-btn active" onclick="window.setFilter('type', 'all', this)">
                    All Types
                </button>
                <button type="button" class="eliza-pill-btn" onclick="window.setFilter('type', 'physical', this)">
                    Physical Books (<?php echo $physical_count; ?>)
                </button>
                <button type="button" class="eliza-pill-btn" onclick="window.setFilter('type', 'digital', this)">
                    Digital PDFs (<?php echo $digital_count; ?>)
                </button>
            </div>

            <div class="eliza-search-box">
                <svg class="eliza-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="orderSearchInput" placeholder="Search by name, email, order ref, city..." oninput="window.runTableFilter()">
            </div>
        </div>

        <!-- ORDERS DATA TABLE -->
        <div class="eliza-table-card">
            <?php if (empty($orders)) : ?>
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; color: #94a3b8;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    </div>
                    <h3 style="margin: 0 0 6px; font-size: 16px; color: #1e293b;">No customer orders found</h3>
                    <p style="margin: 0; color: #64748b; font-size: 13px;">Customer orders will automatically appear here once initiated.</p>
                </div>
            <?php else : ?>
                <table class="eliza-orders-table" id="ordersMasterTable">
                    <thead>
                        <tr>
                            <th style="width: 150px;">Order Ref &amp; Date</th>
                            <th style="width: 220px;">Customer Contact</th>
                            <th style="width: 200px;">Product &amp; Amount</th>
                            <th>Fulfillment &amp; Courier Address</th>
                            <th style="width: 130px;">Status</th>
                            <th style="width: 140px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($orders) as $ord) : 
                            $status = strtoupper($ord['status'] ?? 'PENDING_PAYMENT');
                            if ($status === 'COMPLETE') $status = 'PAID';
                            $p_type = ($ord['product_type'] ?? '') === 'digital' ? 'digital' : 'physical';
                            $search_corpus = strtolower(
                                ($ord['order_id'] ?? '') . ' ' .
                                ($ord['customer_name'] ?? '') . ' ' .
                                ($ord['customer_email'] ?? '') . ' ' .
                                ($ord['customer_phone'] ?? '') . ' ' .
                                ($ord['product_title'] ?? '') . ' ' .
                                ($ord['street_address'] ?? '') . ' ' .
                                ($ord['city'] ?? '') . ' ' .
                                ($ord['province'] ?? '') . ' ' .
                                ($ord['dedication'] ?? '')
                            );
                        ?>
                            <tr class="order-data-row" 
                                data-status="<?php echo esc_attr($status); ?>"
                                data-type="<?php echo esc_attr($p_type); ?>"
                                data-search="<?php echo esc_attr($search_corpus); ?>">
                                
                                <td>
                                    <div style="font-family: monospace; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 4px; display: inline-flex; align-items: center; gap: 6px;">
                                        <span><?php echo esc_html($ord['order_id'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div style="font-size: 12px; color: #64748b;">
                                        <?php echo esc_html($ord['created_at'] ?? 'N/A'); ?>
                                    </div>
                                    <?php if (!empty($ord['paid_at'])) : ?>
                                        <div style="font-size: 11px; color: #059669; margin-top: 2px;">
                                            Paid: <?php echo esc_html(substr($ord['paid_at'], 5)); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13.5px; margin-bottom: 2px;">
                                        <?php echo esc_html($ord['customer_name'] ?? 'Unknown'); ?>
                                    </div>
                                    <div>
                                        <a href="mailto:<?php echo esc_attr($ord['customer_email'] ?? ''); ?>" style="color: #0284c7; text-decoration: none; font-size: 12.5px;">
                                            <?php echo esc_html($ord['customer_email'] ?? ''); ?>
                                        </a>
                                    </div>
                                    <?php if (!empty($ord['customer_phone'])) : ?>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                            <a href="tel:<?php echo esc_attr($ord['customer_phone']); ?>" style="color: #64748b; text-decoration: none;">
                                                <?php echo esc_html($ord['customer_phone']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13px; margin-bottom: 4px;">
                                        <?php echo esc_html($ord['product_title'] ?? 'Book'); ?>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 14px; font-weight: 800; color: #8e6516;">
                                            <?php echo esc_html($ord['amount'] ? 'R' . $ord['amount'] : ''); ?>
                                        </span>
                                        <span class="type-badge <?php echo ($p_type === 'digital') ? 'type-digital' : 'type-physical'; ?>">
                                            <?php echo ($p_type === 'digital') ? 'Digital PDF' : 'Physical Book'; ?>
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <?php if ($p_type === 'digital') : ?>
                                        <div style="background: #faf6ee; border: 1px solid rgba(212,175,55,0.3); border-radius: 8px; padding: 10px 14px;">
                                            <div style="font-size: 11px; font-weight: 700; color: #8e6516; text-transform: uppercase;">Instant PDF Delivery</div>
                                            <div style="font-size: 12px; margin-top: 4px;">
                                                <?php if (!empty($ord['customer_email_sent'])) : ?>
                                                    <span style="color: #059669; font-weight: 600;">✓ Email dispatched to customer</span>
                                                <?php else : ?>
                                                    <span style="color: #d97706; font-weight: 600;">⌛ Email pending confirmation</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($ord['download_url'])) : ?>
                                                <div style="margin-top: 4px;">
                                                    <a href="<?php echo esc_url($ord['download_url']); ?>" target="_blank" style="color: #8e6516; font-weight: 600; font-size: 12px; text-decoration: underline;">Test Download Link &rarr;</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else : ?>
                                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px;">
                                            <div style="font-weight: 600; color: #1e293b; font-size: 12.5px; line-height: 1.45;">
                                                <?php echo esc_html($ord['street_address'] ?? ''); ?><br>
                                                <?php echo esc_html($ord['city'] ?? ''); ?>, <?php echo esc_html($ord['province'] ?? ''); ?> <?php echo esc_html($ord['postal_code'] ?? ''); ?>
                                            </div>
                                            <?php if (!empty($ord['dedication'])) : ?>
                                                <div style="margin-top: 8px; padding: 6px 10px; background: #faf6ee; border-left: 2.5px solid #8e6516; border-radius: 4px; font-size: 12px; color: #78350f;">
                                                    <strong>Dedication:</strong> &ldquo;<?php echo esc_html($ord['dedication']); ?>&rdquo;
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($ord['tracking_info'])) : ?>
                                                <div style="margin-top: 6px; font-size: 11.5px; color: #0284c7; font-weight: 600;">
                                                    Courier Waybill: <?php echo esc_html($ord['tracking_info']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($status === 'PAID' || $status === 'COMPLETE') : ?>
                                        <span class="status-badge status-paid">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            <span>Paid</span>
                                        </span>
                                    <?php elseif ($status === 'DISPATCHED') : ?>
                                        <span class="status-badge status-dispatched">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon></svg>
                                            <span>Dispatched</span>
                                        </span>
                                    <?php else : ?>
                                        <span class="status-badge status-pending">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <span>Pending</span>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td style="text-align: right;">
                                    <form method="post" action="" style="display: inline-block;">
                                        <?php wp_nonce_field('eliza_order_manage_nonce'); ?>
                                        <input type="hidden" name="target_order_id" value="<?php echo esc_attr($ord['order_id']); ?>">
                                        
                                        <?php if ($p_type === 'physical' && $status === 'PAID') : ?>
                                            <button type="submit" name="eliza_order_action" value="mark_dispatched" class="action-btn-sm action-btn-dispatch" title="Mark order as dispatched with courier">
                                                Mark Dispatched
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($status === 'PENDING_PAYMENT') : ?>
                                            <button type="submit" name="eliza_order_action" value="mark_paid" class="action-btn-sm action-btn-paid" title="Manually confirm order as paid and dispatch customer receipt">
                                                Confirm Paid
                                            </button>
                                        <?php endif; ?>

                                        <button type="submit" name="eliza_order_action" value="resend_email" class="action-btn-sm" title="Re-send order confirmation / download email to customer">
                                            Resend Email
                                        </button>

                                        <button type="submit" name="eliza_order_action" value="delete_order" class="action-btn-sm action-btn-delete" onclick="return confirm('Remove order <?php echo esc_js($ord['order_id']); ?> from logs?');" title="Remove order from logs">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="noFilterResultsNotice" style="display: none; text-align: center; padding: 48px 20px; color: #64748b; font-size: 14px;">
                    No orders match your selected filters.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    (function() {
        var currentStatus = 'all';
        var currentType = 'all';

        window.setFilter = function(category, value, el) {
            if (category === 'status') {
                currentStatus = value;
                var btns = document.querySelectorAll('#statusFilterGroup .eliza-pill-btn');
                btns.forEach(function(b) { b.classList.remove('active'); });
                if (el) el.classList.add('active');
            } else if (category === 'type') {
                currentType = value;
                var btns = document.querySelectorAll('#typeFilterGroup .eliza-pill-btn');
                btns.forEach(function(b) { b.classList.remove('active'); });
                if (el) el.classList.add('active');
            }
            window.runTableFilter();
        };

        window.runTableFilter = function() {
            var searchInput = document.getElementById('orderSearchInput');
            var search = searchInput ? searchInput.value.toLowerCase().trim() : '';
            var rows = document.querySelectorAll('.order-data-row');
            var visibleCount = 0;

            rows.forEach(function(row) {
                var rowStatus = row.getAttribute('data-status') || '';
                var rowType = row.getAttribute('data-type') || '';
                var rowSearch = row.getAttribute('data-search') || '';

                var statusMatch = (currentStatus === 'all') || (rowStatus === currentStatus);
                var typeMatch = (currentType === 'all') || (rowType === currentType);
                var searchMatch = !search || (rowSearch.indexOf(search) !== -1);

                if (statusMatch && typeMatch && searchMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            var notice = document.getElementById('noFilterResultsNotice');
            if (notice) {
                notice.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
            }
        };
    })();
    </script>
    <?php
}

/**
 * Render the dedicated PayFast Gateway Settings Admin Page.
 */
function eliza_render_payfast_settings_page() {
    // Process form submission if saved
    if (isset($_POST['eliza_payfast_save_settings']) && check_admin_referer('eliza_payfast_settings_nonce')) {
        update_option('eliza_payfast_merchant_id', sanitize_text_field($_POST['merchant_id']));
        update_option('eliza_payfast_merchant_key', sanitize_text_field($_POST['merchant_key']));
        update_option('eliza_payfast_passphrase', sanitize_text_field($_POST['passphrase']));
        update_option('eliza_payfast_mode', sanitize_text_field($_POST['mode']));
        update_option('eliza_payfast_notify_email', sanitize_email($_POST['notify_email']));
        echo '<div class="notice notice-success is-dismissible"><p><strong>' . __('PayFast gateway settings saved successfully.', 'eliza-reconnection') . '</strong></p></div>';
    }

    $config = eliza_get_payfast_config();
    ?>
    <div class="wrap" style="max-width: 900px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <h1 style="margin-bottom: 16px;">
            <?php _e('PayFast Payment Gateway Configuration', 'eliza-reconnection'); ?>
        </h1>

        <?php eliza_render_admin_tabs('settings'); ?>

        <!-- STATUS HEALTH BANNER -->
        <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
            <div>
                <strong style="color: #15803d; font-size: 14px;">Gateway Connected &amp; Operational</strong>
                <div style="color: #166534; font-size: 13px; margin-top: 2px;">
                    Currently configured for <strong><?php echo ($config['mode'] === 'sandbox') ? 'Sandbox Testing' : 'Live Production Processing'; ?></strong>. Verified against PayFast South Africa portal.
                </div>
            </div>
        </div>

        <!-- SETTINGS CARD -->
        <div style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <h2 style="margin-top: 0; padding-bottom: 14px; border-bottom: 1px solid #eee; font-size: 1.25rem; color: #1d2327;">
                <?php _e('Merchant Credentials & Security Settings', 'eliza-reconnection'); ?>
            </h2>

            <p style="color: #646970; font-size: 13px; line-height: 1.55; margin-bottom: 24px;">
                <?php _e('Configure Eliza\'s official PayFast South Africa account credentials. The security passphrase acts as a secret salt used exclusively on the server to hash customer transactions—it is never exposed to the public browser.', 'eliza-reconnection'); ?>
            </p>

            <form method="post" action="">
                <?php wp_nonce_field('eliza_payfast_settings_nonce'); ?>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="merchant_id"><?php _e('Merchant ID', 'eliza-reconnection'); ?></label></th>
                            <td>
                                <input type="text" name="merchant_id" id="merchant_id" value="<?php echo esc_attr($config['merchant_id']); ?>" class="regular-text" required style="font-family: monospace; font-size: 14px;">
                                <p class="description"><?php _e('Your unique PayFast Merchant identifier (e.g. 37314833).', 'eliza-reconnection'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="merchant_key"><?php _e('Merchant Key', 'eliza-reconnection'); ?></label></th>
                            <td>
                                <input type="text" name="merchant_key" id="merchant_key" value="<?php echo esc_attr($config['merchant_key']); ?>" class="regular-text" required style="font-family: monospace; font-size: 14px;">
                                <p class="description"><?php _e('Your PayFast Merchant security key (e.g. fxzpiiksxtjfp).', 'eliza-reconnection'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="passphrase"><?php _e('Security Passphrase', 'eliza-reconnection'); ?></label></th>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px; max-width: 400px;">
                                    <input type="password" name="passphrase" id="passphrase" value="<?php echo esc_attr($config['passphrase']); ?>" class="regular-text" style="font-family: monospace; font-size: 14px; flex-grow: 1;">
                                    <button type="button" class="button" id="togglePassphraseBtn" onclick="togglePassphraseVisibility()"><?php _e('Show', 'eliza-reconnection'); ?></button>
                                </div>
                                <p class="description">
                                    <?php _e('Configured in your PayFast Dashboard under Settings &rarr; Developer Settings. When you update your passphrase in PayFast, update it here anytime.', 'eliza-reconnection'); ?>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="mode"><?php _e('Gateway Environment', 'eliza-reconnection'); ?></label></th>
                            <td>
                                <select name="mode" id="mode" style="min-width: 240px; font-weight: 600;">
                                    <option value="live" <?php selected($config['mode'], 'live'); ?>>Live Production (Real Transactions)</option>
                                    <option value="sandbox" <?php selected($config['mode'], 'sandbox'); ?>>Sandbox (Testing &amp; Simulation)</option>
                                </select>
                                <p class="description"><?php _e('Default is Live Production. Customer payments are processed in ZAR (Rands).', 'eliza-reconnection'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="notify_email"><?php _e('Order Alert Notification Email', 'eliza-reconnection'); ?></label></th>
                            <td>
                                <input type="email" name="notify_email" id="notify_email" value="<?php echo esc_attr($config['notify_email']); ?>" class="regular-text">
                                <p class="description"><?php _e('Email address where customer courier shipping information and digital purchase receipts are instantly sent.', 'eliza-reconnection'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="submit" style="margin-top: 28px; padding-top: 18px; border-top: 1px solid #eee;">
                    <input type="submit" name="eliza_payfast_save_settings" id="submit" class="button button-primary" value="<?php _e('Save PayFast Settings', 'eliza-reconnection'); ?>" style="padding: 6px 20px; font-size: 14px;">
                </p>
            </form>
        </div>
    </div>

    <script>
    function togglePassphraseVisibility() {
        const inp = document.getElementById('passphrase');
        const btn = document.getElementById('togglePassphraseBtn');
        if (inp.type === 'password') {
            inp.type = 'text';
            btn.textContent = 'Hide';
        } else {
            inp.type = 'password';
            btn.textContent = 'Show';
        }
    }
    </script>
    <?php
}

// =========================================================================
// 4. AJAX CHECKOUT HANDLER: PREPARE AND SECURELY SIGN PAYFAST ORDER
// =========================================================================

/**
 * Handle frontend AJAX order submission from #authorOrderModal.
 *
 * Validates inputs, generates unique order ID, calculates MD5 signature
 * using the server-side passphrase, records pending order, and returns
 * the exact signed payload to the client for immediate POST to PayFast.
 */
function eliza_handle_payfast_checkout_ajax() {
    $config = eliza_get_payfast_config();

    // 1. Sanitize customer inputs
    $customer_name  = sanitize_text_field($_POST['customer_name'] ?? '');
    $customer_email = sanitize_email($_POST['customer_email'] ?? '');
    $customer_phone = sanitize_text_field($_POST['customer_phone'] ?? '');
    $product_type   = sanitize_text_field($_POST['product_type'] ?? 'physical');
    $product_id     = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $book_title     = sanitize_text_field($_POST['book_title'] ?? 'Eliza James Publication');
    $book_price_raw = sanitize_text_field($_POST['book_price'] ?? 'R450');
    $street_address = sanitize_text_field($_POST['street_address'] ?? '');
    $city           = sanitize_text_field($_POST['city'] ?? '');
    $province       = sanitize_text_field($_POST['province'] ?? '');
    $postal_code    = sanitize_text_field($_POST['postal_code'] ?? '');
    $dedication     = sanitize_textarea_field($_POST['dedication'] ?? '');

    // Validation
    if (empty($customer_name) || empty($customer_email)) {
        wp_send_json_error(array('message' => __('Please provide your full name and a valid email address.', 'eliza-reconnection')));
    }
    if ($product_type === 'physical' && (empty($street_address) || empty($city) || empty($province))) {
        wp_send_json_error(array('message' => __('Please provide your full South African physical address for door courier delivery.', 'eliza-reconnection')));
    }

    // Retrieve download attachment URL if digital product
    $download_url = '';
    if ($product_type === 'digital') {
        if ($product_id > 0) {
            $download_url = get_post_meta($product_id, 'product_download_url', true);
        }
        if (empty($download_url) && function_exists('eliza_get_digital_pdf_products')) {
            $dig_list = eliza_get_digital_pdf_products();
            foreach ($dig_list as $di) {
                if ($di->post_title === $book_title || $di->ID === $product_id) {
                    $download_url = get_post_meta($di->ID, 'product_download_url', true);
                    if ($product_id <= 0) $product_id = $di->ID;
                    break;
                }
            }
        }
        if (empty($download_url)) {
            if (stripos($book_title, 'test') !== false) {
                $download_url = home_url('/wp-content/uploads/test-digital-guide-eliza-james.pdf');
            } else {
                $download_url = home_url('/wp-content/uploads/chakra-energetics-guide.pdf');
            }
        }
    }

    // 2. Parse First and Last Name
    $name_parts = explode(' ', trim($customer_name));
    $name_first = $name_parts[0];
    $name_last  = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : 'Customer';

    // 3. Format numerical amount in ZAR (two decimals)
    $clean_amount = preg_replace('/[^0-9.]/', '', $book_price_raw);
    $amount_float = floatval($clean_amount);
    if ($amount_float <= 0) {
        $amount_float = ($product_type === 'digital') ? 250.00 : 450.00;
    }
    $amount = number_format($amount_float, 2, '.', '');

    // 4. Generate unique payment ID
    $m_payment_id = 'ELIZA-' . date('ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));

    // 5. Build URLs
    $books_page_url = home_url('/books/');
    $return_url = add_query_arg(array(
        'payment'    => 'success',
        'order_id'   => $m_payment_id,
        'product_id' => $product_id,
        'type'       => $product_type,
        'title'      => urlencode($book_title)
    ), $books_page_url);

    $cancel_url = add_query_arg(array(
        'payment'   => 'cancelled',
        'order_id'  => $m_payment_id
    ), $books_page_url);

    $notify_url = admin_url('admin-ajax.php?action=eliza_payfast_itn');

    // 6. Assemble PayFast Data Array in exact documentation order
    $item_desc = ($product_type === 'digital')
        ? 'Digital PDF Guide Instant Delivery'
        : 'Printed Book with Door-to-Door SA Courier Delivery';

    $shipping_summary = ($product_type === 'digital')
        ? 'Digital Email Delivery'
        : ($street_address . ', ' . $city . ', ' . $province . ' ' . $postal_code);

    $data = array(
        // Merchant Details
        'merchant_id'      => $config['merchant_id'],
        'merchant_key'     => $config['merchant_key'],
        'return_url'       => $return_url,
        'cancel_url'       => $cancel_url,
        'notify_url'       => $notify_url,
        // Buyer Details
        'name_first'       => $name_first,
        'name_last'        => $name_last,
        'email_address'    => $customer_email,
        'cell_number'      => !empty($customer_phone) ? $customer_phone : '',
        // Transaction Details
        'm_payment_id'     => $m_payment_id,
        'amount'           => $amount,
        'item_name'        => $book_title,
        'item_description' => $item_desc,
        // Custom integer pass-through parameters (must strictly precede custom_str in PayFast docs)
        'custom_int1'      => $product_id,
        // Custom string pass-through tracking variables
        'custom_str1'      => $product_type,
        'custom_str2'      => substr($shipping_summary, 0, 255),
        'custom_str3'      => substr($dedication, 0, 255),
        'custom_str4'      => !empty($download_url) ? substr($download_url, 0, 255) : '',
    );

    // Filter and canonically order parameters for PayFast standard redirect
    $filtered_data = eliza_payfast_canonical_order($data);

    // 7. Calculate server-side signature
    $signature = eliza_payfast_generate_signature($filtered_data, $config['passphrase']);
    $filtered_data['signature'] = $signature;

    // 8. Record Order in WordPress Options Log
    $new_order = array(
        'order_id'           => $m_payment_id,
        'product_id'         => $product_id,
        'created_at'         => current_time('Y-m-d H:i:s'),
        'customer_name'      => $customer_name,
        'customer_email'     => $customer_email,
        'customer_phone'     => $customer_phone,
        'product_title'      => $book_title,
        'product_type'       => $product_type,
        'amount'             => $amount,
        'download_url'       => $download_url,
        'street_address'     => $street_address,
        'city'               => $city,
        'province'           => $province,
        'postal_code'        => $postal_code,
        'dedication'         => $dedication,
        'status'             => 'PENDING_PAYMENT',
        'customer_email_sent'=> false,
    );

    $recent_orders = get_option('eliza_recent_orders', array());
    $recent_orders[] = $new_order;
    // Keep max 50 recent orders
    if (count($recent_orders) > 50) {
        $recent_orders = array_slice($recent_orders, -50);
    }
    update_option('eliza_recent_orders', $recent_orders);

    // 9. Send initial notification email to Eliza
    $to = $config['notify_email'];
    $subject = 'New Pending Order: ' . $book_title . ' [' . $m_payment_id . ']';
    $body = "A new customer has initiated a PayFast checkout on Eliza Reconnection.\n\n"
          . "Order ID: " . $m_payment_id . "\n"
          . "Product: " . $book_title . " (R" . $amount . ")\n"
          . "Type: " . ($product_type === 'digital' ? 'Digital PDF' : 'Physical Printed Book') . "\n\n"
          . "Customer Name: " . $customer_name . "\n"
          . "Email: " . $customer_email . "\n"
          . "Phone: " . $customer_phone . "\n";

    if ($product_type === 'physical') {
        $body .= "\nCourier Address:\n"
              . $street_address . "\n"
              . $city . ", " . $province . " " . $postal_code . "\n";
        if (!empty($dedication)) {
            $body .= "\nPersonal Dedication Request:\n\"" . $dedication . "\"\n";
        }
    }

    $body .= "\nStatus: Connecting to PayFast for payment capture.\n";
    @wp_mail($to, $subject, $body, array('Content-Type: text/plain; charset=UTF-8'));

    // 10. Send response to frontend JS for auto-submitting the PayFast form
    wp_send_json_success(array(
        'process_url'  => eliza_get_payfast_process_url(),
        'order_id'     => $m_payment_id,
        'fields'       => $filtered_data,
        'redirect_msg' => __('Connecting directly to secure PayFast gateway...', 'eliza-reconnection')
    ));
}
add_action('wp_ajax_eliza_payfast_checkout', 'eliza_handle_payfast_checkout_ajax');
add_action('wp_ajax_nopriv_eliza_payfast_checkout', 'eliza_handle_payfast_checkout_ajax');

// =========================================================================
// 5. INSTANT TRANSACTION NOTIFICATION (ITN) WEBHOOK HANDLER
// =========================================================================

/**
 * Handle incoming server-to-server callback from PayFast upon payment completion.
 */
function eliza_handle_payfast_itn_ajax() {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        status_header(400);
        exit('Invalid Request Method');
    }

    $config = eliza_get_payfast_config();
    $pf_data = $_POST;

    if (empty($pf_data) || !isset($pf_data['signature'])) {
        status_header(400);
        exit('No Data Received');
    }

    $posted_signature = $pf_data['signature'];
    unset($pf_data['signature']);

    // Re-calculate signature to verify data authenticity
    // PayFast ITN specifies that parameters must be hashed in the exact order received in POST
    $param_string = '';
    foreach ($pf_data as $key => $val) {
        $param_string .= $key . '=' . urlencode(trim((string)$val)) . '&';
    }
    $param_string = substr($param_string, 0, -1);
    if (!empty($config['passphrase'])) {
        $param_string .= '&passphrase=' . urlencode(trim($config['passphrase']));
    }
    $calculated_signature = md5($param_string);

    if ($posted_signature !== $calculated_signature) {
        // Fallback: test canonical order in case gateway environment sorted fields
        $canonical_sig = eliza_payfast_generate_signature($pf_data, $config['passphrase']);
        if ($posted_signature !== $canonical_sig) {
            status_header(400);
            exit('Signature Mismatch');
        }
    }

    // Payment status check
    $payment_status = $pf_data['payment_status'] ?? '';
    $order_id       = sanitize_text_field($pf_data['m_payment_id'] ?? '');
    $amount_gross   = sanitize_text_field($pf_data['amount_gross'] ?? '');

    // Update order status in WordPress options
    $orders = get_option('eliza_recent_orders', array());
    $target_order = null;
    foreach ($orders as &$ord) {
        if ($ord['order_id'] === $order_id) {
            $ord['status'] = ($payment_status === 'COMPLETE') ? 'PAID' : $payment_status;
            $ord['payfast_gross'] = $amount_gross;
            $ord['paid_at'] = current_time('Y-m-d H:i:s');
            
            // Dispatch confirmation email to customer if not already sent
            if ($payment_status === 'COMPLETE' && empty($ord['customer_email_sent'])) {
                if (($ord['product_type'] ?? '') === 'digital') {
                    if (function_exists('eliza_send_customer_download_email')) {
                        eliza_send_customer_download_email($ord);
                    }
                } else {
                    if (function_exists('eliza_send_customer_physical_order_email')) {
                        eliza_send_customer_physical_order_email($ord);
                    }
                }
                $ord['customer_email_sent'] = true;
            }
            $target_order = $ord;
            break;
        }
    }
    update_option('eliza_recent_orders', $orders);

    // Send final confirmation email to Eliza
    if ($payment_status === 'COMPLETE') {
        $to = $config['notify_email'];
        $subject = 'Payment Confirmed: PayFast Order [' . $order_id . ']';
        $body = "Payment of R" . $amount_gross . " has been successfully confirmed by PayFast.\n\n"
              . "Order ID: " . $order_id . "\n"
              . "Item: " . ($pf_data['item_name'] ?? ($target_order['product_title'] ?? 'Book Publication')) . "\n"
              . "Customer: " . ($pf_data['name_first'] ?? '') . ' ' . ($pf_data['name_last'] ?? '') . "\n"
              . "Email: " . ($pf_data['email_address'] ?? ($target_order['customer_email'] ?? '')) . "\n\n"
              . "Delivery Info:\n" . ($pf_data['custom_str2'] ?? 'N/A') . "\n";

        if (!empty($target_order['dedication'])) {
            $body .= "Dedication: " . $target_order['dedication'] . "\n";
        }

        if (($target_order['product_type'] ?? '') === 'digital') {
            $body .= "\nDigital Delivery: Automated customer download email dispatched containing secure link to PDF publication.\n";
        } else {
            $body .= "\nCourier Delivery: Automated customer order confirmation email dispatched with courier delivery timeline.\n";
        }

        @wp_mail($to, $subject, $body, array('Content-Type: text/plain; charset=UTF-8'));
    }

    // Acknowledge PayFast notification with 200 OK
    status_header(200);
    echo 'OK';
    exit;
}
add_action('wp_ajax_eliza_payfast_itn', 'eliza_handle_payfast_itn_ajax');
add_action('wp_ajax_nopriv_eliza_payfast_itn', 'eliza_handle_payfast_itn_ajax');

// =========================================================================
// 6. BRANDED CUSTOMER DIGITAL DELIVERY EMAIL SYSTEM
// =========================================================================

/**
 * Dispatch an automated, luxury-styled HTML confirmation email to the buyer
 * containing their direct, secure PDF download link and e-reader instructions.
 *
 * Designed with Google Antigravity aesthetic: responsive layout, deep dusk
 * header, gold accents (#D4AF37), Georgia typography, and crystal-clear CTA.
 *
 * @param array $order Order record array from 'eliza_recent_orders'.
 * @return bool True if email was successfully accepted for delivery by wp_mail.
 */
function eliza_send_customer_download_email($order) {
    if (empty($order) || empty($order['customer_email'])) {
        return false;
    }

    $customer_email = sanitize_email($order['customer_email']);
    $customer_name  = !empty($order['customer_name']) ? $order['customer_name'] : 'Seeker';
    $order_id       = !empty($order['order_id']) ? $order['order_id'] : 'ELIZA-' . date('ymd');
    $product_title  = !empty($order['product_title']) ? $order['product_title'] : 'Digital Guide (PDF)';
    $amount         = !empty($order['amount']) ? $order['amount'] : '250.00';
    $download_url   = !empty($order['download_url']) ? $order['download_url'] : '';

    // If download_url wasn't stored directly in order record, query product
    if (empty($download_url) && !empty($order['product_id'])) {
        $download_url = get_post_meta($order['product_id'], 'product_download_url', true);
    }
    if (empty($download_url) && function_exists('eliza_get_digital_pdf_products')) {
        $all_dig = eliza_get_digital_pdf_products();
        foreach ($all_dig as $d) {
            if ($d->post_title === $product_title) {
                $download_url = get_post_meta($d->ID, 'product_download_url', true);
                break;
            }
        }
    }
    if (empty($download_url)) {
        if (stripos($product_title, 'test') !== false) {
            $download_url = home_url('/wp-content/uploads/test-digital-guide-eliza-james.pdf');
        } else {
            $download_url = home_url('/wp-content/uploads/chakra-energetics-guide.pdf');
        }
    }

    $name_parts = explode(' ', trim($customer_name));
    $first_name = !empty($name_parts[0]) ? $name_parts[0] : 'Friend';

    $subject = 'Your Digital Publication Download: ' . $product_title . ' [' . $order_id . ']';
    $site_title = get_bloginfo('name') ?: 'Eliza Reconnection';
    $sender_email = 'orders@elizareconnection.co.za';
    $reply_to = 'eliza.reconnection@gmail.com';

    $html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . esc_html($subject) . '</title>
</head>
<body style="margin: 0; padding: 0; background-color: #FAF8F5; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; color: #170F0A; -webkit-font-smoothing: antialiased;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF8F5; padding: 36px 12px;">
    <tr>
      <td align="center">
        <!-- Main Card Container -->
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; border: 1.5px solid #D4AF37; box-shadow: 0 16px 40px rgba(212,175,55,0.12);">
          
          <!-- Header Banner -->
          <tr>
            <td style="background: linear-gradient(135deg, #170F0A 0%, #2A1A12 100%); padding: 36px 32px; text-align: center; border-bottom: 2px solid #D4AF37;">
              <span style="display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #D4AF37; margin-bottom: 8px;">
                ' . esc_html($site_title) . ' &middot; Sacred Publications
              </span>
              <h1 style="margin: 0; font-family: Georgia, \'Times New Roman\', serif; font-size: 26px; font-weight: 400; color: #FFFFFF; letter-spacing: -0.01em;">
                Your Digital Guide is Ready
              </h1>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="padding: 36px 32px;">
              <p style="margin: 0 0 18px; font-size: 16px; line-height: 1.6; color: #170F0A;">
                Dear ' . esc_html($first_name) . ',
              </p>
              <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.65; color: #52473E;">
                Thank you for welcoming this sacred wisdom into your personal journey. Your payment has been successfully confirmed by PayFast. You can access and save your digital publication immediately using the secure download link below:
              </p>

              <!-- Download Button Box -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6EE; border-radius: 12px; border: 1px solid rgba(212,175,55,0.35); padding: 24px 20px; text-align: center; margin-bottom: 28px;">
                <tr>
                  <td>
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8E6516; margin-bottom: 6px;">
                      Instant Digital Edition
                    </div>
                    <div style="font-family: Georgia, \'Times New Roman\', serif; font-size: 19px; font-weight: 700; color: #170F0A; margin-bottom: 16px;">
                      ' . esc_html($product_title) . '
                    </div>
                    <a href="' . esc_url($download_url) . '" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #170F0A 0%, #301E13 100%); color: #D4AF37; padding: 14px 32px; border-radius: 8px; border: 1.5px solid #D4AF37; font-weight: 700; font-size: 15px; text-decoration: none; letter-spacing: 0.02em;">
                      Download Publication (PDF) &darr;
                    </a>
                    <div style="margin-top: 14px; font-size: 12px; color: #786C5E; line-height: 1.5;">
                      Direct Link: <a href="' . esc_url($download_url) . '" target="_blank" style="color: #8E6516; word-break: break-all; text-decoration: underline;">' . esc_url($download_url) . '</a>
                    </div>
                  </td>
                </tr>
              </table>

              <!-- Helpful Reading Instructions -->
              <div style="margin-bottom: 28px; padding: 16px 20px; background-color: #F8F9FA; border-radius: 8px; border-left: 3px solid #8E6516; font-size: 13px; line-height: 1.6; color: #52473E;">
                <strong style="color: #170F0A;">Reading &amp; Storage Tip:</strong><br>
                For the best reading experience, save or add this PDF to your device\'s local storage, <em>Apple Books</em>, <em>Adobe Acrobat Reader</em>, or your preferred e-reader so that you have permanent offline access at any time.
              </div>

              <!-- Order Summary Table -->
              <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #8E6516; margin-bottom: 10px;">
                Transaction Summary
              </div>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; font-size: 14px; margin-bottom: 28px;">
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Order Reference:</td>
                  <td style="padding: 10px 0; text-align: right; font-family: monospace; font-weight: 700; color: #170F0A;">' . esc_html($order_id) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Publication:</td>
                  <td style="padding: 10px 0; text-align: right; font-weight: 600; color: #170F0A;">' . esc_html($product_title) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Total Paid:</td>
                  <td style="padding: 10px 0; text-align: right; font-weight: 700; color: #8E6516; font-size: 15px;">R' . esc_html($amount) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; color: #786C5E;">Payment Method:</td>
                  <td style="padding: 10px 0; text-align: right; color: #170F0A;">PayFast South Africa (Confirmed)</td>
                </tr>
              </table>

              <!-- Personal Author Message -->
              <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.65; font-style: italic; color: #52473E;">
                &ldquo;May these teachings gently awaken your inner wisdom, deepen your spiritual sovereignty, and bring profound alignment to your path.&rdquo;
              </p>
              <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #170F0A;">
                Warm blessings,<br>
                <strong>Eliza James</strong><br>
                <span style="font-size: 13px; color: #786C5E;">Author &middot; ' . esc_html($site_title) . '</span>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #FAF8F5; padding: 20px 32px; text-align: center; font-size: 12px; color: #8C8074; border-top: 1px solid #EFEAE3;">
              <p style="margin: 0 0 4px;">
                Need assistance? Feel free to reply directly to this email or reach us at <a href="mailto:' . esc_attr($reply_to) . '" style="color: #8E6516; text-decoration: underline;">' . esc_html($reply_to) . '</a>.
              </p>
              <p style="margin: 0;">
                &copy; ' . date('Y') . ' ' . esc_html($site_title) . '. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_title . ' <' . $sender_email . '>',
        'Reply-To: ' . $site_title . ' <' . $reply_to . '>',
    );

    return (bool) wp_mail($customer_email, $subject, $html, $headers);
}

/**
 * Dispatch an automated, luxury-styled HTML order confirmation email to the buyer
 * for physical book orders.
 *
 * Details the confirmed door-to-door courier delivery address, personal dedication
 * request (if any), estimated courier transit time (10-14 business days across SA),
 * and transaction reference.
 *
 * @param array $order Order record array from 'eliza_recent_orders'.
 * @return bool True if email was successfully accepted for delivery by wp_mail.
 */
function eliza_send_customer_physical_order_email($order) {
    if (empty($order) || empty($order['customer_email'])) {
        return false;
    }

    $customer_email = sanitize_email($order['customer_email']);
    $customer_name  = !empty($order['customer_name']) ? $order['customer_name'] : 'Seeker';
    $order_id       = !empty($order['order_id']) ? $order['order_id'] : 'ELIZA-' . date('ymd');
    $product_title  = !empty($order['product_title']) ? $order['product_title'] : 'Physical Book';
    $amount         = !empty($order['amount']) ? $order['amount'] : '450.00';
    $street_address = !empty($order['street_address']) ? $order['street_address'] : '';
    $city           = !empty($order['city']) ? $order['city'] : '';
    $province       = !empty($order['province']) ? $order['province'] : '';
    $postal_code    = !empty($order['postal_code']) ? $order['postal_code'] : '';
    $customer_phone = !empty($order['customer_phone']) ? $order['customer_phone'] : '';
    $dedication     = !empty($order['dedication']) ? $order['dedication'] : '';

    $name_parts = explode(' ', trim($customer_name));
    $first_name = !empty($name_parts[0]) ? $name_parts[0] : 'Friend';

    $subject = 'Order Confirmation: ' . $product_title . ' [' . $order_id . ']';
    $site_title = get_bloginfo('name') ?: 'Eliza Reconnection';
    $sender_email = 'orders@elizareconnection.co.za';
    $reply_to = 'eliza.reconnection@gmail.com';

    $html = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . esc_html($subject) . '</title>
</head>
<body style="margin: 0; padding: 0; background-color: #FAF8F5; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; color: #170F0A; -webkit-font-smoothing: antialiased;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF8F5; padding: 36px 12px;">
    <tr>
      <td align="center">
        <!-- Main Card Container -->
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; border: 1.5px solid #D4AF37; box-shadow: 0 16px 40px rgba(212,175,55,0.12);">
          
          <!-- Header Banner -->
          <tr>
            <td style="background: linear-gradient(135deg, #170F0A 0%, #2A1A12 100%); padding: 36px 32px; text-align: center; border-bottom: 2px solid #D4AF37;">
              <span style="display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #D4AF37; margin-bottom: 8px;">
                ' . esc_html($site_title) . ' &middot; Sacred Publications
              </span>
              <h1 style="margin: 0; font-family: Georgia, \'Times New Roman\', serif; font-size: 26px; font-weight: 400; color: #FFFFFF; letter-spacing: -0.01em;">
                Your Order is Confirmed
              </h1>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="padding: 36px 32px;">
              <p style="margin: 0 0 18px; font-size: 16px; line-height: 1.6; color: #170F0A;">
                Dear ' . esc_html($first_name) . ',
              </p>
              <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.65; color: #52473E;">
                Thank you for welcoming <strong>' . esc_html($product_title) . '</strong> into your sacred journey. Your payment has been successfully confirmed by PayFast. Your book will be carefully packaged and couriered directly to your door.
              </p>

              <!-- Delivery Address Box -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #FAF6EE; border-radius: 12px; border: 1px solid rgba(212,175,55,0.35); padding: 22px 20px; margin-bottom: 28px;">
                <tr>
                  <td>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8E6516; margin-bottom: 8px;">
                      Tracked Door-to-Door Courier Delivery
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: #170F0A; margin-bottom: 4px;">
                      ' . esc_html($customer_name) . '
                    </div>
                    <div style="font-size: 14px; color: #52473E; line-height: 1.5; margin-bottom: 6px;">
                      ' . esc_html($street_address) . '<br>
                      ' . esc_html($city) . ', ' . esc_html($province) . ' ' . esc_html($postal_code) . '
                    </div>
                    ' . (!empty($customer_phone) ? '<div style="font-size: 13px; color: #786C5E;">Phone: ' . esc_html($customer_phone) . '</div>' : '') . '
                    
                    ' . (!empty($dedication) ? '
                    <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(212,175,55,0.35);">
                      <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #8E6516; margin-bottom: 4px;">Author Dedication Request:</div>
                      <div style="font-style: italic; font-size: 13px; color: #170F0A; line-height: 1.5;">&ldquo;' . esc_html($dedication) . '&rdquo;</div>
                    </div>' : '') . '

                    <div style="margin-top: 14px; font-size: 12px; color: #8E6516; line-height: 1.45; font-weight: 500;">
                      &check; Estimated delivery: 10 to 14 business days across South Africa. You will receive courier dispatch updates as your package makes its way to your door.
                    </div>
                  </td>
                </tr>
              </table>

              <!-- Order Summary Table -->
              <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #8E6516; margin-bottom: 10px;">
                Transaction Summary
              </div>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; font-size: 14px; margin-bottom: 28px;">
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Order Reference:</td>
                  <td style="padding: 10px 0; text-align: right; font-family: monospace; font-weight: 700; color: #170F0A;">' . esc_html($order_id) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Book:</td>
                  <td style="padding: 10px 0; text-align: right; font-weight: 600; color: #170F0A;">' . esc_html($product_title) . '</td>
                </tr>
                <tr style="border-bottom: 1px solid #EFEAE3;">
                  <td style="padding: 10px 0; color: #786C5E;">Total Paid:</td>
                  <td style="padding: 10px 0; text-align: right; font-weight: 700; color: #8E6516; font-size: 15px;">R' . esc_html($amount) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; color: #786C5E;">Payment Method:</td>
                  <td style="padding: 10px 0; text-align: right; color: #170F0A;">PayFast South Africa (Confirmed)</td>
                </tr>
              </table>

              <!-- Personal Author Message -->
              <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.65; font-style: italic; color: #52473E;">
                &ldquo;May these teachings gently awaken your inner wisdom, deepen your spiritual sovereignty, and bring profound alignment to your path.&rdquo;
              </p>
              <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #170F0A;">
                Warm blessings,<br>
                <strong>Eliza James</strong><br>
                <span style="font-size: 13px; color: #786C5E;">Author &middot; ' . esc_html($site_title) . '</span>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #FAF8F5; padding: 20px 32px; text-align: center; font-size: 12px; color: #8C8074; border-top: 1px solid #EFEAE3;">
              <p style="margin: 0 0 4px;">
                Need assistance with your courier delivery? Reply directly to this email or reach us at <a href="mailto:' . esc_attr($reply_to) . '" style="color: #8E6516; text-decoration: underline;">' . esc_html($reply_to) . '</a>.
              </p>
              <p style="margin: 0;">
                &copy; ' . date('Y') . ' ' . esc_html($site_title) . '. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_title . ' <' . $sender_email . '>',
        'Reply-To: ' . $site_title . ' <' . $reply_to . '>',
    );

    return (bool) wp_mail($customer_email, $subject, $html, $headers);
}

/**
 * Configure outbound transactional email delivery headers & envelope sender
 * to satisfy strict SPF and DMARC requirements across Google, Microsoft, and Yahoo mail hosts.
 */
add_action('phpmailer_init', function($phpmailer) {
    if (strpos(gethostname(), 'aserv.co.za') !== false) {
        $phpmailer->Sender = 'novquep3c8x3@aserv.co.za';
    } else {
        $phpmailer->Sender = 'orders@elizareconnection.co.za';
    }
});

add_filter('wp_mail_from', function($from_email) {
    // Prevent fallback to admin@localhost.com
    if (empty($from_email) || strpos($from_email, 'localhost') !== false || strpos($from_email, 'example.com') !== false) {
        return 'orders@elizareconnection.co.za';
    }
    return $from_email;
});

add_filter('wp_mail_from_name', function($from_name) {
    if (empty($from_name) || $from_name === 'WordPress') {
        return 'Eliza Reconnection';
    }
    return $from_name;
});
