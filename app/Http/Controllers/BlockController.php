<?php

namespace App\Http\Controllers;

use App\Models\BlocksNews;
use App\Services\MyService;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public static function setBlock($blocks, $news, $check) {
//        function getArray($strArr, $request) {
//            foreach($request as $key => $value) {
//                $keyarr = explode('_', $key);
//                if(!empty(array_intersect($strArr, $keyarr))) {
//                    if($value !== null) {
//                        $arr[$keyarr[1]][$keyarr[0]] = $value;
//                        $arr[$keyarr[1]]['id'] = $keyarr[1];
//                    }
//                }
//            }
//            if(isset($arr)) {
//                return $arr;
//            } else {
//                return false;
//            }
//        }

        // $blockArr = MyService::getArray(['blockName', 'editordata', 'blockSignature', 'blockImg', 'blockOldImg'], $request->all());


        // if($blockArr) {
        //     foreach ($blockArr as $key => $value) {
        //         if(isset($blockArr[$key]['blockImg'])) {
        //             unset($blockArr[$key]['blockOldImg']);
        //         } else {
        //             if(isset($blockArr[$key]['blockOldImg'])) {
        //                 $blockArr[$key]['blockImg'] = $blockArr[$key]['blockOldImg'];
        //                 unset($blockArr[$key]['blockOldImg']);
        //             }
        //         }
        //     }
        // }

        // if($blockArr) {
        //     foreach($blockArr as $key => $value) {
        //         if(isset($value['blockImg'])) {
        //             if(!is_string($value['blockImg'])) {
        //                     $fileArr = MyService::compressImg($value['blockImg'], $request, true);
        //                 $blockArr[$key]['blockImg'] = $fileArr['newFileName'];
        //             }
        //         }
        //     }
        // }
        if($check) {
            $blocksNews = $news->blocks->where('news_id', $news->id);
            if(isset($blocksNews[0])) {
                foreach ($blocksNews as $item) {
                    $item->delete();
                }
            }
        }
        $blockArr = json_decode($blocks, true);
        $blocks = [];
        if($blockArr) {
            $i = 0;
            foreach ($blockArr as $key => $value) {
                $blocks[$i] = new BlocksNews();
                $blocks[$i]->news_id = $news->id;
                if(isset($blockArr[$key]['title'])) {
                    $blocks[$i]['name'] = $blockArr[$key]['title'];
                }
                if(isset($blockArr[$key]['description'])) {
                    $blocks[$i]['description'] = $blockArr[$key]['description'];
                }
                if(isset($blockArr[$key]['signature'])) {
                    $blocks[$i]['signature'] = $blockArr[$key]['signature'];
                }
                if(isset($blockArr[$key]['img'])) {
                    $blocks[$i]['img'] = $blockArr[$key]['img'];
                }
                $i++;
            }
            $news->blocks()->saveMany($blocks);
        }
    }
}
