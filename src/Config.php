<?php

declare(strict_types=1);

namespace Zkwbbr\ValidationHelper;

class Config
{
    /**
     * HTML code that will wrap error messages
     *
     * Note: use pipe | as separator
     * E.g., <div class="">|</div>
     *
     * @var string
     */
    private $errorsHtmlWrap;

    public function getErrorsHtmlWrap(): string
    {
        return $this->errorsHtmlWrap;
    }

    public function setErrorsHtmlWrap(string $errorsHtmlWrap)
    {
        $this->errorsHtmlWrap = $errorsHtmlWrap;
        return $this;
    }
}
