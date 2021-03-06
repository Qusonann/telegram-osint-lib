<?php

namespace TLMessage\TLMessage\ServerMessages\Auth;


use MTSerialization\AnonymousMessage;
use TLMessage\TLMessage\TLServerMessage;


class DHServerInnerData extends TLServerMessage
{

    /**
     * @param AnonymousMessage $tlMessage
     * @return boolean
     */
    public static function isIt(AnonymousMessage $tlMessage)
    {
        return self::checkType($tlMessage, 'server_DH_inner_data');
    }


    /**
     * @return string
     */
    public function getG()
    {
        $g = $this->getTlMessage()->getValue('g');
        return strrev(pack('I', $g));
    }


    /**
     * @return string
     * @noinspection PhpUnused
     */
    public function getDHPrime()
    {
        return $this->getTlMessage()->getValue('dh_prime');
    }


    /**
     * @return int
     */
    public function getGA()
    {
        return $this->getTlMessage()->getValue('g_a');
    }


}