<?php
namespace IgetMaster\MaterialAdmin\Services;

class MotdService {
    private static $motd;

    /**
     * Set the Message of The Day
     */
    public static function setMotd($motd) {
        MotdService::$motd = $motd;
    }

    /**
     * Set the Message of The Day
     */
    public static function getMotd() {
        return MotdService::$motd;
    }
}
