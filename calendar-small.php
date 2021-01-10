/*
 * php code used for "Events Manager" Wordpress Plugin
 * @link https://wordpress.org/plugins/events-manager/
 * @link http://wp-events-plugin.com/documentation/using-template-files/
 * 
 * Currently (2021-01-08) there is a bug which displayes the wrong month name in the small celander widget
 * you will need to override the wdiget template and add some code and change one line of code
 */
 
 
 <?php

/*

 * This file contains the HTML generated for small calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.

 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.

 * There are two variables made available to you:

 */

/* @var array $calendar - contains an array of information regarding the calendar and is used to generate the content */

/* @var array $args - the arguments passed to EM_Calendar::output() */


/*************************creating a couple new variables with the proper month/year *****************************/
//fixing the month name without modifying any outside values
//quick array of names
$month_name = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
//get this months name first
$the_month = date('n');
//if the user has clicked the widget and changed the month we need to grab that
if(isset($_REQUEST['mo']))
{
	$the_month = intval($_REQUEST['mo']);
}
//apply the selection
$month_output = $month_name[$the_month];

//do a similar set of actions for the year
$year_output = date('Y');
if(isset($_REQUEST['yr']))
{
	$year_output = intval($_REQUEST['yr']);
}
/**********************back to the standard template ****************************/


$EM_DateTime = new EM_DateTime($calendar['month_start']);

?>

<table class="em-calendar">

	<thead>

		<tr>

			<td><a class="em-calnav em-calnav-prev" href="<?php echo esc_url($calendar['links']['previous_url']); ?>" rel="nofollow">&lt;&lt;</a></td>

<?php /**************************** edit the line below to output the new values we created earlier ***************************************/ ?>
			<td class="month_name" colspan="5"><?php echo( $month_output . ' ' . $year_output); ?></td>
<?php /**************************** no further edits needed *******************************************************************************/ ?>

			<td><a class="em-calnav em-calnav-next" href="<?php echo esc_url($calendar['links']['next_url']); ?>" rel="nofollow">&gt;&gt;</a></td>

		</tr>

	</thead>

	<tbody>

		<tr class="days-names">

			<td><?php echo implode('</td><td>',$calendar['row_headers']); ?></td>

		</tr>

		<tr>

			<?php

			$cal_count = count($calendar['cells']);

			$col_count = $count = 1; //this counts collumns in the $calendar_array['cells'] array

			$col_max = count($calendar['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers

			foreach($calendar['cells'] as $date => $cell_data ){

				$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'eventful':'eventless';

				if(!empty($cell_data['type'])){

					$class .= "-".$cell_data['type'];

				}

				?>

				<td class="<?php echo esc_attr($class); ?>">

					<?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>

					<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>"><?php echo esc_html(date('j',$cell_data['date'])); ?></a>

					<?php else:?>

					<?php echo esc_html(date('j',$cell_data['date'])); ?>

					<?php endif; ?>

				</td>

				<?php

				//create a new row once we reach the end of a table collumn

				$col_count= ($col_count == $col_max ) ? 1 : $col_count+1;

				echo ($col_count == 1 && $count < $cal_count) ? '</tr><tr>':'';

				$count ++;

			}

			?>

		</tr>

	</tbody>

</table>
