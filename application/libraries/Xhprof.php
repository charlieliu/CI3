<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* @author liuchangli0107@gmail.com
 */
class CI_Xhprof {
	private $_ci;
	private $XHProfPath = 'xhprof/';
	private $applicationName = 'my_application';
	private $sampleSize = 1;
	private static $enabled = false;

	public function __construct()
	{
		$this->_ci = get_instance();
	}

	public function XHProf_Start() {
		if (mt_rand(1, $this->sampleSize) == 1) {
			include_once $this->XHProfPath . 'xhprof_lib/utils/xhprof_lib.php';
			include_once $this->XHProfPath . 'xhprof_lib/utils/xhprof_runs.php';
			xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);

			self::$enabled = true;
		}
	}

	public function XHProf_End($set_name=null, $remark_str='')
	{
		$run_id = '' ;
		$this->applicationName = is_null($set_name) ? $this->applicationName : $set_name ;
		if (self::$enabled) {
			$XHProfData = xhprof_disable();

			$XHProfRuns = new XHProfRuns_Default();
			$run_id = $XHProfRuns->save_run($XHProfData, $this->applicationName);
		}
		$this->_ci->load->model('xhprof_model','',TRUE);
		$add_log = $this->_ci->xhprof_model->query_log($run_id, $set_name, $remark_str) ;
		if( $add_log['status']!='100' )
		{
			var_dump($add_log) ;
			exit('CLASS:'.__CLASS__.' FUNCTION:'.__FUNCTION__.' LINE:'.__LINE__);
		}
		return $run_id ;
	}
}
?>