<?php

namespace App\Enums\Question;

enum Type : string
{
    case MultipleChoice = 'multiple_choice';
    case FillInTheBlank = 'fill_in_the_blank';
    case Why = 'why';
    case WhatHappens = 'what_happens';

}
