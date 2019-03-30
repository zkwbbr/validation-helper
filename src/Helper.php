<?php

declare(strict_types=1);

namespace Zkwbbr\ValidationHelper;

use Respect\Validation\Exceptions;

class Helper
{
    private $cfg;

    public function __construct(?Config $cfg)
    {
        $this->cfg = $cfg;
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

        $wrap = explode('|', $this->cfg->getErrorsHtmlWrap());

        foreach ($errors as $k => $v)
            $errors[$k] = $wrap[0] . $v . $wrap[1];

        return $errors;
    }
}
