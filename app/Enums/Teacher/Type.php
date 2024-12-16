<?php

namespace App\Enums\Teacher;

enum Type : string
{
    case ONLINE_COURSE = 'online_course';
    case RECORDED_COURSE = 'recorded_course';
    case PRIVATE_TEACHER = 'private_teacher';


    public function label(): string
    {
        return match ($this) {
            self::ONLINE_COURSE => 'معلمين الكورسات الاونلاين',
            self::RECORDED_COURSE => 'معلمين الكورسات المسجلة',
            self::PRIVATE_TEACHER => 'معلمك الخاص',
        };
    }

}
