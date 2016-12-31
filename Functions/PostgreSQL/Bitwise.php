<?php
/**
 * @todo à testers
 */

namespace Olix\DoctrineExtensionBundle\Functions\PostgreSQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;
class Bitwise extends FunctionNode {
    protected $field;
    protected $value;
    protected $operator;
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->value = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->operator = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return $this->field->dispatch($sqlWalker) . ' ' . str_replace("'", "", $this->operator->dispatch($sqlWalker))
            . ' ' . $this->value->dispatch($sqlWalker);
    }
}
