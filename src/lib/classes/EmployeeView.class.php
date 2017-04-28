<?php

/**
 * Employee view - creates the HTML for employee.php
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeView {
  private $_model;

  public function __construct (Employee $model) {
    $this->_model = $model;
  }

  /**
   * Get HTML for back link
   *
   * @return {String}
   */
  private function _getBackLink () {
    return '<p class="back">&laquo; <a href="../">Back to Staff Directory</a></p>';
  }

  /**
   * Get HTML for Employee details table
   *
   * @return $html {String}
   */
  private function _getEmployee () {
    $html = '<table>';

    if ($this->_model->phone) {
      $html .= sprintf('<tr><th>Phone</th><td>%s</td></tr>',
        $this->_model->phone
      );
    }
    $html .= sprintf('<tr><th>Email</th><td><a href="mailto:%s">%s</a></td></tr>',
      $this->_model->email,
      $this->_model->email
    );
    if ($this->_model->room) {
      $html .= sprintf('<tr><th>Room</th><td>%s</td></tr>',
        $this->_model->room
      );
    }
    $html .= sprintf('<tr><th>Address</th><td>%s</td></tr>',
      $this->_model->getAddress()
    );
    if ($this->_model->webpage) {
      $html .= sprintf('<tr><th>Web</th><td><a href="%s">%s</a></td></tr>',
        $this->_model->webpage,
        $this->_model->webpage
      );
    }
    if ($this->_model->orcid) {
      $html .= sprintf('<tr><th>ORCid</th><td>
          <a href="https://orcid.org/%s">https://orcid.org/%s</a>
        </td></tr>',
        $this->_model->orcid,
        $this->_model->orcid
      );
    }

    $html .= '</table>';

    return $html;
  }

  /**
   * Render HTML
   */
  public function render () {
    print $this->_getEmployee();
    print $this->_getBackLink();
  }
}
