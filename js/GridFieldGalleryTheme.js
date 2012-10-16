(function($) {
	
	$.entwine('colymba', function($) {
      
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