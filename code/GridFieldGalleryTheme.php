<?php
/**
 * SS3 GridFiled component appying a theme to the GridField
 * rendering it into a gallery view
 *
 * @author colymba
 * @package GridFieldGalleryTheme
 */
class GridFieldGalleryTheme implements GridField_HTMLProvider, GridField_ColumnProvider
{
    /** @var string */  
    protected $thumbnailField;
    
    /** @var array */
    protected $fileTypeMapping = array(
      'ai.png' => array('eps','ps'),
      'developer.png' => array('php','js'),
      'doc.png' => array('docx'),
      'html.png' => array('htm','xhtml'),
      'image.png' => array('jpg','jpeg','gif','png','tiff','tga','bmp','pct'),
      'movie.png' => array('3g2','3gp','asf','asx','avi','mov','mp4','mpg','rm','vob','wmv','mkv'),
      'music.png' => array('aif','iff','m3u','m4a','mp3','mpa','ra','wav','wma'),
      'ppt.png' => array('pptx'),
      'psd.pnd' => array('psb'),
      'text.png' => array('odt','rtf','txt','wpd','wps'),
      'xls.png' => array('xlsx'),
      'zip.png' => array('7z','cbr','deb','gz','pkg','rar','rpm','sit','sitx','tar','zipx')
    );

    /**
    * @param String $thumbnailField has_one relation on DO to use for thumbnail preview
    */
    public function __construct($thumbnailField) {
      $this->thumbnailField = $thumbnailField;
    }
  
    /* *********************************************************************** */
    // GridField_HTMLProvider
  
    public function getHTMLFragments($gridField)
		{			
			Requirements::css(GRIDFIELD_GALLERY_THEME_PATH . '/css/GridFieldGalleryTheme.css');
			Requirements::javascript(GRIDFIELD_GALLERY_THEME_PATH . '/js/GridFieldGalleryTheme.js');
    }
    
    /* *********************************************************************** */
    // GridField_ColumnProvider
	
    function augmentColumns($gridField, &$columns)
    {
      if(!in_array('GalleryThumbnail', $columns))
        $columns[] = 'GalleryThumbnail';
    }

    function getColumnsHandled($gridField)
    {
      return array('GalleryThumbnail');
    }

    function getColumnContent($gridField, $record, $columnName)
    {
      $previewObj = $record->getComponent($this->thumbnailField);
      $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/unknown.png';
      
      if ( $previewObj )
      {
        if ( $previewObj instanceof Image )
        {
          $gd = new GD(Director::baseFolder()."/" . $previewObj->Filename);
          $url = $previewObj->CroppedImage( 150, 150 )->URL;
          if ($url) $imgFile = $url;
        }
        else if ( $previewObj instanceof File )
        {
          $ext = pathinfo($previewObj->URL, PATHINFO_EXTENSION);
          if ($ext) $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/'.$ext.'.png';
        }
      }
      
      return '<img src="'.$imgFile.'" />';
    }

    function getColumnAttributes($gridField, $record, $columnName)
    {
      $class = 'galleryThumbnail';
      $previewObj = $record->getComponent($this->thumbnailField);
      if ( $previewObj )
      {
        if ( $previewObj instanceof Image ) $class .= ' image';
        else if ( $previewObj instanceof File ) $class .= ' icon';
      }
      return array('class' => $class);
    }

    function getColumnMetadata($gridField, $columnName)
    {
      if($columnName == 'GalleryThumbnail') {
        return array('title' => 'Thumbnail');
      }
    }
}