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
      :'&nbsp;'"></span>
    </p>
  </template>
</span>
<script>
  let accessPreviewApline = Alpine.evaluate(document.querySelector('.apline-preview'), '$data');
  let accessApline;
  const intervalCheck = setInterval(()=>{
    if(document.querySelector('.apline-main')){
      accessApline = Alpine.evaluate(document.querySelector('.apline-main'), '$data');
      accessPreviewApline.open = true;
      clearInterval(intervalCheck);
    }
  },300)
</script>
<style>
  :root {
  --send-bg: #0B93F6;
  --send-color: white;
  --receive-bg: #E5E5EA;
  --receive-text: black;
  --page-background: white;
}
p.receive {
  max-width: 255px;
  word-wrap: break-word;
  margin-bottom: 12px;
  line-height: 24px;
  position: relative;
	padding: 10px 20px;
  border-radius: 25px;
  margin-left: 15px;
}
p.receive:before, p.receive:after {
    content: "";
		position: absolute;
    bottom: 0;
    height: 25px;
  }
.receive {
	background: var(--receive-bg);
	color: black;
  align-self: flex-start;
}
.receive:before {
		left: -7px;
    width: 20px;
    background-color: var(--receive-bg);
		border-bottom-right-radius: 16px 14px;
	}
.receive:after {
		left: -26px;
    width: 26px;
    background-color: var(--page-background);
		border-bottom-right-radius: 10px;
	}
</style>