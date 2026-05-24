<?php

namespace tests\org\ietf\helpers;

use PHPUnit\Framework\TestCase;

use function org\ietf\helpers\isLocale;

/**
 * Unit tests for the isLocale validation function.
 *
 * @package tests\org\ietf\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class IsLocaleTest extends TestCase
{
    public function testValidLanguageOnly(): void
    {
        $this->assertTrue(isLocale('fr'));
        $this->assertTrue(isLocale('en'));
        $this->assertTrue(isLocale('und'));   // 3 letters
        $this->assertTrue(isLocale('FR'));    // case-insensitive
    }

    public function testValidLanguageRegion(): void
    {
        $this->assertTrue(isLocale('fr-FR'));
        $this->assertTrue(isLocale('en-US'));
        $this->assertTrue(isLocale('es-419')); // UN M49 region
    }

    public function testValidLanguageScriptRegion(): void
    {
        $this->assertTrue(isLocale('zh-Hant-TW'));
        $this->assertTrue(isLocale('sr-Cyrl-RS'));
    }

    public function testValidWithVariants(): void
    {
        $this->assertTrue(isLocale('de-CH-1996'));
        $this->assertTrue(isLocale('en-GB-oxendict'));
    }

    public function testValidWithPrivateUse(): void
    {
        $this->assertTrue(isLocale('en-x-pig-latin'));
        $this->assertTrue(isLocale('fr-FR-x-priv'));
    }

    public function testEmptyAndMalformed(): void
    {
        $this->assertFalse(isLocale(''));
        $this->assertFalse(isLocale('a'));         // 1 letter
        $this->assertFalse(isLocale('toolong'));   // 7 letters as language
        $this->assertFalse(isLocale('fr-'));       // trailing dash
        $this->assertFalse(isLocale('-fr'));       // leading dash
        $this->assertFalse(isLocale('fr-x'));      // x without private subtags
        $this->assertFalse(isLocale('fr-FRA'));    // 3-letter region (would be UN M49 → digits)
    }

    public function testStrictModeAcceptsRealCodes(): void
    {
        $this->assertTrue(isLocale('fr-FR', strict: true));
        $this->assertTrue(isLocale('en-US', strict: true));
        $this->assertTrue(isLocale('zh-Hant-TW', strict: true));
    }

    public function testStrictModeRejectsUnknownLanguage(): void
    {
        // 'zz' is syntactically valid but not in ISO 639-1
        $this->assertTrue(isLocale('zz-ZZ'));
        $this->assertFalse(isLocale('zz-ZZ', strict: true));
    }

    public function testStrictModeRejectsUnknownScript(): void
    {
        // 'Wxyz' is not a registered ISO 15924 script code
        $this->assertFalse(isLocale('en-Wxyz-US', strict: true));
    }

    public function testStrictModeRejectsUnknownRegion(): void
    {
        $this->assertFalse(isLocale('en-ZZ', strict: true));
    }

    public function testStrictSkipsThreeLetterLanguage(): void
    {
        // 'und' is 3 letters, no ISO 639-2 class available → skip cross-check
        $this->assertTrue(isLocale('und', strict: true));
    }

    public function testStrictAcceptsKnownNumericRegion(): void
    {
        // 3-digit region (UN M49) cross-validated against UNM49Numeric
        $this->assertTrue(isLocale('es-419', strict: true));   // Latin America and the Caribbean
        $this->assertTrue(isLocale('en-001', strict: true));   // World
        $this->assertTrue(isLocale('fr-150', strict: true));   // Europe
    }

    public function testStrictRejectsUnknownNumericRegion(): void
    {
        // 999 is syntactically valid but not assigned in UN M49
        $this->assertTrue(isLocale('es-999'));                 // tolerant: syntax OK
        $this->assertFalse(isLocale('es-999', strict: true));  // strict: unknown M49 code
    }
}
