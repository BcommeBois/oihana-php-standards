<?php

namespace org\ietf;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants for BCP 47 / RFC 5646 **variant** subtags as
 * registered in the IANA Language Subtag Registry.
 *
 * Variant subtags refine the language/script/region triple with notation,
 * orthography or dialect specifications: `1996` (post-reform German orthography),
 * `valencia` (Valencian Catalan), `fonipa` (IPA phonetic transcription),
 * `tarask` (Belarusian Taraškievica), `pinyin`, `wadegile`, etc.
 *
 * In a BCP 47 tag, variants appear after the language/script/region components:
 *   `de-CH-1996`     — Swiss German with 1996 orthography
 *   `ca-ES-valencia` — Catalan, Valencian variant, in Spain
 *   `sl-Latn-fonipa` — IPA transcription of Slovenian
 *
 * Naming convention:
 * - Alphabetic subtags → uppercase constant name (e.g. `VALENCIA = 'valencia'`).
 * - Numeric or digit-leading subtags → prefixed with `V_` because PHP
 *   identifiers cannot start with a digit (e.g. `V_1996 = '1996'`,
 *   `V_1606NICT = '1606nict'`).
 *
 * **Prefix constraints** (e.g. `valencia` requires `ca`) and **deprecation**
 * metadata are documented in the per-constant PHPDoc but **not enforced** by
 * this class. For full BCP 47 validation, see {@see \org\ietf\helpers\isLocale}.
 *
 * Example usage:
 *   BCP47Variant::V_1996;            // '1996'
 *   BCP47Variant::VALENCIA;          // 'valencia'
 *   BCP47Variant::FONIPA;            // 'fonipa'
 *   BCP47Variant::includes('1996');  // true
 *   BCP47Variant::includes('xyz');   // false
 *
 * @see \org\ietf\Locale
 * @see \org\ietf\BCP47Grandfathered Legacy grandfathered tags (full tags, not subtags)
 * @see \org\ietf\BCP47Redundant     Redundant registered tags
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry IANA registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5 RFC 5646 §2.2.5 — Variant Subtags
 *
 * @package org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class BCP47Variant
{
    use ConstantsTrait;

    /**
     * Late Middle French (to 1606). Prefix: `frm`.
     */
    public const string V_1606NICT = '1606nict';

    /**
     * Early Modern French. Prefix: `fr`.
     */
    public const string V_1694ACAD = '1694acad';

    /**
     * Traditional German orthography. Prefix: `de`.
     */
    public const string V_1901 = '1901';

    /**
     * "Academic" ("governmental") variant of Belarusian as codified in 1959. Prefix: `be`.
     */
    public const string V_1959ACAD = '1959acad';

    /**
     * Standardized Resian orthography. Prefix: `sl-rozaj, sl-rozaj-biske, sl-rozaj-njiva, sl-rozaj-osojs, sl-rozaj-solba`.
     */
    public const string V_1994 = '1994';

    /**
     * German orthography of 1996. Prefix: `de`.
     */
    public const string V_1996 = '1996';

    /**
     * Orthographic formulation of 1943 - Official in Brazil (Formulário Ortográfico de 1943 - Oficial no Brasil). Prefix: `pt-BR`.
     */
    public const string ABL1943 = 'abl1943';

    /**
     * Akhmimic dialect of Coptic. Prefix: `cop`.
     */
    public const string AKHMIMIC = 'akhmimic';

    /**
     * Akuapem Twi. Prefix: `tw`.
     */
    public const string AKUAPEM = 'akuapem';

    /**
     * ALA-LC Romanization, 1997 edition.
     */
    public const string ALALC97 = 'alalc97';

    /**
     * Aluku dialect / Boni dialect. Prefix: `djk`.
     */
    public const string ALUKU = 'aluku';

    /**
     * Anpezo standard of Ladin. Prefix: `lld`.
     */
    public const string ANPEZO = 'anpezo';

    /**
     * Portuguese Language Orthographic Agreement of 1990 (Acordo Ortográfico da Língua Portuguesa de 1990). Prefix: `pt, gl`.
     */
    public const string AO1990 = 'ao1990';

    /**
     * Aranese. Prefix: `oc`.
     */
    public const string ARANES = 'aranes';

    /**
     * Eastern Armenian. Prefix: `hy`. **Deprecated** since 2018-03-24.
     */
    public const string AREVELA = 'arevela';

    /**
     * Western Armenian. Prefix: `hy`. **Deprecated** since 2018-03-24.
     */
    public const string AREVMDA = 'arevmda';

    /**
     * Arcaicam Esperantom / Arkaika Esperanto. Prefix: `eo`.
     */
    public const string ARKAIKA = 'arkaika';

    /**
     * Asante Twi / Ashanti Twi. Prefix: `tw`.
     */
    public const string ASANTE = 'asante';

    /**
     * Auvergnat. Prefix: `oc`.
     */
    public const string AUVERN = 'auvern';

    /**
     * Unified Turkic Latin Alphabet (Historical). Prefix: `az, ba, crh, kk, krc, ky, sah, tk, tt, uz`.
     */
    public const string BAKU1926 = 'baku1926';

    /**
     * The Balanka dialect of Anii. Prefix: `blo`.
     */
    public const string BALANKA = 'balanka';

    /**
     * The Barlavento dialect group of Kabuverdianu. Prefix: `kea`.
     */
    public const string BARLA = 'barla';

    /**
     * Basic English. Prefix: `en`.
     */
    public const string BASICENG = 'basiceng';

    /**
     * Buddhist Hybrid Sanskrit. Prefix: `sa`.
     */
    public const string BAUDDHA = 'bauddha';

    /**
     * BCI Blissymbolics AV. Prefix: `zbl`.
     */
    public const string BCIAV = 'bciav';

    /**
     * BCI Blissymbolics. Prefix: `zbl`.
     */
    public const string BCIZBL = 'bcizbl';

    /**
     * Biscayan dialect of Basque. Prefix: `eu`.
     */
    public const string BISCAYAN = 'biscayan';

    /**
     * The San Giorgio dialect of Resian / The Bila dialect of Resian. Prefix: `sl-rozaj`.
     */
    public const string BISKE = 'biske';

    /**
     * Black American Sign Language dialect. Prefix: `ase, sgn-ase`.
     */
    public const string BLASL = 'blasl';

    /**
     * Bohairic dialect of Coptic. Prefix: `cop`.
     */
    public const string BOHAIRIC = 'bohairic';

    /**
     * Slovene in Bohorič alphabet. Prefix: `sl`.
     */
    public const string BOHORIC = 'bohoric';

    /**
     * Boontling. Prefix: `en`.
     */
    public const string BOONT = 'boont';

    /**
     * Bornholmsk. Prefix: `da`.
     */
    public const string BORNHOLM = 'bornholm';

    /**
     * Cisalpine. Prefix: `oc`.
     */
    public const string CISAUP = 'cisaup';

    /**
     * Portuguese-Brazilian Orthographic Convention of 1945 (Convenção Ortográfica Luso-Brasileira de 1945). Prefix: `pt`.
     */
    public const string COLB1945 = 'colb1945';

    /**
     * Cornu-English / Cornish English / Anglo-Cornish. Prefix: `en`.
     */
    public const string CORNU = 'cornu';

    /**
     * Occitan variants of the Croissant area. Prefix: `oc`.
     */
    public const string CREISS = 'creiss';

    /**
     * Slovene in Dajnko alphabet. Prefix: `sl`.
     */
    public const string DAJNKO = 'dajnko';

    /**
     * Serbian with Ekavian pronunciation. Prefix: `sr, sr-Latn, sr-Cyrl`.
     */
    public const string EKAVSK = 'ekavsk';

    /**
     * Early Modern English (1500-1700). Prefix: `en`.
     */
    public const string EMODENG = 'emodeng';

    /**
     * Fascia standard of Ladin. Prefix: `lld`.
     */
    public const string FASCIA = 'fascia';

    /**
     * Fayyumic dialect of Coptic. Prefix: `cop`.
     */
    public const string FAYYUMIC = 'fayyumic';

    /**
     * Fodom standard of Ladin. Prefix: `lld`.
     */
    public const string FODOM = 'fodom';

    /**
     * International Phonetic Alphabet.
     */
    public const string FONIPA = 'fonipa';

    /**
     * Kirshenbaum Phonetic Alphabet.
     */
    public const string FONKIRSH = 'fonkirsh';

    /**
     * North American Phonetic Alphabet / Americanist Phonetic Notation.
     */
    public const string FONNAPA = 'fonnapa';

    /**
     * Uralic Phonetic Alphabet.
     */
    public const string FONUPA = 'fonupa';

    /**
     * X-SAMPA transcription.
     */
    public const string FONXSAMP = 'fonxsamp';

    /**
     * Gallo. Prefix: `fr`.
     */
    public const string GALLO = 'gallo';

    /**
     * Gascon. Prefix: `oc`.
     */
    public const string GASCON = 'gascon';

    /**
     * Gherdëina standard of Ladin. Prefix: `lld`.
     */
    public const string GHERD = 'gherd';

    /**
     * Classical Occitan orthography. Prefix: `oc, oc-aranes, oc-auvern, oc-cisaup, oc-creiss, oc-gascon, oc-lemosin, oc-lengadoc, oc-nicard, oc-provenc, oc-vivaraup`.
     */
    public const string GRCLASS = 'grclass';

    /**
     * Italian-inspired Occitan orthography. Prefix: `oc, oc-cisaup, oc-nicard, oc-provenc`.
     */
    public const string GRITAL = 'grital';

    /**
     * Mistralian or Mistralian-inspired Occitan orthography. Prefix: `oc, oc-aranes, oc-auvern, oc-cisaup, oc-creiss, oc-gascon, oc-lemosin, oc-lengadoc, oc-nicard, oc-provenc, oc-vivaraup`.
     */
    public const string GRMISTR = 'grmistr';

    /**
     * The Hà Nội variant of Vietnamese. Prefix: `vi`.
     */
    public const string HANOI = 'hanoi';

    /**
     * Hepburn romanization. Prefix: `ja-Latn`.
     */
    public const string HEPBURN = 'hepburn';

    /**
     * Hepburn romanization, Library of Congress method. Prefix: `ja-Latn-hepburn`. **Deprecated** since 2010-02-07.
     */
    public const string HEPLOC = 'heploc';

    /**
     * Norwegian in Høgnorsk (High Norwegian) orthography. Prefix: `nn`.
     */
    public const string HOGNORSK = 'hognorsk';

    /**
     * Standard H-system orthographic fallback for spelling Esperanto. Prefix: `eo`.
     */
    public const string HSISTEMO = 'hsistemo';

    /**
     * The Huế (province Thừa Thiên) variant of Vietnamese. Prefix: `vi`.
     */
    public const string HUETT = 'huett';

    /**
     * Serbian with Ijekavian pronunciation. Prefix: `sr, sr-Latn, sr-Cyrl`.
     */
    public const string IJEKAVSK = 'ijekavsk';

    /**
     * Epic Sanskrit. Prefix: `sa`.
     */
    public const string ITIHASA = 'itihasa';

    /**
     * Bulgarian in 1899 orthography. Prefix: `bg`.
     */
    public const string IVANCHOV = 'ivanchov';

    /**
     * Jauer dialect of Romansh. Prefix: `rm`.
     */
    public const string JAUER = 'jauer';

    /**
     * Jyutping Cantonese Romanization. Prefix: `yue`.
     */
    public const string JYUTPING = 'jyutping';

    /**
     * Common Cornish orthography of Revived Cornish. Prefix: `kw`.
     */
    public const string KKCOR = 'kkcor';

    /**
     * Kleinschmidt orthography / Allattaasitaamut. Prefix: `kl, kl-tunumiit`.
     */
    public const string KLEINSCH = 'kleinsch';

    /**
     * The Kociewie dialect of Polish. Prefix: `pl`.
     */
    public const string KOCIEWIE = 'kociewie';

    /**
     * Standard Cornish orthography of Revived Cornish / Kernowek Standard. Prefix: `kw`.
     */
    public const string KSCOR = 'kscor';

    /**
     * Classical Sanskrit. Prefix: `sa`. **Deprecated** since 2024-06-08.
     */
    public const string LAUKIKA = 'laukika';

    /**
     * Ancient Egyptian in Leiden Unified Transliteration. Prefix: `egy`.
     */
    public const string LEIDENTR = 'leidentr';

    /**
     * Limousin. Prefix: `oc`.
     */
    public const string LEMOSIN = 'lemosin';

    /**
     * Languedocien. Prefix: `oc`.
     */
    public const string LENGADOC = 'lengadoc';

    /**
     * The Lipovaz dialect of Resian / The Lipovec dialect of Resian. Prefix: `sl-rozaj`.
     */
    public const string LIPAW = 'lipaw';

    /**
     * The Latgalian language orthography codified in 1929. Prefix: `ltg`.
     */
    public const string LTG1929 = 'ltg1929';

    /**
     * The Latgalian language orthography codified in the language law in 2007. Prefix: `ltg`.
     */
    public const string LTG2007 = 'ltg2007';

    /**
     * Post-1917 Russian orthography. Prefix: `ru`.
     */
    public const string LUNA1918 = 'luna1918';

    /**
     * Lycopolitan alias Subakhmimic dialect of Coptic. Prefix: `cop`.
     */
    public const string LYCOPOL = 'lycopol';

    /**
     * Ancient Egyptian hieroglyphs encoded in Manuel de Codage. Prefix: `egy`.
     */
    public const string MDCEGYP = 'mdcegyp';

    /**
     * Ancient Egyptian transliteration encoded in Manuel de Codage. Prefix: `egy`.
     */
    public const string MDCTRANS = 'mdctrans';

    /**
     * Mesokemic alias Oxyrhynchite dialect of Coptic. Prefix: `cop`.
     */
    public const string MESOKEM = 'mesokem';

    /**
     * Slovene in Metelko alphabet. Prefix: `sl`.
     */
    public const string METELKO = 'metelko';

    /**
     * The moderate (conservative, i.e. Danish-like) spelling variant of Bokmål. Prefix: `nb`.
     */
    public const string MODERAT = 'moderat';

    /**
     * Monotonic Greek. Prefix: `el`.
     */
    public const string MONOTON = 'monoton';

    /**
     * Ndyuka dialect / Aukan dialect. Prefix: `djk`.
     */
    public const string NDYUKA = 'ndyuka';

    /**
     * Natisone dialect / Nadiza dialect. Prefix: `sl`.
     */
    public const string NEDIS = 'nedis';

    /**
     * Newfoundland English. Prefix: `en-CA`.
     */
    public const string NEWFOUND = 'newfound';

    /**
     * Niçard. Prefix: `oc`.
     */
    public const string NICARD = 'nicard';

    /**
     * The Gniva dialect of Resian / The Njiva dialect of Resian. Prefix: `sl-rozaj`.
     */
    public const string NJIVA = 'njiva';

    /**
     * Volapük nulik / Volapük perevidöl / Volapük nulädik / de Jong's Volapük / New Volapük / Revised Volapük / Modern Volapük. Prefix: `vo`.
     */
    public const string NULIK = 'nulik';

    /**
     * The Oseacco dialect of Resian / The Osojane dialect of Resian. Prefix: `sl-rozaj`.
     */
    public const string OSOJS = 'osojs';

    /**
     * Oxford English Dictionary spelling. Prefix: `en`.
     */
    public const string OXENDICT = 'oxendict';

    /**
     * Pahawh Hmong Second Stage Reduced orthography. Prefix: `mww, hnj`.
     */
    public const string PAHAWH2 = 'pahawh2';

    /**
     * Pahawh Hmong Third Stage Reduced orthography. Prefix: `mww, hnj`.
     */
    public const string PAHAWH3 = 'pahawh3';

    /**
     * Pahawh Hmong Final Version orthography. Prefix: `mww, hnj`.
     */
    public const string PAHAWH4 = 'pahawh4';

    /**
     * Pamaka dialect. Prefix: `djk`.
     */
    public const string PAMAKA = 'pamaka';

    /**
     * Latino Sine Flexione / Interlingua de API / Interlingua de Peano. Prefix: `la`.
     */
    public const string PEANO = 'peano';

    /**
     * Hokkien Vernacular Romanization System / Pe̍h-ōe-jī orthography/romanization. Prefix: `nan-Latn`.
     */
    public const string PEHOEJI = 'pehoeji';

    /**
     * Petrine orthography. Prefix: `ru`.
     */
    public const string PETR1708 = 'petr1708';

    /**
     * Pinyin romanization. Prefix: `zh-Latn, bo-Latn`.
     */
    public const string PINYIN = 'pinyin';

    /**
     * Polytonic Greek. Prefix: `el`.
     */
    public const string POLYTON = 'polyton';

    /**
     * Provençal. Prefix: `oc`.
     */
    public const string PROVENC = 'provenc';

    /**
     * Puter idiom of Romansh. Prefix: `rm`.
     */
    public const string PUTER = 'puter';

    /**
     * Radical (i.e. Nynorsk-like) spelling variant of Bokmål. Prefix: `nb`.
     */
    public const string RADIKALT = 'radikalt';

    /**
     * Volapük rigik / Schleyer's Volapük / Original Volapük / Classic Volapük. Prefix: `vo`.
     */
    public const string RIGIK = 'rigik';

    /**
     * Resian / Resianic / Rezijan. Prefix: `sl`.
     */
    public const string ROZAJ = 'rozaj';

    /**
     * Rumantsch Grischun. Prefix: `rm`.
     */
    public const string RUMGR = 'rumgr';

    /**
     * Sahidic dialect of Coptic. Prefix: `cop`.
     */
    public const string SAHIDIC = 'sahidic';

    /**
     * The Sài Gòn variant of Vietnamese. Prefix: `vi`.
     */
    public const string SAIGON = 'saigon';

    /**
     * Scottish Standard English. Prefix: `en`.
     */
    public const string SCOTLAND = 'scotland';

    /**
     * Scouse. Prefix: `en`.
     */
    public const string SCOUSE = 'scouse';

    /**
     * Simplified form.
     */
    public const string SIMPLE = 'simple';

    /**
     * Sorbian dialect of Schleife. Prefix: `dsb`.
     */
    public const string SLEPE = 'slepe';

    /**
     * The Stolvizza dialect of Resian / The Solbica dialect of Resian. Prefix: `sl-rozaj`.
     */
    public const string SOLBA = 'solba';

    /**
     * The Sotavento dialect group of Kabuverdianu. Prefix: `kea`.
     */
    public const string SOTAV = 'sotav';

    /**
     * Spanglish. Prefix: `en, es`.
     */
    public const string SPANGLIS = 'spanglis';

    /**
     * The "Stadin slangi" dialect of Finnish. Prefix: `fi`.
     */
    public const string STADI = 'stadi';

    /**
     * Surmiran idiom of Romansh. Prefix: `rm`.
     */
    public const string SURMIRAN = 'surmiran';

    /**
     * Sursilvan idiom of Romansh. Prefix: `rm`.
     */
    public const string SURSILV = 'sursilv';

    /**
     * Sutsilvan idiom of Romansh. Prefix: `rm`.
     */
    public const string SUTSILV = 'sutsilv';

    /**
     * Synnejysk / South Jutish. Prefix: `da`.
     */
    public const string SYNNEJYL = 'synnejyl';

    /**
     * Tagalog-English code-switching. Prefix: `en, tl, fil`.
     */
    public const string TAGLISH = 'taglish';

    /**
     * Taiwanese Hokkien Romanization System for Hokkien languages / Tâi-lô orthography/romanization. Prefix: `nan-Latn`.
     */
    public const string TAILO = 'tailo';

    /**
     * Belarusian in Taraskievica orthography. Prefix: `be`.
     */
    public const string TARASK = 'tarask';

    /**
     * Tongyong Pinyin romanization. Prefix: `zh-Latn`.
     */
    public const string TONGYONG = 'tongyong';

    /**
     * Tunumiisiut / East Greenlandic / Østgrønlandsk. Prefix: `kl`.
     */
    public const string TUNUMIIT = 'tunumiit';

    /**
     * Unified Cornish orthography of Revived Cornish. Prefix: `kw`.
     */
    public const string UCCOR = 'uccor';

    /**
     * Unified Cornish Revised orthography of Revived Cornish. Prefix: `kw`.
     */
    public const string UCRCOR = 'ucrcor';

    /**
     * Ulster dialect of Scots. Prefix: `sco`.
     */
    public const string ULSTER = 'ulster';

    /**
     * Unifon phonetic alphabet. Prefix: `en, hup, kyh, tol, yur`.
     */
    public const string UNIFON = 'unifon';

    /**
     * Vedic Sanskrit. Prefix: `sa`. **Deprecated** since 2024-06-08.
     */
    public const string VAIDIKA = 'vaidika';

    /**
     * Val Badia standard of Ladin. Prefix: `lld`.
     */
    public const string VALBADIA = 'valbadia';

    /**
     * Valencian. Prefix: `ca`.
     */
    public const string VALENCIA = 'valencia';

    /**
     * Vallader idiom of Romansh. Prefix: `rm`.
     */
    public const string VALLADER = 'vallader';

    /**
     * Latvian orthography used before 1920s ("vecā druka"). Prefix: `lv`.
     */
    public const string VECDRUKA = 'vecdruka';

    /**
     * The Viennese dialect of German. Prefix: `de`.
     */
    public const string VIENNESE = 'viennese';

    /**
     * Vivaro-Alpine. Prefix: `oc`.
     */
    public const string VIVARAUP = 'vivaraup';

    /**
     * Wade-Giles romanization. Prefix: `zh-Latn`.
     */
    public const string WADEGILE = 'wadegile';

    /**
     * Standard X-system orthographic fallback for spelling Esperanto. Prefix: `eo`.
     */
    public const string XSISTEMO = 'xsistemo';
}
