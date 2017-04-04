<?php
	namespace Security\Classes;

	use \StdClass as StdClass;
	use Security\Models\Keys as Keys;	

	class Cryptography
	{
		protected static $IN, $OUT;

		public function __construct()
		{
			$this->Initialize();
		}

		public function Initialize()
		{
			$this->Debug("Cryptography object instantiated");
		}

		// Public Methods

		public static function Debug()
		{
			echo "<pre><h1>IN</h1>";
			print_r(self::$IN);
			echo "<h1>OUT</h1>";
			print_r(self::$OUT);
			echo "</pre>";
		}

		public static function Encrypt($text, $keysId, $base64 = false)
		{
			$_enc 			= new StdClass();
			$_enc->key 		= self::GenerateKey();
			$_enc->iv 		= self::GenerateIV($base64);
			$_enc->encrypt 	= openssl_encrypt
			( 
				self::Pkcs7Pad($text, 16), 	// pad data 
				'AES-256-CBC', 				// cipher and mode 
				$_enc->key,					// secret key 
				0, 							// options (not used) 
				$_enc->iv 					// initialisation vector 
			);
       
	        // check if key was already assigned
	        if($keysId)
	        {
	            $current = Keys::findFirst($keysId);
	            
	            if($current)
	                $current->delete();
	        }
	        
	        $key = new Keys();
	        $key->setKey($_enc->key);
	        $key->setIV($_enc->iv);
	        
	        if($key->save())
	        {
	            $keysId = $key->getId();
	            return self::$IN = (object)array("keysId" => $key->getId(), "data" => $_enc->encrypt);
	        }
		}

		public static function DeCrypt($text, $keysId, $base64 = false)
		{
			/* 
			 * user base64_decode or hex2bin depending on column type BINARYVAR/BINDARY/VARCHAR
			 */

			if($keysId)
	        {
	            $key = Keys::findFirst($keysId);
	            
	            if($key)
	            {
	                return self::$OUT = self::Pkcs7Unpad( openssl_decrypt
					(
						$base64 ? base64_decode($text) : $text,
						'AES-256-CBC',
						$key->getKey(),
						0,
						$base64 ? base64_decode($key->getIV()) : $key->getIV()
					));
	            }

	            return null;
	        }
		}

		// Private Methods / Helpers

		/*
		 * Returns a binary blob generated from a reliable pseudo random number generator (OpenSSL)
		 */
		private static function GenerateKey()
		{
			$key_size = 32; // 256 bits
			return openssl_random_pseudo_bytes($key_size, $strong);
		}

		/*
		 * Returns an Initialization Vector (extra randomness for the encryption)
		 * The i.v. should be regenerated and restored after modifying a model
		 */
		private static function GenerateIV($base64 = false)
		{
			$iv_size = 16; // 128 bits
			$iv = openssl_random_pseudo_bytes($iv_size, $strong) ;
			
			/* 
			 * return a (non) base64 encoded iv.
			 * set $base64 to true when de iv database column is BINARY or VARBINARY
			 */
			return $base64 ? base64_encode($iv) : $iv;
		}

		/* 
		 * Pad data to blocksize
		 * More info: 
		 * http://www.di-mgt.com.au/cryptopad.html#whatispadding
		 * https://www.w3schools.com/php/func_string_str_pad.asp
		 */
		private static function Pkcs7Pad($data, $size) 
		{ 
			$length = $size - strlen($data) % $size; 
			return $data . str_repeat(chr($length), $length); 
		}

		private static function Pkcs7Unpad($data)
		{
			return substr($data, 0, -ord($data[strlen($data) - 1]));
		}
	}
?>