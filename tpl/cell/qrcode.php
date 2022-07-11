<?php
/** @var $field \GDO\QRCode\GDT_QRCode **/
?>
<div <?=$field->htmlID()?>
 title="<?=html($field->getVar())?>"
 class="gdt-qr-code">
  <a
   href="<?=$field->hrefCodeFullscreen()?>"
   target="_blank">
    <img 
     width="<?=$field->qrcodeSize?>"
     height="<?=$field->qrcodeSize?>"
     src="<?=$field->hrefCode()?>"
     alt="<?=t('qrcode')?>" />
  </a>
</div>
 