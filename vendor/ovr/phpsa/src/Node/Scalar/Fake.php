<?php

namespace PHPSA\Node\Scalar;

class Fake extends \PhpParser\Node\Scalar
{
    /** @var mixed */
    public $value;

    /** @var mixed */
    public $type;

    /**
     * Constructs a fake node.
     *
     * @param mixed $value      Value of the Node
     * @param mixed $type      Type of the node
     * @param array $attributes Additional attributes
     */
    public function __construct($value, $type, array $attributes = array())
    {
        parent::__construct($attributes);

        $this->value = $value;
        $this->type = $type;
    }

    //@codeCoverageIgnoreStart
    public function getSubNodeNames()
    {
        return array('value', 'type');
    }
    //@codeCoverageIgnoreEnd
}
