<?php
namespace GDO\QRCode;

use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;
use GDO\QRCode\Method\Render;

/**
 * A QR Code is a string that renders a qrcode as html and card.
 *
 * @TODO: GDT_QRCode: as table cell, a popup with the code is displayed?
 *
 * @version 7.0.1
 * @since 6.10.0
 * @author gizmore
 */
final class GDT_QRCode extends GDT_String
{

	public int $qrcodeSize = 128;

	protected function __construct()
	{
		parent::__construct();
		$this->ascii()->caseS();
		$this->icon = 'qrcode';
		$this->max(2048);
	}

	#########################
	### Widget image size ###
	#########################

	public function gdtDefaultLabel(): ?string
	{
		return 'qrcode';
	}

	public function renderHTML(): string
	{
		return GDT_Template::php('QRCode', 'qrcode_html.php', ['field' => $this]);
	}

	##############
	### Render ###
	##############

	public function qrcodeSize(int $size): self
	{
		$this->qrcodeSize = $size;
		return $this;
	}

	public function renderBase64()
	{
		return Render::renderBase64($this->getVar(), $this->qrcodeSize);
	}

	#############
	### HREFs ###
	#############
	public function hrefCode(): string
	{
		$args = '&data=' . urlencode($this->getVar());
		$args .= '&size=' . $this->qrcodeSize;
		return hrefNoSeo('QRCode', 'Render', $args);
	}

	public function hrefCodeFullscreen(): string
	{
		$args = '&data=' . urlencode($this->getVar());
		$args .= '&size=768';
		return hrefNoSeo('QRCode', 'Render', $args);
	}

}
