<?php
 /*
  LightSpeed Web Store
 
  NOTICE OF LICENSE
 
  This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@lightspeedretail.com <mailto:support@lightspeedretail.com>
 * so we can send you a copy immediately.
 
  DISCLAIMER
 
 * Do not edit or add to this file if you wish to upgrade Web Store to newer
 * versions in the future. If you wish to customize Web Store for your
 * needs please refer to http://www.lightspeedretail.com for more information.
 
 * @copyright  Copyright (c) 2011 Xsilva Systems, Inc. http://www.lightspeedretail.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 
 */

   /*
     * XLSIntegerBox
     * 
     * Extends class used in Web Admin panel 
     */
    
    
    class XLSIntegerBox extends QIntegerTextBox  {
        
        protected $strCssClass = "textfield";
        
        public function __construct($objParentObject , $strControlId = null) {
            parent::__construct($objParentObject , $strControlId);
            parent::AddAction(new QEnterKeyEvent() , new QTerminateAction());
        }
        
        private $blnHasNoEnterAction = true;
        
        public function AddAction($objEvent , $objAction) {
            if(($objEvent instanceof QEnterKeyEvent) && 
                ($this->blnHasNoEnterAction)){
                    $this->blnHasNoEnterAction = false;
                    $this->RemoveAllActions('onkeypress');
            }
            parent::AddAction($objEvent , $objAction);
        }
    }
    
?>
