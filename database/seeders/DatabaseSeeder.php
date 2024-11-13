<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BlocksNews;
use App\Models\Favorite;
use App\Models\Hub;
use App\Models\News;
use App\Models\Hotel;
use App\Models\HotelOption;
use App\Models\HotelSocial;
use App\Models\Images;
use App\Models\Location;
use App\Models\Option;
use App\Models\Places;
use App\Models\Setting;
use App\Models\Social;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ru_RU');
        $user1 = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '71234567890',
            'role_id' => 1,
            'password' => Hash::make("admin"),
        ]);
        Location::create([
            'name' => 'Тверь',
            'putevoditel_po' => 'Тверской области',
            'icon' => 'tver',
            'btn_text' => 'Административный центр региона на пути из Москвы в Санкт-Петербург.',
            'seo_text' => 'Древний город на двух берегах Волги. Административный центр региона на пути из Москвы в Санкт-Петербург. Город, где 28 раз гостил Пушкин, родина знаменитого купца Афанасия Никитина и шансонье Михаила Круга.',
            'order' => 101,
        ]);
        Location::create([
            'name' => 'Ржев',
            'putevoditel_po' => 'Ржевской области',
            'icon' => 'rjov',
            'btn_text' => 'Административный центр региона на пути из Москвы в Санкт-Петербург.',
            'seo_text' => 'Место воинской славы и памяти подвигов жителей в годы Великой Отечественной войны.',
            'order' => 102,
        ]);
        Location::create([
            'name' => 'Конаково',
            'putevoditel_po' => 'Конаковской области',
            'icon' => 'konakovo',
            'btn_text' => 'Административный центр региона на пути из Москвы в Санкт-Петербург.',
            'seo_text' => 'Здесь древнерусская культура соседствуют с живописными пейзажами и богатой природой.',
            'order' => 103,
        ]);
        Location::create([
            'name' => 'Старица',
            'putevoditel_po' => 'Старицавской области',
            'icon' => 'starica',
            'btn_text' => 'Административный центр региона на пути из Москвы в Санкт-Петербург.',
            'seo_text' => 'Удивительная храмовая архитектура, застройка XIX века и старинные каменоломни.',
            'order' => 104,
        ]);
        Location::create([
            'name' => 'Торжок',
            'putevoditel_po' => 'Торжской области',
            'icon' => 'torjok',
            'btn_text' => 'Административный центр региона на пути из Москвы в Санкт-Петербург.',
            'seo_text' => 'Похож на Суздаль, только другой эпохи и совсем не избалованный туристами!',
            'order' => 105,
        ]);

        Hub::create([
            'name' => 'Что посмотреть',
            'location_id' => 1,
            'icon' => 'heart',
            'order' => 105,
            'seo_text' => 'null'
        ]);
        Setting::create([
            'key' => 'hubs.1',
            'content' => '{"title":null,"description":null,"article_id":"0","hubs":null,"img":"\/img\/content\/popular-touring\/tour-01.webp"}'
        ]);
        Hub::create([
            'name' => 'Чем занятся',
            'location_id' => 1,
            'icon' => 'heart',
            'order' => 106,
            'seo_text' => 'null'
        ]);
        Setting::create([
            'key' => 'hubs.2',
            'content' => '{"title":null,"description":null,"article_id":"0","hubs":null,"img":"\/img\/content\/popular-touring\/tour-02.webp"}'
        ]);
        Hub::create([
            'name' => 'Где поесть',
            'location_id' => 1,
            'icon' => 'heart',
            'order' => 107,
            'seo_text' => 'null'
        ]);
        Setting::create([
            'key' => 'hubs.3',
            'content' => '{"title":null,"description":null,"article_id":"0","hubs":null,"img":"\/img\/content\/popular-touring\/tour-03.webp"}'
        ]);
        Hub::create([
            'name' => 'Где остановится',
            'location_id' => 1,
            'icon' => 'heart',
            'order' => 108,
            'seo_text' => 'null'
        ]);
        Setting::create([
            'key' => 'hubs.4',
            'content' => '{"title":null,"description":null,"article_id":"0","hubs":null,"img":"\/img\/content\/popular-touring\/tour-01.webp"}'
        ]);
        Hub::create([
            'name' => 'Экскурсии',
            'location_id' => 1,
            'icon' => 'heart',
            'order' => 109,
            'seo_text' => 'null'
        ]);
        Setting::create([
            'key' => 'hubs.5',
            'content' => '{"title":null,"description":null,"article_id":"0","hubs":null,"img":"\/img\/content\/popular-touring\/tour-02.webp"}'
        ]);
        Tag::create([
            'name' => 'Парк',
            'type' => '0',
            'order' => 500,
        ]);
        Tag::create([
            'name' => 'Улицы',
            'type' => '1',
            'order' => 500,
        ]);
        Tag::create([
            'name' => 'Гостиницы',
            'type' => '2',
            'order' => 500,
        ]);
        $tags = [
            '0' => [
                "Отели Твери",
                "Хостелы Твери",
                "Апартаменты Твери",
                "Базы отдыха Твери",
                "Церкви Твери",
                "Кафе Твери",
            ],
            '1' => [
                "Чем заняться в Твери",
                "Что посмотреть в Твери",
            ],
            '2' => [
                "Достопримечательности Тверь",
                "Экскурсии твери",
            ],
        ];
        foreach($tags as $type => $names){
            foreach($names as $name){
                Tag::create([
                    'name' => $name,
                    'type' => strval($type),
                    'order' => 500,
                ]);
            }
        }
        $imgArr = ['/img/hero-slider/hero-01.png', '/img/hero-slider/hero-02.png', '/img/hero-slider/hero-03.png', '/img/news/news-01.png', '/img/news/news-02.png', '/img/news/news-03.png'];
        for ($i=0; $i<10; $i++) {
            $img = $faker->randomElement($imgArr);
            \App\Models\News::create([
                "location_id" => 1,
                "hub_id" => rand(1,5),
                "title" => $faker->sentence(5),
                "name" => $faker->sentence(2),
                "img" => $img,
                "thumbImg" => $img,
                "description" => $faker->paragraph(2),
                "coordinates" => '41.2123, 51.5632',
                "signature" => $faker->sentence(2),
                "data" => $faker->dateTime(),
                "type" => rand(0,10) > 5 ? '0' : '1',
                "author" => 1,
                "order" => 100,
                'views' => $faker->boolean,
                'likes' => $faker->boolean,
                'comments' => $faker->boolean,
                'viewsCount' => rand(99, 999),
            ]);
        }
        for ($i=1; $i<=10; $i++) {
            News::where('id', $i)->first()->tags()->sync([1,2,3]);
            for($a=1;$a<4;$a++) {
                BlocksNews::create([
                    'news_id' => $i,
                    'name' => $faker->sentence(5),
                    'description' => $faker->paragraph(2),
                    'img' => $faker->randomElement($imgArr),
                    'signature' => $faker->sentence(2)
                ]);
            }
        }

        Option::create([
            'name' => 'parking',
            'content' => 'Охраняемая парковка',
            'ico' => 'parking',
        ]);
        Option::create([
            'name' => 'wiFi',
            'content' => 'Wi-Fi',
            'ico' => 'wi-fi',
        ]);
        Option::create([
            'name' => 'transfer',
            'content' => 'Трансфер',
            'ico' => 'transfer',
        ]);
        Option::create([
            'name' => 'animals',
            'content' => 'Можно с животными',
            'ico' => 'animals',
        ]);
        Option::create([
            'name' => 'baggage',
            'content' => 'Поднос багажа',
            'ico' => 'baggage',
        ]);
        Option::create([
            'name' => 'servise',
            'content' => 'Обслуживание в номерах',
            'ico' => 'servise',
        ]);

        Social::create([
            'name' => 'dzen',
            'icon' => 'dzen'
        ]);

        Social::create([
            'name' => 'vk',
            'icon' => 'vk'
        ]);

        Social::create([
            'name' => 'telegram',
            'icon' => 'telegram'
        ]);

        Social::create([
            'name' => 'odnoklasniki',
            'icon' => 'odnoklasniki'
        ]);
        for($i=0; $i<100; $i++) {
            Hotel::create([
                'location_id' => 1,
                'hub_id' => rand(1,5),
                'name' => $faker->sentence(2),
                'title' => $faker->sentence(5),
                'reservation' => $faker->url(),
                'number' => $faker->phoneNumber,
                'email' => $faker->email(),
                'website' => $faker->url(),
                'description' => $faker->paragraph(5),
                'coordinates' => '41.2123, 51.5632',
                'price' => rand(1000,10000),
                'views' => $faker->boolean,
                'likes' => $faker->boolean,
                'comments' => $faker->boolean,
                'viewsCount' => rand(99,999),
                'likesCount' => rand(9,99),
                'commentsCount' => rand(1,19),
            ]);
        }
        $imgArr = ['/hotelImages/hotel1.jpg', '/hotelImages/hotel2.jpg','/hotelImages/hotel3.jpg','/hotelImages/hotel4.jpg','/hotelImages/hotel5.jpg','/hotelImages/hotel6.jpg','/hotelImages/hotel7.jpg','/hotelImages/hotel8.jpg'];
        $tgids = Tag::where('type', '0')->pluck('id')->toArray();
        for($i=0; $i<100; $i++) {
            shuffle($tgids);
            $arr = array_slice($tgids, 0, 3);
            Hotel::where('id', $i+1)->first()->tags()->sync($arr);
        }
        for($i=1; $i<=100; $i++) {
            for($a=0; $a<8; $a++) {
            $img = $faker->randomElement($imgArr);
                Images::create([
                    'table' => 'hotels',
                    'table_id' => $i,
                    'img' => $img,
                    'thumb_img' => $img
                ]);
            }
        }
        for($i=1; $i<=100; $i++) {
            HotelSocial::create([
                'hotels_id' => $i,
                'icon' => 'telegram',
                'link' => 'https://t.me/#'
            ]);
            HotelOption::create([
                'hotel_id' => $i,
                'option_id' => 1,
            ]);
            HotelOption::create([
                'hotel_id' => $i,
                'option_id' => 2,
            ]);
            Places::create([
                'hotels_id' => $i,
                'icon' => 'eat',
                'text' => '30м от ресторана "Вкусно и точка"'
            ]);
        }
        for($i = 0; $i<100; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'role_id' => 0,
                'permission_email' => 0,
                'permission_sms' => 0
            ]);
        }

        for($i = 1; $i<=100; $i++) {
            Favorite::create([
                'user_id' => $faker->numberBetween(1, 100),
                'table_name' => 'hotels',
                'item_id' => $faker->numberBetween(1, 100)
            ]);
        }
        foreach(Tag::all() as $tag){
            $tag->soundex = $tag->mySoundex($tag->name);
            $tag->save();
        }
        for($i = 0; $i < 5; $i ++){
            \App\Models\Comment::create([
                "user_id" => 1,
                "message" => $faker->sentence,
                "item_id" => 1,
                "table_name" => 'news',
            ]);
        }
        for($i = 0; $i < 50; $i ++){
            \App\Models\Like::create([
                "comment_id" => rand(1,5),
                "like" => rand(0,1) == 1,
                "user_id" => rand(1,100),
            ]);
        }
        for($i = 0; $i < 5; $i ++){
            \App\Models\Comment::create([
                "user_id" => 1,
                "message" => $faker->sentence,
                "item_id" => 2,
                "table_name" => 'news',
            ]);
        }
        for($i = 0; $i < 50; $i ++){
            \App\Models\Like::create([
                "comment_id" => rand(1,5)+5,
                "like" => rand(0,1) == 1,
                "user_id" => rand(1,100),
            ]);
        }
    }
}
