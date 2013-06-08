<?php
require_once(dirname(__FILE__)."/../../../dhtmlx/connector/grid_connector.php");
require_once(dirname(__FILE__)."/../../../dhtmlx/connector/scheduler_connector.php");
require_once(dirname(__FILE__)."/../../../dhtmlx/connector/db_phpyii.php");

class EventController extends Controller
{
	public function actionGrid()
	{
		$this->render('grid');
	}

	public function actionGrid_data()
	{
		$grid = new GridConnector(Events::model(), "PHPYii");
		$grid->configure("-", "event_id", "start_date, end_date, event_name");
		$grid->render();
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionScheduler()
	{
		$this->render('scheduler');
	}

	public function actionScheduler_data()
	{
		$scheduler = new SchedulerConnector(Events::model(), "PHPYii");
		$scheduler->enable_log("text.log");
		$scheduler->configure("-", "event_id", "start_date, end_date, event_name");
		$scheduler->render();
	}
}