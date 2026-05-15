<?php
/**
 * Plugin Name: WooCommerce Inventory System
 * Plugin URI: https://reubenrosillo.free.nf/
 * Description: Simple WooCommerce inventory management system with frontend shortcode display.
 * Version: 1.0
 * Author: Reuben Rosillo
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Inventory_System {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
        add_shortcode( 'wc_inventory_table', array( $this, 'inventory_shortcode' ) );
        add_action( 'admin_post_update_inventory_stock', array( $this, 'update_inventory_stock' ) );
    }

    /**
     * Admin Menu
     */
    public function create_admin_menu() {
        add_menu_page(
            'Inventory System',
            'Inventory System',
            'manage_woocommerce',
            'wc-inventory-system',
            array( $this, 'inventory_admin_page' ),
            'dashicons-products',
            56
        );
    }

    /**
     * Admin Page
     */
    public function inventory_admin_page() {

        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="notice notice-error"><p>WooCommerce must be installed and activated.</p></div>';
            return;
        }

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
        ));

        ?>

        <div class="wrap">
            <h1>WooCommerce Inventory System</h1>

            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Update Stock</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ( $products as $product ) : ?>

                        <tr>
                            <td><?php echo esc_html( $product->get_id() ); ?></td>

                            <td>
                                <?php echo esc_html( $product->get_name() ); ?>
                            </td>

                            <td>
                                <?php echo esc_html( $product->get_sku() ); ?>
                            </td>

                            <td>
                                <?php echo wc_price( $product->get_price() ); ?>
                            </td>

                            <td>
                                <?php echo esc_html( $product->get_stock_quantity() ); ?>
                            </td>

                            <td>
                                <?php echo esc_html( ucfirst( $product->get_stock_status() ) ); ?>
                            </td>

                            <td>

                                <form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                                    <input type="hidden" name="action" value="update_inventory_stock">

                                    <input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ); ?>">

                                    <?php wp_nonce_field( 'update_stock_nonce', 'update_stock_nonce_field' ); ?>

                                    <input
                                        type="number"
                                        name="stock_quantity"
                                        value="<?php echo esc_attr( $product->get_stock_quantity() ); ?>"
                                        min="0"
                                        style="width:80px;"
                                    >

                                    <button class="button button-primary">
                                        Update
                                    </button>

                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <?php
    }

    /**
     * Update Stock
     */
    public function update_inventory_stock() {

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_die( 'Unauthorized user' );
        }

        if (
            ! isset( $_POST['update_stock_nonce_field'] ) ||
            ! wp_verify_nonce( $_POST['update_stock_nonce_field'], 'update_stock_nonce' )
        ) {
            wp_die( 'Nonce verification failed' );
        }

        $product_id = intval( $_POST['product_id'] );
        $stock_qty = intval( $_POST['stock_quantity'] );

        $product = wc_get_product( $product_id );

        if ( $product ) {
            $product->set_manage_stock( true );
            $product->set_stock_quantity( $stock_qty );

            if ( $stock_qty > 0 ) {
                $product->set_stock_status( 'instock' );
            } else {
                $product->set_stock_status( 'outofstock' );
            }

            $product->save();
        }

        wp_redirect( admin_url( 'admin.php?page=wc-inventory-system' ) );
        exit;
    }

    /**
     * Frontend Shortcode
     */
    public function inventory_shortcode() {

        if ( ! class_exists( 'WooCommerce' ) ) {
            return '<p>WooCommerce is required.</p>';
        }

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
        ));

        ob_start();

        ?>

        <style>
            .wc-inventory-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }

            .wc-inventory-table th,
            .wc-inventory-table td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }

            .wc-inventory-table th {
                background: #222;
                color: #fff;
            }

            .stock-in {
                color: green;
                font-weight: bold;
            }

            .stock-out {
                color: red;
                font-weight: bold;
            }
        </style>

        <table class="wc-inventory-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ( $products as $product ) : ?>

                    <tr>
                        <td>
                            <?php echo esc_html( $product->get_name() ); ?>
                        </td>

                        <td>
                            <?php echo esc_html( $product->get_sku() ); ?>
                        </td>

                        <td>
                            <?php echo wc_price( $product->get_price() ); ?>
                        </td>

                        <td>
                            <?php echo esc_html( $product->get_stock_quantity() ); ?>
                        </td>

                        <td>

                            <?php if ( $product->is_in_stock() ) : ?>

                                <span class="stock-in">In Stock</span>

                            <?php else : ?>

                                <span class="stock-out">Out of Stock</span>

                            <?php endif; ?>

                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

        <?php

        return ob_get_clean();
    }
}

new WC_Inventory_System();