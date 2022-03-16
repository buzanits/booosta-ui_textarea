<?php
namespace booosta\ui_textarea;

use \booosta\Framework as b;
b::init_module('ui_textarea');

class Ui_textarea extends \booosta\ui\UI
{
  use moduletrait_ui_textarea;

  protected $textarea;
  protected $placeholder;
  protected $max;
  protected $message;
  protected $counttext;

  public function __construct($name = null, $value = null, $cols = 50, $rows = 3)
  {
    parent::__construct();
    $this->textarea = $this->makeInstance("\\booosta\\formelements\\Textarea", $name, $value, $cols, $rows);
    $this->textarea->set_id("ui_textarea_$name");
    $this->id = "ui_textarea_$name";
    $this->placeholder = $caption;
    $this->extra = '';
  }

  public function after_instanciation()
  {
    parent::after_instanciation();

    if(is_object($this->topobj) && is_a($this->topobj, "\\booosta\\webapp\\Webapp")):
      $this->topobj->moduleinfo['ui_textarea'] = true;
      if($this->topobj->moduleinfo['jquery']['use'] == '') $this->topobj->moduleinfo['jquery']['use'] = true;
    endif;
  }

  public function set_placeholder($placeholder) { $this->placeholder = $placeholder; }
  public function add_extra($code) { $this->extra .= $code; }
  public function set_max($max) { $this->max = $max; }
  public function set_message($message) { $this->message = $message; }
  public function set_counttext($counttext) { $this->counttext = $counttext; }

  public function get_htmlonly() { 
    return $this->textarea->get_html(); 
  }

  public function get_js()
  {
    $code = '';
    $extra .= $this->extra;

    $params = ['stopInputAtMaximum: true', 'countSpaces: true', 'countDown: true'];
    if($this->max) $params[] = "max: $this->max";
    if($this->message) $params[] = "maximumErrorText: '$this->message'";
    if($this->counttext) $params[] = "countDownText: '$this->counttext'";
    $paramstr = implode(',', $params);

    if(is_object($this->topobj) && is_a($this->topobj, "\\booosta\\webapp\\webapp")):
      $this->topobj->add_jquery_ready("\$('#$this->id').textcounter({ $paramstr });");
      return '';
    else:
      return "\$(document).ready(function(){ \$('#$this->id').textcounter({ $paramstr }); })";
    endif;
  }

  public function __call($name, $args)
  {
    return call_user_func_array([$this->textarea, $name], $args);
  }
}
