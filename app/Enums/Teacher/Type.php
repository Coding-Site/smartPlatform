<?php

namespace App\Enums\Teacher;

enum Type : string
{
    case ONLINE_COURSE = 'online_course';
    case RECORDED_COURSE = 'recorded_course';
    case PRIVATE_TEACHER = 'private_teacher';
}
