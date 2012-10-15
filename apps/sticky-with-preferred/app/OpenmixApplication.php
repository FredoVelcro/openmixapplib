<?php

/**
 * For information on writing Openmix applications, check out
 * https://github.com/cedexis/openmixapplib/wiki
 */
class OpenmixApplication implements Lifecycle
{
    
    /**
    * @var The list of available CNAMEs, keyed by alias.
    * penalty is a percentage. e.g. 10 = 10% slower (score * 1.1)
    */
    public $providers = array(
        'level3' => array('cname' => 'www.msnbc.msn.com.c.footprint.net', 'penalty' => 0),
        'akamai__vip' => array('cname' => 'assets.msnbc.msn.com.edgesuite.net', 'penalty' => 0),
        //'cdnetworks' => array('cname' => 'assets.msnbc.msn.com.cdngc.net', 'penalty' => 0)
    );
    
    private $ttl = 30;
    
    public $availabilityThreshold = 60;
    private $varianceThreshold = .65;
    
    /**
     * @var array An array mapping networks to preferred providers.  Note that market
     * and country codes must be UPPER CASE.  There's a memory limit here.  It's somewhere
     * around 450 keys.
     *
     * Example::
     *
     * $preferred = array(
     *    'NA-US-1234' => 'cotendo',
     *    'NA-US-2345' => 'bitgravity',
     *    'NA-US-3456' => 'akamai',
     * );
     */
    public $preferred = array(
        'NA-US-3923' => 'akamai__vip',
        'NA-US-14912' => 'level3',
        'NA-US-14676' => 'level3',
        'NA-US-22460' => 'level3',
        'NA-US-10455' => 'akamai__vip',
        'NA-US-16863' => 'akamai__vip',
        'NA-US-26478' => 'akamai__vip',
        'NA-US-35788' => 'akamai__vip',
        'NA-US-14985' => 'akamai__vip',
        'NA-US-26578' => 'level3',
        'NA-US-14989' => 'akamai__vip',
        'NA-US-26577' => 'akamai__vip',
        'NA-US-6966' => 'level3',
        'NA-US-32939' => 'akamai__vip',
        'NA-US-11911' => 'akamai__vip',
        'NA-US-14677' => 'level3',
        'NA-US-11915' => 'akamai__vip',
        'NA-US-3999' => 'akamai__vip',
        'NA-US-3851' => 'akamai__vip',
        'NA-US-18812' => 'level3',
        'NA-US-36105' => 'akamai__vip',
        'NA-US-33745' => 'level3',
        'NA-US-54040' => 'akamai__vip',
        'NA-US-29859' => 'akamai__vip',
        'NA-US-18779' => 'akamai__vip',
        'NA-US-2914' => 'level3',
        'NA-US-33647' => 'level3',
        'NA-US-714' => 'akamai__vip',
        'NA-US-40702' => 'level3',
        'NA-US-19271' => 'level3',
        'NA-US-7046' => 'akamai__vip',
        'NA-US-6157' => 'level3',
        'NA-US-26934' => 'level3',
        'NA-US-12064' => 'level3',
        'NA-US-14214' => 'level3',
        'NA-US-14188' => 'akamai__vip',
        'NA-US-10962' => 'akamai__vip',
        'NA-US-1706' => 'akamai__vip',
        'NA-US-1668' => 'akamai__vip',
        'NA-US-292' => 'akamai__vip',
        'NA-US-6295' => 'level3',
        'NA-US-291' => 'akamai__vip',
        'NA-US-3770' => 'akamai__vip',
        'NA-US-4323' => 'akamai__vip',
        'NA-US-3778' => 'akamai__vip',
        'NA-US-6983' => 'akamai__vip',
        'NA-US-14325' => 'level3',
        'NA-US-22717' => 'level3',
        'NA-US-2828' => 'akamai__vip',
        'NA-US-13429' => 'akamai__vip',
        'NA-US-3147' => 'akamai__vip',
        'NA-US-6389' => 'akamai__vip',
        'NA-US-14328' => 'akamai__vip',
        'NA-US-12015' => 'akamai__vip',
        'NA-US-11686' => 'akamai__vip',
        'NA-US-14751' => 'akamai__vip',
        'NA-US-3389' => 'akamai__vip',
        'NA-US-2381' => 'akamai__vip',
        'NA-US-17310' => 'level3',
        'NA-US-2386' => 'akamai__vip',
        'NA-US-3582' => 'level3',
        'NA-US-10337' => 'level3',
        'NA-US-46269' => 'level3',
        'NA-US-1239' => 'akamai__vip',
        'NA-US-109' => 'akamai__vip',
        'NA-US-6939' => 'akamai__vip',
        'NA-US-104' => 'akamai__vip',
        'NA-US-25973' => 'akamai__vip',
        'NA-US-13333' => 'akamai__vip',
        'NA-US-16810' => 'akamai__vip',
        'NA-US-6500' => 'akamai__vip',
        'NA-US-6075' => 'akamai__vip',
        'NA-US-12083' => 'akamai__vip',
        'NA-US-23148' => 'akamai__vip',
        'NA-US-1248' => 'akamai__vip',
        'NA-US-6079' => 'akamai__vip',
        'NA-US-21928' => 'akamai__vip',
        'NA-US-23326' => 'akamai__vip',
        'NA-US-32479' => 'akamai__vip',
        'NA-US-16718' => 'akamai__vip',
        'NA-US-3801' => 'akamai__vip',
        'NA-US-33470' => 'akamai__vip',
        'NA-US-23481' => 'akamai__vip',
        'NA-US-14477' => 'akamai__vip',
        'NA-US-7341' => 'akamai__vip',
        'NA-US-1906' => 'akamai__vip',
        'NA-US-20135' => 'level3',
        'NA-US-16928' => 'akamai__vip',
        'NA-US-21688' => 'akamai__vip',
        'NA-US-22302' => 'akamai__vip',
        'NA-US-19159' => 'akamai__vip',
        'NA-US-26878' => 'akamai__vip',
        'NA-US-22283' => 'akamai__vip',
        'NA-US-13645' => 'level3',
        'NA-US-20001' => 'akamai__vip',
        'NA-US-19406' => 'akamai__vip',
        'NA-US-10242' => 'akamai__vip',
        'NA-US-26282' => 'akamai__vip',
        'NA-US-27506' => 'level3',
        'NA-US-14710' => 'akamai__vip',
        'NA-US-13768' => 'level3',
        'NA-US-18687' => 'akamai__vip',
        'NA-US-1999' => 'level3',
        'NA-US-1998' => 'akamai__vip',
        'NA-US-11530' => 'akamai__vip',
        'NA-US-4179' => 'akamai__vip',
        'NA-US-19029' => 'level3',
        'NA-US-29968' => 'akamai__vip',
        'NA-US-36375' => 'akamai__vip',
        'NA-US-32808' => 'akamai__vip',
        'NA-US-557' => 'akamai__vip',
        'NA-US-16673' => 'akamai__vip',
        'NA-US-22759' => 'akamai__vip',
        'NA-US-16586' => 'akamai__vip',
        'NA-US-30193' => 'level3',
        'NA-US-131' => 'akamai__vip',
        'NA-US-237' => 'level3',
        'NA-US-31822' => 'level3',
        'NA-US-21899' => 'akamai__vip',
        'NA-US-6102' => 'level3',
        'NA-US-1696' => 'akamai__vip',
        'NA-US-10837' => 'level3',
        'NA-US-17227' => 'akamai__vip',
        'NA-US-27343' => 'akamai__vip',
        'NA-US-29761' => 'akamai__vip',
        'NA-US-1751' => 'akamai__vip',
        'NA-US-10933' => 'akamai__vip',
        'NA-US-1790' => 'akamai__vip',
        'NA-US-21976' => 'level3',
        'NA-US-23503' => 'level3',
        'NA-US-7829' => 'akamai__vip',
        'NA-US-26783' => 'akamai__vip',
        'NA-US-12282' => 'akamai__vip',
        'NA-US-11040' => 'level3',
        'NA-US-3701' => 'akamai__vip',
        'NA-US-13370' => 'akamai__vip',
        'NA-US-26891' => 'akamai__vip',
        'NA-US-13576' => 'akamai__vip',
        'NA-US-3112' => 'akamai__vip',
        'NA-US-40246' => 'akamai__vip',
        'NA-US-2538' => 'akamai__vip',
        'NA-US-11714' => 'level3',
        'NA-US-11650' => 'akamai__vip',
        'NA-US-17184' => 'akamai__vip',
        'NA-US-46375' => 'akamai__vip',
        'NA-US-2711' => 'akamai__vip',
        'NA-US-2714' => 'akamai__vip',
        'NA-US-127' => 'level3',
        'NA-US-11309' => 'akamai__vip',
        'NA-US-5078' => 'akamai__vip',
        'NA-US-17161' => 'level3',
        'NA-US-7381' => 'akamai__vip',
        'NA-US-10921' => 'level3',
        'NA-US-7385' => 'akamai__vip',
        'NA-US-10835' => 'level3',
        'NA-US-6478' => 'level3',
        'NA-US-3794' => 'akamai__vip',
        'NA-US-15048' => 'akamai__vip',
        'NA-US-29' => 'akamai__vip',
        'NA-US-4385' => 'level3',
        'NA-US-16966' => 'level3',
        'NA-US-4983' => 'level3',
        'NA-US-12175' => 'akamai__vip',
        'NA-US-2152' => 'akamai__vip',
        'NA-US-53813' => 'akamai__vip',
        'NA-US-8025' => 'level3',
        'NA-US-23118' => 'akamai__vip',
        'NA-US-12179' => 'level3',
        'NA-US-20452' => 'level3',
        'NA-US-23126' => 'level3',
        'NA-US-11834' => 'akamai__vip',
        'NA-US-18566' => 'level3',
        'NA-US-11272' => 'level3',
        'NA-US-3561' => 'akamai__vip',
        'NA-US-41095' => 'akamai__vip',
        'NA-US-4130' => 'level3',
        'NA-US-40511' => 'akamai__vip',
        'NA-US-53250' => 'level3',
        'NA-US-5691' => 'level3',
        'NA-US-32828' => 'level3',
        'NA-US-10599' => 'level3',
        'NA-US-2900' => 'akamai__vip',
        'NA-US-701' => 'akamai__vip',
        'NA-US-33544' => 'level3',
        'NA-US-20357' => 'akamai__vip',
        'NA-US-88' => 'level3',
        'NA-US-20426' => 'akamai__vip',
        'NA-US-14615' => 'akamai__vip',
        'NA-US-14203' => 'level3',
        'NA-US-81' => 'akamai__vip',
        'NA-US-87' => 'level3',
        'NA-US-797' => 'level3',
        'NA-US-30560' => 'akamai__vip',
        'NA-US-4046' => 'akamai__vip',
        'NA-US-174' => 'akamai__vip',
        'NA-US-793' => 'akamai__vip',
        'NA-US-4043' => 'akamai__vip',
        'NA-US-20057' => 'akamai__vip',
        'NA-US-14921' => 'akamai__vip',
        'NA-US-30110' => 'akamai__vip',
        'NA-US-40923' => 'level3',
        'NA-US-26496' => 'level3',
        'NA-US-27264' => 'level3',
        'NA-US-11286' => 'akamai__vip',
        'NA-US-299' => 'akamai__vip',
        'NA-US-17232' => 'akamai__vip',
        'NA-US-17231' => 'level3',
        'NA-US-243' => 'akamai__vip',
        'NA-US-13536' => 'level3',
        'NA-US-7784' => 'level3',
        'NA-US-15130' => 'akamai__vip',
        'NA-US-1348' => 'akamai__vip',
        'NA-US-4546' => 'akamai__vip',
        'NA-US-11757' => 'akamai__vip',
        'NA-US-6334' => 'akamai__vip',
        'NA-US-26146' => 'level3',
        'NA-US-12007' => 'akamai__vip',
        'NA-US-12005' => 'akamai__vip',
        'NA-US-13476' => 'akamai__vip',
        'NA-US-11596' => 'akamai__vip',
        'NA-US-2379' => 'akamai__vip',
        'NA-US-26223' => 'level3',
        'NA-US-16399' => 'level3',
        'NA-US-40285' => 'akamai__vip',
        'NA-US-3593' => 'akamai__vip',
        'NA-US-1226' => 'level3',
        'NA-US-21947' => 'level3',
        'NA-US-21528' => 'akamai__vip',
        'NA-US-8057' => 'akamai__vip',
        'NA-US-13977' => 'akamai__vip',
        'NA-US-4267' => 'akamai__vip',
        'NA-US-4181' => 'akamai__vip',
        'NA-US-1341' => 'akamai__vip',
        'NA-US-3598' => 'level3',
        'NA-US-4185' => 'akamai__vip',
        'NA-US-5661' => 'level3',
        'NA-US-4436' => 'akamai__vip',
        'NA-US-15003' => 'akamai__vip',
        'NA-US-13323' => 'akamai__vip',
        'NA-US-5668' => 'akamai__vip',
        'NA-US-13448' => 'akamai__vip',
        'NA-US-46303' => 'level3',
        'NA-US-186' => 'akamai__vip',
        'NA-US-12133' => 'akamai__vip',
        'NA-US-3081' => 'level3',
        'NA-US-23155' => 'akamai__vip',
        'NA-US-18' => 'akamai__vip',
        'NA-US-53347' => 'level3',
        'NA-US-11979' => 'level3',
        'NA-US-196' => 'akamai__vip',
        'NA-US-22637' => 'akamai__vip',
        'NA-US-11971' => 'akamai__vip',
        'NA-US-3527' => 'akamai__vip',
        'NA-US-17054' => 'level3',
        'NA-US-17055' => 'level3',
        'NA-US-22808' => 'akamai__vip',
        'NA-US-33165' => 'akamai__vip',
        'NA-US-12' => 'akamai__vip',
        'NA-US-36012' => 'level3',
        'NA-US-6367' => 'level3',
        'NA-US-19108' => 'akamai__vip',
        'NA-US-7774' => 'akamai__vip',
        'NA-US-2698' => 'akamai__vip',
        'NA-US-22442' => 'akamai__vip',
        'NA-US-16509' => 'akamai__vip',
        'NA-US-3909' => 'level3',
        'NA-US-27026' => 'level3',
        'NA-US-23102' => 'akamai__vip',
        'NA-US-6629' => 'akamai__vip',
        'NA-US-11486' => 'level3',
        'NA-US-26292' => 'akamai__vip',
        'NA-US-6621' => 'akamai__vip',
        'NA-US-1968' => 'akamai__vip',
        'NA-US-30404' => 'akamai__vip',
        'NA-US-11245' => 'akamai__vip',
        'NA-US-21547' => 'level3',
        'NA-US-16700' => 'level3',
        'NA-US-11039' => 'akamai__vip',
        'NA-US-30628' => 'akamai__vip',
        'NA-US-26794' => 'akamai__vip',
        'NA-US-217' => 'akamai__vip',
        'NA-US-40313' => 'akamai__vip',
        'NA-US-40315' => 'level3',
        'NA-US-18712' => 'level3',
        'NA-US-12042' => 'level3',
        'NA-US-3354' => 'akamai__vip',
        'NA-US-3356' => 'akamai__vip',
        'NA-US-73' => 'akamai__vip',
        'NA-US-72' => 'level3',
        'NA-US-7106' => 'level3',
        'NA-US-70' => 'akamai__vip',
        'NA-US-22742' => 'level3',
        'NA-US-11414' => 'level3',
        'NA-US-7068' => 'level3',
        'NA-US-7065' => 'akamai__vip',
        'NA-US-20069' => 'akamai__vip',
        'NA-US-11796' => 'akamai__vip',
        'NA-US-1761' => 'akamai__vip',
        'NA-US-1767' => 'level3',
        'NA-US-668' => 'level3',
        'NA-US-23047' => 'akamai__vip',
        'NA-US-1261' => 'level3',
        'NA-US-3495' => 'akamai__vip',
        'NA-US-32035' => 'akamai__vip',
        'NA-US-19957' => 'level3',
        'NA-US-19956' => 'akamai__vip',
        'NA-US-13407' => 'akamai__vip',
        'NA-US-19817' => 'akamai__vip',
        'NA-US-693' => 'level3',
        'NA-US-11663' => 'akamai__vip',
        'NA-US-14778' => 'level3',
        'NA-US-30337' => 'akamai__vip',
        'NA-US-4492' => 'level3',
        'NA-US-7395' => 'akamai__vip',
        'NA-US-2707' => 'akamai__vip',
        'NA-US-2701' => 'level3',
        'NA-US-125' => 'akamai__vip',
        'NA-US-22925' => 'akamai__vip',
        'NA-US-13926' => 'akamai__vip',
        'NA-US-32867' => 'akamai__vip',
        'NA-US-11025' => 'akamai__vip',
        'NA-US-6569' => 'akamai__vip',
        'NA-US-5742' => 'level3',
        'NA-US-10615' => 'level3',
        'NA-US-6315' => 'akamai__vip',
        'NA-US-13490' => 'akamai__vip',
        'NA-US-10753' => 'level3',
        'NA-US-7726' => 'akamai__vip',
        'NA-US-22561' => 'akamai__vip',
        'NA-US-22936' => 'akamai__vip',
        'NA-US-21737' => 'akamai__vip',
        'NA-US-10430' => 'level3',
        'NA-US-14051' => 'akamai__vip',
        'NA-US-22394' => 'level3',
        'NA-US-10437' => 'level3',
        'NA-US-21582' => 'akamai__vip',
        'NA-US-7246' => 'level3',
        'NA-US-26854' => 'akamai__vip',
        'NA-US-11788' => 'akamai__vip',
        'NA-US-3571' => 'akamai__vip',
        'NA-US-3479' => 'akamai__vip',
        'NA-US-26554' => 'akamai__vip',
        'NA-US-3' => 'level3',
        'NA-US-13385' => 'level3',
        'NA-US-36049' => 'level3',
        'NA-US-22244' => 'level3',
        'NA-US-18990' => 'akamai__vip',
        'NA-US-16657' => 'level3',
        'NA-US-22781' => 'level3',
        'NA-US-27' => 'akamai__vip',
        'NA-US-7029' => 'akamai__vip',
        'NA-US-14600' => 'akamai__vip',
        'NA-US-29737' => 'akamai__vip',
        'NA-US-30600' => 'akamai__vip',
        'NA-US-32251' => 'level3',
        'NA-US-22093' => 'level3',
        'NA-US-14288' => 'akamai__vip',
        'NA-US-3614' => 'akamai__vip',
        'NA-US-19855' => 'akamai__vip',
        'NA-US-63' => 'akamai__vip',
        'NA-US-7795' => 'level3',
        'NA-US-11745' => 'akamai__vip',
        'NA-US-6325' => 'akamai__vip',
        'NA-US-12035' => 'akamai__vip',
        'NA-US-7939' => 'level3',
        'NA-US-11892' => 'akamai__vip',
        'NA-US-29780' => 'akamai__vip',
        'NA-US-29933' => 'akamai__vip',
        'NA-US-11427' => 'akamai__vip',
        'NA-US-7925' => 'level3',
        'NA-US-8103' => 'akamai__vip',
        'NA-US-1215' => 'akamai__vip',
        'NA-US-1351' => 'level3',
        'NA-US-30008' => 'akamai__vip',
        'NA-US-160' => 'level3',
        'NA-US-161' => 'level3',
        'NA-US-5650' => 'akamai__vip',
        'NA-US-6356' => 'akamai__vip',
        'NA-US-25850' => 'akamai__vip',
        'NA-US-25996' => 'akamai__vip',
        'NA-US-14543' => 'akamai__vip',
        'NA-US-3685' => 'akamai__vip',
        'NA-US-35908' => 'akamai__vip',
        'NA-US-6197' => 'level3',
        'NA-US-6059' => 'akamai__vip',
        'NA-US-32' => 'level3',
        'NA-US-26046' => 'akamai__vip',
        'NA-US-8148' => 'level3',
        'NA-US-46687' => 'level3',
        'NA-US-21704' => 'level3',
        'NA-US-5056' => 'akamai__vip',
        'NA-US-22958' => 'akamai__vip',
        'NA-US-16904' => 'akamai__vip',
        'NA-US-15305' => 'level3',
        'NA-US-25921' => 'akamai__vip',
        'NA-US-6221' => 'level3',
        'NA-US-7772' => 'level3',
        'NA-US-9' => 'akamai__vip',
        'NA-US-15026' => 'level3',
        'NA-US-33339' => 'akamai__vip',
        'NA-US-18530' => 'akamai__vip',
        'NA-US-14901' => 'akamai__vip',
        'NA-US-11078' => 'level3',
        'NA-US-11550' => 'level3',
        'NA-US-11492' => 'level3',
        'NA-US-4152' => 'level3',
        'NA-US-7332' => 'akamai__vip',
        'NA-US-3549' => 'akamai__vip',
        'NA-US-1970' => 'akamai__vip',
        'NA-US-19009' => 'akamai__vip',
        'NA-US-11961' => 'akamai__vip',
        'NA-US-11847' => 'level3',
        'NA-US-22192' => 'level3',
        'NA-US-32703' => 'level3',
        'NA-US-15169' => 'akamai__vip',
        'NA-US-210' => 'akamai__vip',
        'NA-US-14340' => 'level3',
        'NA-US-15162' => 'akamai__vip',
        'NA-US-1785' => 'level3',
        'NA-US-6122' => 'akamai__vip',
        'NA-US-14265' => 'akamai__vip',
        'NA-US-26827' => 'level3',
        'NA-US-7054' => 'level3',
        'NA-US-25776' => 'akamai__vip',
        'NA-US-19648' => 'akamai__vip',
        'NA-US-21852' => 'level3',
        'NA-US-8147' => 'akamai__vip',
        'NA-US-4565' => 'akamai__vip',
        'NA-US-29992' => 'akamai__vip',
        'NA-US-17394' => 'level3',
        'NA-US-25899' => 'akamai__vip',
        'NA-US-2553' => 'akamai__vip',
        'NA-US-59' => 'akamai__vip',
        'NA-US-55' => 'level3',
        'NA-US-14464' => 'akamai__vip',
        'NA-US-52' => 'akamai__vip',
        'NA-US-6189' => 'level3',
        'NA-US-7896' => 'akamai__vip',
        'NA-US-46428' => 'akamai__vip',
        'NA-US-11773' => 'akamai__vip',
        'NA-US-1699' => 'akamai__vip',
        'NA-US-17025' => 'level3',
        'NA-US-46925' => 'akamai__vip',
        'NA-US-13855' => 'level3',
        'NA-US-8039' => 'level3',
        'NA-US-10794' => 'akamai__vip',
        'NA-US-111' => 'level3',
        'NA-US-6459' => 'level3',
        'NA-US-2496' => 'akamai__vip',
        'NA-US-27064' => 'akamai__vip',
        'NA-US-7973' => 'level3',
        'NA-US-6263' => 'akamai__vip',
        'NA-US-6510' => 'akamai__vip',
        'NA-US-25969' => 'akamai__vip',
        'NA-US-6517' => 'akamai__vip',
        'NA-US-1252' => 'akamai__vip',
        'NA-US-6307' => 'akamai__vip',
        'NA-US-14828' => 'level3',
        'NA-US-14041' => 'level3',
        'NA-US-11215' => 'akamai__vip',
        'NA-US-47018' => 'akamai__vip',
        'NA-US-23316' => 'akamai__vip',
        'NA-US-23314' => 'level3',
        'NA-US-3464' => 'akamai__vip',
        'NA-US-32287' => 'level3',
        'NA-US-11351' => 'akamai__vip',
        'NA-US-7377' => 'akamai__vip',
        'NA-US-22315' => 'akamai__vip',
        'NA-US-71' => 'level3',
        'NA-US-16527' => 'akamai__vip',
        'NA-US-16526' => 'akamai__vip',
        'NA-US-14381' => 'level3',
        'NA-US-16643' => 'akamai__vip',
        'NA-US-20231' => 'akamai__vip',
        'NA-US-23404' => 'level3',
        'NA-US-7017' => 'level3',
        'NA-US-7014' => 'akamai__vip',
        'NA-US-6167' => 'akamai__vip',
        'NA-US-13776' => 'akamai__vip',
        'NA-US-11509' => 'level3',
        'NA-US-13672' => 'akamai__vip',
        'NA-US-13778' => 'akamai__vip',
        'NA-US-40127' => 'akamai__vip',
        'NA-US-5723' => 'akamai__vip',
        'NA-US-19530' => 'akamai__vip',
        'NA-US-40375' => 'akamai__vip',
        'NA-US-16733' => 'akamai__vip',
        'NA-US-46887' => 'akamai__vip',
        'NA-US-17356' => 'level3',
        'NA-US-30641' => 'akamai__vip',
        'NA-US-12025' => 'level3',
        'NA-US-19902' => 'akamai__vip',
        'NA-US-226' => 'level3',
        'NA-US-225' => 'akamai__vip',
        'NA-US-22723' => 'akamai__vip',
        'NA-US-7086' => 'level3',
        'NA-US-29792' => 'akamai__vip',
        'NA-US-721' => 'level3',
        'NA-US-39939' => 'akamai__vip',
        'NA-US-1742' => 'akamai__vip',
        'NA-US-32748' => 'level3',
        'NA-US-7281' => 'akamai__vip',
        'NA-US-600' => 'akamai__vip',
        'NA-US-159' => 'akamai__vip',
        'NA-US-31939' => 'akamai__vip',
        'NA-US-8075' => 'akamai__vip',
        'NA-US-21782' => 'level3',
        'NA-US-26642' => 'akamai__vip',
        'NA-US-16983' => 'level3',
        'NA-US-11167' => 'level3',
        'NA-US-4922' => 'akamai__vip',
        'NA-US-12112' => 'level3',
        'NA-US-4201' => 'level3',
        'NA-US-49' => 'level3',
        'NA-US-46' => 'level3',
        'NA-US-47' => 'akamai__vip',
        'NA-US-11643' => 'level3',
        'NA-US-1294' => 'akamai__vip',
        'NA-US-10970' => 'level3',
        'NA-US-20141' => 'level3',
        'NA-US-13788' => 'akamai__vip',
        'NA-US-13789' => 'akamai__vip',
        'NA-US-2647' => 'level3',
        'NA-US-5049' => 'akamai__vip',
        'NA-US-11318' => 'level3',
        'NA-US-6461' => 'akamai__vip',
        'NA-US-4996' => 'akamai__vip',
        'NA-US-25932' => 'akamai__vip',
        'NA-US-4581' => 'level3',
        'NA-US-4583' => 'akamai__vip',
    );
    
