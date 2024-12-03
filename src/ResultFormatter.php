<?php

namespace EmailVerifier;

class ResultFormatter
{
    public function format(array $results): string
    {
        $output = str_pad("Email", 30) . str_pad("Validity", 15) . "Existence\n";
        $output .= str_repeat("-", 50) . "\n";

        foreach ($results as $result) {
            $output .= str_pad($result['email'], 30);
            $output .= str_pad($result['valid'] ? 'Valid' : 'Invalid', 15);
            $output .= $result['exists'] ? 'Exists' : 'Does not exist';
            $output .= "\n";
        }

        return $output;
    }
}
