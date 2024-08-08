<?
require_once "./src/Email.php";

class App
{
  private $emailAddress;
  public function __construct($emailAddress)
  {
    $this->emailAddress = $emailAddress;
  }
  public function checkEmail()
  {
    $email = new Email($this->emailAddress);
    $checkAddress = $email->checkMailAddress();
    return $checkAddress;
  }
}
