<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\Util;


use PHPExcel_Cell;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;

class ExcelTable
{
	/**
	 * @var \PHPExcel;
	 */
	protected $phpExcel;
	/**
	 * @var \PHPExcel_Worksheet
	 */
	protected $sheet;

	protected $fileName;

	protected $currentColumn;
	protected $currentRow;

	public function __construct($title = 'output', $author = '')
	{
		$this->phpExcel = new \PHPExcel();
		$this->phpExcel->getProperties()
		               ->setCreator($author)
		               ->setTitle($title);
		$this->phpExcel->setActiveSheetIndex(0);

		$this->sheet = $this->phpExcel->getActiveSheet();

		// default style
		$this->setDefaultStyle();

		$this->fileName = preg_replace('/[^A-Za-z]+/', '_', $title);

		$this->resetRow();
		$this->resetColumn();
	}

	public function addRow(array $cells)
	{
		foreach ($cells as $cell)
		{
			$this->addCell($cell);
		}
		$this->incrementRow();
		$this->resetColumn();
	}

	public function addCell($value)
	{
		$this->sheet->setCellValueByColumnAndRow($this->currentColumn, $this->currentRow, $value);

		// style
		$this->setCurrentCellStyle();

		$this->incrementColumn();
	}

	public function output()
	{
		$this->setStyleBeforeOutput();

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=\"{$this->fileName}\".xslx");
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Cache-Control: cache, must-revalidate');
		header('Pragma: public');

		$objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
		$objWriter->save('php://output');
		die();
	}

	protected function incrementRow()
	{
		$this->currentRow++;
	}

	protected function incrementColumn()
	{
		$this->currentColumn++;
	}

	protected function resetRow()
	{
		$this->currentRow = 1;
	}

	protected function resetColumn()
	{
		$this->currentColumn = 0;
	}

	//
	// STYLE
	//
	protected function setDefaultStyle()
	{
		$this->sheet->getDefaultRowDimension()->setRowHeight(-1);
		$this->phpExcel->getDefaultStyle()
		               ->getAlignment()
		               ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}

	protected function setCurrentCellStyle()
	{
		$style = $this->sheet->getStyleByColumnAndRow($this->currentColumn, $this->currentRow);

		// header
		if ($this->currentRow === 1)
		{
			// background
			$style->getFill()
			      ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			      ->setStartColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_BLACK));

			// font color
			$style->getFont()->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_WHITE));
		}

		// borders
		$borders = $style->getBorders();
		$borders->getTop()
		        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$borders->getBottom()
		        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$borders->getLeft()
		        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$borders->getRight()
		        ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}

	protected function setStyleBeforeOutput()
	{
		// wuto width
		$cellIterator = $this->sheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		/** @var PHPExcel_Cell $cell */
		foreach ($cellIterator as $cell)
		{
			$this->sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}
	}
}