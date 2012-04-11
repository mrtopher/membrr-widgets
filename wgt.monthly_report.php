<?php

/**
 * Membrr Monthly Report Widget
 *
 * Display monthly report snapshot in widget format.
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Widget
 * @author		Chris Monnat
 * @link		http://chrismonnat.com
 */

class Wgt_monthly_report
{
	public $EE;
	public $title;
	public $wclass;
	public $settings;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE = get_instance();
	
		$this->title = 'Membrr Monthly Report';
	
		$this->wclass = 'contentMenu';
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @param	object
	 * @return 	string
	 */
	public function index()
	{
		// get monthly reports
		$result = $this->EE->db->query('SELECT COUNT(recurring_id) AS `new_subscriptions`, MONTH(date_created) AS `date_month`, YEAR(date_created) AS `date_year`
									    FROM `exp_membrr_subscriptions`
									    WHERE YEAR(date_created) > 0
									    GROUP BY YEAR(date_created), MONTH(date_created)
									    ORDER BY `date_created` DESC');
			
		$months = array();							    
		if($result->num_rows() > 0) 
		{
			foreach($result->result_array() as $month) 
			{
				$month['date_month'] = str_pad($month['date_month'], 2, '0', STR_PAD_LEFT);
				
				$months[$month['date_month'] . $month['date_year']] = array(
								'code' 				=> $month['date_month'] . $month['date_year'],
								'year' 				=> $month['date_year'],
								'month' 			=> date('F', strtotime('2011-' . $month['date_month'] . '-01 12:12:12')),
								'new_subscribers' 	=> $month['new_subscriptions'],
								'expirations' 		=> '0',
								'difference' 		=> '0',
								'url' 				=> $this->cp_url('index', array('month' => $month['date_month'] . $month['date_year']))
							);					
			}
		}		
		
		$result = $this->EE->db->query('SELECT COUNT(recurring_id) AS `expirations`, MONTH(end_date) AS `date_month`, YEAR(end_date) AS `date_year`
									    FROM `exp_membrr_subscriptions`
									    WHERE YEAR(end_date) > 0
									    GROUP BY YEAR(end_date), MONTH(end_date)
									    ORDER BY `end_date` DESC');					    
		
		if($result->num_rows() > 0) 
		{
			foreach($result->result_array() as $month) 
			{
				$month['date_month'] = str_pad($month['date_month'], 2, '0', STR_PAD_LEFT);
				
				if(isset($months[$month['date_month'] . $month['date_year']])) 
				{
					// we have a report for this, so we'll add this to it
					$months[$month['date_month'] . $month['date_year']]['expirations'] = $month['expirations'];
				}
			}
		}
		
		// calculate difference
		reset($months);
		
		foreach($months as $key => $month) 
		{
			$difference = $month['new_subscribers'] - $month['expirations'];
			if($difference > 0) 
			{
				$difference = '+' . $difference;
			}
			
			$months[$key]['difference'] = $difference;
		}
				
		// get specific monthly report
		reset($months);
		
		$display = '';
		if(count($months) > 0)
		{
			foreach($months as $month)
			{
				$display .= '
					<tr class="'.alternator('odd','even').'">
						<td><a href="'.$month['url'].'">'.$month['month'].', '.$month['year'].'</a></td>
						<td>'.$month['new_subscribers'].'</td>
						<td>'.$month['expirations'].'</td>
						<td>'.$month['difference'].'</td>
					</tr>';
	
			}
		}
		else
		{
			$display = '<tr><td colspan="3"><center>No data to report on.</center></td></tr>';
		}		
		
		return '
			<table>
				<thead><tr><th>Date</th><th>Subs</th><th>Exps</th><th>Diff</th></tr></thead>
				<tbody>'.$display.'</tbody>
			</table>
		';
	}
	
	/**
	 * CP URL
	 *
	 * Aids in generation of CP URLs.
	 *
	 * @param	string		$action
	 * @param	array		$variables
	 * @return	string
	 */
	private function cp_url ($action = 'index', $variables = array()) 
	{
		$url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp' . AMP . 'module=membrr'.AMP.'method=' . $action;
		
		foreach($variables as $variable => $value) 
		{
			$url .= AMP . $variable . '=' . $value;
		}
		
		return $url;
	}
	
}
/* End of file wgt.monthly_report.php */
/* Location: /system/expressionengine/third_party/membrr/widgets/wgt.monthly_report.php */