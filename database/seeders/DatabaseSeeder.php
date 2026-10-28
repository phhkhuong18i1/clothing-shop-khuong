<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\NewsArticle;
use App\Models\StoreSetting;
use App\Models\StoreSlide;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Hàng mới', 'slug' => 'new-arrivals', 'description' => 'Những thiết kế vừa có mặt tại studio.'],
            ['name' => 'Trang phục', 'slug' => 'clothing', 'description' => 'Phom dáng dễ mặc cho nhịp sống mỗi ngày.'],
            ['name' => 'Đồ dệt kim', 'slug' => 'knitwear', 'description' => 'Lớp áo mềm mại cho những ngày dịu mát.'],
            ['name' => 'Phụ kiện', 'slug' => 'accessories', 'description' => 'Điểm chạm cuối cùng cho bộ trang phục.'],
        ])->mapWithKeys(function (array $data): array {
            $category = Category::updateOrCreate(['slug' => $data['slug']], $data);

            return [$data['slug'] => $category];
        });

        $categories['tops'] = Category::updateOrCreate(['slug' => 'tops'], ['name' => 'Áo', 'description' => 'Áo sơ mi, áo kiểu và những lớp mặc hằng ngày.', 'parent_id' => $categories['clothing']->id]);
        $categories['bottoms'] = Category::updateOrCreate(['slug' => 'bottoms'], ['name' => 'Quần & váy', 'description' => 'Những phom dáng thoải mái để phối cùng tủ đồ.', 'parent_id' => $categories['clothing']->id]);

        $photo = fn (string $id, int $width = 900): string => "https://images.unsplash.com/{$id}?auto=format&fit=crop&w={$width}&q=85";
        $products = [
            [
                'sku' => 'AT-1001', 'slug' => 'ao-so-mi-linen-may', 'name' => 'Áo sơ mi Linen Mây', 'category' => 'tops',
                'price' => 890000, 'sale_price' => 790000, 'description' => 'Áo sơ mi linen thoáng nhẹ với phom dáng thư thái, dễ kết hợp từ ngày làm việc đến cuối tuần.',
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'], 'colors' => ['Trắng ngà', 'Xanh nhạt'], 'is_featured' => true, 'is_best_seller' => true,
                'images' => ['photo-1598554747436-c9293d6a588f', 'photo-1598033129183-c4f50c736f10', 'photo-1603252109303-2751441dd157'],
            ],
            [
                'sku' => 'AT-1002', 'slug' => 'ao-len-form-mem', 'name' => 'Áo len Form Mềm', 'category' => 'knitwear',
                'price' => 1490000, 'description' => 'Lớp len mỏng mềm mại, giữ phom đẹp và đủ nhẹ để đồng hành qua nhiều mùa.',
                'sizes' => ['S', 'M', 'L'], 'colors' => ['Màu yến mạch', 'Than chì'], 'is_featured' => true, 'is_best_seller' => true,
                'images' => ['photo-1576566588028-4147f3842f27', 'photo-1618354691373-d851c5c3a990', 'photo-1620799140408-edc6dcb6d633'],
            ],
            [
                'sku' => 'AT-1003', 'slug' => 'quan-ong-rong-an-nhien', 'name' => 'Quần ống rộng An Nhiên', 'category' => 'bottoms',
                'price' => 1290000, 'description' => 'Chất vải đứng phom, cạp vừa vặn và ống quần rộng thoải mái cho ngày dài năng động.',
                'sizes' => ['XS', 'S', 'M', 'L', 'XL'], 'colors' => ['Màu cát', 'Đen'], 'is_featured' => false, 'is_best_seller' => true,
                'images' => ['photo-1490114538077-0a7f8cb49891', 'photo-1473966968600-fa801b869a1a', 'photo-1509631179647-0177331693ae'],
            ],
            [
                'sku' => 'AT-1004', 'slug' => 'tui-vai-di-cho', 'name' => 'Túi vải Đi Chợ', 'category' => 'accessories',
                'price' => 550000, 'description' => 'Chiếc túi vải cotton bền chắc, rộng rãi cho những vật dụng cần thiết mỗi ngày.',
                'sizes' => ['Một cỡ'], 'colors' => ['Mộc tự nhiên'], 'is_featured' => false, 'is_best_seller' => false,
                'images' => ['photo-1590874103328-eac38a683ce7', 'photo-1544816155-12df9643f363', 'photo-1553062407-98eeb64c6a62'],
            ],
            [
                'sku' => 'AT-1005', 'slug' => 'vay-midi-nang', 'name' => 'Váy midi Nắng', 'category' => 'bottoms',
                'price' => 1390000, 'sale_price' => 1190000, 'description' => 'Váy midi rũ nhẹ với đường cắt tinh giản, cho vẻ ngoài nữ tính mà vẫn tự nhiên.',
                'sizes' => ['XS', 'S', 'M', 'L'], 'colors' => ['Kem', 'Nâu đất'], 'is_featured' => true, 'is_best_seller' => false,
                'images' => ['photo-1515886657613-9f3515b0c78f', 'photo-1539109136881-3be0616acf4b', 'photo-1483985988355-763728e1935b'],
            ],
            [
                'sku' => 'AT-1006', 'slug' => 'ao-khoac-cham-thu', 'name' => 'Áo khoác Chạm Thu', 'category' => 'new-arrivals',
                'price' => 1890000, 'description' => 'Áo khoác nhẹ với bảng màu trầm ấm, hoàn thiện vừa đủ cho những buổi sáng se mát.',
                'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['Nâu nhạt', 'Xanh rêu'], 'is_featured' => false, 'is_best_seller' => false,
                'images' => ['photo-1548126032-079a0fb0099d', 'photo-1529139574466-a303027c1d8b', 'photo-1544022613-e87ca75a784a'],
            ],
        ];

        foreach ($products as $productData) {
            $imageIds = $productData['images'];
            unset($productData['images']);
            $categorySlug = $productData['category'];
            unset($productData['category']);

            $product = Product::updateOrCreate(['sku' => $productData['sku']], [
                ...$productData,
                'category_id' => $categories[$categorySlug]->id,
                'stock_quantity' => 12,
                'is_published' => true,
            ]);

            foreach ($imageIds as $index => $imageId) {
                $product->images()->updateOrCreate(['sort_order' => $index], [
                    'image_path' => $photo($imageId),
                    'alt_text' => $product->name.' — ảnh '.($index + 1),
                    'is_primary' => $index === 0,
                ]);
            }
        }

        $articles = [
            ['title' => 'Chọn chất liệu tự nhiên cho tủ đồ mỗi ngày', 'slug' => 'chon-chat-lieu-tu-nhien', 'excerpt' => 'Một vài gợi ý nhỏ để chọn linen, cotton và len phù hợp với nhịp sống của bạn.', 'body' => "Chất liệu tốt bắt đầu từ cảm giác dễ chịu trên da. Linen thoáng mát cho ngày nắng, cotton mềm nhẹ để mặc thường xuyên, còn len mỏng giúp tạo thêm lớp khi thời tiết dịu xuống.\n\nHãy ưu tiên những món đồ dễ giặt, dễ phối và phù hợp với khí hậu nơi bạn sống. Một tủ đồ nhỏ nhưng được chọn kỹ sẽ đồng hành cùng bạn lâu hơn.", 'cover_image' => $photo('photo-1490481651871-ab68de25d43d', 1400)],
            ['title' => 'Ba cách phối một chiếc sơ mi linen', 'slug' => 'ba-cach-phoi-so-mi-linen', 'excerpt' => 'Từ ngày làm việc đến buổi hẹn cuối tuần, chiếc sơ mi quen thuộc có thể linh hoạt hơn bạn nghĩ.', 'body' => "Mặc cùng quần ống rộng để có vẻ ngoài thư thái. Sơ vin một phần với chân váy midi khi cần thêm nét chỉn chu. Hoặc khoác mở ngoài áo thun cotton cho những ngày muốn mặc nhiều lớp.\n\nChọn màu trung tính làm nền, rồi thêm điểm nhấn nhỏ bằng túi hoặc trang sức quen thuộc.", 'cover_image' => $photo('photo-1598554747436-c9293d6a588f', 1400)],
            ['title' => 'Phía sau một bảng màu tinh giản', 'slug' => 'phia-sau-bang-mau-tinh-gian', 'excerpt' => 'Vì sao những sắc độ tự nhiên luôn dễ kết hợp và ít bị giới hạn bởi mùa mốt?', 'body' => "Màu cát, trắng ngà, nâu đất và xanh dịu có thể kết hợp với nhau theo nhiều cách. Bảng màu này giúp mỗi món đồ dễ dàng tìm được bạn đồng hành trong tủ đồ.\n\nThay vì mua theo xu hướng ngắn hạn, hãy chọn sắc độ khiến bạn muốn mặc lại nhiều lần.", 'cover_image' => $photo('photo-1483985988355-763728e1935b', 1400)],
        ];
        foreach ($articles as $index => $article) {
            NewsArticle::updateOrCreate(['slug' => $article['slug']], [...$article, 'is_published' => true, 'published_at' => now()->subDays($index + 1)]);
        }

        $slides = [
            ['eyebrow' => 'Bộ sưu tập mới · Thu đông', 'title' => 'Mặc nhẹ nhàng, sống trọn vẹn.', 'description' => 'Phom dáng dễ chịu, chất liệu tự nhiên và những gam màu khiến bạn muốn mặc mỗi ngày.', 'image' => 'photo-1539109136881-3be0616acf4b'],
            ['eyebrow' => 'Chất liệu được tuyển chọn', 'title' => 'Chạm vào sự thoải mái.', 'description' => 'Linen thoáng mát, len mềm và những thiết kế đồng hành cùng nhịp sống của bạn.', 'image' => 'photo-1485230895905-ec40ba36b9bc'],
            ['eyebrow' => 'Tủ đồ bền vững', 'title' => 'Ít hơn, nhưng đúng với bạn.', 'description' => 'Những món đồ vượt qua mùa mốt, để bạn luôn thấy mình trong từng lựa chọn.', 'image' => 'photo-1490481651871-ab68de25d43d'],
        ];
        foreach ($slides as $index => $slide) {
            StoreSlide::firstOrCreate(['title' => $slide['title']], [
                'eyebrow' => $slide['eyebrow'], 'description' => $slide['description'],
                'image_path' => $photo($slide['image'], 2200), 'link_label' => 'Khám phá bộ sưu tập',
                'link_url' => null, 'sort_order' => $index, 'is_active' => true,
            ]);
        }
        StoreSetting::firstOrCreate(['id' => 1], StoreSetting::defaults());
    }
}
