<?php

namespace Alsharie\AdenBankPayment;

use Alsharie\AdenBankPayment\Helpers\AdenBankAuthHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Psr\Http\Message\ResponseInterface;

class Guzzle
{
    /**
     * Store guzzle client instance.
     *
     * @var AdenBank
     */
    protected $guzzleClient;

    /**
     * AdenBank payment base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Store AdenBank payment endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * BaseService Constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $this->guzzleClient = new Client();

        $this->basePath = config('adenBank.url.base');
    }


    /**
     * @param $path
     * @param $attributes
     * @param $headers
     * @param array $security
     * @param string $method
     * @return ResponseInterface
     */
    protected function sendRequest($path, $attributes, $headers, $security = [], string $method = 'POST'): ResponseInterface
    {
        $retries = 0;
        $success = false;
        $_response = null;
        do {
            if (AdenBankAuthHelper::getAuthToken() == null && $path != $this->getLoginPath()) {
                $aden = new AdenBank();
                $aden->login();
            }
            $headers['Authorization'] = 'Bearer ' . AdenBankAuthHelper::getAuthToken();
            try {
                $_response = $this->guzzleClient->requestAsync(
                    $method,
                    $path,
                    [
                        'headers' => array_merge(
                            [
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ],
                            $headers
                        ),
                        'json' => $attributes,
                        ...$security
                    ]
                )->then(function ($response) {
                    return $response;
                })->wait();


                if ($_response->getStatusCode() == 200) {
                    return $_response;
                } else if (strpos(strtolower($_response->getBody()->getContents()), 'anonymous') !== false) {
                    if ($path !== $this->getLoginPath() &&
                        ($_response->getStatusCode() === 401 || $_response->getStatusCode() === 400)) {
                        // received 401, so we need to refresh the token
                        $aden = new AdenBank();
                        $aden->login();
                    }
                }

                $retries++;
            } catch (ConnectException $e) {
                // Log the exception message
                error_log($e->getMessage());

                // Throw the exception again
                throw $e;
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Handle client exceptions here
                error_log($e->getMessage());
                // You can decide to retry the request, throw the exception again, or handle it in another way
                // Throw the exception again
                throw $e;
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                // Handle request exceptions here
                error_log($e->getMessage());
                // You can decide to retry the request, throw the exception again, or handle it in another way
                // Throw the exception again
                throw $e;
            } catch (\Exception $e) {
                $retries++;
            }
        } while ($retries <= 2);

        if ($_response === null || $_response->getStatusCode() != 200) {
            throw new \Exception('Failed to get successful response after 2 retries');
        }
        return $_response;
    }


    protected function getLoginPath(): string
    {
        return $this->basePath . '/' . "auth/v1/auth";
    }


    protected function getPaymentRequestPath(): string
    {
        return $this->basePath . '/' . "Payment/Trn";
    }

    protected function getApprovePaymentPath(): string
    {
        return $this->basePath . '/' . "Payment/ApproveTras";
    }

    protected function getCheckTransactionPath(): string
    {
        return $this->basePath . '/' . "Payment/checkOperation";
    }


}