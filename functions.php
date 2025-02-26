<?php
/**
 * Custom WooCommerce Subscriptions Template Modifications
 */

// Don't call this file directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Replace the default subscriptions template with custom output
 */
function custom_woocommerce_subscriptions_template() {
    // Only modify the main subscriptions endpoint (not single subscription views)
    if (isset($_GET['subscription_id']) || WC_Subscriptions::is_woocommerce_pre('2.6')) {
        return;
    }

    // Remove the default content
    remove_action('woocommerce_account_subscriptions_endpoint', array('WC_Subscriptions_Account', 'subscription_list'));
    
    // Add our custom content
    add_action('woocommerce_account_subscriptions_endpoint', 'custom_subscriptions_content');
}
add_action('init', 'custom_woocommerce_subscriptions_template');

/**
 * Output the custom subscriptions list
 */
function custom_subscriptions_content() {
    // Get the user's subscriptions
    $user_id = get_current_user_id();
    $subscriptions = wcs_get_users_subscriptions($user_id);
    
    // Start output
    echo '<div class="woocommerce_account_subscriptions">';
    
    if (!empty($subscriptions)) {
        echo '<table class="shop_table shop_table_responsive my_account_subscriptions my_account_orders">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="subscription-id order-number"><span class="nobr">' . esc_html__('Subscription', 'woocommerce-subscriptions') . '</span></th>';
        echo '<th class="subscription-status order-status"><span class="nobr">' . esc_html__('Status', 'woocommerce-subscriptions') . '</span></th>';
        echo '<th class="subscription-next-payment order-date"><span class="nobr">' . esc_html_x('Next Payment', 'table heading', 'woocommerce-subscriptions') . '</span></th>';
        echo '<th class="subscription-total order-total"><span class="nobr">' . esc_html_x('Total', 'table heading', 'woocommerce-subscriptions') . '</span></th>';
        echo '<th class="subscription-actions order-actions"></th>';
        echo '</tr>';
        echo '</thead>';
        
        echo '<tbody>';
        foreach ($subscriptions as $subscription_id => $subscription) {
            echo '<tr class="order">';
            
            // Subscription ID column
            echo '<td class="subscription-id order-number" data-title="' . esc_attr__('ID', 'woocommerce-subscriptions') . '">';
            echo '<a href="' . esc_url($subscription->get_view_order_url()) . '">' . esc_html(sprintf(_x('#%s', 'hash before order number', 'woocommerce-subscriptions'), $subscription->get_order_number())) . '</a>';
            do_action('woocommerce_my_subscriptions_after_subscription_id', $subscription);
            echo '</td>';
            
            // Status column
            echo '<td class="subscription-status order-status" data-title="' . esc_attr__('Status', 'woocommerce-subscriptions') . '">';
            echo esc_attr(wcs_get_subscription_status_name($subscription->get_status()));
            echo '</td>';
            
            // Next payment column
            echo '<td class="subscription-next-payment order-date" data-title="' . esc_attr_x('Next Payment', 'table heading', 'woocommerce-subscriptions') . '">';
            echo esc_attr($subscription->get_date_to_display('next_payment'));
            if (!$subscription->is_manual() && $subscription->has_status('active') && $subscription->get_time('next_payment') > 0) {
                $payment_method_to_display = sprintf(__('Via %s', 'woocommerce-subscriptions'), $subscription->get_payment_method_to_display());
                $payment_method_to_display = apply_filters('woocommerce_my_subscriptions_payment_method', $payment_method_to_display, $subscription);
                echo '<br/><small>' . esc_attr($payment_method_to_display) . '</small>';
            }
            echo '</td>';
            
            // Total column
            echo '<td class="subscription-total order-total" data-title="' . esc_attr_x('Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions') . '">';
            echo wp_kses_post($subscription->get_formatted_order_total());
            echo '</td>';
            
            // Actions column
            echo '<td class="subscription-actions order-actions">';
            echo '<a href="' . esc_url($subscription->get_view_order_url()) . '" class="button view">' . esc_html_x('View', 'view a subscription', 'woocommerce-subscriptions') . '</a>';
            do_action('woocommerce_my_subscriptions_actions', $subscription);
            echo '</td>';
            
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="no_subscriptions">';
        printf(
            esc_html__('You have no active subscriptions. Find your first subscription in the %sstore%s.', 'woocommerce-subscriptions'),
            '<a href="' . esc_url(apply_filters('woocommerce_subscriptions_message_store_url', get_permalink(wc_get_page_id('shop')))) . '">',
            '</a>'
        );
        echo '</p>';
    }
    
    echo '</div>';
}