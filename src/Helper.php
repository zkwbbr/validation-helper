<?php

declare(strict_types=1);

namespace Zkwbbr\ValidationHelper;

use Respect\Validation\Exceptions;

class Helper
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

    public function __construct()
    {

    }

    public function getErrorsHtmlWrap(): string
    {
        return $this->errorsHtmlWrap;
    }

    /**
     * Set HTML code that will wrap error messages
     *
     * Note: use pipe | as separator
     * E.g., <div class="">|</div>
     *
     * @var string
     */
    public function setErrorsHtmlWrap(string $errorsHtmlWrap)
    {
        $this->errorsHtmlWrap = $errorsHtmlWrap;
        return $this;
    }

    /**
     * Get all errors of each field (including all rules)
     *
     * @param array $rules
     * @param array $data
     * @return array
     */
    public function allErrors(array $rules, array $data): array
    {
        $errors = [];

        foreach ($rules as $k => $v) {
            try {
                $rules[$k]->assert($data[$k]);
            } catch (Exceptions\NestedValidationException $e) {
                $errors[$k] = $e->getMessages();
            }
        }

        return $errors;
    }

    /**
     * Get only first error (from first rule) of all fields
     *
     * @param array $rules
     * @param array $data
     * @return array
     */
    public function oneError(array $rules, array $data): array
    {
        $errors = [];

        foreach ($rules as $k => $v) {
            if (isset($data[$k])) {
                try {
                    $rules[$k]->check($data[$k]);
                    $errors[$k] = null;
                } catch (Exceptions\ValidationException $e) {
                    $errors[$k] = $e->getMainMessage();
                }
            } else {
                $errors[$k] = null;
            }
        }

        return $errors;
    }

    /**
     * Same as $this->oneError() method except the error messages are wrapped
     * with HTML code defined by setErrorsHtmlWrap() config method
     *
     * @param array $rules
     * @param array $data
     * @return array
     */
    public function oneErrorHtmlWrap(array $rules, array $data): array
    {
        $errors = $this->oneError($rules, $data);

        $wrap = explode('|', $this->getErrorsHtmlWrap());

        foreach ($errors as $k => $v)
            $errors[$k] = $wrap[0] . $v . $wrap[1];

        return $errors;
    }
}
