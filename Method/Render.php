<?php
namespace GDO\QRCode\Method;

use GDO\Core\Method;
use GDO\QRCode\GDT_QRCode;
use GDO\Core\GDT_UInt;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;
use GDO\QRCode\Module_QRCode;

/**
 * This method renders an arbitrary QR code.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.10.0
 * @see https://github.com/chillerlan/php-qrcode
 * @see \GDO\QRCode\GDT_QRCode
 */
final class Render extends Method
{
	public function getMethodTitle() : string
	{
		return t('qrcode');
	}
	
	public function gdoParameters() : array
	{
		return [
			GDT_QRCode::make('data')->notNull(),
			GDT_UInt::make('size')->initial('1024')->max(4096),
		];
	}
	
	public function execute()
	{
		$data = $this->gdoParameterVar('data');
		$size = $this->gdoParameterVar('size');
		return $this->render($data, $size);
	}
	
	public function render(string $data, int $size=1024)
	{
		$module = Module_QRCode::instance();
		
		$module->initQRCodeAutoloader();
		
		$options = new QROptions([
			'version' => 5,
			'outputType' => QRCode::OUTPUT_IMAGE_GIF,
			'eccLevel'=> QRCode::ECC_L,
			'imageTransparent' => false,
			'svgWidth' => $size,
			'svgHeight' => $size,
		]);
		
		// invoke a fresh QRCode instance
		$qrcode = new QRCode($options);
		
		$data = $qrcode->render($data); # to DATA;SRC string

		list(, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		
		header('Content-Type: image/gif');
		header('Content-Size: '.strlen($data));
		
		echo $data;

		die();
	}
	
}
