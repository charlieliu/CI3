<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* third_party/PHPExcel.php and third_party/PHPExcel copy from https://github.com/PHPOffice/PHPExcel */
require_once APPPATH."/third_party/PHPExcel.php";
require_once APPPATH."/third_party/PHPExcel/IOFactory.php";
require_once APPPATH."/third_party/PHPExcel/Cell.php";
require_once APPPATH."/third_party/PHPExcel/Writer/Excel2007.php";
require_once APPPATH."/third_party/PHPExcel/CachedObjectStorageFactory.php";
require_once APPPATH."/third_party/PHPExcel/Settings.php";


class Excel extends PHPExcel {

	public function __construct($params=null)
	{
		if( !is_null($params) )
		{
			$memoryCacheSize = empty($params['memoryCacheSize']) ? '1'  : $params['memoryCacheSize'] ;
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings =array('memoryCacheSize'=>$memoryCacheSize.'MB',) ;
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings) ;
		}
		parent::__construct();
	}

	public function xls2Array($file,$skip_empty=TRUE)
	{
		$rtnAry = array();
		$objReader = PHPExcel_IOFactory::createReaderForFile($file) ;
		$objReader->setReadDateOnly(TRUE) ;

		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->setActiveSheet();

		foreach ($objWorksheet->getRowIterator() as $row)
		{
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE) ;
			unset($tmpAry) ;
			foreach ($cellIterator as $cell)
			{
				$v = $cell->getFormattedValue() ;
				$v = trim($v) ;
				$tmpAry[] = $v ;
			}
			if( $skip_empty )
			{
				// remove repeat value in the row
				$chk_ary = array_unique($tmpAry) ;
				// check array's value
				if( count($chk_ary)==1 && $chk_ary[0]=='' )
				{
					// remove empty  row
				}
				else
				{
					$rtnAry[] = $tmpAry ;
				}
			}
			else
			{
				// default
				$rtnAry[] = $tmpAry ;
			}
		}
		return $rtnAry ;
	}


	public function Array2xls($arr=array(),$title='')
	{
		if( !empty($arr) && is_array($arr) )
		{
			// set Sheet Index
			$this->setActiveSheetIndex(0) ;
			// set font
			$this->getActiveSheet()->getDefaultStyle()->getFont()->setName('新細明體') ;
			// set default width
			$this->getActiveSheet()->getDefaultColumnDimension()->setWidth(12) ;
			// set A1's style for title
			// set A1 center
			$this->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ;
			// set A1 font size
			$this->getActiveSheet()->getStyle('A1')->getFont()->setSize(16) ;
			// set A1 bold font
			$this->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE) ;
			// set row 1 height
			$this->getActiveSheet()->getRowDimension('1')->setRowHeight(24) ;
			// set A1 value
			$this->getActiveSheet()->setCellValue('A1',$title) ;

			$max_col = 1 ;
			$row_num = 1 ;
			foreach ($arr as $row)
			{
				$row_num++ ;
				$col_num = 0 ;
				// set row height
				$this->getActiveSheet()->getRowDimension($row_num)->setRowHeight(16);
				foreach ($row as $val)
				{
					$col_num++ ;
					$col_str = $this->num2apha($col_num).$row_num ;
					// set col value
					$this->getActiveSheet()->setCellValue($col_str,(string)$val) ;
					// check how much column used
					$max_col = $col_num>$max_col ? $col_num : $max_col ;
				}
			}
			// merge column for A1(title)
			$this->getActiveSheet()->mergeCells('A1:'.$this->num2apha($max_col).'1') ;
			// set value type text
			for ($i=2; $i<=$max_col ; $i++)
			{
				$col_str = $this->num2apha($i);
				$this->getActiveSheet()->getStyle($col_str)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT) ;
			}
			// set A2 bold font
			$this->getActiveSheet()->getStyle('A2:'.$col_str.'2')->getFont()->setBold(TRUE) ;
			// create xls' name
			$filename = $title.date('YmdHis').'.xls' ;

			ob_end_clean() ;
			header('Content-Transfer-Encoding: binary') ;
			header('Content-Type: application/vnd.ms-excel; name='.$filename) ;// for IE & Opera
			header('Content-Type: application/octet-stream; name='.$filename) ;// for others
			header('Content-Disposition: attachment; filename='.$filename) ;
			// no cache
			header('Cache-Control: max-age=0') ;

			$objWriter = new PHPExcel_Writer_Excel5($this, 'Excel5') ;
			//$objWriter = PHPExcel_IOFactory::createWriter($this, 'Excel5');
			$objWriter->save('php://output') ;
		}
	}

	public function num2apha($num=0)
	{
		$num = intval($num) ;
		$output = '' ;
		if( $num>0 )
		{
			$apha = array(
				0 => 'Z',1 => 'A',2 => 'B',3 => 'C',4 => 'D',5 => 'E',6 => 'F',7 => 'G',8 => 'H',9 => 'I',
				10 => 'J',11 => 'K',12 => 'L',13 => 'M',14 => 'N',15 => 'O',16 => 'P',17 => 'Q',18 => 'R',19 => 'S',
				20 => 'T',21 => 'U',22 => 'V',23 => 'W',24 => 'X',25 => 'Y',
			);
			do{
				$num2str = $num%26 ;
				$str = $apha[$num2str] ;
				$output = $str.$output ;
				$num = floor($num/26) ;
			}while( $num>0 );
		}
		return $output ;
	}
}
?>