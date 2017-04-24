<?php
$dataset = array(
    array('A', 'C', 'D'),
    array('B', 'C', 'E'),
    array('A', 'B', 'C', 'E'),
    array('B', 'E')
);

$dataAwal = array();
$dataAkhir = array();
proses($dataset, $dataAwal, $dataAkhir);
echo "Nilai Confidensi=50%";
echo "<br><br>";
for ($i = 0; $i < count($dataAwal); $i++) {
    if ($i == 0) {
        echo "<table border='0'>
            <tr>
                <td>";

        echo "
            <table border='1'>
                <tr>
                    <td>Kombinasi 1</td>
                    <td>Nilai</td>
                    ";
        foreach ($dataAwal[$i] as $key => $awal) {
            echo "
                <tr>
                    <td>" . $awal['items'] . "</td>
                    <td>" . $awal['nilai'] . '%</td>
                </tr>
                ';
        }
        echo "
            </table>
            ";
        echo '
        </td>
        <td>===></td>
        <td>';
        echo "
            <table border='1'>
                <tr>
                    <td>Kombinasi hasil 1</td>
                    <td>Nilai</td>
                    ";
        foreach ($dataAkhir[$i] as $key => $akhir) {
            echo "
                print_r(".$akhir['items'].");
                <tr>

                    <td>" . $akhir['items'] . "</td>
                    <td>" . $akhir['nilai'] . '%</td>
                </tr>
                ';
        }
        echo "
            </table>
            ";

        echo "
        </td>
    </tr>
</table>";
    } else {
        echo "<br><br>";
        echo "
<table border='0'>
    <tr>
        <td>";

        echo "
            <table border='1'>
                <tr>
                    <td>Kombinasi proses</td>
                    <td>Nilai</td>
                    ";
        foreach ($dataAwal[$i] as $key => $awal) {
            $item = "";
            foreach ($awal['items'] as $key => $value) {
                $item .= $value;
            }
            echo "
                <tr>
                    <td>" . $item . "</td>
                    <td>" . $awal['nilai'] . '%</td>
                </tr>
                ';
        }
        echo "
            </table>
            ";
        echo '
        </td>
        <td>===></td>
        <td>';
        echo "
            <table border='1'>
                <tr>
                    <td>Kombinasi proses hasil 2</td>
                    <td>Nilai</td>
                    ";
        foreach ($dataAkhir[$i] as $key => $akhir) {
            $item = "";
            foreach ($akhir['items'] as $key => $value) {
                $item .= $value;
            }
            echo "
                <tr>
                    <td>" . $item . "</td>
                    <td>" . $akhir['nilai'] . '%</td>
                </tr>
                ';
        }
        echo "
            </table>
            ";

        echo "
        </td>
    </tr>
</table>";
    }

}


function proses($dataset = array(), &$dataAwal = array(), &$dataAkhir = array(), $panjang = 1, $itemset = array())
{
    if (empty($itemset)) {
        $itemset = $dataset;
    }
    $items = array();
    if (count($itemset[0]) > 1) {
        foreach ($itemset as $value) {
            foreach ($value as $data) {
                if (!empty($items)) {
                    $status = true;
                    foreach ($items as $item) {
                        if ($data == $item) {
                            $status = false;
                        }
                    }
                    if ($status) {
                        $items[] = $data;
                    }
                } else {
                    $items[] = $data;
                }
            }
        }
    } else {
        $items = $itemset;

    }


    $new_itemset = array();

    $itemset = kombinasi($items, $panjang);

    $dataset_awal = array();
    $dataset_akhir = array();
    if (support($dataset, $itemset, $new_itemset, $dataset_awal, $dataset_akhir)) {
        array_push($dataAkhir, $dataset_akhir);
        array_push($dataAwal, $dataset_awal);
        return proses($dataset, $dataAwal, $dataAkhir, $panjang + 1, $new_itemset);

    } else {

        array_push($dataAwal, $dataset_awal);
        array_push($dataAkhir, $dataset_akhir);
    }

}


function support($dataset = array(), $itemset = array(), &$new_itemset = array(), &$dataset_awal = array(), &$dataset_akhir = array())
{
    $persen = 50;
    $jumlah = array();
    $status = false;
    if (empty($dataset) || empty($itemset)) {
        return false;
    } else {
        if (count($itemset[0]) > 1) {
            $jumlah = array();
            foreach ($itemset as $i => $items) {
                $jumlah[$i] = 0;
                foreach ($dataset as $data) {
                    $count_item = count($items);
                    if (count(array_intersect($data, $items)) == $count_item) {
                        $jumlah[$i]++;
                    }

                }
                $nilai = ($jumlah[$i] / count($dataset)) * 100;
                $awal = array(
                    'items' => $items,
                    'nilai' => $nilai
                );
                array_push($dataset_awal, $awal);
                if ($nilai >= $persen) {
                    $status = true;
                    array_push($new_itemset, $items);
                    $akhir = array(
                        'items' => $items,
                        'nilai' => $nilai
                    );
                    array_push($dataset_akhir, $akhir);
                }
            }

        } else {

            foreach ($itemset as $item) {
                $jumlah[$item] = 0;
                foreach ($dataset as $value) {
                    foreach ($value as $data) {
                        if ($item == $data) {
                            $jumlah[$item]++;
                        }
                    }
                }
            }
            foreach ($itemset as $item) {
                $nilai = (($jumlah[$item] / count($dataset)) * 100);
                $awal = array(
                    'items' => $item,
                    'nilai' => $nilai
                );
                array_push($dataset_awal, $awal);
                if ($nilai >= $persen) {
                    $status = true;
                    array_push($new_itemset, $item);
                    $akhir = array(
                        'items' => $item,
                        'nilai' => $nilai
                    );
                    array_push($dataset_akhir, $akhir);
                }
            }
        }


        if (count($new_itemset) > 1) {
            return true;
        } else {
            return false;
        }
    }
}


function kombinasi($items, $panjang, $arrData = array())
{
    sort($items);

    if (empty($arrData)) {
        $arrData = $items;
    }

    if ($panjang == 1) {
        return $arrData;
    }

    $dataset = array();
    if (count($arrData[0]) > 1) {
        foreach ($arrData as $key => $aData) {
            $indeks = count($aData) - 1;
            for ($i = 0; $i
            < count($items); $i++) {
                if ($aData[$indeks] == $items[$i]) {
                    for ($j = $i + 1; $j
                    < count($items); $j++) {
                        $temp = array();
                        foreach ($aData as $data) {
                            $temp[] = $data;
                        }
                        $temp[] = $items[$j];
                        array_push($dataset, $temp);
                    }
                }
            }
        }

    } else {
        for ($i = 0; $i
        < count($arrData) - 1; $i++) {
            for ($j = $i + 1; $j
            < count($arrData); $j++) {
                $temp = array();
                $temp[] = $arrData[$i];
                $temp[] = $arrData[$j];
                array_push($dataset, $temp);
            }
        }
    }

    return kombinasi($items, $panjang - 1, $dataset);
}

?>
