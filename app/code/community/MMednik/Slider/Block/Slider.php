<?php

class Mmednik_Slider_Block_Slider extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

    const MAX_SLIDES = 10;

    public $_slides = array();
    
    public $_sliderId;
    public $_sliderWidth;
    public $_sliderHeight;
    
    public $_animtype;
    public $_animduration;
    public $_animspeed;
    public $_automatic;
    public $_showcontrols;
    public $_centercontrols;
    public $_nexttext;
    public $_prevtext;
    public $_showmarkers;
    public $_centermarkers;
    public $_keyboardnav;
    public $_hoverpause;
    public $_usecaptions;
    public $_randomstart;
    public $_responsive;

    protected function _construct() {
        parent::_construct();
    }
    
    protected function resizeImg($fileName, $rWidth, $rHeight = '') {
        // from http://www.atwix.com/magento/how-to-resize-images/
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;
        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $fileName;
        $basePath = str_replace('/', '\\', $basePath);
        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . "resized" . DS . $fileName;
        $newPath = str_replace('/', '\\', $newPath);
        if ($rWidth != '') {
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($rWidth, $rHeight);
                $imageObj->save($newPath);
            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "resized" . DS . $fileName;
            
        } else {
            $resizedURL = $imageURL;
        }
        return $resizedURL;
    }
    
    protected function _prepareLayout() {
        $this->getLayout()->getBlock('head')
                ->addItem('skin_js', 'js/slider/bjqs-1.3.js')
                ->addItem('skin_css', 'css/slider/bjqs.css');
        return parent::_prepareLayout();
    }

    protected function _toHtml() {
        for ($i = 1; $i <= self::MAX_SLIDES; $i++) {
            if ($this->getData('slide' . $i)) {
                $this->_sliderWidth = $this->getData('width');
                $this->_sliderHeight = $this->getData('height');
                $image = $this->getData('slide' . $i);
                $imgSrc = $this->resizeImg($image, $this->_sliderWidth, $this->_sliderHeight);
                $link = $this->getData('slide' . $i . 'link');
                $alt = $this->getData('slide' . $i . 'alt');
                if($link) {
                    $blockHTML = '<a href="' . $link . '" title="' . $alt . '"><img src="' . $imgSrc . '" width="' . $this->_sliderWidth . '" height="' . $this->_sliderHeight . '" alt="' . $alt . '" title="' . $alt . '" /></a>';
                } else {
                    $blockHTML = '<img src="' . $imgSrc . '" width="' . $this->_sliderWidth . '" height="' . $this->_sliderHeight . '" alt="' . $alt . '" title="' . $alt . '" />';
                }
                $this->_slides[$i] = $blockHTML;
            }
        }
        
        $this->_sliderId = $this->getData('id');
        
        $this->_animtype = $this->getData('animtype');
        $this->_animduration = $this->getData('animduration');
        $this->_animspeed = $this->getData('animspeed');
        $this->_automatic = $this->getData('automatic');
        $this->_showcontrols = $this->getData('showcontrols');
        $this->_centercontrols = $this->getData('centercontrols');
        $this->_nexttext = $this->getData('nexttext');
        $this->_prevtext = $this->getData('prevtext');
        $this->_showmarkers = $this->getData('showmarkers');
        $this->_centermarkers = $this->getData('centermarkers');
        $this->_keyboardnav = $this->getData('keyboardnav');
        $this->_hoverpause = $this->getData('hoverpause');
        $this->_usecaptions = $this->getData('usecaptions');
        $this->_randomstart = $this->getData('randomstart');
        $this->_responsive = $this->getData('responsive');
        
        return parent::_toHtml();
    }
    
}