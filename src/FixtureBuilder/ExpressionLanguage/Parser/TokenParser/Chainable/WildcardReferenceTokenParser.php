<?php

/*
 * This file is part of the Alice package.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Parser\TokenParser\Chainable;

use Nelmio\Alice\Definition\Value\FixtureMatchReferenceValue;
use Nelmio\Alice\Exception\FixtureBuilder\ExpressionLanguage\ParseException;
use Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Parser\ChainableTokenParserInterface;
use Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Token;
use Nelmio\Alice\FixtureBuilder\ExpressionLanguage\TokenType;
use Nelmio\Alice\NotClonableTrait;

final class WildcardReferenceTokenParser implements ChainableTokenParserInterface
{
    use NotClonableTrait;

    /**
     * @inheritdoc
     */
    public function canParse(Token $token): bool
    {
        return $token->getType()->getValue() === TokenType::WILDCARD_REFERENCE_TYPE;
    }

    /**
     * Parses expressions such as '$username'.
     *
     * {@inheritdoc}
     *
     * @throws ParseException
     */
    public function parse(Token $token)
    {
        $value = $token->getValue();
        $fixtureId = substr($value, 1, strlen($value) - 2);
        if (false === $fixtureId) {
            throw ParseException::createForToken($token);
        }

        return new FixtureMatchReferenceValue(
            sprintf('/^%s.*', $fixtureId)
        );
    }
}
