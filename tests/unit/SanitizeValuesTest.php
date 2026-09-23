<?php
/**
 * @copyright Copyright (c) 2026, BW-Tech GmbH
 * @license AGPL-3.0
 */

namespace OCA\ConfigReport\Tests;

use OCA\ConfigReport\ReportDataCollector;
use OCP\IConfig;
use Test\TestCase;

/**
 * Geheimnisse müssen auch verschachtelt und in JSON-Zeichenketten aus dem
 * Bericht verschwinden; harmlose Schlüssel bleiben stehen.
 */
class SanitizeValuesTest extends TestCase {
	private function bereinige(array $werte): array {
		$sammler = (new \ReflectionClass(ReportDataCollector::class))->newInstanceWithoutConstructor();
		$feld = new \ReflectionProperty(ReportDataCollector::class, 'obscuredkeys');
		$feld->setAccessible(true);
		$feld->setValue($sammler, ['server_user']);
		$methode = new \ReflectionMethod(ReportDataCollector::class, 'sanitizeValues');
		$methode->setAccessible(true);
		return $methode->invoke($sammler, $werte);
	}

	public function testNestedSecretsAreRemoved(): void {
		$ergebnis = $this->bereinige([
			'redis.cluster' => ['seeds' => ['a:1', 'b:2'], 'password' => 'geheim1'],
			'objectstore_multibucket' => ['arguments' => ['credentials' => ['key' => 'k', 'secret' => 'geheim2'], 'bucket' => 'b']],
		]);
		self::assertSame(IConfig::SENSITIVE_VALUE, $ergebnis['redis.cluster']['password']);
		self::assertSame(['a:1', 'b:2'], $ergebnis['redis.cluster']['seeds']);
		self::assertSame(IConfig::SENSITIVE_VALUE, $ergebnis['objectstore_multibucket']['arguments']['credentials']);
		self::assertSame('b', $ergebnis['objectstore_multibucket']['arguments']['bucket']);
	}

	public function testSecretsInJsonStringsAreRemoved(): void {
		$ergebnis = $this->bereinige(['config' => '{"token":"geheim3","name":"n"}']);
		$dekodiert = \json_decode($ergebnis['config'], true);
		self::assertSame(IConfig::SENSITIVE_VALUE, $dekodiert['token']);
		self::assertSame('n', $dekodiert['name']);
	}

	public function testHarmlessKeysAndListsStay(): void {
		$werte = ['enabled' => 'yes', 'installed_version' => '1.0', 'types' => 'filesystem', 'keyTypeId' => 'x', 'liste' => ['a', 'b'], 'json-harmlos' => '{"name":"n"}'];
		self::assertSame($werte, $this->bereinige($werte));
	}

	public function testTopLevelSecretsAndObscuredKeys(): void {
		$ergebnis = $this->bereinige(['key' => 'bwmp_x', 'mail_smtppassword' => 'p', 'server_user' => 'u', 'api_key' => 'a']);
		foreach ($ergebnis as $wert) {
			self::assertSame(IConfig::SENSITIVE_VALUE, $wert);
		}
	}
}
