<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum RecipientType: string
{
    case Alliance = 'alliance';
    case Character = 'character';
    case Corporation = 'corporation';
    case MailingList = 'mailing_list';
}
