<?

class Email
{
  private array $emails;
  private $regularExpressions = "/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i";
  public function __construct(array $emails)
  {
    $this->emails = $emails;
  }

  public function checkMailAddress()
  {
    $record = "MX";
    $message = [];
    foreach ($this->emails as $email) {
      if (!preg_match($this->regularExpressions, $email)) {
        $message[$email] = "Не правильно написан адрес\n";
      } else {
        list($address, $domain) = explode("@", $email);

        if (!checkdnsrr($domain, $record)) {
          $message[$email] = "Такого email не существует \n";
        } else {
          $message[$email] = "Email введен верно \n";
        }
      }
    }
    return $message;
  }
}
