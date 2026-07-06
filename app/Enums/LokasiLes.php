<?php

namespace App\Enums;

enum LokasiLes: string
{
    case ISTANA_MENTARI           = 'Perumahan Istana Mentari';
    case HOTEL_ASTON              = 'Hotel Aston Sidoarjo';
    case HOTEL_SWISS_BERLINN      = 'Hotel Swiss Berlinn';
    case HOTEL_SOFIA              = 'Hotel Sofia Juanda';
    case PERMATA_WATERPARK        = 'Permata Waterpark Tanggulangin';
    case REGENCY_21               = 'Regency 21';
    case PREMIER_PLACE            = 'Premier Place Hotel Juanda';
    case APARTMENT_PROSPERO       = 'Apartment Prospero Sidoarjo';
    case LEGOK_ASRI               = 'Legok Asri Park';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
