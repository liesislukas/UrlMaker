<?php
// Can be used without Phalcon, just delete "extends Plugin" and this next line of code:
use Phalcon\Mvc\User\Plugin;

class UrlMaker extends Plugin
{
    public $removeAlwaysVar = array('_url');
    public $urlParts = array();

    public function __construct()
    {
        return $this->reset();;
    }

    public function reset()
    {
        $urlParts = $_GET;
        $this->urlParts = $urlParts;
        foreach ($this->removeAlwaysVar as $var) {
            $this->removeVar($var);
        }
        return $this;
    }

    public function removeVarGlobally($var)
    {
        if (!in_array($var, $this->removeAlwaysVar)) {
            $this->removeAlwaysVar[] = $var;
        }
        $this->removeVar($var);
        return $this;
    }

    /* check if this value is current value */
    public function isCurrent($var, $val)
    {
        if (isset($this->urlParts[$var])) {
            $vals = explode(',', $this->urlParts[$var]);
            if (in_array($val, $vals)) {
                return true;
            }
        }
        return false;
    }

    /* change one of the vars in url value */
    public function setVal($var, $val)
    {
        $this->urlParts[$var] = $val;
        return $this;
    }

    /* get one of the vars in url value */
    public function getVal($var)
    {
        return (isset($this->urlParts[$var])) ? $this->urlParts[$var] : null;
    }

    public function changeVal($var, $old_val, $new_val, $force_change = true)
    {
        if (isset($this->urlParts[$var])) {
            $vals = explode(',', $this->urlParts[$var]);
            foreach ($vals as $x => $y) {
                if ($y == $old_val) {
                    $vals[$x] = $new_val;
                }
            }
            $vals = array_unique($vals);
            $this->urlParts[$var] = implode(',', $vals);
        } else {
            if ($force_change) {
                $this->urlParts[$var] = $new_val;
            }
        }
        return $this;
    }

    /* add one of the vars in url value */
    public function addVal($var, $val)
    {
        if (isset($this->urlParts[$var])) {
            $vals = explode(',', $this->urlParts[$var]);
            foreach ($vals as $x => $y) {
                if (trim($y) == '') {
                    unset($vals[$x]);
                }
            }
            $vals[] = $val;
            $vals = array_unique($vals);
            $this->urlParts[$var] = implode(',', $vals);
        } else {
            $this->urlParts[$var] = $val;
        }

        return $this;
    }

    public function removeVar($var)
    {
        $var = trim($var);
        if (isset($this->urlParts[$var])) {
            unset($this->urlParts[$var]);
        }
        return $this;
    }

    // comma separated set of vars: var,var,var
    public function removeVars($vars)
    {
        $vars = explode(',', $vars);
        foreach ($vars as $var) {
            $this->removeVar($var);
        }
        return $this;
    }

    public function removeVal($var, $val)
    {
        if (isset($this->urlParts[$var])) {
            $vals = explode(',', $this->urlParts[$var]);
            foreach ($vals as $x => $y) {
                if ($y == $val) {
                    unset($vals[$x]);
                }
                if ($y == '') {
                    unset($vals[$x]);
                }
            }
            $this->urlParts[$var] = implode(',', $vals);
        }
        return $this;
    }

    // return query elements as hidden form inputs
    public function getQueryAsInputs($show_empty = false)
    {
        // <input type="hidden" name="" value=""/>
        $urlParts = $this->urlParts;
        if ($show_empty == false) {
            foreach ($urlParts as $var => $val) {
                if ($val == '') {
                    unset($urlParts[$var]);
                }
            }
        }
        $html = '';
        // make var=value pairs
        foreach ($urlParts as $var => $val) {
            $html .= '<input type="hidden" name="' . $var . '" value="' . $val . '"/>' . "\n";
        }
        return $html;
    }

    public function getQuery($show_empty = false, $reset = true)
    {
        $urlParts = $this->urlParts;
        if ($show_empty == false) {
            foreach ($urlParts as $var => $val) {
                if ($val == '') {
                    unset($urlParts[$var]);
                }
            }
        }
        $url = array();

        // make var=value pairs
        foreach ($urlParts as $var => $val) {
            $url[] = "$var=$val";
        }

        $url = '?' . implode('&', $url);

        if ($reset) {
            $this->reset();
        }

        return $url;
    }


}

?>