    public $saved = array();
    
    public $reasons = array(
        'Data problem' => 'A',
        'Fastest provider' => 'B',
        'All providers below availability threshold' => 'C',
        'Preferred provider' => 'D',
        'Saved provider' => 'E',
    );
    
    /**
     * @param Configuration $config
     **/
    public function init($config)
    {
        // Copy preferred to saved
        $this->saved = $this->preferred;
        
        $config->declareInput(EDNSProperties::ENABLE);
        
        $config->declareInput(
            RadarProbeTypes::AVAILABILITY,
            implode(',', array_keys($this->providers)));
        
        $config->declareInput(
            RadarProbeTypes::HTTP_RTT,
            implode(',', array_keys($this->providers)));
        
        // need these to key into preferred provider mapping
        $config->declareInput(GeoProperties::MARKET);
        $config->declareInput(GeoProperties::COUNTRY);
        $config->declareInput(GeoProperties::ASN);
        $config->declareInput(EDNSProperties::MARKET);
        $config->declareInput(EDNSProperties::COUNTRY);
        $config->declareInput(EDNSProperties::ASN);
        
        foreach ($this->providers as $alias => $data) {
            $config->declareResponseOption($alias, $data['cname'], $this->ttl);
        }
        
        foreach ($this->reasons as $code) {
            $config->declareReasonCode($code);
        }
    }
    
