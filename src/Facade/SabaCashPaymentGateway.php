<?php

namespace Alsharie\AdenBankPayment\Facade;

use Illuminate\Support\Facades\Facade;
use Alsharie\AdenBankPayment\AdenBank;

class AdenBankPaymentGateway extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     */
    protected static function getFacadeAccessor()
    {
        return AdenBank::class;
    }
}