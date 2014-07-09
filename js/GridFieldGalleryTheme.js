(function($) {
	
	$.entwine('colymba', function($) {
      
      $('td.galleryThumbnail').entwine({
        
        onmatch: function(){
          this.parents('table.ss-gridfield-table').addClass('galleryTheme');
          this.parents('table.ss-gridfield-table.galleryTheme').find('thead tr.sortable-header').css({display: 'none'});
          this.setupToolTip();
        },
        onunmatch: function(){},

        setupToolTip: function()
        {
          var _this = this;
          this.parents('tr').on('mouseenter.GFGallery', function(){
            _this.showToolTip();
          });
          this.parents('tr').on('mouseleave.GFGallery', function(){
            _this.hideToolTip();
          });
        },

        cleanToolTip: function()
        {
          this.parents('tr').off('mouseenter.GFGallery');
          this.parents('tr').off('mouseleave.GFGallery');
        },

        showToolTip: function()
        {
          var data = this.collectToolTipData(),
              $tp  = $('<div id="galleryToolTip"/>')
              ;

          $.each(data, function(prop,val){
            $tp.append('<p><strong>'+prop+':</strong> '+val+'</p>');
          });

          this.hideToolTip();
          $tp.data('thumbnail', this);
          this.parents('body').append($tp);          
        },

        hideToolTip: function()
        {
          this.parents('body').find('#galleryToolTip').empty().remove();
        },

        collectToolTipData: function()
        {
          var data = {},
              regEx = new RegExp('.*(col-)([^ ]+).*', 'i')
              ;

          this.parent('tr')
              .find('td')
              .not('.col-buttons,.col-bulkSelect,.galleryThumbnail')
              .each(function(index,element)
              {
                var $e      = $(element),
                    title   = $e.attr('class').replace(regEx, '$2').replace('-', ' '),
                    content = $e.html()
                    ;

                data[title] = content;
          });

          return data;
        }
      });

      $('#galleryToolTip').entwine({
        onmatch: function(){
          this.position();
        },
        onunmatch: function(){},

        position: function()
        {
          var $thumb = this.data('thumbnail'),
              $block = $thumb.parent('tr'),
              block = {
                top:    $block.offset().top,
                left:   $block.offset().left,
                height: $block.outerHeight(),
                width:  $block.outerWidth()
              },
              tt = {
                height: this.outerHeight(),
                width:  this.outerWidth()
              },
              top  = block.top + block.height + 5,
              left = block.left - ((tt.width - block.width) / 2)
              ;

          this.css({
            top:  top + 'px',
            left: left + 'px',
          }).css({display: 'block'});
        }
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