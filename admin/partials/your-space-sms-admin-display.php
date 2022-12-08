<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://akshaykn.vercel.app/
 * @since      1.0.0
 *
 * @package    Your_Space_Sms
 * @subpackage Your_Space_Sms/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<script>
    function booking() {
            return {
                type: 0, 
                wooAction: "",
                increment() { //increment a step
                },
            }
        }
</script>
<span x-data="booking()">
    <select name="type" id="type" x-model="type">
        <option value="">Please select</option>
        <option value="woocommerce">WooCommerce</option>
        <option value="contactform">Contact Form</option>
    </select>
    <div x-show="type==='woocommerce'">
        <select name="woo-action" id="woo-action" x-model="wooAction">
            <option value="">Please select</option>
            <option value="woocommerce_payment_complete">woocommerce_payment_complete</option>
            <option value="woocommerce_order_status_failed">woocommerce_order_status_failed</option>
        </select>
        <span x-text="wooAction"></span>
        <textarea name="sms-body" id="sms-body" cols="90" rows="4" x-show="wooAction">
        </textarea>
    </div>
    <div x-show="type==='contactform'">contactform</div>
</span>
