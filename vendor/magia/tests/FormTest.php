<?php
use Magia\Model\Form\InputField;

class FormTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */

    protected $baseUrl = 'http://localhost';

    public function testBasicInputGenerator()
	{
        $inputField = new InputField('number', ['value'=>5, 'max'=>10]);
        $expected = "<input type='number' value='5' max='10' >";
        $result = $inputField->generateCode();

		$this->assertEquals($expected, $result);
	}



}
