<?php

namespace BhadraFoods\PhonePeV2\Http\Controllers;

use BhadraFoods\PhonePeV2\Facades\PhonePePayment;
use BhadraFoods\PhonePeV2\PhonePePaymentClient;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use Botble\Payment\Supports\PaymentHelper;
use Exception;
use Illuminate\Http\Request;

class PhonePeController extends BaseController
{
    public function callback(Request $request, PhonePePaymentClient $client)
    {
        $request->validate([
            'trans_id' => ['required', 'string', 'exists:payments,charge_id'],
        ]);

        $payment = Payment::query()
            ->where('charge_id', $request->string('trans_id')->toString())
            ->firstOrFail();

        try {
            $response = $client->getStatus($payment->charge_id, true, true);
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage($exception->getMessage() ?: __('Payment failed!'));
        }

        if (! $response) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        $status = $this->mapStatus($response->getState());

        $payment->update([
            'status' => $this->resolvePersistedStatus($payment->status, $status),
            'metadata' => array_merge($payment->metadata ?? [], [
                'status_check' => $response->jsonSerialize(),
            ]),
        ]);

        if ($status !== PaymentStatusEnum::COMPLETED) {
            return $this
                ->httpResponse()
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }

        return $this
            ->httpResponse()
            ->setNextUrl(PaymentHelper::getRedirectURL())
            ->setMessage(__('Payment successfully!'));
    }

    public function webhook(Request $request, PhonePePaymentClient $client)
    {
        if (! get_payment_setting('callback_username', PhonePePayment::getId()) || ! get_payment_setting('callback_password', PhonePePayment::getId())) {
            abort(400, 'PhonePe callback credentials are not configured.');
        }

        try {
            $response = $client->verifyCallback($request, true);

            $payload = $response->getPayload();
            $payment = Payment::query()
                ->where('charge_id', $payload->getMerchantOrderId())
                ->firstOrFail();

            $payment->update([
                'status' => $this->resolvePersistedStatus($payment->status, $this->mapStatus($payload->getState())),
                'metadata' => array_merge($payment->metadata ?? [], [
                    'callback' => $response->jsonSerialize(),
                ]),
            ]);

            return response()->noContent();
        } catch (Exception) {
            abort(400);
        }
    }

    protected function mapStatus(string $state): string
    {
        return match ($state) {
            'COMPLETED', 'SUCCESS' => PaymentStatusEnum::COMPLETED,
            'PENDING' => PaymentStatusEnum::PENDING,
            default => PaymentStatusEnum::FAILED,
        };
    }

    protected function resolvePersistedStatus(string $currentStatus, string $incomingStatus): string
    {
        return $currentStatus === PaymentStatusEnum::COMPLETED ? $currentStatus : $incomingStatus;
    }
}
