(function ($, Drupal, once) {
    Drupal.behaviors.component_tint_customize_datalayer = {    
      attach: function (context, settings) {    

        const ln_tint_connector_styles__is_active = settings.tintComponent.tint_custom_activate;

        if(ln_tint_connector_styles__is_active === '0') {
          return;
        }
        
        const ln_tint_connector_name = settings?.tintComponent?.ln_tint_connector?.module_name;
        const ln_tint_connector_version = settings?.tintComponent?.ln_tint_connector?.module_version;

        // On page load            
        $(once('paragraph--type--tint-component', '.paragraph--type--tint-component')).each(function(){
          
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event:"ugcEvent",
            eventCategory:"UGC",
            eventAction:"View UGC",
          });

          window.dataLayer.push({
            'event' : 'ugc_content_visibility',
            'event_name' : 'content_visibility',
            'content_id' : settings.ln_datalayer?.data?.content_id || 'NA',
            'content_name' : settings.ln_datalayer?.data?.content_name || 'NA',
            'module_name' : ln_tint_connector_name || 'NA',
            'module_version' : ln_tint_connector_version || 'NA',
          });
        });

        // On post click
        window.tintPostClickDl = function(currentPost) {
          const currentUrl = document.location.href;
          const userName = currentPost?.attributes?.author?.username;
          const postId = currentPost?.id;
          const postText = currentPost.attributes?.text;
          const postLink = currentPost?.attributes?.url;

          window.dataLayer.push({
            'event' : 'ugc_post_click',
            'event_name' : 'ugc_post_click',
            'link_classes' : userName || 'NA',
            'link_domain' : currentUrl || 'NA',
            'link_id' : postId || 'NA',
            'link_text' : postText || 'NA',
            'link_url' : postLink || 'NA',
            'module_name' : ln_tint_connector_name || 'NA',
            'module_version' : ln_tint_connector_version || 'NA',
          });
        };

        // On buy now button
        window.clickBuyNow = function(buttonData) {
          const currentUrl = document.location.href;
          const userName = currentPost?.attributes?.author?.username;
          const postId = currentPost?.id;

          window.dataLayer.push({
            'event' : 'ugc_tint_cta',
            'event_name' : 'ugc_tint_cta',
            'link_classes' : userName || 'NA',
            'link_domain' : currentUrl || 'NA',
            'link_id' : postId || 'NA',
            'link_text' : buttonData.text || 'NA',
            'link_url' : buttonData.link || 'NA',
            'module_name' : ln_tint_connector_name || 'NA',
            'module_version' : ln_tint_connector_version || 'NA',
          });
        };

        // On products click
        window.clickTintProducts = function(data) {

          window.dataLayer.push({
            'event' : 'ugc_buy_now_click',
            'event_name' : 'ugc_products_click',
            'link_text' : data?.productTitle || 'NA', 
            'link_id' : data?.productId || 'NA', 
            'link_product_sku' : data?.productSku || 'NA', 
            'link_url' : data?.url || 'NA',
            'module_name' : ln_tint_connector_name || 'NA',
            'module_version' : ln_tint_connector_version || 'NA',       
          });
        }   

        // Additional cta button        
        window.clickTintAdditionalCta = function(data) {
          const ctaUrl = data?.ctaUrl;
          const ctaId = data?.ctaId;
          const ctaText = data?.ctaText;
          
          window.dataLayer.push({
            'event' : 'ugc_additional_cta_click',
            'event_name' : 'ugc_additional_cta_click',
            'link_text' : ctaText || 'NA', 
            'link_id' : ctaId || 'NA', 
            'link_url' : ctaUrl || 'NA',
            'module_name' : ln_tint_connector_name || 'NA',
            'module_version' : ln_tint_connector_version || 'NA',       
          });
        }   
      }
    };
  })(jQuery, Drupal, once);