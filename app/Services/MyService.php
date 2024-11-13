<?php
namespace App\Services;

use App\Mail\RegisterMail;
use App\Models\Common;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Tinify\Tinify;
use Tinify\Exception;
use Tinify\Source;

class MyService
{
        public static function compress($imageBuffer, $method = 'fit', $width = null, $height = null){
        $to = Setting::where('key', 'back')->first();
        if(!$to)
            return $imageBuffer;
        $to = json_decode($to->content, true);
        if(empty($to['tinify'])){
            return $imageBuffer;
        }
        $api_key = $to['tinify'];
        // $api_key = "N9vnNxSjLy9wwTW9wnnLPGnkXBQ2ZdcD";
        $tinify = new Tinify();
        $tinify->setKey($api_key);
        try {
            Log::info(json_encode([
                'method' => $method, //scale, fit, cover, thumb
                'width' => $width,
                'height' => $height
            ]));
            // $source = $tinify->fromBuffer($imageBuffer);
            $source = Source::fromBuffer($imageBuffer);
            if ($width || $height) {
                $source = $source->resize([
                    'method' => $method, //scale, fit, cover, thumb
                    'width' => $width,
                    'height' => $height
                ]);
            }
            $compressed = $source->toBuffer();
            Log::info($compressed);
            return $compressed;
        } catch (Exception $e) {
            // Обработка ошибок
            return false;
        }
    }

    public static function sendSms(){
    }

    public static function compressImg($fileName, $request, $check, $w = 1290, $h = 518) {
        if(is_string($fileName)) {
            $file = $request->file($fileName);
        } else {
            $file = $fileName;
        }
        $imgDirectory = 'public/images';
        $imageBuffer = file_get_contents($file->getPathname());
        $compressed = MyService::compress($imageBuffer, "thumb", $w, $h);
        $newFileName = time() . '_' . $file->getClientOriginalName();
        $pp = public_path('images');
        $imgUrl = $pp . '/' . $newFileName;
        if(!$check) {
            $thumbNewFileName = time() . '_thumb_' . $file->getClientOriginalName();
            $imgThumbUrl = $pp . '/' . $thumbNewFileName;
            $compressed2 = MyService::compress($imageBuffer, "thumb", 390, 200);
            file_put_contents($imgThumbUrl, $compressed2);
            Storage::put($imgDirectory, $thumbNewFileName);
        }
        file_put_contents($imgUrl, $compressed);

        Storage::put($imgDirectory, $newFileName);
        if(!$check) {
            $fileArr = ['newFileName' => $newFileName, 'thumbNewFileName' => $thumbNewFileName];
        } else {
            $fileArr = ['newFileName' => $newFileName];
        }

        return $fileArr;
    }

    public static function getArray($strArr, $request) {
        foreach($request as $key => $value) {
            $keyarr = explode('_', $key);
            if(!empty(array_intersect($strArr, $keyarr))) {
                if($value !== null) {
                    $arr[$keyarr[1]][$keyarr[0]] = $value;
                    $arr[$keyarr[1]]['id'] = $keyarr[1];
                }
            }
        }
        if(isset($arr)) {
            return $arr;
        } else {
            return false;
        }
    }

    public static function getSvg(){
        $spritePath = public_path('/img/sprite.svg');
        $spriteContent = File::get($spritePath);
        preg_match_all('/<symbol\s+id="([^"]+)"/', $spriteContent, $matches);
        $symbolIds = $matches[1];
        return $symbolIds;
    }

    public static function transliterate($text) {
        // Массив соответствий для кириллических символов
        $transliterationTable = array(
            // Прописные буквы
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO',
            'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'KH', 'Ц' => 'TS', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SHCH', 'Ы' => 'Y',
            'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',

            // Строчные буквы
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y',
            'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
        );

        // Заменяем кириллические символы на латиницу
        return strtr($text, $transliterationTable);
    }

    public static function getFingerprint(){
        $ip = MyService::getClientIp();
        $userAgent = Request::header('User-Agent');

        // Получение других заголовков и данных
        $acceptLanguage = Request::header('Accept-Language');
        $acceptEncoding = Request::header('Accept-Encoding');
        $acceptCharset = Request::header('Accept-Charset');
        $connection = Request::header('Connection');
        $host = Request::header('Host');

        // Объединение всех данных для создания уникального фингерпринта
        $fingerprintString = implode('|', [
            $ip,
            $userAgent,
            $acceptLanguage,
            $acceptEncoding,
            $acceptCharset,
            $connection,
            $host
        ]);

        // Создание хеша для фингерпринта
        return hash('sha256', $fingerprintString);
    }

    static function getClientIp()
    {
        //.htaccess rule
        //RequestHeader set X-Real-IP "%{REMOTE_ADDR}s"

        // Попробуйте извлечь IP-адрес из заголовков
        $ip = Request::header('X-Forwarded-For');
        if ($ip) {
            $ip = explode(',', $ip)[0]; // Возьмите первый IP-адрес из списка
        } else {
            $ip = Request::header('X-Real-IP');
        }

        // Если IP не найден, используйте IP-адрес запроса
        return $ip ?: Request::ip();
    }

    public static function mailMessageAdmin($subject, $message){
        $to = Setting::where('key', 'back')->first();
        if(!$to)
            return;
        $to = json_decode($to->content, true);
        if(empty($to['mail'])){
            return;
        }
        $to = $to['mail'];

        MyService::mailMessage($to, $subject, $message);
    }
    public static function mailMessage($to, $subject, $message){
        try{
            // Mail::to($to)->send(new RegisterMail($message, $subject));
            // Mail::html($message, function ($msg) use ($to, $subject) {
            //     $msg->from('osobinca@osobinca.su')
            //         ->to($to)
            //         ->subject($subject);
            // });
            // $headers = array();
            // $headers['MIME-Version'] = 'MIME-Version: 1.0';
            // $headers['Content-type'] = 'text/html; charset=iso-8859-1';
            mail($to, $subject, $message);
            logger()->info("Email sent to: $to");
        }catch(\Exception $e){
            logger()->error("Send email:". $e->getMessage());
            return false;
        }
        return true;
    }
}
?>
