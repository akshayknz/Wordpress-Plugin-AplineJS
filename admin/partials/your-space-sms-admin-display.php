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
wp_nonce_field( $this->plugin_name.'_scheduledsms_meta_box', $this->plugin_name.'_scheduledsmss_meta_box_nonce' );
$type = get_post_meta(get_the_ID(), $this->plugin_name.'-type', true );
$wooAction = get_post_meta(get_the_ID(), $this->plugin_name.'-woo-action', true );
$contactformItem = get_post_meta(get_the_ID(), $this->plugin_name.'-contactform-item', true );
$sendTo = get_post_meta(get_the_ID(), $this->plugin_name.'-send-to', true );
$agentPhone = get_post_meta(get_the_ID(), $this->plugin_name.'-agent-phone', true );
$smsBody = (get_post_meta(get_the_ID(), $this->plugin_name.'-sms-body', true ));
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<script>
    function booking() {
        return {
            //General vairables
            title: "",
            type: "<?= $type?$type:"";?>",
            sendTo: "<?= $sendTo?$sendTo:"user";?>",
            agentPhone: "<?= $agentPhone?$agentPhone:"";?>",
            smsBody: `<?= $smsBody?$smsBody:"";?>`,
            //Woocommerce variables
            wooAction: "<?= $wooAction?$wooAction:"";?>",
            //Contact form variables
            contactformItem: "<?= $contactformItem?$contactformItem:"";?>",
            init() { //construct
                this.$watch('type', () => {
                    this.makeTitle();
                    this.resetFields()
                })
                this.$watch('sendTo', () => this.makeTitle())
                this.$watch('title', value => {
                    document.querySelector('[name="post_title"]').value = value
                    document.querySelector('#title-prompt-text').classList.add('screen-reader-text')
                })
            },
            makeTitle() { //sets post title based on data
                this.title =
                    this.type.charAt(0).toUpperCase() + this.type.slice(1) + " - " +
                    this.sendTo.charAt(0).toUpperCase() + this.sendTo.slice(1) + " SMS";
            },
            resetFields() {
                this.agentPhone = ""
                this.sendTo = "user"
                this.wooAction = ""
                this.contactformItem = ""
                this.smsBody = ""
            }
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
                    <select name="<?= $this->plugin_name; ?>-type" id="type" x-model="type" class="postform" aria-describedby="type-description">
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
                    <select name="<?= $this->plugin_name; ?>-woo-action" id="woo-action" x-model="wooAction" class="postform">
                        <option value="">Please select</option>
                        <option value="woocommerce_payment_complete">Payment complete</option>
                        <option value="woocommerce_order_status_failed">Order failed</option>
                    </select>
                    <p class="description" id="slug-description">The event on which this SMS is send.</p>
                </td>
            </tr>
            <tr class="form-field term-slug-wrap" x-show="type==='contactform'">
                <th scope="row">
                    <label for="slug">Contact Form</label>
                </th>
                <td>
                    <select name="<?= $this->plugin_name; ?>-contactform-item" id="contactform-item" x-model="contactformItem" class="postform">
                        <option value="">Please select</option>
                        <?php
                        $dbValue = get_option('field-name');
                        $contactForms = get_posts(array(
                            'post_type'     => 'wpcf7_contact_form',
                            'numberposts'   => -1
                        ));
                        foreach ($contactForms as $p) {
                            echo '<option value="' . $p->ID . '"' . selected($p->ID, $dbValue, false) . '>' . $p->post_title . ' (' . $p->ID . ')</option>';
                        } ?>
                    </select>
                    <p class="description" id="slug-description">SMS will be sent on submission of this form.</p>
                </td>
            </tr>
            <tr class="form-field term-slug-wrap" x-show="wooAction||contactformItem">
                <th scope="row">
                    <label for="slug">Send to</label>
                </th>
                <td>
                    <select name="<?= $this->plugin_name; ?>-send-to" id="send-to" x-model="sendTo" class="postform">
                        <option value="user">User</option>
                        <option value="agent">Agent</option>
                    </select>
                    <p class="description" id="slug-description">The SMS can be sent to either the user or an agent.</p>
                </td>
            </tr>
            <tr class="form-field term-slug-wrap" x-show="(wooAction||contactformItem)&& sendTo&&sendTo=='agent'">
                <th scope="row">
                    <label for="slug">Agent Phone</label>
                </th>
                <td>
                    <input name="<?= $this->plugin_name; ?>-agent-phone" id="agent-phone" x-model="agentPhone" type="tel" size="40" aria-required="true" aria-describedby="name-description">
                    <p class="description" id="slug-description">This SMS will be sent to this phone number.</p>
                </td>
            </tr>
            <tr class="form-field term-slug-wrap" x-show="(wooAction||contactformItem)&& sendTo">
                <th scope="row">
                    <label for="slug">SMS Body</label>
                </th>
                <td>
                    <textarea name="<?= $this->plugin_name; ?>-sms-body" id="sms-body" cols="90" rows="4" x-model="smsBody" class="postform"></textarea>
                    <p class="description" id="slug-description">SMS character limit: <span x-text="`${smsBody.length}/160`"></span>. Use <code>%%</code> for variables. Example: <code>Hello %name%.</code></p>
                </td>
            </tr>
        </tbody>
    </table>
</span>