<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\PackageCode;
use org\unece\uncefact\PackageName;
use PHPUnit\Framework\TestCase;

class PackageNameTest extends TestCase
{
    protected function setUp(): void
    {
        PackageCode::resetCaches();
        PackageName::resetCaches();
    }

    /* --------------------------------------------------------------------
       Basic one-way helpers
       ------------------------------------------------------------------ */

    public function testGetCode(): void
    {
        $this->assertSame(PackageCode::BAG , PackageName::getCode(PackageName::BAG));
    }

    public function testGetFromCode(): void
    {
        $this->assertSame(PackageName::BAG , PackageName::getFromCode(PackageCode::BAG));
    }

    /* --------------------------------------------------------------------
       Unknown lookups should return null
       ------------------------------------------------------------------ */

    public function testUnknownReturnsNull(): void
    {
        $this->assertNull(PackageName::getCode('Unknown-Package'));
        $this->assertNull(PackageName::getFromCode('ZZZ'));
    }

    /* --------------------------------------------------------------------
       Cache behaviour – second call must hit the cache
       ------------------------------------------------------------------ */

    public function testGetCodeUsesInternalCache(): void
    {
        $first  = PackageName::getCode(PackageName::BAG);
        $second = PackageName::getCode(PackageName::BAG);
        $this->assertSame($first , $second);
    }

    public function testResetCachesClearsTheCodeCache(): void
    {
        $this->assertSame(PackageCode::BAG , PackageName::getCode(PackageName::BAG));
        PackageName::resetCaches();
        $this->assertSame(PackageCode::BAG , PackageName::getCode(PackageName::BAG));
    }
}
