<?php

namespace BhadraFoods\PhonePeV2;

use BhadraFoods\PhonePeV2\Facades\PhonePePayment;
use Botble\Payment\Supports\PaymentHelper;
use Exception;
use Illuminate\Http\Request;
use PhonePe\common\exceptions\PhonePeException;
use PhonePe\payments\v2\models\request\builders\StandardCheckoutPayRequestBuilder;
use PhonePe\payments\v2\models\request\builders\StandardCheckoutRefundRequestBuilder;
use PhonePe\payments\v2\models\response\CallbackResponse;
use PhonePe\payments\v2\models\response\RefundStatusCheckResponse;
use PhonePe\payments\v2\models\response\StandardCheckoutRefundResponse;
use PhonePe\payments\v2\models\response\StatusCheckResponse;
use PhonePe\payments\v2\standardCheckout\StandardCheckoutClient;

class PhonePePaymentClient
{
    public function __construct(
        protected StandardCheckoutClient $paymentClient
    ) {
    }

    public function pay(array $data, string $transactionId): ?string
    {
        $orderId = $this->normalizeMetadataValue($data['order_id'] ?? $transactionId);
        $customerId = $this->normalizeMetadataValue($data['customer_id'] ?? '');

        $request = StandardCheckoutPayRequestBuilder::builder()
            ->merchantOrderId($transactionId)
            ->amount((int) round($data['amount'] * 100))
            ->redirectUrl(route('payment.phonepe-v2.callback', ['trans_id' => $transactionId]))
            ->message('Payment for order ' . $orderId)
            ->udf1($orderId)
            ->udf2($customerId)
            ->build();

        try {
            $response = $this->paymentClient->pay($request);

            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), $response->jsonSerialize());

            return $response->getRedirectUrl();
        } catch (PhonePeException $exception) {
            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), [
                'body' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    public function getStatus(string $transactionId, bool $withDetails = true, bool $throwable = false): ?StatusCheckResponse
    {
        $request = [
            'transaction_id' => $transactionId,
            'with_details' => $withDetails,
        ];

        try {
            $response = $this->paymentClient->getOrderStatus($transactionId, $withDetails);

            PaymentHelper::log(PhonePePayment::getId(), $request, $response->jsonSerialize());

            return $response;
        } catch (Exception $exception) {
            PaymentHelper::log(PhonePePayment::getId(), $request, [
                'body' => $exception->getMessage(),
            ]);

            if ($throwable) {
                throw $exception;
            }

            return null;
        }
    }

    public function verifyCallback(Request $request, bool $throwable = false): ?CallbackResponse
    {
        $logRequest = [
            'headers' => [
                'authorization' => $request->header('authorization'),
            ],
            'body' => $request->getContent(),
        ];

        try {
            $response = $this->paymentClient->verifyCallbackResponse(
                ['authorization' => (string) $request->header('authorization')],
                $request->getContent(),
                (string) get_payment_setting('callback_username', PhonePePayment::getId()),
                (string) get_payment_setting('callback_password', PhonePePayment::getId()),
            );

            PaymentHelper::log(PhonePePayment::getId(), $logRequest, $response->jsonSerialize());

            return $response;
        } catch (Exception $exception) {
            PaymentHelper::log(PhonePePayment::getId(), $logRequest, [
                'body' => $exception->getMessage(),
            ]);

            if ($throwable) {
                throw $exception;
            }

            return null;
        }
    }

    public function refund(string $merchantRefundId, string $originalMerchantOrderId, float $amount): StandardCheckoutRefundResponse|string
    {
        $request = StandardCheckoutRefundRequestBuilder::builder()
            ->merchantRefundId($merchantRefundId)
            ->originalMerchantOrderId($originalMerchantOrderId)
            ->amount((int) round($amount * 100))
            ->build();

        try {
            $response = $this->paymentClient->refund($request);

            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), $response->jsonSerialize());

            return $response;
        } catch (Exception $exception) {
            PaymentHelper::log(PhonePePayment::getId(), $request->jsonSerialize(), [
                'body' => $exception->getMessage(),
            ]);

            return $exception->getMessage();
        }
    }

    public function getRefundStatus(string $merchantRefundId, bool $throwable = false): ?RefundStatusCheckResponse
    {
        $request = [
            'merchant_refund_id' => $merchantRefundId,
        ];

        try {
            $response = $this->paymentClient->getRefundStatus($merchantRefundId);

            PaymentHelper::log(PhonePePayment::getId(), $request, $response->jsonSerialize());

            return $response;
        } catch (Exception $exception) {
            PaymentHelper::log(PhonePePayment::getId(), $request, [
                'body' => $exception->getMessage(),
            ]);

            if ($throwable) {
                throw $exception;
            }

            return null;
        }
    }

    protected function normalizeMetadataValue(mixed $value): string
    {
        if (is_array($value)) {
            return implode(',', array_map(fn (mixed $item) => $this->normalizeMetadataValue($item), $value));
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if ($value === null) {
            return '';
        }

        return (string) $value;
    }
}
