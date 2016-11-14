<?php

namespace Light\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Util\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * The composer ignore plugin.
 *
 * @author lichunqaing<light-li@hotmail.com>
 * @version 1.0.0
 * @license MIT
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
	/**
	 * @var Composer
	 */
	protected $composer;
	/**
	 * @var Config
	 */
	protected $config;
	/**
	 * @var Filesystem
	 */
	protected $fileSystem;
	
	/**
	 * @inheritdoc
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->composer = $composer;
		$this->config = $composer->getConfig();
		$this->fileSystem = new Filesystem();
	}
	
	/**
	 * @inheritdoc
	 */
	public static function getSubscribedEvents()
	{
		return [
			ScriptEvents::POST_AUTOLOAD_DUMP => 'onPostAutoloadDump',
		];
	}
	
	/**
	 * @param Event $event
	 */
	public function onPostAutoloadDump(Event $event)
	{
		/** @var Package $package */
		$package = $this->composer->getPackage();
		$extra = $package->getExtra();
		
		$ignoreList = isset($extra['light-ignore-plugin']) ? $extra['light-ignore-plugin'] : null;
		
		if (!$ignoreList) {
			return;
		}
		
		$vendor_dir = $this->config->get('vendor-dir');
		
		foreach ($ignoreList as $vendor => $files) {
			$root = $this->fileSystem->normalizePath("{$vendor_dir}/{$vendor}");
			$this->ignorePath($root, $files);
		}
	}
	
	/**
	 * @param string $root
	 * @param array  $files
	 */
	protected function ignorePath($root, array $files)
	{
		foreach ($files as $file) {
			$_file = $this->fileSystem->normalizePath("{$root}/{$file}");
			if (is_dir($_file)) {
				$this->fileSystem->removeDirectory($_file);
			} else {
				$finder = Finder::create()->in($root)->ignoreVCS(false)->name($file)->files();
				
				foreach ($finder as $item) {
					$this->fileSystem->remove($item->getRealPath());
				}
			}
		}
	}
}
