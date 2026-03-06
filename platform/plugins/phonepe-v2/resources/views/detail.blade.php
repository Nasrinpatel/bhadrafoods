@php
    /** @var $response \PhonePe\payments\v2\models\response\StatusCheckResponse */
@endphp

<x-core::form.fieldset class="mt-3">
    <x-core::datagrid>
        @if($response->getOrderId())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/phonepe-v2::phonepe.transaction_id') }}</x-slot:title>
                {{ $response->getOrderId() }}
            </x-core::datagrid.item>
        @endif

        @if($response->getAmount())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/phonepe-v2::phonepe.amount') }}</x-slot:title>
                {{ format_price($response->getAmount() / 100, 'INR') }}
            </x-core::datagrid.item>
        @endif

        @if($response->getState())
            <x-core::datagrid.item>
                <x-slot:title>{{ trans('plugins/phonepe-v2::phonepe.state') }}</x-slot:title>
                {{ $response->getState() }}
            </x-core::datagrid.item>
        @endif
    </x-core::datagrid>

    <div class="mt-3">
        <label class="form-label">
            {{ trans('plugins/phonepe-v2::phonepe.response') }}
        </label>
        <pre>{{ json_encode($response->jsonSerialize(), JSON_PRETTY_PRINT) }}</pre>
    </div>
</x-core::form.fieldset>
