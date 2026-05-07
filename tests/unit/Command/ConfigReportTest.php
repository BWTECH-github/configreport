<?php
/**
 * Modified by BW-Tech GmbH for owncloud.online PHP 8.4 compatibility.
 */

namespace OCA\ConfigReport\Tests\Command;

use OCA\ConfigReport\Command\ConfigReport;
use OCA\ConfigReport\ReportDataCollector;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Test\TestCase;

class ConfigReportTest extends TestCase {
	public function testExecuteWritesRawJson(): void {
		$collector = $this->getMockBuilder(ReportDataCollector::class)
			->disableOriginalConstructor()
			->onlyMethods(['getReportJson'])
			->getMock();
		$collector->method('getReportJson')->willReturn('{"prompt":"\\\\b \\\\>"}');

		$command = new ConfigReport();
		$property = new \ReflectionProperty(ConfigReport::class, 'reportDataCollector');
		$property->setAccessible(true);
		$property->setValue($command, $collector);

		$output = new BufferedOutput(BufferedOutput::VERBOSITY_NORMAL, true);
		$method = new \ReflectionMethod(ConfigReport::class, 'execute');
		$method->setAccessible(true);
		$method->invoke($command, new ArrayInput([]), $output);

		self::assertSame("{\"prompt\":\"\\\\b \\\\>\"}\n", $output->fetch());
	}
}
