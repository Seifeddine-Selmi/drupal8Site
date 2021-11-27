<?php 
namespace Drupal\queue\Form;

use Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class FormUnpublishNode extends FormBase{
    
    /**
     * Returns a unique string identifying the form.
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId(){
        return 'unpublish_node_forms';
    }
    

    /**
     * Form constructor.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     *
     * @return array
     *   The form structure.
     */
    public function buildForm(array $form, FormStateInterface $form_state){
        
        $node_storage = \Drupal::entityManager()->getStorage('node');
        $nodes =  $node_storage->loadMultiple();
        
        foreach ($nodes as $node){
            $content[$node->get('nid')->value]= $node->get('title')->value;
        }
        
        $form['node'] = array(
            '#type' => 'select',
            '#title' => $this->t('Node'),
            '#options' => $content,
            '#required' => TRUE,
        );
        
        $form['status'] = array(
            '#type' => 'select',
            '#title' => $this->t('Status'),
            '#options' => [
                true => $this->t('Publish'),
                false => $this->t('Unpublish'),
            ],
            '#required' => TRUE,
        );
        
      
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        );
        
        return $form;
    }
    
   
    
    /**
     * Form validation handler.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function validateForm(array &$form, FormStateInterface $form_state){
      
    }
    
    /**
     * Form submission handler.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function submitForm(array &$form, FormStateInterface $form_state){
        $node_storage = \Drupal::entityManager()->getStorage('node');
        $this->messenger()->addStatus($this->t(
            'The node @node will @status on text Queue Processing',
            [
                '@node' =>  $node_storage->load($form_state->getValue('node'))->get('title')->value ,
                '@status' => $form_state->getValue('status')==true ? 'Publish':'Unpublish',
            ]
            ));

        $data['nid'] = $form_state->getValue('node');
        $data['status'] = $form_state->getValue('status');
        $queue = \Drupal::queue('node_queue');
        $queue->createQueue();
        $queue->createItem($data);
    }
}