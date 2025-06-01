<?php

namespace Bensondevs\Midtrans\Enums;

use Bensondevs\Midtrans\Enums\Concerns\EnumExtensions;

enum PaymentType: string
{
    use EnumExtensions;

    case CreditCard = 'credit_card';

    case BankTransfer = 'bank_transfer';
    case BcaVa = 'bca_va';
    case BniVa = 'bni_va';
    case BriVa = 'bri_va';
    case PermataVa = 'permata_va';
    case CimbVa = 'cimb_va';
    case DanamonVa = 'danamon_va';
    case OtherVa = 'other_va';

    case Gopay = 'gopay';
    case Shopeepay = 'shopeepay';
    case Dana = 'dana';
    case Linkaja = 'linkaja';

    case Qris = 'qris';

    case Indomaret = 'indomaret';
    case Alfamart = 'alfamart';

    case Akulaku = 'akulaku';
    case Kredivo = 'kredivo';

    case BcaKlikpay = 'bca_klikpay';
    case BcaKlikbca = 'bca_klikbca';
    case BriEpay = 'bri_epay';
    case CimbClicks = 'cimb_clicks';
    case DanamonOnline = 'danamon_online';
    case MandiriBill = 'echannel';
    case MandiriEcash = 'mandiri_ecash';

    case Paypal = 'paypal';
    case DbsPaylah = 'dbs_paylah';
    case UobEzpay = 'uob_ezpay';
}
