<?php

require_once '../../vendor/autoload.php';
require_once 'Parsedown.php';
require_once 'ParsedownExtra.php';

$Extra = new ParsedownExtra();
$Extra->setSafeMode(true);
$Extra->setMarkupEscaped(true);

$id = filter_input(INPUT_GET, 'id');
$type = filter_input(INPUT_GET, 'type');

if($type == "project"){
    $URL = 'http://localhost/documents/getJson?type=project&id='.$id;
} else if($type == "document"){
    $URL = 'http://localhost/documents/getJson?type=document&id='.$id;
} else {
    exit;
}
echo $URL;
$str = file_get_contents($URL);
$lastIndex = strrpos($str, '}');
$str = substr($str, 0, $lastIndex + 1);

$time = time();

function sectionNumber($str) {
    return (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
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
//    $projectVersion = $jsonMain[$id]['project-version'];
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

    $fancyTableStyleName = 'Fancy Table';
    $fancyTableStyle = array('borderSize' => 6, 'cellMargin' => 20, 'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED);
    $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'name' => 'Arial', 'bgColor' => '989b9c');
    $fancyTableCellStyle = array('valign' => 'center');
    $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
    $fancyTableFontStyle = array('bold' => true, 'size' => 11, 'name' => 'Arial');
    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);

//Header for all pages
    $subsequent = $section->addHeader();
    if (trim($json['cp-icon']) != "") {
        $subsequent->addImage($json['cp-icon'], array('width' => 110, 'height' => 50));
    } else {
        $subsequent->addImage('../assets/images/muRata.png', array('width' => 110, 'height' => 50));
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
//$section = $phpWord->addSection();
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $Extra->text($json['cp-change-history']));

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
        $section->addTitle($i + 1 . ".0 " . $json['sections'][$i]['title']);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $Extra->text(htmlspecialchars($json['sections'][$i]['content'])));
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
        $directoryName = "Documents_".$time;

        if (!is_dir($directoryName)) {
            mkdir($directoryName, 0666);
        }
        rename($fileName, $directoryName . '/' . $fileName);
        if (count($idArray) == $count) {
            $zip_file = $directoryName . '.zip';
            // Get real path for our folder
            $rootPath = realpath($directoryName);

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            $zip->close();

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($zip_file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zip_file));
            readfile($zip_file);
            unlink($zip_file);
            if (is_dir($directoryName)) {
                $this->rmrf("$directoryName/*");
                rmdir($directoryName);
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
        readfile($fileName);
        unlink($fileName);
        exit;
    }
}


