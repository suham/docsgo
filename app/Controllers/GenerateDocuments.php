<?php namespace App\Controllers;

use App\Models\SettingsModel;
use CodeIgniter\I18n\Time;
use TP\Tools\Parsedown;
use TP\Tools\ParsedownExtra;
use App\Models\DocumentModel;
use PhpOffice\PhpWord\Shared\ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;


class GenerateDocuments extends BaseController
{
	
	public function index(){
		$this->downloadDocuments();
	}

	public function downloadDocuments()  {
		$Extra = new ParsedownExtra();
		$Extra->setSafeMode(true);
		$Extra->setMarkupEscaped(true);

		$params = $this->returnParams();
		if($params[0] == 1){
			$type = "document";
		}else{
			$type = "project";
		}
		$main_id = $params[1];

		$model = new DocumentModel();
		$str = $model->getDocumentsData($type, $main_id); 
		if(isset($str) && count($str) == 0) {
			$response = array('success' => "False", "description"=>"There is no documents to download", "serverPath"=>$_SERVER['DOCUMENT_ROOT'], "folderName"=>'');
			echo json_encode( $response );	
			return false;
		}
		function sectionNumber($sectionStr) {
			return (int) filter_var($sectionStr, FILTER_SANITIZE_NUMBER_INT);
		}

		function addTableStylesToContent($rawContent) {
			$fontFamily = 'Arial, sans-serif';
			$fontSize = '11';
			$replaceContent = str_replace("<table>", '<table style="border-spacing:0 10px; font-family:' . $fontFamily . '; font-size: ' . $fontSize . ';width: 100%; padding: 10px; border: 1px #000000 solid; border-collapse: collapse;" border="1" cellpadding="5">', $rawContent);
			$replaceContent = str_replace("<th>", "<th style='padding-top: 8px;font-weight: bold; height: 50px;text-align: left; background-color:#cbebf2;'>", $replaceContent);
			$replaceContent = str_replace("<td>", "<td style='padding-top: 8px;text-align: left;'>", $replaceContent);
			$replaceContent = str_replace("<br/>", " <br/> ", $replaceContent);
			return $replaceContent;
		}

		$jsonGetId = $str;
		
		$idArray = array_keys($jsonGetId);
		$count = 0;

		foreach ($idArray as $id) {
			$jsonMain = $str;
			$fileNameLev1 = str_replace(",", "_", $jsonMain[$id]['file-name'] . ".docx");
			$fileName = str_replace(" ", "_", $fileNameLev1);
			$jsonObj = json_decode($jsonMain[$id]['json-object'], true);
			$documentType = array_keys($jsonObj);
			$json = $jsonObj[$documentType[0]];

			// Creating the new document...
			$phpWord = new \PhpOffice\PhpWord\PhpWord();
			$phpWord->getSettings()->setUpdateFields(true);

			$section = $phpWord->addSection();

			$phpWord->addTitleStyle(1, array('name' => $json['section-font'], 'size' => $json['section-font-size'], 'bold' => TRUE));
			$phpWord->setDefaultParagraphStyle(
					array(
						'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
						'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
						'spacing' => 100,
					)
			);

			$multilevelNumberingStyleName = 'multilevel';
			$phpWord->addNumberingStyle(
					$multilevelNumberingStyleName, array(
				'type' => 'multilevel',
				'levels' => array(
					array('format' => 'decimal', 'text' => '%1.', 'left' => 500, 'hanging' => 360, 'tabPos' => 500),
					array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
				),
					)
			);
		
			//Header for all pages
			$subsequent = $section->addHeader();
			if (trim($json['cp-icon']) != "") {
				$subsequent->addImage($json['cp-icon'], array('width' => 110, 'height' => 50));
			} else {
				$subsequent->addImage('https://info.viosrdtest.in/assets/images/muRata.png', array('width' => 110, 'height' => 50));
			}
		
			//Footer for all pages
			$footer = $section->addFooter();
			$footer->addPreserveText('Murata Vios CONFIDENTIAL                              Page {PAGE} of {NUMPAGES}                             ' . $json['cp-line4'] . ' ' . $json['cp-line5'], null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));

			// Inline font style
			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = 14;
			$fontStyle['bold'] = TRUE;
			$section->addText($json['cp-line1'], $fontStyle, ['align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER]);
			$section->addText($json['cp-line2'], $fontStyle, ['align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER]);
			$section->addTextBreak();
			$section->addTextBreak();
			$cp_line3 = $json['cp-line3'];
			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = 14;
			$fontStyle['bold'] = TRUE;		
			$section->addText($json['cp-line3'], $fontStyle, ['align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER]);
			$section->addText($json['cp-line4'], $fontStyle, ['align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER]);
			$section->addText($json['cp-line5'], $fontStyle, ['align' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER]);
			$section->addTextBreak();

			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = $json['section-font-size'];
			$fontStyle['bold'] = TRUE;
			$section->addText('Approval Matrix', $fontStyle);

			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = $json['section-font-size'];
			$fontStyle['bold'] = FALSE;
			$section->addText($json['cp-approval-matrix'], $fontStyle);
			$section->addTextBreak();

			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = $json['section-font-size'];
			$fontStyle['bold'] = TRUE;
			$section->addText('Change History', $fontStyle);

			$fontStyle['name'] = $json['section-font'];
			$fontStyle['size'] = $json['section-font-size'];
			$fontStyle['bold'] = FALSE;

			$tableContent = $Extra->text($json['cp-change-history']);
			$tableContent = addTableStylesToContent($tableContent);
			\PhpOffice\PhpWord\Shared\Html::addHtml($section, $tableContent, FALSE, FALSE);

			$section->addTextBreak();

			$section = $phpWord->addSection();
			$fontStyle12 = array('spaceAfter' => 60, 'size' => $json['section-font']);
			$fontStyle10 = array('size' => 10);
			$phpWord->addTitleStyle(null, array('size' => $json['section-font'], 'bold' => true));
			$phpWord->addTitleStyle(1, array('size' => $json['section-font'], 'color' => '333333', 'bold' => true));
			$phpWord->addTitleStyle(2, array('size' => $json['section-font'], 'color' => '666666'));
			$phpWord->addTitleStyle(3, array('size' => $json['section-font'], 'italic' => true));
			$phpWord->addTitleStyle(4, array('size' => $json['section-font']));
			// Add text elements
			$section->addTitle('Table of contents', 0);
			$section->addTextBreak(2);

			// Add TOC #1
			$toc = $section->addTOC($fontStyle12);
			$section->addTextBreak(2);


			$section = $phpWord->addSection();

			for ($i = 0; $i < count($json['sections']); $i++) {
				$section->addTitle($i + 1 . ". " . $json['sections'][$i]['title']);
				$contentSection = '<b>sample data</b>';
				if($json['sections'][$i]['content'] != ''){
					$contentSection = $Extra->text(htmlspecialchars($json['sections'][$i]['content']));
				}
				if (strpos($contentSection, '<table>') !== false) {
					$tableContentFormatted = addTableStylesToContent($contentSection);
					\PhpOffice\PhpWord\Shared\Html::addHtml($section, $tableContentFormatted, FALSE, FALSE);
				} else {
					\PhpOffice\PhpWord\Shared\Html::addHtml($section, $contentSection, FALSE, FALSE);
				}
				
				$section->addTextBreak();
			}
			// Saving the document as OOXML file...
			\PhpOffice\PhpWord\Settings::setCompatibility(false);
			$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
			ob_clean();
			$count++;
			
			if ($type == "project") {
				$objWriter->save($fileName);
				$directoryName = "Project_Documents";
				if (!is_dir($directoryName)) {
					mkdir($directoryName, 0777);
				}
				rename($fileName, $directoryName . '/' . $fileName);
				if (count($idArray) == $count) {
					$zip_file = $directoryName .'_'.$main_id.'.zip';
					$rootPath = realpath($directoryName);
					// / Initiate a new instance of ZipArchive  
					$zip = new ZipArchive();  
					$res = $zip->open($zip_file, ZipArchive::CREATE);
					if ($zip->open($zip_file, ZipArchive::CREATE)) {
						$files = new RecursiveIteratorIterator(
							new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
						);
						foreach ($files as $name => $file) {
							if (!$file->isDir()) {
								$filePath = $file->getRealPath();
								$relativePath = substr($filePath, strlen($rootPath) + 1);
								$zip->addFile($filePath, $relativePath);
								$filesToDelete[] = $filePath;
							}
						}
						$zip->close();
						//removing the document files
						if (is_dir($directoryName)) {
							foreach ($filesToDelete as $file) {
								unlink($file);
							}
							rmdir($directoryName);
						}

						$response = array('success' => "True", "description"=>"Project files are downloaded", "serverPath"=>$_SERVER['DOCUMENT_ROOT'], "folderName"=>$zip_file);
						echo json_encode( $response );	
					}else{
						$response = array('success' => "False", ""=>"Unable to download the project files", "serverPath"=>$_SERVER['DOCUMENT_ROOT'], "folderName"=>$zip_file);
						echo json_encode( $response );	
					}
				}
			}else{
				$rootDirName = $_SERVER['DOCUMENT_ROOT'];
				$directoryName = "Project_Documents_".$str[0]['project-id'];		
				if (!is_dir($directoryName)) {
					mkdir($directoryName, 0777);
				}
				$objWriter->save($directoryName.'/'.$fileName);
				$response = array('success' => "True", "description"=>"File downloaded successfully", "serverPath"=>$_SERVER['DOCUMENT_ROOT'].'/'.$directoryName, "filePath"=>$fileName);
				echo json_encode( $response );	
			}
			
		}
	}

	private function returnParams(){
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);
		$type = $uri->getSegment(4);
		return [$id, $type];
	}

}