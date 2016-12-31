<?php
/**
 * Fonction PostgresSQL ILIKE
 *
 * @author Olivier <sabinus52@gmail.com>
 *
 * @package Olix
 * @subpackage ImportFluxBundle
 */

namespace Olix\DoctrineExtensionBundle\Functions\PostgreSQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;


class Ilike extends FunctionNode
{

    /**
     * Nom du champs
     */
    protected $field;

    /**
     * Valeur du champs
     */
    protected $value;


    /**
     * {@inheritDoc}
     * @see \Doctrine\ORM\Query\AST\Functions\FunctionNode::parse()
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->value = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }


    /**
     * {@inheritDoc}
     * @see \Doctrine\ORM\Query\AST\Functions\FunctionNode::getSql()
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return '('.$this->field->dispatch($sqlWalker) . ' ILIKE ' . $this->value->dispatch($sqlWalker).')';
    }

}
