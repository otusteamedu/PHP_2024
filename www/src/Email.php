<?

class Email
{
  private $email;
  private $regularExpressions = "/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i";
  public function __construct($email)
  {
    $this->email = $email;
  }

  public function checkMailAddress()
  {
    $record = "MX";
    $message = "";

    if (!preg_match($this->regularExpressions, $this->email)) {
      $message .= "Не правильно написан адрес \n";
      return $message;
    }

    list($address, $domain) = explode("@", $this->email);

    if (!checkdnsrr($domain, $record)) {
      $message .= "Такого email не существует \n";
    } else {
      $message .= "Email введен верно \n";
    }
    return $message;
  }
}
