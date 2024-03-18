<?php

namespace Alsharie\AdenBankPayment\Responses;


class AdenBankResponse
{
    protected $success = true;
    /**
     * Store the response data.
     *
     * @var array
     */
    protected $data = [];
    protected $request;

    /**
     * Response constructor.
     */
    public function __construct($response,$request)
    {
        $this->data = (array)json_decode($response, true);
        $this->request = $request;
    }


    /**
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @return array
     */
    public function body()
    {
        return $this->data;
    }

    public function getRequest(){
        return $this->request;
    }

    public function isSuccess()
    {
        if(isset($this->data['Status'])){
            return $this->data['Status'];
        }
        return false;

    }




    /**
     * Message ID associated with the payment
     * @return false|mixed
     */
    public function getMsgID()
    {
        if (!empty($this->data['msgID'])) {
            return $this->data['msgID'];
        }

        return false;
    }

    /**
     * The sent by Merchant Unique transaction ID
     * @return false|mixed
     */
    public function getRefNo()
    {
        if (!empty($this->data['refNo'])) {
            return $this->data['refNo'];
        }

        return false;
    }

    //Status
    public function getStatus()
    {
        if (!empty($this->data['Status'])) {
            return $this->data['Status'];
        }

        return false;
    }


    /**
     * Date and time of the payment transaction
     * @return false|mixed
     */
    public function getTraTime()
    {
        if (!empty($this->data['TraTime'])) {
            return $this->data['TraTime'];
        }

        return false;
    }

}