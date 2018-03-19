<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

$week_mon = "Monday";
$week_tue = "Tuesday";
$week_wed = "Wednesday";
$week_thu = "Thursday";
$week_fri = "Friday";
$week_sat = "Saturday";
$week_sun = "Sunday";

?>

           <table class="table">
               <thead>
                   <tr>
                       <th scope="col">Time</th>
                       <th scope="col">Monday</th>
                       <th scope="col">Tuesday</th>
                       <th scope="col">Wednesday</th>
                       <th scope="col">Thursday</th>
                       <th scope="col">Friday</th>
                       <th scope="col">Saturday</th>
                       <th scope="col">Sunday</th>
                   </tr>
               </thead>
               <tbody>
               <?php
                   for ($row = 0; $row < 24; $row++) {
                       echo "<tr>";
                       echo "<th scope='row'>" . ($row + 1);
                       for ($col = 0; $col < 7; $col++) {
                           echo "<td>";

                           echo "</td>";
                       }
                       echo "</tr>";
                   }
               ?>
               </tbody>
           </table>

            <!--
            <div id="calendar">
                <div class="cal-top">
                    <div class="cal-col cal-header">
                        <?php echo $week_mon; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_tue; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_wed; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_thu; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_fri; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_sat; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                    <div class="cal-col cal-header">
                        <?php echo $week_sun; ?>
                        <div class="cal-subheader">

                        </div>
                    </div>
                </div>
                <div class="cal-body">
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                    <div class="cal-col">

                    </div>
                </div>
            </div>
            -->