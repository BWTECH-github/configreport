<?php
/**
 * Modified by BW-Tech GmbH for owncloud.online PHP 8.4 compatibility.
 */

namespace OCA\ConfigReport\AppInfo;

use OC\Helper\UserTypeHelper;
use OCA\ConfigReport\Controller\ReportController;
use OCA\ConfigReport\ReportDataCollector;
use \OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

/**
 * Class Application
 *
 * @package OCA\ConfigReport\AppInfo
 */
class Application extends App {
	/**
	 * Application constructor.
	 *
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams = []) {
		parent::__construct('configreport', $urlParams);
		$this->registerServices();
	}

	private function registerServices() {
		$container = $this->getContainer();

		$container->registerService('ReportDataCollector', function ($c) {
			return self::getCollector();
		});

		$container->registerService('ReportController', function (IAppContainer $c) {
			$server = $c->getServer();
			return new ReportController(
				$c->query('AppName'),
				$c->query('Request'),
				$server->getConfig(),
				$c->query('ReportDataCollector')
			);
		});
	}

	public static function getCollector(): ReportDataCollector {
		$statusInfo = \OCP\Util::getStatusInfo(true);
		$user = \OC::$server->getUserSession()->getUser();

		return new ReportDataCollector(
			\OC::$server->getIntegrityCodeChecker(),
			\OC::$server->getUserManager(),
			new UserTypeHelper(),
			\OC::$server->getGroupManager(),
			\OCP\Util::getVersion(),
			$statusInfo['versionstring'] ?? '',
			$statusInfo['edition'] ?? '',
			$user !== null ? $user->getDisplayName() : '',
			/* @phan-suppress-next-line PhanAccessMethodInternal */
			\OC::$server->getSystemConfig(),
			\OC::$server->getAppConfig(),
			\OC::$server->getDatabaseConnection(),
			\OC::$server->getGlobalStoragesService()
		);
	}
}
