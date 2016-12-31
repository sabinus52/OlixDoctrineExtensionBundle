<?php
/**
 * @todo à tester : ne marche peut etre pas
 * 
 * $qb = $this->_em->createQueryBuilder();
    $qb->select('d')
       ->from('\Test\MyBundle\Entity\MyEntity', 'd')
       ->orderBy('CAST(d.myField AS UNSIGNED)', 'ASC')

    return $qb->getQuery()->getResult();
   
   
 */
namespace Olix\DoctrineExtensionBundle\Functions\PostgreSQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

class Cast extends FunctionNode
{
    public $firstDateExpression = null;
    public $secondDateExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_IDENTIFIER);
        $this->secondDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf('CAST(%s AS %s)', $this->firstDateExpression->dispatch($sqlWalker), $this->secondDateExpression->dispatch($sqlWalker));
    }
}
