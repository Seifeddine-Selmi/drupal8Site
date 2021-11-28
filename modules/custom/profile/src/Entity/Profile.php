<?php 
namespace Drupal\profile\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the profile entity class.
 * https://www.drupal.org/docs/8/api/entity-api/structure-of-an-entity-annotation
 * 
 * The base table name here is plural, despite Drupal table naming standards,
 * because "profile" is a reserved word in many databases.
 *
 * @ContentEntityType(
 *   id = "profile",
 *   label = @Translation("Profile"),
 *   handlers = {
 *     "list_builder" = "Drupal\profile\ProfileListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "default" = "Drupal\profile\Form\ProfileEntityForm",
 *       "add" = "Drupal\profile\Form\ProfileEntityForm",
 *       "edit" = "Drupal\profile\Form\ProfileEntityForm"
 *     },
 *   },
 *   admin_permission = "administer",
 *   base_table = "profile",
 *   data_table = "profile_field_data",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "profile_id",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *      "add-form" = "/profile/add",
 *     "canonical" = "/profile/{profile}",
 *     "edit-form" = "/profile/{profile}/edit",
 *     "collection" = "/admin/profile",
 *   },
 * )
 */
class Profile extends ContentEntityBase implements ProfileInterface {
    
    // https://www.drupal.org/docs/drupal-apis/entity-api/creating-a-content-entity-type-in-drupal-8
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
        $fields = [];

        // Standard field, used as unique if primary index.
        if ($entity_type->hasKey('id')) {
            $fields['profile_id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('Profile ID.'))
            ->setReadOnly(TRUE)
            ->setSetting('unsigned', TRUE);;
        }
      
        
        if ($entity_type->hasKey('uuid')) {
            $fields[$entity_type->getKey('uuid')] = BaseFieldDefinition::create('uuid')
            ->setLabel(new TranslatableMarkup('UUID'))
            ->setReadOnly(TRUE);
        }
       
        if ($entity_type->hasKey('langcode')) {
            $fields[$entity_type->getKey('langcode')] = BaseFieldDefinition::create('language')
            ->setLabel(new TranslatableMarkup('Language'))
            ->setDisplayOptions('view', [
                'region' => 'hidden',
            ])
            ->setDisplayOptions('form', [
                'type' => 'language_select',
                'weight' => 2,
            ]);
            if ($entity_type->isRevisionable()) {
                $fields[$entity_type->getKey('langcode')]->setRevisionable(TRUE);
            }
            if ($entity_type->isTranslatable()) {
                $fields[$entity_type->getKey('langcode')]->setTranslatable(TRUE);
            }
        }
        

            $fields['gender'] = BaseFieldDefinition::create('list_string')
            ->setLabel(t('Gender'))
            ->setDescription(t('The gender of the Profile entity.'))
            ->setSettings(array(
                'allowed_values' => array(
                    'female' => 'female',
                    'male' => 'male',
                ),
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'list_default',
                'weight' => -4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'options_select',
                'weight' => -4,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
            

        
      
            $fields['first_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('First Name'))
            ->setDescription(t('The first name of the Profile entity.'))
            ->setSettings(array(
                'default_value' => '',
                'max_length' => 255,
                'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -5,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -5,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        
   
            $fields['last_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Last Name'))
            ->setDescription(t('The last name of the Profile entity.'))
            ->setSettings(array(
                'default_value' => '',
                'max_length' => 255,
                'text_processing' => 0,
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -5,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -5,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
     
            $fields['birth_date'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Birth date'))
            ->setDescription(t('The birth date of the Profile entity.'))
            ->setSetting('datetime_type', 'date')
            ->setRequired(TRUE)
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -5,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
  
            $fields['email'] = BaseFieldDefinition::create('email')
            ->setLabel(t('Email'))
            ->setDescription(t('Your email.'))
            ->setRequired(TRUE)
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -5,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -5,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
     


            $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));
            
   
        
      
            $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));
   
        
        return $fields;
        
        // The Profile entity type needs to be installed.
        // drush entity-updates
    }
}