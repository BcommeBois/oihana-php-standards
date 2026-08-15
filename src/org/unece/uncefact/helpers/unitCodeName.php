<?php

namespace org\unece\uncefact\helpers ;

use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\PackageCode;

/**
 * The official UN/CEFACT name of a unit code, whether that unit measures something or contains it.
 *
 * UN/CEFACT splits its vocabulary in two — codes that measure (`MTK` a square metre, `TNE` a tonne)
 * and codes that package (`BX` a box, `PA` a parcel). A unit read off an article belongs to one family or the other,
 * and the caller rarely knows which.
 *
 * ```php
 * unitCodeName( 'MTK' ) ; // 'Square Meter'
 * unitCodeName( 'BX'  ) ; // 'Box'
 * unitCodeName( 'ZZZ' ) ; // null
 * ```
 *
 * The lookup is case-sensitive : `unitCodeName( 'mtk' )` returns `null`.
 *
 * ⚠️ **The two families are flattened into a single name.** The returned string carries no trace of the
 * family it was resolved against, and that distinction is often the one that matters : a fee stated per
 * square metre can be brought down to an article billed by the square metre ; it cannot be brought down
 * to one billed by the box without knowing what the box holds. A caller that needs to tell a unit that
 * measures from a unit that merely holds must ask {@see MeasureCode::getName()} directly and read its
 * `null` as the signal — this helper is the wrong tool for that job.
 *
 * The measures are searched first, so a code claimed by both families would resolve to its
 * measure reading. **No such code exists today** : `PT` and `DB` used to collide, but only
 * because {@see MeasureCode} declared them wrongly — in Rec 20 `PT` is a pint and `DB` a dry
 * pound, never a Point nor a Decibel. Correcting the codes against the official dataset
 * removed the ambiguity rather than arbitrating it.
 *
 * @param string|null $code The UN/CEFACT unit code.
 *
 * @return string|null The official UN/CEFACT name, or `null` when the code is absent or belongs to neither family.
 *
 * @package org\unece\uncefact\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.1.0
 */
function unitCodeName( ?string $code ) :?string
{
    if( $code === null )
    {
        return null ;
    }

    return MeasureCode::getName( $code ) ?? PackageCode::getName( $code ) ;
}
