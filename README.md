GridField Gallery Theme
============================
SS3 GridField component that attempt to change the GridField layout into an basic gallery view. (Still in dev)

## About
* Display gridfield item as thumbnails for Image has_one relations
* Displays file type icons for File has_one relations
* Action button accessible on mouseover
* Great with [GridFieldBulkEditingTools](https://github.com/colymba/GridFieldBulkEditingTools)
* Works with [SortableGridField](https://github.com/UndefinedOffset/SortableGridField)

## Usage
Add component like this:
````php
$config->addComponent(new GridFieldGalleryTheme('HasOneRelation'));
````
with the string 'HasOneRelation' being the name of the has_one Image/File relation in your DataObject that your want to use as thumbnail/icon preview.

### File type icons
File type icons are stored in the component's folder under img/icons/ saved as PNG and name with the extension of the file type (i.e. pdf.png)

## NOTES
* Only tested in Chrome and IE9
* GridFieldSortableHeader is removed since this causes problem with the layout (at least for now)

## @TODO
* Add functionality to display a Name/Title on mouseover
* Fix the look of the column header (width isn't uniform)
* Option for dynamic thumbnail resizing in the view
* Create a bunch of default file type icons
* Icon preview styling
* other stuff...