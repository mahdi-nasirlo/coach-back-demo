<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\CollectionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table("collections")->exists())
        {
            Collection::query()->truncate();
        }

        if (DB::table("collection_groups")->exists())
        {
            CollectionGroup::query()->truncate();
        }

        /**
         * collection groups
         */
         CollectionGroup::query()->create([
            "handle" => "coaches",
            "fa" => [
                "name" => "مربی",
            ],
            "en" => [
                "name" => "coach"
            ]
        ]);

        CollectionGroup::query()->create([
            "handle" => "product_physical",
            "fa" => [
                "name" => "محصولات فیزیکی",
            ],
            "en" => [
                "name" => "physical products"
            ]
        ]);

        CollectionGroup::query()->create([
            "handle" => "blog_post",
            "fa" => [
                "name" => "مقالات",
            ],
            "en" => [
                "name" => "posts"
            ]
        ]);
        /**
         * collection groups
         */

        /**
         * collections
         */
        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ فردی",
            ],
            "en" => [
                "name" => "Personal Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ عملکرد",
            ],
            "en" => [
                "name" => "Performance Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ زندگی",
            ],
            "en" => [
                "name" => "Life Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ رابطه",
            ],
            "en" => [
                "name" => "Relationship Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ موفقیت",
            ],
            "en" => [
                "name" => "Success Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ شغلی",
            ],
            "en" => [
                "name" => "Career Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ رابطه",
            ],
            "en" => [
                "name" => "Relationship Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ کسب و کار",
            ],
            "en" => [
                "name" => "Business Coaching"
            ]
        ]);

        Collection::query()->create([
            "collection_group_id" => 1,
            "sort" => 0,
            "fa" => [
                "name" => "کوچینگ کسب و کار دیجیتال",
            ],
            "en" => [
                "name" => "Digital Business Coaching"
            ]
        ]);

        Collection::query()->where("collection_group_id", 1)
            ->get()
            ->map(fn($item) => $item->update([
                "en" => [
                    "url" => "coaches"
                ],
                "fa" => [
                    "url" => "coaches"
                ]
            ]));
        /**
         * collections
         */
    }
}
