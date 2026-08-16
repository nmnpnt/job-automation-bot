<?php

namespace App\Enums;

enum ApplicationAction: string
{
    case AUTO_APPLY = 'AUTO_APPLY';
    case EXTERNAL_APPLICATION = 'EXTERNAL_APPLICATION';
    case COMPANY_WEBSITE = 'COMPANY_WEBSITE';
    case MANUAL_REQUIRED = 'MANUAL_REQUIRED';
    case SKIP = 'SKIP';
}
