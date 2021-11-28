<?php 
namespace Drupal\profile;

use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;


class ProfileListBuilder extends EntityListBuilder {
    
    public function buildHeader(){
        $header['gender'] = t('Gender');
        $header['last_name'] = t('Last Name');
        $header['first_name'] = t('First Name');
       
        return $header + parent::buildHeader();
    }
    
    public function buildRow(EntityInterface $entity){
        $row['gender'] = $entity->gender->value;
        $row['last_name'] = $entity->last_name->value;
        $row['first_name'] = $entity->first_name->value;
        
        return $row + parent::buildRow($entity);
    }
    
    
}