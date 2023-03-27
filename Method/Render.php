<?php
namespace GDO\QRCode\Method;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use GDO\Core\Application;
use GDO\Core\GDT;
use GDO\Core\GDT_UInt;
use GDO\Core\Method;
use GDO\QRCode\GDT_QRCode;
use GDO\QRCode\Module_QRCode;

/**
 * This method renders an arbitrary QR code.
 *
 * @version 7.0.1
 * @since 6.10.0
 * @author gizmore
 * @see https://github.com/chillerlan/php-qrcode
 * @see GDT_QRCode
 */
final class Render extends Method
{

	public function getMethodTitle(): string
	{
		return t('qrcode');
	}

	public function gdoParameters(): array
	{
		return [
			GDT_QRCode::make('data')->notNull(),
			GDT_UInt::make('size')->initial('1024')->max(4096),
		];
	}

	public function execute(): GDT
	{
		$data = $this->gdoParameterVar('data');
		$size = $this->gdoParameterVar('size');
		return $this->render($data, $size);
	}

	public function render(string $data, int $size = 1024)
	{
		$data = self::renderBase64($data, $size);

		$data = base64_decode($data);

		hdr('Content-Type: image/gif');
		hdr('Content-Size: ' . strlen($data));

		if (!Application::instance()->isUnitTests())
		{
			echo $data;
			die(0);
		}
	}

	public static function renderBase64(string $data, int $size = 1024): string
	{
		$module = Module_QRCode::instance();

		$module->initQRCodeAutoloader();

		$options = new QROptions([
// 			'version' => 5,
			'outputType' => QRCode::OUTPUT_IMAGE_GIF,
			'eccLevel' => QRCode::ECC_L,
			'imageTransparent' => false,
			'svgWidth' => $size,
			'svgHeight' => $size,
		]);

		// invoke a fresh QRCode instance
		$qrcode = new QRCode($options);

		$data = $qrcode->render($data); # to DATA;SRC string

		[, $data] = explode(';', $data);
		[, $data] = explode(',', $data);
		return $data;
	}

}
