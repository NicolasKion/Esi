<?php

namespace NicolasKion\Esi\Enums;

enum RecipientType: string
{
    case Alliance = 'alliance';
    case Character = 'character';
    case Corporation = 'corporation';
    case MailingList = 'mailing_list';
}
