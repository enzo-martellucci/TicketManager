<?php

namespace App\Config;

enum Priority: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
}
