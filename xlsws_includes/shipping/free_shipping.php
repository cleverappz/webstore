<?php

class free_shipping extends xlsws_class_shipping {


	public function name(){
		$config = $this->getConfigValues(get_class($this));
		
		if(isset($config['label']))
			return $config['label'];
		
		return $this->admin_name();
	}

	
	public function admin_name(){
		return _sp("Free shipping");	
	}		
	
	
	// return the keys for this module
	public function config_fields($objParent){
		
		$ret= array();
		
		$ret['label'] = new XLSTextBox($objParent);
		$ret['label']->Name = _sp('Label');
		$ret['label']->Required = true;
		$ret['label']->Text = $this->admin_name();			
		
		
		$ret['rate'] = new XLSTextBox($objParent);
		$ret['rate']->Name = _sp('Threshold Amount ($)');
		$ret['rate']->Text = '0';
		$ret['rate']->ToolTip = _sp('The amount the subtotal must be before free shipping is considered');
		
		$ret['product'] = new XLSTextBox($objParent);
		$ret['product']->Name = _sp('LightSpeed Product Code');
		$ret['product']->Required = true;
		$ret['product']->Text = 'SHIPPING';		

		
		return $ret;
	}
	
	
	public function check_config_fields($fields){

		//check that rate is numeric
		$val = $fields['rate']->Text;
		if(!is_numeric($val)){
			QApplication::ExecuteJavaScript("alert('Rate must be a number')");
			return false;
		}
		
		
		
		return true;	
	}	
	
	
	public function total($fields , $cart , $country = '' , $zipcode  = '' , $state = '', $city = '' , $address2 = '' ,  $address1= ''  , $company = '', $lname = '',   $fname = '' ){

		$config = $this->getConfigValues('free_shipping');
		
		$price = 0;
		
		if ($cart->Subtotal < $config['rate'])
		{	
			_xls_log("FREE SHIPPING: Cart subtotal does not qualify for free shipping");
			$userMsg = _sp("Subtotal does not qualify for free shipping, you must purchase at least " . _xls_currency($config['rate']) . " worth of merchandise.");
			QApplication::ExecuteJavaScript("alert('".$userMsg."')"); 
			return FALSE;
		}
		
		return array('price' => $price ,  'product' =>  $config['product']);
		
		
		return 0;
		
	}
	
	
	

	public function check(){
		return true;
	}
	
	
}


?>
