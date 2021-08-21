<?php


namespace JLM\MonCash;

class TransactionDetails
{
    private $path;
    private $payment;
    private $timestamp;
    private $status;

    /**
     * TransactionDetails constructor.
     */
    public function __construct(array $transactionDetailsValue)
    {
        $this->setPath($transactionDetailsValue["path"]);
        $this->setPayment($transactionDetailsValue["payment"]);
        $this->setTimestamp($transactionDetailsValue["timestamp"]);
        $this->setStatus($transactionDetailsValue["status"]);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        if (!empty($path) && is_string($path)) {
            $this->path = $path;
        }
    }

    /**
     * @return mixed
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param mixed $payment
     */
    public function setPayment($payment)
    {
        if (!empty($payment)) {
            $this->payment = $payment;
        }
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        if (!empty($timestamp)) {
            $this->timestamp = $timestamp;
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if (!empty($status)) {
            $this->status = $status;
        }
    }


}