    /**
     * @param Request $request
     * @param Response $response
     * @param Utilities $utilities
     **/
    public function service($request, $response, $utilities)
    {
        $key = $this->get_key($request);
        $candidates = $request->radar(RadarProbeTypes::HTTP_RTT);
        //print("\nRTT:\n" . print_r($candidates, true));
        
        if (!is_array($candidates)) {
            $utilities->selectRandom();
            $response->setReasonCode($this->reasons['Data problem']);
            return;
        }
        
        $candidates = array_intersect_key($candidates, $this->providers);
        //print("\nCandidates:\n" . print_r($candidates, true));
        
        if (empty($candidates)) {
            $utilities->selectRandom();
            $response->setReasonCode($this->reasons['Data problem']);
            return;
        }
        
        // Add penalties
        foreach ($candidates as $alias => $rtt) {
            $padding = 1 + floatval($this->providers[$alias]['penalty']) / 100;
            $candidates[$alias] *= $padding;
        }
        //print("\nCandidates after penalty:\n" . print_r($candidates, true));
        
        //print("\nAvailability threshold: " . $this->availabilityThreshold);
        $avail = $request->radar(RadarProbeTypes::AVAILABILITY);
        //print("\nAvail:\n" . print_r($avail, true));
        if (!is_array($avail)) {
            $utilities->selectRandom();
            $response->setReasonCode($this->reasons['Data problem']);
            return;
        }
        
        $avail = array_intersect_key($avail, $this->providers);
        if (empty($avail)) {
            $utilities->selectRandom();
            $response->setReasonCode($this->reasons['Data problem']);
            return;
        }
        
        $avail_filtered = array_filter($avail, array($this, 'filter_avail'));
        //print("\nAvail (filtered):\n" . print_r($avail_filtered, true));
        
        if (empty($avail_filtered)) {
            // No providers available. Select the most available.
            arsort($avail);
            $response->selectProvider(key($avail));
            $response->setReasonCode($this->reasons['All providers below availability threshold']);
            return;
        }
        
        $candidates = array_intersect_key($candidates, $avail_filtered);
        asort($candidates);
        //print("\nCandidates (filtered and sorted):\n" . print_r($candidates, true));
        $alias = key($candidates);
        //print("\nFastest: $alias, RTT: " . var_export($candidates[$alias], true));
        
        if (!array_key_exists($key, $this->preferred)) {
            // Not sticky. Do simple performance-based selection.
            $response->selectProvider($alias);
            $response->setReasonCode($this->reasons['Fastest provider']);
            return;
        }
        
        $saved_alias = null;
        if (array_key_exists($key, $this->saved)) {
            $saved_alias = $this->saved[$key];
        }
        
        if (array_key_exists($saved_alias, $candidates)) {
            $test_val = $this->varianceThreshold * $candidates[$saved_alias];
            //print("\nSaved: $saved_alias, RTT: " . var_export($test_val, true));
            if ($candidates[$alias] < $test_val) {
                $response->selectProvider($alias);
                $response->setReasonCode($this->reasons['Fastest provider']);
                $this->saved[$key] = $alias;
                return;
            }
            $response->selectProvider($saved_alias);
            $response->setReasonCode($this->reasons['Saved provider']);
            $this->saved[$key] = $saved_alias;
            return;
        }
        
        // Fall back to the preferred provider
        $preferred_alias = $this->preferred[$key];
        $test_val = $this->varianceThreshold * $candidates[$preferred_alias];
        //print("\nPreferred: $preferred_alias, RTT: " . var_export($test_val, true));
        
        if ($candidates[$alias] < $test_val) {
            $response->selectProvider($alias);
            $response->setReasonCode($this->reasons['Fastest provider']);
            $this->saved[$key] = $alias;
            return;
        }
        
        $response->selectProvider($preferred_alias);
        $response->setReasonCode($this->reasons['Preferred provider']);
        $this->saved[$key] = $preferred_alias;
    }
    
    public function get_key($request) {
        if ($request->geo(EDNSProperties::ENABLE)) {
            $market = $request->geo(EDNSProperties::MARKET);
            $country = $request->geo(EDNSProperties::COUNTRY);
            $asn = $request->geo(EDNSProperties::ASN);
        }
        else {
            $market = $request->geo(GeoProperties::MARKET);
            $country = $request->geo(GeoProperties::COUNTRY);
            $asn = $request->geo(GeoProperties::ASN);
        }
        return "$market-$country-$asn";
    }
    
    public function filter_avail($avail) {
        //print("\navail: $avail");
        if (is_numeric($avail)) {
            if ($avail >= $this->availabilityThreshold) {
                return true;
            }
        }
        return false;
    }
}

?>
