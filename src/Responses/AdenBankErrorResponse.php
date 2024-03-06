<?php

namespace Alsharie\AdenBankPayment\Responses;


class AdenBankErrorResponse extends AdenBankResponse
{
    protected $success = false;

    public function __construct($response, $status, $request)
    {
        parent::__construct($response, $request);
        $this->data = (array)json_decode($response);
        $this->data['status_code'] = $status;
    }


}