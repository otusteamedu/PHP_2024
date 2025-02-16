<?php
namespace App;

use App\VerifyEmail;

class App {
    public function run() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emails = $_POST['emails'] ?? '';
            $emailList = array_map('trim', explode(',', $emails));

            $verifier = new VerifyEmail();
            $result = $verifier->verifyEmails($emailList);

            $this->renderView('form.php', ['result' => $result]);
        } else {
            $this->renderView('form.php');
        }
    }

    private function renderView($view, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $view;
    }
}
