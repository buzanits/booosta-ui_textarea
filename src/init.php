<?php
namespace booosta\ui_textarea;

\booosta\Framework::add_module_trait('webapp', 'ui_textarea\webapp');

trait webapp
{
  protected function preparse_ui_textarea()
  {
    $path = 'vendor/npm-assets/jquery-text-counter';

    if($this->moduleinfo['ui_textarea']):
      $this->add_includes("<script type='text/javascript' src='{$this->base_dir}$path/textcounter.js'></script>");
    endif;
  }
}
