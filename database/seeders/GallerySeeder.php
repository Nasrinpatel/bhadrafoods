<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Gallery\Database\Traits\HasGallerySeeder;

class GallerySeeder extends BaseSeeder
{
    use HasGallerySeeder;

    public function run(): void
    {
        $this->uploadFiles('galleries');

        $galleries = [
            [
                'name' => 'Perfect',
            ],
            [
                'name' => 'New Day',
            ],
            [
                'name' => 'Happy Day',
            ],
            [
                'name' => 'Nature',
            ],
            [
                'name' => 'Morning',
            ],
            [
                'name' => 'Photography',
            ],
        ];

        $descriptions = [
            'A stunning capture of natural beauty that showcases the perfect blend of light and shadow.',
            'This breathtaking moment frozen in time represents the essence of artistic photography.',
            'An exquisite composition that brings together vibrant colors and exceptional detail.',
            'A masterpiece of visual storytelling that speaks to the heart and soul of the viewer.',
            'Captured with precision and artistry, this image embodies the spirit of creative expression.',
            'A remarkable display of photographic excellence that transcends ordinary imagery.',
        ];

        $images = [];
        $index = 0;
        foreach ($this->getFilesFromPath('galleries') as $item) {
            $images[] = [
                'img' => $item,
                'description' => $descriptions[$index % count($descriptions)],
            ];
            $index++;
        }

        foreach ($galleries as $index => &$item) {
            $item['image'] = $this->filePath('galleries/' . ($index + 1) . '.jpg');
            $item['is_featured'] = true;
        }

        $this->createGalleries($galleries, $images);
    }
}
