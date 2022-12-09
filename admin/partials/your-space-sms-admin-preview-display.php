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
<span x-data="{ open: false }" class="apline-preview">
  <template x-if="open">
    <p class="receive">
      <span x-html="accessApline.smsBody!=''?
      accessApline.smsBody.replaceAll('\n', '<br>').replaceAll('%name%', 'John')
      :'&nbsp;'">
      </span>
    </p>
  </template>
</span>

<script>
  let accessPreviewApline = Alpine.evaluate(document.querySelector('.apline-preview'), '$data');
  let accessApline;
  const intervalCheck = setInterval(() => {
    if (document.querySelector('.apline-main')) {
      accessApline = Alpine.evaluate(document.querySelector('.apline-main'), '$data');
      accessPreviewApline.open = true;
      clearInterval(intervalCheck);
    }
  }, 300)
</script>