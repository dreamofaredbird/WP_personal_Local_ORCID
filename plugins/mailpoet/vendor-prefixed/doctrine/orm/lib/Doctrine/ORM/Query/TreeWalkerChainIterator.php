<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace MailPoetVendor\Doctrine\ORM\Query;

if (!defined('ABSPATH')) exit;


/**
 * 
 */
class TreeWalkerChainIterator implements \Iterator, \ArrayAccess
{
    /**
     * @var TreeWalker[]
     */
    private $walkers = array();
    /**
     * @var TreeWalkerChain
     */
    private $treeWalkerChain;
    /**
     * @var
     */
    private $query;
    /**
     * @var
     */
    private $parserResult;
    public function __construct(\MailPoetVendor\Doctrine\ORM\Query\TreeWalkerChain $treeWalkerChain, $query, $parserResult)
    {
        $this->treeWalkerChain = $treeWalkerChain;
        $this->query = $query;
        $this->parserResult = $parserResult;
    }
    /**
     * {@inheritdoc}
     */
    function rewind()
    {
        return \reset($this->walkers);
    }
    /**
     * {@inheritdoc}
     */
    function current()
    {
        return $this->offsetGet(\key($this->walkers));
    }
    /**
     * {@inheritdoc}
     */
    function key()
    {
        return \key($this->walkers);
    }
    /**
     * {@inheritdoc}
     */
    function next()
    {
        \next($this->walkers);
        return $this->offsetGet(\key($this->walkers));
    }
    /**
     * {@inheritdoc}
     */
    function valid()
    {
        return \key($this->walkers) !== null;
    }
    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->walkers[$offset]);
    }
    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return new $this->walkers[$offset]($this->query, $this->parserResult, $this->treeWalkerChain->getQueryComponents());
        }
        return null;
    }
    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (\is_null($offset)) {
            $this->walkers[] = $value;
        } else {
            $this->walkers[$offset] = $value;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->walkers[$offset]);
        }
    }
}
