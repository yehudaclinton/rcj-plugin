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
        
//$this->grav['log']->info('debug '.$action.' f '.$form["name"]);


        switch ($form["name"]) {
            case 'form1':
            
            $headline = $form->data['title'];
            $link = $form->data['link'];
            $cat = $form->data['category'];
//$this->grav['log']->info('huda test0 '.$headline);
$content = file_get_contents("user/pages/01.home/default.md");


if($action=="save"){
$domain = parse_url($link);
$domain = explode('.', $domain['host']);

$tag = "<i class='fa fa-tags' aria-hidden='true'></i><span class='tags'><a href='/rcj/rcj-posts/tag:".$cat."' class='p-category'>".$domain[1]."</a></span>";

$newcontnent = str_replace("===", "===  \n  \n**[".($headline)."](".$link.")** ".$tag."  \n  \n", $content);

  $rewrite = file_put_contents("user/pages/01.home/default.md", $newcontnent);
  $this->grav['log']->info('add link attempt:'.$rewrite);
}
//TODO
//get article category in a proper place
//see if there is 10 articles in list. if so remove bottom one
//append link to top of article list

          break;
        case "form2":
$this->grav['log']->info("feedback form submitted: ".$form->data['name']." ".$form->data['suggestion']);
          break;
        default:
$this->grav['log']->info("something else happened!");
        }
    }
}
