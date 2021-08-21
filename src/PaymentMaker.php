<?php


namespace JLM\MonCash;

use GuzzleHttp\Client;
use JLM\MonCash\Utils\Constants;

class PaymentMaker
{
    private Order $orderObj;
    private Credentials $authObj; //Not tested Yet
    private $configArray;

    /**
     * PaymentMaker constructor.
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
     * @return mixed
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
        $this->orderObj = $orderObj;
    }

    /**
     * @param mixed $authObj
     */
    public function setAuthObj($authObj)
    {
        $this->authObj = $authObj;
    }

    /**
     * @param mixed $configArray
     */
    public function setConfigArray($configArray)
    {
        $this->configArray = $configArray;
    }

    public function makePayment()
    {
        $authInfos = $this->authObj->getAuthorizationInformations();
        $restEndpointSplit = explode("//", $this->getConfigArray()["rest_api_endpoint"]);

        $httpClient = new Client();
        try {
            $res = $httpClient->post(
                $restEndpointSplit[0] . "//" . $restEndpointSplit[1] . "" . Constants::$PAYMENT_CREATOR_URI,

                array(
                    "body" => json_encode(array(
                        "amount" => $this->orderObj->getAmount(),
                        "orderId" => $this->getOrderObj()->getOrderId(),
                    )),
                    "headers" => array(
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER,
                        Constants::$HTTP_AUTHORIZATION_HEADER => "Bearer " . $authInfos["access_token"],
                        Constants::$HTTP_CONTENT_TYPE_HEADER => Constants::$HTTP_APPLICATION_JSON
                    )
                )
            );

            return json_decode($res->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            var_dump($e->getMessage());
        }

        return array();
    }

    public static function makePaymentRequest(Order $orderObjValue, Credentials $authObjValue, $configArrayValue): PaymentDetails
    {
        $paymentObj = new PaymentMaker($orderObjValue, $authObjValue, $configArrayValue);
        $paymentInfos = $paymentObj->makePayment();
        $paymentToken = new PaymentToken($paymentInfos['payment_token']);

        $paymentDetails = new PaymentDetails(array(
            "mode" => $paymentInfos["mode"],
            "path" => $paymentInfos["path"],
            "payment_token" => $paymentToken,
            "timestamp" => $paymentInfos["timestamp"],
            "status" => $paymentInfos["status"]
        ));

        $paymentDetails->setRedirect($configArrayValue["redirect"] . "" . Constants::$GATE_WAY_URI . "?token=" . $paymentToken->getToken());

        return $paymentDetails;
        // var_dump($paymentObj->makePayment());
    }
}