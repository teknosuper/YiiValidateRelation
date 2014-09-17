<?php 

class YiiFormModel extends CFormModel {

	public $addDefaultRules=true;

	public function defaultRules()
	{
		return array(
			// @todo Please remove those attributes that should not be searched.
		);
	}

	public function createValidators()
	{
	    $validators=new CList;
	    $rules=$this->rules();
	    if($this->addDefaultRules)
		    $rules = array_merge($rules,$this->defaultRules());
	    foreach($rules as $rule)
	    {
	        if(isset($rule[0],$rule[1]))  // attributes, validator name
	            $validators->add(CValidator::createValidator($rule[1],$this,$rule[0],array_slice($rule,2)));
	        else
	            throw new CException(Yii::t('yii','{class} has an invalid validation rule. The rule must specify attributes to be validated and the validator name.',
	                array('{class}'=>get_class($this))));
	    }
	    return $validators;
	}

	public function validateRelation($attribute,$params)
	{

		$where_prefix = array_values(preg_filter('/^where_(.*)/', '$1', array_keys($params)));

		$where_array = array();
		for ($i=0; $i < count($where_prefix); $i++) { 
			# code...
			$where_array[$where_prefix[$i]] =  $params["where_".$where_prefix[$i]];
		}
		/*
			end check where params
		*/
		$where = ($where_array) ? $where_array :array() ;

		if($params['model']::model()->findAllByAttributes(array_merge(array($params['relationField']=>$this->$attribute),array_filter($where))))
		{
			return True;
	    }
	    else 
	    {
	    	if(isset($params['required']))
	    	{
	    		if($params['required'] =="yes")
	    		{
					$message = Yii::t('yii', '{attribute} not available!', array('{attribute}'=>$this->getAttributeLabel($attribute)));
                    $this->addError($attribute,$message);
			        return False;
	    		}
	    		else
	    		{
	    			if($this->$attribute=='')
	    			{
			    		return TRUE;
	    			}
	    			else
	    			{
						$message = Yii::t('yii', '{attribute} not available!', array('{attribute}'=>$this->getAttributeLabel($attribute)));
	                    $this->addError($attribute,$message);
				        return False;
	    			}
	    		}
	    	}
	    	else
	    	{
    			if($this->$attribute=='')
    			{
		    		return TRUE;
    			}
    			else
    			{
					$message = Yii::t('yii', '{attribute} not available!', array('{attribute}'=>$this->getAttributeLabel($attribute)));
                    $this->addError($attribute,$message);
			        return False;
    			}
	    	}
	    }
	}

}