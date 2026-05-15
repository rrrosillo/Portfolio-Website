<?php
/**
 * Plugin Name: WooCommerce Inventory System
 * Description: WooCommerce inventory management system with AJAX stock updates, search/filter, and CSV export.
 * Version: 2.0
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Inventory_System {

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );

        add_shortcode( 'wc_inventory_table', array( $this, 'inventory_shortcode' ) );

        add_action( 'wp_ajax_wc_update_stock', array( $this, 'ajax_update_stock' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
     * Scripts
     */
    public function enqueue_scripts() {

        wp_enqueue_script( 'jquery' );
    }

    /**
     * Admin Page
     */
    public function inventory_admin_page() {

        $search = isset( $_GET['inventory_search'] )
            ? sanitize_text_field( $_GET['inventory_search'] )
            : '';

        $args = array(
            'limit'  => -1,
            'status' => 'publish'
        );

        if ( ! empty( $search ) ) {
            $args['search'] = '*' . $search . '*';
        }

        $products = wc_get_products( $args );

        ?>

        <div class="wrap">

            <h1>WooCommerce Inventory System</h1>

            <form method="GET" style="margin-bottom:20px;">

                <input type="hidden" name="page" value="wc-inventory-system">

                <input
                    type="text"
                    name="inventory_search"
                    placeholder="Search products..."
                    value="<?php echo esc_attr( $search ); ?>"
                    style="width:300px;"
                >

                <button class="button">Search</button>

                <a
                    href="<?php echo esc_url( admin_url( 'admin.php?page=wc-inventory-system&export_csv=1' ) ); ?>"
                    class="button button-primary"
                >
                    Export CSV
                </a>

            </form>

            <table class="widefat striped">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Update</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ( $products as $product ) : ?>

                    <tr>
                        <td><?php echo $product->get_id(); ?></td>

                        <td><?php echo esc_html( $product->get_name() ); ?></td>

                        <td><?php echo esc_html( $product->get_sku() ); ?></td>

                        <td><?php echo wc_price( $product->get_price() ); ?></td>

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

                </tbody>

            </table>
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
                    data: {
                        action: 'wc_update_stock',
                        product_id: productID,
                        quantity: quantity
                    },
                    success: function(response){

                        button.text('Saved');

                        $('.stock-status-' + productID).text(response.data.status);

                        setTimeout(function(){
                            button.text('Save');
                        }, 1000);
                    }
                });
            });
        });
        </script>

        <?php

        if ( isset( $_GET['export_csv'] ) ) {
            $this->export_csv();
        }
    }

    /**
     * AJAX Stock Update
     */
    public function ajax_update_stock() {

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error();
        }

        $product_id = intval( $_POST['product_id'] );
        $quantity  = intval( $_POST['quantity'] );

        $product = wc_get_product( $product_id );

        if ( $product ) {

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

        wp_send_json_error();
    }

    /**
     * CSV Export
     */
    public function export_csv() {

        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment; filename="inventory-export.csv"' );

        $output = fopen( 'php://output', 'w' );

        fputcsv( $output, array(
            'ID',
            'Product',
            'SKU',
            'Price',
            'Stock',
            'Status'
        ));

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
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

        $products = wc_get_products(array(
            'limit' => -1,
            'status' => 'publish'
        ));

        ob_start();

        ?>

        <table class="wc-inventory-table" style="width:100%; border-collapse:collapse;">

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
                    <td><?php echo esc_html( $product->get_name() ); ?></td>
                    <td><?php echo esc_html( $product->get_sku() ); ?></td>
                    <td><?php echo wc_price( $product->get_price() ); ?></td>
                    <td><?php echo esc_html( $product->get_stock_quantity() ); ?></td>
                    <td><?php echo esc_html( ucfirst( $product->get_stock_status() ) ); ?></td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

        <?php

        return ob_get_clean();
    }
}

new WC_Inventory_System();