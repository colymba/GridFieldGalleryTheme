(function($) {
	
	$.entwine('colymba', function($) {
      
      $('td.galleryThumbnail').entwine({
        
        onmatch: function(){
          $(this).parents('table.ss-gridfield-table').find('thead tr.sortable-header').empty().remove();
        }
        
      });
      
      $('tr.ss-gridfield-item').entwine({
        
        onmouseover: function(){
          $(this).find('td.col-buttons').show();
        },
        onmouseout: function(){
          $(this).find('td.col-buttons').hide();
        }
        
      });
      
      
  });
  
}(jQuery));