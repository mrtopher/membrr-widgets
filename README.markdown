# Membrr Widgets for dashEE

If you use the [dashEE ExpressionEngine module](https://github.com/mrtopher/dashEE) and sell membership subscriptions using [Membrr](http://membrr.com) then these widgets are for you:

*   Monthly Report - shows number of subscriptions and expirations per month.
*   Recent Subscriptions - shows 10 most recent subscriptions.
*   Curent Month Statistics - Shows number of new subscribers, expirations, cancellations, payments and revenue for current month.

## Installation

These widgets were written and tested using Membrr 1.70. If you experience any problems please ensure you are using Membrr version 1.70 or greater.

1.  Create a folder named "widgets" in /system/expressionengine/third_party/membrr.

2.  Upload selected widget files to the new widgets folder within the module directory.

3.  Update the membrr language file located in the language/eng directory of the module by adding the following lines:
`'wgt_monthly_report_name' => 'Membrr Monthly Report',`
`'wgt_monthly_report_description' => 'Monthly report snapshot as on module CP homepage.',`
`'wgt_recent_subscriptions_name' => 'Membrr Recent Subscriptions',`
`'wgt_recent_subscriptions_description' => 'Most recent Membrr subscriptions.',`
`'wgt_this_month_name' => 'Membrr Current Month Stats',`
`'wgt_this_month_description' => 'Shows current month subscriptions, expirations, cancellations and revenue.',`

That's it. When you click the Widgets button from the dashboard you should now see the widgets listed for installation.

## Updating

When updating the widget it is recommended that you first remove the widget from your dashboard, upload the updated widget file and then re-add the widget. If you don't do things in this order you may experience unexpected results. One remedy may be to remove and re-add the widget once the updated file has been uploaded.