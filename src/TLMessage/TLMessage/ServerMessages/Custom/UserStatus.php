<?php

namespace TLMessage\TLMessage\ServerMessages\Custom;


use Client\StatusWatcherClient\Models\HiddenStatus;
use Exception\TGException;
use MTSerialization\AnonymousMessage;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusEmpty;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusLastMonth;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusLastWeek;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusOffline;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusOnline;
use TLMessage\TLMessage\ServerMessages\UserStatus\UserStatusRecently;
use TLMessage\TLMessage\TLServerMessage;


class UserStatus extends TLServerMessage
{

    /**
     * @var UserStatusEmpty|UserStatusOffline|UserStatusOnline|UserStatusLastWeek
     */
    private $status;


    public function __construct(AnonymousMessage $tlMessage)
    {
        parent::__construct($tlMessage);

        if(UserStatusOnline::isIt($tlMessage))
            $this->status = new UserStatusOnline($tlMessage);
        if(UserStatusOffline::isIt($tlMessage))
            $this->status = new UserStatusOffline($tlMessage);
        if(UserStatusEmpty::isIt($tlMessage))
            $this->status = new UserStatusEmpty($tlMessage);
        if(UserStatusRecently::isIt($tlMessage))
            $this->status = new UserStatusRecently($tlMessage);
        if(UserStatusLastWeek::isIt($tlMessage))
            $this->status = new UserStatusLastWeek($tlMessage);
    }


    /**
     * @param AnonymousMessage $tlMessage
     * @return boolean
     */
    public static function isIt(AnonymousMessage $tlMessage)
    {
        return
            UserStatusOnline::isIt($tlMessage) ||
            UserStatusOffline::isIt($tlMessage) ||
            UserStatusEmpty::isIt($tlMessage) ||
            UserStatusRecently::isIt($tlMessage) ||
            UserStatusLastWeek::isIt($tlMessage) ||
            UserStatusLastMonth::isIt($tlMessage);
    }


    /**
     * @return boolean
     */
    public function isOnline()
    {
        return UserStatusOnline::isIt($this->getTlMessage());
    }


    /**
     * @return boolean
     */
    public function isOffline()
    {
        return UserStatusOffline::isIt($this->getTlMessage());
    }


    /**
     * @return boolean
     */
    public function isHidden()
    {
        return
            UserStatusEmpty::isIt($this->getTlMessage()) ||
            UserStatusRecently::isIt($this->getTlMessage()) ||
            UserStatusLastWeek::isIt($this->getTlMessage()) ||
            UserStatusLastMonth::isIt($this->getTlMessage());
    }


    /**
     * @return HiddenStatus
     * @throws TGException
     */
    public function getHiddenState()
    {
        if(UserStatusRecently::isIt($this->getTlMessage()))
            return new HiddenStatus(HiddenStatus::HIDDEN_SEEN_RECENTLY);

        if(UserStatusLastWeek::isIt($this->getTlMessage()))
            return new HiddenStatus(HiddenStatus::HIDDEN_SEEN_LAST_WEEK);

        if(UserStatusLastMonth::isIt($this->getTlMessage()))
            return new HiddenStatus(HiddenStatus::HIDDEN_SEEN_LAST_MONTH);

        if(UserStatusEmpty::isIt($this->getTlMessage()))
            return new HiddenStatus(HiddenStatus::HIDDEN_EMPTY);

        throw new TGException(TGException::ERR_ASSERT_UNKNOWN_HIDDEN_STATUS);
    }


    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->isOnline() ? $this->status->getExpires() : null;
    }


    /**
     * @return int
     */
    public function getWasOnline()
    {
        return $this->isOffline() ? $this->status->getWasOnline() : null;
    }


}