<?php

class FractionMath{
	
	public $whole; //number
	public $numerator; //number
	public $denominator; //number
	public $result; //string

	//get everything in string until certain string
	public function everything_until($string, $until){
		return trim(substr($string, 0, strpos($string, $until) ));
	}

	//get everything in string from certain char till the end
	public function everything_from($string,$from){
		return substr($string, strpos($string, $from) + 1);
	}


	//get numbers, divide them by types whole, numerator, denominator. Return array with 3 numbers, whole, num, dem
	public function getNumbers($string){
		
		$string = trim(preg_replace('/\s+/', ' ', $string));
		
	
		//check if there is whole number 2 numbers next to each other
		if (preg_match('~[0-9] [0-9]+~', $string)) {
			//whole number detected
			$first=$this->everything_until(trim($string)," ");
			$this->whole=trim($first);			
			$result[0]=trim($first);
		}

		//check if there is fractions
		if (strpos($string,"/")!==false){

			//if there is whole number, we take right place for fractions
			if (preg_match('~[0-9] [0-9]+~', $string)) {
				$second= $this->everything_from($string," ");
				$divided=explode("/",trim($second));
			}else{
				$divided=explode("/",trim($string));
			}
			$this->numerator=trim($divided[0]);
			$this->denominator=trim($divided[1]);
			$result[]=trim($divided[0]);
			$result[]=trim($divided[1]);
		}
		
		//else there is only whole number
		else{
			$this->whole=trim($string);
			$result[0]=trim($string);
		}

		return $result;
		
	}

	//return whole number without fractions
	public function getWhole(){
		return $this->whole;
	}
	
	//return fractions string without whole
	public function getFractions(){
		if($this->numerator == 0){
			return;
		}else{
			return $this->numerator . "/" . $this->denominator;
		}
	}

	//return numerator
	public function getNumerator(){
		return $this->numerator;
	}
	
	//return denominator
	public function getDenominator(){
		return $this->denominator;
	}
	
	//return result whole number and fractions, string
	public function getResult(){
		return $this->result;
	}
		
	//make a fractions into mixed whole + fractions, return string
	public function toMixed(){
		$string=$this->result;
		$a=$this->makeCountable($string);
		
		$whole = (int) ($a[0] / $a[1]);
		$numerator=$a[0] % $a[1];
		$denominator=$a[1];
		
		$this->whole=$whole;
		$this->numerator=$numerator;
		$this->denominator=$denominator;
		
		
		if($numerator==0){
			$this->result="$whole";
			return "$whole";
		}elseif($whole==0){
			$this->result="$numerator/$denominator";
			return "$numerator/$denominator";
		}else{
			$this->result="$whole $numerator/$denominator";
			return "$whole $numerator/$denominator";
		}
	}
	
	//detect types (whole, fracts) and return to fracts
	public function toFractions($string){
		
		$string=$this->getNumbers($string);

		switch(count($string)){
			case 1:
				//whole only
				return "$string[0]/1";
			break;
			case 2:
				//fractions only
				return "$string[0]/$string[1]";
			break;
			case 3:
				//mixed
				return $string[0] * $string[2] + $string[1]."/$string[2]";
			break;
		}
		

	}
	
	//make arrays of num and denom from string
	public function makeCountable($a){
		
		//convert everything to fractions string
		$a=$this->toFractions($a);
		
		//convert fractions string into array
		$a=$this->getNumbers($a);
		
		return $a;
	}
	
	//make string result of mixed numbers in string
	public function plus($a, $b){
		
		//make them into array
		$a=$this->makeCountable($a);
		$b=$this->makeCountable($b);
		
		$numerator= ($a[0] * $b[1]) + ($b[0] * $a[1]);
		$denominator =$a[1] * $b[1];
		
		$this->numerator=$numerator;
		$this->denominator=$denominator;		
		$this->result="$numerator/$denominator";
		
		return "$numerator/$denominator";
	}
	
	//make string result of mixed numbers in string
	public function minus($a, $b){
		
		//make numbers into array so we could operate with them
		$a=$this->makeCountable($a);
		$b=$this->makeCountable($b);
		
		$numerator= ($a[0] * $b[1]) - ($b[0] * $a[1]);
		$denominator =$a[1] * $b[1];

		$this->numerator=$numerator;
		$this->denominator=$denominator;		
		$this->result="$numerator/$denominator";
		
		return "$numerator/$denominator";
	}
	
	//make string result of mixed numbers in string
	public function multiply($a, $b){
		
		$a=$this->makeCountable($a);
		$b=$this->makeCountable($b);
		
		$numerator= $a[0] * $b[0];
		$denominator =$a[1] * $b[1];
		
		$this->numerator=$numerator;
		$this->denominator=$denominator;
		$this->result="$numerator/$denominator";
		
		return "$numerator/$denominator";
		
	}
	
	//make string result of mixed numbers in string
	public function divide($a, $b){
		
		$a=$this->makeCountable($a);
		$b=$this->makeCountable($b);
		
		$numerator= $a[0] * $b[1];
		$denominator =$a[1] * $b[0];
		
		$this->numerator=$numerator;
		$this->denominator=$denominator;
		$this->result="$numerator/$denominator";
		
		return "$numerator/$denominator";		
		
	}
	
	//reduce fractions, return fractions string
	public function reduceFraction($numerator="x", $denominator="x"){

		if($numerator=="x"){
			$from_result=$this->makeCountable($this->result);
			$numerator=$from_result[0];
			$denominator=$from_result[1];
		}
		
		$tmp = $this->greatestCommonDenominator($numerator, $denominator);
		
		$numerator=$numerator / $tmp;
		$denominator=$denominator / $tmp;
		
		
		$this->numerator=$numerator;
		$this->denominator=$denominator;
		$this->result="$numerator/$denominator";
		
		return "$numerator/$denominator";
		
	}

	//greatest common denominator
	public function greatestCommonDenominator($a, $b){

		if ($b){
			return $this->greatestCommonDenominator($b, $a % $b);
		}else{
			return $a;
		}
		
	}	
	
	//get numbers from string
	public function fromString(){
		
	}
	
	//echo 
	public function toString(){
		
	}
	
	
	
}
?>
