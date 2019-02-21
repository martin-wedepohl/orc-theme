<?php 
/*
 * This file contains the HTML generated for full calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.
 * 
 * There are two variables made available to you: 
 * 
 * 	$calendar - contains an array of information regarding the calendar and is used to generate the content
 *  $args - the arguments passed to EM_Calendar::output()
 * 
 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.
 */

// Calculate back one month and forward 1 year
$today     = time();
$lastmonth = strtotime('-1 month', $today);
$nextyear  = strtotime('+1 year',  $today);

// Hide links if too much in the past or too much in the future
$displayPrev = ($calendar['month_start'] < $lastmonth) ? false : true;
$displayNext = ($calendar['month_start'] > $nextyear)  ? false : true;

$lastMonth    = date('F', mktime(12, 0, 0, $calendar['month_last'], 15, $calendar['year_last']));
$nextMonth    = date('F', mktime(12, 0, 0, $calendar['month_next'], 15, $calendar['year_next']));
?>
<table class="em-calendar fullcalendar">
	<thead>
		<tr>
            <?php if($displayPrev) { ?>
			<td class="transparent-right"><a class="em-calnav full-link em-calnav-prev" href="<?php echo esc_url($calendar['links']['previous_url']); ?>">&lt;&lt; <?php echo $lastMonth; ?></a></td>
            <?php } else { ?>
			<td class="transparent-right"></td>
            <?php } ?>
			<td class="month_name transparent-left transparent-right"><?php echo esc_html(date_i18n(get_option('dbem_full_calendar_month_format'), $calendar['month_start'])); ?></td>
            <?php if($displayNext) { ?>
			<td class="transparent-left align-right"><a class="em-calnav full-link em-calnav-next" href="<?php echo esc_url($calendar['links']['next_url']); ?>"> <?php echo $nextMonth; ?> &gt;&gt;</a></td>
            <?php } else { ?>
			<td class="transparent-left"></td>
            <?php } ?>
		</tr>
	</thead>
	<tbody>
			<?php
			foreach($calendar['cells'] as $date => $cell_data ){
				//In some cases (particularly when long events are set to show here) long events and all day events are not shown in the right order. In these cases, 
				//if you want to sort events cronologically on each day, including all day events at top and long events within the right times, add define('EM_CALENDAR_SORTTIME', true); to your wp-config.php file 
				if( defined('EM_CALENDAR_SORTTIME') && EM_CALENDAR_SORTTIME ) ksort($cell_data['events']); //indexes are timestamps
				?>
                <?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>
                <?php
                    $output = EM_Events::output($cell_data['events'],array('format'=>get_option('dbem_full_calendar_event_format')));
                    $found_display_none = strpos($output, 'display:none;');
                    $class = (false === $found_display_none) ? '' : 'style="display:none;"';
                ?>
		<tr <?php echo $class; ?>>
            <td><?php echo esc_html(date('l, F jS',$cell_data['date'])); ?></td>
            <td colspan="2">
                <ul>
                    <?php echo EM_Events::output($cell_data['events'],array('format'=>get_option('dbem_full_calendar_event_format'))); ?>
                    <?php if( $args['limit'] && $cell_data['events_count'] > $args['limit'] && get_option('dbem_display_calendar_events_limit_msg') != '' ): ?>
                    <li><a href="<?php echo esc_url($cell_data['link']); ?>"><?php echo get_option('dbem_display_calendar_events_limit_msg'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </td>
        </tr>
                <?php endif; ?>
				<?php
			}
			?>
		</tr>
	</tbody>
</table>