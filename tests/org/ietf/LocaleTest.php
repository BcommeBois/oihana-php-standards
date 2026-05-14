<?php

namespace tests\org\ietf;

use InvalidArgumentException;
use org\ietf\Locale;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Locale class.
 *
 * @package tests\org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class LocaleTest extends TestCase
{
    public function testDefaultConstructorIsUnd(): void
    {
        $l = new Locale();
        $this->assertSame('und', $l->tag);
        $this->assertSame('und', $l->language);
        $this->assertNull($l->script);
        $this->assertNull($l->region);
        $this->assertSame([], $l->variants);
        $this->assertNull($l->privateUse);
    }

    public function testLanguageRegion(): void
    {
        $l = new Locale('fr-FR');
        $this->assertSame('fr-FR', $l->tag);
        $this->assertSame('fr',    $l->language);
        $this->assertSame('FR',    $l->region);
        $this->assertNull($l->script);
    }

    public function testLanguageScriptRegion(): void
    {
        $l = new Locale('zh-Hant-TW');
        $this->assertSame('zh',   $l->language);
        $this->assertSame('Hant', $l->script);
        $this->assertSame('TW',   $l->region);
    }

    public function testCaseNormalization(): void
    {
        // language uppercase → lowercase ; script lowercase → Titlecase ; region lowercase → uppercase
        $l = new Locale('FR-latn-fr');
        $this->assertSame('fr',   $l->language);
        $this->assertSame('Latn', $l->script);
        $this->assertSame('FR',   $l->region);
        $this->assertSame('fr-Latn-FR', $l->tag); // canonical form
    }

    public function testVariants(): void
    {
        $l = new Locale('de-CH-1996');
        $this->assertSame('de', $l->language);
        $this->assertSame('CH', $l->region);
        $this->assertSame(['1996'], $l->variants);
    }

    public function testPrivateUse(): void
    {
        $l = new Locale('en-x-pig-latin');
        $this->assertSame('en', $l->language);
        $this->assertSame('x-pig-latin', $l->privateUse);
    }

    public function testNumericRegion(): void
    {
        // UN M49 region code
        $l = new Locale('es-419');
        $this->assertSame('es',  $l->language);
        $this->assertSame('419', $l->region);
    }

    public function testTagSetterUpdatesComponents(): void
    {
        $l = new Locale();
        $l->tag = 'ja-JP';
        $this->assertSame('ja', $l->language);
        $this->assertSame('JP', $l->region);
    }

    public function testToStringReturnsTag(): void
    {
        $l = new Locale('fr-FR');
        $this->assertSame('fr-FR', (string) $l);
    }

    public function testIsStrictReturnsTrueForRealCodes(): void
    {
        $this->assertTrue((new Locale('fr-FR'))->isStrict());
        $this->assertTrue((new Locale('zh-Hant-TW'))->isStrict());
    }

    public function testIsStrictReturnsFalseForFakeCodes(): void
    {
        $this->assertFalse((new Locale('zz-ZZ'))->isStrict());
    }

    public function testTolerantConstructorAcceptsUnknownCodes(): void
    {
        $l = new Locale('zz-ZZ');
        $this->assertSame('zz', $l->language);
        $this->assertSame('ZZ', $l->region);
        $this->assertFalse($l->isStrict());
    }

    public function testStrictConstructorRejectsUnknownCodes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('zz-ZZ', strict: true);
    }

    public function testStrictConstructorAcceptsRealCodes(): void
    {
        $l = new Locale('fr-FR', strict: true);
        $this->assertSame('fr-FR', $l->tag);
    }

    public function testInvalidTagThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('!!');
    }

    public function testEmptyTagThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('');
    }
}
