<?php

namespace BhadraFoods\Custom\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Rules\EmailRule;
use Botble\Base\Rules\PhoneNumberRule;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Events\SentContactEvent;
use Botble\Contact\Models\Contact;
use Botble\Contact\Services\ContactService;
use Botble\Ecommerce\Models\Product;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BulkOrderController extends PublicController
{
    public function send(Request $request, ContactService $contactService): BaseHttpResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'company_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', new PhoneNumberRule()],
            'email' => ['required', new EmailRule(), 'max:80'],
            'product_id' => ['required', 'integer', Rule::exists('ec_products', 'id')->where(fn ($query) => $query->where('status', 'published'))],
            'minimum_order_quantity' => ['required', 'numeric', 'min:1'],
            'quantity_in_kg' => ['required', 'numeric', 'gte:minimum_order_quantity'],
            'content' => ['required', 'string', 'max:10000'],
        ], [
            'quantity_in_kg.gte' => __('Quantity must be equal to or greater than the minimum order quantity.'),
        ]);

        $product = Product::query()->wherePublished()->select(['id', 'name'])->findOrFail($data['product_id']);

        if ($error = $contactService->validateBlacklistDomain($data['email'])) {
            return $this->response->setError()->setMessage($error);
        }

        if ($error = $contactService->validateBlacklistKeywords($data['content'])) {
            return $this->response->setError()->setMessage($error);
        }

        $contact = Contact::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => __('B2B / Bulk Order Inquiry'),
            'content' => $data['content'],
            'status' => ContactStatusEnum::UNREAD,
            'custom_fields' => array_filter([
                __('Company Name') => $data['company_name'],
                __('Product') => $product->name,
                __('Qty (kg)') => $data['quantity_in_kg'],
                __('MOQ (kg)') => $data['minimum_order_quantity'],
            ], fn ($value) => filled($value)),
        ]);

        event(new SentContactEvent($contact));

        return $this->response->setMessage(__('Your bulk order inquiry has been sent successfully.'));
    }
}
