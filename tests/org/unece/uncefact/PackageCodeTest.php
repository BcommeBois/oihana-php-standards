<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\PackageCode;
use org\unece\uncefact\PackageName;
use PHPUnit\Framework\TestCase;

class PackageCodeTest extends TestCase
{
    protected function setUp(): void
    {
        PackageCode::resetCaches();
        PackageName::resetCaches();
    }

    /* --------------------------------------------------------------------
       Basic one-way helpers
       ------------------------------------------------------------------ */

    public function testGetName(): void
    {
        $this->assertSame(PackageName::BAG , PackageCode::getName(PackageCode::BAG));
    }

    public function testGetFromName(): void
    {
        $this->assertSame(PackageCode::BAG , PackageCode::getFromName(PackageName::BAG));
    }

    /* --------------------------------------------------------------------
       Unknown lookups should return null
       ------------------------------------------------------------------ */

    public function testUnknownReturnsNull(): void
    {
        $this->assertNull(PackageCode::getName('ZZZ'));
        $this->assertNull(PackageCode::getFromName('Unknown-Package'));
    }

    /* --------------------------------------------------------------------
       Cache behaviour – second call must hit the cache
       ------------------------------------------------------------------ */

    public function testGetNameUsesInternalCache(): void
    {
        $first  = PackageCode::getName(PackageCode::BAG);
        $second = PackageCode::getName(PackageCode::BAG);
        $this->assertSame($first , $second);
    }

    public function testResetCachesClearsTheNameCache(): void
    {
        $this->assertSame(PackageName::BAG , PackageCode::getName(PackageCode::BAG));
        PackageCode::resetCaches();
        $this->assertSame(PackageName::BAG , PackageCode::getName(PackageCode::BAG));
    }
}
