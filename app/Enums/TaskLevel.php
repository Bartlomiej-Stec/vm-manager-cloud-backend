<?php

namespace App\Enums;

enum TaskLevel: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
    case INSANE = 'insane';
}
