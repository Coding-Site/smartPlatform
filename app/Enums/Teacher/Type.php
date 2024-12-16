<?php

namespace App\Enums\Teacher;

enum Type : string
{
    case ONLINE_COURSE = 'online_course';
    case RECORDED_COURSE = 'recorded_course';
    case PRIVATE_TEACHER = 'private_teacher';


        public function localizedLabel(string $locale = 'en'): string
    {
        $labels = [
            'en' => [
                self::ONLINE_COURSE->value => 'Online Course Teacher',
                self::RECORDED_COURSE->value => 'Recorded Course Teacher',
                self::PRIVATE_TEACHER->value => 'Private Teacher',
            ],
            'ar' => [
                self::ONLINE_COURSE->value => ' معلم كورسات اونلاين',
                self::RECORDED_COURSE->value => 'معلم كورسات مسجلة',
                self::PRIVATE_TEACHER->value => 'معلمك الخاص',
            ],
        ];

        return $labels[$locale][$this->value];
    }


}
