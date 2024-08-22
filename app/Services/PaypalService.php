<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Contracts\PaypalServiceContract;
use Gloudemans\Shoppingcart\Cart;
use Srmklive\PayPal\Services\PayPal;


class PaypalService implements PaypalServiceContract
{
    protected Paypal $paypalClient;

    public function __construct()
    {
        $this->paypalClient = app(Paypal::class);
        $this->paypalClient->setApiCredentials(config('paypal'));
        $this->paypalClient->setAccessToken($this->paypalClient->getAccessToken());
    }

    public function create(Cart $cart): string|null
    {
        $paypalOrder = $this->paypalClient->createOrder($this->buildOrderRequestData($cart));

        logs()->info('Paypal create order response:', [
            'response' => $paypalOrder
        ]);

        return $paypalOrder['id'] ?? null;
    }

    public function capture(string $vendorOrderId): TransactionStatus
    {
        $result = $this->paypalClient->capturePaymentOrder($vendorOrderId);

        return match($result['status']) {
            'COMPLETED', 'APPROVED' => TransactionStatus::Success,
            'CREATED', 'SAVED' => TransactionStatus::Pending,
            default => TransactionStatus::Cancelled
        };
    }

    protected function buildOrderRequestData(Cart $cart): array // array to send it further
    {
        $currencyCode = config('paypal.currency');
        $items = [];

        $cart->content()->each(function ($item) use (&$items, &$currencyCode) {
            $items[] = [ // 1 by 1 item from cart
                'name' => $item->name,
                'quantity' => $item->qty,
                'sku' => $item->model->SKU,
                'url' => url(route('products.show', $item->model)),
                'category' => 'PHYSICAL_GOODS',
                'unit_amount' => [
                    'value' => $item->price,
                    'currency_code' => $currencyCode,
                ],
                'tax' => [
                    'value' => round($item->price / 100 * $item->taxRate, 2),
                    'currency_code' => $currencyCode,
                ],
            ];
        });

        return [ // array with request to PayPal
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currencyCode,
                        'value' => $cart->total(),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->subtotal()
                            ],
                            'tax_total' => [
                                'currency_code' => $currencyCode,
                                'value' => $cart->tax()
                            ]
                        ]
                    ],
                    'items' => $items,
                ]
            ]
        ];
    }
}
