<?php

namespace BhadraFoods\PhonePeV2;

use BhadraFoods\PhonePeV2\Contracts\PhonePePayment as PhonePePaymentContract;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PhonePePayment implements PhonePePaymentContract
{
    public function isConfigured(): bool
    {
        return (bool) (get_payment_setting('client_id', $this->getId())
            && get_payment_setting('client_secret', $this->getId())
            && get_payment_setting('client_version', $this->getId())
            && get_payment_setting('environment', $this->getId(), 'UAT'));
    }

    public function getId(): string
    {
        return 'phonepe_v2';
    }

    public function getDisplayName(): string
    {
        return 'PhonePe';
    }

    public function isSupportRefundOnline(): bool
    {
        return true;
    }

    public function supportedCurrencies(): array
    {
        return ['INR'];
    }

    public function generateTransactionId(): string
    {
        return (string) Str::uuid();
    }

    public function authorize(array $data, Request $request): array
    {
        if (! $this->isConfigured()) {
            return [
                'error' => true,
                'message' => trans('plugins/payment::payment.invalid_settings', ['name' => $this->getDisplayName()]),
            ];
        }

        if (! in_array($data['currency'], $this->supportedCurrencies(), true)) {
            return [
                'error' => true,
                'message' => __(
                    ":name doesn't support :currency. List of currencies supported by :name: :currencies.",
                    [
                        'name' => $this->getDisplayName(),
                        'currency' => $data['currency'],
                        'currencies' => implode(', ', $this->supportedCurrencies()),
                    ]
                ),
            ];
        }

        $transactionId = $this->generateTransactionId();
        $url = app(PhonePePaymentClient::class)->pay($data, $transactionId);

        if (! $url) {
            return [
                'error' => true,
                'message' => __('Failed to create payment request.'),
            ];
        }

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'charge_id' => $transactionId,
            'payment_channel' => $this->getId(),
            'status' => PaymentStatusEnum::PENDING,
            'customer_id' => $data['customer_id'],
            'customer_type' => $data['customer_type'],
            'payment_type' => 'direct',
            'order_id' => $data['order_id'],
            'metadata' => [
                'merchantOrderId' => $transactionId,
            ],
        ], $request);

        exit(header('Location: ' . $url));
    }

    public function refund(string $transactionId, float $amount, array $data = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'error' => true,
                'message' => trans('plugins/payment::payment.invalid_settings', ['name' => $this->getDisplayName()]),
            ];
        }

        $payment = Payment::query()
            ->where('charge_id', $transactionId)
            ->first();

        if (! $payment) {
            return [
                'error' => true,
                'message' => trans('plugins/phonepe-v2::phonepe.refund.payment_not_found'),
            ];
        }

        if ($amount <= 0 || $amount > (float) $payment->amount) {
            return [
                'error' => true,
                'message' => trans('plugins/phonepe-v2::phonepe.refund.invalid_amount'),
            ];
        }

        $merchantRefundId = 'refund-' . Str::uuid();

        $response = app(PhonePePaymentClient::class)->refund(
            $merchantRefundId,
            $payment->charge_id,
            $amount,
        );

        if (is_string($response)) {
            return [
                'error' => true,
                'message' => $response,
            ];
        }

        $statusResponse = app(PhonePePaymentClient::class)->getRefundStatus($merchantRefundId);
        $state = $statusResponse?->getState() ?? $response->getState();

        return match ($state) {
            'COMPLETED' => [
                'error' => false,
                'message' => trans('plugins/phonepe-v2::phonepe.refund.completed'),
                'data' => $statusResponse?->jsonSerialize() ?? $response->jsonSerialize(),
            ],
            'PENDING' => [
                'error' => false,
                'message' => trans('plugins/phonepe-v2::phonepe.refund.pending'),
                'data' => $statusResponse?->jsonSerialize() ?? $response->jsonSerialize(),
            ],
            default => [
                'error' => true,
                'message' => trans('plugins/phonepe-v2::phonepe.refund.failed'),
                'data' => $statusResponse?->jsonSerialize() ?? $response->jsonSerialize(),
            ],
        };
    }

    public function refundOrder(string $paymentId, float|string $totalAmount, array $options = []): array
    {
        return $this->refund($paymentId, (float) $totalAmount, $options);
    }
}
