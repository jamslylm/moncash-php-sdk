<?php


namespace JLM\MonCash;


class PaymentDetails
{
    private $mode;
    private $path;
    private $payment_token;
    private $timestamp;
    private $status;
    private $redirect; //Not tested yet

    /**
     * PaymentDetails constructor.
     */
    public function __construct(array $paymentDetailsArrayValue)
    {
        $this->setMode($paymentDetailsArrayValue["mode"]);
        $this->setPath($paymentDetailsArrayValue["path"]);
        $this->setPaymentToken($paymentDetailsArrayValue["payment_token"]);
        $this->setTimestamp($paymentDetailsArrayValue["timestamp"]);
        $this->setStatus($paymentDetailsArrayValue["status"]);
//        $this->setRedirect($paymentDetailsArrayValue["redirect"]);
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getPaymentToken()
    {
        return $this->payment_token;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        if (!empty($mode)) {
            $this->mode = $mode;
        }
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        if (!empty($path)) {
            $this->path = $path;
        }
    }

    /**
     * @param mixed $payment_token
     */
    public function setPaymentToken($payment_token)
    {
        if (!empty($payment_token)) {
            $this->payment_token = $payment_token;
        }
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
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if (!empty($status)) {
            $this->status = $status;
        }
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        if (!empty($redirect)) {
            $this->redirect = $redirect;
        }
    }

}