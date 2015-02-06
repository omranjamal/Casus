<?php
namespace solidew\Casus;

class Casus 
{
    protected $generator;

    public function hasMCrypt()
    {
        return function_exists("mcrypt_encrypt");
    }

    public function hasOpenSSL()
    {
        return function_exists("openssl_random_pseudo_bytes");
    }

    public function isSecure()
    {
        return $this->generator->isSecure();
    }

    public function getGenerator()
    {
        return $this->generator;
    }

    public function setGenerator($secure = true, Generator $generator = null)
    {
        if ($secure === true && $generator === null) {
            if ($this->hasMCrypt()) {
                $this->generator = new MCrypt;
            } elseif ($this->hasOpenSSL()) {
                $this->generator = new OpenSSL;
            } else {
                throw new errors\Insecure('MCrypt or OpenSSL extension not found');
            }
        } elseif ($generator !== null) {
            $this->generator = $generator;

            if ($secure === true) {
                if ($generator->isSecure() === false) {
                    throw new errors\Insecure('The provided generator is not a CSPRNG');
                }
            }
        } else {
            $this->generator = new Basic;
        }
    }

    public function integer($min = 0, $max = PHP_INT_MAX)
    {
        return $this->generator->integer($min, $max);
    }

    public function float($min = 0, $max = 1, $points = 4, $secure = true)
    {
        return $this->generator->float($min, $max, $points, $secure);
    }

    public function boolean($secure = true)
    {
        return $this->generator->boolean($secure);
    }

    public function alpha($length = 32, $case_randomization = true, $secure = true)
    {
        return $this->generator->alpha($length, $case_randomization, $secure);
    }

    public function alphanum($length = 32, $case_randomization = true, $secure = true)
    {
        return $this->generator->alphanum($length, $case_randomization, $secure);
    }

    public function asciiRange($length = 32, $ranges = [[65,90],[97,122],[48,57]], $secure = true)
    {
        return $this->generator->asciiRange($length, $ranges, $secure);
    }

    public function string($length = 32, $charset = false, $secure = true)
    {
        return $this->generator->string($length, $charset, $secure);
    }

    public function integerArray($min = 0, $max = PHP_INT_MAX, $length = 10, $secure = true)
    {
        return $this->generator->integerArray($min, $max, $length, $secure);
    }

    public function floatArray($min = 0, $max = 1, $points = 4, $length = 10, $secure = true)
    {
        return $this->generator->floatArray($min, $max, $points, $length, $secure);
    }

    public function randomize($input, $secure = true)
    {
        return $this->generator->randomize($input, $secure);
    }

    public function selectRandom($input, $length = 1, $secure = true)
    {
        return $this->generator->selectRandom($input, $length, $secure);
    }

    public function byte($secure = true)
    {
        return $this->generator->byte($secure);
    }

    public function byteString($length = 32, $secure = true)
    {
        return $this->generator->byteString($length, $secure);
    }

    public function __construct($secure = true, Generator $generator = null)
    {
        $this->setGenerator($secure, $generator);
    }
}