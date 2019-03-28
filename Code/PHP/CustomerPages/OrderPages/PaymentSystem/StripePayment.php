<?php

namespace PhpPot\Service;
require_once '../stripe-php/init.php';

use \Stripe\Stripe;
use \Stripe\Customer;
use \Stripe\ApiOperations\Create;
use \Stripe\Charge;

class StripePayment
{

    private $apiKey;

    private $stripeService;

    public function __construct()
    {
        // Uses config file to set the Stripe Secret Key and verify this key
        require_once "config.php";
        $this->apiKey = STRIPE_SECRET_KEY;
        $this->stripeService = new \Stripe\Stripe();
        $this->stripeService->setVerifySslCerts(false);
        $this->stripeService->setApiKey($this->apiKey);
    }

    // Adds customer to Customers tab in the Stripe Dashboard online
    public function addCustomer($customerDetailsAry)
    {
        
        $customer = new Customer();
        
        $customerDetails = $customer->create($customerDetailsAry);
        
        return $customerDetails;
    }

    // Function to charge the amount from the user's card and display this info in Stripe Dashboard online
    public function chargeAmountFromCard($cardDetails)
    {
        $customerDetailsAry = array(
            'email' => $cardDetails['email'],
            'source' => $cardDetails['token']
        );
        $customerResult = $this->addCustomer($customerDetailsAry);
        $charge = new Charge();
        $cardDetailsAry = array(
            'customer' => $customerResult->id,
            'amount' => $cardDetails['amount']*100 ,
            'currency' => $cardDetails['currency_code'],
            'description' => $cardDetails['description'],
            'metadata' => array(
                'table_number' => $cardDetails['table_number']
            )
        );
        $result = $charge->create($cardDetailsAry);

        return $result->jsonSerialize();
    }
}