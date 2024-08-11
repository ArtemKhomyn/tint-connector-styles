<?php

namespace Drupal\ln_tint_connector_styles\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'ln_tint_styles' field widget.
 *
 * @FieldWidget(
 *   id = "ln_tint_styles",
 *   label = @Translation("Tint Connector Styles Widget"),
 *   field_types = {
 *     "serialized_settings_item"
 *   },
 *   multiple_values = FALSE,
 * )
 */
class LnTintStylesWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element;

    // Adding vertical tabs wrapper
    $element['tabs'] = [
      '#type' => 'vertical_tabs',
      '#title' => $this->t('Tint Component Settings'),
    ];
    $element['value']['activate'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Activate TINT Component'),
      '#default_value' => $items->value['activate'],
    ];
    // Tab 1: General settings
    $element['value']['config'] = [
      '#type' => 'details',
      '#title' => $this->t('Tint Config'),
    ];
    // Horizontal tabs within the vertical tab
    $element['value']['config']['tabs'] = [
      '#type' => 'horizontal_tabs',
      '#title' => $this->t('Settings'),
    ];
    // Horizontal sub-tab 1
    $element['value']['config']['tabs']['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General'),
      '#group' => 'horizontal_tabs',
      '#open' => TRUE,
    ];
    $element['value']['config']['tabs']['general']['field_tint_c_template'] = [
      '#title' => $this->t('Template'),
      '#type' => 'select',
      '#empty_option' => NULL,
      '#options' => ['grid' => 'Grid', 'slider' => 'Slider', 'tile' => 'Tile'],
      '#default_value' => $items->value['config']['tabs']['general']['field_tint_c_template'] ?? 'grid',
      '#required' => TRUE,
      '#attributes' => ['class' => ['tint-selector']],
    ];
    $element['value']['config']['tabs']['general']['posts'] = [
      '#type' => 'number',
      '#default_value' => $items->value['config']['tabs']['general']['posts'] ?? 50,
      '#title' => $this->t('Max Api Loaded Posts'),
    ];
    $element['value']['config']['tabs']['general']['button'] = [
      '#title' => $this->t('Share Button'),
      '#type' => 'select',
      '#options' => ['show' => 'Show', 'hide' => 'Hide'],
      '#empty_option' => NULL,
      '#default_value' => $items->value['config']['tabs']['general']['button'] ?? 'hide',
      '#required' => TRUE,
      '#attributes' => ['class' => ['tint-selector']],
    ];
    $element['value']['config']['tabs']['general']['open_method'] = [
      '#title' => $this->t('Link open method'),
      '#type' => 'select',
      '#options' => ['same_tab' => 'Same Tab', 'new_tab' => 'New Tab'],
      '#default_value' => $items->value['config']['tabs']['general']['open_method'] ?? NULL,
      '#required' => TRUE,
      '#attributes' => ['class' => ['tint-selector']],
    ];
    // Horizontal sub-tab 2
    $element['value']['config']['tabs']['theme_colors'] = [
      '#type' => 'details',
      '#title' => $this->t('Theme Colors'),
      '#group' => 'horizontal_tabs',
      '#open' => TRUE,
    ];
    $element['value']['config']['tabs']['theme_colors']['theme_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Theme Color'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['theme_color'] ?? NULL,
      '#required' => TRUE,
    ];

    $element['value']['config']['tabs']['theme_colors']['text_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Text Color'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['text_color'] ?? NULL,
      '#required' => TRUE,
    ];

    $element['value']['config']['tabs']['theme_colors']['bg_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Overlay BG'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['bg_color'] ?? NULL,
      '#required' => TRUE,
    ];

    $element['value']['config']['tabs']['theme_colors']['bg_opacity'] = [
      '#type' => 'number',
      '#title' => $this->t('Opacity BG'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['bg_opacity'] ?? 0.3,
      '#required' => TRUE,
      '#step' => 0.01,
      '#min' => 0,
      '#max' => 1,
    ];
    $element['value']['config']['tabs']['theme_colors']['overlay_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Overlay Text Color'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['overlay_color'] ?? NULL,
      '#required' => TRUE,
    ];

    $element['value']['config']['tabs']['theme_colors']['popup_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Popup Text Color'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['popup_color']?? NULL,
      '#required' => TRUE,
    ];

    // Horizontal sub-tab 2
    $element['value']['config']['tabs']['slider_posts'] = [
      '#type' => 'details',
      '#title' => $this->t('Config customizations'),
      '#group' => 'horizontal_tabs',
      '#open' => TRUE,
    ];
    $element['value']['config']['tabs']['slider_posts']['slides_row'] = [
      '#title' => $this->t('Desktop Posts in row'),
      '#type' => 'select',
      '#options' => ['1'=>'1', '1'=>'1',  '2'=>'2',  '3'=>'3', '4' => '4', '5' => '5'],
      '#default_value' => $items->value['config']['tabs']['slider_posts']['slides_row'] ?? NULL,
      '#required' => TRUE,
      '#attributes' => ['class' => ['tint-selector']],
    ];
    $element['value']['config']['tabs']['slider_posts']['autoscroll'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Slider autoscroll'),
      '#default_value' => $items->value['config']['tabs']['slider_posts']['autoscroll'],
    ];
    $element['value']['config']['tabs']['slider_posts']['initial_posts'] = [
      '#type' => 'number',
      '#title' => $this->t('Initial posts'),
      '#default_value' => $items->value['config']['tabs']['slider_posts']['initial_posts'] ?? 8,
      '#step' => 1,
      '#min' => 2,
    ];
    $element['value']['config']['tabs']['slider_posts']['mobile_slides_row'] = [
      '#title' => $this->t('Mobile Posts in row'),
      '#type' => 'select',
      '#options' => ['1' => '1', '2' => '2'],
      '#default_value' => $items->value['config']['tabs']['slider_posts']['mobile_slides_row'] ?? NULL,
      '#attributes' => ['class' => ['tint-selector']],
    ];
    $element['value']['config']['tabs']['slider_posts']['load_more'] = [
      '#title' => $this->t('Load More Posts'),
      '#type' => 'number',
      '#default_value' => $items->value['config']['tabs']['slider_posts']['load_more'] ?? 8,
      '#step' => 1,
      '#min' => 1,
      '#max' => 40,
    ];
    $element['value']['post_index'] = [
      '#type' => 'number',
      '#title' => $this->t('Post Index For Search'),
      '#default_value' => $items->value['config']['tabs']['theme_colors']['post_index'] ?? 1,
      '#required' => TRUE,
      '#step' => 1,
      '#min' => 0,
      '#max' => 1000,
      '#prefix' => '<div class="field--name-field-tint-post-index-search">',
      '#suffix' => '</div>',
    ];


    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getTargetBundle() == 'dsu_tint';
  }

}
