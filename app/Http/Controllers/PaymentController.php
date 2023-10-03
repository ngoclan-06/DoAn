<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Config;

use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = config('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential(
            $paypalConfig['client_id'],
            $paypalConfig['secret']
        ));
        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function getCheckout()
    {
        return view('frontend.payment.checkout');
    }

    public function postPayWithPayPal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Product Name')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('Product description')
            ->setItemList($itemList);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.status'))
            ->setCancelUrl(route('paypal.status'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
            return redirect()->to($payment->getApprovalLink());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Đã có lỗi xảy ra. Vui lòng thử lại ' . $e->getMessage());
        }
    }

    public function status(Request $request)
    {
        $paymentId = $request->get('paymentId');
        $payerId = $request->get('PayerID');
        $token = $request->get('token');

        if (!$paymentId || !$payerId || !$token) {
            return redirect()->route('home-user')->withErrors('Error processing PayPal payment');
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            if ($result->getState() === 'approved') {
                // Payment successful, save data or do other things
                return redirect()->route('home-user')->with('success', 'Payment completed successfully');
            } else {
                return redirect()->route('home-user')->withErrors('Payment was not completed successfully');
            }
        } catch (\Exception $e) {
            return redirect()->route('home-user')->withErrors('Error processing PayPal payment: ' . $e->getMessage());
        }
    }
}
