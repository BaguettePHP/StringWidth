<?php
namespace Teto;

/**
 * @license
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * @package \Teto\StringWidth
 * @license   MPL-2.0
 * @copyright 2015 USAMI Kenta
 */
final class StringWidth
{
    private $wcwidth;

    /**
     * @param callable $callback
     */
    public function __construct(callable $wcwidth = null)
    {
        $this->wcwidth = $wcwidth ?: self::getwcwidth();
    }

    /**
     * @param  string $input
     * @return int
     */
    public function getWidth($input)
    {
        $wcwidth = $this->wcwidth;
        $width = 0;
        $len   = mb_strlen($input, 'UTF-8');

        for ($i = 0; $i < $len; $i++) {
            $char = mb_substr($input, $i, 1, 'UTF-8');
            $width += $wcwidth($char);
        }

        return $width;
    }

    /**
     * @param  string $input
     * @return int
     */
    public static function asSingle($input)
    {
        static $single;
        if (empty($single)) {
            $single = new StringWidth([new \Teto\StringWidth\Tanasinn\Single, 'wcwidth']);
        }

        return $single->getWidth($input);
    }

    /**
     * @param  string $input
     * @return int
     */
    public static function asDouble($input)
    {
        static $double;
        if (empty($double)) {
            $double = new StringWidth([new \Teto\StringWidth\Tanasinn\Double, 'wcwidth']);
        }

        return $double->getWidth($input);
    }

    /**
     * @return callable
     */
    public static function getwcwidth()
    {
        static $cjk = ['zh', 'ja', 'ko'];

        return in_array(substr(\Locale::getDefault(), 2), $cjk, true)
            ? [new \Teto\StringWidth\Tanasinn\Double, 'wcwidth']
            : [new \Teto\StringWidth\Tanasinn\Single, 'wcwidth']
            ;
    }
}
