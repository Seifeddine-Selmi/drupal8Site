<?php 

namespace Drupal\hello_drupal8\Controller;


use Drupal\Core\Controller\ControllerBase;;

class SayHelloToDrupal8 extends ControllerBase{
    
    
    public function hi(){
        return array (
            '#type' => 'markup',
            '#markup' => $this->t('Hello Drupal8'),
        );
    }
    
    public function hi_sir($your_name){
        return array (
            '#type' => 'markup',
            '#markup' => $this->t('Hello @name How Are You ?',
                ['@name'  => $your_name]
                ),
        );
    }
    
    
}