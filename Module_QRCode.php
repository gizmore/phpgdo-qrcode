<?php
namespace GDO\QRCode;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Array;

/**
 * QRCode rendering module.
 *
 * @author gizmore
 * @version 7.0.1
 * @since 6.5.0
 */
final class Module_QRCode extends GDO_Module
{
	public string $license = 'MIT';

	public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/qrcode');
	}
	
	public function getLicenseFilenames(): array
	{
		return [
			'php-qrcode/LICENSE',
			'php-settings-container/LICENSE',
			'LICENSE',
		];
	}

	public function thirdPartyFolders(): array
	{
		return [
			'php-qrcode/',
			'php-settings-container/',
		];
	}

	# ####################################
	# ## Autoload PSR vendor emulation ###
	# ####################################
	public function initQRCodeAutoloader(): void
	{
		static $inited;
		if ( !isset($inited))
		{
			spl_autoload_register([
				$this,
				'autoload'
			]);
			$inited = true;
		}
	}

	public function autoload(string $className): void
	{
		$className = str_replace("\\", '/', $className);

		if (str_starts_with($className, 'chillerlan/QRCode'))
		{
			$path = str_replace('chillerlan/QRCode', $this->filePath('php-qrcode/src'), $className);
			$path .= '.php';
			require_once $path;
		}

		elseif (str_starts_with($className, 'chillerlan/Settings'))
		{
			$path = str_replace('chillerlan/Settings', $this->filePath('php-settings-container/src'), $className);
			$path .= '.php';
			require_once $path;
		}
	}

}
