<?php
namespace Cgsmith\Validate;

/**
 * Class ValidateRecaptcha
 * Handle validation against Google API
 *
 * @package Cgsmith
 * @license MIT
 * @author Chris Smith
 * @link   https://github.com/google/recaptcha
 */
class Recaptcha extends \Zend_Validate_Abstract
{
    /** @var string secret key */
    protected $_secretKey;

    /** @const string invalid captcha */
    const INVALID_CAPTCHA = 'invalidCaptcha';

    /** @const string invalid captcha */
    const CAPTCHA_EMPTY = 'captchaEmpty';

    /** @const string URL to where requests are posted */
    const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /** @const string http method for communicating with google */
    const POST_METHOD = 'POST';

    /** @const string peer key for communication */
    const PEER_KEY = 'www.google.com';

    protected $_messageTemplates = array(
        self::INVALID_CAPTCHA => 'The captcha was invalid',
        self::CAPTCHA_EMPTY   => 'Капча должна быть заполнена'
    );

    /**
     * @param $options
     */
    public function __construct($options) {
        $this->_secretKey = $options['secretKey'];
    }

    /**
     * Validate our form's element
     *
     * @param mixed $value
     * @param null $context
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        if (empty($value)) {
            $this->_error(self::CAPTCHA_EMPTY);
            return false;
        }

        if (!$this->_verify()) {
            $this->_error(self::INVALID_CAPTCHA);
            return false;
        }

        return true;
    }

    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes the captcha test.
     *
     * @return boolean
     * @link   https://github.com/google/recaptcha
     */
    protected function _verify()
    {
        $queryString = http_build_query(array(
            'secret'   => $this->_secretKey,
            'response' => $this->_value,
            'remoteIp' => $_SERVER['REMOTE_ADDR']
        ));

        /**
         * PHP 5.6.0 changed the way you specify the peer name for SSL context options.
         * Using "CN_name" will still work, but it will raise deprecated errors.
         */
        $peerKey = version_compare(PHP_VERSION, '5.6.0', '<') ? 'CN_name' : 'peer_name';
        $context = stream_context_create(array(
            'http'  => array(
                'header'      => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'      => self::POST_METHOD,
                'content'     => $queryString,
                'verify_peer' => true,
                $peerKey      => self::PEER_KEY
            )
        ));
        $jsonObject = json_decode(file_get_contents(self::SITE_VERIFY_URL,false,$context));

        return $jsonObject->success;
    }
}
