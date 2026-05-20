<?php
/**
 * Plugin Name: WooCommerce Inventory System
 * Plugin URI: https://example.com
 * Description: Simple WooCommerce inventory management system with frontend shortcode display.
 * Version: 2.1.1
 * Author: Your Name
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

                        <?php

                        function inventory_sort_link( $label, $column ) {

                            $current_order = isset( $_GET['order'] ) ? $_GET['order'] : 'ASC';

                            $new_order = $current_order === 'ASC' ? 'DESC' : 'ASC';

                            $url = add_query_arg(array(
                                'orderby' => $column,
                                'order'   => $new_order
                            ));

                            return '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
                        }

                        ?>

                        <th><?php echo inventory_sort_link( 'ID', 'ID' ); ?></th>
                        <th><?php echo inventory_sort_link( 'Product', 'title' ); ?></th>
                        <th><?php echo inventory_sort_link( 'SKU', 'sku' ); ?></th>
                        <th><?php echo inventory_sort_link( 'Price', 'price' ); ?></th>
                        <th><?php echo inventory_sort_link( 'Stock', 'stock_quantity' ); ?></th>
                        <th><?php echo inventory_sort_link( 'Status', 'stock_status' ); ?></th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>

                    <?php if ( ! empty( $products ) ) : ?>

                        <?php foreach ( $products as $product ) : ?>

                            <tr>

                                <td>
                                    <?php echo esc_html( $product->get_id() ); ?>
                                </td>

                                <td>
                                    <?php echo esc_html( $product->get_name() ); ?>
                                </td>

                                <td>
                                    <?php echo esc_html( $product->get_sku() ); ?>
                                </td>

                                <td>
                                    <?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?>
                                </td>

                                <td>

                                    <input
                                        type="number"
                                        class="inventory-stock"
                                        data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
                                        value="<?php echo esc_attr( $product->get_stock_quantity() ); ?>"
                                        min="0"
                                        style="width:80px;"
                                    >

                                </td>

                                <td class="stock-status-<?php echo esc_attr( $product->get_id() ); ?>">
                                    <?php echo esc_html( ucfirst( $product->get_stock_status() ) ); ?>
                                </td>

                                <td>

                                    <button
                                        class="button button-primary update-stock-btn"
                                        data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
                                    >
                                        Save
                                    </button>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>
                            <td colspan="7">No products found.</td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

            <?php

            $total_products = wc_get_products(array(
                'limit'  => -1,
                'return' => 'ids',
                'status' => 'publish'
            ));

            $total_pages = ceil( count( $total_products ) / $per_page );

            if ( $total_pages > 1 ) :

                echo '<div style="margin-top:20px;">';

                for ( $i = 1; $i <= $total_pages; $i++ ) {

                    $page_url = add_query_arg(array(
                        'paged_inventory' => $i
                    ));

                    if ( $i == $paged ) {

                        echo '<span style="margin-right:10px; font-weight:bold;">' . $i . '</span>';

                    } else {

                        echo '<a style="margin-right:10px;" href="' . esc_url( $page_url ) . '">' . $i . '</a>';
                    }
                }

                echo '</div>';

            endif;

            ?>

        </div>

        <script>
        jQuery(document).ready(function($){

            $('.update-stock-btn').on('click', function(){

                let button = $(this);
                let productID = button.data('product-id');

                let quantity = $('.inventory-stock[data-product-id="' + productID + '"]').val();

                button.text('Saving...');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'wc_update_stock',
                        product_id: productID,
                        quantity: quantity
                    },
                    success: function(response){

                        if(response.success){

                            $('.stock-status-' + productID).text(response.data.status);

                            button.text('Saved');

                        } else {

                            button.text('Error');
                        }

                        setTimeout(function(){
                            button.text('Save');
                        }, 1500);
                    },
                    error: function(){

                        button.text('Error');

                        setTimeout(function(){
                            button.text('Save');
                        }, 1500);
                    }
                });
            });
        });
        </script>

        <?php
    }

    /**
     * AJAX Update Stock
     */
    public function ajax_update_stock() {

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error();
        }

        $product_id = isset( $_POST['product_id'] )
            ? intval( $_POST['product_id'] )
            : 0;

        $quantity = isset( $_POST['quantity'] )
            ? intval( $_POST['quantity'] )
            : 0;

        $product = wc_get_product( $product_id );

        if ( ! $product ) {
            wp_send_json_error();
        }

        $product->set_manage_stock( true );
        $product->set_stock_quantity( $quantity );

        if ( $quantity > 0 ) {
            $product->set_stock_status( 'instock' );
            $status = 'Instock';
        } else {
            $product->set_stock_status( 'outofstock' );
            $status = 'Outofstock';
        }

        $product->save();

        wp_send_json_success(array(
            'status' => $status
        ));
    }

    /**
     * CSV Export Trigger
     */
    public function maybe_export_csv() {

        if (
            isset( $_GET['page'] ) &&
            $_GET['page'] === 'wc-inventory-system' &&
            isset( $_GET['export_csv'] )
        ) {
            $this->export_csv();
        }
    }

    /**
     * Export CSV
     */
    public function export_csv() {

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
        ));

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment; filename=inventory-export.csv' );

        $output = fopen( 'php://output', 'w' );

        fputcsv( $output, array(
            'ID',
            'Product',
            'SKU',
            'Price',
            'Stock Quantity',
            'Stock Status'
        ));

        foreach ( $products as $product ) {

            fputcsv( $output, array(
                $product->get_id(),
                $product->get_name(),
                $product->get_sku(),
                $product->get_price(),
                $product->get_stock_quantity(),
                $product->get_stock_status()
            ));
        }

        fclose( $output );
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
            margin-top: 20px;
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
                            <?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?>
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