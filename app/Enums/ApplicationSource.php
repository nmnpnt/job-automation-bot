<?php

namespace App\Enums;

enum ApplicationSource: string
{
    case IN_PLATFORM = 'IN_PLATFORM';
    case EXTERNAL_JOB_BOARD = 'EXTERNAL_JOB_BOARD';
    case COMPANY_WEBSITE = 'COMPANY_WEBSITE';
    case ATS = 'ATS';
    case GREENHOUSE = 'GREENHOUSE';
    case LEVER = 'LEVER';
    case WORKDAY = 'WORKDAY';
    case LINKEDIN = 'LINKEDIN';
    case NAUKRI = 'NAUKRI';
    case UPLERS = 'UPLERS';
    case UNSTOP = 'UNSTOP';
    case HIRIST = 'HIRIST';
    case CUTSHORT = 'CUTSHORT';
    case OTHER_ATS = 'OTHER_ATS';
    case UNKNOWN = 'UNKNOWN';
}
