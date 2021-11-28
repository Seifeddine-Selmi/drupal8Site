<?php 
namespace Drupal\profile\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

class ProfileEntityForm extends ContentEntityForm{
    
    public function buildForm(array $form, FormStateInterface $form_state){
        $form = parent::buildForm($form, $form_state); // To get the form build from Profile baseFieldDefinitions
        $form['birth_date'] = array(
            '#title' => t('Birth Date'),
            '#type' => 'date',
            '#default_value' => format_date(time(), 'custom', 'Y-m-d'),
        );
        return $form;      
    }
    
    public function save(array $form, FormStateInterface $form_state){
        $entity = $this->getEntity();
        $entity->save();
        $form_state->setRedirect('entity.profile.collection'); // Route generate automatically
    }
    
}