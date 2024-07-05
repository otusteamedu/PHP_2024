<?php
declare(strict_types = 1);



foreach (glob("src/Persons/*.php") as $filename)
{
    include_once $filename;
};
foreach (glob("src/Subjects/*.php") as $filename)
{
    include_once $filename;
};

use \Kyberlox\ComposerTest\subj\Subject as Subject;

use \Kyberlox\ComposerTest\psn\Person as Person;
use \Kyberlox\ComposerTest\psn\{sword\Swordsman as Swordsman, arch\Archer as Archer, spear\Spearman as Spearman};

use \Kyberlox\ComposerTest\subj\erea\Еreatment as Еreatment;

$stick = new Subject("дубинка", 7.5);

$sword = new Subject("ржавый меч", 10);
$bow = new Subject("погнутый лук", 5);
$spear = new Subject("кривое копьё", 15);

$shield = new Subject("дырявый щит", 10);
$dagger = new Subject("тупой кинжал", 5);
$armour = new Subject("старый доспех", 15);

$peasant = new Person("Крестьянин", 100, $stick, $stick, 0, 0);
$guardian = new Swordsman("Стражник", 100, $sword, $shield, 0, 0);
$hunter = new Archer("Охотник", 90, $bow , $dagger, 0, 0);
$infantryman = new Spearman("Пехотинец", 100, $spear, $armour, 0, 0);

$blessing = new Еreatment("благословение Короля", 25);

$bandits = [$peasant, $hunter];
$guard = [$guardian, $infantryman];


$evil_time = true;
echo "</br> <h1> Разбойники напали на Королевтсво! </h1> </br></br></br>";

while ( (($peasant->health>=0) && ($hunter->health>=0)) || (($guardian->health>=0) && ($infantryman->health>=0)) )
{
    //БИТВА

    //определим очередность хода
    if ($evil_time){
        //зло атакует
        $current_grup = $bandits;
        $answer_group = $guard;
        $evil_time = false;

        //по умолчанию юниты дерутся отчаянно и используют свои особые навыки (чтобы не затягивать бой)
        if ($hunter->health > 0) {$hunter->aim();};
        if ($peasant->health > 0) {$peasant->attack();};
    }
    else
    {
        //ход стражи
        $current_grup = $guard;
        $answer_group = $bandits;
        $evil_time = true;

        //по умолчанию юниты дерутся отчаянно и используют свои особые навыки (чтобы не затягивать бой)
        if ($guardian->health > 0){$guardian->jump();};
        if ($infantryman->health > 0){$infantryman->cast();};
    };

    //стратения нападения
    foreach ($current_grup as $cur_gr)
    {
        //будет ли отряд биться отчаянно?
        if (rand(0, 1) == 0)
        {
            //базовая атака
            if ($cur_gr->health > 0) {
            $cur_gr->attack();
            };
        };
    };

    //стратегия защиты
    $strategy = rand(0, 2);
    $prot = false;
    switch ($strategy){
        //держать оборону
        case 0:
            foreach ($answer_group as $ans_gr)
            {
                $ans_gr->protect();
                $prot = true;
            };
            break;
        //контратака
        case 1:
            foreach ($answer_group as $ans_gr)
            {
                $ans_gr->attack();
            };
            break;
        //отчаянная контратака
        case 2:
            //определено как действие по умолчанию
            break;
    };
    
    foreach($current_grup as $cur_psn){
        foreach ($answer_group as $ans_psn){
            if ($prot){
                $ans_psn->health = $ans_psn->health + $ans_psn->protection_points - $cur_psn->damge_points;
            }
            else{
                $ans_psn->health = $ans_psn->health - $cur_psn->damge_points;
                $cur_psn->health = $cur_psn->health - $ans_psn->damge_points;
            };
        };
    };

    //echo $peasant->name, " : ", $peasant->health, " ", $hunter->name, " : ", $hunter->health, " ", $guardian->name, " : ", $guardian->health, " ", $infantryman->name, " : ", $infantryman->health, " ";



    //проверяем потери
    for ($i=0; $i<count($bandits); $i++)
    {
        if ($bandits[$i]->health <= 0)
        {
            $nm = $bandits[$i]->name;
            echo "$nm  повержен! </br>";
            unset($bandits[$i]);
        }
        else
        {
            $nm = $bandits[$i]->name;
            $heal = $bandits[$i]->health;
            echo "</br> $nm имеет $heal здоровья </br>";
        }
    };
    for ($i=0; $i<count($guard); $i++)
    {
        if ($guard[$i]->health <=0)
        {
            $nm = $guard[$i]->name;
            echo "$nm пал в бою! </br>";
            unset($guard[$i]);
        }
        else
        {
            $nm = $guard[$i]->name;
            $heal = $guard[$i]->health;
            echo "</br> $nm имеет $heal здоровья </br>";
        }
    };
};

if (($peasant->health<=0) && ($hunter->health<=0))
{
    echo "</br> </br> Стража победила! И Король наградил их! </br>";
    foreach($guard as $winner)
        $blessing->heal($winner);
}
else
{
    echo "</br> </br> Бандиты захватили власть в Королевстве!</br>";
    foreach($bandits as $winner)
        $blessing->heal($winner);
};
?>
