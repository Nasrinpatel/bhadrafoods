<?php

namespace Botble\Ecommerce\Tests\Feature;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\BaseTestCase;
use Botble\Ecommerce\Models\Brand;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Ecommerce\Models\ProductCollection;
use Botble\Ecommerce\Supports\DiscountSupport;
use Botble\Ecommerce\Supports\EcommerceHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PerformanceOptimizationTest extends BaseTestCase
{
    use RefreshDatabase;

    public function test_discount_support_only_loads_categories_for_given_product_ids(): void
    {
        $product1 = Product::query()->create([
            'name' => 'Product 1',
            'price' => 100,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $product2 = Product::query()->create([
            'name' => 'Product 2',
            'price' => 200,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $category1 = ProductCategory::query()->create([
            'name' => 'Category 1',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $category2 = ProductCategory::query()->create([
            'name' => 'Category 2',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        DB::table('ec_product_category_product')->insert([
            ['product_id' => $product1->id, 'category_id' => $category1->id],
            ['product_id' => $product2->id, 'category_id' => $category2->id],
        ]);

        $discountSupport = new DiscountSupport();

        $reflection = new \ReflectionMethod($discountSupport, 'getProductCategoryIds');

        $categoryIds = $reflection->invoke($discountSupport, [$product1->id]);

        $this->assertContains($category1->id, $categoryIds);
        $this->assertNotContains($category2->id, $categoryIds);
    }

    public function test_discount_support_only_loads_collections_for_given_product_ids(): void
    {
        $product = Product::query()->create([
            'name' => 'Product 1',
            'price' => 100,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $otherProduct = Product::query()->create([
            'name' => 'Product 2',
            'price' => 200,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $collection = ProductCollection::query()->create([
            'name' => 'Collection 1',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $otherCollection = ProductCollection::query()->create([
            'name' => 'Collection 2',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        DB::table('ec_product_collection_products')->insert([
            ['product_id' => $product->id, 'product_collection_id' => $collection->id],
            ['product_id' => $otherProduct->id, 'product_collection_id' => $otherCollection->id],
        ]);

        $discountSupport = new DiscountSupport();

        $reflection = new \ReflectionMethod($discountSupport, 'getProductCollectionIds');

        $collectionIds = $reflection->invoke($discountSupport, [$product->id]);

        $this->assertContains($collection->id, $collectionIds);
        $this->assertNotContains($otherCollection->id, $collectionIds);
    }

    public function test_discount_support_caches_results_across_calls(): void
    {
        $product = Product::query()->create([
            'name' => 'Product 1',
            'price' => 100,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $category = ProductCategory::query()->create([
            'name' => 'Category 1',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        DB::table('ec_product_category_product')->insert([
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);

        $discountSupport = new DiscountSupport();
        $reflection = new \ReflectionMethod($discountSupport, 'getProductCategoryIds');

        $queryCount = 0;
        DB::listen(function () use (&$queryCount): void {
            $queryCount++;
        });

        $reflection->invoke($discountSupport, [$product->id]);
        $firstCallQueries = $queryCount;

        $queryCount = 0;
        $reflection->invoke($discountSupport, [$product->id]);
        $secondCallQueries = $queryCount;

        $this->assertGreaterThan(0, $firstCallQueries);
        $this->assertEquals(0, $secondCallQueries, 'Second call should use cached data, no DB queries');
    }

    public function test_discount_support_handles_product_with_no_categories(): void
    {
        $product = Product::query()->create([
            'name' => 'Product No Categories',
            'price' => 100,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $discountSupport = new DiscountSupport();
        $reflection = new \ReflectionMethod($discountSupport, 'getProductCategoryIds');

        $categoryIds = $reflection->invoke($discountSupport, [$product->id]);

        $this->assertEmpty($categoryIds);
    }

    public function test_brands_for_filter_returns_cached_results(): void
    {
        $brand = Brand::query()->create([
            'name' => 'Test Brand',
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        $product = Product::query()->create([
            'name' => 'Product',
            'price' => 100,
            'status' => BaseStatusEnum::PUBLISHED,
            'brand_id' => $brand->id,
            'is_variation' => 0,
        ]);

        Cache::flush();

        $helper = app(EcommerceHelper::class);

        $result1 = $helper->brandsForFilter();
        $result2 = $helper->brandsForFilter();

        $this->assertEquals($result1->count(), $result2->count());
        $this->assertTrue(Cache::has('brands_for_filter_' . md5(serialize([]))));
    }

    public function test_brands_for_filter_cache_varies_by_category(): void
    {
        Cache::flush();

        $helper = app(EcommerceHelper::class);

        $helper->brandsForFilter([]);
        $helper->brandsForFilter([1, 2]);

        $this->assertTrue(Cache::has('brands_for_filter_' . md5(serialize([]))));
        $this->assertTrue(Cache::has('brands_for_filter_' . md5(serialize([1, 2]))));
    }

    public function test_tags_for_filter_returns_cached_results(): void
    {
        Cache::flush();

        $helper = app(EcommerceHelper::class);

        $helper->tagsForFilter();

        $this->assertTrue(Cache::has('tags_for_filter_' . md5(serialize([]))));
    }

    public function test_tags_for_filter_cache_key_is_order_independent(): void
    {
        Cache::flush();

        $helper = app(EcommerceHelper::class);

        $helper->tagsForFilter([3, 1, 2]);

        $expectedKey = 'tags_for_filter_' . md5(serialize([1, 2, 3]));
        $this->assertTrue(Cache::has($expectedKey), 'Category IDs should be sorted before cache key generation');
    }
}
