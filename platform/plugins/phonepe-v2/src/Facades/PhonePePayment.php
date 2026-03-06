<?php

namespace BhadraFoods\PhonePeV2\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isConfigured()
 * @method static string getId()
 * @method static string getDisplayName()
 * @method static array supportedCurrencies()
 * @method static bool isSupportRefundOnline()
 * @method static array authorize(array $data, \Illuminate\Http\Request $request)
 * @method static array refund(string $transactionId, float $amount, array $data = [])
 *
 * @see \BhadraFoods\PhonePeV2\Contracts\PhonePePayment
 */
class PhonePePayment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BhadraFoods\PhonePeV2\Contracts\PhonePePayment::class;
    }
}
