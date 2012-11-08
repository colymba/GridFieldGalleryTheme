(function($) {
	
	$.entwine('colymba', function($) {
      
      $('td.galleryThumbnail').entwine({
        
        onmatch: function(){
          $(this).parents('table.ss-gridfield-table').addClass('galleryTheme');
          $(this).parents('table.ss-gridfield-table.galleryTheme').find('thead tr.sortable-header').empty().remove();
        }
        
      });
      
      $('.galleryTheme tr.ss-gridfield-item').entwine({
        
        onmouseover: function(){
          $(this).find('td.col-buttons').show();
        },
        onmouseout: function(){
          $(this).find('td.col-buttons').hide();
        }
        
      });
      
      
  });
  
}(jQuery));