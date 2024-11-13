<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Images;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HotelPageController extends Controller
{
    public function index(Hotel $hotel) {
        $hotel->viewsCount = $hotel->viewsCount + 1;
        $hotel->save();
        $options = [];

        foreach ($hotel->options as $option) {
            $options[] = $option;
        }

        $records2 = Images::where('table', 'hotels')->where('table_id', $hotel->id)->get();

        $imgs = [];
        foreach ($records2 as $index => $item) {
            $imgs[$index]['img'] = $item->img;
            $imgs[$index]['thumb'] = $item->img;//$item->thumb_img;
        }



        $social = $hotel->social;

        $phone = HotelPageController::formatPhoneNumber($hotel->number);
        $phoneNumber = $hotel->number;

        $places = $hotel->places;

        $favorite = false;

        if(Auth::user()) {
            if(count(Favorite::where('user_id', Auth::user()->id)->where('table_name', $hotel->getTable())->where('item_id', $hotel->id)->get()) == 0) {
                $favorite = false;
            } else {
                $favorite = true;
            }
        }

        return view('pages.indexHotel', compact('hotel', 'options', 'imgs', 'places', 'phone', 'social', 'phoneNumber', 'favorite'));
    }

    function formatPhoneNumber($phone) {
        // Убираем все нецифровые символы
        $phone = str_replace('/\D/g', '', $phone);

        // Форматируем по шаблону +_ (__) ___ __ __
        $format = '+_ (___) ___ __ __';

        $formatted = '';
        $index = 0;

        $chars = str_split($format);

        foreach($chars as $char) {
            if ($char === '_') {
                if ($index < strlen($phone)) {
                    $formatted .= $phone[$index++];
                } else {
                    break;
                }
            } else {
                $formatted .= $char;
            }
        }

        return $formatted;
    }
}
