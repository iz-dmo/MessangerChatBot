<?php
  
namespace App\Http\Controllers;
  
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
  
class BatManController extends Controller
{
    
    public function handle()
    {
        $botman = app('botman');
        
        $botman->hears("hi",function($bot){
            $this->askOption($bot);
        });
        
        $botman->fallback(function($bot){
            $bot->reply('I have no idea what are you talking about.');
        });
       
        
        $botman->listen();
    }
  
  
    public function askOption($bot)
    {
       $question = Question::create("Hi sir, what are you looking for?")
                ->addButtons([
                Button::create("Order Now")->value('order'),
                Button::create("Show me more items")->value('items'),
            ]);
       $bot->reply($question,function(Answer $answer) use ($bot){
        if($answer->isInteractiveMessageReply()){
            $selectedValue = $answer->getValue();
            if($selectedValue === "order"){
                $bot->reply("Which items do you want to order?");
            }else{
                $bot->reply("Here is a list of our items..");
            }
        }
       });
    }

    
}