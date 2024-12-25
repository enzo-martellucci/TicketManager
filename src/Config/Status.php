<?php

namespace App\Config;

enum Status: string
{
    case OPEN = 'Open';
    case IN_PROGRESS = 'In Progress';
    case RESOLVED = 'Resolved';
    case CLOSED = 'Closed';
}
