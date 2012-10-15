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
        'cdnetworks' => array('cname' => 'assets.msnbc.msn.com.cdngc.net', 'penalty' => 0)
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
     *    'NA-US-1234' => array( 'provider' => 'cotendo' ),
     *    'NA-US-2345' => array( 'provider' => 'bitgravity' ),
     *    'NA-US-3456' => array( 'provider' => 'akamai' ),
     * );
     */
    public $preferred = array(
        /*
        'NA-US-3923' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14912' => array( 'provider' => 'level3' ),
        'NA-US-14676' => array( 'provider' => 'level3' ),
        'NA-US-22460' => array( 'provider' => 'level3' ),
        'NA-US-10455' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16863' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26478' => array( 'provider' => 'cdnetworks' ),
        'NA-US-35788' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14985' => array( 'provider' => 'akamai__vip' ),
        'NA-US-26578' => array( 'provider' => 'level3' ),
        'NA-US-14989' => array( 'provider' => 'akamai__vip' ),
        'NA-US-26577' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6966' => array( 'provider' => 'level3' ),
        'NA-US-32939' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11911' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14677' => array( 'provider' => 'level3' ),
        'NA-US-11915' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3999' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3851' => array( 'provider' => 'cdnetworks' ),
        'NA-US-18812' => array( 'provider' => 'level3' ),
        'NA-US-36105' => array( 'provider' => 'cdnetworks' ),
        'NA-US-33745' => array( 'provider' => 'level3' ),
        'NA-US-54040' => array( 'provider' => 'akamai__vip' ),
        'NA-US-29859' => array( 'provider' => 'akamai__vip' ),
        'NA-US-18779' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2914' => array( 'provider' => 'level3' ),
        'NA-US-33647' => array( 'provider' => 'level3' ),
        'NA-US-714' => array( 'provider' => 'cdnetworks' ),
        'NA-US-40702' => array( 'provider' => 'level3' ),
        'NA-US-19271' => array( 'provider' => 'level3' ),
        'NA-US-7046' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6157' => array( 'provider' => 'level3' ),
        'NA-US-26934' => array( 'provider' => 'level3' ),
        'NA-US-12064' => array( 'provider' => 'level3' ),
        'NA-US-14214' => array( 'provider' => 'level3' ),
        'NA-US-14188' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10962' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1706' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1668' => array( 'provider' => 'akamai__vip' ),
        'NA-US-292' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6295' => array( 'provider' => 'level3' ),
        'NA-US-291' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3770' => array( 'provider' => 'cdnetworks' ),
        'NA-US-4323' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3778' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6983' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14325' => array( 'provider' => 'level3' ),
        'NA-US-22717' => array( 'provider' => 'level3' ),
        'NA-US-2828' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13429' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3147' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6389' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14328' => array( 'provider' => 'cdnetworks' ),
        'NA-US-12015' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11686' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14751' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3389' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2381' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17310' => array( 'provider' => 'level3' ),
        'NA-US-2386' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3582' => array( 'provider' => 'level3' ),
        'NA-US-10337' => array( 'provider' => 'level3' ),
        'NA-US-46269' => array( 'provider' => 'level3' ),
        'NA-US-1239' => array( 'provider' => 'akamai__vip' ),
        'NA-US-109' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6939' => array( 'provider' => 'akamai__vip' ),
        'NA-US-104' => array( 'provider' => 'cdnetworks' ),
        'NA-US-25973' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13333' => array( 'provider' => 'cdnetworks' ),
        'NA-US-16810' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6500' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6075' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12083' => array( 'provider' => 'akamai__vip' ),
        'NA-US-23148' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1248' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6079' => array( 'provider' => 'akamai__vip' ),
        'NA-US-21928' => array( 'provider' => 'akamai__vip' ),
        'NA-US-23326' => array( 'provider' => 'cdnetworks' ),
        'NA-US-32479' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16718' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3801' => array( 'provider' => 'cdnetworks' ),
        'NA-US-33470' => array( 'provider' => 'akamai__vip' ),
        'NA-US-23481' => array( 'provider' => 'cdnetworks' ),
        'NA-US-14477' => array( 'provider' => 'akamai__vip' ),
        'NA-US-7341' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1906' => array( 'provider' => 'akamai__vip' ),
        'NA-US-20135' => array( 'provider' => 'level3' ),
        'NA-US-16928' => array( 'provider' => 'akamai__vip' ),
        'NA-US-21688' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22302' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19159' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26878' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22283' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13645' => array( 'provider' => 'level3' ),
        'NA-US-20001' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19406' => array( 'provider' => 'akamai__vip' ),
        'NA-US-10242' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26282' => array( 'provider' => 'akamai__vip' ),
        'NA-US-27506' => array( 'provider' => 'level3' ),
        'NA-US-14710' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13768' => array( 'provider' => 'level3' ),
        'NA-US-18687' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1999' => array( 'provider' => 'level3' ),
        'NA-US-1998' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11530' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4179' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19029' => array( 'provider' => 'level3' ),
        'NA-US-29968' => array( 'provider' => 'akamai__vip' ),
        'NA-US-36375' => array( 'provider' => 'cdnetworks' ),
        'NA-US-32808' => array( 'provider' => 'cdnetworks' ),
        'NA-US-557' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16673' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22759' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16586' => array( 'provider' => 'akamai__vip' ),
        'NA-US-30193' => array( 'provider' => 'level3' ),
        'NA-US-131' => array( 'provider' => 'akamai__vip' ),
        'NA-US-237' => array( 'provider' => 'level3' ),
        'NA-US-31822' => array( 'provider' => 'level3' ),
        'NA-US-21899' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6102' => array( 'provider' => 'level3' ),
        'NA-US-1696' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10837' => array( 'provider' => 'level3' ),
        'NA-US-17227' => array( 'provider' => 'akamai__vip' ),
        'NA-US-27343' => array( 'provider' => 'cdnetworks' ),
        'NA-US-29761' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1751' => array( 'provider' => 'akamai__vip' ),
        'NA-US-10933' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1790' => array( 'provider' => 'cdnetworks' ),
        'NA-US-21976' => array( 'provider' => 'level3' ),
        'NA-US-23503' => array( 'provider' => 'level3' ),
        'NA-US-7829' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26783' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12282' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11040' => array( 'provider' => 'level3' ),
        'NA-US-3701' => array( 'provider' => 'cdnetworks' ),
        */
        'NA-US-13370' => array( 'provider' => 'akamai__vip' ),
        'NA-US-26891' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13576' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3112' => array( 'provider' => 'cdnetworks' ),
        'NA-US-40246' => array( 'provider' => 'akamai__vip' ),
        'NA-US-2538' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11714' => array( 'provider' => 'level3' ),
        'NA-US-11650' => array( 'provider' => 'cdnetworks' ),
        'NA-US-17184' => array( 'provider' => 'akamai__vip' ),
        'NA-US-46375' => array( 'provider' => 'akamai__vip' ),
        'NA-US-2711' => array( 'provider' => 'akamai__vip' ),
        'NA-US-2714' => array( 'provider' => 'akamai__vip' ),
        'NA-US-127' => array( 'provider' => 'level3' ),
        'NA-US-11309' => array( 'provider' => 'akamai__vip' ),
        'NA-US-5078' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17161' => array( 'provider' => 'level3' ),
        'NA-US-7381' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10921' => array( 'provider' => 'level3' ),
        'NA-US-7385' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10835' => array( 'provider' => 'level3' ),
        'NA-US-6478' => array( 'provider' => 'level3' ),
        'NA-US-3794' => array( 'provider' => 'cdnetworks' ),
        'NA-US-15048' => array( 'provider' => 'akamai__vip' ),
        'NA-US-29' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4385' => array( 'provider' => 'level3' ),
        'NA-US-16966' => array( 'provider' => 'level3' ),
        'NA-US-4983' => array( 'provider' => 'level3' ),
        'NA-US-12175' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2152' => array( 'provider' => 'akamai__vip' ),
        'NA-US-53813' => array( 'provider' => 'akamai__vip' ),
        'NA-US-8025' => array( 'provider' => 'level3' ),
        'NA-US-23118' => array( 'provider' => 'cdnetworks' ),
        'NA-US-12179' => array( 'provider' => 'level3' ),
        'NA-US-20452' => array( 'provider' => 'level3' ),
        'NA-US-23126' => array( 'provider' => 'level3' ),
        'NA-US-11834' => array( 'provider' => 'cdnetworks' ),
        'NA-US-18566' => array( 'provider' => 'level3' ),
        'NA-US-11272' => array( 'provider' => 'level3' ),
        'NA-US-3561' => array( 'provider' => 'cdnetworks' ),
        'NA-US-41095' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4130' => array( 'provider' => 'level3' ),
        'NA-US-40511' => array( 'provider' => 'akamai__vip' ),
        'NA-US-53250' => array( 'provider' => 'level3' ),
        'NA-US-5691' => array( 'provider' => 'level3' ),
        'NA-US-32828' => array( 'provider' => 'level3' ),
        'NA-US-10599' => array( 'provider' => 'level3' ),
        'NA-US-2900' => array( 'provider' => 'cdnetworks' ),
        'NA-US-701' => array( 'provider' => 'akamai__vip' ),
        'NA-US-33544' => array( 'provider' => 'level3' ),
        'NA-US-20357' => array( 'provider' => 'cdnetworks' ),
        'NA-US-88' => array( 'provider' => 'level3' ),
        'NA-US-20426' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14615' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14203' => array( 'provider' => 'level3' ),
        'NA-US-81' => array( 'provider' => 'akamai__vip' ),
        'NA-US-87' => array( 'provider' => 'level3' ),
        'NA-US-797' => array( 'provider' => 'level3' ),
        'NA-US-30560' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4046' => array( 'provider' => 'cdnetworks' ),
        'NA-US-174' => array( 'provider' => 'akamai__vip' ),
        'NA-US-793' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4043' => array( 'provider' => 'cdnetworks' ),
        'NA-US-20057' => array( 'provider' => 'cdnetworks' ),
        'NA-US-14921' => array( 'provider' => 'akamai__vip' ),
        'NA-US-30110' => array( 'provider' => 'cdnetworks' ),
        'NA-US-40923' => array( 'provider' => 'level3' ),
        'NA-US-26496' => array( 'provider' => 'level3' ),
        'NA-US-27264' => array( 'provider' => 'level3' ),
        'NA-US-11286' => array( 'provider' => 'cdnetworks' ),
        'NA-US-299' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17232' => array( 'provider' => 'cdnetworks' ),
        'NA-US-17231' => array( 'provider' => 'level3' ),
        'NA-US-243' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13536' => array( 'provider' => 'level3' ),
        'NA-US-7784' => array( 'provider' => 'level3' ),
        'NA-US-15130' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1348' => array( 'provider' => 'cdnetworks' ),
        'NA-US-4546' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11757' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6334' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26146' => array( 'provider' => 'level3' ),
        'NA-US-12007' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12005' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13476' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11596' => array( 'provider' => 'akamai__vip' ),
        'NA-US-2379' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26223' => array( 'provider' => 'level3' ),
        'NA-US-16399' => array( 'provider' => 'level3' ),
        'NA-US-40285' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3593' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1226' => array( 'provider' => 'level3' ),
        'NA-US-21947' => array( 'provider' => 'level3' ),
        'NA-US-21528' => array( 'provider' => 'akamai__vip' ),
        'NA-US-8057' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13977' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4267' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4181' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1341' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3598' => array( 'provider' => 'level3' ),
        'NA-US-4185' => array( 'provider' => 'akamai__vip' ),
        'NA-US-5661' => array( 'provider' => 'level3' ),
        'NA-US-4436' => array( 'provider' => 'cdnetworks' ),
        'NA-US-15003' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13323' => array( 'provider' => 'akamai__vip' ),
        'NA-US-5668' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13448' => array( 'provider' => 'cdnetworks' ),
        'NA-US-46303' => array( 'provider' => 'level3' ),
        'NA-US-186' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12133' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3081' => array( 'provider' => 'level3' ),
        'NA-US-23155' => array( 'provider' => 'akamai__vip' ),
        'NA-US-18' => array( 'provider' => 'cdnetworks' ),
        'NA-US-53347' => array( 'provider' => 'level3' ),
        'NA-US-11979' => array( 'provider' => 'level3' ),
        'NA-US-196' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22637' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11971' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3527' => array( 'provider' => 'cdnetworks' ),
        'NA-US-17054' => array( 'provider' => 'level3' ),
        'NA-US-17055' => array( 'provider' => 'level3' ),
        'NA-US-22808' => array( 'provider' => 'cdnetworks' ),
        'NA-US-33165' => array( 'provider' => 'cdnetworks' ),
        'NA-US-12' => array( 'provider' => 'cdnetworks' ),
        'NA-US-36012' => array( 'provider' => 'level3' ),
        'NA-US-6367' => array( 'provider' => 'level3' ),
        'NA-US-19108' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7774' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2698' => array( 'provider' => 'cdnetworks' ),
        'NA-US-22442' => array( 'provider' => 'cdnetworks' ),
        'NA-US-16509' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3909' => array( 'provider' => 'level3' ),
        'NA-US-27026' => array( 'provider' => 'level3' ),
        'NA-US-23102' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6629' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11486' => array( 'provider' => 'level3' ),
        'NA-US-26292' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6621' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1968' => array( 'provider' => 'cdnetworks' ),
        'NA-US-30404' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11245' => array( 'provider' => 'akamai__vip' ),
        'NA-US-21547' => array( 'provider' => 'level3' ),
        'NA-US-16700' => array( 'provider' => 'level3' ),
        'NA-US-11039' => array( 'provider' => 'cdnetworks' ),
        'NA-US-30628' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26794' => array( 'provider' => 'cdnetworks' ),
        'NA-US-217' => array( 'provider' => 'cdnetworks' ),
        'NA-US-40313' => array( 'provider' => 'akamai__vip' ),
        'NA-US-40315' => array( 'provider' => 'level3' ),
        'NA-US-18712' => array( 'provider' => 'level3' ),
        'NA-US-12042' => array( 'provider' => 'level3' ),
        'NA-US-3354' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3356' => array( 'provider' => 'cdnetworks' ),
        'NA-US-73' => array( 'provider' => 'akamai__vip' ),
        'NA-US-72' => array( 'provider' => 'level3' ),
        'NA-US-7106' => array( 'provider' => 'level3' ),
        'NA-US-70' => array( 'provider' => 'cdnetworks' ),
        'NA-US-22742' => array( 'provider' => 'level3' ),
        'NA-US-11414' => array( 'provider' => 'level3' ),
        'NA-US-7068' => array( 'provider' => 'level3' ),
        'NA-US-7065' => array( 'provider' => 'akamai__vip' ),
        'NA-US-20069' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11796' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1761' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1767' => array( 'provider' => 'level3' ),
        'NA-US-668' => array( 'provider' => 'level3' ),
        'NA-US-23047' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1261' => array( 'provider' => 'level3' ),
        'NA-US-3495' => array( 'provider' => 'cdnetworks' ),
        'NA-US-32035' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19957' => array( 'provider' => 'level3' ),
        'NA-US-19956' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13407' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19817' => array( 'provider' => 'akamai__vip' ),
        'NA-US-693' => array( 'provider' => 'level3' ),
        'NA-US-11663' => array( 'provider' => 'cdnetworks' ),
        'NA-US-14778' => array( 'provider' => 'level3' ),
        'NA-US-30337' => array( 'provider' => 'akamai__vip' ),
        'NA-US-4492' => array( 'provider' => 'level3' ),
        'NA-US-7395' => array( 'provider' => 'akamai__vip' ),
        'NA-US-2707' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2701' => array( 'provider' => 'level3' ),
        'NA-US-125' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22925' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13926' => array( 'provider' => 'akamai__vip' ),
        'NA-US-32867' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11025' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6569' => array( 'provider' => 'akamai__vip' ),
        'NA-US-5742' => array( 'provider' => 'level3' ),
        'NA-US-10615' => array( 'provider' => 'level3' ),
        'NA-US-6315' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13490' => array( 'provider' => 'akamai__vip' ),
        'NA-US-10753' => array( 'provider' => 'level3' ),
        'NA-US-7726' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22561' => array( 'provider' => 'cdnetworks' ),
        'NA-US-22936' => array( 'provider' => 'cdnetworks' ),
        'NA-US-21737' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10430' => array( 'provider' => 'level3' ),
        'NA-US-14051' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22394' => array( 'provider' => 'level3' ),
        'NA-US-10437' => array( 'provider' => 'level3' ),
        'NA-US-21582' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7246' => array( 'provider' => 'level3' ),
        'NA-US-26854' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11788' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3571' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3479' => array( 'provider' => 'cdnetworks' ),
        'NA-US-26554' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3' => array( 'provider' => 'level3' ),
        'NA-US-13385' => array( 'provider' => 'level3' ),
        'NA-US-36049' => array( 'provider' => 'level3' ),
        'NA-US-22244' => array( 'provider' => 'level3' ),
        'NA-US-18990' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16657' => array( 'provider' => 'level3' ),
        'NA-US-22781' => array( 'provider' => 'level3' ),
        'NA-US-27' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7029' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14600' => array( 'provider' => 'akamai__vip' ),
        'NA-US-29737' => array( 'provider' => 'akamai__vip' ),
        'NA-US-30600' => array( 'provider' => 'cdnetworks' ),
        'NA-US-32251' => array( 'provider' => 'level3' ),
        'NA-US-22093' => array( 'provider' => 'level3' ),
        'NA-US-14288' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3614' => array( 'provider' => 'akamai__vip' ),
        'NA-US-19855' => array( 'provider' => 'akamai__vip' ),
        'NA-US-63' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7795' => array( 'provider' => 'level3' ),
        'NA-US-11745' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6325' => array( 'provider' => 'cdnetworks' ),
        'NA-US-12035' => array( 'provider' => 'akamai__vip' ),
        'NA-US-7939' => array( 'provider' => 'level3' ),
        'NA-US-11892' => array( 'provider' => 'cdnetworks' ),
        'NA-US-29780' => array( 'provider' => 'cdnetworks' ),
        'NA-US-29933' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11427' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7925' => array( 'provider' => 'level3' ),
        'NA-US-8103' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1215' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1351' => array( 'provider' => 'level3' ),
        'NA-US-30008' => array( 'provider' => 'cdnetworks' ),
        'NA-US-160' => array( 'provider' => 'level3' ),
        'NA-US-161' => array( 'provider' => 'level3' ),
        'NA-US-5650' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6356' => array( 'provider' => 'akamai__vip' ),
        'NA-US-25850' => array( 'provider' => 'akamai__vip' ),
        'NA-US-25996' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14543' => array( 'provider' => 'akamai__vip' ),
        'NA-US-3685' => array( 'provider' => 'cdnetworks' ),
        'NA-US-35908' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6197' => array( 'provider' => 'level3' ),
        'NA-US-6059' => array( 'provider' => 'akamai__vip' ),
        'NA-US-32' => array( 'provider' => 'level3' ),
        'NA-US-26046' => array( 'provider' => 'cdnetworks' ),
        'NA-US-8148' => array( 'provider' => 'level3' ),
        'NA-US-46687' => array( 'provider' => 'level3' ),
        'NA-US-21704' => array( 'provider' => 'level3' ),
        'NA-US-5056' => array( 'provider' => 'akamai__vip' ),
        'NA-US-22958' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16904' => array( 'provider' => 'cdnetworks' ),
        'NA-US-15305' => array( 'provider' => 'level3' ),
        'NA-US-25921' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6221' => array( 'provider' => 'level3' ),
        'NA-US-7772' => array( 'provider' => 'level3' ),
        'NA-US-9' => array( 'provider' => 'cdnetworks' ),
        'NA-US-15026' => array( 'provider' => 'level3' ),
        'NA-US-33339' => array( 'provider' => 'cdnetworks' ),
        'NA-US-18530' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14901' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11078' => array( 'provider' => 'level3' ),
        'NA-US-11550' => array( 'provider' => 'level3' ),
        'NA-US-11492' => array( 'provider' => 'level3' ),
        'NA-US-4152' => array( 'provider' => 'level3' ),
        'NA-US-7332' => array( 'provider' => 'cdnetworks' ),
        'NA-US-3549' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1970' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19009' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11961' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11847' => array( 'provider' => 'level3' ),
        'NA-US-22192' => array( 'provider' => 'level3' ),
        'NA-US-32703' => array( 'provider' => 'level3' ),
        'NA-US-15169' => array( 'provider' => 'cdnetworks' ),
        'NA-US-210' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14340' => array( 'provider' => 'level3' ),
        'NA-US-15162' => array( 'provider' => 'akamai__vip' ),
        'NA-US-1785' => array( 'provider' => 'level3' ),
        'NA-US-6122' => array( 'provider' => 'cdnetworks' ),
        'NA-US-14265' => array( 'provider' => 'akamai__vip' ),
        'NA-US-26827' => array( 'provider' => 'level3' ),
        'NA-US-7054' => array( 'provider' => 'level3' ),
        'NA-US-25776' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19648' => array( 'provider' => 'cdnetworks' ),
        'NA-US-21852' => array( 'provider' => 'level3' ),
        'NA-US-8147' => array( 'provider' => 'cdnetworks' ),
        'NA-US-4565' => array( 'provider' => 'cdnetworks' ),
        'NA-US-29992' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17394' => array( 'provider' => 'level3' ),
        'NA-US-25899' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2553' => array( 'provider' => 'akamai__vip' ),
        'NA-US-59' => array( 'provider' => 'akamai__vip' ),
        'NA-US-55' => array( 'provider' => 'level3' ),
        'NA-US-14464' => array( 'provider' => 'akamai__vip' ),
        'NA-US-52' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6189' => array( 'provider' => 'level3' ),
        'NA-US-7896' => array( 'provider' => 'cdnetworks' ),
        'NA-US-46428' => array( 'provider' => 'akamai__vip' ),
        'NA-US-11773' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1699' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17025' => array( 'provider' => 'level3' ),
        'NA-US-46925' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13855' => array( 'provider' => 'level3' ),
        'NA-US-8039' => array( 'provider' => 'level3' ),
        'NA-US-10794' => array( 'provider' => 'akamai__vip' ),
        'NA-US-111' => array( 'provider' => 'level3' ),
        'NA-US-6459' => array( 'provider' => 'level3' ),
        'NA-US-2496' => array( 'provider' => 'akamai__vip' ),
        'NA-US-27064' => array( 'provider' => 'akamai__vip' ),
        'NA-US-7973' => array( 'provider' => 'level3' ),
        'NA-US-6263' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6510' => array( 'provider' => 'cdnetworks' ),
        'NA-US-25969' => array( 'provider' => 'akamai__vip' ),
        'NA-US-6517' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1252' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6307' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14828' => array( 'provider' => 'level3' ),
        'NA-US-14041' => array( 'provider' => 'level3' ),
        'NA-US-11215' => array( 'provider' => 'akamai__vip' ),
        'NA-US-47018' => array( 'provider' => 'akamai__vip' ),
        'NA-US-23316' => array( 'provider' => 'akamai__vip' ),
        'NA-US-23314' => array( 'provider' => 'level3' ),
        'NA-US-3464' => array( 'provider' => 'akamai__vip' ),
        'NA-US-32287' => array( 'provider' => 'level3' ),
        'NA-US-11351' => array( 'provider' => 'cdnetworks' ),
        'NA-US-7377' => array( 'provider' => 'cdnetworks' ),
        'NA-US-22315' => array( 'provider' => 'cdnetworks' ),
        'NA-US-71' => array( 'provider' => 'level3' ),
        'NA-US-16527' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16526' => array( 'provider' => 'akamai__vip' ),
        'NA-US-14381' => array( 'provider' => 'level3' ),
        'NA-US-16643' => array( 'provider' => 'cdnetworks' ),
        'NA-US-20231' => array( 'provider' => 'cdnetworks' ),
        'NA-US-23404' => array( 'provider' => 'level3' ),
        'NA-US-7017' => array( 'provider' => 'level3' ),
        'NA-US-7014' => array( 'provider' => 'cdnetworks' ),
        'NA-US-6167' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13776' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11509' => array( 'provider' => 'level3' ),
        'NA-US-13672' => array( 'provider' => 'cdnetworks' ),
        'NA-US-13778' => array( 'provider' => 'cdnetworks' ),
        'NA-US-40127' => array( 'provider' => 'cdnetworks' ),
        'NA-US-5723' => array( 'provider' => 'cdnetworks' ),
        'NA-US-19530' => array( 'provider' => 'akamai__vip' ),
        'NA-US-40375' => array( 'provider' => 'cdnetworks' ),
        'NA-US-16733' => array( 'provider' => 'akamai__vip' ),
        'NA-US-46887' => array( 'provider' => 'akamai__vip' ),
        'NA-US-17356' => array( 'provider' => 'level3' ),
        'NA-US-30641' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12025' => array( 'provider' => 'level3' ),
        'NA-US-19902' => array( 'provider' => 'cdnetworks' ),
        'NA-US-226' => array( 'provider' => 'level3' ),
        'NA-US-225' => array( 'provider' => 'cdnetworks' ),
        'NA-US-22723' => array( 'provider' => 'akamai__vip' ),
        'NA-US-7086' => array( 'provider' => 'level3' ),
        'NA-US-29792' => array( 'provider' => 'cdnetworks' ),
        'NA-US-721' => array( 'provider' => 'level3' ),
        'NA-US-39939' => array( 'provider' => 'cdnetworks' ),
        'NA-US-1742' => array( 'provider' => 'cdnetworks' ),
        'NA-US-32748' => array( 'provider' => 'level3' ),
        'NA-US-7281' => array( 'provider' => 'cdnetworks' ),
        'NA-US-600' => array( 'provider' => 'akamai__vip' ),
        'NA-US-159' => array( 'provider' => 'akamai__vip' ),
        'NA-US-31939' => array( 'provider' => 'akamai__vip' ),
        'NA-US-8075' => array( 'provider' => 'akamai__vip' ),
        'NA-US-21782' => array( 'provider' => 'level3' ),
        'NA-US-26642' => array( 'provider' => 'akamai__vip' ),
        'NA-US-16983' => array( 'provider' => 'level3' ),
        'NA-US-11167' => array( 'provider' => 'level3' ),
        'NA-US-4922' => array( 'provider' => 'akamai__vip' ),
        'NA-US-12112' => array( 'provider' => 'level3' ),
        'NA-US-4201' => array( 'provider' => 'level3' ),
        'NA-US-49' => array( 'provider' => 'level3' ),
        'NA-US-46' => array( 'provider' => 'level3' ),
        'NA-US-47' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11643' => array( 'provider' => 'level3' ),
        'NA-US-1294' => array( 'provider' => 'cdnetworks' ),
        'NA-US-10970' => array( 'provider' => 'level3' ),
        'NA-US-20141' => array( 'provider' => 'level3' ),
        'NA-US-13788' => array( 'provider' => 'akamai__vip' ),
        'NA-US-13789' => array( 'provider' => 'cdnetworks' ),
        'NA-US-2647' => array( 'provider' => 'level3' ),
        'NA-US-5049' => array( 'provider' => 'cdnetworks' ),
        'NA-US-11318' => array( 'provider' => 'level3' ),
        'NA-US-6461' => array( 'provider' => 'cdnetworks' ),
        'NA-US-4996' => array( 'provider' => 'akamai__vip' ),
        'NA-US-25932' => array( 'provider' => 'cdnetworks' ),
        'NA-US-4581' => array( 'provider' => 'level3' ),
        'NA-US-4583' => array( 'provider' => 'akamai__vip' ),
    );
    
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
        if (array_key_exists('saved', $this->preferred[$key])) {
            $saved_alias = $this->preferred[$key]['saved'];
        }
        
        if (array_key_exists($saved_alias, $candidates)) {
            $test_val = $this->varianceThreshold * $candidates[$saved_alias];
            //print("\nSaved: $saved_alias, RTT: " . var_export($test_val, true));
            if ($candidates[$alias] < $test_val) {
                $response->selectProvider($alias);
                $response->setReasonCode($this->reasons['Fastest provider']);
                $this->preferred[$key]['saved'] = $alias;
                return;
            }
            $response->selectProvider($saved_alias);
            $response->setReasonCode($this->reasons['Saved provider']);
            $this->preferred[$key]['saved'] = $saved_alias;
            return;
        }
        
        // Fall back to the preferred provider
        $preferred_alias = $this->preferred[$key]['provider'];
        $test_val = $this->varianceThreshold * $candidates[$preferred_alias];
        //print("\nPreferred: $preferred_alias, RTT: " . var_export($test_val, true));
        
        if ($candidates[$alias] < $test_val) {
            $response->selectProvider($alias);
            $response->setReasonCode($this->reasons['Fastest provider']);
            $this->preferred[$key]['saved'] = $alias;
            return;
        }
        
        $response->selectProvider($preferred_alias);
        $response->setReasonCode($this->reasons['Preferred provider']);
        $this->preferred[$key]['saved'] = $preferred_alias;
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
