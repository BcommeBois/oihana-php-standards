<?php

namespace tests\org\iso;

use oihana\reflect\exceptions\ConstantException;
use org\iso\ISO3166_1;
use PHPUnit\Framework\TestCase;

class ISO3166_1Test extends TestCase
{
    protected function setUp(): void
    {
        ISO3166_1::resetCaches();
    }

    public function testIncludesValidAndInvalid(): void
    {
        $this->assertTrue(ISO3166_1::includes(ISO3166_1::FR));
        $this->assertTrue(ISO3166_1::includes(ISO3166_1::US));
        $this->assertFalse(ISO3166_1::includes('XX'));
        $this->assertFalse(ISO3166_1::includes(''));
    }

    public function testGetAllHasExpectedEntries(): void
    {
        $all = ISO3166_1::getAll();
        $this->assertIsArray($all);
        // Keys are constant names, values are their codes (same string)
        $this->assertArrayHasKey('FR', $all);
        $this->assertArrayHasKey('US', $all);
        $this->assertSame('FR', $all['FR']);
        $this->assertSame('US', $all['US']);
        // A couple more samples
        $this->assertArrayHasKey('DE', $all);
        $this->assertSame('DE', $all['DE']);
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all = ISO3166_1::getAll();
        $values = ISO3166_1::enums();

        $this->assertIsArray($values);
        // All enums should be unique values of getAll
        $this->assertSameSize(array_unique(array_values($all)), $values);
        // Sample presence
        $this->assertContains('FR', $values);
        $this->assertContains('US', $values);
        $this->assertContains('DE', $values);
    }

    public function testGetReturnsDefaultOnInvalid(): void
    {
        $this->assertSame('FR', ISO3166_1::get('FR', 'ZZ'));
        $this->assertSame('ZZ', ISO3166_1::get('XX', 'ZZ'));
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        // should not throw
        ISO3166_1::validate('FR');
        ISO3166_1::validate(ISO3166_1::US);

        $this->expectException(ConstantException::class);
        ISO3166_1::validate('XX');
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('FR', ISO3166_1::getConstant('FR'));
        $this->assertSame('US', ISO3166_1::getConstant('US'));
        $this->assertNull(ISO3166_1::getConstant('XX'));
    }
}
