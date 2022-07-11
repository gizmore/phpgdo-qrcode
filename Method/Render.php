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
 * @TODO Image render size does not seem to supported by this lib.
 * 
 * @see https://github.com/chillerlan/php-qrcode
 * 
 * @see \GDO\QRCode\GDT_QRCode
 * 
 * @author gizmore
 * 
 * @version 6.10
 * @since 6.10
 */
final class Render extends Method
{
	public function gdoParameters() : array
	{
		return array(
			GDT_QRCode::make('data')->notNull(),
			GDT_UInt::make('size')->initial('1024'),
		);
	}
	
	public function execute()
	{
		$data = $this->gdoParameterVar('data');
		$size = $this->gdoParameterVar('size');
		return $this->render($data, $size);
	}
	
	public function render($data, $size='1024')
	{
		$module = Module_QRCode::instance();
		
		$module->initQRCodeAutoloader();
		
		$options = new QROptions([
			'version' => 5,
			'outputType' => QRCode::OUTPUT_IMAGE_GIF,
			'eccLevel'=> QRCode::ECC_L,
			'imageTransparent' => false,
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
