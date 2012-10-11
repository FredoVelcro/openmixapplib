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
        'cloudfront' => array('cname' => 'd5m0og4uaboet.cloudfront.net', 'penalty' => 0),
        'cotendo' => array('cname' => 'orig-10014.cedexis.cotcdn.net', 'penalty' => 10),
        //'origin' => array('cname' => 'origin.cedexis.com', 'penalty' => 0)
    );
    
    private $ttl = 30;
    
    public $availabilityThreshold = 60;
    private $varianceThreshold = .65;
    
    public $preferred = array(
        'na-us-3923' => array( 'provider' => 'cotendo' ),
        'na-us-14912' => array( 'provider' => 'cloudfront' ),
        'na-us-14676' => array( 'provider' => 'cloudfront' ),
        'na-us-22460' => array( 'provider' => 'cloudfront' ),
        'na-us-10455' => array( 'provider' => 'cotendo' ),
        'na-us-16863' => array( 'provider' => 'cotendo' ),
        'na-us-26478' => array( 'provider' => 'cotendo' ),
        'na-us-35788' => array( 'provider' => 'cotendo' ),
        'na-us-14985' => array( 'provider' => 'cotendo' ),
        'na-us-26578' => array( 'provider' => 'cloudfront' ),
        'na-us-14989' => array( 'provider' => 'cotendo' ),
        'na-us-26577' => array( 'provider' => 'cotendo' ),
        'na-us-6966' => array( 'provider' => 'cloudfront' ),
        'na-us-32939' => array( 'provider' => 'cotendo' ),
        'na-us-11911' => array( 'provider' => 'cotendo' ),
        'na-us-14677' => array( 'provider' => 'cloudfront' ),
        'na-us-11915' => array( 'provider' => 'cotendo' ),
        'na-us-3999' => array( 'provider' => 'cotendo' ),
        'na-us-3851' => array( 'provider' => 'cotendo' ),
        'na-us-18812' => array( 'provider' => 'cloudfront' ),
        'na-us-36105' => array( 'provider' => 'cotendo' ),
        'na-us-33745' => array( 'provider' => 'cloudfront' ),
        'na-us-54040' => array( 'provider' => 'cotendo' ),
        'na-us-29859' => array( 'provider' => 'cotendo' ),
        'na-us-18779' => array( 'provider' => 'cotendo' ),
        'na-us-2914' => array( 'provider' => 'cloudfront' ),
        'na-us-33647' => array( 'provider' => 'cloudfront' ),
        'na-us-714' => array( 'provider' => 'cotendo' ),
        'na-us-40702' => array( 'provider' => 'cloudfront' ),
        'na-us-19271' => array( 'provider' => 'cloudfront' ),
        'na-us-7046' => array( 'provider' => 'cotendo' ),
        'na-us-6157' => array( 'provider' => 'cloudfront' ),
        'na-us-26934' => array( 'provider' => 'cloudfront' ),
        'na-us-12064' => array( 'provider' => 'cloudfront' ),
        'na-us-14214' => array( 'provider' => 'cloudfront' ),
        'na-us-14188' => array( 'provider' => 'cotendo' ),
        'na-us-10962' => array( 'provider' => 'cotendo' ),
        'na-us-1706' => array( 'provider' => 'cotendo' ),
        'na-us-1668' => array( 'provider' => 'cotendo' ),
        'na-us-292' => array( 'provider' => 'cotendo' ),
        'na-us-6295' => array( 'provider' => 'cloudfront' ),
        'na-us-291' => array( 'provider' => 'cotendo' ),
        'na-us-3770' => array( 'provider' => 'cotendo' ),
        'na-us-4323' => array( 'provider' => 'cotendo' ),
        'na-us-3778' => array( 'provider' => 'cotendo' ),
        'na-us-6983' => array( 'provider' => 'cotendo' ),
        'na-us-14325' => array( 'provider' => 'cloudfront' ),
        'na-us-22717' => array( 'provider' => 'cloudfront' ),
        'na-us-2828' => array( 'provider' => 'cotendo' ),
        'na-us-13429' => array( 'provider' => 'cotendo' ),
        'na-us-3147' => array( 'provider' => 'cotendo' ),
        'na-us-6389' => array( 'provider' => 'cotendo' ),
        'na-us-14328' => array( 'provider' => 'cotendo' ),
        'na-us-12015' => array( 'provider' => 'cotendo' ),
        'na-us-11686' => array( 'provider' => 'cotendo' ),
        'na-us-14751' => array( 'provider' => 'cotendo' ),
        'na-us-3389' => array( 'provider' => 'cotendo' ),
        'na-us-2381' => array( 'provider' => 'cotendo' ),
        'na-us-17310' => array( 'provider' => 'cloudfront' ),
        'na-us-2386' => array( 'provider' => 'cotendo' ),
        'na-us-3582' => array( 'provider' => 'cloudfront' ),
        'na-us-10337' => array( 'provider' => 'cloudfront' ),
        'na-us-46269' => array( 'provider' => 'cloudfront' ),
        'na-us-1239' => array( 'provider' => 'cotendo' ),
        'na-us-109' => array( 'provider' => 'cotendo' ),
        'na-us-6939' => array( 'provider' => 'cotendo' ),
        'na-us-104' => array( 'provider' => 'cotendo' ),
        'na-us-25973' => array( 'provider' => 'cotendo' ),
        'na-us-13333' => array( 'provider' => 'cotendo' ),
        'na-us-16810' => array( 'provider' => 'cotendo' ),
        'na-us-6500' => array( 'provider' => 'cotendo' ),
        'na-us-6075' => array( 'provider' => 'cotendo' ),
        'na-us-12083' => array( 'provider' => 'cotendo' ),
        'na-us-23148' => array( 'provider' => 'cotendo' ),
        'na-us-1248' => array( 'provider' => 'cotendo' ),
        'na-us-6079' => array( 'provider' => 'cotendo' ),
        'na-us-21928' => array( 'provider' => 'cotendo' ),
        'na-us-23326' => array( 'provider' => 'cotendo' ),
        'na-us-32479' => array( 'provider' => 'cotendo' ),
        'na-us-16718' => array( 'provider' => 'cotendo' ),
        'na-us-3801' => array( 'provider' => 'cotendo' ),
        'na-us-33470' => array( 'provider' => 'cotendo' ),
        'na-us-23481' => array( 'provider' => 'cotendo' ),
        'na-us-14477' => array( 'provider' => 'cotendo' ),
        'na-us-7341' => array( 'provider' => 'cotendo' ),
        'na-us-1906' => array( 'provider' => 'cotendo' ),
        'na-us-20135' => array( 'provider' => 'cloudfront' ),
        'na-us-16928' => array( 'provider' => 'cotendo' ),
        'na-us-21688' => array( 'provider' => 'cotendo' ),
        'na-us-22302' => array( 'provider' => 'cotendo' ),
        'na-us-19159' => array( 'provider' => 'cotendo' ),
        'na-us-26878' => array( 'provider' => 'cotendo' ),
        'na-us-22283' => array( 'provider' => 'cotendo' ),
        'na-us-13645' => array( 'provider' => 'cloudfront' ),
        'na-us-20001' => array( 'provider' => 'cotendo' ),
        'na-us-19406' => array( 'provider' => 'cotendo' ),
        'na-us-10242' => array( 'provider' => 'cotendo' ),
        'na-us-26282' => array( 'provider' => 'cotendo' ),
        'na-us-27506' => array( 'provider' => 'cloudfront' ),
        'na-us-14710' => array( 'provider' => 'cotendo' ),
        'na-us-13768' => array( 'provider' => 'cloudfront' ),
        'na-us-18687' => array( 'provider' => 'cotendo' ),
        'na-us-1999' => array( 'provider' => 'cloudfront' ),
        'na-us-1998' => array( 'provider' => 'cotendo' ),
        'na-us-11530' => array( 'provider' => 'cotendo' ),
        'na-us-4179' => array( 'provider' => 'cotendo' ),
        'na-us-19029' => array( 'provider' => 'cloudfront' ),
        'na-us-29968' => array( 'provider' => 'cotendo' ),
        'na-us-36375' => array( 'provider' => 'cotendo' ),
        'na-us-32808' => array( 'provider' => 'cotendo' ),
        'na-us-557' => array( 'provider' => 'cotendo' ),
        'na-us-16673' => array( 'provider' => 'cotendo' ),
        'na-us-22759' => array( 'provider' => 'cotendo' ),
        'na-us-16586' => array( 'provider' => 'cotendo' ),
        'na-us-30193' => array( 'provider' => 'cloudfront' ),
        'na-us-131' => array( 'provider' => 'cotendo' ),
        'na-us-237' => array( 'provider' => 'cloudfront' ),
        'na-us-31822' => array( 'provider' => 'cloudfront' ),
        'na-us-21899' => array( 'provider' => 'cotendo' ),
        'na-us-6102' => array( 'provider' => 'cloudfront' ),
        'na-us-1696' => array( 'provider' => 'cotendo' ),
        'na-us-10837' => array( 'provider' => 'cloudfront' ),
        'na-us-17227' => array( 'provider' => 'cotendo' ),
        'na-us-27343' => array( 'provider' => 'cotendo' ),
        'na-us-29761' => array( 'provider' => 'cotendo' ),
        'na-us-1751' => array( 'provider' => 'cotendo' ),
        'na-us-10933' => array( 'provider' => 'cotendo' ),
        'na-us-1790' => array( 'provider' => 'cotendo' ),
        'na-us-21976' => array( 'provider' => 'cloudfront' ),
        'na-us-23503' => array( 'provider' => 'cloudfront' ),
        'na-us-7829' => array( 'provider' => 'cotendo' ),
        'na-us-26783' => array( 'provider' => 'cotendo' ),
        'na-us-12282' => array( 'provider' => 'cotendo' ),
        'na-us-11040' => array( 'provider' => 'cloudfront' ),
        'na-us-3701' => array( 'provider' => 'cotendo' ),
        'na-us-13370' => array( 'provider' => 'cotendo' ),
        'na-us-26891' => array( 'provider' => 'cotendo' ),
        'na-us-13576' => array( 'provider' => 'cotendo' ),
        'na-us-3112' => array( 'provider' => 'cotendo' ),
        'na-us-40246' => array( 'provider' => 'cotendo' ),
        'na-us-2538' => array( 'provider' => 'cotendo' ),
        'na-us-11714' => array( 'provider' => 'cloudfront' ),
        'na-us-11650' => array( 'provider' => 'cotendo' ),
        'na-us-17184' => array( 'provider' => 'cotendo' ),
        'na-us-46375' => array( 'provider' => 'cotendo' ),
        'na-us-2711' => array( 'provider' => 'cotendo' ),
        'na-us-2714' => array( 'provider' => 'cotendo' ),
        'na-us-127' => array( 'provider' => 'cloudfront' ),
        'na-us-11309' => array( 'provider' => 'cotendo' ),
        'na-us-5078' => array( 'provider' => 'cotendo' ),
        'na-us-17161' => array( 'provider' => 'cloudfront' ),
        'na-us-7381' => array( 'provider' => 'cotendo' ),
        'na-us-10921' => array( 'provider' => 'cloudfront' ),
        'na-us-7385' => array( 'provider' => 'cotendo' ),
        'na-us-10835' => array( 'provider' => 'cloudfront' ),
        'na-us-6478' => array( 'provider' => 'cloudfront' ),
        'na-us-3794' => array( 'provider' => 'cotendo' ),
        'na-us-15048' => array( 'provider' => 'cotendo' ),
        'na-us-29' => array( 'provider' => 'cotendo' ),
        'na-us-4385' => array( 'provider' => 'cloudfront' ),
        'na-us-16966' => array( 'provider' => 'cloudfront' ),
        'na-us-4983' => array( 'provider' => 'cloudfront' ),
        'na-us-12175' => array( 'provider' => 'cotendo' ),
        'na-us-2152' => array( 'provider' => 'cotendo' ),
        'na-us-53813' => array( 'provider' => 'cotendo' ),
        'na-us-8025' => array( 'provider' => 'cloudfront' ),
        'na-us-23118' => array( 'provider' => 'cotendo' ),
        'na-us-12179' => array( 'provider' => 'cloudfront' ),
        'na-us-20452' => array( 'provider' => 'cloudfront' ),
        'na-us-23126' => array( 'provider' => 'cloudfront' ),
        'na-us-11834' => array( 'provider' => 'cotendo' ),
        'na-us-18566' => array( 'provider' => 'cloudfront' ),
        'na-us-11272' => array( 'provider' => 'cloudfront' ),
        'na-us-3561' => array( 'provider' => 'cotendo' ),
        'na-us-41095' => array( 'provider' => 'cotendo' ),
        'na-us-4130' => array( 'provider' => 'cloudfront' ),
        'na-us-40511' => array( 'provider' => 'cotendo' ),
        'na-us-53250' => array( 'provider' => 'cloudfront' ),
        'na-us-5691' => array( 'provider' => 'cloudfront' ),
        'na-us-32828' => array( 'provider' => 'cloudfront' ),
        'na-us-10599' => array( 'provider' => 'cloudfront' ),
        'na-us-2900' => array( 'provider' => 'cotendo' ),
        'na-us-701' => array( 'provider' => 'cotendo' ),
        'na-us-33544' => array( 'provider' => 'cloudfront' ),
        'na-us-20357' => array( 'provider' => 'cotendo' ),
        'na-us-88' => array( 'provider' => 'cloudfront' ),
        'na-us-20426' => array( 'provider' => 'cotendo' ),
        'na-us-14615' => array( 'provider' => 'cotendo' ),
        'na-us-14203' => array( 'provider' => 'cloudfront' ),
        'na-us-81' => array( 'provider' => 'cotendo' ),
        'na-us-87' => array( 'provider' => 'cloudfront' ),
        'na-us-797' => array( 'provider' => 'cloudfront' ),
        'na-us-30560' => array( 'provider' => 'cotendo' ),
        'na-us-4046' => array( 'provider' => 'cotendo' ),
        'na-us-174' => array( 'provider' => 'cotendo' ),
        'na-us-793' => array( 'provider' => 'cotendo' ),
        'na-us-4043' => array( 'provider' => 'cotendo' ),
        'na-us-20057' => array( 'provider' => 'cotendo' ),
        'na-us-14921' => array( 'provider' => 'cotendo' ),
        'na-us-30110' => array( 'provider' => 'cotendo' ),
        'na-us-40923' => array( 'provider' => 'cloudfront' ),
        'na-us-26496' => array( 'provider' => 'cloudfront' ),
        'na-us-27264' => array( 'provider' => 'cloudfront' ),
        'na-us-11286' => array( 'provider' => 'cotendo' ),
        'na-us-299' => array( 'provider' => 'cotendo' ),
        'na-us-17232' => array( 'provider' => 'cotendo' ),
        'na-us-17231' => array( 'provider' => 'cloudfront' ),
        'na-us-243' => array( 'provider' => 'cotendo' ),
        'na-us-13536' => array( 'provider' => 'cloudfront' ),
        'na-us-7784' => array( 'provider' => 'cloudfront' ),
        'na-us-15130' => array( 'provider' => 'cotendo' ),
        'na-us-1348' => array( 'provider' => 'cotendo' ),
        'na-us-4546' => array( 'provider' => 'cotendo' ),
        'na-us-11757' => array( 'provider' => 'cotendo' ),
        'na-us-6334' => array( 'provider' => 'cotendo' ),
        'na-us-26146' => array( 'provider' => 'cloudfront' ),
        'na-us-12007' => array( 'provider' => 'cotendo' ),
        'na-us-12005' => array( 'provider' => 'cotendo' ),
        'na-us-13476' => array( 'provider' => 'cotendo' ),
        'na-us-11596' => array( 'provider' => 'cotendo' ),
        'na-us-2379' => array( 'provider' => 'cotendo' ),
        'na-us-26223' => array( 'provider' => 'cloudfront' ),
        'na-us-16399' => array( 'provider' => 'cloudfront' ),
        'na-us-40285' => array( 'provider' => 'cotendo' ),
        'na-us-3593' => array( 'provider' => 'cotendo' ),
        'na-us-1226' => array( 'provider' => 'cloudfront' ),
        'na-us-21947' => array( 'provider' => 'cloudfront' ),
        'na-us-21528' => array( 'provider' => 'cotendo' ),
        'na-us-8057' => array( 'provider' => 'cotendo' ),
        'na-us-13977' => array( 'provider' => 'cotendo' ),
        'na-us-4267' => array( 'provider' => 'cotendo' ),
        'na-us-4181' => array( 'provider' => 'cotendo' ),
        'na-us-1341' => array( 'provider' => 'cotendo' ),
        'na-us-3598' => array( 'provider' => 'cloudfront' ),
        'na-us-4185' => array( 'provider' => 'cotendo' ),
        'na-us-5661' => array( 'provider' => 'cloudfront' ),
        'na-us-4436' => array( 'provider' => 'cotendo' ),
        'na-us-15003' => array( 'provider' => 'cotendo' ),
        'na-us-13323' => array( 'provider' => 'cotendo' ),
        'na-us-5668' => array( 'provider' => 'cotendo' ),
        'na-us-13448' => array( 'provider' => 'cotendo' ),
        'na-us-46303' => array( 'provider' => 'cloudfront' ),
        'na-us-186' => array( 'provider' => 'cotendo' ),
        'na-us-12133' => array( 'provider' => 'cotendo' ),
        'na-us-3081' => array( 'provider' => 'cloudfront' ),
        'na-us-23155' => array( 'provider' => 'cotendo' ),
        'na-us-18' => array( 'provider' => 'cotendo' ),
        'na-us-53347' => array( 'provider' => 'cloudfront' ),
        'na-us-11979' => array( 'provider' => 'cloudfront' ),
        'na-us-196' => array( 'provider' => 'cotendo' ),
        'na-us-22637' => array( 'provider' => 'cotendo' ),
        'na-us-11971' => array( 'provider' => 'cotendo' ),
        'na-us-3527' => array( 'provider' => 'cotendo' ),
        'na-us-17054' => array( 'provider' => 'cloudfront' ),
        'na-us-17055' => array( 'provider' => 'cloudfront' ),
        'na-us-22808' => array( 'provider' => 'cotendo' ),
        'na-us-33165' => array( 'provider' => 'cotendo' ),
        'na-us-12' => array( 'provider' => 'cotendo' ),
        'na-us-36012' => array( 'provider' => 'cloudfront' ),
        'na-us-6367' => array( 'provider' => 'cloudfront' ),
        'na-us-19108' => array( 'provider' => 'cotendo' ),
        'na-us-7774' => array( 'provider' => 'cotendo' ),
        'na-us-2698' => array( 'provider' => 'cotendo' ),
        'na-us-22442' => array( 'provider' => 'cotendo' ),
        'na-us-16509' => array( 'provider' => 'cotendo' ),
        'na-us-3909' => array( 'provider' => 'cloudfront' ),
        'na-us-27026' => array( 'provider' => 'cloudfront' ),
        'na-us-23102' => array( 'provider' => 'cotendo' ),
        'na-us-6629' => array( 'provider' => 'cotendo' ),
        'na-us-11486' => array( 'provider' => 'cloudfront' ),
        'na-us-26292' => array( 'provider' => 'cotendo' ),
        'na-us-6621' => array( 'provider' => 'cotendo' ),
        'na-us-1968' => array( 'provider' => 'cotendo' ),
        'na-us-30404' => array( 'provider' => 'cotendo' ),
        'na-us-11245' => array( 'provider' => 'cotendo' ),
        'na-us-21547' => array( 'provider' => 'cloudfront' ),
        'na-us-16700' => array( 'provider' => 'cloudfront' ),
        'na-us-11039' => array( 'provider' => 'cotendo' ),
        'na-us-30628' => array( 'provider' => 'cotendo' ),
        'na-us-26794' => array( 'provider' => 'cotendo' ),
        'na-us-217' => array( 'provider' => 'cotendo' ),
        'na-us-40313' => array( 'provider' => 'cotendo' ),
        'na-us-40315' => array( 'provider' => 'cloudfront' ),
        'na-us-18712' => array( 'provider' => 'cloudfront' ),
        'na-us-12042' => array( 'provider' => 'cloudfront' ),
        'na-us-3354' => array( 'provider' => 'cotendo' ),
        'na-us-3356' => array( 'provider' => 'cotendo' ),
        'na-us-73' => array( 'provider' => 'cotendo' ),
        'na-us-72' => array( 'provider' => 'cloudfront' ),
        'na-us-7106' => array( 'provider' => 'cloudfront' ),
        'na-us-70' => array( 'provider' => 'cotendo' ),
        'na-us-22742' => array( 'provider' => 'cloudfront' ),
        'na-us-11414' => array( 'provider' => 'cloudfront' ),
        'na-us-7068' => array( 'provider' => 'cloudfront' ),
        'na-us-7065' => array( 'provider' => 'cotendo' ),
        'na-us-20069' => array( 'provider' => 'cotendo' ),
        'na-us-11796' => array( 'provider' => 'cotendo' ),
        'na-us-1761' => array( 'provider' => 'cotendo' ),
        'na-us-1767' => array( 'provider' => 'cloudfront' ),
        'na-us-668' => array( 'provider' => 'cloudfront' ),
        'na-us-23047' => array( 'provider' => 'cotendo' ),
        'na-us-1261' => array( 'provider' => 'cloudfront' ),
        'na-us-3495' => array( 'provider' => 'cotendo' ),
        'na-us-32035' => array( 'provider' => 'cotendo' ),
        'na-us-19957' => array( 'provider' => 'cloudfront' ),
        'na-us-19956' => array( 'provider' => 'cotendo' ),
        'na-us-13407' => array( 'provider' => 'cotendo' ),
        'na-us-19817' => array( 'provider' => 'cotendo' ),
        'na-us-693' => array( 'provider' => 'cloudfront' ),
        'na-us-11663' => array( 'provider' => 'cotendo' ),
        'na-us-14778' => array( 'provider' => 'cloudfront' ),
        'na-us-30337' => array( 'provider' => 'cotendo' ),
        'na-us-4492' => array( 'provider' => 'cloudfront' ),
        'na-us-7395' => array( 'provider' => 'cotendo' ),
        'na-us-2707' => array( 'provider' => 'cotendo' ),
        'na-us-2701' => array( 'provider' => 'cloudfront' ),
        'na-us-125' => array( 'provider' => 'cotendo' ),
        'na-us-22925' => array( 'provider' => 'cotendo' ),
        'na-us-13926' => array( 'provider' => 'cotendo' ),
        'na-us-32867' => array( 'provider' => 'cotendo' ),
        'na-us-11025' => array( 'provider' => 'cotendo' ),
        'na-us-6569' => array( 'provider' => 'cotendo' ),
        'na-us-5742' => array( 'provider' => 'cloudfront' ),
        'na-us-10615' => array( 'provider' => 'cloudfront' ),
        'na-us-6315' => array( 'provider' => 'cotendo' ),
        'na-us-13490' => array( 'provider' => 'cotendo' ),
        'na-us-10753' => array( 'provider' => 'cloudfront' ),
        'na-us-7726' => array( 'provider' => 'cotendo' ),
        'na-us-22561' => array( 'provider' => 'cotendo' ),
        'na-us-22936' => array( 'provider' => 'cotendo' ),
        'na-us-21737' => array( 'provider' => 'cotendo' ),
        'na-us-10430' => array( 'provider' => 'cloudfront' ),
        'na-us-14051' => array( 'provider' => 'cotendo' ),
        'na-us-22394' => array( 'provider' => 'cloudfront' ),
        'na-us-10437' => array( 'provider' => 'cloudfront' ),
        'na-us-21582' => array( 'provider' => 'cotendo' ),
        'na-us-7246' => array( 'provider' => 'cloudfront' ),
        'na-us-26854' => array( 'provider' => 'cotendo' ),
        'na-us-11788' => array( 'provider' => 'cotendo' ),
        'na-us-3571' => array( 'provider' => 'cotendo' ),
        'na-us-3479' => array( 'provider' => 'cotendo' ),
        'na-us-26554' => array( 'provider' => 'cotendo' ),
        'na-us-3' => array( 'provider' => 'cloudfront' ),
        'na-us-13385' => array( 'provider' => 'cloudfront' ),
        'na-us-36049' => array( 'provider' => 'cloudfront' ),
        'na-us-22244' => array( 'provider' => 'cloudfront' ),
        'na-us-18990' => array( 'provider' => 'cotendo' ),
        'na-us-16657' => array( 'provider' => 'cloudfront' ),
        'na-us-22781' => array( 'provider' => 'cloudfront' ),
        'na-us-27' => array( 'provider' => 'cotendo' ),
        'na-us-7029' => array( 'provider' => 'cotendo' ),
        'na-us-14600' => array( 'provider' => 'cotendo' ),
        'na-us-29737' => array( 'provider' => 'cotendo' ),
        'na-us-30600' => array( 'provider' => 'cotendo' ),
        'na-us-32251' => array( 'provider' => 'cloudfront' ),
        'na-us-22093' => array( 'provider' => 'cloudfront' ),
        'na-us-14288' => array( 'provider' => 'cotendo' ),
        'na-us-3614' => array( 'provider' => 'cotendo' ),
        'na-us-19855' => array( 'provider' => 'cotendo' ),
        'na-us-63' => array( 'provider' => 'cotendo' ),
        'na-us-7795' => array( 'provider' => 'cloudfront' ),
        'na-us-11745' => array( 'provider' => 'cotendo' ),
        'na-us-6325' => array( 'provider' => 'cotendo' ),
        'na-us-12035' => array( 'provider' => 'cotendo' ),
        'na-us-7939' => array( 'provider' => 'cloudfront' ),
        'na-us-11892' => array( 'provider' => 'cotendo' ),
        'na-us-29780' => array( 'provider' => 'cotendo' ),
        'na-us-29933' => array( 'provider' => 'cotendo' ),
        'na-us-11427' => array( 'provider' => 'cotendo' ),
        'na-us-7925' => array( 'provider' => 'cloudfront' ),
        'na-us-8103' => array( 'provider' => 'cotendo' ),
        'na-us-1215' => array( 'provider' => 'cotendo' ),
        'na-us-1351' => array( 'provider' => 'cloudfront' ),
        'na-us-30008' => array( 'provider' => 'cotendo' ),
        'na-us-160' => array( 'provider' => 'cloudfront' ),
        'na-us-161' => array( 'provider' => 'cloudfront' ),
        'na-us-5650' => array( 'provider' => 'cotendo' ),
        'na-us-6356' => array( 'provider' => 'cotendo' ),
        'na-us-25850' => array( 'provider' => 'cotendo' ),
        'na-us-25996' => array( 'provider' => 'cotendo' ),
        'na-us-14543' => array( 'provider' => 'cotendo' ),
        'na-us-3685' => array( 'provider' => 'cotendo' ),
        'na-us-35908' => array( 'provider' => 'cotendo' ),
        'na-us-6197' => array( 'provider' => 'cloudfront' ),
        'na-us-6059' => array( 'provider' => 'cotendo' ),
        'na-us-32' => array( 'provider' => 'cloudfront' ),
        'na-us-26046' => array( 'provider' => 'cotendo' ),
        'na-us-8148' => array( 'provider' => 'cloudfront' ),
        'na-us-46687' => array( 'provider' => 'cloudfront' ),
        'na-us-21704' => array( 'provider' => 'cloudfront' ),
        'na-us-5056' => array( 'provider' => 'cotendo' ),
        'na-us-22958' => array( 'provider' => 'cotendo' ),
        'na-us-16904' => array( 'provider' => 'cotendo' ),
        'na-us-15305' => array( 'provider' => 'cloudfront' ),
        'na-us-25921' => array( 'provider' => 'cotendo' ),
        'na-us-6221' => array( 'provider' => 'cloudfront' ),
        'na-us-7772' => array( 'provider' => 'cloudfront' ),
        'na-us-9' => array( 'provider' => 'cotendo' ),
        'na-us-15026' => array( 'provider' => 'cloudfront' ),
        'na-us-33339' => array( 'provider' => 'cotendo' ),
        'na-us-18530' => array( 'provider' => 'cotendo' ),
        'na-us-14901' => array( 'provider' => 'cotendo' ),
        'na-us-11078' => array( 'provider' => 'cloudfront' ),
        'na-us-11550' => array( 'provider' => 'cloudfront' ),
        'na-us-11492' => array( 'provider' => 'cloudfront' ),
        'na-us-4152' => array( 'provider' => 'cloudfront' ),
        'na-us-7332' => array( 'provider' => 'cotendo' ),
        'na-us-3549' => array( 'provider' => 'cotendo' ),
        'na-us-1970' => array( 'provider' => 'cotendo' ),
        'na-us-19009' => array( 'provider' => 'cotendo' ),
        'na-us-11961' => array( 'provider' => 'cotendo' ),
        'na-us-11847' => array( 'provider' => 'cloudfront' ),
        'na-us-22192' => array( 'provider' => 'cloudfront' ),
        'na-us-32703' => array( 'provider' => 'cloudfront' ),
        'na-us-15169' => array( 'provider' => 'cotendo' ),
        'na-us-210' => array( 'provider' => 'cotendo' ),
        'na-us-14340' => array( 'provider' => 'cloudfront' ),
        'na-us-15162' => array( 'provider' => 'cotendo' ),
        'na-us-1785' => array( 'provider' => 'cloudfront' ),
        'na-us-6122' => array( 'provider' => 'cotendo' ),
        'na-us-14265' => array( 'provider' => 'cotendo' ),
        'na-us-26827' => array( 'provider' => 'cloudfront' ),
        'na-us-7054' => array( 'provider' => 'cloudfront' ),
        'na-us-25776' => array( 'provider' => 'cotendo' ),
        'na-us-19648' => array( 'provider' => 'cotendo' ),
        'na-us-21852' => array( 'provider' => 'cloudfront' ),
        'na-us-8147' => array( 'provider' => 'cotendo' ),
        'na-us-4565' => array( 'provider' => 'cotendo' ),
        'na-us-29992' => array( 'provider' => 'cotendo' ),
        'na-us-17394' => array( 'provider' => 'cloudfront' ),
        'na-us-25899' => array( 'provider' => 'cotendo' ),
        'na-us-2553' => array( 'provider' => 'cotendo' ),
        'na-us-59' => array( 'provider' => 'cotendo' ),
        'na-us-55' => array( 'provider' => 'cloudfront' ),
        'na-us-14464' => array( 'provider' => 'cotendo' ),
        'na-us-52' => array( 'provider' => 'cotendo' ),
        'na-us-6189' => array( 'provider' => 'cloudfront' ),
        'na-us-7896' => array( 'provider' => 'cotendo' ),
        'na-us-46428' => array( 'provider' => 'cotendo' ),
        'na-us-11773' => array( 'provider' => 'cotendo' ),
        'na-us-1699' => array( 'provider' => 'cotendo' ),
        'na-us-17025' => array( 'provider' => 'cloudfront' ),
        'na-us-46925' => array( 'provider' => 'cotendo' ),
        'na-us-13855' => array( 'provider' => 'cloudfront' ),
        'na-us-8039' => array( 'provider' => 'cloudfront' ),
        'na-us-10794' => array( 'provider' => 'cotendo' ),
        'na-us-111' => array( 'provider' => 'cloudfront' ),
        'na-us-6459' => array( 'provider' => 'cloudfront' ),
        'na-us-2496' => array( 'provider' => 'cotendo' ),
        'na-us-27064' => array( 'provider' => 'cotendo' ),
        'na-us-7973' => array( 'provider' => 'cloudfront' ),
        'na-us-6263' => array( 'provider' => 'cotendo' ),
        'na-us-6510' => array( 'provider' => 'cotendo' ),
        'na-us-25969' => array( 'provider' => 'cotendo' ),
        'na-us-6517' => array( 'provider' => 'cotendo' ),
        'na-us-1252' => array( 'provider' => 'cotendo' ),
        'na-us-6307' => array( 'provider' => 'cotendo' ),
        'na-us-14828' => array( 'provider' => 'cloudfront' ),
        'na-us-14041' => array( 'provider' => 'cloudfront' ),
        'na-us-11215' => array( 'provider' => 'cotendo' ),
        'na-us-47018' => array( 'provider' => 'cotendo' ),
        'na-us-23316' => array( 'provider' => 'cotendo' ),
        'na-us-23314' => array( 'provider' => 'cloudfront' ),
        'na-us-3464' => array( 'provider' => 'cotendo' ),
        'na-us-32287' => array( 'provider' => 'cloudfront' ),
        'na-us-11351' => array( 'provider' => 'cotendo' ),
        'na-us-7377' => array( 'provider' => 'cotendo' ),
        'na-us-22315' => array( 'provider' => 'cotendo' ),
        'na-us-71' => array( 'provider' => 'cloudfront' ),
        'na-us-16527' => array( 'provider' => 'cotendo' ),
        'na-us-16526' => array( 'provider' => 'cotendo' ),
        'na-us-14381' => array( 'provider' => 'cloudfront' ),
        'na-us-16643' => array( 'provider' => 'cotendo' ),
        'na-us-20231' => array( 'provider' => 'cotendo' ),
        'na-us-23404' => array( 'provider' => 'cloudfront' ),
        'na-us-7017' => array( 'provider' => 'cloudfront' ),
        'na-us-7014' => array( 'provider' => 'cotendo' ),
        'na-us-6167' => array( 'provider' => 'cotendo' ),
        'na-us-13776' => array( 'provider' => 'cotendo' ),
        'na-us-11509' => array( 'provider' => 'cloudfront' ),
        'na-us-13672' => array( 'provider' => 'cotendo' ),
        'na-us-13778' => array( 'provider' => 'cotendo' ),
        'na-us-40127' => array( 'provider' => 'cotendo' ),
        'na-us-5723' => array( 'provider' => 'cotendo' ),
        'na-us-19530' => array( 'provider' => 'cotendo' ),
        'na-us-40375' => array( 'provider' => 'cotendo' ),
        'na-us-16733' => array( 'provider' => 'cotendo' ),
        'na-us-46887' => array( 'provider' => 'cotendo' ),
        'na-us-17356' => array( 'provider' => 'cloudfront' ),
        'na-us-30641' => array( 'provider' => 'cotendo' ),
        'na-us-12025' => array( 'provider' => 'cloudfront' ),
        'na-us-19902' => array( 'provider' => 'cotendo' ),
        'na-us-226' => array( 'provider' => 'cloudfront' ),
        'na-us-225' => array( 'provider' => 'cotendo' ),
        'na-us-22723' => array( 'provider' => 'cotendo' ),
        'na-us-7086' => array( 'provider' => 'cloudfront' ),
        'na-us-29792' => array( 'provider' => 'cotendo' ),
        'na-us-721' => array( 'provider' => 'cloudfront' ),
        'na-us-39939' => array( 'provider' => 'cotendo' ),
        'na-us-1742' => array( 'provider' => 'cotendo' ),
        'na-us-32748' => array( 'provider' => 'cloudfront' ),
        'na-us-7281' => array( 'provider' => 'cotendo' ),
        'na-us-600' => array( 'provider' => 'cotendo' ),
        'na-us-159' => array( 'provider' => 'cotendo' ),
        'na-us-31939' => array( 'provider' => 'cotendo' ),
        'na-us-8075' => array( 'provider' => 'cotendo' ),
        'na-us-21782' => array( 'provider' => 'cloudfront' ),
        'na-us-26642' => array( 'provider' => 'cotendo' ),
        'na-us-16983' => array( 'provider' => 'cloudfront' ),
        'na-us-11167' => array( 'provider' => 'cloudfront' ),
        'na-us-4922' => array( 'provider' => 'cotendo' ),
        'na-us-12112' => array( 'provider' => 'cloudfront' ),
        'na-us-4201' => array( 'provider' => 'cloudfront' ),
        'na-us-49' => array( 'provider' => 'cloudfront' ),
        'na-us-46' => array( 'provider' => 'cloudfront' ),
        'na-us-47' => array( 'provider' => 'cotendo' ),
        'na-us-11643' => array( 'provider' => 'cloudfront' ),
        'na-us-1294' => array( 'provider' => 'cotendo' ),
        'na-us-10970' => array( 'provider' => 'cloudfront' ),
        'na-us-20141' => array( 'provider' => 'cloudfront' ),
        'na-us-13788' => array( 'provider' => 'cotendo' ),
        'na-us-13789' => array( 'provider' => 'cotendo' ),
        'na-us-2647' => array( 'provider' => 'cloudfront' ),
        'na-us-5049' => array( 'provider' => 'cotendo' ),
        'na-us-11318' => array( 'provider' => 'cloudfront' ),
        'na-us-6461' => array( 'provider' => 'cotendo' ),
        'na-us-4996' => array( 'provider' => 'cotendo' ),
        'na-us-25932' => array( 'provider' => 'cotendo' ),
        'na-us-4581' => array( 'provider' => 'cloudfront' ),
        'na-us-4583' => array( 'provider' => 'cotendo' ),
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
        $market = $request->geo(GeoProperties::MARKET);
        $country = $request->geo(GeoProperties::COUNTRY);
        $asn = $request->geo(GeoProperties::ASN);
        if ($request->geo(EDNSProperties::ENABLE)) {
            $market = $request->geo(EDNSProperties::MARKET);
            $country = $request->geo(EDNSProperties::COUNTRY);
            $asn = $request->geo(EDNSProperties::ASN);
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
