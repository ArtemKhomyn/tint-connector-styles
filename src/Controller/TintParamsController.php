<?php

namespace Drupal\ln_tint_connector_styles\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\Entity\Paragraph;


class TintParamsController extends ControllerBase {

  protected $entityTypeManager;

  protected $routeMatch;

  public function __construct(EntityTypeManagerInterface $entityTypeManager, RouteMatchInterface $routeMatch) {
    $this->entityTypeManager = $entityTypeManager;
    $this->routeMatch = $routeMatch;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_route_match'),
    );
  }


  public function preprocessPage($variables) {
    // Get the current node from the route parameters
    $node = $this->routeMatch->getParameter('node');

    // Get the current route name
    $route_name = $this->routeMatch->getRouteName();
    
    // Check if the route is the node edit form
    if ($route_name == 'entity.node.edit_form') {
      // Attach the library for the node edit form
      $variables['#attached']['library'][] = 'ln_tint_connector_styles/tint_api_edit_form';
    }

    // Ensure the node is an instance of NodeInterface
    if ($node instanceof NodeInterface) {
      $node = $variables['node'];
    }

    // Process paragraphs if the node exists
    if ($node) {
      foreach ($node->getFieldDefinitions() as $field_name => $field_definition) {
        if ($field_definition->getType() === 'entity_reference_revisions' && $field_definition->getSetting('target_type') === 'paragraph') {
          $paragraphs = $node->get($field_name)->referencedEntities();
          foreach ($paragraphs as $paragraph) {
            if ($paragraph instanceof Paragraph) {
              $paragraph_type = $paragraph->bundle();
              if ($paragraph_type === 'tint_component' || $paragraph_type === 'dsu_tint') {
                return $this->setTintParams($node, $variables, $field_name);
              }
            }
          }
        }
      }
    }
  }

  private function setTintParams($node, $variables, $fieldName) {
    // Load paragraphs of type 'dsu_tint'
    $paragraphStorage = $this->entityTypeManager->getStorage('paragraph');
    $paragraphsTintId = $paragraphStorage->getQuery()
      ->condition('type', 'dsu_tint')
      ->accessCheck(FALSE)
      ->execute();

    // Get the paragraphs attached to the node
    $nodeParagraphs = $node->get($fieldName)->getValue();
    $tintId = 0;

    // Find the TINT paragraph ID
    foreach ($nodeParagraphs as $item) {
      if (in_array($item['target_id'], $paragraphsTintId)) {
        $tintId = $item['target_id'];
        break;
      }
    }

    // Return if no TINT paragraph ID is found
    if (!$tintId) {
      return;
    }

    // Load the TINT paragraph entity
    $tintParagraph = Paragraph::load($tintId);
    if (!$tintParagraph) {
      return;
    }
    $tintParagraphSC = $tintParagraph->get('field_styles_connector')?->value;
    // Get TINT paragraph settings
    $tintParagraphKey = $tintParagraph->get('field_c_settings')?->value['tint_id'] ?? NULL; // Add null check here
    if ($tintParagraph && $tintParagraph->get('field_tint_customizations')) {
      $tintParagraph = $tintParagraph->get('field_tint_customizations')->entity;
      if (!$tintParagraph) {
        return;
      }

      // Process CTA posts if available
      if ($tintParagraph->get('field_cta_for_post')) {
        $ctaPostsIds = $tintParagraph->get('field_cta_for_post')->getValue();
        $ctaPostTargetIds = [];
        $ctaPosts = NULL;
        $ctaPostValue = [];

        foreach ($ctaPostsIds as $key => $value) {
          $ctaPostTargetIds[] = $value['target_id'];
        }

        if (count($ctaPostTargetIds) >= 1) {
          $ctaPosts = $paragraphStorage->loadMultiple($ctaPostTargetIds);
        }

        if ($ctaPosts) {
          foreach ($ctaPosts as $key => $value) {
            $link_field = $value->get('field_cta_tint_item_link')->getValue();

            $link_text = NULL;
            $item_url = NULL;

            if (!empty($link_field)) {
              $link_text = $link_field[0]['title'];
              $uri = $link_field[0]['uri'];

              if (strpos($uri, 'entity:') === 0) {
                $item_url = Url::fromUri($uri)->toString();
              }
              else {
                $item_url = $uri;
              }
            }

            $array = [
              'post_id' => $value->get('field_field_id_t_of_post')->value,
              'link_text' => $link_text,
              'item_url' => $item_url,
            ];
            $ctaPostValue[] = $array;
          }
        }
      }

      // define ln_tint_connector module name and version
      $module_name = 'ln_tint_connector';
      $module_list = \Drupal::service('extension.list.module');
      $module_info = $module_list->getExtensionInfo($module_name);
      $module_version = isset($module_info['version']) ? $module_info['version'] : 'NA';
      $module_name = isset($module_info['name']) ? $module_info['name'] : 'NA';

      // Prepare API data with all settings
      $apiData = [
        'ln_tint_connector' => [
          'module_name' => $module_name,
          'module_version' => $module_version,
        ],
        'api_key' => $tintParagraphKey,
        'tint_custom_activate' => $tintParagraphSC['activate'] ? '1' : '0',
        'theme_color' =>  [
          'color' => $tintParagraphSC['config']['tabs']['theme_colors']['theme_color'],
        ],
        'overlay_bg' => [
          'color' => $tintParagraphSC['config']['tabs']['theme_colors']['bg_color'] ,
          'opacity' => $tintParagraphSC['config']['tabs']['theme_colors']['bg_opacity'] ,
        ],
        'overlay_text_color' =>  [
          'color' => $tintParagraphSC['config']['tabs']['theme_colors']['overlay_color'] ,
        ],
        'text_color' => [
          'color' => $tintParagraphSC['config']['tabs']['theme_colors']['text_color'],
        ],
        'popup_color' => [
          'color' => $tintParagraphSC['config']['tabs']['theme_colors']['popup_color']
        ],
        'target_blank' => $tintParagraphSC['config']['tabs']['general']['open_method'],
        'max_posts' => $tintParagraphSC['config']['tabs']['general']['posts'],
        'more_posts' => $tintParagraphSC['config']['tabs']['slider_posts']['load_more'],
        'share_button' => $tintParagraphSC['config']['tabs']['general']['button'] ,
        'template' => $tintParagraphSC['config']['tabs']['general']['field_tint_c_template'],
        'slides_in_row' => $tintParagraphSC['config']['tabs']['slider_posts']['slides_row'],
        'slider_autoscroll' => $tintParagraphSC['config']['tabs']['slider_posts']['autoscroll'],
        'initial_posts_g' => $tintParagraphSC['config']['tabs']['slider_posts']['initial_posts'],
        'desktop_posts_g' => $tintParagraphSC['config']['tabs']['slider_posts']['initial_posts'],
        'mobile_posts_g' => $tintParagraphSC['config']['tabs']['slider_posts']['mobile_slides_row'] ,
        'initial_posts_t' => $tintParagraphSC['config']['tabs']['slider_posts']['initial_posts'] ,
        'desktop_posts_t' => $tintParagraphSC['config']['tabs']['slider_posts']['slides_row'],
        'mobile_posts_t' => $tintParagraphSC['config']['tabs']['slider_posts']['mobile_slides_row'],
        'more_posts_t' => $tintParagraphSC['config']['tabs']['slider_posts']['load_more'],
        'post_index_search' => $tintParagraphSC['post_index'],
        'cta_posts' => $ctaPostValue,
      ];

      // Attach the API data to Drupal settings
      if ($tintParagraphSC['activate']) {
        $variables['#attached']['library'][] = 'ln_tint_connector_styles/tint_api_component';
      }
      $variables['#attached']['drupalSettings']['tintComponent'] = $apiData;
      return $variables;

    }
  }
}

