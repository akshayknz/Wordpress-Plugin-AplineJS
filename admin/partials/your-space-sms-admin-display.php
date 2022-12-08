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
            sendTo: "",
            agentPhone: "",
            smsBody:"",
            increment() { //increment a step
            },
        }
    }
</script>


<span x-data="booking()" class="apline-main">
<table class="form-table" role="presentation">
  <tbody>
    <tr class="form-field form-required term-name-wrap">
      <th scope="row">
        <label for="name">Type</label>
      </th>
      <td>
        <select name="type" id="type" x-model="type" class="postform" aria-describedby="type-description">
            <option value="">Please select</option>
            <option value="woocommerce">WooCommerce</option>
            <option value="contactform">Contact Form</option>
        </select>
        <p class="description" id="type-description">The plugin/object this event is attached to.</p>
      </td>
    </tr>
    <tr class="form-field term-slug-wrap" x-show="type==='woocommerce'">
      <th scope="row">
        <label for="slug">Woocommerce Event</label>
      </th>
      <td>
        <select name="woo-action" id="woo-action" x-model="wooAction" class="postform">
            <option value="">Please select</option>
            <option value="woocommerce_payment_complete">woocommerce_payment_complete</option>
            <option value="woocommerce_order_status_failed">woocommerce_order_status_failed</option>
        </select>
        <p class="description" id="slug-description">The event on which this SMS is send.</p>
      </td>
    </tr>
    <tr class="form-field term-slug-wrap" x-show="wooAction">
      <th scope="row">
        <label for="slug">Send to</label>
      </th>
      <td>
        <select name="send-to" id="send-to" x-model="sendTo" class="postform">
            <option value="">Please select</option>
            <option value="user">User</option>
            <option value="agent">Agent</option>
        </select>
        <p class="description" id="slug-description">The SMS can be sent to either the user or an agent.</p>
      </td>
    </tr>
    <tr class="form-field term-slug-wrap" x-show="sendTo=='agent'">
      <th scope="row">
        <label for="slug">Agent Phone</label>
      </th>
      <td>
        <input name="agent-phone" id="agent-phone" x-model="agentPhone" type="tel" size="40" aria-required="true" aria-describedby="name-description">
        <p class="description" id="slug-description">This SMS will be sent to this phone number.</p>
      </td>
    </tr>
    <tr class="form-field term-slug-wrap" x-show="wooAction">
      <th scope="row">
        <label for="slug">SMS Body</label>
      </th>
      <td>
        <textarea name="sms-body" id="sms-body" cols="90" rows="4" x-show="wooAction" x-model="smsBody" class="postform"></textarea>
        <p class="description" id="slug-description">Use <code>%%</code> for variables. Example: <code>Hello %name%.</code></p>
      </td>
    </tr>
  </tbody>
</table>





    
    <div x-show="type==='woocommerce'">
       
        <span x-text="wooAction"></span>
    </div>
    <div x-show="type==='contactform'">contactform</div>
</span>