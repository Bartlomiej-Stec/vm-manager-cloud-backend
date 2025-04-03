<?php

namespace App\Enums;

enum CodeType: string 
{
    case USER_ANSWER = 'user_answer';
    case TASK_CORRECT_ANSWER = 'task_correct_answer';
}
