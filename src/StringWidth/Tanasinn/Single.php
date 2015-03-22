<?php
namespace Teto\StringWidth\Tanasinn;

/**
 * @license
 * ***** BEGIN LICENSE BLOCK *****
 * Version: MPL 1.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 * The Original Code is tanasinn
 * The Initial Developer of the Original Code is * Hayaki Saito.
 * Portions created by the Initial Developer are Copyright (C) 2010 - 2011
 * the Initial Developer. All Rights Reserved.
 * ***** END LICENSE BLOCK *****
 *
 * - USAMI Kenta ported to PHP from JavaScript.
 */

/**
 * @package \Teto\StringWidth\Tanasinn
 * @license MPL-1.1
 * @copyright 2010-2011 Hayaki Saito
 * @copyright 2015 USAMI Kenta
 */
class Single
{
    /**
     * @param  string $s UTF-8 String
     * @return int
     */
    public static function wcwidth($s)
    {
        $c = intval(unpack('H*', mb_convert_encoding($s, 'UTF-16', 'UTF-8'))[1], 16);

        if ($c < 0x10000) {
            if (preg_match(Pattern::RE_AMB_AS_SINGLE_2, $s)) {
                return 2;
            } elseif (preg_match(Pattern::RE_WIDTH_0_CHARS, $s)) {
                return 0;
            }
            return 1;
        } elseif ($c < 0x1F200) {
            return 1;
        } elseif ($c < 0x1F300) {
            return 2;
        } elseif ($c < 0x20000) {
            return 1;
        } elseif ($c < 0xE0000) {
            return 2;
        }
        return 1;
    }
}
