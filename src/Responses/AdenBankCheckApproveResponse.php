<?php

namespace Alsharie\AdenBankPayment\Responses;


class AdenBankCheckApproveResponse extends AdenBankResponse
{

    /**
     * Bank's unique transaction ID. generated by bank
     * @return false|mixed
     */
    public function getBankRef()
    {
        if (!empty($this->data['BankRef'])) {
            return $this->data['BankRef'];
        }

        return false;
    }

    /**
     * Additional notes or details
     * @return false|mixed
     */
    public function getNotes()
    {
        if (!empty($this->data['Notes'])) {
            return $this->data['Notes'];
        }

        return false;
    }
}