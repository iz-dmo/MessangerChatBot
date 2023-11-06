<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;


class BatManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */

    
    public function __construct(){
        DriverManager::loadDriver(FacebookDriver::class);
    }

    public function Handle(Request $request)
    {
        $botman = app('botman');

        $botman->hears('GET_STARTED|hi|hello',function($bot){
            $bot->typesAndWaits(0.5);
            $bot->reply("Hello,I'm chatbot 🤖.If there is anything you want to talk to (Admin)👦🏻,leave your messages here.");
            $bot->reply(
                ButtonTemplate::create('Whom do you want to talk to?')
                    ->addButton(
                        ElementButton::create('Kitty Bot')
                            ->type('postback')
                            ->payload('bot')
                    )
                    ->addButton(
                        ElementButton::create("Admin AChw Ly")
                            ->type('postback')
                            ->payload('admin')
            ));
        });
        $botman->hears('bot',function($bot){
            $bot->reply('အခြောက်ကြီး""အခြောက်ကြီးမလို့ အခြောက်ကြီးခေါ်တာ ဘာဖြစ်လဲကွာ😵‍💫');
        });
        $botman->hears('admin',function($bot){
            $bot->reply("ငါနဲ့ကျမပြောဘူး🙄 သွားခေါ်ပေးမယ် ခဏစောင့်");
        });

        $botman->hears('image',function($bot){
            $attach = new Image('https://dfstudio-d420.kxcdn.com/wordpress/wp-content/uploads/2019/06/digital_camera_photo-1080x675.jpg');

            $message =OutgoingMessage::create('Hello World')->withAttachment($attach);

            $bot->reply($message);
        });
        
        $botman->hears('keyword',function($bot){
            $bot->typesAndWaits(2);
            $bot->reply('Yamete Kudasai');
        });

        $botman->fallback(function($bot){
            $bot->reply('Sorry,I have no idea for that command 🙇🏻‍♂️');
        });

        $botman->listen();
    }

   
}
