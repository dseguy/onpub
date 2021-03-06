<?php

/**
 * @author {@link mailto:corey@onpub.com Corey H.M. Taylor}
 * @copyright Onpub (TM). Copyright 2015, Onpub.com.
 * {@link http://onpub.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * Version 2
 * @package onpubgui
 */
class OnpubWidgetPDOException
{
  private $exception;
  private $header;
  private $footer;

  function __construct($exception, $header = TRUE, $footer = TRUE)
  {
    $this->exception = $exception;
    $this->header = $header;
    $this->footer = $footer;
  }

  public function display()
  {
    if ($this->header) {
      $widget = new OnpubWidgetHeader("PDO Exception");
      $widget->display();
    }

    en('<h3 class="onpub-field-header">Error Message</h3><p class="onpub-error">' . $this->exception->getMessage() . '</p>');

    en('<h3 class="onpub-field-header">Error Code</h3><p>' . $this->exception->getCode() . '</p>');

    $sqlstate = $this->exception->errorInfo[0];

    en('<h3 class="onpub-field-header">SQLSTATE Code</h3><p>' . $sqlstate . '</p>');

    en('<h3 class="onpub-field-header">Trace 0</h3><p>File: ' . $this->exception->getFile() . '. Line: ' . $this->exception->getLine() . '.</p>');

    $trace = $this->exception->getTrace();

    for ($i = 0; $i < sizeof($trace); $i++) {
      en('<h3 class="onpub-field-header">Trace ' . ($i + 1) . '</h3>', 0);
      en('<p>Method: ' . $trace[$i]['class'] . $trace[$i]['type'] . $trace[$i]['function'] . '().');
      en('File: ' . $trace[$i]['file'] . '.', 0);
      en(' Line: ' . $trace[$i]['line'] . '.</p>', 0);

    }

    if ($this->footer) {
      $widget = new OnpubWidgetFooter();
      $widget->display();
    }
  }
}
?>