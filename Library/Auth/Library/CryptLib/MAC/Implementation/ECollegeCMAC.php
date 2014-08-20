<?php
/**
 * A Cipher based MAC generator (Based upon the CMAC specification)
 *
 * Library stream-lined for use in eCollege OAuth 2.0 API Implementations
 * This is not a complete library - it is reduced only to the necessary components
 * to generate AES-CMAC hashes. 
 * 
 * Original library copyrighted Anthony Ferrara and available at 
 * https://github.com/ircmaxell/PHP-CryptLib
 * 
 * PHP version 5.3
 *
 * @see        http://csrc.nist.gov/publications/nistpubs/800-38B/SP_800-38B.pdf
 * @category   PHPCryptLib
 * @package    MAC
 * @subpackage Implementation
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    Build @@version@@
 */
namespace CryptLib\MAC\Implementation;

use \CryptLib\Cipher\Factory;

/**
 * A Cipher based MAC generator (Based upon the CMAC specification)
 * Modified for simplified eCollege API Usage. 
 *
 * @see        http://csrc.nist.gov/publications/nistpubs/800-38B/SP_800-38B.pdf
 * @category   PHPCryptLib
 * @package    MAC
 * @subpackage Implementation
 */
class ECollegeCMAC extends \CryptLib\MAC\AbstractMAC {

    protected $cipher = null;

    /**
     * @var array The stored options for this instance
     */
    protected $options = array(
        'cipher'        => 'aes-128',
        'cipherFactory' => null,
    );

    /**
     * Build the instance of the MAC generator
     *
     * @param array $options The options for the instance
     *
     * @return void
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);
        if (is_null($this->options['cipherFactory'])) {
            $this->options['cipherFactory'] = new Factory;
        }
        $this->cipher = $this->options['cipherFactory']->getBlockCipher(
            $this->options['cipher']
        );
    }

	/** 
	 * Generate a MAC from any string of ASCII data 
	 * In particular, this can take the Assertion string needed to access eCollege APIs
	 * via OAuth 2.0 - Assertion Grant Type methodology. That string is formatted as: 
	 * {client_name}|{key_moniker}|{client_id}|{client_string}|{username}|{timestamp}
	 * And this must then be hashed via CMAC-AES. The hash is tacked on as a final parameter. 
	 * 
	 * This method assumes your string was not previously hex encoded, encodes it, and then hashes it. 
	 *
     * @param string $string Arbitrary ASCII String (not hex encoded)
     * @param string $key  The key to generate the MAC
     *
     * @return string The generated MAC of the appropriate size
	 * 
	 */

	public function generateECollegeCMAC($string,$key){ 
		
		//pack the string into hexadecimal
		$packed_string = ''; 
		$l = strlen($string); 
        for($i=0; $i<$l; $i++) { 
            $packed_string .= pack("c", ord(substr($string, $i, 1))); 
        } 		

		//use existing method from library
		//this returns binary data, so we bin2hex it to translate it back.
		return bin2hex($this->generate($packed_string,$key)); 
	} 

    /**
     * Generate the MAC using the supplied data
     *
     * @param string $data The data to use to generate the MAC with
     * @param string $key  The key to generate the MAC
     * @param int    $size The size of the output to return
     *
     * @return string The generated MAC of the appropriate size
     */
    public function generate($data, $key, $size = 0) {
        $blockSize = $this->cipher->getBlockSize();
        if ($size == 0) {
            $size = $blockSize;
        }
        if ($size > $blockSize) {
            throw new \OutOfRangeException(
                sprintf(
                    'The size is too big for the cipher primitive [%d:%d]',
                    $size,
                    $blockSize
                )
            );
        }
        $this->cipher->setKey($key); 
        $keys    = $this->generateKeys();
        $mBlocks = $this->splitDataIntoMBlocks($data, $keys);
        $cBlock  = str_repeat(chr(0), $blockSize);
        foreach ($mBlocks as $key => $block) {
            $cBlock = $this->cipher->encryptBlock($cBlock ^ $block);
        }
        return substr($cBlock, 0, $size);
    }

    /**
     * Generate a pair of keys by encrypting a block of all 0's, and then
     * maniuplating the result
     *
     * @return array The generated keys
     */
    protected function generateKeys() {
        $keys      = array();
        $blockSize = $this->cipher->getBlockSize();
        $rVal      = $this->getRValue($blockSize);
        $text      = str_repeat(chr(0), $blockSize);
        $lVal      = $this->cipher->encryptBlock($text);
        $keys[0]   = $this->leftShift($lVal, 1);
        if (ord(substr($lVal, 0, 1)) > 127) {
            $keys[0] = $keys[0] ^ $rVal;
        }
        $keys[1] = $this->leftShift($keys[0], 1);
        if (ord(substr($keys[0], 0, 1)) > 127) {
            $keys[1] = $keys[1] ^ $rVal;
        }
        return $keys;
    }

    /**
     * Get an RValue based upon the block size
     *
     * @param int $size The size of the block in bytes
     *
     * @see http://csrc.nist.gov/publications/nistpubs/800-38B/SP_800-38B.pdf
     * @return string A RValue of the appropriate block size
     */
    protected function getRValue($size) {
        switch ($size * 8) {
            case 64:
                return str_repeat(chr(0), 7) . chr(0x1B);
            case 128:
                return str_repeat(chr(0), 15) . chr(0x87);
            default:
        }
        throw new \RuntimeException('Unsupported Block Size For The Cipher');
    }

    protected function leftShift($data, $bits) {
        $mask   = (0xff << (8 - $bits)) & 0xff;
        $state  = 0;
        $result = '';
        $length = strlen($data);
        for ($i = $length - 1; $i >= 0; $i--) {
            $tmp     = ord($data[$i]);
            $result .= chr(($tmp << $bits) | $state);
            $state   = ($tmp & $mask) >> (8 - $bits);
        }
        return strrev($result);
    }

    /**
     * Split the data into appropriate block chunks, encoding with the kyes
     *
     * @param string $data The data to split
     * @param array  $keys The keys to use for encoding
     *
     * @return array The array of chunked and encoded data
     */
    protected function splitDataIntoMBlocks($data, array $keys) {
        $blockSize = $this->cipher->getBlockSize();
        $data      = str_split($data, $blockSize);
        $last      = end($data);
        if (strlen($last) != $blockSize) {
            //Pad the last element
            $last .= chr(0x80) . str_repeat(chr(0), $blockSize - 1 - strlen($last));
            $last  = $last ^ $keys[1];
        } else {
            $last = $last ^ $keys[0];
        }
        $data[count($data) - 1] = $last;
        return $data;
    }

}