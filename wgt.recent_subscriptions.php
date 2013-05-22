<?php

/**
 * Membrr Recent Subscriptions Widget
 *
 * Display most recent 10 membrr subscriptions in widget format.
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Widget
 * @author		Chris Monnat
 * @link		http://chrismonnat.com
 */

class Wgt_recent_subscriptions
{
	public $widget_name 		= 'Membrr Recent Subscriptions';
	public $widget_description 	= 'Most recent Membrr subscriptions.';

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
	
		$this->title = 'Recent Subscriptions';
	
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
		require(PATH_THIRD.'membrr/class.membrr_ee.php');
		$membrr = new Membrr_EE;
	
		// get latest payments
		$subscriptions = $membrr->GetSubscriptions(0, 10, array());
		$display = '';
		
		if(is_array($subscriptions)) 
		{			
			reset($subscriptions);
			
			foreach($subscriptions as $sub)
			{
				$display .= '
					<tr class="'.alternator('odd','even').'">
						<td><a href="'.$this->cp_url('subscription', array('id' => $sub['id'])).'">'.$sub['id'].'</a></td>
						<td>'.$sub['plan_name'].'</td>
						<td>'.$sub['amount'].'</td>
					</tr>';
			}

		}
		else
		{
			$display = '<tr><td colspan="3"><center>No data to report on.</center></td></tr>';
		}

		return '
			<table>
				<thead><tr><th>Sub ID</th><th>Plan</th><th>Amount</th></tr></thead>
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
/* End of file wgt.recent_subscriptions.php */
/* Location: /system/expressionengine/third_party/membrr/widgets/wgt.recent_subscriptions.php */