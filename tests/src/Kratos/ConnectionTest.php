<?php

namespace Kratos;

use PDO;
use stdClass;
use PHPUnit_Framework_TestCase as PHPUnit;
class ConnectionTest extends PHPUnit {
    protected $con;
    public function setup()
    {
        $this->con = new Connection(new PDO('mysql:host=127.0.0.1;port=3306;dbname=emprestame','root','1234'));
    }
    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage $connection must be an instance of PDO.
     */
    public function testInvalidSetup()
    {
        $con = new Connection(new stdClass);
        throw new InvalidArgumentException($con, 10);
    }

    public function testGetById()
    {
        $contato = $this->con->contato->getById(1);
        $this->assertEquals($contato['email'], 'kiltoncls@gmail.com');
    }
    public function testGetByArguments()
    {
        $res = $this->con->contato->getByArguments(array('nome' => 'willian'));
        $this->assertTrue($res);
    }
    public function testGetAll()
    {
        $all = $this->con->contato->getAll();
        $this->assertNotEmpty($all);
    }
    public function testInsert()
    {
        $data['id'] = 10;
        $data['nome'] = 'Willian Mano';
        $data['email'] = 'willianmanoaraujo@gmail.com';
        $data['telefone'] = '9888776655';

        $insert = $this->con->contato->insert($data);
        $this->assertNotEmpty($insert);
    }
    public function testUpdate()
    {
        $data['id'] = 10;
        $data['nome'] = 'Willian Mano Araujo';
        $data['email'] = 'willianmanoaraujo@gmail.com';
        $data['telefone'] = '9888776655';

        $update = $this->con->contato->update($data);
        $this->assertEquals($update, $data['id']);
    }
    public function testDelete()
    {
        $delete = $this->con->contato->delete(10);
        $this->assertTrue($delete);
    }
    public function testInvalidDelete()
    {
        $delete = $this->con->contato->delete(100);
        $this->assertFalse($delete);
    }
    public function tearDown()
    {

    }
}