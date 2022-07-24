<?php
namespace GDO\QRCode;

use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;

/**
 * A QR Code is a string that renders a qrcode as cell.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.10.0
 */
final class GDT_QRCode extends GDT_String
{
	public function defaultLabel() : self { return $this->label('qrcode'); }
	
	protected function __construct()
	{
		parent::__construct();
		$this->utf8();
		$this->max(2048);
	}

	#########################
	### Widget image size ###
	#########################
	public int $qrcodeSize = 128;
	public function qrcodeSize(int $size) : self
	{
		$this->qrcodeSize = $size;
		return $this;
	}

	##############
	### Render ###
	##############
	public function renderHTML() : string
	{
		return GDT_Template::php('QRCode', 'qrcode_html.php', ['field'=>$this]);
	}
	
	#############
	### HREFs ###
	#############
	public function hrefCode() : string
	{
		$args = '&data='.urlencode($this->getVar());
		$args .= '&size='.$this->qrcodeSize;
		return href('QRCode', 'Render', $args);
	}
	
// 	public function hrefCodeFullscreen() : string
// 	{
// 		$args = '&data='.urlencode($this->getVar());
// 		return href('QRCode', 'Render', $args);
// 	}
	
}
