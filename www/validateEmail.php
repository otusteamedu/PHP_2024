<?php
function validateEmails(array $emails): array {
    $validEmails = [];

    foreach ($emails as $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain = explode('@', $email)[1];

            if (checkdnsrr($domain)) {
                $validEmails[] = $email;
            }
        }
    }

    return $validEmails;
}


$emailList = [
    'test@example.com',
    'test2@domain',
    'te@st@test1.com',
    'test3@google.com',
    'test4@otus.com',
    'test5@@@example.com'
];

$validatedEmails = validateEmails($emailList);

echo "Валидные email:\n";
print_r($validatedEmails);