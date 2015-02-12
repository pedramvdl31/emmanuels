<?php

class Job extends \Eloquent {
	protected $fillable = [];

	static public function debug($results) {
		if(count($results)>0){
			foreach ($results as $p) {
				echo '<pre>';
				print_r($p);
				echo '</pre>';

			}
		}
		return false;
	}

	public static function dump($results) {
		if(isset($results)) {
			echo '<pre>';
			print_r($results);
			echo '</pre>';
		}

		return false;
	}

	public static function substr_with_ellipsis($string, $chars = 100)
	{
	    preg_match('/^.{0,' . $chars. '}(?:.*?)\b/iu', $string, $matches);
	    $new_string = $matches[0];
	    return ($new_string === $string) ? $string : $new_string . '...';
	}

	public static function format_phone($phone_number, $country_code)
	{

		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
		try {
		    $formatted_number = $phoneUtil->parse($phone_number, $country_code);

		    $isValid = $phoneUtil->isValidNumber($formatted_number);
		    /**
		    * E164 = +12065577391
		    * formatInOriginalFormat()
		    * National = (206) 557-7391
		    * International = +1 206-557-7391
		    * RFC3966 = tel:+1-206-557-7391
		    * 
		    **/
		    if($isValid) {
		    	return $phoneUtil->format($formatted_number, \libphonenumber\PhoneNumberFormat::NATIONAL);
		    } else {
		    	return null;
		    }

		    // get formatted phone number
		    
		} catch (\libphonenumber\NumberParseException $e) {
			return $e;
		}
	}

	private static function crypto_rand_secure($min, $max) {
	        $range = $max - $min;
	        if ($range < 0) return $min; // not so random...
	        $log = log($range, 2);
	        $bytes = (int) ($log / 8) + 1; // length in bytes
	        $bits = (int) $log + 1; // length in bits
	        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	        do {
	            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	            $rnd = $rnd & $filter; // discard irrelevant bits
	        } while ($rnd >= $range);
	        return $min + $rnd;
	}

	public static function getToken($length){
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ-";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz-";
	    $codeAlphabet.= "0123456789";
	    for($i=0;$i<$length;$i++){
	        $token .= $codeAlphabet[Job::crypto_rand_secure(0,strlen($codeAlphabet))];
	    }
	    return $token;
	}



    public static function cardTypes()
    {
        return array(
            '0'=>'Select Card Type',
            'visa'=>'Visa',
            'mastercard'=>'Mastercard',
            'amex'=>'American Express',
            'discover'=>'Discover',
            'maestro'=>'Maestro',
        );
    }

    public static function prepareVaultCreditCardErrors($data)
    {
        $card_errors = array();
        if(isset($data['details'])) {
            foreach ($data['details'] as $key => $value) {
                switch($value['field']) {
                    case 'first_name':
                        $card_errors['billing_first_name'] = $value['issue'];
                    break;
                    case 'last_name':
                        $card_errors['billing_last_name'] = $value['issue'];
                    break;
                    case 'type':
                        $card_errors['card_type'] = $value['issue'];
                    break;
                    case 'number':
                        $card_errors['card_number'] = $value['issue'];
                    break;
                    case 'expire_month':
                        $card_errors['card_month'] = $value['issue'];
                    break;
                    case 'expire_year':
                        $card_errors['card_year'] = $value['issue'];
                    break;
                    default:
                        $card_errors['default'] = $value['issue'];
                    break;
                }
            }
        }
        if(!isset($card_errors['billing_first_name']) && Input::get('billing_first_name') == '') {
            $card_errors['billing_first_name'] = 'This field cannot be left empty';
        }
        if(!isset($card_errors['billing_last_name']) && Input::get('billing_last_name') == '') {
            $card_errors['billing_last_name'] = 'This field cannot be left empty';
        }


        return $card_errors;
    }
    public static function prepareDirectCreditCardErrors($data)
    {

        $card_errors = array();
        if(isset($data['details'])) {
            foreach ($data['details'] as $key => $value) {
  				Job::dump($value['field']);
                switch($value['field']) {
                	case 'payer.funding_instruments[0].credit_card.number':
                		$card_errors['direct_number'] = $value['issue'];
                	break;
                	case 'payer.funding_instruments[0].credit_card.expire_month':
                		 $card_errors['direct_month'] = $value['issue'];
                	break;
                	case 'payer.funding_instruments[0].credit_card.expire_year':
                		$card_errors['direct_year'] = $value['issue'];
                	break;
                	case 'payer.funding_instruments[0].credit_card.type':
                		$card_errors['direct_type'] = $value['issue'];
                	break;
                    case 'payer.funding_instruments[0].credit_card.first_name':
                        $card_errors['direct_first_name'] = $value['issue'];
                    break;
                    case 'payer.funding_instruments[0].credit_card.last_name':
                        $card_errors['direct_last_name'] = $value['issue'];
                    break;
                    default:
                        $card_errors['direct_default'] = $value['issue'];
                    break;
                }
            }
        }
        if(!isset($card_errors['direct_first_name']) && Input::get('direct_first_name') == '') {
            $card_errors['direct_first_name'] = 'This field cannot be left empty';
        }
        if(!isset($card_errors['direct_last_name']) && Input::get('direct_last_name') == '') {
            $card_errors['direct_last_name'] = 'This field cannot be left empty';
        }


        return $card_errors;
    }
	public static function formatDollar($amount) {
		$formatted = '$0.00';
		if(is_numeric($amount)) {
			$formatted = ($amount < 0) ? '<span class="text-warning">(-$'.(sprintf('%.2f',$amount) * -1).')</span>' : '$'.sprintf('%.2f',$amount);
		}

		return $formatted;
	}
}