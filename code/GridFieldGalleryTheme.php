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
	protected $thumbnailConfig = array(
		'format' => 'CroppedImage',
		'width' => 150,
		'height' => 150,
	);
    
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

	/**
	 * @param string $name
	 * @param mixed $val
	 */
	public function setThumbnailConfig($name, $val) {
		$this->thumbnailConfig[$name] = $val;
		return $this;
	}

	/**
	 * @param string $name
	 */
	public function getThumbnailConfig($name) {
		if(isset($this->thumbnailConfig[$name]))
			return $this->thumbnailConfig[$name];

		return null;
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
      $previewObj = $record->{$this->thumbnailField}();
      $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/missing.png';
      
      if ( $previewObj->ID )
      {
        if ( $previewObj instanceof Image )
        {
	        $width = $this->getThumbnailConfig('width') ? $this->getThumbnailConfig('width') : 150;
	        $height = $this->getThumbnailConfig('height') ? $this->getThumbnailConfig('height') : 150;
	        $format = $this->getThumbnailConfig('format');

	        if($format && $previewObj->hasMethod($format))
		        $url = $previewObj->$format($width, $height)->URL;
	        elseif($format && $previewObj->hasMethod('generate' . $format))
		        $url = $previewObj->getFormattedImage($format, $width, $height)->URL;
	        else
		        $url = $previewObj->CroppedImage($width, $height)->URL;

          if ($url) $imgFile = $url;
        }
        else if ( $previewObj instanceof File )
        {
          if ( is_dir( BASE_PATH.'/'.$previewObj->Filename ) ) $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/folder.png';
          else $imgFile = $this->getFileTypeIcon( $previewObj );
        }
      }
      
      return '<img src="'.$imgFile.'" />';
    }
    
    /**
     * Return the icon to display for the fileobject
     * @param File $file
     * @return string icon path
     */
    function getFileTypeIcon ( $file )
    {
      $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/file.png';      
      $ext = strtolower( pathinfo($file->Filename, PATHINFO_EXTENSION) );
      
      if ($ext)
      {
        $tempFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/'.$ext.'.png';
        if ( !file_exists(BASE_PATH.'/'.$tempFile) )
        {
          foreach ( $this->fileTypeMapping as $icon => $extensions)                
          {
            if ( in_array($ext, $extensions) )
            {
              $imgFile = GRIDFIELD_GALLERY_THEME_PATH . '/img/icons/'.$icon;
              break;
            }
          }
        }else{
          $imgFile = $tempFile;
        }
      }
      
      return $imgFile;
    }

    function getColumnAttributes($gridField, $record, $columnName)
    {
      $class = 'galleryThumbnail';
      $previewObj = $record->{$this->thumbnailField}();
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