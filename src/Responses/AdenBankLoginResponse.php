<?php

namespace Alsharie\AdenBankPayment\Responses;


class AdenBankLoginResponse extends AdenBankResponse
{

    /**
     * @return mixed|void
     */
    public function getToken()
    {
        if (!empty($this->data['access_token'])) {
            return $this->data['access_token'];
        }

    }


}