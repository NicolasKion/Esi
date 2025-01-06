<?php

namespace NicolasKion\Esi\Enums;

enum ContractType: string
{
    case ItemExchange = 'item_exchange';
    case Courier = 'courier';
    case Auction = 'auction';
}
