<?php 
namespace Drupal\hello_drupal8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class ExampleController extends ControllerBase {
    
    /**
     * Returns a render-able array for a test page.
     */
    public function content() {
        $build = [
            '#markup' => $this->t('Hello World!'),
        ];
        return $build;
    }
    
}