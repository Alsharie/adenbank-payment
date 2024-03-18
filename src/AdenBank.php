<?php

namespace Alsharie\AdenBankPayment;


use Alsharie\AdenBankPayment\Helpers\AdenBankAuthHelper;
use Alsharie\AdenBankPayment\Responses\AdenBankCheckApproveResponse;
use Alsharie\AdenBankPayment\Responses\AdenBankErrorResponse;
use Alsharie\AdenBankPayment\Responses\AdenBankInitPaymentResponse;
use Alsharie\AdenBankPayment\Responses\AdenBankLoginResponse;

class AdenBank extends AdenBankAttributes
{


    /**
     * login into the gateway to get the token
     * @return AdenBankErrorResponse|AdenBankLoginResponse
     */
    public function login()
    {
        // set `username`, and `token` .

        $this->setAuthAttributes();
        $request = [
            'headers' => $this->headers,
            'attributes' => $this->attributes,
        ];

        try {
            $response = $this->sendRequest(
                $this->getLoginPath(),
                $this->attributes,
                $this->headers,
                $this->security
            );


            $response = new AdenBankLoginResponse((string)$response->getBody(), $request);
            AdenBankAuthHelper::setAuthToken($response->getToken());
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new AdenBankErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode(), $request);
        } catch (\Exception $e) {
            return new AdenBankErrorResponse($e->getTraceAsString(), $e->getCode(), $request);
        }
    }

    /**
     * It Is used to allow the merchant to initiate a payment for a specific customer.
     * @return AdenBankInitPaymentResponse|AdenBankErrorResponse
     */
    public function paymentRequest()
    {
        // set header info
        $this->setAuthorization();
        $this->generateMerchantToken();
        $request = [
            'headers' => $this->headers,
            'attributes' => $this->attributes,
        ];
        if (!isset($this->attributes['currency'])) {
            $this->attributes['currency'] = 'YER';//rial Yemeni
        }

        if (!isset($this->attributes['notes'])) {
            $this->attributes['notes'] = '';
        }


        try {
            $response = $this->sendRequest(
                $this->getPaymentRequestPath(),
                $this->attributes,
                $this->headers,
                $this->security
            );

            return new AdenBankInitPaymentResponse((string)$response->getBody(), $request);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new AdenBankErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode(), $request);
        } catch (\Exception $e) {
            return new AdenBankErrorResponse($e->getTraceAsString(), $e->getCode(), $request);
        }
    }


    /**
     * It is used to confirm the initPayment request
     * @return AdenBankCheckApproveResponse|AdenBankErrorResponse
     */
    public function approvePayment()
    {

        $this->setAuthorization();
        $this->generateMerchantToken();

        $request = [
            'headers' => $this->headers,
            'attributes' => $this->attributes,
        ];

        try {
            $response = $this->sendRequest(
                $this->getApprovePaymentPath(),
                $this->attributes,
                $this->headers,
                $this->security,
            );

            return new AdenBankCheckApproveResponse((string)$response->getBody(), $request);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new AdenBankErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode(), $request);
        } catch (\Exception $e) {
            return new AdenBankErrorResponse($e->getTraceAsString(), $e->getCode(), $request);
        }
    }


    /**
     * It is used to check the state of an operation ( It is useful in cases of time out).
     * @return AdenBankCheckApproveResponse|AdenBankErrorResponse
     */
    public function checkTransactionStatus()
    {
        // set header info
        $this->setAuthorization();
        $this->generateMerchantToken();

        $request = [
            'headers' => $this->headers,
            'attributes' => $this->attributes,
        ];
        try {
            $response = $this->sendRequest(
                $this->getCheckTransactionPath(),
                $this->attributes,
                $this->headers,
                $this->security,
            );

            return new AdenBankCheckApproveResponse((string)$response->getBody(), $request);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return new AdenBankErrorResponse($e->getResponse()->getBody(), $e->getResponse()->getStatusCode(), $request);
        } catch (\Exception $e) {
            return new AdenBankErrorResponse($e->getTraceAsString(), $e->getCode(), $request);
        }
    }

}