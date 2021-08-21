<?php


namespace JLM\MonCash;


class Order
{
    private $orderId;
    private $amount;

    /**
     * Order constructor.
     * @param int $orderId
     * @param double $amount
     */
    public function __construct($orderId, $amount)
    {
        $this->setOrderId($orderId);
        $this->setAmount($amount);
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        if (!empty($orderId) && is_int($orderId)) {
            $this->orderId = $orderId;
        }
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        if (!empty($amount) && is_int($amount)) {
            $this->amount = $amount;
        }
    }

    public function toJSON()
    {
        return json_encode(
            array(
                "amount" => $this->getAmount(),
                "orderId" => $this->getOrderId()
            )
        );
    }

}