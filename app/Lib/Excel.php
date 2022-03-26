<?php


namespace App\Lib;


use Exception;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Auth;

class Excel
{

//엑셀 insert 구문 생성
    /*
     * $val : 업로드 파일 정보
     * $table : 업로드 파일 정보가 저장될 테이블 명
     * $keyRowIndex : 칼럼명이 들어가있는 곳의 row 번호
     * */
    public static function upload($val, $table, $keyRowIndex = 1, $dataRowIndex = 2)
    {
        $dateTime = date('Y-m-d H:i:s');
        $target = storage_path('app/'.$val['path']);
        $sqlStr = '';
        $created_staff_code = Auth::user()->staff_code;

        // $objPHPExcel = new PHPExcel();

        try {
            // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
            $objReader = IOFactory::createReaderForFile($target);
            // 읽기전용으로 설정
            $objReader->setReadDataOnly(true);
            // 엑셀파일을 읽는다.
            $objExcel = $objReader->load($target);

            // 첫번째 시트를 선택
            $objExcel->setActiveSheetIndex(0);
            //실행된 시트 반환
            $objWorksheet = $objExcel->getActiveSheet();

            $sql_str = "INSERT INTO	".$table;
            $row_temp = '';
            foreach($objWorksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator(); //셀 호출
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $datetime = date('Y-m-d H:i:s');

                $rowIndex = $row->getRowIndex();

                // 제목행 앞의 행은 무시한다.
                if ($rowIndex < $keyRowIndex) {
                    continue;
                }

                // $keyRowIndex에 설정된 줄의 값을 불러와서 배열로 생성.
                if ($rowIndex == $keyRowIndex) {
                    $columnTitleArr = [];
                    foreach ($cellIterator as $cell) {
                        $column_index = $cell->getColumn();
                        $titleValue = str_replace("\n", '', trim($cell->getValue()));
                        if(!$titleValue) {
                            continue;
                        }

                        $columnTitleArr[$column_index] = $titleValue;// 각 row data 배열화

                    }
                    continue;
                }

                //실제 데이터 행 이전의 데이터는 무시
                if ($rowIndex < $dataRowIndex) {
                    continue;
                }

                $duplicate = '';

                foreach ($cellIterator as $cell) {
                    $column_index = $cell->getColumn();

                    if (!isset($columnTitleArr[$column_index])) {
                        continue;
                    }
                    $column_title = $columnTitleArr[$column_index];
                    $sheet[$rowIndex][$column_title] = $cell->getValue();// 각 row data 배열화
                    if ($column_title == 'id' && $sheet[$rowIndex][$column_title] == '') {
                        $sheet[$rowIndex][$column_title] = 'NULL';
                        continue;
                    }
                    $date_check = strpos($column_title, 'date');

                    if ($date_check !== false) {
                        $sheet[$rowIndex][$column_title] = NumberFormat::toFormattedString($sheet[$rowIndex][$column_title], 'YYYY-MM-DD');
                    }

                    $duplicate .= "$columnTitleArr[$column_index]=values(".$columnTitleArr[$column_index].")";

                    if (count($columnTitleArr) != count($sheet[$rowIndex])) {
                        $duplicate .= ",";
                    }
                }

                if(is_null($sheet[$rowIndex][$column_title])) {
                    //continue;
                }

                $row_temp .= "
                            (";

                $array_first = array_shift($sheet[$rowIndex]);

                $row_temp .= $array_first.',';
                $row_temp .= "'".implode("','", $sheet[$rowIndex])."'
                                , '".$datetime."'
                                , '".$created_staff_code."'
                            ),";
            }

            $row_temp = trim($row_temp,',');

            $sql_str .= "
                    (
                        ".implode(",", $columnTitleArr)."
                        , created_at, created_staff_code
                    ) VALUES ";

            $sql_str .= $row_temp;

            $sql_str .= " ON DUPLICATE KEY UPDATE
                            $duplicate
                            , created_at= '".$datetime."'
                            , created_staff_code= '".$created_staff_code."'
                        ";

            // 파일 삭제
            //unlink($target);
            Storage::delete($val['path']);

            if ($sql_str) {
                $status = true;
                $message = '등록 되었습니다.';
            } else {
                throw new Exception('엑셀 업로드 실패');
            }
        } catch (Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }

        return [
            'status'  => $status,
            'message' => $message,
            'data' => [
                'sqlStr' => $sql_str
            ]
        ];
    }

}
