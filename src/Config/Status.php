<?php

namespace App\Config;

enum Status: string
{
    case Open = 'Open';
    case InProgress = 'In Progress';
    case Resolved = 'Resolved';
    case Closed = 'Closed';
}
