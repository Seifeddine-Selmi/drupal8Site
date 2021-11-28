<?php 
namespace Drupal\profile\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Url;

/**
 *  Provides a form for deleting a profile entity
 *  @ingroup profile
 *  
 *  https://www.drupal.org/docs/drupal-apis/entity-api/creating-a-content-entity-type-in-drupal-8#s-srcformcontactdeleteformphp
 *  
 * @author seif
 *
 */
class ProfileEntityDeleteForm extends ContentEntityConfirmFormBase{
    
    
    /**
     * 
     * {@inheritDoc}
     * @see \Drupal\Core\Form\ConfirmFormInterface::getQuestion()
     */
    public function getQuestion(){
        return $this->t('Are you sure you want to delete %name entity ?', array('%name' => $this->entity->label()));
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Drupal\Core\Form\ConfirmFormInterface::getCancelUrl()
     * 
     *  If the delete command is canceled, return to the profile list.
     */
    public function getCancelUrl(){
        return new Url('entity.profile.collection');
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Drupal\Core\Entity\ContentEntityConfirmFormBase::getConfirmText()
     */
    public function getConfirmText() {
       return $this->t('Delete');
    }
    
    
    /**
     * 
     * {@inheritDoc}
     * @see \Drupal\Core\Entity\ContentEntityForm::submitForm()
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $entity = $this->getEntity();
        $entity->delete();
        
        // http://drupal8.local/admin/reports/dblog
        $this->logger('profile')->notice('@type: deleted %title.',
            array(
                '%title' => $this->entity->label(),
            ));
        // Redirect to term list after delete.
        $form_state->setRedirect('entity.profile.collection');
    }
}