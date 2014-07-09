(function($) {
	
	$.entwine('colymba', function($) {
      
      $('td.galleryThumbnail').entwine({
        
        onmatch: function(){
          $(this).parents('table.ss-gridfield-table').addClass('galleryTheme');
          $(this).parents('table.ss-gridfield-table.galleryTheme').find('thead tr.sortable-header').empty().remove();
        }
        
      });      
      
  });
  
}(jQuery));