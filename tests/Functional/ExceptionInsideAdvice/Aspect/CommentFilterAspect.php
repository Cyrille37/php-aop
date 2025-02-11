<?php
/** @noinspection PhpUnused */
namespace Okapi\Aop\Tests\Functional\ExceptionInsideAdvice\Aspect;

use Exception;
use Okapi\Aop\Attributes\Aspect;
use Okapi\Aop\Attributes\Before;
use Okapi\Aop\Invocation\BeforeMethodInvocation;

#[Aspect]
class CommentFilterAspect
{
    /**
     * @throws Exception
     */
    #[Before(
        class: 'Okapi\Aop\Tests\Functional\ExceptionInsideAdvice\ClassesToIntercept\CommentController',
        method: 'saveComment',
    )]
    public function checkForInappropriateLanguage(BeforeMethodInvocation $invocation): void
    {
        $comment = $invocation->getArgument('comment');

        $inappropriateWords = ['bad', 'terrible', 'awful'];

        foreach ($inappropriateWords as $word) {
            if (str_contains($comment, $word)) {
                throw new Exception('Comment contains inappropriate language!');
            }
        }
    }
}
