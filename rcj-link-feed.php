<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class RcjLinkFeedPlugin
 * @package Grav\Plugin
 */
class RcjLinkFeedPlugin extends Plugin
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onFormProcessed' => ['onFormProcessed', 0]
        ];
    }
    
    public function onFormProcessed(Event $event)
    {
        $form = $event['form'];
        $action = $event['action'];
        $params = $event['params'];


        switch ($form["name"]) {
            case 'form1':
            
            $headline = $form->data['title'];
            $link = $form->data['link'];
            $cat = $form->data['category'];
 
         if($cat!="default") $cat.="/default";
         $content = file_get_contents("user/pages/01.home/".$cat.".md");

if($action=="save"){
  //extract domain name from url
  $domain = parse_url($link);
  $domain = explode('.', $domain['host']);
  //exceptions that are solved by using first url part instead of second
  if($domain[1]=="com"||$domain[1]=="org"||$domain[1]=="substack") $domain[1]=$domain[0];

  $tag = "<span class='tags'><a href='/rcj/rcj-posts/tag:".$cat."' class='p-category'>".$domain[1]."</a></span>";

  //find where to place the headline by skipping to the third '---'
  $pos = strpos($content, "---", strpos($content, "---",3)+strlen("---"));
  $newcontnent = substr_replace($content,"---  \n  \n**[".($headline)."](".$link.")** ".$tag."  \n  \n",$pos,3);

  //rewrite the whole page including new headline
  $rewrite = file_put_contents("user/pages/01.home/".$cat.".md", $newcontnent);

  //$this->grav['log']->info('add link attempt:'.$rewrite);
}
//TODO
//sanatize inputs?
//sort out the tag vs source
//see if there is 10 articles in list. if so remove bottom one

          break;
        case "form2":
$this->grav['log']->info("feedback form submitted: ".$form->data['name']." ".$form->data['suggestion']);
          break;
        default:
$this->grav['log']->info("something else happened!");
        }
    }
}
