<?php

class Greeting {

    /**
     * Returns a Greeting according to the time of the day/night
     *
     * @param bool $forceLunchGreet
     * @return string
     */
    public static function greet($forceLunchGreet){
        
        $currentHour = (int)date('H');
        $goodMorning = $currentHour >= 5 && $currentHour < 13;
        $goodAfternoon = $currentHour >= 13 && $currentHour <= 18;

        // TODO: String translation
        $greet =  $goodMorning ? 'Bom dia' : ($goodAfternoon ? 'Boa tarde' : 'Boa noite');

        if($forceLunchGreet){
            $greet = 'Bom almoço, Até já';
        }

        return $greet;
    }
}