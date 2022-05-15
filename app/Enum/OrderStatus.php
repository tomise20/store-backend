<?php

namespace App\Enum;

enum OrderStatus: string {
    case RECEIVED = 'RECEIVED';
    case PROCESSED = 'PROCESSED';
    case COMPLETE = 'COMPLETE';
}