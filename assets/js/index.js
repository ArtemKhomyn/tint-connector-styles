(function ($, Drupal) {
    Drupal.behaviors.component_tint_init = {    
      attach: function (context, settings) { 

        // styled initial loader
        
        const loaderElement = document.querySelectorAll('.paragraph--type--tint-component .tint-api_out .loader')
        const tint_custon = settings?.tintComponent?.tint_custom_activate;

        if (tint_custon === '1') {
          const dsu_tint = document.querySelectorAll('.paragraph--type--dsu-tint .tint-social');

          dsu_tint.forEach(tint => {
            tint.style.display = 'none'
          })
        } else {
          const tint_customization = document.querySelectorAll('.paragraph--type--tint-component');

          tint_customization.forEach(tint => {
            tint.style.display = 'none'
          })
        }
        
        const theme_color = settings.tintComponent.theme_color.color;
        loaderElement.forEach(loader =>{
          loader.style.borderTop = `8px solid ${theme_color}`;
        })        
      }
    };
  })(jQuery, Drupal);


  

  
  
  
  