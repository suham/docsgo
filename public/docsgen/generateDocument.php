<?php

require_once '../../vendor/autoload.php';
require_once 'Parsedown.php';
require_once 'ParsedownExtra.php';

$Extra = new ParsedownExtra();
$Extra->setSafeMode(true);
$Extra->setMarkupEscaped(true);

$main_id = filter_input(INPUT_GET, 'id');
$type = filter_input(INPUT_GET, 'type');
$time = time();

if($type == "project"){
    $URL = 'https://info.viosrdtest.in/documents/getJson?type=project&id='.$main_id;
} else if($type == "document"){
    $URL = 'https://info.viosrdtest.in/documents/getJson?type=document&id='.$main_id;
} else {
    exit;
}

$str = file_get_contents($URL);
$lastIndex = strrpos($str, '}');
$str = substr($str, 0, $lastIndex + 1);

function sectionNumber($str) {
    return (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
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

$jsonGetId = json_decode($str, true);
if($jsonGetId == null){
    $response = array();
    $response["success"] = "False";
    echo json_encode($response);
    exit;
}
$idArray = array_keys($jsonGetId);
$count = 0;
foreach ($idArray as $id) {
    $jsonMain = json_decode($str, true);
    $fileName = str_replace(",","_",$jsonMain[$id]['file-name'] . ".docx");
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
        $contentSection = $Extra->text(htmlspecialchars($json['sections'][$i]['content']));
        if(strpos($contentSection, '<table>') !== false){
            $tableContentFormatted = addTableStylesToContent($contentSection);
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $tableContentFormatted, FALSE, FALSE);
        } else {
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $contentSection, FALSE, FALSE);
        }
        
//        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $Extra->text($json['sections'][$i]['content']));
        $section->addTextBreak();
    }
    // Saving the document as OOXML file...
    \PhpOffice\PhpWord\Settings::setCompatibility(false);
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    ob_clean();
//    flush();
    $objWriter->save($fileName);
    $count++;
    
    if ($type == "project") {
        $directoryName = "Documents_".$main_id;

        if (!is_dir($directoryName)) {
            mkdir($directoryName, 0777);
        }
        rename($fileName, $directoryName . '/' . $fileName);
        if (count($idArray) == $count) {
            $zip_file = $directoryName . '.zip';
            $rootPath = realpath($directoryName);
            $zip = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            $filesToDelete = array();
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

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($zip_file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zip_file));
            flush();
//            readfile($zip_file);
            if (is_dir($directoryName)) {
                foreach ($filesToDelete as $file) {
                    unlink($file);
                }
                rmdir($directoryName);
                unlink($zip_file);
            }
            exit;
        }
    } else {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $fileName);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        flush();
//        readfile($fileName);
        unlink($fileName);
        exit;
    }
}