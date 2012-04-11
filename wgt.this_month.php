<?php

/**
 * Membrr Current Month Report Widget
 *
 * Display monthly report snapshot in widget format.
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Widget
 * @author		Chris Monnat
 * @link		http://chrismonnat.com
 */

class Wgt_this_month
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
	
		$this->title = date('F') . ' Membrr Stats';
	
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
		$current_year = date('Y');
		$current_month = date('m');
		
		$result = $this->EE->db->query('SELECT COUNT(recurring_id) AS `new_subscriptions`
									    FROM `exp_membrr_subscriptions`
									    WHERE YEAR(date_created) = \'' . $current_year . '\' and MONTH(date_created) = \'' . $current_month . '\'');
		
		$display = '<tr><td>New Subscribers:</td><td>'.$result->row()->new_subscriptions.'</td></tr>';
		
		$result = $this->EE->db->query('SELECT COUNT(recurring_id) AS `expirations`
									    FROM `exp_membrr_subscriptions`
									    WHERE YEAR(end_date) = \'' . $current_year . '\' and MONTH(end_date) = \'' . $current_month . '\'');
		
		$display .= '<tr><td>Expirations:</td><td>'.$result->row()->expirations.'</td></tr>';
		
		$result = $this->EE->db->query('SELECT COUNT(recurring_id) AS `cancellations`
									    FROM `exp_membrr_subscriptions`
									    WHERE YEAR(date_cancelled) = \'' . $current_year . '\' and MONTH(date_cancelled) = \'' . $current_month . '\'');
		
		$display .= '<tr><td>Cancellations:</td><td>'.$result->row()->cancellations.'</td></tr>';
		
		$result = $this->EE->db->query('SELECT COUNT(payment_id) AS `payments`
									    FROM `exp_membrr_payments`
									    WHERE YEAR(date) = \'' . $current_year . '\' and MONTH(date) = \'' . $current_month . '\'');
		
		$display .= '<tr><td>Payments:</td><td>'.$result->row()->payments.'</td></tr>';
		
		$result = $this->EE->db->query('SELECT SUM(amount) AS `revenue`
									    FROM `exp_membrr_payments`
									    WHERE YEAR(date) = \'' . $current_year . '\' and MONTH(date) = \'' . $current_month . '\'');
		
		$display .= '<tr><td>Revenue:</td><td>'.$result->row()->revenue.'</td></tr>';
		
		return '
			<table>
				<tbody>'.$display.'</tbody>
			</table>
		';
	}
	
}
/* End of file wgt.this_month.php */
/* Location: /system/expressionengine/third_party/membrr/widgets/wgt.this_month.php */