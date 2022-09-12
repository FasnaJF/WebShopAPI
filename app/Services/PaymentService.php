<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    private UserService $userService;
    private OrderProductService $orderProductService;

    public function __construct(
        UserService $userService,
        OrderProductService $orderProductService
    ) {
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
                'order_id' => (int) $order_id,
                'customer_email' => $user->email,
                'value' => $amount,
            ],
        ];

        return $this->paymentRequest($paymentRequestBody);
    }

    private function paymentRequest($paymentRequestBody): \Psr\Http\Message\StreamInterface|string
    {
        $client = new Client();
        $paymentService = config('payment.super_pay.base_url');
        try {
            $response = $client->get($paymentService, $paymentRequestBody);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $data = json_decode($response->getBody());
            if ($data->message === config('payment.super_pay.service_unavailable')) {
                return 'Some internal error. Please try again';
            }
            return $response->getBody();
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
            return $response->getBody();
        }

        return $response->getBody();
    }
}
