<?php
namespace Teto;

/**
 * @license
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

final class StringWidthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderFor_test_as_single
     */
    public function test_as_single($expected, $input)
    {
        $wcwidth = [new \Teto\StringWidth\Tanasinn\Single, 'wcwidth'];
        $actual = new StringWidth($wcwidth);

        $this->assertEquals($expected, $actual->getWidth($input));
    }

    public function dataProviderFor_test_as_single()
    {
        return [
            [0, ''],
            [1, 'a'],
            [1, "\n"],
            [3, 'abc'],
            [3, '☆☆☆'],
            [6, 'あいう'],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_as_double
     */
    public function test_as_double($expected, $input)
    {
        $wcwidth = [new \Teto\StringWidth\Tanasinn\Double, 'wcwidth'];
        $actual = new StringWidth($wcwidth);

        $this->assertEquals($expected, $actual->getWidth($input));
    }

    public function dataProviderFor_test_as_double()
    {
        return [
            [0, ''],
            [1, 'a'],
            [1, "\n"],
            [3, 'abc'],
            [6, '☆☆☆'],
            [6, 'あいう'],
        ];
    }
}
