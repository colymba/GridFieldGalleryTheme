(function($) {
	
	$.entwine('colymba', function($) {
      
      $('td.galleryThumbnail').entwine({
        
        onmatch: function(){
          $(this).parents('table.ss-gridfield-table').addClass('galleryTheme');
          $(this).parents('table.ss-gridfield-table.galleryTheme').find('thead tr.sortable-header').empty().remove();
        },
        onunmatch: function(){}
        
      });

      $('td.col-bulkSelect input').entwine({
        
        onmatch: function(){},
        onunmatch: function(){},
        onchange: function()
        {
          if (this.is(':checked'))
          {
            this.parent('td').addClass('selected');
          }
          else{
            this.parent('td').removeClass('selected');
          }
        }
      });      
      
  });
  
}(jQuery));