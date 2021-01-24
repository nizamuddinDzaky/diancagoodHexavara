<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Image;
use App\Models\ProductVariant;
use App\Models\Promo;
use App\Models\Review;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Skincare',
                'slug' => 'sk',
                'image' => 'skincare.png'
            ],
            [
                'name' => 'Cosmetics',
                'slug' => 'co',
                'image' => 'cosmetics.png'
            ],
            [
                'name' => 'Masker Wajah',
                'slug' => 'ma',
                'image' => 'mask.png'
            ],
            [
                'name' => 'Starter Kit',
                'slug' => 'st',
                'image' => 'starter.png'
            ]
        ];

        $subcategories = [
            [
                'category_id' => 1,
                'name' => 'Serum',
                'slug' => 'serum'
            ],
            [
                'category_id' => 1,
                'name' => 'Sleeping Mask',
                'slug' => 'sleepmask'
            ],
        ];

        $brands = [
            [
                'name' => 'Somebymi',
                'slug' => 'somebymi'
            ],
        ];

        $products = [
            [
                'category_id' => 1,
                'subcategory_id' => 2,
                'brand_id' => 1,
                'name' => 'SOMEBYMI YUJA BRIGHTENING SLEEPING MASK',
                'slug' => 'sybsm',
                'description' => 'SOMEBYMI YUJA BRIGHTENING SLEEPING MASK 60 gr (ORIGINAL GUARANTEE)

                Perawatan Pemutih Spesial. Yuja (Citron) diekstrak dari Goheung dan efek pemutihnya akan memungkinkan Anda untuk memiliki kulit yang lebih cerah dan sehat. Melembabkan, Memutihkan Perawatan 2-in-1. Mengintensifkan efek pencerahan dengan memasok hidrasi. Aroma Yuja yang menenangkan Diekstrak dari 100% Yuja asli (citron), aroma membantu Anda untuk bersantai dari jauh di dalam tubuh Anda. Perawatan Tidur yang menyegarkan. Tekstur yang ringan dan formula yang menyerap cepat tidak akan meninggalkan noda pada bantal Anda.
                
                [FITUR]
                Produk fungsional ganda. Pemutih + Anti Kerut.
                Mencerahkan dan melembabkan kulit dengan 70% Ekstrak Goheung Yuja.
                Meningkatkan warna kulit dan mencerahkan kulit dengan Glutathione, Arbutin dan Resmelin.
                Menghidrasi kulit dengan Aquaxyl dan Fructan dan memberi vitalitas kulit dengan 10 jenis vitamin.
                
                [CARA PEMAKAIAN]
                1. Setelah membersihkan wajah dengan cleansing, oleskan ke wajah sebagai langkah terakhir dari rutinitas perawatan kulit malam dasar Anda, hindari area mata dan bibir.
                2. Ratakan ke seluruh wajah Anda.
                3. Cuci muka Anda keesokan paginya.
                
                [KANDUNGAN PRODUK]
                Citrus Junos Fruit Extract, Water, Butylene Glycol, Niacinamide, Glycerin, Panthenol, 1,2-Hexanediol, Simmondsia Chinensis (Jojoba) Seed Oil, Thuja Orientals Leaf Extract, Zanthoxylum Schinifolum Leaf Extract, Polygonum Cuspidatum root Extract, Mentha Piperita (Peppermint) leaf Extract, Mentha Aquatica Leaf Extract, Mentha Rotundifolia Leaf Extract, nelumbo Nucifera Flower Extract, Coptis Japonica Extract, Hippophae Rhamnodes Fruit Extract, Arbutin, Glutathione, Ascorbic Acid, Ascorbyl Glucoside, Biotin, Tocopherol, Cyanocobalamin, (-)-alpha-bisabolol, Ascorbyl Tetraisopalmitate, Menadione, Arginine, Trehalose, Madecassoside, Aenoside, Diphenylsiloxy Phenyl Trimethicone, Caprylyl Methicone, Inulin Lauryl Carbamate, Behenyl Alcohol, Sorbitan Oleate, Sorbitan Isostearate, Caprylyl/ Capryl Glucoside, Polyisobutene, Xanthan Gum, Carbomer, Acrylates/ C10-30 Alkyl Acrylate Crosspolymer, Dimethicone/ Phenyl Vinyl Dimethicone Crosspolymer, Benzyl Glycol, Ethylhexyglycerin, Raspberry Ketone, Disodium EDTA, Citrus Junos Peel Oil (3,000 ppm)
                
                ==========================
                
                *Setiap barang yang akan kami kirim selalu dicek dan dipastikan dalam kondisi baik dan tidak rusak. kerusakan paket setelah sampai di tangan pembeli bukan menjadi tanggung jawab kami.
                
                *setiap pengiriman product sudah termasuk packing menggunakan bubble wrap (gratis). 
                
                TIDAK MENJUAL BARANG YANG TIDAK ORIGINAL!
                
                -Dianca Goods-',
                'image' => 'yuja niacin brightening sleeping mask 1.png',
                'status' => 1,
                'is_featured' => 1,
                'promo' => 0
            ],
        ];

        $variants = [
            [
                'product_id' => 1,
                'name' => '60gr',
                'price' => 258000,
                'weight' => 60,
                'stock' => 125
            ],
            [
                'product_id' => 1,
                'name' => '100gr',
                'price' => 300000,
                'weight' => 100,
                'stock' => 100
            ]
        ];

        $images = [
            [
                'filename' => 'somebymi yuja niacin 1.png',
                'product_id' => 1
            ],
            [
                'filename' => 'somebymi yuja niacin 2.png',
                'product_id' => 1
            ],
            [
                'filename' => 'somebymi yuja niacin 3.png',
                'product_id' => 1
            ],
            [
                'filename' => 'somebymi yuja niacin 4.png',
                'product_id' => 1
            ],
            [
                'filename' => 'yuja niacin brightening sleeping mask 1.png.png',
                'product_id' => 1
            ],
        ];

        $reviews = [
            [
                'product_id' => 1,
                'customer_id' => 2,
                'text' => 'Barang udah sampe dan original, pacar juga seneng banget dibeliin ini',
                'rate' => 4.5,
                'status' => 1,
                
            ]
        ];

        Category::insert($categories);
        Subcategory::insert($subcategories);
        Brand::insert($brands);
        Product::insert($products);
        ProductVariant::insert($variants);
        Image::insert($images);
        Review::insert($reviews);
    }
}