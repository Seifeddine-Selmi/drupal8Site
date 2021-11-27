<?php 
namespace Drupal\formd8v2\Form;

use Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class FormSubscribe extends FormBase{
    
    /**
     * Returns a unique string identifying the form.
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId(){
        return 'subscriber_form';
    }
    
    
    // Old Version 7 and 6
    // function subscribe_form();
    // function subscribe_form_validate();
    // function subscribe_form_submit();
    
    //https://api.drupal.org/api/drupal/namespace/Drupal!Core!Render!Element/8.2.x
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
       
        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('First Name'),
        //   '#default_value' => $node->title,
            '#size' => 60,
            '#maxlength' => 128,
          //  '#required' => TRUE,
        );
        
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Last Name'),
            //   '#default_value' => $node->title,
            '#size' => 60,
            '#maxlength' => 128,
            //  '#required' => TRUE,
        );
        
        $form['gender'] = [
            '#type' => 'select',
            '#title' => $this
            ->t('Select element'),
            '#options' => [
                'Male' => $this->t('Male'),
                'Female' => $this->t('Female'),
            ],
            '#required' => TRUE,
        ];
        
        $form['birth_date'] = array(
            '#type' => 'date',
            '#title' => $this->t('Birth Date'),
            '#default_value' => array('year' => 2020,'month' => 2,'day' => 15,),
        );
        
        $form['email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email'),
        );
        
        /* managed_file to save images in table file_managed*/
        $form['picture'] = array(
            '#type' => 'managed_file',
            '#title' => $this->t('Upload picture'),
            '#upload_location' => 'public://images/',
        );
        
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
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
        if(is_numeric($form_state->getValue('first_name'))){
            $form_state->setErrorByName('first_name', $this->t('Error, The first name must be a string'));
        }
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

        $picture = $form_state->getValue('picture');
        $file = File::load($picture[0]);  //$picture[0] id generate by drupal
        $profile_value = array(
            'first_name' => $form_state->getValue('first_name'),
            'last_name' => $form_state->getValue('last_name'),
            'gender' => $form_state->getValue('gender'),
            'birth_date' => strtotime($form_state->getValue('birth_date')),
            'email' => $form_state->getValue('email'),
            'fid' => $picture[0],
  
        );
        
        $file->setPermanent();
        $file->save();   
        /*SELECT * FROM drupal8site.file_managed order by fid desc;*/
        
        
        
        
        $query = \Drupal::database();
        $query->insert('profiles')
               ->fields($profile_value)
               ->execute();
        
               if(!is_null($query)){
                   $this->messenger()->addStatus($this->t(
                       'Your First Name number is @first_name <br>
                         Your Last Name number is @last_name  <br>
                         Your Gender is @gender  <br>
                         Your Birth Date is @birth_date  <br>
                         Your Email number is @email  <br>
                       ',
                       [
                           '@first_name' => $form_state->getValue('first_name'),
                           '@last_name' => $form_state->getValue('last_name'),
                           '@gender' => $form_state->getValue('gender'),
                           '@birth_date' => $form_state->getValue('birth_date'),
                           '@email' => $form_state->getValue('email')
                       ]
                       ));
               }
    }
}