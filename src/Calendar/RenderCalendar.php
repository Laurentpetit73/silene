<?php

namespace App\Calendar;

class RenderCalendar{

    private $year;
    private $startmonth;
    private $endmonth;
    private $data;
    private $endday = false;

    public function __construct(string $year , int $startmonth=0 , int $endmonth=12, array $data)
    {
        $this->year = $year;
        $this->startmonth = $startmonth;
        $this->endmonth = $endmonth;
        $this->data = $data;
    }

    private function createMonth($month)
    {
        
        return new Month($this->year,$month);
    }

    private function dayHtml($day)
    {
        ?>

        <div class="date <?= $day->getDayOfWeek() == "0" ? "dim":"" ?>" id="<?= $day->getDateKey()?>"> 
            <?php if( $day->getDayOfWeek() == "0"): ?>
                <div class="trait"></div>
            <?php endif; ?>
            <p class="nom-jour"><?= $day->getDayNameMin()?></p>
            <p class="num-jour"><?= $day->getDay() ?></p>
            <p class="nom-moi"><?= $day->getMonthNameMin() ?></p>
            </div>
        
        <?php
         
    }

    public function getClass($day)
    {
        if($this->endday == true && $day->getIsStart() == true){
            $class = 'background: linear-gradient(127deg, yellow 45%,rgba(0, 0, 255, 0) 45% 55%, yellow 55%);';
        }else if($this->endday == true){
            $class = 'background: linear-gradient(127deg, yellow 45%,rgba(0, 0, 255, 0) 45% 55%, #9fe1b4 55%);';
        }else if($day->getBooking() != null && $day->getIsStart() == true){
            $class = 'background: linear-gradient(127deg, #9fe1b4 45%,rgba(0, 0, 255, 0) 45% 55%, yellow 55%)';
        }else if($day->getBooking() != null){
            $class = 'background-color: yellow';
        }else{
            $class = 'background-color: #9fe1b4';
        }

        if($day->getIsEnd()){
            $this->endday = true;
        }else{
            $this->endday = false;
        }


        return $class;

    }


    public function render()
    {
        ?>
        <?php $nbday = count($this->data)  ?>
        <?php for($i = 0; $i < $nbday ; $i++): ?>
        <?php $day = $this->data[$i];
       
        $nextday = ($i==$nbday-1) ? $this->data[$i] : $this->data[$i + 1];
         ?>
        <?php if($day->getDay()=="01"): ?>
         <div class ="first-line">
         <?php $book[]='<div class ="book"><div class="color" id="'.$day->getDateKey().'-col"></div>' ?>

         <?= $this->dayHtml($day)?>
         <?php elseif(($day->getMonth() != $nextday->getMonth())||($i==$nbday-1)):?> 
        <?php $book[]='<div class="color" id="'.$day->getDateKey().'-col"></div></div>' ?>
        <?= $this->dayHtml($day)?>
        </div>
        <?=implode('',$book);?>
        <?php $book = array()?>
        
       
        
        <?php else:?> 
        <?= $this->dayHtml($day)?>
        <?php $book[]='<div class="color" id="'.$day->getDateKey().'-col" style="'.$this->getClass($day).'"></div>' ?>
        <?php endif;?>
        <?php endfor; ?>
        <?php

    }
}