<?php


namespace JLM\MonCash;

use JLM\MonCash\Utils\Constants;

class TransactionCaller
{
    private $orderObj;
    private Credentials $authObj; //Not tested Yet
    private $configArray;

    /**
     * TransactionCaller constructor.
     * @param $orderObj
     * @param $authObj
     * @param $configArray
     */
    public function __construct($orderObj, $authObj, $configArray)
    {
        $this->setOrderObj($orderObj);
        $this->setAuthObj($authObj);
        $this->setConfigArray($configArray);
    }

    /**
     * @return mixed
     */
    public function getOrderObj()
    {
        return $this->orderObj;
    }

    /**
     * @return mixed
     */
    public function getAuthObj()
    {
        return $this->authObj;
    }

    /**
     * @return array
     */
    public function getConfigArray()
    {
        return $this->configArray;
    }

    /**
     * @param mixed $orderObj
     */
    public function setOrderObj($orderObj)
    {
        if (!empty($orderObj)) {
            $this->orderObj = $orderObj;
        }
    }

    /**
     * @param mixed $authObj
     */
    public function setAuthObj($authObj)
    {
        if (!empty($authObj)) {
            $this->authObj = $authObj;
        }
    }

    /**
     * @param array $configArray
     */
    public function setConfigArray(array $configArray)
    {
        if (!empty($configArray) && is_array($configArray)) {
            $this->configArray = $configArray;
        }
    }

    public function getTransactionDetailsByTransactionId($transactionId)
    {
        $authInfos = $this->authObj->getAuthorizationInformations();
        $restEndpointSplit = explode("//", $this->getConfigArray()["rest_api_endpoint"]);

        $httpClient = new \GuzzleHttp\Client();
        try {
            $res = $httpClient->post(
                $restEndpointSplit[0] . "//" . $restEndpointSplit[1] . "" . Constants::$PAYMENT_TRANSACTION_URI,
                array(
                    "body" => json_encode(array(
                        "transactionId" => $transactionId
                    )),
                    "headers" => array(
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                        "Authorization" => "Bearer " . $authInfos["access_token"],
                        "Content-Type" => Constants::$HTTP_APPLICATION_JSON
                    )
                )
            );
            return json_decode($res->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            var_dump($e->getMessage());
        }

        return array();
    }

    public function getTransactionDetailsByOrderId()
    {
        $authInfos = $this->authObj->getAuthorizationInformations();
        $restEndpointSplit = explode("//", $this->getConfigArray()["rest_api_endpoint"]);
        $httpClient = new \GuzzleHttp\Client();
        try {
            $res = $httpClient->post(
                $restEndpointSplit[0] . "//" . $restEndpointSplit[1] . "" . Constants::$PAYMENT_ORDER_URI,
                array(
                    "body" => json_encode(array(
                        "orderId" => $this->orderObj->getOrderId()
                    )),
                    "headers" => array(
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                        "Authorization" => "Bearer " . $authInfos["access_token"],
                        "Content-Type" => Constants::$HTTP_APPLICATION_JSON
                    )
                )
            );
            return json_decode($res->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            var_dump($e->getMessage());

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            var_dump($e);
        }

        return array();
    }

    public static function getTransactionDetailsByOrderIdRequest(Order $orderObjValue, Credentials $authObjValue, $configArrayValue)
    {
        $callerObj = new TransactionCaller($orderObjValue, $authObjValue, $configArrayValue);
        $transactionRep = $callerObj->getTransactionDetailsByOrderId();

        if (!empty($transactionRep)) {
            $transactPayment = new TransactionPayment($transactionRep["payment"]);
            $trasanctDetails = new TransactionDetails(array(
                "path" => $transactionRep["path"],
                "payment" => $transactPayment,
                "timestamp" => $transactionRep["timestamp"],
                "status" => $transactionRep["status"],
            ));

            return $trasanctDetails;
        }

        return null;
    }

    public static function getTransactionDetailsByTransactionIdRequest($transactionId, Credentials $authObjValue, $configArrayValue)
    {
        $callerObj = new TransactionCaller(new Order("", ""), $authObjValue, $configArrayValue);
        $transactionRep = $callerObj->getTransactionDetailsByTransactionId($transactionId);

        $transactPayment = new TransactionPayment($transactionRep["payment"]);
        $trasanctDetails = new TransactionDetails(array(
            "path" => $transactionRep["path"],
            "payment" => $transactPayment,
            "timestamp" => $transactionRep["timestamp"],
            "status" => $transactionRep["status"],
        ));

        return $trasanctDetails;

    }

}