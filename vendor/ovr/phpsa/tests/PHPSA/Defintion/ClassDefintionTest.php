<?php

namespace Tests\PHPSA\Defintion;

use PHPSA\Definition\ClassDefinition;
use Tests\PHPSA\TestCase;

class ClassDefintionTest extends TestCase
{
    /**
     * @return ClassDefinition
     */
    protected function getSimpleInstance()
    {
        return new ClassDefinition('MyTestClass', 0);
    }

    public function testSimpleInstance()
    {
        $classDefinition = $this->getSimpleInstance();
        $this->assertSame('MyTestClass', $classDefinition->getName());
        $this->assertFalse($classDefinition->isCompiled());
    }

    public function testScopePointer()
    {
        $classDefinition = $this->getSimpleInstance();

        $pointer = $classDefinition->getPointer();
        $this->assertInstanceOf('PHPSA\ScopePointer', $pointer);
        $this->assertEquals($classDefinition, $pointer->getObject());
    }

    public function testSetGetHasForClassProperty()
    {
        $classDefinition = $this->getSimpleInstance();
        $this->assertFalse($classDefinition->hasProperty('test1'));
        $this->assertFalse($classDefinition->hasProperty('test2'));

        $property = new \PhpParser\Node\Stmt\Property(
            0,
            array(
                new \PhpParser\Node\Stmt\PropertyProperty(
                    'test1',
                    new \PhpParser\Node\Scalar\String_(
                        'test string'
                    )
                )
            )
        );
        $classDefinition->addProperty($property);

        $this->assertTrue($classDefinition->hasProperty('test1'));
        $this->assertFalse($classDefinition->hasProperty('test2'));

        $property = new \PhpParser\Node\Stmt\Property(
            0,
            array(
                new \PhpParser\Node\Stmt\PropertyProperty(
                    'test2',
                    new \PhpParser\Node\Scalar\String_(
                        'test string'
                    )
                )
            )
        );
        $classDefinition->addProperty($property);

        $this->assertTrue($classDefinition->hasProperty('test1'));
        $this->assertTrue($classDefinition->hasProperty('test2'));
    }

    public function testMethodSetGet()
    {
        $classDefinition = $this->getSimpleInstance();
        $methodName = 'method1';
        $nonExistsMethodName = 'method2';

        $this->assertFalse($classDefinition->hasMethod($methodName));
        $this->assertFalse($classDefinition->hasMethod($nonExistsMethodName));

        $classDefinition->addMethod(
            new \PHPSA\Definition\ClassMethod(
                $methodName,
                new \PhpParser\Node\Stmt\ClassMethod(
                    $methodName
                ),
                0
            )
        );

        $this->assertTrue($classDefinition->hasMethod($methodName));
        $this->assertFalse($classDefinition->hasMethod($nonExistsMethodName));

        $method = $classDefinition->getMethod($methodName);
        $this->assertInstanceOf('PHPSA\Definition\ClassMethod', $method);
        $this->assertSame($methodName, $method->getName());

        return $classDefinition;
    }
}
