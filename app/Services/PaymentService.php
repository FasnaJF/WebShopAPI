<?php

namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    private OrderService $orderService;
    private UserService $userService;
    private OrderProductService $orderProductService;

    public function __construct(
        OrderService $orderService,
        UserService $userService,
        OrderProductService $orderProductService
    ) {
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->orderProductService = $orderProductService;
    }


    public function createPayment($data)
    {
        $order_id = $data['id'];
        $user = $this->userService->getUserById(Auth::id());
        $amount = $this->orderProductService->getOrderAmount($order_id);

        $paymentRequestBody = [
            'json' => [
                'order_id' => (int)$order_id,
                'customer_email' => $user->email,
                'value' => $amount
            ]
        ];
        $client = new Client();
        $paymentService = config('payment.super_pay.base_url');
        try {
            $response = $client->get($paymentService, $paymentRequestBody);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $data = json_decode($response->getBody());
            if($data->message == config('payment.super_pay.service_unavailable')) {
                return 'Some internal error. Please try again';
            }
                return $response->getBody();
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            return $response->getBody();
        }

        $data = json_decode($response->getBody());
        if($data->message == config('payment.super_pay.insufficient_fund')){
            return 'Insufficient balance. Please recharge your account and try again.';
        }
        if($data->message == config('payment.super_pay.payment_successful')){

            $this->orderService->updateOrder($order_id,['paid'=>1]);
            return 'Payment Successful, thanks for purchasing.';
        }
        return $response->getBody();
    }


}
