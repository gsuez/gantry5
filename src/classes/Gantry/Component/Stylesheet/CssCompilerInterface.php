<?php

/**
 * @package   Gantry5
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   Dual License: MIT or GNU/GPLv2 and later
 *
 * http://opensource.org/licenses/MIT
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Gantry Framework code that extends GPL code is considered GNU/GPLv2 and later
 */

namespace Gantry\Component\Stylesheet;

interface CssCompilerInterface
{
    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target = null);

    /**
     * @param string $configuration
     * @return $this
     */
    public function setConfiguration($configuration = null);

    /**
     * @param array $paths
     * @return $this
     */
    public function setPaths(array $paths = null);

    /**
     * @param array $files
     * @return $this
     */
    public function setFiles(array $files = null);

    /**
     * @param string $name
     * @return string
     */
    public function getCssUrl($name);

    public function getVariables();
    public function setVariables(array $variables);
    public function compileFile($in, $out = null);

    /**
     * @return $this
     */
    public function compileAll();

    public function resetCache();
}
