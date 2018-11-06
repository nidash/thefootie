<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 05/11/2018
 * Time: 17:05
 */

namespace App\Tests\Utils;

use App\Utils\JWTManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JWTManagerTest extends KernelTestCase {
  /**
   * @var \App\Utils\JWTManager
   */
  protected $jwt;

  public function __construct(
    ?string $name = NULL,
    array $data = [],
    string $dataName = ''
  ) {
    parent::__construct($name, $data, $dataName);
    self::bootKernel();
    $this->jwt = new JWTManager('prefix','name', self::$kernel->getContainer());
  }

  public function testEncode() {
    $data = ['id' => 1, 'name' => 'Sunshine'];
    $this->assertEquals('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlN1bnNoaW5lIn0.Cjalh3SCepYvEg1CUlfh3m36jjlBJ69AZHs1ev5lPr8', $this->jwt->encode($data));
  }

  public function testDecode() {
    $string = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6IlN1bnNoaW5lIn0.Cjalh3SCepYvEg1CUlfh3m36jjlBJ69AZHs1ev5lPr8';

    echo "\n i am returning";
    print_r($this->jwt->decode($string));

    //$this->assertJson(['id':1,'name':'Sunshine'], $this->jwt->decode($string));

    //$this->assertArraySubset(['name' => 'hello'], $this->jwt->decode($string));
  }

}
