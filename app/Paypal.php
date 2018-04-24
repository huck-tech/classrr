<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Paypal extends Model
{
    public function getPaymentForBooking($classroom, $classTotals, $booking, $discount = 0)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $transaction = $this->getTransaction($classroom, $classTotals, $discount);

        $baseUrl = route('payments_callback');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/?success=true")
            ->setCancelUrl("$baseUrl/?success=false&&booking_id=".$booking->id);

        $payment = new Payment();
        $payment->setIntent("authorize")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        return $payment;
    }

    public function getTransaction($classroom, $classTotals,  $discount = 0)
    {
        $description = 'Classroom "' . $classroom['title'] . '"';
        // $fee = 'Processing Fee (5%)';
        $fee = 'Processing Fee (0%)';
        // $price_before = $classTotals['price_before'];
        // $fee_price = $classTotals['price_before'] * 0.05;
        $fee_price = 0;
        $final_price = $classTotals['total_price'] - $discount;

        $item = new Item();

        $item->setName($description)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($final_price);

        $item2 = new Item();

        $item2->setName($fee)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($fee_price);

        $itemList = new ItemList();
        $itemList->setItems(array($item,$item2));

        $details = new Details();
        $details
            ->setSubtotal($final_price);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setDetails($details)
            ->setTotal($final_price);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($description);

        return $transaction;
    }
}
