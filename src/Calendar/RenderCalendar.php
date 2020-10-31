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
        if($this->endday == true){
            $class = 'fin';
        }else if($day->getBooking() != null && $day->getIsStart() == true){
            $class = 'debut';
        }else if($day->getBooking() != null){
            $class = 'test';
        }else{
            $class = 'free';
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
         <?php $book[]='<div class ="book"><div class="free" id="'.$day->getDateKey().'-col"></div>' ?>

         <?= $this->dayHtml($day)?>
         <?php elseif(($day->getMonth() != $nextday->getMonth())||($i==$nbday-1)):?> 
        <?php $book[]='<div class="free" id="'.$day->getDateKey().'-col"></div></div>' ?>
        <?= $this->dayHtml($day)?>
        </div>
        <?=implode('',$book);?>
        <?php $book = array()?>
        
       
        
        <?php else:?> 
        <?= $this->dayHtml($day)?>
        <?php $book[]='<div class="'.$this->getClass($day).'" id="'.$day->getDateKey().'-col"></div>' ?>
        <?php endif;?>
        <?php endfor; ?>
        <?php

    }
}