<?php
/**
 * @package phpSource
 */

namespace Wsdl2PhpGenerator\PhpSource;

/**
 * Class that represents the source code for a function in php
 *
 * @package phpSource
 * @author Fredrik Wallgren <fredrik.wallgren@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class PhpFunction extends PhpElement
{
    /**
     *
     * @var string String containing the params to the function
     * @access private
     */
    private $params;

    /**
     *
     * @var The code inside {}
     * @access private
     */
    private $source;

    /**
     *
     * @var PhpDocComment A comment in phpdoc format that describes the function
     * @access private
     */
    private $comment;

    /**
     *
     * @param string $access
     * @param string $identifier
     * @param string $params
     * @param string $source
     * @param PhpDocComment $comment
     */
    public function __construct($access, $identifier, $params, $source, PhpDocComment $comment = null)
    {
        $this->access = $access;
        $this->identifier = $identifier;
        $this->params = $params;
        $this->source = $source;
        $this->comment = $comment;
    }

    /**
     *
     * @return string Returns the complete source code for the function
     * @access public
     */
    public function getSource()
    {
        $ret = '' . PHP_EOL;

        if ($this->comment !== null) {
            $ret .= $this->getSourceRow($this->comment->getSource());
        }

        $ret .= $this->getSourceRow(trim($this->access . ' function ' . $this->identifier . '(' . $this->params . ')'));
        if ($this->source !== null) {
            $ret .= $this->getSourceRow('{');
            // do not create function empty space function PSR-2
            if ($this->source != '') {
                // Use 4 spaces as indention, as requested by PSR-2
                $ret .= $this->getSourceRow(str_replace('  ', '    ', $this->source));
            }
            $ret .= $this->getSourceRow('}');
        } else {
            $ret .= $this->getSourceRow(';');

            // if it has a row with only ; we need to put them at the end of the function
            $ret = str_replace(PHP_EOL . '    ;', ';', $ret);
        }

        return $ret;
    }
}
