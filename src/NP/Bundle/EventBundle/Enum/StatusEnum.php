<?php

namespace NP\Bundle\EventBundle\Enum;

class StatusEnum {

    const ENDED = "ended";
    const FUTUR = "futur";
    const DURING = "during";

    public static function getValues() {
        return array(
            self::ENDED,
            self::FUTUR,
            self::DURING
        );
    }
}