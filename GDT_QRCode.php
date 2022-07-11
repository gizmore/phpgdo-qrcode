<?php
namespace GDO\QRCode;

use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;

/**
 * A QR Code is a string that renders a qrcode as cell.
 * @author gizmore
 * @since 6.10
 * @version 6.10
 */
final class GDT_QRCode extends GDT_String
{
	public function defaultLabel() : self { return $this->label('qrcode'); }
	
	protected function __construct()
	{
		$this->utf8();
		$this->max(2048);
	}

	#########################
	### Widget image size ###
	#########################
	public $qrcodeSize = '128';
	public function qrcodeSize($size)
	{
		$this->qrcodeSize = $size;
		return $this;
	}

	##############
	### Render ###
	##############
	public function renderCell() : string
	{
		return GDT_Template::php('QRCode', 'cell/qrcode.php', ['field'=>$this]);
	}
	
	#############
	### HREFs ###
	#############
	public function hrefCode()
	{
		$args = '&data='.urlencode($this->getVar());
		$args .= '&size='.$this->qrcodeSize;
		return href('QRCode', 'Render', $args);
	}
	
	public function hrefCodeFullscreen()
	{
		$args = '&data='.urlencode($this->getVar());
		return href('QRCode', 'Render', $args);
	}
	
}
