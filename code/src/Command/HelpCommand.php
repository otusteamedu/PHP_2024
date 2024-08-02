<?php

declare(strict_types=1);

namespace Viking311\Books\Command;

class HelpCommand
{
    /**
     * @return void
     */
    public function run(): void
    {
        $content = 'Search help' . PHP_EOL;
        $content .= 'php ./app.php [OPTIONS]' . PHP_EOL;
        $content .= 'Options:' . PHP_EOL;
        $content .= "\t-h\tВывод справки" .PHP_EOL;
        $content .= "\t-c\tПоисковая фраза" .PHP_EOL;
        $content .= "\t-l\tЦена меньше чем" .PHP_EOL;
        $content .= "\t-e\tЦена равна" .PHP_EOL;
        $content .= "\t-g\tЦена больше чем" .PHP_EOL;

        fwrite(STDOUT, $content) ;
    }
}
