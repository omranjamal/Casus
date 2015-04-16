Casus
===================
> Just another Randomizer Library but cooler! With many out of the box features and support for 'Cryptographically 
> Secure Pseudo Random Number Generators' (CSPRNGs) provided by MCrypt and/or OpenSSL

#Installation
The easiest way to install Casus for use in your own projects is through composer. You could manually download the 
files and use an alternative [psr-4](http://www.php-fig.org/psr/psr-4/) compatible autoloader to autoload the file 
in the `src` directory but this is not recommended and highly discouraged.

## Through composer.json File
Add this line in your `composer.json` file and run `composer install` on the command line
```JSON
"require": {
    "solidew/casus": "*"
}
```

## Through the command line
Just run in your project directory
```
composer require solidew/casus
```


#Usage
Basically all you do is instantiate an object of the Casus Class and you're good to go!

```PHP
<?php
//Include the Composer Autoloader
include "vendor/autoload.php";

$casus = new \solidew\Casus\Casus();
echo $casus->integer();
```
The above example will out put a number between `0` and `PHP_INT_MAX` of your PHP installation.

The casus class actually forwards all method calls to the generator instance, thus you could, if you prefer to, get the generator instance and call methods directly on it. Like:
```PHP
<?php
$casus = new \solidew\Casus\Casus();
$random_generator = $casus->getGenerator();
echo $random_generator->integer();
```
#Methods
## Method List
- [integer](#integer-min-max--secure) - Generates a random integer
- [float](#float-min-max-precision--secure) - Generates a random floating point number
- [boolean](#boolean-secure) - Generates a random boolean value
- [alpha](#alpha-length-case_randomization--secure) - Generates a random string with alphabets
- [alphanum](#alphanum-length-case_randomization--secure) - Generates a random string with alphabets and numbers
- [asciiRange](#asciirange-length-ranges--secure) - Generates a random string from a range in the ascii table
- [string](#string-length-charset--secure) - Generates a random string from a character set
- [integerArray](#integerarray-min-max-length--secure) - Generates an array of random Integers
- [floatArray](#floatarray-min-max-precision-length--secure) - Generates an array of random floating point integers
- [randomize](#randomize-input--secure) - Takes an array or string and randomizes its order
- [selectRandom](#selectrandom-input-length--secure) - Selects elements from an array at random
- [byte](#byte-secure) - Generates a random byte
- [byteString](#bytestring-length--secure) - Generates a string of random bytes

The `$secure` parameter on each method is used to temporarily override the secure generator for an insecure one, in a secure instance. (This can be done by setting it to `false`). By default it is set to `true`.

### integer (_$min_, _$max_ [, _$secure_])
Returns a Number between `$min` & `$max`

**Parameters**  
- _int_ `$min` (`0`)
	> Lower Bound of numbers returned
    
- _int_ `$max` (`PHP_INT_MAX`)
    > Upper Bound of numbers returned


### float (_$min_, _$max_, _$precision_ [, _$secure_])
Returns a Floating point number between `$min` & `$max`

**Parameters**  
- _int_ `$min` (`0`)
	> Lower Bound of numbers returned
    
- _int_ `$max` (`PHP_INT_MAX`)
    > Upper Bound of numbers returned

- _int_ `$precision` (`4`)
    > Number of decimal digits


### boolean ([_$secure_])
Returns a `boolean` value (`true` or `false`)


### alpha (_$length_, _$case_randomization_ [, _$secure_])
Returns a string consisting of alphabets

**Parameters**  
- _int_ `$length` (`32`)
	> Length of the Random String
    
- _boolean_ `$case_randomization` (`true`)
    > To randomize case or not


### alphanum (_$length_, _$case_randomization_ [, _$secure_])
Returns a string consisting of alphabets & numbers

**Parameters**  
- _int_ `$length` (`32`)
	> Length of the Random String
    
- _boolean_ `$case_randomization` (`true`)2nd parameter)
    > To randomize case or not


### asciiRange (_$length_, _$ranges_ [, _$secure_])
Returns a string consisting of ASCII characters with the the range
defined by `$ranges`

**Parameters**  
- _int_ `$length` (`32`)
	> Length of the Random String
    
- _array_ `$ranges` (`[[65,90],[97,122],[48,57]]`)
    > The Ranges of Character codes in the ASCII table to choose from
    > It could be a single dimensional array with the first value being
    > the starting point and the second being the ending point  
    > eg. `asciiRange(32, [97, 122])` [A-Z]  
    >   
    > **Or**  
    >   
    > It could be a multidimensional array defining a set of ranges like:
    > ```PHP
    > $ranges = [
    >   [65,90],
    >   [97,122],
    >   [48,57]
    > ];
    > 
    > asciiRange(32, $ranges)
    > ```
    > The above produces a string consisting of lower case
    > letters, upper case letters and numbers



### string (_$length_, _$charset_ [, _$secure_])
Returns a string consisting of the characters specified in `$charset`

**Parameters**  
- _int_ `$length` (`32`)
	> Length of the Random String
    
- _array/string_ `$charset` (`abcdefghijklmopqrstuvwxyz`)
    > An Array or String of characters to be used in the random string


### integerArray (_$min_, _$max_, _$length_ [, _$secure_])
Returns an array of random integers

**Parameters**  
- _int_ `$min` (`0`)
	> Lower Bound of numbers returned
    
- _int_ `$max` (`PHP_INT_MAX`)
    > Upper Bound of numbers returned

- _int_ `$length` (`10`)
    > Length of generated Integer Array


### floatArray (_$min_, _$max_, _$precision_, _$length_ [, _$secure_])
Returns an array of random floating point numbers

**Parameters**  
- _int_ `$min` (`0`)
	> Lower Bound of numbers returned
    
- _int_ `$max` (`PHP_INT_MAX`)
    > Upper Bound of numbers returned

- _int_ `$precision` (`4`)
    > Number of decimal digits
Array or String
- _int_ `$length` (`10`)
    > Length of generated Integer Array


### randomize (_$input_ [, _$secure_])
Takes a Array or String and returns a randomized version of it.

**Parameters**  
- _array/string_ `$input`
	> The Array or String to be randomized

### selectRandom (_$input_, _$length_ [, _$secure_])
Selects random elements from an array or string

**Parameters**  
- _array/string_ `$input`
	> The Array or String to be randomly selected from

- _int_ `$length` (`10`)
	> Length of generated Array or String

### byte ([_$secure_])
Returns a Random Byte


### byteString (_$length_ [, _$secure_])
Returns a Random String of Bytes

**Parameters**  
- _int_ `$length` (`32`)
	> Length of generated Byte String


# Initialization Options
### $secure
**type:** `boolean`  
**default:** `true`  
To use a Cryptographically Secure Generator or not. By default, a CSPRNG
like `MCrypt` or `OpenSSL` will be used
```PHP
$casus = new Casus(false);
```
The Above example makes Casus use a Generator that is not cryptographically secure. (It just uses 
PHP's built in `mt_rand` function)

### $generator
**type:** `Generator`  
**default:** `null`  
Injects the Generator Instance to use. (Must be an instance of a child of `\solidew\Casus\Generator`)
```PHP
$generator = new \solidew\Casus\OpenSSL();
$casus = new Casus(true, $generator);
```
The Above example specifies an instance of the default OpenSSL generator.  
**Note:** If the provided generator is not secure and `$secure` is set to true, Casus will throw an
`\solidew\Casus\errors\Insecure` Exception.

#Misc Methods
### isSecure()
Returns: `boolean`  
Returns if the current Generator in use is Secure or not.

### hasMCrypt()
Returns: `boolean`  
Returns if your PHP installation has the MCrypt extension enabled or not.

### hasOpenSSL()
Returns: `boolean`  
Returns if your PHP installation has the OpenSSL extension enabled or not.

### getGenerator()
Returns: `Generator`  
Returns the current Generator Instance in use.

### setGenerator(_$secure_, _$generator_)
Returns: `boolean`  
Set a new generator based on arguments. (This is actually the method the constructor calls behind the scenes)

Returns true on success, and throws `solidew\Casus\errors\Insecure` Exception if the first parameter is true but the generator parameter is not a secure generator, or if no secure generator extension was found.

#Writing Custom Generators
##Creating a Generator
To create a generator all you have to do is write a class that extends
the abstract class `\solidew\Casus\Generator`. It is absolutely required that you implement the `integer ($min, $max)` method. (It's already an Abstract Method, so you should get an error in the event that you forget to implement it)

Example Generator:
```PHP
<?php
class SuperGenerator extends \solidew\Casus\Generator
{
	public function integer($min, $max)
    {
    	return rand($min, $max);
    }
}
```

##Using your Custom Generator
Just Pass it in as the second parameter of the Casus constructor
```PHP
<?php
$generator = new SuperGenerator();
$casus = new \solidew\Casus\Casus(false, $generator);
```

Or Just directly instantiate your Generator class (the Casus Main Class is useless anyway, it actually just forwards all the method calls to the generator instance)
```PHP
<?php
$random = new SuperGenerator();
```
**Note:** The Casus main class could be used to enforce secure Generators.

##Cryptographically Secure?
If your Generator is Cryptographically Secure (uses an CSPRNG Algorithm) then you have to specify it so that Casus doesn't complain.

You can do that simply by setting the `$secure` property in your Generator class to `true` like:
```PHP
<?php
class SuperGenerator extends \solidew\Casus\Generator
{
	protected $secure = true;
    
	public function integer($min, $max)
    {
    	return rand($min, $max);
    }
}
```

##Unit Testing Your Generator
The simplest way to Unit test your Custom Generator would be to extend the `GeneratorTest` class in Casus's `Tests` directory. The `CeneratorTest` class already extends the `PHPUnit_Framework_TestCase` class so you don't have to.

You do have to implement the `setUp()` though so that it sets the `casus` property of the TestClass Object to an instance of your Generator Class.

Example:
```PHP
<?php
include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/GeneratorTest.php';

class SuperGeneratorTest extends \GeneratorTest
{
	public function setUp() {
        $this->casus = new \AwesomePerson\SuperGenerator();
    }
}
```

This will test all the standard methods that comes packaged with Casus. You could go ahead and add tests for your Special Methods.