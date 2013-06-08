<table id="calendar">
    <thead>
        <tr class="month-year-row">
            <th class="previous-month"><?php echo CHtml::link('<<', $this->previousLink); ?></th>
            <th colspan="5"><h4><?php echo $this->monthName.', '.$this->year; ?><h4></th>
            <th class="next-month"><?php echo CHtml::link('>>', $this->nextLink); ?></th>
        </tr>
        <tr class="weekdays-row">
            <?php foreach(Yii::app()->locale->getWeekDayNames('narrow') as $weekDay): ?>
                <th><?php echo $weekDay; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php $daysStarted = false; $day = 1; ?>
        <?php for($i = 1; $i <= $this->daysInCurrentMonth+$this->firstDayOfTheWeek; $i++): ?>
            <?php if(!$daysStarted) $daysStarted = ($i == $this->firstDayOfTheWeek+1); ?>
            <td <?php if($day == $this->day){
                echo 'class="calendar-selected-day"';
                }else{
                echo 'class="calendar-no-selected-day"'; 
            }
            ?>>
             <?php if($daysStarted && $day <= $this->daysInCurrentMonth): ?>
                <table>
                <tr> <td colspan="2">    
                    <h4>
                    <?php 
                    //echo $this->year.$this->month.$day;
                    echo CHtml::link($day, $this->getDayLink($day));  ?></h4>
                </td>
                </tr>
                <tr>
                    <?php 
                    $fechaCuadro=$this->year."-".str_pad($this->month, 2, "0", STR_PAD_LEFT)."-".str_pad($day, 2, "0", STR_PAD_LEFT);
                    //echo $fechaCuadro;    
                    $instalaciones=Eventos::model()->getCantidadInstalaciones($fechaCuadro); ?>
                   <td><?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/world-link-icon.png', 'Instalaciones'); echo " ".$instalaciones?> </td>
                   <td><?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/computer-link-icon.png', 'Soportes');?> </td>     
                </tr>
                <tr>
                    <td colspan=2><?php echo $instalaciones=Eventos::model()->getCiudadesInstalaciones($fechaCuadro); $day++; ?></td>
                       
                </tr>    
               </table>
             <?php endif; ?>
                
            </td>
            <?php if($i % 7 == 0): ?>
                </tr><tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tr>
    </tbody>
</table>
